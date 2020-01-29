@extends('layouts.app')
@section('title', 'Мои заказы')

@section('content')
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show position-absolute d-table" style="right:0" role="alert">
      <button type="button" class="close mt-2" data-dismiss="alert">×</button>
      <h5 class="mt-2"><strong>{{ session('status') }}</strong></h5>
    </div>
  @endif
  <section class="container py-5" id="profile">
    <div class="card px-0">
      <div class="card-body px-0 py-0">
        <div class="row">
          <div class="col-md-3">
            <div class="nav flex-column nav-pills h-100" role="tablist" aria-orientation="vertical">
              <a class="nav-link border-0" href="{{ route('profile.index') }}" aria-selected="true"><i class="fal fa-user pr-1"></i> Мой профиль</a>
              <a class="nav-link active border-0" href="{{ route('orders.index') }}" aria-selected="true"><i class="fal fa-tasks pr-1"></i> Мои заказы</a>
            </div>
          </div>
          <div class="col-md-9">
            <div class="row">
              <div class="col-12">
                <h3 class="font-weight-bold">Мой профиль</h3>
              </div>
            </div>
            <div class="row mt-4">
              <ul class="nav nav-tabs bg-white border-0" id="myTab" role="tablist">
                <li class="nav-item bg-white m-0">
                  <a class="nav-link active border-0" id="success-order-tab" data-toggle="tab" href="#active-order" role="tab" aria-controls="active-order"
                     aria-selected="true">Текущие</a>
                </li>
                <li class="nav-item bg-white m-0">
                  <a class="nav-link border-0" id="success-order-tab" data-toggle="tab" href="#success-order" role="tab" aria-controls="success-order"
                     aria-selected="false">Выполненые</a>
                </li>
              </ul>
              <div class="tab-content w-100" id="myTabContent">
                <div class="tab-pane fade show active" id="active-order" role="tabpanel" aria-labelledby="home-tab">
                  <div class="table-responsive">
                    <table class="table text-center">
                      <thead>
                      <tr>
                        <th class="border-top-0" scope="col">№ заказа</th>
                        <th class="border-top-0" scope="col">Статус заказа</th>
                        <th class="border-top-0" scope="col">Метод оплаты</th>
                        <th class="border-top-0" scope="col">Метод доставки</th>
                        <th class="border-top-0" scope="col">Трек номер</th>
                        <th class="border-top-0" scope="col">Сумма заказа</th>
                      </tr>
                      </thead>
                      <tbody>
                        @forelse($orders as $order)
                          @if($order->ship_status !== 'received')
                            <tr>
                              <th scope="row">{{ $order->no }}</th>
                              <td
                                style="color: {{ $order->ship_status == \App\Models\Order::SHIP_STATUS_PENDING ? '#D0D0D0' : '#04B900'}}"
                              >{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
                              <td>{{ \App\Models\Order::$paymentMethodsMap[$order->payment_method] }}</td>
                              <td>{{ \App\Models\Order::$expressMethodsMap[$order->express_company] }}</td>
                              <td>
                                @if($order->ship_status == \App\Models\Order::SHIP_STATUS_DELIVERED || !isset($order->ship_data['express_no']))
                                  Ожидайте
                                @elseif(isset($order->ship_data['express_no']))
                                  {{ $order->ship_data['express_no'] }}
                                  <a href="#" class="c-red d-block">Отследить</a>
                                @endif
{{--                                RP2303403402pp <a href="#" class="c-red d-block">Отследить</a>--}}
                              </td>
                              <td>{{ $order->total_amount }} тг.</td>
                            </tr>
                          @endif
                        @empty
                          <tr>
                            <td>Нет автивных заказов</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="success-order" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="table-responsive">
                    <table class="table text-center">
                      <thead>
                        <tr>
                          <th class="border-top-0" scope="col">№ заказа</th>
                          <th class="border-top-0" scope="col">Статус заказа</th>
                          <th class="border-top-0" scope="col">Метод оплаты</th>
                          <th class="border-top-0" scope="col">Метод доставки</th>
                          <th class="border-top-0" scope="col">Трек номер</th>
                          <th class="border-top-0" scope="col">Сумма заказа</th>
                        </tr>
                      </thead>
                      <tbody>
                      @forelse($orders as $order)
                        @if($order->ship_status == 'received')
                          <tr>
                            <th scope="row">{{ $order->no }}</th>
                            <td
                              style="color: {{ $order->ship_status == \App\Models\Order::SHIP_STATUS_PENDING ? '#D0D0D0' : '#04B900'}}"
                            >{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
                            <td>{{ \App\Models\Order::$paymentMethodsMap[$order->payment_method] }}</td>
                            <td>{{ \App\Models\Order::$expressMethodsMap[$order->express_company] }}</td>
                            <td>
                              @if($order->ship_status == \App\Models\Order::SHIP_STATUS_DELIVERED || !isset($order->ship_data['express_no']))
                                Ожидайте
                              @elseif(isset($order->ship_data['express_no']))
                                {{ $order->ship_data['express_no'] }}
                                <a href="#" class="c-red d-block">Отследить</a>
                              @endif
                              {{--                                RP2303403402pp <a href="#" class="c-red d-block">Отследить</a>--}}
                            </td>
                            <td>{{ $order->total_amount }} тг.</td>
                          </tr>
                        @endif
                      @empty
                        <tr>
                          <td>Нет автивных заказов</td>
                        </tr>
                      @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection






{{--@extends('layouts.app')--}}
{{--@section('title', 'Список заказов')--}}

{{--@section('content')--}}
{{--<div class="row">--}}
{{--<div class="col-lg-10 offset-lg-1">--}}
{{--<div class="card">--}}
{{--  <div class="card-header">Список заказов</div>--}}
{{--  <div class="card-body">--}}
{{--    <ul class="list-group">--}}
{{--      @foreach($orders as $order)--}}
{{--        <li class="list-group-item">--}}
{{--          <div class="card">--}}
{{--            <div class="card-header">--}}
{{--              Номер заказа：{{ $order->no }}--}}
{{--              <span class="float-right">{{ $order->created_at->format('d.m.Y H:i:s') }}</span>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--              <table class="table">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                  <th>Информация о продукте</th>--}}
{{--                  <th class="text-center">Цена за единицу</th>--}}
{{--                  <th class="text-center">количество</th>--}}
{{--                  <th class="text-center">Общая стоимость заказа</th>--}}
{{--                  <th class="text-center">Состояние заказа</th>--}}
{{--                  <th class="text-center">Операция</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                @foreach($order->items as $index => $item)--}}
{{--                  <tr>--}}
{{--                    <td class="product-info">--}}
{{--                      <div class="preview">--}}
{{--                        <a target="_blank" href="{{ route('products.show', [$item->product_id]) }}">--}}
{{--                          <img src="{{ $item->product->image_url }}">--}}
{{--                        </a>--}}
{{--                      </div>--}}
{{--                      <div>--}}
{{--                        <span class="product-title">--}}
{{--                           <a target="_blank" href="{{ route('products.show', [$item->product_id]) }}">{{ $item->product->title }}</a>--}}
{{--                        </span>--}}
{{--                        <span class="sku-title">{{ $item->productSku->title }}</span>--}}
{{--                      </div>--}}
{{--                    </td>--}}
{{--                    <td class="sku-price text-center">{{ $item->price }} р.</td>--}}
{{--                    <td class="sku-amount text-center">{{ $item->amount }}</td>--}}
{{--                    @if($index === 0)--}}
{{--                      <td rowspan="{{ count($order->items) }}" class="text-center total-amount">{{ $order->total_amount }} р.</td>--}}
{{--                      <td rowspan="{{ count($order->items) }}" class="text-center">--}}
{{--                        @if($order->paid_at)--}}
{{--                          @if($order->refund_status === \App\Models\Order::REFUND_STATUS_PENDING)--}}
{{--                            Оплаченный--}}
{{--                          @else--}}
{{--                            {{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}--}}
{{--                          @endif--}}
{{--                        @elseif($order->closed)--}}
{{--                          Закрыто--}}
{{--                        @else--}}
{{--                          Неоплаченный<br>--}}
{{--                          Пожалуйста, завершите ваш платеж до {{ $order->created_at->addSeconds(config('app.order_ttl'))->format('H:i') }}<br>--}}
{{--                          В противном случае заказ будет закрыт автоматически--}}
{{--                        @endif--}}
{{--                      </td>--}}
{{--                      <td rowspan="{{ count($order->items) }}" class="text-center">--}}
{{--                        <a class="btn btn-primary btn-sm" href="{{ route('orders.show', ['order' => $order->id]) }}">Посмотреть заказ</a>--}}
{{--                        <!-- Оценочный вход начинается -->--}}
{{--                        @if($order->paid_at)--}}
{{--                          <a class="btn btn-success btn-sm" href="{{ route('orders.review.show', ['order' => $order->id]) }}">--}}
{{--                            {{ $order->reviewed ? 'Посмотреть отзывы' : 'Оценить' }}--}}
{{--                          </a>--}}
{{--                        @endif--}}
{{--                        <!-- Конец вступительного экзамена -->--}}
{{--                      </td>--}}
{{--                    @endif--}}
{{--                  </tr>--}}
{{--                @endforeach--}}
{{--              </table>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </li>--}}
{{--      @endforeach--}}
{{--    </ul>--}}
{{--    <div class="float-right">{{ $orders->render() }}</div>--}}
{{--  </div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endsection--}}
