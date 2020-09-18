<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Services\CartService;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Stock;
use App\Models\UserAddress;
use App\Models\User;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $cartService;

  public function __construct(CartService $cartService) {
    $isCrCoockie = true;
    if (!isset($_COOKIE['cr'])) {
      setcookie('cr', Currency::find(1)->id, time() + (3600 * 24 * 30), '/');
      $isCrCoockie = false;
    }
    if(!isset($_COOKIE["products"])) {
      setcookie("products", '', time() + (3600 * 24 * 30), '/');

    }
    $stock = null;
    try {
      if (explode('/', Request()->route()->getPrefix())[0] !== 'admin' || end($r) !== 'getData' || end($r) !== 'favicon.ico') {
        $sts = Stock::all();
        foreach ($sts as $st) {
          if (!isset($_COOKIE['stock_' . $st->id])) {
            $stock = $st;
            break;
          }
        }
      }
    } catch (\Throwable $e) {
      $stock = null;
    }
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) use($stock, $isCrCoockie) {
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
        $dataItems = $this->cartService->get();
        $amount = $dataItems['amount'];
        $priceAmount = $dataItems['priceAmount'];
        $cartItems = $dataItems['cartItems'];
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        if(isset($address)) {
          if ($address->currency_id !== null) {
            $currencyGlobal = $address->currency;
          } else {
            $currency = Currency::find(1);
            $address->currency()->associate($currency);
            $address->save();
            $currencyGlobal = $address->currency;
            setcookie('cr', $currencyGlobal->id, time() + (3600 * 24 * 30), '/');
          }
        } else {
          $currencyGlobal = Currency::find(1);
          setcookie('cr', $currencyGlobal->id, time() + (3600 * 24 * 30), '/');
        }
      } else if ($isCrCoockie) {
        $currencyGlobal = Currency::find($_COOKIE['cr']);
      } else {
        $currencyGlobal = Currency::find(1);
        setcookie('cr', $currencyGlobal->id, time() + (3600 * 24 * 30), '/');
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
      return $next($request);
    });
  }

}
