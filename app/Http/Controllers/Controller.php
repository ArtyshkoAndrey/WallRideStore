<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Stock;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Services\CartService;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $cartService;

  public function __construct(CartService $cartService) {

    if (!isset($_COOKIE['city'])) {
      setcookie('city', City::first()->id, time() + (3600 * 24 * 30), '/');
    }
//    if (!isset($_COOKIE['stock_counter'])) {
//      setcookie('stock_counter', 10, time() + (3600 * 24 * 30), '/');
//    }
    if (!isset($_COOKIE['whooip'])) {
      setcookie('whooip', 0, time() + (3600 * 24 * 30), '/');
    }
    if(!isset($_COOKIE["products"])) {
      setcookie("products", '', time() + (3600 * 24 * 30), '/');
    }
    $stock = null;
    try {
//    if (isset($_COOKIE['stock_counter'])) {
//      if ((int)$_COOKIE['stock_counter'] > 5 && (int)$_COOKIE['stock_counter'] !== 0) {
//        $r = explode('/',url()->current());
      if (explode('/', Request()->route()->getPrefix())[0] !== 'admin' || end($r) !== 'getData' || end($r) !== 'favicon.ico') {
        $sts = Stock::all();
        foreach ($sts as $st) {
          if (!isset($_COOKIE['stock_' . $st->id])) {
            $stock = $st;
            break;
          }
        }
//          setcookie('stock_counter', 0, time() + (3600 * 24 * 30), '/');
      }
//      } else {
//        dd(Cookie::get('stock_counter'));
//        setcookie('stock_counter', $_COOKIE['stock_counter'] + 1, time() + (3600 * 24 * 30), '/');
//        Cookie::queue(Cookie::make('stock_counter', Cookie::get('stock_counter') + 1, 60 * 24 * 30));
//      }
//    }
    } catch (\Throwable $e) {
      $stock = null;
    }
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) use($stock) {
      $cartItems = [];
      $priceAmount = 0;
      $amount = 0;
      if (Auth::check() && explode('/', $request->route()->getPrefix())[0] !== 'admin') {
        if(isset($_COOKIE["products"])) {
          if (count(explode(',', $_COOKIE["products"])) > 0) {
            $arr = explode(',', $_COOKIE["products"]);
            if ($arr[0] !== "") {
              foreach ($arr as $id) {
                $this->cartService->add((int) $id, 1);
              }
              setcookie("products", '', time() - 3600);;
            }
          }
        }
        $cartItems = $this->cartService->get();
        $priceAmount = $this->cartService->priceAmount();
        $amount = $this->cartService->amount();
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        if(isset($address)) {
          if ($address->currency_id !== null) {
            $currencyGlobal = $address->currency;
          } else {
            $currency = Currency::find(1);
            $address->currency()->associate($currency);
            $address->save();
            $currencyGlobal = $address->currency;
          }
        } else {
          $currencyGlobal = Currency::find(1);
        }
      } else {
        if (isset($_COOKIE['city'])) {
          if(!isset($_COOKIE['whooip']) || (int) $_COOKIE['whooip'] === 0) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://pro.ipwhois.io/json/' . \Request::ip() . '?key=gFoMKlSHuw23CWwm&lang=ru');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, []);
            $out = curl_exec($curl);
            curl_close($curl);
            if(\App\Models\City::where('name',json_decode($out)->city)->first()) {
              $ct = \App\Models\City::where('name',json_decode($out)->city)->first();
              $ctr = Country::whereHas('cities', function ($q) use ($ct) {
                $q->where('cities.id', $ct->id);
              })->first();
            } else if (\App\Models\City::where('name', 'LIKE', '%'.json_decode($out)->city . '%')->first()) {
              $ct = \App\Models\City::where('name', 'LIKE', '%'.json_decode($out)->city . '%')->first();
              $ctr = Country::whereHas('cities', function ($q) use ($ct) {
                $q->where('cities.id', $ct->id);
              })->first();
            } else {
              $ct = \App\Models\City::find($_COOKIE['city']);
              $ctr = Country::whereHas('cities', function ($q) use ($ct) {
                $q->where('cities.id', $ct->id);
              })->first();
            }
            if ($ctr) {
              if ($ctr->name === 'Россия') {
                $currencyGlobal = Currency::find(2);
              } else if ($ctr->name === 'Казахстан') {
                $currencyGlobal = Currency::find(1);
              } else {
                $currencyGlobal = Currency::find(3);
              }
            } else {
              $currencyGlobal = Currency::find(3);
            }
          } else {
            $ct = \App\Models\City::find($_COOKIE['city']);
            $ctr = Country::whereHas('cities', function ($q) use ($ct) {
              $q->where('cities.id', $ct->id);
            })->first();
            if ($ctr) {
              if ($ctr->name === 'Россия') {
                $currencyGlobal = Currency::find(2);
              } else if ($ctr->name === 'Казахстан') {
                $currencyGlobal = Currency::find(1);
              } else {
                $currencyGlobal = Currency::find(3);
              }
            } else {
              $currencyGlobal = Currency::find(3);
            }
          }
        } else {
          if(!isset($_COOKIE['whooip']) || (int)  $_COOKIE['whooip'] === 0) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://pro.ipwhois.io/json/' . \Request::ip() . '?key=gFoMKlSHuw23CWwm&lang=ru');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, []);
            $out = curl_exec($curl);
            curl_close($curl);
            if(\App\Models\City::where('name',json_decode($out)->city)->first()) {
              $ct = \App\Models\City::where('name',json_decode($out)->city)->first();
              $ctr = Country::whereHas('cities', function ($q) use ($ct) {
                $q->where('cities.id', $ct->id);
              })->first();
            } else if (\App\Models\City::where('name', 'LIKE', '%'.json_decode($out)->city . '%')->first()) {
              $ct = \App\Models\City::where('name', 'LIKE', '%'.json_decode($out)->city . '%')->first();
              $ctr = Country::whereHas('cities', function ($q) use ($ct) {
                $q->where('cities.id', $ct->id);
              })->first();
            } else {
              $ct = \App\Models\City::find(isset($_COOKIE['city']) ? $_COOKIE['city'] : 1);
              $ctr = Country::whereHas('cities', function ($q) use ($ct) {
                $q->where('cities.id', $ct->id);
              })->first();
            }
            if ($ctr) {
              if ($ctr->name === 'Россия') {
                $currencyGlobal = Currency::find(2);
              } else if ($ctr->name === 'Казахстан') {
                $currencyGlobal = Currency::find(1);
              } else {
                $currencyGlobal = Currency::find(3);
              }
            } else {
              $currencyGlobal = Currency::find(3);
            }
          } else {
            $currencyGlobal = Currency::find(1);
          }

        }
      }
      if(Carbon::parse($currencyGlobal->updated_at)->addDay() < Carbon::now()) {
        $assertion_link = 'https://nationalbank.kz/rss/rates_all.xml';
        $arrContextOptions=array(
          "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false
          )
        );
        try {
          $assertion = file_get_contents($assertion_link, false, stream_context_create($arrContextOptions));
          $ar = simplexml_load_string($assertion);

          //$ar = simplexml_load_file('https://nationalbank.kz/rss/rates_all.xml');
          foreach ($ar->channel->item as $item) {
            if ((string)$item->title === 'USD') {
              $currency = Currency::where('name', 'Американский доллар')->first();
              $currency->ratio = 1 / $item->description;
              $currency->save();
            } else if ((string)$item->title === 'RUB') {
              $currency = Currency::where('name', 'Российский рубль')->first();
              $currency->ratio = 1 / $item->description;
              $currency->save();
            }
          }
          $currency = Currency::where('name', 'Тенге')->first();
          $currency->updated_at = Carbon::now();
          $currency->save();
          header("Refresh: 0;");
        } catch (\ErrorException $e) {
          Log::info($e);
        }
      }
      View::share('currency', $currencyGlobal);
      View::share('cartItems', $cartItems);
      View::share('priceAmount', $priceAmount);
      View::share('amount', $amount);
      View::share('stocksToView', $stock);
//      View::share('stocksToView', null);
      return $next($request);
    });
  }

}
