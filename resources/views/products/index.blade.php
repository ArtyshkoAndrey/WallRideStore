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
              <form action="{{ route('products.search') }}" id="big-search" class="form-inline w-100">
                <div class="form-group mb-0 mr-0">
                  <label class="sr-only">Что-то искали?</label>
                  <input type="text" name="name" class="form-control border-0" placeholder="Что-то искали?">
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
    <div class="container-fluid carousel px-0" id="sliderList1">
      @if(count($productsNew) > 0)
        <product-list  inline-template>
          <carousel :loop="false" :auto-width="true" :nav="false" :dots="false">
            @foreach($productsNew as $product)
              <product :slider=true :currency="{{ $currency }}" :item="{{ $product }}"></product>
            @endforeach
          </carousel>
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
    <div class="container-fluid px-0 mx-0" id="sliderList2">
      @if(count($products) > 0)
        <product-list inline-template>
          <carousel :loop="false" :auto-width="true" :nav="false" :dots="false">
            @foreach($products as $product)
              <product :slider=true :currency="{{ $currency }}" :item="{{ $product }}"></product>
            @endforeach
          </carousel>
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
@endsection

@section('scriptsAfterJs')
<script>
</script>
@endsection
