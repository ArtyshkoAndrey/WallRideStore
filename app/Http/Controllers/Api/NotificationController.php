<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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
      'email' => 'required|email'
    ]);
    $email = $request->get('email');
    $user = User::whereEmail($email)->first();
    if ($user) {
      if (!$user->notification) {
        $user->notification = true;
        if (!$user->old_notification) {
          $user->old_notification = true;
//          TODO: Рассылка о том что первый раз подпислись
        }
        $user->save();
        return response()->json('Вы успешно подписали. Вым был выслан промокод на скидку при следующей покупке');
      }
      return response()->json('Данная почта уже участвует в рассылке');
    }
    return response()->json(['message' => 'Данной почты не существует'], 500);
  }
}
