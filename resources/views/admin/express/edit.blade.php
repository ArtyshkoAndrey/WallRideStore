@extends('admin.layouts.app')

@section('title', 'Редактирование компании доставки')

@section('css')

@endsection

@section('content')

  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('admin.express.index') }}">Компании доставки</a>
            </li>
            <li class="breadcrumb-item active">Редактирование компании доставки</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Редактирование компании доставки</h3>
      </div>
      @if ($errors->any())
        <div class="col-12">
          <div class="card bg-dark-dm">
            <div class="invalid-feedback d-block">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endif

      <div class="col-12 d-flex">
        <a href="{{ route('admin.express-zone.create') }}" class="btn bg-secondary text-dark-dm">Создать новую зону</a>
      </div>
      <div class="col-12 p-0">
        <form action="{{ route('admin.express.update', $express->id) }}" method="POST" class="w-full">
          @csrf
          @method('PUT')
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="row row-eq-spacing-sm m-0 p-0">

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="name" class="required">Наименование</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Наименование" value="{{ old('name', $express->name) }}" required>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="description" class="required">Краткое описание</label>
                      <input type="text" class="form-control" name="description" id="description" placeholder="Описание" value="{{ old('description', $express->description) }}" required>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="track_url" class="required">Ссылка на отслеживание (на конеце '/')</label>
                      <input type="text" class="form-control" name="track_url" id="track_url" placeholder="Ссылка на отслеживание (на конеце '/')" value="{{ old('track_url', $express->track_url) }}" required>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="min_cost" class="required">Минимальная стоимость</label>
                      <input type="number" class="form-control" name="min_cost" id="min_cost" placeholder="Минимальная стоимость" value="{{ old('min_cost', $express->min_cost) }}" required>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="enabled" value="0"><!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                      <input type="checkbox" name="enabled" id="enabled" value="1" {{ old('enabled', $express->enabled) ? 'checked' : null }}>
                      <label for="enabled" class="text-danger">Использовать</label>
                    </div>
                  </div>

                  <div class="col-12 mt-10">
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="enabled_cash" value="0"><!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                      <input type="checkbox" name="enabled_cash" id="enabled_cash" value="1" {{ old('enabled_cash', $express->enabled_cash) ? 'checked' : null }}>
                      <label for="enabled_cash" class="text-danger">Наличные</label>
                    </div>
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="enabled_card" value="0">
                      <input type="checkbox" name="enabled_card" id="enabled_card" value="1" {{ old('enabled_card', $express->enabled_card) ? 'checked' : null }}>
                      <label for="enabled_card">Картой</label>
                    </div>
                  </div>



                  <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit">Сохранить</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

        <div class="row row-eq-spacing p-0 m-0">

          <div class="col-12 col-lg mt-10">
            <div class="card bg-dark-dm">

              @if(count($express->zones) > 0 && $express->zones[0]->step_cost_array === null)

                <table class="table">
                  <thead>
                  <tr>
                    <th>Название зоны</th>
                    <th>Цена за 0.5 кг.</th>
                    <th>Цена каждый шаг в кг.</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($express->zones as $zone)
                    <tr class="align-items-center">
                      {{--                      TODO: Ссылка на редактирование зоны --}}
                      <td>
                        <a href="{{ route('admin.express-zone.edit', $zone->id) }}" class="text-danger">
                          {{ $zone->name }}
                        </a>
                      </td>
                      <td>{{ number_format($zone->cost, 0,',', ' ') }} ₸</td>
                      <td>{{ number_format($zone->cost_step, 0,',', ' ') }} ₸ / {{ $zone->step }} кг.</td>
                      <td><a href="{{ route('admin.express-zone.edit', $zone->id) }}" class="btn btn-secondary">Редактировать</a></td>
                      <td>
                        <form action="{{ route('admin.express-zone.destroy', $zone->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn bg-transparent border-0 shadow-none rounded-0" style="color: #F33C3C" type="submit">
                            <i style="font-size: 1.5rem" class="bx bx-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>

              @else

                <table class="table">
                  <thead>
                  <tr>
                    <th>Название зоны</th>
                    <th>Цена первого шага</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($express->zones as $zone)
                    <tr>
                      <td>
                        <a href="{{ route('admin.express-zone.edit', $zone->id) }}" class="text-danger">
                          {{ $zone->name }}
                        </a>
                      </td>
                      <td>{{ number_format(count($zone->step_cost_array) > 0 ? $zone->step_cost_array[0]['cost'] : 0, 0,',', ' ') }} ₸</td>
                      <td><a href="{{ route('admin.express-zone.edit', $zone->id) }}" class="btn btn-secondary">Редактировать</a></td>
                      <td>
                        <form action="{{ route('admin.express-zone.destroy', $zone->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn bg-transparent border-0 shadow-none rounded-0" style="color: #F33C3C" type="submit">
                            <i style="font-size: 1.5rem" class="bx bx-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>

              @endif


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')

@endsection
