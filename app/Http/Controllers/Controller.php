<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\UserAddress;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\CartService;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $cartService;

  public function __construct(CartService $cartService) {
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) {
      $cartItems = [];
      if (Auth::check()) {
        $cartItems = $this->cartService->get();
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        if(isset($address)) {
          if (isset($adress->currency)) {
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
      return $next($request);
    });
  }

}
