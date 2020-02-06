@extends('layouts.app')
@section('title', 'Поиск товаров')

@section('content')
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
                  <input type="text" value="{{$name}}" name="name" class="form-control border-0" placeholder="Что-то искали?">
                </div>
                <button type="submit" class="btn btn-primary border-0 ml-0"><i class="far fa-search"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="mt-5">
    <div class="container">
      <div class="row">
      @forelse($products as $product)
        <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
      @empty
        <div class="col-12 mt-4">
          <h3 class="font-weight-bold text-center">Не найдено ни одной позиции</h3>
        </div>
      @endforelse
        <div class="col-12 d-flex justify-content-center mt-2 mb-5">
          <div>{{ $products->appends($name)->links() }}</div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
