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
    $cartItems = $this->cartService->get();
    $amount =$this->cartService->amount();
    $priceAmount = $this->cartService->priceAmount();
    $address = $request->user()->address;
//        TODO Серствать страницу корзины
    return view('cart.index', compact('cartItems','address', 'amount', 'priceAmount'));
  }

  public function add(AddCartRequest $request)
  {
    $this->cartService->add($request->input('sku_id'), $request->input('amount'));
    $cartItems = $this->cartService->get();
    $amount =$this->cartService->amount();
    $priceAmount = $this->cartService->priceAmount();

    return ['cartItems' => $cartItems, 'amount' => $amount, 'priceAmount' => $priceAmount];
  }

  public function minus(AddCartRequest $request)
  {
    $this->cartService->minusAmount($request->input('sku_id'), $request->input('amount'));
    $cartItems = $this->cartService->get();
    $amount =$this->cartService->amount();
    $priceAmount = $this->cartService->priceAmount();

    return ['cartItems' => $cartItems, 'amount' => $amount, 'priceAmount' => $priceAmount];

  }

  public function remove(ProductSku $sku, Request $request)
  {
    $this->cartService->remove($sku->id);

    return [];
  }
}
