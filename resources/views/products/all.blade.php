@extends('layouts.app')
@section('title', 'Список товаров')

@section('content')
{{--    {{ dd($products) }}--}}
  <section class="container mt-5 pt-5">
    <form action="{{ route('products.all') }}">
      <div class="row">
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="order" class="form-control">
            <option value="">Сортировать по</option>
            <option value="new_desc">Сначала новые</option>
            <option value="price_asc">Сначала дешовые</option>
            <option value="price_desc">Сначало дорогие</option>
            <option value="sold_count_desc">По убыванию продаж</option>
            <option value="sold_count_asc">По возрастанию продаж</option>
            <option value="rating_desc">По убыванию оценки</option>
            <option value="rating_asc">По возрастанию оценки</option>
          </select>
        </div>
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="category" class="form-control">
            @foreach(App\Models\Category::where('is_brand', 0)->get() as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="brand" class="form-control">
            @foreach(App\Models\Category::where('is_brand', 1)->get() as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="size" class="form-control">
            @foreach(App\Models\Skus::get() as $attr)
              <option value="{{ $attr->id }}">{{ $attr->title }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </form>
  </section>
  <section class="mt-5">
    <div class="container">
      <div class="row align-items-center px-3">
        <div class="col-12"><h2 class="font-weight-bold d-block">Все товары</h2></div>
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
      <div class="row">
        @foreach($products as $product)
          <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
        @endforeach
        <div class="col-12 d-flex justify-content-center mt-2 mb-5">
          <div>{{ $products->appends($filters)->render() }}</div>
        </div>
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
      $('form select[name=order]').val(filters.order);
      $('form select[name=order]').on('change', function() {
        $('form').submit();
      });
    })
    $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width());
    window.addEventListener("resize", () => {
      $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width())
    });
  </script>
@endsection
