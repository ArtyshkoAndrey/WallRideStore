@extends('admin.layouts.app')

@section('title', 'Создание зоны доставки')

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
            <li class="breadcrumb-item active">Создание зоны доставки</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Создание зоны доставки</h3>
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
        <form action="{{ route('admin.express-zone.store') }}" method="POST" class="w-full">
          @csrf
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="row row-eq-spacing-sm m-0 p-0">
                  <div class="col-auto ml-auto">
                    <button class="btn btn-success" type="submit">Создать</button>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="name" class="required">Наименование</label>
                      <input type="text"
                             class="form-control"
                             name="name"
                             id="name"
                             placeholder="Наименование"
                             value="{{ old('name') }}"
                             required>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="type" class="required">Вид стоимости</label>
                      <select class="form-control" name="type" id="type" required>
                        <option value="step_cost_array">Массив весов</option>
                        <option value="cost_step">Шаг стоимости</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <label for="company" class="required">Компания</label>
                      <select class="form-control" name="company" id="company" required>
                        @foreach(App\Models\ExpressCompany::get() as $company)
                          <option value="{{$company->id}}" {{old('company') === $company->id ? 'selected' : null}}>{{$company->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
@endsection

@section('script')

@endsection
