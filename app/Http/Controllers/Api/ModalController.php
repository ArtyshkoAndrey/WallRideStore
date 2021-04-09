<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Modal;
use Illuminate\Http\JsonResponse;

class ModalController extends Controller
{
  public function index (): JsonResponse
  {
    $modals = Modal::all();
    return response()->json(['modals' => $modals]);
  }
}
