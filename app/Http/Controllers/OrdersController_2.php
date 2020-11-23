<?php

namespace App\Http\Controllers;

use App\Exceptions\CouponCodeUnavailableException;
use App\Http\Requests\OrderRequest;
use App\Models\Admin;
use App\Models\City;
use App\Models\CouponCode;
use App\Models\Currency;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use App\Models\UserAddress;
use App\Notifications\RegisterPaid;
use App\Notifications\RegisterPassword;
use App\Services\OrderService;
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

  public function store (OrderRequest $request, OrderService $orderService) {
    if(Auth::check()) {
      $user = $request->user();
    } else {
      $request->validate([
        'email' => 'required',
      ]);
      $user = User::where('email', $request->email)->first();
      if($user === null) {
//      return $request->address;
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->address['contact_name'];
        $address = new UserAddress();
        $address->contact_phone = $request->address['phone'];
        $address->country_id = $request->address['country'];
        $address->city_id = $request->address['city'];
        $address->currency_id = Currency::first()->id;
        $address->street = $request->address['street'];
        $pass = str_random(10);
        $user->password = bcrypt($pass);
        $user->save();
        $user->address()->save($address);
        $address->save();
        $user->notify(new RegisterPassword($user->email, $pass));
      }
      Auth::login($user);
    }
    $address = $request->address;
    $coupon = null;
    $service = $request->service;
    $payment_method = $request->payment_method;
    $express_company = $request->express_company;
    $cost_transfer = (int) $request->cost_transfer !== null && isset($request->cost_transfer) ? $request->cost_transfer : 0;

    if ($code = $request->input('coupon')) {
      $coupon = CouponCode::where('code', $code)->first();
      if (!$coupon) {
        throw new CouponCodeUnavailableException('Данного купона не существует');
      }
    }
    $order = $orderService->store($user, $address, $request->items, $payment_method, $express_company, $cost_transfer, $coupon);
    setcookie("products", '', time() + (3600 * 24 * 30), "/", request()->getHost());
    $items = $request->items;
    $promotionsName = [];
    foreach ($items as $item) {
      if (isset($item['productSku']['product']['isPromotion'])) {
        if (!in_array($item['productSku']['product']['namePromotion'], $promotionsName, TRUE)) {
          array_push($promotionsName, $item['productSku']['product']['namePromotion']);
          $order->promotions()->attach(Promotion::where('name', $item['productSku']['product']['namePromotion'])->first()->id);
        }
      }
    }
    $order->save();
    if ($payment_method === 'card') {
      if ($service === 'Paybox') {
        return $orderService->paybox($order, $user, $cost_transfer + $order->ship_price);
      } else if ($service === 'CloudPayment') {
        return route('orders.cloudpayment', ['userEmail' => $user->email, 'userId' => $user->id, 'orderId' => $order->id, 'cost' => $cost_transfer + $order->ship_price]);
      }
    } else {
      if ($order->no) {
        $order->ship_status = Order::SHIP_STATUS_PENDING;
        $order->closed = 0;
        $order->save();
        $admin = Admin::first();
        $admin->notify(new RegisterPaid($order));
        return route('orders.index');
      } else {
        return 'Ошибка';
      }
    }
  }
}
