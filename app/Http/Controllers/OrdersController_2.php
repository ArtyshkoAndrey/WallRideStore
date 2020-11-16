<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrdersController_2 extends Controller
{

  function multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
  }

  public function create()
  {
    if(!Auth::check()) {
      if (isset($_COOKIE["products"])) {
        $ids = explode(',', $_COOKIE["products"]);
      } else {
        $ids = [];
      }
      $cartItems = [];
      $priceAmount = 0;
      $productsSku = Product::getProducts($ids);
      foreach ($productsSku as $k => $productSku) {
        $ch = false;
        foreach ($cartItems as $key => $item) {
          if (($item['id'] === $productSku->id) && ($item['product_sku']->product->price === $productSku->product->price)) {
            $ch = true;
            $cartItems[$key]['amount'] = $item['amount'] + 1;
            $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
          }
        }
        if (!$ch) {
          if (isset($productSku)) {
            $item = array();
            $item['amount'] = 1;
            $item['id'] = $productSku->id;
            $item['product_sku'] = $productSku;
            $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
            array_push($cartItems, $item);
          } else {
            unset($productsSku[$k]);
          }
        }
      }
      $amount = count($ids);
      return view('orders.create_2', compact( 'cartItems', 'priceAmount', 'amount'));
    }
    return view('orders.create_2');
  }
}
