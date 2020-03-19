@extends('admin.layouts.app')
@section('title', 'Магазин - Новости')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Новости</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.news.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2"><a href="{{ route('admin.news.index') }}" class="bg-white px-3 py-2 d-block">Все</a></div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ route('admin.news.index', ['type' => 'all']) }}" class="{{ ($filters['type'] === null || $filters['type'] === 'all') ? 'active' : ''}}">Все ({{App\Models\News::withTrashed()->count()}})</a>
            </div>
            <div class="col-auto">
              <a href="{{ route('admin.news.index', ['type' => 'publish']) }}" class="{{ $filters['type'] === 'publish' ? 'active' : ''}}">
                Опубликованные ({{App\Models\News::count()}})
              </a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.news.index', ['type' => 'delete']) }}" class="{{ $filters['type'] === 'delete' ? 'active' : ''}}">
                Удаленные ({{App\Models\News::onlyTrashed()->count()}})
              </a>
            </div>
            <div class="col-auto ml-auto">{{ $news->appends($filters)->render() }}</div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.news.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{$filters['type']}}">
                  <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск" value="{{ $filters['search'] }}">
                  <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" type="submit">Найти</button>
                </div>
              </form>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ \App\Models\News::withTrashed()->count() }} новостей</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Название</th>
              <th>Статус</th>
              <th>Дата публикации</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($news as $n)
              <tr class="align-items-center">
                <td style="vertical-align: middle;" class="text-wrap w-25">
                  <a href="{{ route('admin.news.edit', $n->id) }}" class="text-red">{{ $n->title }}</a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $n->trashed() ? 'Удалено' : 'Опубликовано' }}
                </td>
                <td style="vertical-align: middle;">
                  {{ $n->created_at->format('d.m.Y') }}
                </td>
                <td style="vertical-align: middle; horiz-align: center; display: flex">
                  @if($n->trashed())
                    <form action="{{ route('admin.news.restore', $n->id) }}" method="post">
                      @csrf
                      <button class="bg-transparent border-0 rounded-0" style="color: #FFC701" type="submit"><i style="font-size: 1.5rem" class="fas fa-trash-undo-alt"></i></button>
                    </form>
                    <form action="{{ route('admin.news.destroy', $n->id) }}" method="post">
                      @csrf
                      @method('delete')
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                    </form>
                  @else
                    <form action="{{ route('admin.news.destroy', $n->id) }}" method="post">
                      @csrf
                      @method('delete')
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                    </form>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">Нет новостей</td>
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
    $('input[name="search"]').val(filters.search)
  </script>
@endsection
