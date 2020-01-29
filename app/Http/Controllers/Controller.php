<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\UserAddress;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function __construct() {
    $this->middleware(function ($request, $next) {
      if (Auth::check()) {
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        $currencyGlobal = $address->currency;
      } else {
        $currencyGlobal = Currency::find(1);
      }
      View::share('currency', $currencyGlobal);
      return $next($request);
    });
  }

}
