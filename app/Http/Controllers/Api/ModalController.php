<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\RandomCouponCode;
use App\Models\CouponCode;
use App\Models\Modal;
use http\Env\Response;
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

  /**
   * @throws BindingResolutionException
   */
  public function code(): JsonResponse
  {
    $code = CouponCode::whereRandom(true)->first();

    if (!$code) {
      $this->dispatch(new RandomCouponCode());
      return response()->json('error code', 500);
    }

    return response()->json(['code' => $code]);
  }
}
