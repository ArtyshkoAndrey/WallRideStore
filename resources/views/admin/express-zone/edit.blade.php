@extends('admin.layouts.app')

@section('title', 'Редактирование зоны доставки')

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
            <li class="breadcrumb-item active">Редактирование зоны доставки</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Редактирование зоны доставки</h3>
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
      <div class="col-12 p-0">
        <form action="{{ route('admin.express-zone.update', $zone->id) }}" method="POST" class="w-full">
          @csrf
          @method('PUT')
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="row row-eq-spacing-sm m-0 p-0">
                  <div class="col-auto ml-auto">
                    <button class="btn btn-success" type="submit">Обновить</button>
                  </div>
                  @if($zone->step_cost_array !== null)
                    <input type="hidden" name="method_cost" value="array_step">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="name" class="required">Наименование</label>
                        <input type="text"
                               class="form-control"
                               name="name"
                               id="name"
                               placeholder="Наименование"
                               value="{{ old('name', $zone->name) }}"
                               required>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label for="company" class="required">Компания</label>
                        <select class="form-control" name="company" id="company">
                          @foreach(App\Models\ExpressCompany::get() as $company)
                            <option value="{{$company->id}}" {{$zone->company->id === $company->id ? 'selected' : null}}>{{$company->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <list-cost :methodCost="{{ $zone->step_cost_array !== null ? 'array_step' : 'step_and_cost' }}"
                               :step_counter="{{ count($zone->step_cost_array) }}"
                               :step_cost_array="{{ json_encode($zone->step_cost_array, JSON_THROW_ON_ERROR) }}"
                               inline-template >

                      <div class="col-12">
                        <div class="row align-items-end justify-content-around mt-2" v-for="index in step_counter">
                          <div class="col-md">
                            <label :for="'weight_to['+index+']'">Вес от:</label>
                            <input type="number" min="0" step="0.1" :name="'weight_to['+index+']'" :id="'weight_to_'+index" class="form-control rounded-0" :value="step_cost_array[index - 1] ? step_cost_array[index - 1].weight_to : ''" required>
                          </div>
                          <div class="col-md">
                            <label :for="'weight_from['+index+']'">Вес до:</label>
                            <input type="number" min="0" step="0.1" :name="'weight_from['+index+']'" :id="'weight_from_'+index" class="form-control rounded-0" :value="step_cost_array[index - 1] ? step_cost_array[index - 1].weight_from : ''" required>
                          </div>
                          <div class="col-md">
                            <label :for="'cost['+index+']'">Цена за промежуток:</label>
                            <input type="number" min="0" :name="'cost['+index+']'" :id="'cost_'+index" class="form-control rounded-0" :value="step_cost_array[index - 1] ? step_cost_array[index - 1].cost : ''" required>
                          </div>
                          <div class="col-md-auto mt-2 mt-sm-0">
                            <button type="button" @click="step_counter--" class="btn btn-danger rounded-0 w-100">Удаить</button>
                          </div>
                          <div class="col-12">
                            <hr class="w-full">
                          </div>
                        </div>
                        <div class="row justify-content-end mt-2">
                          <div class="col-md-auto">
                            <button type="button" @click="step_counter++" class="btn btn-dark rounded-0 w-full">Добавить</button>
                          </div>
                        </div>
                      </div>

                    </list-cost>
                    <div class="col-12 mt-10">
                      <div class="row justify-content-center align-items-center px-0 mx-0">
                        <div class="col-md mr-10">
                          <select name="city" id="city" class="w-full" placeholder="Город"></select>
                        </div>
                        <div class="col-md-auto  mt-10 mt-md-0 mr-10">
                          <button class="btn " onclick="addColumn()" type="button">Добавить</button>
                        </div>
                        <div class="col-md mr-10">
                          <select name="country" id="country" class=" w-full" placeholder="Страна"></select>
                        </div>
                        <div class="col-md-auto mt-10 mr-10 mt-md-0">
                          <button class="btn" onclick="addCountry()" type="button">Добавить</button>
                        </div>
                      </div>
                      <div class="col-12  mt-10">
                        <button type="button" onclick="document.getElementById('cities_delete').submit()" class="btn bg-danger d-block ml-auto">Удалить все города</button>
                      </div>
                    </div>
                    <div class="col-12">
                      <hr>
                    </div>
                    <div class="col-12">
                      <div class="row table-responsive">
                        <table class="table text-nowrap">
                          <thead>
                          <tr>
                            <th>Город</th>
                            <th>{{ $zone->cities->count() }} городов</th>
                          </tr>
                          </thead>
                          <tbody id="tbody">
                          @foreach($zone->cities as $city)
                            <tr class="align-items-center" id="city-{{ $city->id }}">
                              <td>
                                {{ $city->name }}
                              </td>
                              <td>
                                <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="onDelete({{ $city->id }})" type="button"><i style="font-size: 1.5rem" class="bx bxs-trash"></i></button>
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>

                  @else

                    <input type="hidden" name="method_cost" value="step_and_cost">

                    <div class="col-12">
                      <label for="name" class="required">Наименование</label>
                      <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $zone->name) }}" required>
                    </div>

                    <div class="col-md">
                      <label for="cost" class="required">Стоимость</label>
                      <input type="number" name="cost" id="cost" class="form-control" value="{{ old('cost', $zone->cost) }}" required>
                    </div>

                    <div class="col-md">
                      <label for="step" class="required">Шаг</label>
                      <input type="number" name="step" id="step" class="form-control rounded-0" step="0.01" value="{{ old('step', $zone->step) }}" required>
                    </div>

                    <div class="col-md">
                      <label for="cost_step" class="required">Стоимость шага</label>
                      <input type="number" name="cost_step" id="cost_step" class="form-control" value="{{ old('cost_step', $zone->cost_step) }}" required>
                    </div>

                    <div class="col-md">
                      <div class="form-group">
                        <label for="company" class="required">Компания</label>
                        <select class="form-control" name="company" id="company">
                          @foreach(App\Models\ExpressCompany::get() as $company)
                            <option value="{{$company->id}}" {{$zone->company->id === $company->id ? 'selected' : null}}>{{$company->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-12 mt-10">
                      <div class="row justify-content-center align-items-center px-0 mx-0">
                        <div class="col-md mr-10">
                          <select name="city" id="city" class="w-full" placeholder="Город"></select>
                        </div>
                        <div class="col-md-auto  mt-10 mt-md-0 mr-10">
                          <button class="btn " onclick="addColumn()" type="button">Добавить</button>
                        </div>
                        <div class="col-md mr-10">
                          <select name="country" id="country" class=" w-full" placeholder="Страна"></select>
                        </div>
                        <div class="col-md-auto mt-10 mr-10 mt-md-0">
                          <button class="btn" onclick="addCountry()" type="button">Добавить</button>
                        </div>
                      </div>
                      <div class="col-12  mt-10">
                        <button type="button" onclick="document.getElementById('cities_delete').submit()" class="btn bg-danger d-block ml-auto">Удалить все города</button>
                      </div>
                    </div>
                    <div class="col-12">
                      <hr>
                    </div>
                    <div class="col-12">
                      <div class="row table-responsive">
                        <table class="table text-nowrap">
                          <thead>
                          <tr>
                            <th>Город</th>
                            <th>{{ $zone->cities->count() }} городов</th>
                          </tr>
                          </thead>
                          <tbody id="tbody">
                          @foreach($zone->cities as $city)
                            <tr class="align-items-center" id="city-{{ $city->id }}">
                              <td>
                                {{ $city->name }}
                              </td>
                              <td>
                                <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="onDelete({{ $city->id }})" type="button"><i style="font-size: 1.5rem" class="bx bxs-trash"></i></button>
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>

                  @endif
                </div>
              </div>
            </div>
          </div>
        </form>

        <form action="{{ route('admin.express-zone.update', $zone->id) }}" method="post" style="display: none" id="cities_delete">
          @csrf
          @method('PUT')
          <input type="text" name="cities_delete" value="1">
        </form>

      </div>
    </div>
  </div>
@endsection

@section('script')

  <script>
    function addColumn() {
      axios.put('{{ route('admin.express-zone.update', $zone->id) }}',
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
            $('#city').val('')
            $('#city').text('')
          } else {
            window.swal.fire({
              text: response,
              icon: 'error',
              title: 'Oops...',}
            );
          }
        })
        .catch((error) => {
          console.log(error, 123);
          for (let key in error.response.data.errors) {
            window.swal.fire({
              text: error.response.data.errors[key][0],
              icon: 'error',
              title: 'Oops...',}
            );
          }
        });
    }
    function addCountry() {
      window.swal({title: 'Список городов очень велик.', text: 'Разрешено не ожидать появление городов в списке. Перезагрузите страницу для обновления списка. Добавление городов в базу даннызх работает в отдельном потоке.'});
      axios.put('{{ route('admin.express-zone.update', $zone->id) }}',
        {
          country_id: $('#country').val()
        })
        .then((response) => {
          console.log(response)
          if (response.data.success === 'ok') {
            response.data.cities.forEach(city => {
              $('#tbody').prepend(
                '<tr class="align-items-center" id="city-' + city.id + '">\n' +
                '                    <td>\n' +
                '                      ' + city.name + '\n' +
                '                    </td>\n' +
                '                    <td>\n' +
                '                        <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C"onclick="onDelete(' + city.id + ')" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>\n' +
                '                    </td>\n' +
                '                  </tr>'
              )
            })
            $('#country').val('')
            $('#country').text('')
          } else {
            window.swal.fire({
              text: response,
              icon: 'error',
              title: 'Oops...',}
            );
          }
        })
        .catch((error) => {
          console.log(error);
        });
    }
    function onDelete(index) {
      console.log(index)
      axios.post('{{ route("admin.express-zone.destroyCity", $zone->id) }}',
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
            window.swal.fire({
              text: error.response.data.errors[key][0],
              icon: 'error',
              title: 'Oops...',}
            );
          }
        });
    }
    $(document).ready(() => {
      $('#city').select2({
        placeholder: 'Город',
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.cities') }}';
          },
          data: function (params) {
            return {
              name: params.term
            }
          },
          processResults: function (data) {
            return {
              results: data.cities.map((e) => {
                return {
                  text: e.name,
                  id: e.id
                };
              })
            };
          }
        }
      });
      $('#country').select2({
        placeholder: 'Страна',
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.countries') }}';
          },
          data: function (params) {
            return {
              name: params.term
            }
          },
          processResults: function (data) {
            return {
              results: data.countries.map((e) => {
                return {
                  text: e.name,
                  id: e.id
                };
              })
            };
          }
        }
      });

    })
  </script>

@endsection
