<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{

  use ResetsPasswords;

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected string $redirectTo = RouteServiceProvider::HOME;

  /**
   * Replacing the page path
   *
   * @param Request $request
   * @param null $token
   * @return Application|Factory|View
   */
  public function showResetForm(Request $request, $token = null)
  {
    $email = $request->get('email');
    return view('user.auth.passwords.reset', compact('email', 'token'));
  }
}
