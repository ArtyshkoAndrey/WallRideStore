@extends('admin.layouts.app')
@section('title', 'Создание компании доставки')

@section('content')
  {{--  {{ dd($errors) }}--}}
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Компания доставки</h2>
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
          <form action="{{ route('admin.store.express.store') }}" method="post">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-4">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md-2">
                <label for="cost_type">Тип стоимости</label>
                <select name="cost_type" id="cost_type" class="form-control rounded-0 {{ $errors->has('cost_type') ? ' is-invalid' : '' }}">
                  <option value="Настраиваемая" {{ old('cost_type') == 'Настраиваемая' ? 'selected' : null }}>Настраиваемая</option>
                  <option value="0 тг." {{ old('cost_type') == '0 тг.' ? 'selected' : null }}>0 тг.</option>
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost_type') }}</span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')

@endsection
