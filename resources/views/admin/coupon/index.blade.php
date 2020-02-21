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
      <div class="col-auto ml-0 pl-0"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Заказы</a></div>
      <div class="col-auto"><a href="{{ route('admin.store.coupon.index') }}" class="bg-white px-3 py-2 d-block">Промокоды</a></div>
      <div class="col-auto"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Доставка</a></div>
      <div class="col-auto"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Оплата</a></div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ route('admin.store.coupon.index') }}" class="{{ ($filters['type'] === null || $filters['type'] === 'all') ? 'active' : ''}}">
                Все ({{App\Models\CouponCode::count()}})
              </a>
            </div>
            <div class="col-auto">
              <a href="{{ route('admin.store.coupon.index', ['type' => 'enabled']) }}" class="{{ $type === 'enabled' ? 'active' : ''}}">
                Опубликованные ({{App\Models\CouponCode::where('enabled', 1)->count()}})
              </a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_RECEIVED]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_RECEIVED ? 'active' : ''}}">
                Удаленные ({{App\Models\CouponCode::where('enabled', 0)->count()}})
              </a>
            </div>
            </div>
            <div class="col-auto ml-auto">{{ $coupons->appends($filters)->render() }}</div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <div class="form-inline">
                <select name="action" class="form-control rounded-0">
                  <option value="delete">Удалить</option>
                  <option value="edit">Редактировать</option>
                </select>
                <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" id="action">Применить</button>
              </div>
            </div>
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.store.order.index') }}" name="form-time" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{$filters['type']}}">
                  <input type="hidden" name="search" value="{{$filters['search']}}">
                </div>
              </form>
            </div>
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.store.order.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{$filters['type']}}">
                  <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск" value="{{ $filters['search'] }}">
                  <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" type="submit">Найти</button>
                </div>
              </form>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ \App\Models\CouponCode::all()->count() }} заказов</p>
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
            </tr>
            </thead>
            <tbody>
            @forelse($coupones as $coupon)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><input type="checkbox" meta-order-id="{{ $coupon->id }}" class="check-to-order"></td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">Нет заказов</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')

@endsection
