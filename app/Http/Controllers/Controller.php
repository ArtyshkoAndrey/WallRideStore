<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Currency;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\CartService;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $cartService;

  public function __construct(CartService $cartService) {
    if (!isset($_COOKIE['city'])) {
      setcookie('city', City::first()->id, time() + (86400 * 30), "/");
    }
    if (!isset($_COOKIE['whooip'])) {
      setcookie('whooip', 0, time() + (86400 * 30));
    }
    if(!isset($_COOKIE["products"])) {
      setcookie("products", '', time() + (3600 * 24 * 30), "/", request()->getHost());
    }
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) {
      $cartItems = [];
//      dd(explode('/', $request->route()->getPrefix())[0]);
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
        $currencyGlobal = Currency::find(1);
      }
      if(Carbon::parse($currencyGlobal->updated_at)->addDay() < Carbon::now()) {
        $ar = simplexml_load_file('https://nationalbank.kz/rss/rates_all.xml');
        foreach($ar->channel->item as $item) {
          if ((string)$item->title === 'USD') {
            $currency = Currency::where('name', 'Американский доллар')->first();
            $currency->ratio = 1/$item->description;
            $currency->save();
          } else if ((string)$item->title === 'RUB') {
            $currency = Currency::where('name', 'Российский рубль')->first();
            $currency->ratio = 1/$item->description;
            $currency->save();
          }
        }
        $currency = Currency::where('name', 'Тенге')->first();
        $currency->updated_at = Carbon::now();
        $currency->save();
        header("Refresh: 0;");
      }
      View::share('currency', $currencyGlobal);
      View::share('cartItems', $cartItems);
      View::share('priceAmount', $priceAmount);
      View::share('amount', $amount);
      return $next($request);
    });
  }

}
