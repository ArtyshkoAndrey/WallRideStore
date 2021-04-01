@extends('admin.layouts.app')

@section('title', 'Создание компании доставки')

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
            <li class="breadcrumb-item active">Создание компании доставки</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Создание компании доставки</h3>
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
        <form action="{{ route('admin.express.store') }}" method="POST" class="w-full">
          @csrf
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="row row-eq-spacing-sm m-0 p-0">

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="name" class="required">Наименование</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Наименование" value="{{ old('name') }}" required>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="description" class="required">Краткое описание</label>
                      <input type="text" class="form-control" name="description" id="description" placeholder="Описание" value="{{ old('description') }}" required>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="track_url" class="required">Ссылка на отслеживание (на конеце '/')</label>
                      <input type="text" class="form-control" name="track_url" id="track_url" placeholder="Ссылка на отслеживание (на конеце '/')" value="{{ old('track_url') }}">
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="min_cost" class="required">Минимальная стоимость</label>
                      <input type="number" class="form-control" name="min_cost" id="min_cost" placeholder="Минимальная стоимость" value="{{ old('min_cost') }}" required>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="enabled" value="0"><!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                      <input type="checkbox" name="enabled" id="enabled" value="1" {{ old('enabled') ? 'checked' : null }}>
                      <label for="enabled" class="text-danger">Использовать</label>
                    </div>
                  </div>

                  <div class="col-12 mt-10">
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="enabled_cash" value="0"><!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                      <input type="checkbox" name="enabled_cash" id="enabled_cash" value="1" {{ old('enabled_cash') ? 'checked' : null }}>
                      <label for="enabled_cash" class="text-danger">Наличные</label>
                    </div>
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="enabled_card" value="0">
                      <input type="checkbox" name="enabled_card" id="enabled_card" value="1" {{ old('enabled_card') ? 'checked' : null }}>
                      <label for="enabled_card">Картой</label>
                    </div>
                  </div>



                  <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit">Создать</button>
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
  <script>

  </script>
@endsection
