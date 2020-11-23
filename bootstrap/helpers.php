<?php


use App\Models\Pay;
use Illuminate\Database\Eloquent\Collection;
use Paybox\Pay\Facade as Paybox;

function route_class()
{
  return str_replace('.', '-', Route::currentRouteName());
}


function cost($number) {
	return number_format($number, null, null, ' ');
}

Collection::macro('sortByDate', function ($column = 'created_at', $order = SORT_ASC) {
  /* @var $this Collection */
  return $this->sortBy(function ($datum) use ($column) {
    return strtotime($datum->$column);
  }, SORT_REGULAR, $order == SORT_ASC);
});

function pay_link($order) {
  $p = Pay::first();
  $paybox = new Paybox();
  $paybox->merchant->id = $p->pg_merchant_id;
  $paybox->merchant->secretKey = $p->code;
  $paybox->order->id = $order->id;
  $paybox->order->description = $p->pg_description;
  $paybox->order->amount = $order->total_amount + $order->ship_price;
  $paybox->config->isTestingMode = (bool) $p->pg_testing_mode;
  $paybox->customer->userEmail = auth()->user()->email;
  $paybox->customer->id = auth()->user()->id;
  $paybox->config->successUrlMethod = 'GET';
  $paybox->config->successUrl = route('orders.index');
  $paybox->config->resultUrl = route('orders.success', $order->id);
  $paybox->config->requestMethod = 'GET';
  if ($paybox->init()) {
    return $paybox->redirectUrl;
  }
}

function multiexplode ($delimiters,$string) {
  $ready = str_replace($delimiters, $delimiters[0], $string);
  $launch = explode($delimiters[0], $ready);
  return  $launch;
}
