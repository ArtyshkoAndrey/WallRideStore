<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\UserAddress;
use App\Services\CartService;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  protected $cartService;

  public function __construct(CartService $cartService) {
      $this->middleware('guest');
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
