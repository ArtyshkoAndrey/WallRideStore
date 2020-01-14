@extends('layouts.app')
@section('title', $product->title)

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body product-info">
    <div class="row">
      <div class="col-5">
        <img class="cover" src="{{ $product->image_url }}" alt="">
      </div>
      <div class="col-7">
        <div class="title">{{ $product->title }}</div>
        <div class="price"><label>Цена</label><span>{{ $product->price }}</span> <em>р.</em></div>
        <div class="sales_and_reviews">
          <div class="sold_count">Продаж <span class="count">{{ $product->sold_count }} шт.</span></div>
          <div class="review_count">Оценок <span class="count">{{ $product->review_count }}</span></div>
          <div class="rating" title="Оценка {{ $product->rating }}">Средняя оценка <span class="count">{{ str_repeat('★', floor($product->rating)) }}{{ str_repeat('☆', 5 - floor($product->rating)) }}</span></div>
        </div>
        <div class="skus">
          <label>Выбрать</label>
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            @foreach($product->skus as $sku)
              <label
                  class="btn sku-btn"
                  data-price="{{ $sku->price }}"
                  data-stock="{{ $sku->stock }}"
                  data-toggle="tooltip"
                  title="{{ $sku->description }}"
                  data-placement="bottom">
                <input type="radio" name="skus" autocomplete="off" value="{{ $sku->id }}"> {{ $sku->title }}
              </label>
            @endforeach
          </div>
        </div>
        <div class="cart_amount">
          <label>Кол-во</label>
          <input type="text" class="form-control form-control-sm" value="1">
          <span>шт.</span>
          <span class="stock"></span>
        </div>
        <div class="buttons">
          @if($favored)
            <button class="btn btn-danger btn-disfavor">Убрать из избранных</button>
          @else
            <button class="btn btn-success btn-favor">❤ В избранные</button>
          @endif
          <button class="btn btn-primary btn-add-to-cart">Добавить в корзину</button>
        </div>
      </div>
    </div>
    <div class="product-detail">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#product-detail-tab" aria-controls="product-detail-tab" role="tab" data-toggle="tab" aria-selected="true">Детали продукта</a>
        </li>
        @if(count($reviews) > 0)
        <li class="nav-item">
          <a class="nav-link" href="#product-reviews-tab" aria-controls="product-reviews-tab" role="tab" data-toggle="tab" aria-selected="false">Оценки пользователей</a>
        </li>
        @endif
      </ul>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
          {!! $product->description !!}
        </div>
        @if(count($reviews) > 0)
        <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
          <!-- Список комментариев начинается -->
          <table class="table table-bordered table-striped">
            <thead>
            <tr>
              <td>Пользователь</td>
              <td>Вид товара</td>
              <td>Оценка</td>
              <td>Текст</td>
              <td>Добавлено</td>
            </tr>
            </thead>
            <tbody>
            @foreach($reviews as $review)
              <tr>
                <td>{{ $review->order->user->name }}</td>
                <td>{{ $review->productSku->title }}</td>
                <td>{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                <td>{{ $review->review }}</td>
                <td>{{ $review->reviewed_at->format('d.m.Y') }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
          <!-- Конец списка комментариев -->
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
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
      $('.sku-btn').click(function () {
        $('.product-info .price span').text($(this).data('price'));
        $('.product-info .stock').text('В наличии：' + $(this).data('stock') + 'шт.');
      });

      // Слушайте события нажатия на любимые кнопки
      $('.btn-favor').click(function () {
        // нициируйте запрос post ajax. URL запроса генерируется функцией backend route ().
        axios.post('{{ route('products.favor', ['product' => $product->id]) }}')
          .then(function () { // 请求成功会执行这个回调
            swal('Операция прошла успешно', '', 'success')
              .then(function () { // здесь добавлен метод then ()
                location.reload();
              });
          }, function(error) { // Этот обратный вызов будет выполнен в случае сбоя запроса
            // Если код возврата 401, вы не авторизованы
            if (error.response && error.response.status === 401) {
              swal('Пожалуйста, войдите сначала', '', 'error');
            } else if (error.response && error.response.data.msg) {
              // В других случаях с полем msg, отправьте сообщение пользователю
              swal(error.response.data.msg, '', 'error');
            }  else {
              // В других случаях система должна зависать
              swal('Системная ошибка', '', 'error');
            }
          });
      });

      $('.btn-disfavor').click(function () {
        axios.delete('{{ route('products.disfavor', ['product' => $product->id]) }}')
          .then(function () {
            swal('Операция прошла успешно', '', 'success')
              .then(function () {
                location.reload();
              });
          });
      });

      // Добавить в корзину событие нажатия кнопки
      $('.btn-add-to-cart').click(function () {

        // Запрос на добавление в интерфейс корзины покупок
        axios.post('{{ route('cart.add') }}', {
          sku_id: $('label.active input[name=skus]').val(),
          amount: $('.cart_amount input').val(),
        })
          .then(function () { // Запрос успешно выполнил этот обратный вызов
            swal('Добавить в корзину успех', '', 'success')
              .then(function() {
                location.href = '{{ route('cart.index') }}';
              });
          }, function (error) { // Запрос не смог выполнить этот обратный вызов
            if (error.response.status === 401) {

              // код статуса http 401, пользователь не авторизован
              swal('Пожалуйста, войдите сначала', '', 'error');

            } else if (error.response.status === 422) {

              // Код состояния http: 422, что указывает на сбой проверки ввода пользователя.
              var html = '<div>';
              _.each(error.response.data.errors, function (errors) {
                _.each(errors, function (error) {
                  html += error+'<br>';
                })
              });
              html += '</div>';
              swal({content: $(html)[0], icon: 'error'})
            } else {

              // В других случаях система должна зависать
              swal('Системная ошибка', '', 'error');
            }
          })
      });

    });
  </script>
@endsection
