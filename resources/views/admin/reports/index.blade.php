@extends('admin.layouts.app')
@section('title', 'Магазин - Отчёты')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Отчёты</h2>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Заказы</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.coupon.index') }}" class="bg-dark px-3 py-2 d-block">Промокоды</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.express.index') }}" class="bg-dark px-3 py-2 d-block">Доставка</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.order.index') }}" class="bg-dark px-3 py-2 d-block">Оплата</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.store.reports.index') }}" class="bg-white px-3 py-2 d-block">Отчеты</a></div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row mt-3">
            <div class="col-md justify-content-start align-items-center d-flex">
              <h4 class="font-weight-bold">Отчет по продажам</h4>
            </div>
            <div class="col-md justify-content-center align-items-center d-flex">
              <div class="btn-group"  role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-dark active">Год</button>
                <button type="button" class="btn btn-outline-dark">Месяц</button>
                <button type="button" class="btn btn-outline-dark">Неделя</button>
              </div>
            </div>
            <div class="col-md justify-content-end align-items-center d-flex">
              <h4 class="font-weight-bold m-0">Заработано: {{ cost($summ) }} тг</h4>
            </div>
            <div class="col-md-auto justify-content-end d-flex">
              <button class="btn bg-dark rounded-0" type="button">Скачать PDF</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div id="placeholder" style="height: 500px;"></div>
        </div>
      </div>
    </div>
  </div>
{{--  {{dd(json_encode($ch))}}--}}
@endsection

@section('js')
  <script !src="">
    var options = {
      grid  : {
        borderWidth: 0
      },
      series: {
        points: {show: true},
        lines: {show: true},
        shadowSize: 0, // Drawing is faster without shadows
      },
      xaxis: {
        axisLabel: "График за год",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10,
        ticks: {!! json_encode($cl) !!}
      },

      legend: {
        noColumns: 0,
        labelBoxBorderColor: "#000000",
        position: "nw"
      }
    };
    $.plot($("#placeholder"), [{ label: '123', data: {!! json_encode($ch) !!} }], options);
  </script>
@endsection
