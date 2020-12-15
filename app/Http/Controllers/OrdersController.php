<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Exceptions\CouponCodeUnavailableException;
use App\Http\Requests\OrderRequest;
use App\Jobs\CloseOrder;
use App\Jobs\ProcessOrderMailer;
use App\Models\Admin;
use App\Models\City;
use App\Models\CouponCode;
use App\Models\Currency;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;
use App\Models\Pay;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Order;
use App\Notifications\OrderCreateNotification;
use App\Notifications\OrderEditNotification;
use App\Notifications\RegisterPaid;
use App\Notifications\RegisterPassword;
use App\Notifications\UserCouponCodeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class OrdersController extends Controller
{


  function multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
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
        $user->notification = $request->notification;
        if ($request->notification) {
          $request->old_notification = true;
        }
        $pass = str_random(10);
        $user->password = bcrypt($pass);
        $user->save();
        if ($request->notification)
          $user->notify(new UserCouponCodeNotification($user));
        $user->address()->save($address);
        $address->save();
        $user->notify(new RegisterPassword($user->email, $pass));
      } else {
        if ($request->notification) {
          $user->notification = true;
          if(!$user->old_notification) {
            $user->old_notification = true;
            $user->notify(new UserCouponCodeNotification($user));
          }
          $user->save();
        }
      }
      Auth::login($user);
    }
    $address = $request->address;
    $coupon = null;
    $service = $request->service;
    $payment_method = $request->payment_method;
    $express_company = $request->express_company;
    $cost_transfer = (int) $request->cost_transfer;

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
    $order->user->notify(new OrderCreateNotification($order));
    if ($payment_method === 'card') {
      ProcessOrderMailer::dispatch($order, now()->addMinutes(10));
//      TODO: Изменить время addHourse(3)
      CloseOrder::dispatch($order, now()->addMinute());

      if ($service === 'Paybox') {
        return $orderService->paybox($order, $user, $order->total_amount + $order->ship_price);
      } else if ($service === 'CloudPayment') {
        return route('orders.cloudpayment', ['userEmail' => $user->email, 'userName' => $user->name, 'orderId' => $order->id, 'cost' => ($order->total_amount + $order->ship_price)]);
      } else if ($service === 'PayPal') {
        return $orderService->paypal($order);
      }
    } else {
      if ($order->no) {
        $order->ship_status = Order::SHIP_STATUS_PENDING;
        $order->paid_at = now();
        $order->closed = 0;
        $order->save();
        $order->user->notify(new OrderEditNotification($order, Order::$shipStatusMap[Order::SHIP_STATUS_PENDING]));
        $admin = Admin::first();
        $admin->notify(new RegisterPaid($order));
        return route('orders.index');
      } else {
        return response('Ошибка создания заказа', 500);;
      }
    }
  }

  public function success(Request $request, int $id)
  {

    if ((int) $request->pg_result === 1) {
      $order = Order::with('items.product')->find($id);
      $order->ship_status = Order::SHIP_STATUS_PENDING;
      $order->paid_at = Carbon::now();
      $order->closed = 0;
      $order->save();
      event(new OrderPaid($order));
      $admin = Admin::first();
      $admin->notify(new RegisterPaid($order));
      $ids = [];
      foreach ($order->items as $item) {
        !$item->product->available() ? array_push($ids, $item->product_id) : null;
      }
      Product::destroy($ids);
    }
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
    $settings = Settings::where('key', 'pay')->first();
    $pays = json_decode($settings->meta)->pays;
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
      return view('orders.create_2', compact( 'cartItems', 'priceAmount', 'amount', 'pays'));
    }
    return view('orders.create_2', compact('pays'));
  }

  public function cloudpayment (Request $request) {
    $validator = Validator::make($request->all(), [
      'cost' => 'required|integer',
      'userName' => 'required|string',
      'userEmail' => 'required|string|exists:users,email',
      'orderId' => 'required|exists:orders,id'
    ]);
    if ($validator->fails())
      return redirect('/');
    $order = Order::find($request->orderId);
    $data = $request->all();
    return view('orders.cloud-payment', compact('order', 'data'));
  }

  public function closeCloudpayment (int $id, OrderService $orderService) {
    $validator = Validator::make(['id' => $id], [
      'id' => 'required|integer|exists:orders,id',
    ]);
    if ($validator->fails())
      return response(['error'], 500);
    $order = Order::find($id);

//      TODO: Изменить время addHourse(3)
    CloseOrder::dispatch($order, now());

    return response(['success']);
  }

  public function successCloudpayment (int $id) {
    $validator = Validator::make(['id' => $id], [
      'id' => 'required|exists:orders,id',
    ]);
    if ($validator->fails())
      return response(['error'], 500);
    $order = Order::find($id);
    $order->ship_status = Order::SHIP_STATUS_PENDING;
    $order->paid_at = Carbon::now();
    $order->closed = 0;
    $order->save();
    event(new OrderPaid($order));
    $admin = Admin::first();
    $admin->notify(new RegisterPaid($order));
    $ids = [];
    foreach ($order->items as $item) {
      !$item->product->available() ? array_push($ids, $item->product_id) : null;
    }
    Product::destroy($ids);
    return response(['success']);
  }

  public function paypalStatus(Request $request)
  {
    /** PayPal api context **/
    $paypal_conf = config('paypal');
    $order_id = session('order_id');
    $_api_context = new ApiContext(new OAuthTokenCredential(
        $paypal_conf['client_id'],
        $paypal_conf['secret'])
    );
    $_api_context->setConfig($paypal_conf['settings']);
    /** Получаем ID платежа до очистки сессии **/
    $payment_id = session('paypal_payment_id');
    if (empty($request->PayerID) || empty($request->token)) {
      session()->flash('error', 'Payment failed');
      return redirect()->route('orders.index')->with(['status' => 'Платеж не прошел']);
    }

    $payment = Payment::get($payment_id, $_api_context);
    $execution = new PaymentExecution();
    $execution->setPayerId($request->PayerID);

    /** Выполняем платёж **/
    $result = $payment->execute($execution, $_api_context);

    if ($result->getState() == 'approved') {

      $order = Order::find($order_id);
      $order->ship_status = Order::SHIP_STATUS_PENDING;
      $order->paid_at = Carbon::now();
      $order->closed = 0;
      $order->save();
      event(new OrderPaid($order));
      $admin = Admin::first();
      $admin->notify(new RegisterPaid($order));
      $ids = [];
      foreach ($order->items as $item) {
        !$item->product->available() ? array_push($ids, $item->product_id) : null;
      }
      Product::destroy($ids);

      return redirect()->route('orders.index')->with(['status' => 'Заказ оплачен']);
    }

    return redirect()->route('orders.index')->with(['status' => 'Платеж не прошел']);
  }
}
// http://myshop/orders/paypal/status?paymentId=PAYID-L6Z64XY87N141225X051071A&token=EC-2TB94664SA8431513&PayerID=U862F6WDQQU42.
