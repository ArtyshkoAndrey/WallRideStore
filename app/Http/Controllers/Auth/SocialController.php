<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegisterPassword;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialController extends Controller
{
  public function __construct()
  {
//    $this->middleware('guest');
  }

  public function vk (): RedirectResponse
  {
    return Socialite::driver('vkontakte')->redirect();
  }
  public function google (): RedirectResponse
  {
    return Socialite::driver('google')->redirect();
  }

  public function auth_vk (): \Illuminate\Http\RedirectResponse
  {
    Auth::logout();
    try {
      $user = Socialite::driver('vkontakte')->user();
      if ($user->email) {
        $userM = User::where('email', $user->email)->first();
        if (!$userM) {
          $userM = new User();
          $userM->email = $user->email;
          $userM->name = $user->name;

          $pass = str_random(10);
          $userM->password = bcrypt($pass);
          $userM->save();
          $userM->notify(new RegisterPassword($userM->email, $pass));
        }
        Auth::login($userM, true);
      } else {
        return redirect()->route('register')->withErrors(['В вашем аккаунте ВК не привязана почта']);
      }
    } catch (GuzzleHttp\Exception\ClientException $e) {
      return redirect()->route('login')->withErrors(['Произошла ошибка на стороне сервера. Попробуйте заново']);
    }
    return redirect()->route('profile.index');
  }

  public function auth_google (): \Illuminate\Http\RedirectResponse
  {
    Auth::logout();
    try {
      $user = Socialite::driver('google')->user();
      if ($user->email) {
        $userM = User::where('email', $user->email)->first();
        if ($userM) {
          Auth::login($userM, true);
        } else {
          $userM = new User();
          $userM->email = $user->email;
          $userM->name = $user->name;

          $pass = str_random(10);
          $userM->password = bcrypt($pass);
          $userM->save();
          $userM->notify(new RegisterPassword($userM->email, $pass));
          Auth::login($userM, true);
        }
      } else {
        return redirect()->route('register')->withErrors(['В вашем аккаунте Google не привязана почта']);
      }
    } catch (GuzzleHttp\Exception\ClientException $e) {
      return redirect()->route('login')->withErrors(['Произошла ошибка на стороне сервера. Попробуйте заново']);
    }
    return redirect()->route('profile.index');
  }

}
