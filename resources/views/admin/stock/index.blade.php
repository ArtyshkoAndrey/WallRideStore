@extends('admin.layouts.app')
@section('title', 'Магазин - Акции')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Акции</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.store.stock.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новую</a>
      </div>
    </div>
    @include('admin.layouts.menu_store')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row align-items-end">
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ count($stocks) }} акций</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th style="text-align: center;" class=""><i class="fa fa-camera"></i></th>
              <th>Заголовок</th>
              <th>Описание</th>
              <th>Дата</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($stocks as $stock)
              <tr class="align-items-center">
                <td style="vertical-align: middle">
                  <img src="{{ $stock->getImage() }}" alt="{{ $stock->title }}" style="height: 100px; width: auto">
                </td>

                <td style="vertical-align: middle"><a href="{{ route('admin.store.stock.edit', $stock->id) }}" class="text-red">{{ $stock->title }}</a></td>
                <td style="vertical-align: middle"><span class="text-truncate d-block" style="width: 300px;">{{ $stock->description }}</span></td>
                <td style="vertical-align: middle">
                  {{ $stock->created_at->format('d.m.Y') }}
                </td>
                <td style="vertical-align: middle">
                  <form action="{{ route('admin.store.stock.destroy', $stock->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form></td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">Нет акций</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
