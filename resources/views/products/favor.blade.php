@extends('layouts.app')
@section('title', 'Список товаров в избранном')

@section('content')
  <section class="mt-5 pt-5">
    <div class="container mt-5">
      <div class="row align-items-center px-3">
        <div class="col-12"><h2 class="font-weight-bold d-block">Все товары в избранном</h2></div>
        @if ($message = Session::get('filter'))
          <div class="col-12">
            <h4 class="text-muted">
              {{ $message }}
            </h4>
          </div>
        @endif
      </div>
    </div>
    <div class="container">
      <div class="row {{ count($products) === 0 ? 'justify-content-center align-items-center' : null }}">
        @forelse($products as $product)
          <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
        @empty
          <div class="col-auto mt-5">
            <h4>Нет товаров</h4>
          </div>
        @endforelse
        <div class="col-12 d-flex justify-content-center mt-2 mb-5">
          <div>{{ $products->render() }}</div>
        </div>
      </div>
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
