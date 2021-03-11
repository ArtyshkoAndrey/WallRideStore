@extends('user.layouts.app')
@section('title', 'Заказы')

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <section class="container py-5" id="profile">
    <div class="card rounded-0 px-0">
      <div class="card-body px-0 py-0 rounded-0">
        <div class="row mx-0">
          <div class="col-md-3 bg-gray m-0 p-0">
            <div class="nav flex-column nav-pills h-100 m-0" role="tablist" aria-orientation="vertical">
              <a class="nav-link border-0 rounded-0 py-4" href="{{ route('profile.index') }}" aria-selected="true"><i class="bx bx-user bx-sm pr-1"></i> Мой профиль</a>
              <a class="nav-link active border-0 rounded-0 py-4" href="{{ route('order.index') }}" aria-selected="true"><i class="bx bx-list-ol bx-sm pr-1"></i> Мои заказы</a>
            </div>
          </div>
          <div class="col-md-9 p-4">
            <div class="row">
              <div class="col-12">
                <h3 class="font-weight-bold">Мои Заказы</h3>
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
                        @forelse($orders->where('ship_status', '!=', \App\Models\Order::SHIP_STATUS_RECEIVED) as $order)
                            <tr>
                              <th scope="row">{{ $order->no }}</th>
                              <td>{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
                              <td>{{ \App\Models\Order::$paymentMethodsMap[$order->payment_method] }}</td>
                              <td>{{ \App\Models\Order::$transferMethodsMap[$order->transfer] }}</td>
                              <td>{{ $order->ship_data->track ?? 'Нет данных' }}</td>
                              <td>{{ number_format($order->price + $order->ship_price - $order->sale, 0,',', ' ') }} ₸</td>
                            </tr>
                        @empty
                          <tr>
                            <td colspan="6">Нет заказов</td>
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
                        @forelse($orders->where('ship_status', '=', \App\Models\Order::SHIP_STATUS_RECEIVED) as $order)
                          <tr>
                            <th scope="row">{{ $order->no }}</th>
                            <td>{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
                            <td>{{ \App\Models\Order::$paymentMethodsMap[$order->payment_method] }}</td>
                            <td>{{ \App\Models\Order::$transferMethodsMap[$order->transfer] }}</td>
                            <td>{{ $order->ship_data->track ?? 'Нет данных' }}</td>
                            <td>{{ number_format($order->price + $order->ship_price - $order->sale, 0,',', ' ') }} ₸</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="6">Нет заказов</td>
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

@section('js')
@endsection
