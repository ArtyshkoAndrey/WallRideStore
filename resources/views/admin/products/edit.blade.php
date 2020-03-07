@extends('admin.layouts.app')
@section('title', 'Магазин - Отчёты')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.0.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Отчёты</h2>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2"><a href="{{ route('admin.production.products.index') }}" class="bg-white px-3 py-2 d-block">Заказы</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.production.category.index') }}" class="bg-dark px-3 py-2 d-block">Категории</a></div>
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
          <form action="{{ route('admin.production.products.update', $product->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <label for="title">Наименование</label>
                <input type="text" class="form-control rounded-0" name="title" id="title" value="{{ $product->title }}">
              </div>
              <div class="col-md-4">
                <label for="type">Тип</label>
                <select name="type" id="type" class="form-control rounded-0">
                  <option value="0">Вариативный</option>
                  <option value="1">Обычный</option>
                </select>
              </div>
              <div class="col-12 ml-md-4 ml-2">
                <p class="font-smaller">Ссылка: <a href="{{ route('products.show', $product->id) }}" target="_blank" class="text-red" style="text-decoration: underline">{{ route('products.show', $product->id) }}</a></p>
              </div>

              <div class="col-md-8">
                <div class="row">
                  <div class="col-12">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-md-4">

              </div>
            </div>
          </form>.
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.0.6/js/froala_editor.pkgd.min.js"></script>
  <script !src="">
    let editor = new FroalaEditor('textarea')
  </script>
@endsection
