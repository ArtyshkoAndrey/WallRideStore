<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\UserAddress;
use App\Services\CartService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

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
      $priceAmount = 0;
      $amount = 0;
      if (Auth::check() && explode('/', $request->route()->getPrefix())[0] !== 'admin') {
        if(isset($_COOKIE["products"])) {
          if (count(explode(',', $_COOKIE["products"])) > 0) {
            $arr = explode(',', $_COOKIE["products"]);
            if ($arr[0] !== "") {
              foreach ($arr as $id) {
                $this->cartService->add((int) $id, 1);
              }
              setcookie("products", "", time() + (3600 * 24 * 30), "/", request()->getHost());
            }
          }
        }

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

  public function login(Request $request)
  {
    // validate the form data
    $this->validate($request, [
      'email' => 'required|email|exists:users,email',
      'password' => 'required|min:3'
    ]);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

      // if successful -> redirect forward
      return redirect()->intended('/');
    }

    // if unsuccessful -> redirect back
    return Redirect::back()
      ->withInput()
      ->withErrors(
        [
          'password' => 'Неверный пароль',
        ]
      );
  }
}
