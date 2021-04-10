<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    return response()->json('ok');
  }
}
