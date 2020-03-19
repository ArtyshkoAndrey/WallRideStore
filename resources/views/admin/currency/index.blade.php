@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Валюта</h2>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ $currencies->count() }} валют</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Название</th>
              <th>Коэффициент</th>
              <th>Курс</th>
              <th>Изменялось</th>
            </tr>
            </thead>
            <tbody>
            @forelse($currencies as $cr)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><a href="{{ route('admin.currency.edit', $cr->id) }}" class="text-red">{{$cr->name}}</a></td>
                <td style="vertical-align: middle;">{{$cr->ratio}}</td>
                <td style="vertical-align: middle;">{{ '1 ' . $cr->symbol . ' = ' . 1 / $cr->ratio . ' тг.'  }}</td>
                <td style="vertical-align: middle;">{{ $cr->updated_at->format('d.m.Y') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">Нет валют</td>
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
  </script>
@endsection
