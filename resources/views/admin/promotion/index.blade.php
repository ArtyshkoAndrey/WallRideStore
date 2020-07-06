@extends('admin.layouts.app')
@section('title', 'Магазин - Акции')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Акции</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.production.promotions.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новую</a>
      </div>
    </div>
    @include('admin.layouts.menu_production')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row align-items-end">
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ count($promotions) }} акций</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Наименование</th>
              <th>Статус</th>
              <th>Процент скидки</th>
              <th>Исколючить товары SALE</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($promotions as $promotion)
              <tr class="align-items-center">
                <td style="vertical-align: middle"><a href="{{ route('admin.production.promotions.edit', $promotion->id) }}" class="text-red">{{ $promotion->name }}</a></td>
                <td style="vertical-align: middle">{!! $promotion->status ? '<span style="color: #04B900">Включена</span>' : '<span style="color: #F33C3C">Выключена</span>' !!}</td>
                <td style="vertical-align: middle">{{ $promotion->sale . ' %' }}</td>
                <td style="vertical-align: middle">{!! $promotion->sale_status ? '<span style="color: #04B900">Не исключены</span>' : '<span style="color: #F33C3C">Исключены</span>' !!}</td>
                <td style="vertical-align: middle">
                  <form action="{{ route('admin.production.promotions.destroy', $promotion->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form></td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">Нет вопросов</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
