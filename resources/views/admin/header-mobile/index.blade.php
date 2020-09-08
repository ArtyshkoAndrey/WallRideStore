@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Настройки шапки телефонов</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.header-mobile.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ $hs->count() }} шапок</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Картинка</th>
              <th>Текст 1 уровня</th>
              <th>Текст 2 уровня</th>
              <th>URL</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($hs as $h)
              <tr class="align-items-center">
                <td style="vertical-align: middle; width: 200px"><img src="{{ asset('storage/header-mobile/' . $h->photo) }}" class="img-fluid" alt="{{ $h->photo }}"></td>
                <td style="vertical-align: middle;"><a href="{{ route('admin.header-mobile.edit', $h->id) }}" class="text-red">{{$h->h1}}</a></td>
                <td style="vertical-align: middle;">{{$h->h2}}</td>
                <td style="vertical-align: middle;">{{$h->url}}</td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.header-mobile.destroy', $h->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form></td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">Нет шапок</td>
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
@endsection
