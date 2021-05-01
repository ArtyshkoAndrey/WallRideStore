<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected string $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  /**
   * Replacing the page path
   * @return Application|Factory|View
   */
  public function showLoginForm()
  {
    return view('user.auth.login');
  }

  /**
   * Attempt to log the user into the application.
   *
   * @param Request $request
   * @return bool
   */
  protected function attemptLogin(Request $request): bool
  {
    return $this->guard()->attempt(
      $this->credentials($request), true
    );
  }
}
