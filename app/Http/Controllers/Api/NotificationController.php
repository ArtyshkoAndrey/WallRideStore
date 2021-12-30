<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserSubscribeNotification;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class NotificationController extends Controller
{

  /**
   * @param Request $request
   * @return JsonResponse
   * @throws BindingResolutionException
   */
  public function updateUserNotification(Request $request): JsonResponse
  {
//    $request->validate([
//      'email' => 'required|email',
//      'language' => 'required|string'
//    ]);
//    $email = $request->get('email');
//    $language = $request->get('language', 'ru');
////    App::setLocale($language);
    /*
     *
     * Отправка email на поиск пользователя с таким email'ом
     */


//    $user = User::whereEmail($email)->first();
//    if ($user) {
//      if (!$user->notification) {
//        $user->notification = true;
//        if (!$user->old_notification) {
//          $user->old_notification = true;
          //$user->notify(new UserSubscribeNotification($user));
//        }
//        $user->save();
//        return response()->json(__('email.subscribe'));
//      }
//      return response()->json(__('email.subscribe-already'));
//    }
//    return response()->json(['message' => __('email.error')], 500);

    $response = Http::post('https://api.sendpulse.com/oauth/access_token', [
      'grant_type' => 'client_credentials',
      'client_id' => env('SENDPULSE_API_USER_ID'),
      'client_secret' => env('SENDPULSE_API_SECRET')
    ]);
    $json = $response->json('access_token');


  $emails =  array('email' => $request->get('email')) ;

    $request_for_add_email = Http::withHeaders([
      'Authorization' => 'Bearer '.$json
    ])->post('https://api.sendpulse.com/addressbooks/357843/emails', [
      "emails" => json_encode($emails)
    ]);

    //357843

    return response()->json($request_for_add_email->json());

  }

}
