@extends('admin.layouts.app')
@section('title', 'Редактирование зоны доставки')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Зона доставки</h2>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Заказы</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.coupon.index') }}" class="bg-dark px-3 py-2 d-block">Промокоды</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.express.index') }}" class="bg-white px-3 py-2 d-block">Доставка</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Оплата</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.reports.index') }}" class="bg-dark px-3 py-2 d-block">Отчеты</a></div>
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
              <div class="col-md">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $zone->name }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md">
                <label for="cost">Стоимость</label>
                <input type="number" name="cost" id="cost" class="form-control rounded-0 {{ $errors->has('cost') ? ' is-invalid' : '' }}" value="{{ $zone->cost }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost') }}</span>
              </div>
              <div class="col-md">
                <label for="step">Шаг</label>
                <input type="number" name="step" id="step" class="form-control rounded-0 {{ $errors->has('step') ? ' is-invalid' : '' }}" step="0.01" value="{{ $zone->step }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('step') }}</span>
              </div>
              <div class="col-md">
                <label for="cost_step">Стоимость шага</label>
                <input type="number" name="cost_step" id="cost_step" class="form-control rounded-0 {{ $errors->has('cost_step') ? ' is-invalid' : '' }}" value="{{ $zone->cost_step }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost_step') }}</span>
              </div>
              <div class="col-md">
                <label for="company_id">Компания</label>
                <select name="company_id" class="form-control rounded-0 {{ $errors->has('company_id') ? ' is-invalid' : '' }}" id="company">
                  @foreach(App\Models\ExpressCompany::where('cost_type', 'Настраиваемая')->get() as $company)
                    <option value="{{$company->id}}" {{$zone->company->id == $company->id ? 'selected' : null}}>{{$company->name}}</option>
                  @endforeach
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('company_id') }}</span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <select name="city" id="city" class="form-control w-100" placeholder="Город"></select>
              </div>
              <button class="btn bg-dark rounded-0" onclick="addColumn()" type="button">Добавить</button>
            </div>
            <hr>
            <div class="row table-responsive">
              <table class="table text-nowrap">
                <thead>
                <tr>
                  <th>Город</th>
                  <th></th>
                </tr>
                </thead>
                <tbody id="tbody">
                @foreach($zone->cities as $city)
                  <tr class="align-items-center" id="city-{{ $city->id }}">
                    <td>
                      {{ $city->name }}
                    </td>
                    <td>
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="onDelete({{ $city->id }})" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
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
    function addColumn() {
      axios.put('{{ route('admin.store.express-zone.update', $zone->id) }}',
        {
          city_id: $('#city').val()
        })
        .then((response) => {
          console.log(response)
          if (response.data.success === 'ok') {
            $('#tbody').prepend(
              '<tr class="align-items-center" id="city-' + $('#city').val() + '">\n' +
              '                    <td>\n' +
              '                      ' + $('#city').text() + '\n' +
              '                    </td>\n' +
              '                    <td>\n' +
              '                        <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C"onclick="onDelete(' + $('#city').val() + ')" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>\n' +
              '                    </td>\n' +
              '                  </tr>'
            )
          } else {
            swal(response, '', 'error');
          }
        })
        .catch((error) => {
          console.log(error, 123);
          for (let key in error.response.data.errors) {
            swal(error.response.data.errors[key][0], '', 'error');
          }

        });
    }

    function onDelete(index) {
      console.log(index)
      axios.post('{{ route("admin.store.express-zone.destroyCity", $zone->id) }}',
        {
          city_id: index
        }
        )
        .then((response) => {
          console.log(response)
          if (response.data.success === 'ok') {
            $('#city-'+index).remove()
          }
        })
        .catch((error) => {
          console.log(error, 123);
          for (let key in error.response.data.errors) {
            swal(error.response.data.errors[key][0], '', 'error');
          }

        });
    }



    $('#city').select2({
      placeholder: 'Город',
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
