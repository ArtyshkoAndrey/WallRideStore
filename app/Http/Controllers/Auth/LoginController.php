<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\UserAddress;
use App\Services\CartService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $cartService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CartService $cartService)
    {
      $this->middleware('guest')->except('logout');
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
