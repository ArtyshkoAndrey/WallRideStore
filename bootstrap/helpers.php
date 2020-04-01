<?php


use App\Models\Pay;
use Illuminate\Database\Eloquent\Collection;

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
  $request = [
    'pg_merchant_id' => (int) $p->pg_merchant_id,
    'pg_testing_mode' => (int) $p->pg_testing_mode,
    'pg_user_contact_email' => auth()->user()->email,
    'pg_currency' => 'KZT',
    'pg_amount' => $order->total_amount + $order->ship_price,
    'pg_salt' => 'randomStringForProfessionModel',
    'pg_order_id' => $order->no,
    'pg_success_url_method' => 'POST',
    'pg_user_phone' => implode('', multiexplode(array('-', '+', '(', ')', ' ',), auth()->user()->address->contact_phone)),
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
  return $p->url . $query;
}

function multiexplode ($delimiters,$string) {
  $ready = str_replace($delimiters, $delimiters[0], $string);
  $launch = explode($delimiters[0], $ready);
  return  $launch;
}

