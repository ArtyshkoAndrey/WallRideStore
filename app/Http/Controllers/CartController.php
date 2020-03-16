<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\ProductSku;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
  protected $cartService;

  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) {
      $cartItems = [];
      $priceAmount = 0;
      $amount = 0;
      if (Auth::check() && explode('/', $request->route()->getPrefix())[0] !== 'admin') {
        $cartItems = $this->cartService->get();
        $priceAmount = $this->cartService->priceAmount();
        $amount = $this->cartService->amount();
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        if(isset($address)) {
          if ($address->currency_id !== null) {
            $currencyGlobal = $address->currency;
          } else {
            $currency = Currency::find(1);
            $address->currency()->associate($currency);
            $address->save();
            $currencyGlobal = $address->currency;
          }
        } else {
          $currencyGlobal = Currency::find(1);
        }
      } else {
        $currencyGlobal = Currency::find(1);
      }
      View::share('currency', $currencyGlobal);
      View::share('cartItems', $cartItems);
      View::share('priceAmount', $priceAmount);
      View::share('amount', $amount);
      return $next($request);
    });
  }

  public function index(Request $request)
  {
    $amount = 0;
    $priceAmount = 0;
    $address = [];
    $cartItems = [];
    if(Auth::check()) {
      $cartItems = $this->cartService->get();
      $amount =$this->cartService->amount();
      $priceAmount = $this->cartService->priceAmount();
      $address = $request->user()->address;
    } else {
      if(isset($_COOKIE["products"])) {
        $arr = explode(',',$_COOKIE["products"]);
        $cartItems = [];
        $amount = count($arr);
        if ($arr[0] !== "") {
          foreach ($arr as $id) {
            $id = (int)$id;
            $ch = false;
            $item = [];

            $prs = ProductSku::with('product')->where('id', $id)->first();
            foreach ($cartItems as $key => $item) {
              if ($item['id'] === $id) {
                $ch = true;
                $cartItems[$key]['amount'] = $item['amount'] + 1;
                $priceAmount += $prs->product->price;
                break;
              }
            }
            if (!$ch) {
              $item['amount'] = 1;
              $item['id'] = $id;
              $item['productSku'] = $prs;
              $priceAmount += $prs->product->price;
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
      $cartItems = $this->cartService->get();
      $amount =$this->cartService->amount();
      $priceAmount = $this->cartService->priceAmount();
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
      $amount = 0;
      foreach ($ids as $id) {
        $id = (int)$id;
        $ch = false;
        $item = [];
        $prs = ProductSku::with('product')->where('id', $id)->first();
        foreach ($cartItems as $key => $item) {
          if ($item['product_sku']['id'] === $id) {
            $ch = true;
            $cartItems[$key]['amount'] = $item['amount'] + 1;
            $priceAmount += $prs->product->price;
            break;
          }
        }
        if (!$ch) {
          $item['amount'] = 1;
          $item['id'] = $id;
          $item['product_sku'] = $prs;
          $priceAmount += $prs->product->price;
          array_push($cartItems, $item);
        }
        $amount++;
      }
      return ['cartItems' => $cartItems, 'amount' => $amount, 'priceAmount' => $priceAmount, 'type' => 'web'];
    }
  }

  public function minus(Request $request)
  {
    if(Auth::check()) {
      $this->cartService->minusAmount($request->input('sku_id'), (int) $request->input('amount'));
      $cartItems = $this->cartService->get();
      $amount = $this->cartService->amount();
      $priceAmount = $this->cartService->priceAmount();

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
      foreach ($ids as $id) {
        $id = (int) $id;
        $ch = false;
        $item = [];
        $prs = ProductSku::with('product')->where('id', $id)->first();
        foreach ($cartItems as $key => $item) {
          if($item['product_sku']['id'] === $id) {
            $ch = true;
            $cartItems[$key]['amount'] = $item['amount'] + 1;
            $priceAmount += $prs->product->price;
            break;
          }
        }
        if (!$ch) {
          $item['amount'] = 1;
          $item['id'] = $id;
          $item['product_sku'] = $prs;
          $priceAmount += $prs->product->price;
          array_push($cartItems, $item);
        }
      }
//      return implode(",", $ids);
//      setcookie("products", implode(",", $ids), time() + (3600 * 24 * 30), "/", request()->getHost());
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
//      setcookie("products", implode(",", $ids), time() + (3600 * 24 * 30), "/", request()->getHost());
      return ['ids' => implode(",", $ids)];
    }
  }
}
