@extends('layouts.app')
@section('title', 'Корзина покупок')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-header">Моя корзина</div>
  <div class="card-body">
    <table class="table table-striped">
      <thead>
      <tr>
        <th><input type="checkbox" id="select-all"></th>
        <th>Информация о продукте</th>
        <th>Цена за единицу</th>
        <th>Количество</th>
        <th>Операция</th>
      </tr>
      </thead>
      <tbody class="product_list">
      @foreach($cartItems as $item)
        <tr data-id="{{ $item->productSku->id }}">
          <td>
            <input type="checkbox" name="select" value="{{ $item->productSku->id }}" {{ $item->productSku->product->on_sale ? 'checked' : 'disabled' }}>
          </td>
          <td class="product_info">
            <div class="preview">
              <a target="_blank" href="{{ route('products.show', [$item->productSku->product_id]) }}">
                <img src="{{ $item->productSku->product->image_url }}">
              </a>
            </div>
            <div @if(!$item->productSku->product->on_sale) class="not_on_sale" @endif>
              <span class="product_title">
                <a target="_blank" href="{{ route('products.show', [$item->productSku->product_id]) }}">{{ $item->productSku->product->title }}</a>
              </span>
              <span class="sku_title">{{ $item->productSku->title }}</span>
              @if(!$item->productSku->product->on_sale)
                <span class="warning">Этот продукт был удален</span>
              @endif
            </div>
          </td>
          <td><span class="price">{{ $item->productSku->price }} р.</span></td>
          <td>
            <input type="text" class="form-control form-control-sm amount" @if(!$item->productSku->product->on_sale) disabled @endif name="amount" value="{{ $item->amount }}">
          </td>
          <td>
            <button class="btn btn-sm btn-danger btn-remove">Удалить</button>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    <!-- 开始 -->
    <div>
      <form class="form-horizontal" role="form" id="order-form">
        <div class="form-group row">
          <label class="col-form-label col-sm-3 text-md-right">Выберите адрес доставки</label>
          <div class="col-sm-9 col-md-7">
            <select class="form-control" name="address">
                <option value="{{ $address->id }}">{{ $address->full_address }} {{ $address->contact_name }} {{ $address->contact_phone }}</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-3 text-md-right">Комментарий</label>
          <div class="col-sm-9 col-md-7">
            <textarea name="remark" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <!-- Код купона начинается -->
        <div class="form-group row">
          <label class="col-form-label col-sm-3 text-md-right">Код купона</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="coupon_code">
            <span class="form-text text-muted" id="coupon_desc"></span>
          </div>
          <div class="col-sm-3">
            <button type="button" class="btn btn-success" id="btn-check-coupon">Применить</button>
            <button type="button" class="btn btn-danger" style="display: none;" id="btn-cancel-coupon">Удалить</button>
          </div>
        </div>
        <!-- Код купона заканчивается -->
        <div class="form-group">
          <div class="offset-sm-3 col-sm-3">
            <button type="button" class="btn btn-primary btn-create-order">Заказать</button>
          </div>
        </div>
      </form>
    </div>
    <!-- конец -->
  </div>
</div>
</div>
</div>
@endsection

