@extends('layouts.app')
@section('title', 'Поиск товаров')

@section('content')
  <section class="mt-5 pt-5">
    <div class="container">
      <div class="row">
      @forelse($products as $product)
        <product :slider=false :currency="{{ $currency }}" :item_not_soted="{{ json_encode($product) }}"></product>
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
  <script>
    $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width());
    window.addEventListener("resize", () => {
      $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width())
    });
  </script>
@endsection
