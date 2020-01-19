@extends('layouts.app')
@section('title', 'Список товаров')

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
      </div>
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
  let filters = {!! json_encode($filters) !!};
  $(document).ready(function () {
    $('.search-form input[name=search]').val(filters.search);
    $('.search-form select[name=order]').val(filters.order);
    $('.search-form select[name=order]').on('change', function() {
      $('.search-form').submit();
    });
  })
</script>
@endsection
