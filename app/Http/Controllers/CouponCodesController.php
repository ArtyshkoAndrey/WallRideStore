<?php

namespace App\Http\Controllers;

use App\Exceptions\CouponCodeUnavailableException;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponCodesController extends Controller
{
    public function show($code, Request $request)
    {
      if (!$record = CouponCode::where('code', $code)->first()) {
        throw new CouponCodeUnavailableException('优惠券不存在');
      }
      $record->checkAvailable(Auth::check() ? $request->user() : null);
      return ['record' => $record, 'totalAmount' => $record->getAdjustedPrice($request->totalAmount)];
    }
}
