@extends('admin.layouts.app')
@section('title', 'Создание бренда')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Бренды</h2>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2"><a href="{{ route('admin.production.products.index') }}" class="bg-dark px-3 py-2 d-block">Товары</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.production.category.index') }}" class="bg-dark px-3 py-2 d-block">Категории</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.production.brand.index') }}" class="bg-white px-3 py-2 d-block">Бренды</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.production.attr.index') }}" class="bg-dark px-3 py-2 d-block">Атрибуты</a></div>
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
          <form action="{{ route('admin.production.brand.store') }}" method="post">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="name">Наименование</label>
                    <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? 'is-invalid' : null }}" value="{{ old('name') ? old('name') : null }}" required>
                    <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="categories" class="col-12 px-0">Категории</label>
                    <select name="categories[]" multiple id="categories" class="form-control rounded-0 js-example-basic-multiple">
                      @foreach(App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mt-4 category">
                <ul>
                  @foreach($categories as $category)
                    <li><a href="{{ route('admin.production.category.edit', $category->id) }}" class="text-red">{{ $category->name }}</a></li>
                    @if($category->child()->count() > 0)
                      <ul>
                        @include('admin.layouts.categoryList', ['cat' => $category->child()->get(), 'deleted' => false])
                      </ul>
                    @endif
                  @endforeach
                </ul>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $('.js-example-basic-multiple').select2({
      width: 'resolve'
    });
  </script>
@endsection
