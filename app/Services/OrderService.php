<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Pay;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\ProductSku;
use App\Exceptions\InvalidRequestException;
use App\Jobs\CloseOrder;
use App\Notifications\OrderCancledNotification;
use Carbon\Carbon;
use App\Models\CouponCode;
use App\Exceptions\CouponCodeUnavailableException;
use Paybox\Pay\Facade as Paybox;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PayerInfo;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Redirect;
use URL;

class OrderService
{
  public function store(User $user, $address, $items, $payment_method, $express_company, $cost_transfer, CouponCode $coupon = null)
  {
    // 如果传入了优惠券，则先检查是否可用
    if ($coupon) {
      $coupon->checkAvailable($user);
    }
    // 开启一个数据库事务
    $order = \DB::transaction(function () use ($user, $address, $items, $coupon, $payment_method, $express_company, $cost_transfer) {

      $order   = new Order([
        'address'      => [
            'address'       => ''.Country::find($address['country'])->name.','.City::find($address['city'])->name.','. $address['street'],
            'contact_name'  => $address['contact_name'],
            'contact_phone' => $address['phone'],
        ],
        'total_amount' => 0,
        'id_express_company' => $express_company['id'],
        'payment_method' => $payment_method,
        'ship_price' => $cost_transfer
      ]);
      $order->user()->associate($user);
      $order->save();

      $ids = array();
      foreach ($items as $data) {
        for($i = 0; $i < $data['amount']; $i++) {
          array_push($ids, $data['productSku']['id']);
        }
      }
      $productsSku = Product::getProducts($ids);
      $priceAmount = 0;
      foreach ($productsSku as $k => $productSku) {
        $priceAmount += $productSku->product->on_sale ? (int)$productSku->product->price_sale : (int)$productSku->product->price;
      }
      foreach ($items as $data) {
        $sku = ProductSku::find($data['productSku']['id']);
        $item = $order->items()->make([
          'amount' => $data['amount'],
          'price' => $sku->product->on_sale ? $sku->product->price_sale : $sku->product->price,
        ]);
        $item->product()->associate($sku->product_id);
        if (isset($sku->skus->title)) {
          $item->product_sku = $sku->skus->title;
        } else {
          $item->product_sku = 'One Size';
        }
        $item->save();
        if ($sku->decreaseStock($data['amount']) <= 0) {
          throw new InvalidRequestException('Товар распродан');
        }
      }
      $totalAmount = $priceAmount;
      if ($coupon) {
        $coupon->checkAvailable($user, $priceAmount);
        $totalAmount = $coupon->getAdjustedPrice($priceAmount, $items);

        $order->couponCode()->associate($coupon);
        if ($coupon->changeUsed() <= 0) {
          throw new CouponCodeUnavailableException('该优惠券已被兑完');
        }
      }

      $order->update(['total_amount' => $totalAmount]);

      $skuIds = collect($items)->pluck('sku_id')->all();
      app(CartService::class)->removeAll();
      return $order;
    });

  // dispatch(new CloseOrder($order, config('app.order_ttl')));
    return $order;
  }

  public function cancled(Order $order) {
//      Order::SHIP_STATUS_CANCEL
    $order->ship_status = Order::SHIP_STATUS_CANCEL;
    $order->save();
    $order->user->notify(new OrderCancledNotification($order));
    foreach ($order->items as $item) {
      if (Product::find($item->product->id)) {
        $sku = ProductSku::where('product_id', $item->product->id);
        if($sku->count() === 1) {
          $sku = $sku->first();
          $sku->addStock($item->amount);
        } else if ($sku->count() > 1) {
          $sku = $sku->whereHas('skus', function ($q) use ($item) {
            $q->where('skuses.title', $item->product_sku);
          })->first();
          if ($sku) {
            $sku->addStock($item->amount);
          } else {
            $sku        = new ProductSku();
            $sku->stock = $item->amount;
            $sku->product()->associate($item->product->id);
            $sku->skus()->associate(Skus::where('title', $item->product_sku)->first());
            $sku->save();
          }

        } else {
          throw new \Exception('Ошибка в размерах');
        }
      }
    }
  }

  public function paybox ($order, $user, $cost) {
    $p = Pay::first();
    $paybox = new Paybox();
    $paybox->merchant->id = $p->pg_merchant_id;
    $paybox->merchant->secretKey = $p->code;
    $paybox->order->id = $order->id;
    $paybox->order->description = $p->pg_description;
    $paybox->order->amount = $cost;
    $paybox->config->isTestingMode = (bool) $p->pg_testing_mode;
    $paybox->customer->userEmail = $user->email;
    $paybox->customer->id = $user->id;
    $paybox->config->successUrlMethod = 'GET';
    $paybox->config->successUrl = route('orders.index');
    $paybox->config->resultUrl = route('orders.success', $order->id);
    $paybox->config->requestMethod = 'GET';
    if ($paybox->init()) {
      return $paybox->redirectUrl;
    } else {
      return response('Ошибка подключения к Paybox', 500);
    }
  }

  public function paypal ($order) {

    $currency = Currency::where('short_name', 'USD')->first();
    /** PayPal api context **/
    $paypal_conf = config('paypal');
    $_api_context = new ApiContext(new OAuthTokenCredential(
        $paypal_conf['client_id'],
        $paypal_conf['secret'])
    );
    $_api_context->setConfig($paypal_conf['settings']);
    $amountToBePaid = ($order->ship_price + $order->total_amount) * $currency->ratio;
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $amount = new Amount();
    $amount->setCurrency('USD')
      ->setTotal($amountToBePaid);

    $redirect_urls = new RedirectUrls();
    /** Укажите обратный URL **/
    $redirect_urls->setReturnUrl(route('orders.statusPaypal'))
      ->setCancelUrl(route('orders.statusPaypal'));

    $transaction = new Transaction();
    $transaction->setAmount($amount)
      ->setDescription('Оплата заказа в wallridestore.com');

    $payment = new Payment();
    $payment->setIntent('Sale')
      ->setPayer($payer)
      ->setRedirectUrls($redirect_urls)
      ->setTransactions(array($transaction));
    try {
      $payment->create($_api_context);
    } catch (\PayPal\Exception\PayPalConnectionException $ex) {
      if (config('app.debug')) {
        return response('Ошибка подключения к PayPal', 500);
      } else {
        return response('Ошибка подключения к PayPal', 500);;
      }
    }

    foreach ($payment->getLinks() as $link) {
      if ($link->getRel() == 'approval_url') {
        $redirect_url = $link->getHref();
        break;
      }
    }
    /** добавляем ID платежа в сессию **/
    session(['paypal_payment_id' => $payment->getId()]);
    session(['order_id' => $order->id]);

    if (isset($redirect_url)) {
      /** редиректим в paypal **/
      return $redirect_url;
    }
    return 'Ошибка';
  }

}
