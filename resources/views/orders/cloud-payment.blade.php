@extends('layouts.app')
@section('title', 'Оплата заказа')

@section('content')
  <button class="mt-5" onclick="pay()">
    Оплатить
  </button>
@endsection

@section('scriptsAfterJs')
  <script>

    let widget = new cp.CloudPayments();
    let pay = function () {
      widget.pay('charge', // или 'charge'
        { //options
          publicId: 'pk_4180963d51ddacba2982452f72f00', //id из личного кабинета
          description: 'Оплата товаров в example.com', //назначение
          amount: 100, //сумма
          currency: 'RUB', //валюта
          invoiceId: '1234567', //номер заказа  (необязательно)
          accountId: 'user@example.com', //идентификатор плательщика (необязательно)
          skin: "modern", //дизайн виджета (необязательно)
          data: {
            myProp: 'myProp value'
          }
        },
        {
          onSuccess: function (options) { // success
            //действие при успешной оплате
          },
          onFail: function (reason, options) { // fail
            //действие при неуспешной оплате
          },
          onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
            //например вызов вашей аналитики Facebook Pixel
          }
        }
      )
    };
  </script>
@endsection


@section('headerScript')
  <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
@endsection
