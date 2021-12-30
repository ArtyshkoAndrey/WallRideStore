<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{

  use SendsPasswordResetEmails;

  /**
   * Replacing the page path
   * @return Application|Factory|View
   */
  public function showLinkRequestForm()
  {
    return view('user.auth.passwords.email');
  }
}
