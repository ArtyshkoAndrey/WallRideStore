<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Modal;
use Illuminate\Contracts\Container\BindingResolutionException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModalController extends Controller
{
  /**
   * @param Request $request
   * @return JsonResponse
   * @throws BindingResolutionException
   */
  public function index(Request $request): JsonResponse
  {
    $modals = Modal::translatedIn($request->get('language'))->get();
    return response()->json(['modals' => $modals]);
  }
}
