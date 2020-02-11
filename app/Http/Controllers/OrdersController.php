<?php

namespace App\Http\Controllers;

use App\Events\OrderReviewed;
use App\Exceptions\CouponCodeUnavailableException;
use App\Exceptions\InvalidRequestException;
use App\Http\Requests\ApplyRefundRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\SendReviewRequest;
use App\Models\CouponCode;
use App\Models\UserAddress;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrdersController extends Controller
{

  public function store(OrderRequest $request, OrderService $orderService)
  {
    $user = $request->user();
    $address = $request->address;
    $coupon = null;
    $payment_method = $request->payment_method;
    $express_company = $request->express_company;

    if ($code = $request->input('coupon_code')) {
      $coupon = CouponCode::where('code', $code)->first();
      if (!$coupon) {
        throw new CouponCodeUnavailableException('优惠券不存在');
      }
    }
    $order = $orderService->store($user, $address, $request->items, $payment_method, $express_company, $coupon);
//    return $order;
    $request = [
      'pg_merchant_id' => 514888,
      'pg_testing_mode' => 1,
      'pg_user_contact_email' => $user->email,
      'pg_currency' => 'KZT',
      'pg_amount' => $order->total_amount,
      'pg_salt' => 'randomStringForProfessionModel',
      'pg_order_id' => $order->no,
      'pg_success_url_method' => 'POST',
      'pg_user_phone' => $address['phone'],
      'pg_description' => 'Описание заказа',
      'pg_success_url' => route('orders.success', ['no' => $order->no]),
      'pg_result_url' => route('orders.index')
    ];
    ksort($request); //sort alphabetically
    array_unshift($request, 'payment.php');
    array_push($request, 'kDY43tnDGs9yqtHG');
    $request['pg_sig'] = md5(implode(';', $request));
    unset($request[0], $request[1]);
    $query = http_build_query($request);
    if ($order->no) {
      return 'https://api.paybox.money/payment.php?' . $query;
    } else {
      return 'Ошибка';
    }
  }

  public function success($no)
  {
    $order = Order::where('no', $no)->first();
    $order->paid_at = Carbon::now();
    $order->ship_status = Order::SHIP_STATUS_PENDING;
    $order->closed = 0;
    $order->save();
    return redirect()->route('orders.index')->with('status', 'Ваш заказ оплачен и в обработке');
  }

  public function index(Request $request)
  {

    $orders = Order::query()
      ->with(['items.product', 'items.productSku'])
      ->where('user_id', $request->user()->id)
      ->orderBy('created_at', 'desc')
      ->paginate();

    return view('orders.index', ['orders' => $orders]);
  }

  public function create()
  {
    return view('orders.create');
  }
}
