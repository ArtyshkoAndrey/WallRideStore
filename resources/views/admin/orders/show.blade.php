<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Номер заказа：{{ $order->no }}</h3>
    <div class="box-tools">
      <div class="btn-group float-right" style="margin-right: 10px">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 列表</a>
      </div>
    </div>
  </div>
  <div class="box-body">
    <table class="table table-bordered">
      <tbody>
      <tr>
        <td>Покупатель：</td>
        <td>{{ $order->user->name }}</td>
        <td>Время оплаты：</td>
        <td>{{ $order->paid_at->format('d.m.Y H:i:s') }}</td>
      </tr>
      <tr>
        <td>Способ оплаты：</td>
        <td>{{ $order->payment_method }}</td>
        <td>Номер канала оплаты：</td>
        <td>{{ $order->payment_no }}</td>
      </tr>
      <tr>
        <td>Адрес доставки</td>
        <td colspan="3">{{ $order->address['address'] }} {{ $order->address['zip'] }} {{ $order->address['contact_name'] }} {{ $order->address['contact_phone'] }}</td>
      </tr>
      <tr>
        <td rowspan="{{ $order->items->count() + 1 }}">Список продуктов</td>
        <td>Название товара</td>
        <td>Цена за единицу</td>
        <td>Количество</td>
      </tr>
      @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product->title }} {{ $item->productSku->title }}</td>
          <td>￥{{ $item->price }}</td>
          <td>{{ $item->amount }}</td>
        </tr>
      @endforeach
      <tr>
        <td>Сумма заказа：</td>
        <td>{{ $order->total_amount }} р</td>
        <td>Статус доставки：</td>
        <td>{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
      </tr>
      <!-- Доставка заказа началась -->
      <!-- Если заказ не отправлен, отобразите форму доставки -->
      @if($order->ship_status === \App\Models\Order::SHIP_STATUS_PENDING)
        <!-- Плюс это условие суда -->
        @if($order->refund_status !== \App\Models\Order::REFUND_STATUS_SUCCESS)
        <tr>
          <td colspan="4">
            <form action="{{ route('admin.orders.ship', [$order->id]) }}" method="post" class="form-inline">
              <!-- Не забудьте поле токена csrf -->
              {{ csrf_field() }}
              <div class="form-group {{ $errors->has('express_company') ? 'has-error' : '' }}">
                <label for="express_company" class="control-label">Логистическая компания</label>
                <input type="text" id="express_company" name="express_company" value="" class="form-control" placeholder="Введите логистическую компанию">
                @if($errors->has('express_company'))
                  @foreach($errors->get('express_company') as $msg)
                    <span class="help-block">{{ $msg }}</span>
                  @endforeach
                @endif
              </div>
              <div class="form-group {{ $errors->has('express_no') ? 'has-error' : '' }}">
                <label for="express_no" class="control-label">Логистический номер</label>
                <input type="text" id="express_no" name="express_no" value="" class="form-control" placeholder="Введите номер логистической заметки">
                @if($errors->has('express_no'))
                  @foreach($errors->get('express_no') as $msg)
                    <span class="help-block">{{ $msg }}</span>
                  @endforeach
                @endif
              </div>
              <button type="submit" class="btn btn-success" id="ship-btn">Сохранить</button>
            </form>
          </td>
        </tr>
        <!-- Поместите endif перед остальным предыдущим, если -->
        @endif
      @else
        <!-- В противном случае отобразите логистическую компанию и номер заказа логистики. -->
        <tr>
          <td>Логистическая компания：</td>
          <td>{{ $order->ship_data['express_company'] }}</td>
          <td>Логистический номер：</td>
          <td>{{ $order->ship_data['express_no'] }}</td>
        </tr>
      @endif
      <!-- Конец доставки заказа -->
      @if($order->refund_status !== \App\Models\Order::REFUND_STATUS_PENDING)
        <tr>
          <td>Статус возврата：</td>
          <td colspan="2">{{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}, причина：{{ $order->extra['refund_reason'] }}</td>
          <td>
            <!-- Если статус возврата заказа применяется, показать кнопку обработки-->
            @if($order->refund_status === \App\Models\Order::REFUND_STATUS_APPLIED)
              <button class="btn btn-sm btn-success" id="btn-refund-agree">Согласиться</button>
              <button class="btn btn-sm btn-danger" id="btn-refund-disagree">Не согласиться</button>
            @endif
          </td>
        </tr>
      @endif
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Не соглашаться на событие нажатия кнопки
    $('#btn-refund-disagree').click(function() {
      // Версия SweetAlert, используемая Laravel-Admin, отличается от версии, которую мы использовали на переднем плане, поэтому параметры также отличаются
      swal({
        title: 'Укажите причину отказа в возврате',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: "Подтверждение\n",
        cancelButtonText: "Отменен",
        showLoaderOnConfirm: true,
        preConfirm: function(inputValue) {
          if (!inputValue) {
            swal('Причина не может быть пустой', '', 'error')
            return false;
          }
          // Laravel-Admin не имеет axios и использует ajax-метод jQuery для запроса
          return $.ajax({
            url: '{{ route('admin.orders.handle_refund', [$order->id]) }}',
            type: 'POST',
            data: JSON.stringify({   // Превратить запрос в строку JSON
              agree: false,  // Отклонить заявку
              reason: inputValue,
              // Принесите токен CSRF
              // Страница администратора Laravel может получить токен CSRF через LA.token
              _token: LA.token,
            }),
            contentType: 'application/json',  // Запрашиваемый формат данных - JSON
          });
        },
        allowOutsideClick: () => !swal.isLoading()
      }).then(function (ret) {
        // Если пользователь нажимает кнопку «Отмена», никаких действий не предпринимается.
        if (ret.dismiss === 'cancel') {
          return;
        }
        swal({
          title: 'Операция прошла успешно',
          type: 'success'
        }).then(function() {
          // Обновить страницу, когда пользователь нажимает кнопку на Swal
          location.reload();
        });
      });
    });

    // Нажмите кнопку подтверждения события
    $('#btn-refund-agree').click(function() {
      swal({
        title: 'Вы уверены, что хотите вернуть деньги пользователю?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "Подтверждение",
        cancelButtonText: "Отмена",
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return $.ajax({
            url: '{{ route('admin.orders.handle_refund', [$order->id]) }}',
            type: 'POST',
            data: JSON.stringify({
              agree: true, // Согласен вернуть
              _token: LA.token,
            }),
            contentType: 'application/json',
          });
        }
      }).then(function (ret) {
        // Если пользователь нажимает кнопку «Отмена», никаких действий не предпринимается.
        if (ret.dismiss === 'cancel') {
          return;
        }
        swal({
          title: 'Операция прошла успешно',
          type: 'success'
        }).then(function() {
          // Обновить страницу, когда пользователь нажимает кнопку на Swal
          location.reload();
        });
      });
    });

  });
</script>
