<?php

namespace App\Http\Middleware;

use App;
use App\Exceptions\RedirectWithErrorsException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @return mixed
   * @throws App\Exceptions\RedirectWithErrorsException
   */
  public function handle(Request $request, Closure $next)
  {
    if (Auth::check()) {
//    If logged in
      $user = User::find(auth()->id());
      if ($user->is_admin) {
//      If the properties are Admin
//      Localization fix
        App::setLocale('ru');
        return $next($request);
      }
    }

    throw new RedirectWithErrorsException(__('errors_redirect.auth.admin'));
  }
}
