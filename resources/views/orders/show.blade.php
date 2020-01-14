@extends('layouts.app')
@section('title', 'Посмотреть заказ')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-header">
    <h4>Детали заказа</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
      <tr>
        <th>Информация о продукте</th>
        <th class="text-center">Цена за единицу</th>
        <th class="text-center">Количество</th>
        <th class="text-right item-amount">Адрес доставки</th>
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
          <td class="sku-price text-center vertical-middle">{{ $item->price }} р.</td>
          <td class="sku-amount text-center vertical-middle">{{ $item->amount }}</td>
          <td class="item-amount text-right vertical-middle">{{ number_format($item->price * $item->amount, 2, '.', '') }} р.</td>
        </tr>
      @endforeach
      <tr><td colspan="4"></td></tr>
    </table>
    <div class="order-bottom">
      <div class="order-info">
        <div class="line"><div class="line-label">Адрес доставки：</div><div class="line-value">{{ join(' ', $order->address) }}</div></div>
        <div class="line"><div class="line-label">Комментарий：</div><div class="line-value">{{ $order->remark ?: '-' }}</div></div>
        <div class="line"><div class="line-label">Номер заказа：</div><div class="line-value">{{ $order->no }}</div></div>
        <!-- 输出物流状态 -->
        <div class="line">
          <div class="line-label">Логистический статус：</div>
          <div class="line-value">{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</div>
        </div>
        <!-- Показать, есть ли логистическая информация -->
        @if($order->ship_data)
          <div class="line">
            <div class="line-label">Логистическая информация：</div>
            <div class="line-value">{{ $order->ship_data['express_company'] }} {{ $order->ship_data['express_no'] }}</div>
          </div>
        @endif
        <!-- Отображение информации о возврате, когда заказ был оплачен, и статус возврата не возвращается -->
        @if($order->paid_at && $order->refund_status !== \App\Models\Order::REFUND_STATUS_PENDING)
          <div class="line">
            <div class="line-label">Статус возврата：</div>
            <div class="line-value">{{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}</div>
          </div>
          <div class="line">
            <div class="line-label">Причина возврата：</div>
            <div class="line-value">{{ $order->extra['refund_reason'] }}</div>
          </div>
        @endif
      </div>
      <div class="order-summary text-right">
        <!-- Показать информацию о начале предложения -->
        @if($order->couponCode)
          <div class="text-primary">
            <span>Информация о предложении：</span>
            <div class="value">{{ $order->couponCode->description }}</div>
          </div>
        @endif
        <!-- Конец показа предложений -->
        <div class="total-amount">
          <span>Общая стоимость заказа：</span>
          <div class="value">{{ $order->total_amount }} р.</div>
        </div>
        <div>
          <span>Статус заказа：</span>
          <div class="value">
            @if($order->paid_at)
              @if($order->refund_status === \App\Models\Order::REFUND_STATUS_PENDING)
                Оплаченный
              @else
                {{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}
              @endif
            @elseif($order->closed)
              Закрыто
            @else
              Неоплаченный
            @endif
          </div>
          @if(isset($order->extra['refund_disagree_reason']))
            <div>
              <span>Причина отказа в возврате：</span>
              <div class="value">{{ $order->extra['refund_disagree_reason'] }}</div>
            </div>
          @endif
        </div>
        <!-- Запуск кнопки оплаты -->
        @if(!$order->paid_at && !$order->closed)
          <div class="payment-buttons">
            <a class="btn btn-primary btn-sm" href="{{ route('payment.alipay', ['order' => $order->id]) }}">Alipay платеж</a>
            <!-- Замените предыдущую кнопку оплаты WeChat этим -->
            <button class="btn btn-sm btn-success" id='btn-wechat'>WeChat оплаты</button>
          </div>
        @endif
        <!-- Кнопка окончания платежа -->
        <!-- Если статус доставки заказа отправлен, отображается кнопка «Подтвердить получение». -->
        @if($order->ship_status === \App\Models\Order::SHIP_STATUS_DELIVERED)
          <div class="receive-button">
            <button type="button" id="btn-receive" class="btn btn-sm btn-success">Подтвердите получение</button>
          </div>
        @endif
        <!-- Показать кнопку запроса на возврат, когда заказ оплачен и статус возврата не возвращен -->
        @if($order->paid_at && $order->refund_status === \App\Models\Order::REFUND_STATUS_PENDING)
          <div class="refund-button">
            <button class="btn btn-sm btn-danger" id="btn-apply-refund">Запросить возврат</button>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection

@section('scriptsAfterJs')
  <script>
    $(document).ready(function() {
      // WeChat кнопка оплаты вещь
      $('#btn-wechat').click(function() {
        swal({
          // Параметр содержимого может быть элементом DOM, здесь мы используем jQuery для динамической генерации тега img и получения элемента DOM с помощью метода [0].
          content: $('<img src="{{ route('payment.wechat', ['order' => $order->id]) }}" />')[0],
          // Параметр кнопок может установить текст, отображаемый кнопкой
          buttons: ['близко', '\n' + 'Платеж завершен'],
        })
          .then(function(result) {
            // Если пользователь нажимает кнопку «Завершенный платеж», страница перезагружается.
            if (result) {
              location.reload();
            }
          })
      });
      // Подтвердите квитанцию ​​о нажатии кнопки
      $('#btn-receive').click(function() {
        // Всплывающее окно подтверждения
        swal({
          title: "Подтвердить, что товар был получен?",
          icon: "warning",
          dangerMode: true,
          buttons: ['Нет', 'Да'],
        })
          .then(function(ret) {
            // Ничего не делать, если вы нажмете кнопку Отмена
            if (!ret) {
              return;
            }
            // операция подтверждения фиксации ajax
            axios.post('{{ route('orders.received', [$order->id]) }}')
              .then(function () {
                // Обновить страницу
                location.reload();
              })
          });
      });
      // Возврат нажатием кнопки
      $('#btn-apply-refund').click(function () {
        swal({
          text: 'Пожалуйста, введите причину возврата',
          content: "input",
        }).then(function (input) {
          // Эта функция срабатывает, когда пользователь нажимает кнопку во всплывающем окне "ласточка"
          if(!input) {
            swal('\n' + 'Причина возврата не может быть пустой', '', 'error');
            return;
          }
          // 请求退款接口
          axios.post('{{ route('orders.apply_refund', [$order->id]) }}', {reason: input})
            .then(function () {
              swal('Успешный запрос на возврат', '', 'success').then(function () {
                // Перезагрузите страницу, когда пользователь нажимает кнопку во всплывающем окне
                location.reload();
              });
            });
        });
      });

    });
  </script>
@endsection
