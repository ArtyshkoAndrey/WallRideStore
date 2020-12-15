<?php

namespace App\Http\Controllers\Auth;

use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Notifications\UserCouponCodeNotification;
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
    parent::__construct($cartService);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
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
   * @return User
   */
  protected function create(array $data): User
  {
    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'notification' => isset($data['email_notifications']),
      'old_notification' => isset($data['email_notifications']),
      'password' => Hash::make($data['password']),
    ]);

    if ($user->notification) {
      $user->notify(new UserCouponCodeNotification($user));
    }
    return $user;
  }
}
