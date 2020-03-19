@extends('admin.layouts.app')
@section('title', 'Редактирование валюты')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Валюта</h2>
      </div>
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
          <form action="{{ route('admin.currency.update', $cr->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="name">Наименование</label>
                    <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $cr->name }}" required>
                    <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="name">Коэффициент</label>
                    <p class="small">1 единицу поделить на курс в тенге</p>
                    <input type="number" min="0" step="0.000000000001" name="ratio" id="ratio" class="w-100 px-2 form-control rounded-0 {{ $errors->has('ratio') ? ' is-invalid' : '' }}" value="{{ $cr->ratio }}" required>
                    <span id="ration-error" class="error invalid-feedback">{{ $errors->first('ratio') }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="name">Символ</label>
                    <input type="text" name="symbol" id="symbol" class="w-100 px-2 form-control rounded-0 {{ $errors->has('symbol') ? ' is-invalid' : '' }}" value="{{ $cr->symbol }}" required>
                    <span id="name-error" class="error invalid-feedback">{{ $errors->first('symbol') }}</span>
                  </div>
                </div>
              </div>
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
