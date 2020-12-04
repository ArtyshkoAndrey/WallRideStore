@extends('admin.layouts.app')
@section('title', 'Магазин - Настройки систем оплат')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Оплата</h2>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
              <tr>
                <th>Название</th>
                <th>Статус</th>
              </tr>
            </thead>
            <tbody>
            @forelse(json_decode($setting->meta)->pays as $key => $p)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><p>{{$p->name}}</p></td>
                <td style="vertical-align: middle;">
                  <div class="custom-control align-items-center mb-2 custom-switch">
                    <input type="checkbox" name="enabled_cash" {{ $p->enabled ? 'checked' : '' }} class="custom-control-input" id="{{ $key }}" onchange="update('{{ $key }}')">
                    <label class="custom-control-label" for="{{ $key }}"></label>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center">Нет оплат</td>
              </tr>
            @endforelse
            </tbody>
          </table>
          <form id="update" action="{{ route('admin.pay-setting.update') }}" method="post" class="d-none">
            <input type="text" id="param" name="param">
            <input type="text" id="ch" name="ch">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    function update(param) {
      let ch = $('#' + param).is(':checked')
      $('#param').val(param)
      $('#ch').val(Number(ch))
      $('#update').submit()
    }
  </script>
@endsection
