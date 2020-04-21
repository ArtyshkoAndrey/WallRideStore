@extends('layouts.app')
@section('title', 'Список товаров со скидкой')

@section('content')
  <section class="mt-5 pt-5">
    <div class="container mt-5">
      <div class="row align-items-center mt-5 px-3">
        <div class="col-12"><h2 class="font-weight-bold d-block">Товары со скидкой</h2></div>
      </div>
    </div>
    <div class="container">
      @if(count($products) > 0)
      <div class="row">
        @forelse($products as $product)
          <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
        @empty
          <div class="col-auto mt-5">
            <h4>Нет товаров</h4>
          </div>
        @endforelse
      </div>
      @endif

      @foreach($brands as $brand)
        <div class="row align-items-center mt-5 px-3">
          <div class="col-12"><h2 class="font-weight-bold d-block">{{ $brand->name }}</h2></div>
        </div>
        <div class="row {{ $brand->products()->where('on_sale', true)->count() === 0 ? 'justify-content-center align-items-center' : null }}">
          @forelse($brand->products()->where('on_sale', true)->with('skus', 'photos')->get() as $product)
            <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
          @empty
            <div class="col-auto mt-5">
              <h4>Нет товаров</h4>
            </div>
          @endforelse
        </div>
      @endforeach

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
