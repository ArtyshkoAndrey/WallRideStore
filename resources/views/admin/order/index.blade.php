@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Магазин</h2>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-auto ml-0 pl-0"><a href="{{ route('admin.store.order.index') }}" class="bg-white px-3 py-2 d-block">Заказы</a></div>
      <div class="col-auto"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Промокоды</a></div>
      <div class="col-auto"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Доставка</a></div>
      <div class="col-auto"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Оплата</a></div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto"><a href="{{ route('admin.store.order.index') }}" class="{{ $type === null ? 'active' : ''}}">Все (100)</a></div>
            <div class="col-auto">
              <a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_PENDING]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_PENDING ? 'active' : ''}}">В обработке (20)</a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_RECEIVED]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_RECEIVED ? 'active' : ''}}">Выполненные (20)</a></div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_PAID]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_PAID ? 'active' : ''}}">Оплачиваются (30)</a></div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_DELIVERED]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_DELIVERED ? 'active' : ''}}">Отпрвленые (30)</a></div>
            <div class="col-auto ml-auto">{{ $orders->onEachSide(1)->links() }}</div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <div class="form-inline">
                <select name="action" class="form-control rounded-0">
                  <option value="delete">Удалить</option>
                  <option value="edit">Редактировать</option>
                </select>
                <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0">Применить</button>
              </div>
            </div>
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <div class="form-inline">
                <select name="time" class="form-control rounded-0">
                  <option value="all">За всё время</option>
                  <option value="year">За год</option>
                  <option value="month">За месяц</option>
                  <option value="week">За неделю</option>
                </select>
              </div>
            </div>
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <div class="form-inline">
                <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск">
                <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0">Найти</button>
              </div>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ \App\Models\Order::all()->count() }} заказов</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>
                <label>
                  <input type="checkbox" name="check_all">
                </label>
              </th>
              <th>User</th>
              <th>Date</th>
              <th>Status</th>
              <th>Reason</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>183</td>
              <td>John Doe</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-success">Approved</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>219</td>
              <td>Alexander Pierce</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-warning">Pending</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>657</td>
              <td>Bob Doe</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-primary">Approved</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>175</td>
              <td>Mike Doe</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-danger">Denied</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>134</td>
              <td>Jim Doe</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-success">Approved</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>494</td>
              <td>Victoria Doe</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-warning">Pending</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>832</td>
              <td>Michael Doe</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-primary">Approved</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>982</td>
              <td>Rocky Doe</td>
              <td>11-7-2014</td>
              <td><span class="tag tag-danger">Denied</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(() => {
      $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
        increaseArea: '20%' // не обязательно
      });
    })
  </script>
@endsection
