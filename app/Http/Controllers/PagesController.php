<?php

namespace App\Http\Controllers;

use App\Models\City;
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

  public function location (Request $request, $city) {
    $city = City::find($city);
    if (Auth::check()) {
      $address = UserAddress::where('user_id', auth()->id())->first();
      if(isset($address)) {
        $address->city()->associate($city);
        $address->save();
      } else {
        return redirect()->route('profile.index');
      }
    } else {
      setcookie('city',$city->id, time() + (86400 * 30), "/");
    }
    // setcookie('whooip', 1, time() + (86400 * 30), "/");
    setcookie('whooip', 1, time() + (3600 * 24 * 30), '/');
    return redirect()->back();
  }
}