@section('scriptsAfterJs')
  <script>
    $(document).ready(function () {
      // Прослушайте событие нажатия кнопки удаления
      $('.btn-remove').click(function () {
        // $ (this) может получить объект jQuery нажатой в данный момент кнопки Удалить
        // Метод closest () может получить первый элемент-предок, соответствующий селектору, вот тег <tr> над кнопкой «Удалить», нажатой в данный момент.
        // Метод data ('id') может получить значение атрибута data-id, который мы установили ранее, который является соответствующим идентификатором SKU
        var id = $(this).closest('tr').data('id');
        swal({
          title: "\n" + "Вы уверены, что хотите удалить этот товар?",
          icon: "warning",
          buttons: ['Отменить', 'Удалить'],
          dangerMode: true,
        })
          .then(function(willDelete) {
            // Пользователь нажимает кнопку ОК, значение willDelete будет истинным, иначе ложным
            if (!willDelete) {
              return;
            }
            axios.delete('/cart/' + id)
              .then(function () {
                location.reload();
              })
          });
      });
      // Прослушать выбор всех / отменить выбор всех событий изменения переключателей
      $('#select-all').change(function() {
        // Получить выбранное состояние радиоблока
        // Метод prop () может знать, содержит ли тег определенное свойство. Когда флажок переключателя установлен, соответствующий тег добавит проверенное свойство.
        var checked = $(this).prop('checked');
        // Получить все имя = выбрать без отключенного атрибута勾选框
        // Мы не хотим, чтобы соответствующие флажки выбирались для продуктов, которые были удалены с полок, поэтому нам нужно добавить условие: not ([отключено])
        $('input[name=select][type=checkbox]:not([disabled])').each(function() {
          // Установите его состояние проверки на то же, что и у целевого радиоблока.
          $(this).prop('checked', checked);
        });
      });

      // Прослушайте событие нажатия кнопки создания заказа
      $('.btn-create-order').click(function () {
        // Создайте параметры запроса и запишите в параметры запроса идентификатор и замечания по адресу, выбранному пользователем.
        var req = {
          address_id: $('#order-form').find('select[name=address]').val(),
          items: [],
          remark: $('#order-form').find('textarea[name=remark]').val(),
          coupon_code: $('input[name=coupon_code]').val(), // Получить код скидки из поля ввода кода скидки
        };
        // Выполните итерацию по всем тегам <tr> с атрибутом data-id в теге <table>, то есть по артикулу товара в каждой корзине покупок.
        $('table tr[data-id]').each(function () {
          // Получить радио окно текущего ряда
          var $checkbox = $(this).find('input[name=select][type=checkbox]');
          // Пропустить, если переключатель отключен или не установлен
          if ($checkbox.prop('disabled') || !$checkbox.prop('checked')) {
            return;
          }
          // 获取当前行中数量输入框
          var $input = $(this).find('input[name=amount]');
          // Пропустить, если пользователь устанавливает количество в 0 или не число
          if ($input.val() == 0 || isNaN($input.val())) {
            return;
          }
          // Сохранить идентификатор и количество SKU в массиве параметров запроса
          req.items.push({
            sku_id: $(this).data('id'),
            amount: $input.val(),
          })
        });
        axios.post('{{ route('orders.store') }}', req)
          .then(function (response) {
            swal('\n' + 'Заказ успешно отправлен', '', 'success')
              .then(() => {
                location.href = '/orders/' + response.data.id;
              });
          }, function (error) {
            if (error.response.status === 422) {
              // Код состояния http: 422, что указывает на сбой проверки ввода пользователя
              var html = '<div>';
              _.each(error.response.data.errors, function (errors) {
                _.each(errors, function (error) {
                  html += error+'<br>';
                })
              });
              html += '</div>';
              swal({content: $(html)[0], icon: 'error'})
            } else if (error.response.status === 403) { // Судя по статусу здесь 403
              swal(error.response.data.msg, '', 'error');
            }  else {
              // В других случаях система должна зависать
              swal('Системная ошибка', '', 'error');
            }
          });
      });

      // Проверить событие нажатия кнопки
      $('#btn-check-coupon').click(function () {
        // Получить введенный пользователем код скидки
        var code = $('input[name=coupon_code]').val();
        // Если нет ввода, всплывающее окно
        if(!code) {
          swal('Пожалуйста, введите код скидки', '', 'warning');
          return;
        }
        // Вызов интерфейса проверки
        axios.get('/coupon_codes/' + encodeURIComponent(code))
          .then(function (response) {  // Первым параметром метода then является обратный вызов, который будет вызываться при успешном выполнении запроса
            $('#coupon_desc').text(response.data.description); // Вывод информации о скидках
            $('input[name=coupon_code]').prop('readonly', true); // Отключить поле ввода
            $('#btn-cancel-coupon').show(); // Показать кнопку Отмена
            $('#btn-check-coupon').hide(); // Скрыть кнопку проверки
          }, function (error) {
            // Если код возврата 404, купон не существует
            if(error.response.status === 404) {
              swal('Код купона не существует', '', 'error');
            } else if (error.response.status === 403) {
              // Если код возврата 403, другие условия не выполняются
              swal(error.response.data.msg, '', 'error');
            } else {
              // Другие ошибки
              swal('Внутренняя ошибка системы', '', 'error');
            }
          })
      });

      // Скрыть событие нажатия кнопки
      $('#btn-cancel-coupon').click(function () {
        $('#coupon_desc').text(''); // Скрыть предложение
        $('input[name=coupon_code]').prop('readonly', false);  // Включить поле ввода
        $('#btn-cancel-coupon').hide(); // Скрыть кнопку отмены
        $('#btn-check-coupon').show(); // Показать кнопку проверки
      });

    });
  </script>
@endsection
