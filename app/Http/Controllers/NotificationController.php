<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\RegisterPassword;
use App\Notifications\UserCouponCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function subscribe (Request $request) {
    $back = $request->get('back', 0);
    $user = User::whereEmail($request->email)->first();
    if ($user) {
      if (!$user->notification) {
        $user->notification = true;
        if (!$user->old_notification) {
          $user->old_notification = true;
          $user->notify(new UserCouponCodeNotification($user));
        }
        $user->save();
        return $back ? redirect()->back()->withSuccess(['Вы успешно подписались на рассылку']) : redirect()->route('products.index')->withSuccess(['Вы успешно подписались на рассылку']);
      }
      return $back ? redirect()->back()->withSuccess(['Вы уже подписаны на рассылку']) : redirect()->route('products.index')->withSuccess(['Вы уже подписаны на рассылку']);
    }
    return $back ? redirect()->back()->withSuccess(['Данного пользователя нет']) : redirect()->route('products.index')->withSuccess(['Данного пользователя нет']);
  }

  public function unsubscribe (Request $request) {
    $back = $request->get('back', 0);
    $user = User::whereEmail($request->email)->first();
    if ($user) {
      $user->notification = false;
      $user->save();
      return $back ? redirect()->back()->withSuccess(['Вы успешно отписались от рассылки']) : redirect()->route('products.index')->withSuccess(['Вы успешно отписались от рассылки']);
    }
    return $back ? redirect()->back()->withSuccess(['Данного пользователя нет']) : redirect()->route('products.index')->withSuccess(['Данного пользователя нет']);
  }

  public function subscribeAuth () {
    $user = auth()->user();
    if ($user) {
      if (!$user->notification) {
        $user->notification = true;
        if (!$user->old_notification) {
          $user->old_notification = true;
          $user->notify(new UserCouponCodeNotification($user));
        }
        $user->save();
        return redirect()->back()->withSuccess(['Вы успешно подписались на рассылку']);
      }
      return redirect()->back()->withSuccess(['Вы уже подписаны на рассылку']);
    }
    return redirect()->back()->withSuccess(['Данного пользователя нет']);
  }

  public function subscribeNotAuth (Request $request) {
    if ($user = User::whereEmail($request->email)->first()) {
      return $this->subscribeNotAuthEmail($request);
    }
    $pass = str_random(10);
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($pass),
      'notification' => true,
      'old_notification' => true
    ]);
    Auth::login($user);
    $user->notify(new RegisterPassword($user->email, $pass));
    if ($user->notification) {
      $user->notify(new UserCouponCodeNotification($user));
    }
    return response()->json(['status' => true]);
  }

  public function subscribeNotAuthEmail (Request $request) {
    $user = User::whereEmail($request->email)->first();
    if (!$user->old_notification) {
      $user->notify(new UserCouponCodeNotification($user));
    }
    $user->notification = true;
    $user->old_notification = true;
    $user->save();
    return response()->json(['status' => true]);
  }
}
