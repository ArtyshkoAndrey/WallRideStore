<?php

namespace App\Http\Controllers\Auth;

use App\Models\Currency;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\View;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $cartService;

  /**
   * Create a new controller instance.
   *
   * @param CartService $cartService
   */
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
