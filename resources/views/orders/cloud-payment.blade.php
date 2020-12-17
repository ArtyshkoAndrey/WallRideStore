@extends('layouts.app')
@section('title', 'Оплата заказа')

@section('content')
  <section class="container mt-5 pt-5 mb-5" id="cart">
    <div class="row mt-4">
      <div class="col-12">
        <div class="row">
          <div class="col-12">
            <h1 class="font-weight-bold">Оплата заказа № {{ $order->no }}</h1>
            <h4>Сервис: CloudPayment</h4>
          </div>
          <div class="col-12">
            <div class="card mt-3">
              <div class="card-body">
                @if ($order->paid_at)
                  <div class="row">
                    <div class="col-12">
                      <h3>Заказ уже оплачен</h3>
                    </div>
                  </div>
                @elseif ($order->ship_status == 'cancel')
                  <div class="row">
                    <div class="col-12">
                      <h3>Заказ был отменён</h3>
                    </div>
                  </div>
                @else
                  <div class="row">
                    <div class="col-12">
                      <p class="h4">Стоимость товаров: {{ $order->total_amount }} ₸</p>
                      <p class="h4">Стоимость доставки: {{ $order->ship_price }} ₸</p>
                      <p class="h4">Итого: {{ $order->total_amount + $order->ship_price }} ₸</p>
                    </div>
                    <div class="col-12 mt-2">
                      <h3>Товары:</h3>
                    </div>
                    <div class="col-md-8">
                      @foreach($order->items as $item)
                        <div class="row mt-3 justify-content-center align-items-center">
                          <div class="col-md-2 offset-md-1 col-4">
                            <img src="{{ $item->product->photos && count($item->product->photos) > 0 ? asset('storage/products/' . $item->product->photos[0]->name) : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png' }}" class="img-fluid" alt="{{ $item->product->title }}">
                          </div>
                          <div class="col-4 col-md-4">
                            {{ ucwords(strtolower($item->product->title)) }}
                          </div>
                          <div class="col-4 col-md text-center font-weight-bold">
                            {{ (int) ($item->product->on_sale ? $item->product->price_sale : $item->product->price) . ' ₸'}} X {{ $item->amount }}
                          </div>
                        </div>
                      @endforeach
                    </div>
                    <div class="col-12 mt-5">
                      <button class="btn btn-dark rounded-0" onclick="pay()">Оплатить картой</button>
                      <small class="d-block">Если после нажатия кнопки выйдите из оплаты не доконца оплачивая товар. то Ваш заказ отмениться</small>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')
  <script>

    let pay = function () {
      let widget = new cp.CloudPayments();
      widget.pay('charge', // или 'charge'
        { //options
          publicId: 'pk_4180963d51ddacba2982452f72f00', //id из личного кабинета
          description: 'Оплата товаров в wallridestore.com', //назначение
          amount: {{ $order->total_amount + $order->ship_price }}, //сумма
          currency: 'KZT', //валюта
          invoiceId: {{ $order->no }}, //номер заказа  (необязательно)
          accountId: "{{ $data['userEmail'] }}", //идентификатор плательщика (необязательно)
          skin: "modern", //дизайн виджета (необязательно)
          data: {
            userName: "{{ $data['userName'] }}"
          }
        },
        {
          onSuccess: function (options) { // success
            //действие при успешной оплате
            console.log('success')
            console.log(options)
            axios.post('/orders/success/' + {{ $order->id}})
              .then(response => {
                swal({
                  icon: 'success',
                  title: 'Упс...',
                  text: 'Вы оплатили заказ',
                })
                .then(() => {
                  window.location = "{{ route('orders.index') }}"
                });
              })
              .catch(error => {
                swal({
                  icon: 'error',
                  title: 'Упс...',
                  text: 'Произошла ошибка, обратитесь к администратору',
                })
              })
          },
          onFail: function (reason, options) { // fail
            console.log('fail')
            console.log(reason, options)
            swal({
              icon: 'warning',
              title: 'Упс...',
              text: 'Вы не оплатили заказ. Попробуйте ещё раз',
            })
            {{--axios.post('/orders/close/' + {{ $order->id}})--}}
            {{--.then(response => {--}}
            {{--  swal({--}}
            {{--    icon: 'error',--}}
            {{--    title: 'Упс...',--}}
            {{--    text: 'Вы не оплатили заказ. Вы будите ',--}}
            {{--  })--}}
            {{--    .then(() => {--}}
            {{--      window.location = "{{ route('orders.index') }}"--}}
            {{--    });--}}
            {{--})--}}
            {{--.catch(error => {--}}
            {{--  swal({--}}
            {{--    icon: 'error',--}}
            {{--    title: 'Упс...',--}}
            {{--    text: 'Произошла ошибка, обратитесь к администратору',--}}
            {{--  })--}}
            {{--})--}}
          },
          onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
            //например вызов вашей аналитики Facebook Pixel
            console.log('complete')
            console.log(paymentResult, options)
          }
        }
      )
    };
  </script>
@endsection


@section('headerScript')
  <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
@endsection
