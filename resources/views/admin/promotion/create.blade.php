@extends('admin.layouts.app')
@section('title', 'Магазин - Акции')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Акции</h2>
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
          <form action="{{ route('admin.production.promotions.store') }}" method="post">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-8">
                    <label for="name">Наименование*</label>
                    <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                    <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-8">
                    <label for="sale">Скидка % *</label>
                    <input type="number" name="sale" id="sale" class="w-100 px-2 form-control rounded-0 {{ $errors->has('sale') ? ' is-invalid' : '' }}" value="{{ old('sale') }}" required>
                    <span id="sale-error" class="error invalid-feedback">{{ $errors->first('sale') }}</span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label for="count_product">На какой в очереди товар будет распространяться</label>
                    <input type="number" name="count_product" id="count_product" class="w-100 px-2 form-control rounded-0 {{ $errors->has('count_product') ? ' is-invalid' : '' }}" value="{{ old('count_product') }}" required>
                    <span id="count_product-error" class="error invalid-feedback">{{ $errors->first('count_product') }}</span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-auto">
                    <div class="custom-control w-100 px-5 mt-4 custom-switch">
                      <input type="checkbox" name="status" class="custom-control-input" id="status" {{ old('status') ? 'checked' : null }}>
                      <label class="custom-control-label" for="status">Включить</label>
                    </div>
                  </div>

                  <div class="col-md-auto">
                    <div class="custom-control w-100 px-5 mt-4 custom-switch">
                      <input type="checkbox" name="sale_status" class="custom-control-input" id="sale_status" {{ !old('sale_status') ? 'checked' : null }}>
                      <label class="custom-control-label" for="sale_status">Исключить товары SALE</label>
                    </div>
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
@endsection
