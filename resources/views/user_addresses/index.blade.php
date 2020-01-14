@extends('layouts.app')
@section('title', 'Список адресов доставки')

@section('content')
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div class="card panel-default">
        <div class="card-header">
          Список адресов доставки
          <a href="{{ route('user_addresses.create') }}" class="float-right">Добавить адрес доставки</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Имя</th>
              <th>Адресс</th>
              <th>Почтовый индекс</th>
              <th>Телефон</th>
              <th>Операция</th>
            </tr>
            </thead>
            <tbody>
            @foreach($addresses as $address)
              <tr>
                <td>{{ $address->contact_name }}</td>
                <td>{{ $address->full_address }}</td>
                <td>{{ $address->zip }}</td>
                <td>{{ $address->contact_phone }}</td>
                <td>
                  <a href="{{ route('user_addresses.edit', ['user_address' => $address->id]) }}" class="btn btn-primary">Изменить</a>
                  <!-- Замените форму ранее удаленной кнопки этой кнопкой. Атрибут data-id хранит идентификатор этого адреса, который будет использоваться в js -->
                  <button class="btn btn-danger btn-del-address" type="button" data-id="{{ $address->id }}">Удалить</button>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scriptsAfterJs')
  <script>
    $(document).ready(function() {
      // Удалить событие нажатия кнопки
      $('.btn-del-address').click(function() {
        // Получить значение атрибута data-id на кнопке, который является идентификатором адреса
        var id = $(this).data('id');
        // Позвони подсластителю
        swal({
          title: "\n" + "Подтвердите удаление адреса?",
          icon: "warning",
          buttons: ['Нет', 'Да'],
          dangerMode: true,
        })
          .then(function(willDelete) { // Эта функция обратного вызова будет запущена после того, как пользователь нажмет кнопку
            // Пользователь нажимает кнопку ОК, и значение willDelete равно true, в противном случае - false
            // Пользователь нажал "Отмена" и ничего не сделал
            if (!willDelete) {
              return;
            }
            // Вызовите интерфейс удаления и используйте идентификатор, чтобы склеить запрошенный URL
            axios.delete('/user_addresses/' + id)
              .then(function () {
                // Обновить страницу после успешного запроса
                location.reload();
              })
          });
      });
    });
  </script>
@endsection
