<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Exceptions\CouponCodeUnavailableException;
use App\Exceptions\InvalidRequestException;
use App\Http\Requests\ApplyRefundRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\SendReviewRequest;
use App\Models\Admin;
use App\Models\City;
use App\Models\CouponCode;
use App\Models\Currency;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;
use App\Models\Pay;
use App\Models\ProductSku;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Order;
use App\Notifications\OrderPaidNotification;
use App\Notifications\RegisterPaid;
use App\Notifications\RegisterPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
  function multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
  }

  public function store(OrderRequest $request, OrderService $orderService)
  {
    if(Auth::check()) {
      $user = $request->user();
    } else {
      $request->validate([
        'email' => 'required|unique:users',
      ]);
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
      Auth::login($user);
      $user->notify(new RegisterPassword($user->email, $pass));
    }
    $address = $request->address;
    $coupon = null;
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
//    return $order;
    setcookie("products", '', time() + (3600 * 24 * 30), "/", request()->getHost());
    if ($payment_method === 'card') {
      $p = Pay::first();
      $request = [
        'pg_merchant_id' => (int) $p->pg_merchant_id,
        'pg_testing_mode' => (int) $p->pg_testing_mode,
        'pg_user_contact_email' => $user->email,
        'pg_currency' => 'KZT',
        'pg_amount' => $order->total_amount + $order->ship_price,
        'pg_salt' => 'randomStringForProfessionModel',
        'pg_order_id' => $order->no,
        'pg_success_url_method' => 'POST',
        'pg_user_phone' => implode('', $this->multiexplode(array('-', '+', '(', ')', ' ',), $address['phone'])),
        'pg_description' => $p->pg_description,
        'pg_success_url' => route('orders.success', ['no' => $order->no]),
        'pg_result_url' => route('orders.index')
      ];
      ksort($request); //sort alphabetically
      array_unshift($request, 'payment.php');
      array_push($request, $p->code);
      $request['pg_sig'] = md5(implode(';', $request));
      unset($request[0], $request[1]);
      $query = http_build_query($request);
      if ($order->no) {
        return $p->url . $query;
      } else {
        return 'Ошибка';
      }
    } else {
      if ($order->no) {
        $order->ship_status = Order::SHIP_STATUS_PENDING;
        $order->closed = 0;
        $order->save();
        foreach ($order->items as $item) {
          $sku = ProductSku::where('product_id', $item->product->id);
          if($sku->count() === 1) {
            $sku = $sku->first();
//        dd($sku);
            $sku->decreaseStock($item->amount);
          } else if ($sku->count() > 1) {
            $sku = $sku->whereHas('skus', function ($q) use ($item) {
              $q->where('skuses.title', $item->product_sku);
            })->first();
//        dd($sku);
            $sku->decreaseStock($item->amount);
          } else {

          }
        }
        $admin = Admin::first();
        $admin->notify(new RegisterPaid($order));
        return route('orders.index');
      } else {
        return 'Ошибка';
      }
    }

  }

  public function success($no)
  {
    $order = Order::where('no', $no)->first();
    $order->paid_at = Carbon::now();
    $order->ship_status = Order::SHIP_STATUS_PENDING;
    $order->closed = 0;
    $order->save();
    foreach ($order->items as $item) {
      $sku = ProductSku::where('product_id', $item->product->id);
      if($sku->count() === 1) {
        $sku = $sku->first();
//        dd($sku);
        $sku->decreaseStock($item->amount);
      } else if ($sku->count() > 1) {
        $sku = $sku->whereHas('skus', function ($q) use ($item) {
          $q->where('skuses.title', $item->product_sku);
        })->first();
//        dd($sku);
        $sku->decreaseStock($item->amount);
      } else {

      }
    }
    event(new OrderPaid($order));
    $admin = Admin::first();
    $admin->notify(new RegisterPaid($order));

    return redirect()->route('orders.index')->with('status', 'Ваш заказ оплачен и в обработке');
  }

  public function index(Request $request)
  {

    $orders = Order::query()
      ->with(['items.product'])
      ->where('user_id', $request->user()->id)
      ->orderBy('created_at', 'desc')
      ->get();

    return view('orders.index', ['orders' => $orders]);
  }

  public function create()
  {
    $express_companies = ExpressCompany::where('name', '!=', 'Самовывоз')->get();
    $zones = ExpressZone::with('company')->whereHas('cities', function ($qq) {
      if(Auth::check()) {
        $qq->where('cities.id', isset(Auth()->user()->address->city_id) ? Auth()->user()->address->city_id : $_COOKIE['city']);
      } else {
        $qq->where('cities.id', $_COOKIE['city']);
      }
    })->get();
    $express_companies = $express_companies->toArray();
    for($i=0;$i<count($express_companies); $i++) {
      foreach ($zones as $z) {
        if($z->company->id === $express_companies[$i]['id']) {
          $express_companies[$i]['costedTransfer'] = $z->cost;
        }
      }
      if (!isset($express_companies[$i]['costedTransfer'])) {
        $express_companies[$i]['costedTransfer'] = null;
      }
    }
    if(!Auth::check()) {
      if (isset($_COOKIE["products"])) {
        $ids = explode(',', $_COOKIE["products"]);
      } else {
        $ids = [];
      }
      $city = City::find($_COOKIE['city']);
      $cartItems = [];
      $priceAmount = 0;
      foreach ($ids as $k => $id) {
        $id = (int) $id;
        $ch = false;
        $item = (object) array();
        $prs = ProductSku::with('product')->where('id', $id)->first();
        foreach ($cartItems as $key => $item) {
          if ($item->productSku->id === $id) {
            $ch = true;
            $cartItems[$key]->amount = $item->amount + 1;
            $priceAmount += $prs->product->on_sale ? $prs->product->price_sale : $prs->product->price;
          }
        }
        if (!$ch) {
          if (isset($prs)) {
            $item = (object)array();
            $item->amount = 1;
            $item->id = $id;
            $item->productSku = $prs;
            $priceAmount += $prs->product->on_sale ? $prs->product->price_sale : $prs->product->price;
            array_push($cartItems, $item);
          } else {
            unset($ids[$k]);
          }
        }
      }
      $amount = count($ids);
      return view('orders.create', compact('express_companies', 'city', 'cartItems', 'priceAmount', 'amount'));
    }
    return view('orders.create', compact('express_companies'));
  }
}
