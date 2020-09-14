@extends('layouts.app')
@section('title', 'Список товаров')

@section('content')
  <section class="container-fluid p-0 text-white" id="slider">
    <div id="carouselExampleCaptions" class="carousel slide" style="height: 500px;" data-ride="carousel">

      <ol class="carousel-indicators d-none d-md-flex">
        <?php $i = 0;?>
        @foreach($hs as$h)
          <li data-target="#carouselExampleCaptions" data-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : ''}}"></li>
          <?php $i++; ?>
        @endforeach
      </ol>
      <div class="carousel-inner h-100 d-none d-md-block">
        <?php $i = 0;?>
        @foreach($hs as$h)
          <div class="carousel-item h-100 {{ $i === 0 ? 'active' : '' }}">
            <div style="width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); position: absolute;"></div>
            <img src="{{ asset('storage/header/' . $h->photo) }}" class="d-block h-100 w-100" style="object-fit: cover" alt="...">
            <div class="col-12 p-0 position-absolute text-center" style="top: 0;">
              <h1>{{$h->h1}}</h1>
              <h3>{{ $h->h2 }}</h3>
              <a href="{{ $h->url }}" class="btn">{{ $h->btn_text }}</a>
            </div>
          </div>
          <?php $i++; ?>
        @endforeach
      </div>

      <ol class="carousel-indicators d-flex d-md-none">
        <?php $i = 0;?>
        @foreach($hsm as$h)
          <li data-target="#carouselExampleCaptions" data-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : ''}}"></li>
          <?php $i++; ?>
        @endforeach
      </ol>
      <div class="carousel-inner h-100 d-block d-md-none">
        <?php $i = 0;?>
        @foreach($hsm as$h)
          <div class="carousel-item h-100 {{ $i === 0 ? 'active' : '' }}">
            <div style="width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); position: absolute;"></div>
            <img src="{{ asset('storage/header-mobile/' . $h->photo) }}" class="d-block h-100 w-100" style="object-fit: cover" alt="...">
            <div class="col-12 p-0 position-absolute text-center" style="top: 0;">
              <h1>{{$h->h1}}</h1>
              <h3>{{ $h->h2 }}</h3>
              <a href="{{ $h->url }}" class="btn">{{ $h->btn_text }}</a>
            </div>
          </div>
          <?php $i++; ?>
        @endforeach
      </div>

      <a class="carousel-control-prev bg-transparent" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next bg-transparent" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </section>
  <section class="mt-5 pt-5 px-00">
    <div class="container-fluid">
      <div class="row align-items-center px-5">
        <h2 class="font-weight-bold">Новые товары</h2>
        <a class="ml-auto text-dark" href="{{ route('products.all', ['order' => 'new_desc']) }}">Смотреть все</a>
      </div>
    </div>
    <div class="container-fluid" id="sliderList1">
      <div class="row px-md-5 px-2">
        @if(count($productsNew) > 0)
          @foreach($productsNew as $product)
            <product :slider=true :currency="{{ $currency }}" :item_not_soted="{{ $product }}"></product>
          @endforeach
            @for($i = 0; $i < 5 - $productsNew->count(); $i++)
              <div class="col-lg"></div>
            @endfor
        @else
          <h3 class="text-center mt-5 pb-5">Нет данных товаров</h3>
        @endif
      </div>
    </div>
  </section>
  @if($category)
  <section class="mt-5 mb-5 px-0">
    <div class="container-fluid">
      <div class="row align-items-center px-5">
        <h2 class="font-weight-bold">{{ $category->name }}</h2>
        <a class="ml-auto text-dark" href="{{ route('products.all', ['category' => $category->id]) }}">Смотреть все</a>
      </div>
    </div>
    <div class="container-fluid" id="sliderList2">
      <div class="row px-md-5 px-2">
        @if(count($products) > 0)
          @foreach($products as $product)
            <product :slider=true :currency="{{ $currency }}" :item_not_soted="{{ $product }}"></product>
          @endforeach
          @for($i = 0; $i < 5 - $products->count(); $i++)
          <div class="col-lg"></div>
          @endfor
        @else
          <h3 class="text-center mt-5 pb-5">Нет данных товаров</h3>
        @endif
      </div>
    </div>
  </section>
  @endif
  <section class="mt-5 mb-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
          <h2 class="font-weight-bold">Новости</h2>
        </div>
      </div>
    </div>
    <div class="container">
      <news :news="{{ $news }}"></news>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')
  <script>
    $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width());
    window.addEventListener("resize", () => {
      $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width())
    });
  </script>
@endsection
