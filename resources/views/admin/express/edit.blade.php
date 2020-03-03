@extends('admin.layouts.app')
@section('title', 'Редактирование купона')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Промокод</h2>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Заказы</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.coupon.index') }}" class="bg-dark px-3 py-2 d-block">Промокоды</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.express.index') }}" class="bg-white px-3 py-2 d-block">Доставка</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Оплата</a></div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ url()->previous() }}" class="h4 d-flex align-content-center"><i class="fal fa-long-arrow-left mr-2"></i> Назад</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.store.express.update', $express->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-4">
                <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0" value="{{ $express->name }}" required>
              </div>
              <div class="col-md-2">
                <select name="cost_type" id="cost_type" class="h-100 w-100 form-control rounded-0">
                  <option value="Настраиваемая" {{ $express->cost_type == 'Настраиваемая' ? 'selected' : null }}>Настраиваемая</option>
                  <option value="0 тг." {{ $express->cost_type == '0 тг.' ? 'selected' : null }}>0 тг.</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="row table-responsive">
              <table class="table text-nowrap">
                <thead>
                  <tr>
                    <th>Название зоны</th>
                    <th>Цена за кг.</th>
                    <th>Цена каждый шаг в кг.</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($express->zones as $zone)
                    <tr class="align-items-center">
                      <td>{{ $zone->name }}</td>
                      <td>{{ cost($zone->cost) }} тг.</td>
                      <td>{{ cost($zone->cost_step) }} тг. / {{ $zone->step }} кг.</td>
                      <td><a href="" class="btn btn-warning border-0 rounded-0">Редактировать</a></td>
                      <td>
                        <form action="{{ route('admin.store.express.destroy', $zone->id) }}" method="post">
                          @csrf
                          @method('delete')
                          <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script !src="">

  </script>
@endsection
