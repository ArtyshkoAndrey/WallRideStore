<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Currency;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;

class PagesController extends Controller
{
  public function root () {
    return view('pages.root');
  }

  public function about () {
    return view('pages.about');
  }
  public function contact () {
    return view('pages.contact');
  }

  public function policy () {
    return view('pages.policy');
  }

  public function payment () {
    return view('pages.payment');
  }

  public function currency (Request $request, $cr) {
    if (Auth::check()) {
      $address = UserAddress::where('user_id', auth()->id())->first();
      if(isset($address)) {
        $address->currency_id = $cr;
        $address->save();
      } else {
        return redirect()->route('profile.index');
      }
    } else {
      setcookie('cr',$cr, time() + (86400 * 30), "/");
    };
    return redirect()->back();
  }
}
