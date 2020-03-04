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
          <form action="{{ route('admin.store.express-zone.update', $zone->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-3">
                <input type="text" name="name" id="name" class="form-control rounded-0" value="{{ $zone->name }}" required>
              </div>
              <div class="col-md-3">
                <input type="number" name="cost" id="cost" class="form-control rounded-0" value="{{ $zone->cost }}" required>
              </div>
              <div class="col-md-3">
                <input type="number" name="step" id="step" class="form-control rounded-0" step="0.01" value="{{ $zone->step }}" required>
              </div>
              <div class="col-md-3">
                <input type="number" name="cost_step" id="cost_step" class="form-control rounded-0" value="{{ $zone->cost_step }}" required>
              </div>
            </div>
            <hr>
            <div class="row table-responsive">
              <table class="table text-nowrap">
                <thead>
                <tr>
                  <th>Город</th>
                  <th style="vertical-align: middle" class="d-flex">
                    <input type="button" class="btn ml-auto bg-dark rounded-0" onclick="addColumn()" value="Добавить новый">
                  </th>
                </tr>
                </thead>
                <tbody id="tbody">
                <? $index = 0; ?>
                @foreach($zone->cities as $city)
                  <tr class="align-items-center" id="city-{{ $index }}">
                    <td>
                      <select id="mySelect2" name="city[]" class="w-100 h-100 form-control mySelect{{$index}}">
                          <option value="{{ $city->city_id }}" selected>{{ $city->cityOriginal->name }}</option>
                      </select>
                    </td>
                    <td>
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="onDelete({{ $index}})"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                    </td>
                  </tr>
                  <? $index++; ?>
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
    let index = {{ $index }}
    function addColumn() {
      $('#tbody').prepend(
        '<tr class="align-items-center" id="city-'+index+'">\n' +
        '                    <td>\n' +
        '                      <select id="mySelect2" name="city[]" class="w-100 h-100 form-control mySelect2">\n' +
        '                      </select>\n' +
        '                    </td>\n' +
        '                    <td>\n' +
      '                        <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C"onclick="onDelete('+index+')"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>\n' +
        '                    </td>\n' +
        '                  </tr>'
      )


      $('.mySelect'+index).select2({
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.city', '') }}' + '/' + params.term;
          },
          processResults: function (data) {
            return {
              results: data.items.map((e) => {
                return {
                  text: e.name,
                  id: e.id
                };
              })
            };
          }
        }
      });
      index++;
    }

    function onDelete(index) {
      $('#city-'+index).remove()
      index--;
    }



    $('.mySelect2').select2({
      ajax: {
        type: "POST",
        dataType: 'json',
        url: function (params) {
          return '{{ route('api.city', '') }}' + '/' + params.term;
        },
        processResults: function (data) {
          return {
            results: data.items.map((e) => {
              return {
                text: e.name,
                id: e.id
              };
            })
          };
        }
      }
    });
  </script>
@endsection
