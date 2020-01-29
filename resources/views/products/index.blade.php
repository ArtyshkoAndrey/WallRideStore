@extends('layouts.app')
@section('title', 'Список товаров')

@section('content')
{{--  {{ dd($productsNew[0]->skus[0]->title) }}--}}
  <section class="container-fluid p-0 text-white" id="slider">
    <div class="row p-0 m-0">
      <div class="col-12 p-0">
        <img class="img-fluid"  src="{{ asset("public/storage/images/slide1.png") }}" alt="">
      </div>
      <div class="col-12 p-0 position-absolute text-center">
        <h1>Polar Scate Co</h1>
        <h3>New collection</h3>
        <a href="#" class="btn">Купить сейчас <img src="{{ asset("public/images/arrow-long-right.png") }}" alt=""></a>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8 col-12">
              <form action="{{ route('products.index') }}" id="big-search" class="form-inline w-100">
                <div class="form-group mb-0 mr-0">
                  <label class="sr-only">Что-то искали?</label>
                  <input type="text" class="form-control border-0" placeholder="Что-то искали?">
                </div>
                <button type="submit" class="btn btn-primary border-0 ml-0"><i class="far fa-search"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="mt-5 pt-5 px-00">
    <div class="container">
      <div class="row align-items-center px-3">
        <h2 class="font-weight-bold">Новые товары</h2>
        <a class="ml-auto c-red" href="#">Смотреть все <img src="{{ asset('public/images/arrow-long-right-red.png') }}" width="50" alt=""></a>
      </div>
    </div>
    <div class="container-fluid px-0">
      @if(count($productsNew) > 0)
        <product-list :currency="{{ ($currency) }}" inline-template>
          <flickity ref="flickity" :options="flickityOptions">
            @foreach($productsNew as $product)
              <product :slider=true :currency="{{ $currency }}" :item="{{ $product }}"></product>
            @endforeach
          </flickity>
        </product-list>
      @else
        <h3 class="text-center mt-5 pb-5">Нет данных товаров</h3>
      @endif
    </div>
  </section>

  <section class="mt-5 mb-5 px-0">
    <div class="container">
      <div class="row align-items-center px-3">
        <h2 class="font-weight-bold">Худи</h2>
        <a class="ml-auto c-red" href="#">Смотреть все <img src="{{ asset('public/images/arrow-long-right-red.png') }}" width="50" alt=""></a>
      </div>
    </div>
    <div class="container-fluid px-0 mx-0">
      @if(count($products) > 0)
        <product-list :currency="{{ ($currency) }}" inline-template>
          <flickity ref="flickity" :options="flickityOptions">
            @foreach($products as $product)
              <product :slider=true :currency="{{ $currency }}" :item="{{ $product }}"></product>
            @endforeach
          </flickity>
        </product-list>
      @else
        <h3 class="text-center mt-5 pb-5">Нет данных товаров</h3>
      @endif
    </div>
  </section>
  <section class="mt-5 mb-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
          <h2 class="font-weight-bold">Новости</h2>
        </div>
      </div>
    </div>
    <div class="container">
      <news></news>
    </div>
  </section>
{{--<div class="row">--}}
{{--<div class="col-lg-10 offset-lg-1">--}}
{{--<div class="card">--}}
{{--  <div class="card-body">--}}
{{--    <!-- Запускается компонент фильтра -->--}}
{{--    <form action="{{ route('products.index') }}" class="search-form">--}}
{{--      <div class="form-row">--}}
{{--        <div class="col-md-9">--}}
{{--          <div class="form-row">--}}
{{--            <div class="col-auto">--}}
{{--              <input type="text" class="form-control form-control-sm" name="search" placeholder="Поиск">--}}
{{--            </div>--}}
{{--            <div class="col-auto">--}}
{{--              <button class="btn btn-primary btn-sm">Поиск</button>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-3">--}}
{{--          <select name="order" class="form-control form-control-sm float-right">--}}
{{--            <option value="">Сортировать по</option>--}}
{{--            <option value="price_asc">Цена по возрастанию</option>--}}
{{--            <option value="price_desc">Цена по убыванию</option>--}}
{{--            <option value="sold_count_desc">Продажи от высоких к низким</option>--}}
{{--            <option value="sold_count_asc">Продажи от низких к высоким</option>--}}
{{--            <option value="rating_desc">Оценке по убыванию</option>--}}
{{--            <option value="rating_asc">Оценке по возрастанию</option>--}}
{{--          </select>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </form>--}}
{{--    <!-- Конец компонента фильтра -->--}}
{{--    <div class="row products-list">--}}
{{--      @foreach($products as $product)--}}
{{--        <div class="col-3 product-item">--}}
{{--          <div class="product-content">--}}
{{--            <div class="top">--}}
{{--              <div class="img">--}}
{{--                <a href="{{ route('products.show', ['product' => $product->id]) }}">--}}
{{--                  <img src="{{ $product->image_url }}" alt="">--}}
{{--                </a>--}}
{{--              </div>--}}
{{--              <div class="price">{{ $product->price }} <b>р.</b></div>--}}
{{--              <div class="title">--}}
{{--                <a href="{{ route('products.show', ['product' => $product->id]) }}">{{ $product->title }}</a>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="bottom">--}}
{{--              <div class="sold_count">Продано <span>{{ $product->sold_count }} шт.</span></div>--}}
{{--              <div class="review_count">Оценок <span>{{ $product->review_count }}</span></div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      @endforeach--}}
{{--    </div>--}}
{{--    <div class="float-right">{{ $products->appends($filters)->render() }}</div>  <!-- Просто добавьте эту строку -->--}}
{{--  </div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
@endsection

@section('scriptsAfterJs')
<script>
</script>
@endsection
