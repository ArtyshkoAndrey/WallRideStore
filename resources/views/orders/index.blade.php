@extends('layouts.app')
@section('title', 'Список заказов')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-header">Список заказов</div>
  <div class="card-body">
    <ul class="list-group">
      @foreach($orders as $order)
        <li class="list-group-item">
          <div class="card">
            <div class="card-header">
              Номер заказа：{{ $order->no }}
              <span class="float-right">{{ $order->created_at->format('d.m.Y H:i:s') }}</span>
            </div>
            <div class="card-body">
              <table class="table">
                <thead>
                <tr>
                  <th>Информация о продукте</th>
                  <th class="text-center">Цена за единицу</th>
                  <th class="text-center">количество</th>
                  <th class="text-center">Общая стоимость заказа</th>
                  <th class="text-center">Состояние заказа</th>
                  <th class="text-center">Операция</th>
                </tr>
                </thead>
                @foreach($order->items as $index => $item)
                  <tr>
                    <td class="product-info">
                      <div class="preview">
                        <a target="_blank" href="{{ route('products.show', [$item->product_id]) }}">
                          <img src="{{ $item->product->image_url }}">
                        </a>
                      </div>
                      <div>
                        <span class="product-title">
                           <a target="_blank" href="{{ route('products.show', [$item->product_id]) }}">{{ $item->product->title }}</a>
                        </span>
                        <span class="sku-title">{{ $item->productSku->title }}</span>
                      </div>
                    </td>
                    <td class="sku-price text-center">{{ $item->price }} р.</td>
                    <td class="sku-amount text-center">{{ $item->amount }}</td>
                    @if($index === 0)
                      <td rowspan="{{ count($order->items) }}" class="text-center total-amount">{{ $order->total_amount }} р.</td>
                      <td rowspan="{{ count($order->items) }}" class="text-center">
                        @if($order->paid_at)
                          @if($order->refund_status === \App\Models\Order::REFUND_STATUS_PENDING)
                            Оплаченный
                          @else
                            {{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}
                          @endif
                        @elseif($order->closed)
                          Закрыто
                        @else
                          Неоплаченный<br>
                          Пожалуйста, завершите ваш платеж до {{ $order->created_at->addSeconds(config('app.order_ttl'))->format('H:i') }}<br>
                          В противном случае заказ будет закрыт автоматически
                        @endif
                      </td>
                      <td rowspan="{{ count($order->items) }}" class="text-center">
                        <a class="btn btn-primary btn-sm" href="{{ route('orders.show', ['order' => $order->id]) }}">Посмотреть заказ</a>
                        <!-- Оценочный вход начинается -->
                        @if($order->paid_at)
                          <a class="btn btn-success btn-sm" href="{{ route('orders.review.show', ['order' => $order->id]) }}">
                            {{ $order->reviewed ? 'Посмотреть отзывы' : 'Оценить' }}
                          </a>
                        @endif
                        <!-- Конец вступительного экзамена -->
                      </td>
                    @endif
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </li>
      @endforeach
    </ul>
    <div class="float-right">{{ $orders->render() }}</div>
  </div>
</div>
</div>
</div>
@endsection
