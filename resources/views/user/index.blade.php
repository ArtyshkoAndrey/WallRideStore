@extends('user.layouts.app')

@section('title', 'Главаня страница')

@section('content')

  <div class="container-fluid p-0">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-mdb-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" :data-slide-to="i-1" :class="i === 1 ? 'active' : ''" v-for="i in 1"></li>
      </ol>
      <div class="carousel-inner">

        <div class="carousel-item" :class="i === 1 ? 'active' : ''" v-for="i in 1">
          <div class="image">
            <img src="{{ asset('storage/slider/photos/slider.jpg') }}" class="d-block d-lg-none w-100" alt="...">

            <img src="{{ asset('storage/slider/photos/slider1.jpg') }}" class="d-lg-block d-none w-100" alt="...">
          </div>
          <div class="carousel-caption">
            <h4 class="text-uppercase">Vans</h4>
            <p>“OF THE WALL”</p>
            <a href="#" class="btn btn-dark">Перейти в магазин</a>
          </div>
        </div>

      </div>
{{--      <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-mdb-slide="prev">--}}
{{--        <span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
{{--        <span class="sr-only">Previous</span>--}}
{{--      </a>--}}
{{--      <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-mdb-slide="next">--}}
{{--        <span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
{{--        <span class="sr-only">Next</span>--}}
{{--      </a>--}}
    </div>
  </div>

  <section class="container mt-5 mb-5">
    <div class="row">
      <div class="col-6">
        <h4 class="font-weight-bolder">{{ __('Новые товары') }}</h4>
      </div>

      <div class="col-6">
        <a href="#" class="text-dark d-block text-right">{{ __('Перейти в каталог') }}</a>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 col-6" v-for="i in 8">
        @include('user.layouts.item')
      </div>
    </div>
  </section>

@endsection
