@extends('admin.layouts.app')
@section('title', 'Магазин - Бренды>')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Бренды</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.production.brand.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    @include('admin.layouts.menu_production')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ route('admin.production.brand.index') }}" class="active">Все ({{App\Models\Brand::count()}})</a>
            </div>
            <div class="col-auto ml-auto">{{ $brands->appends($filters)->render() }}</div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.production.brand.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск" value="{{ $filters['search'] }}">
                  <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" type="submit">Найти</button>
                </div>
              </form>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ \App\Models\Brand::count() }} брендов</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Название</th>
              <th>Опубликовано</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($brands as $brand)
              <tr class="align-items-center">
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.production.brand.edit', $brand->id) }}" class="text-red">
                    {{ $brand->name }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $brand->created_at ? $brand->created_at->format('d.m.Y') : null }}
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.production.brand.destroy', $brand->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">Нет брендов</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    let filters = {!! json_encode($filters) !!};
    $(document).ready(() => {
      $('input[name="search"]').val(filters.search);
    })
  </script>
@endsection
