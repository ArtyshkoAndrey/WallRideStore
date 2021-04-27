@extends('user.layouts.app')
@section('title', 'Заказ - ' . $order->no)

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
          <pay-order :order="{{ $order }}" inline-template >
            <transition name="slide-fade" mode="out-in" appear>
              <div class="col-md-9 p-4" v-if="!windowsLoader" key="1">
                <div class="row">
                  <div class="col-12">
                    <h3 class="font-weight-bold">Заказ - {{ $order->no }}</h3>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-12">
                    <h5>
                      Стоимость товаров: {{ number_format($order->price, 0,',', ' ') }} ₸
                    </h5>
                  </div>
                  <div class="col-12">
                    <h5>
                      Стоимость доставки: {{ number_format($order->ship_price, 0,',', ' ') }} ₸
                    </h5>
                  </div>
                  <div class="col-12">
                    <h5>
                      Скидка: {{ number_format($order->sale, 0,',', ' ') }} ₸
                    </h5>
                  </div>
                  <div class="col-12">
                    <h4>
                      Итого: {{ number_format($order->price + $order->ship_price - $order->sale, 0,',', ' ') }} ₸
                    </h4>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-dark" @click="pay">{{ __('Оплатить') }}</button>
                  </div>
                  <div class="col-12 pt-3">
                    <div class="row">
                      @foreach($order->items as $item)
                        <div class="col-md-4">
                          @include('user.layouts.item-view', ['product' => $item->product])
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-9 p-4" v-else key="2">
                <div class="row">
                  <div class="col-12 text-center">
                    <h3><strong>{{ __('Не закрывайте браузер.') }}</strong> {{ __('Ожидаем подтверждения оплаты') }}. {{ __('Иначе он будет отменён') }}</h3>
                  </div>
                </div>
              </div>
            </transition>
          </pay-order>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('js')
  <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
@endsection
