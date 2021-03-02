<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CouponCodeUnavailableException;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\CouponCode;
use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use App\Services\ParserEmsService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ApiController extends Controller
{

  /**
   * Returns full data by currency id
   *
   * @param int $id
   * @return JsonResponse
   */
  public function currency(int $id): JsonResponse
  {
    $validate = Validator::make(
      ['id' => $id],
      ['id' => 'required|exists:currencies,id']
    );
    if ($validate->fails()) {
      return response()->json(['error' => $validate->errors()->first()], 500);
    }
    $currency = Currency::find($id);
    return response()->json($currency);
  }

  /**
   * Set if isset user new currency in profile. Return new currency
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function set_currency(Request $request): JsonResponse
  {
    $request->validate([
      'currency_id' => 'required|exists:currencies,id',
      'user_id' => 'present|int|exists:users,id|nullable'
    ]);

    $data = $request->all();
    $currency = Currency::find($data['currency_id']);

    if ($data['user_id'])
      User::find($data['user_id'])->update(['currency_id' => $data['currency_id']]);

    return response()->json($currency);
  }

  /**
   * Returns all products according to the given dimensions
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function products(Request $request): JsonResponse
  {
    $ids = $request->get('products_skuses_ids', []);
    $products = Product::with('photos', 'productSkuses.skus')->whereHas('productSkuses', function ($q) use ($ids) {
      $q->whereIn('id', $ids);
    })->get();

    return response()->json($products);
  }


  /**
   * Updates the cart in the database
   *
   * @param Request $request
   * @throws Exception
   */
  public function update_cart(Request $request)
  {
    $data = $request->all();

    CartItem::whereUserId($data['user_id'])->delete();
    foreach ($data['products_skuses'] as $ps) {
      $cartItem = new CartItem(['amount' => $ps['amount']]);
      $cartItem->user()->associate($data['user_id']);
      $cartItem->product_skus()->associate($ps['id']);
      $cartItem->save();
//      CartItem::create(['user_id' => $data['user_id'], 'product_sku_id' => $ps['id'], 'amount' => $ps['amount']]);
    }
  }

  /**
   * Products from the database basket
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function cart_items_auth(Request $request): JsonResponse
  {
    $cartItems = CartItem::whereUserId($request->get('user_id'))->get();
    return response()->json($cartItems);
  }

  /**
   * Checks coupon
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function coupon(Request $request): JsonResponse
  {

    $data = $request->all();

    if (!$record = CouponCode::where('code', $data['code'])->first()) {
      return response()->json(['error' => 'Данного купона не существует'], 403);
    }

    try {
      $record->checkAvailable();
    } catch (CouponCodeUnavailableException $e) {
      return response()->json(['error' => $e->getMessage()], 403);
    }

    $sale = 0;
    $sum = 0;
    foreach ($data['items'] as $item) {

      $countBrandsEnabled = $record
        ->brandsEnabled()
        ->count();
      $countProductsEnabled = $record
        ->productsEnabled()
        ->count();
      $countCategoriesEnabled = $record
        ->categoriesEnabled()
        ->count();

      $product = Product::find($item['id']);

      if ($record->disabled_other_sales && $product->on_sale) {
        continue;
      }

      if ($record->productsDisabled()->where('product_id', $product->id)->exists()) {
        continue;
      }
      if ($record->brandsDisabled()->where('brand_id', $product->brand)->exists()) {
        continue;
      }

      if ($record->categoriesDisabled()->where('category_id', $product->category)->exists()) {
        continue;
      }

      if ($countBrandsEnabled > 0) {
        if (!$record->brandsEnabled()->where('brand_id', $product->brand)->exists()) {
          continue;
        }
      }
      if ($countProductsEnabled > 0) {
        if (!$record->productsEnabled()->where('product_id', $product->id)->exists()) {
          continue;
        }
      }

      if ($countCategoriesEnabled > 0) {
        if (!$record->categoriesEnabled()->whereIn('category_id', $product->categories)->exists()) {
          continue;
        }
      }
      $sum += ($product->on_sale ? $product->price_sale : $product->price) * $item['item']['amount'];
    }

    if ($sum > 0) {
      if ($record->type === CouponCode::TYPE_FIXED) {
        if ($sum - $record->value < 1)
          $sale = $sum - 1;

        else
          $sale = $record->value;
      } elseif ($record->type = CouponCode::TYPE_PERCENT) {
        $sale = $sum / 100 * $record->value;
      }

      if ($sale > $record->max_amount) {
        $sale = $record->max_amount;
      }
    }

    return response()->json(['sale' => $sale]);
  }

  public function getCostEms(Request $request): JsonResponse
  {
    $request->validate([
      'post_code' => 'required',
      'country_code' => 'required',
      'weight' => 'required',
    ]);
    $data = $request->all();
    try {
      $emsService = new ParserEmsService($data['post_code'], $data['country_code'], $data['weight']);
      $price = $emsService->getPrice();
      return response()->json($price);
    } catch (Exception $exception) {
      return response()->json(__('errors_redirect.delivery.not_price'), 500);
    } catch (GuzzleException $e) {
      return response()->json(__('errors_redirect.delivery.error'), 500);
    }
  }
}
