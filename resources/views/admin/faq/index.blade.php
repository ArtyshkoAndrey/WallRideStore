@extends('admin.layouts.app')
@section('title', 'Магазин - FAQ')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>FAQ</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.store.faqs.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    @include('admin.layouts.menu_store')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row align-items-end">
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ count($faqs) }} вопросов</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th style="text-align: center;" class=""><i class="fa fa-camera"></i></th>
              <th>Заголовок</th>
              <th>Дата</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($faqs as $f)
              <tr class="align-items-center">
                <td style="vertical-align: middle">
                  <img src="{{ $f->getImage() }}" alt="{{ $f->title }}" style="height: 100px; width: auto">
                </td>

                <td style="vertical-align: middle"><a href="{{ route('admin.store.faqs.edit', $f->id) }}" class="text-red">{{ $f->title }}</a></td>
                <td style="vertical-align: middle">
                  {{ $f->created_at->format('d.m.Y') }}
                </td>
                <td style="vertical-align: middle">
                  <form action="{{ route('admin.store.faqs.destroy', $f->id) }}" method="post">
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
