<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserSubscribeNotification;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

  /**
   * @param Request $request
   * @return JsonResponse
   * @throws BindingResolutionException
   */
  public function updateUserNotification(Request $request): JsonResponse
  {
    $request->validate([
      'email' => 'required|email',
      'language' => 'required|string'
    ]);
    $email = $request->get('email');
    $language = $request->get('language', 'ru');
    App::setLocale($language);
    $user = User::whereEmail($email)->first();
    if ($user) {
      if (!$user->notification) {
        $user->notification = true;
        if (!$user->old_notification) {
          $user->old_notification = true;
          $user->notify(new UserSubscribeNotification($user));
        }
        $user->save();
        return response()->json(__('email.subscribe'));
      }
      return response()->json(__('email.subscribe-already'));
    }
    return response()->json(['message' => __('email.error')], 500);
  }
}
