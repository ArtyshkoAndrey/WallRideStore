<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\ProductSku;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class CartController extends Controller
{
  protected $cartService;

  public function __construct(CartService $cartService)
  {
    parent::__construct($cartService);
  }

  public function index(Request $request)
  {
    $amount = 0;
    $priceAmount = 0;
    $address = [];
    $cartItems = [];
    if(Auth::check()) {
      $dataItems = $this->cartService->get();
      $amount = $dataItems['amount'];
      $priceAmount = $dataItems['priceAmount'];
      $cartItems = $dataItems['cartItems'];

      $address = $request->user()->address;

    } else {
      if(isset($_COOKIE["products"])) {
        $arr = explode(',',$_COOKIE["products"]);
        $productsSku = Product::getProducts($arr);
        $cartItems = [];
        $amount = count($arr);
        if ($arr[0] !== "") {
          foreach ($productsSku as $k => $productSku) {
            $id = (int)$productSku->id;
            $ch = false;
            $item = [];

            foreach ($cartItems as $key => $item) {
              if (($item['id'] === $productSku->id) && ($item['product_sku']->product->price === $productSku->product->price)) {
                $ch = true;
                $cartItems[$key]['amount'] = $item['amount'] + 1;
                $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
                break;
              }
            }
            if (!$ch) {
              $item['amount'] = 1;
              $item['id'] = $id;
              $item['product_sku'] = $productSku;
              $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
              array_push($cartItems, $item);
            }
          }
        }
      }
    }
    return view('cart.index', compact('cartItems','address', 'amount', 'priceAmount'));
  }

  public function add(AddCartRequest $request)
  {
    if(Auth::check()) {
      $this->cartService->add($request->input('sku_id'), $request->input('amount'));
      $dataItems = $this->cartService->get();
      $amount = $dataItems['amount'];
      $priceAmount = $dataItems['priceAmount'];
      $cartItems = $dataItems['cartItems'];
      return ['cartItems' => $cartItems, 'amount' => $amount, 'priceAmount' => $priceAmount, 'type' => 'auth'];
    } else {
        return ['type' => 'web'];
    }
  }

  public function getData(Request $request) {
    if(Auth::check()) {
      return ['type' => 'auth'];
    } else {
      $ids = $request->ids;
      $cartItems = [];
      $priceAmount = 0;
      $productsSku = Product::getProducts($ids);
      foreach ($productsSku as $k => $productSku) {

        $ch = false;
        foreach ($cartItems as $key => $item) {
          if (($item['id'] === $productSku->id) && ($item['product_sku']->product->price === $productSku->product->price)) {
            $ch = true;
            $cartItems[$key]['amount'] = $item['amount'] + 1;
            $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
            break;
          }
        }
        if (!$ch) {
          if (isset($productSku)) {
            $item = [];
            $item['amount'] = 1;
            $item['id'] = (int)$productSku->id;
            $item['product_sku'] = $productSku;
            if (isset($productSku->product)) {
              $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
              array_push($cartItems, $item);
            } else {
              unset($productsSku[$k]);
            }
          } else {
            unset($productsSku[$k]);
          }
        }
      }
      $amount = count($ids);
      return ['cartItems' => $cartItems, 'amount' => $amount, 'priceAmount' => $priceAmount, 'type' => 'web'];
    }
  }

  public function minus(Request $request)
  {
    if(Auth::check()) {
      $this->cartService->minusAmount($request->input('sku_id'), (int) $request->input('amount'));
      $dataItems = $this->cartService->get();
      $amount = $dataItems['amount'];
      $priceAmount = $dataItems['priceAmount'];
      $cartItems = $dataItems['cartItems'];

      return ['cartItems' => $cartItems, 'amount' => $amount, 'priceAmount' => $priceAmount];
    } else {
      $ids = explode(',',$_COOKIE["products"]);
      foreach ($ids as $key => $id) {
        if ((int) $id === (int) $request->sku_id) {
          if ($request->type === 'minus') {
            unset($ids[$key]);
            sort($ids);
            break;
          } else if ($request->type === 'pluses') {
            array_push($ids, $request->sku_id);
            break;
          }
        }
      }
      $cartItems = [];
      $priceAmount = 0;
      $productsSku = Product::getProducts($ids);
      foreach ($productsSku as $productSku) {
        $ch = false;
        $item = [];
        foreach ($cartItems as $key => $item) {
          if(($item['id'] === $productSku->id) && ($item['product_sku']->product->price === $productSku->product->price)) {
            $ch = true;
            $cartItems[$key]['amount'] = $item['amount'] + 1;
            $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
            break;
          }
        }
        if (!$ch) {
          $item['amount'] = 1;
          $item['id'] = $productSku->id;
          $item['product_sku'] = $productSku;
          $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
          array_push($cartItems, $item);
        }
      }
      return ['cartItems' => $cartItems, 'amount' => count($ids), 'priceAmount' => $priceAmount, 'ids' => implode(",", $ids) ];
    }

  }

  public function remove(ProductSku $sku, Request $request)
  {
    if(Auth::check()) {
      $this->cartService->remove($sku->id);
      return [];
    } else {
      $ids = explode(',',$_COOKIE["products"]);

      foreach ($ids as $key => $id) {
        if ((int) $id === (int) $sku->id) {
          unset($ids[$key]);
        }
      }
//      return implode(",", $ids);
//      setcookie("products", implode(",", $ids), time() + (3600 * 24 * 30), "/", request()->getHost());
      return ['ids' => implode(",", $ids)];
    }
  }
}
