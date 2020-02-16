<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\UserAddress;
use App\Services\CartService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ForgotPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset emails and
  | includes a trait which assists in sending these notifications from
  | your application to your users. Feel free to explore this trait.
  |
  */

  use SendsPasswordResetEmails;
  protected $cartService;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(CartService $cartService)
  {
    $this->middleware('guest');
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) {
      $cartItems = [];
      $priceAmount = 0;
      $amount = 0;
      if (Auth::guard('user')->check()) {
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
}
