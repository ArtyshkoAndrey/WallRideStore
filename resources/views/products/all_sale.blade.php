@extends('layouts.app')
@section('title', 'Список товаров со скидкой')

@section('content')
{{--  <section class="mt-5 pt-5">--}}
{{--    <div class="container mt-5">--}}
{{--      <div class="row align-items-center mt-5 px-3">--}}
{{--        <div class="col-12"><h2 class="font-weight-bold d-block">Товары со скидкой</h2></div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--    <div class="container">--}}
{{--      @if(count($products) > 0)--}}
{{--      <div class="row">--}}
{{--        @forelse($products as $product)--}}
{{--          <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>--}}
{{--        @empty--}}
{{--          <div class="col-auto mt-5">--}}
{{--            <h4>Нет товаров</h4>--}}
{{--          </div>--}}
{{--        @endforelse--}}
{{--      </div>--}}
{{--      @endif--}}

{{--      @foreach($brands as $brand)--}}
{{--        <div class="row align-items-center mt-5 px-3">--}}
{{--          <div class="col-12"><h2 class="font-weight-bold d-block">{{ $brand->name }}</h2></div>--}}
{{--        </div>--}}
{{--        <div class="row {{ $brand->products()->where('on_sale', true)->count() === 0 ? 'justify-content-center align-items-center' : null }}">--}}
{{--          @forelse($brand->products()->where('on_sale', true)->with('skus', 'photos')->get() as $product)--}}
{{--            <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>--}}
{{--          @empty--}}
{{--            <div class="col-auto mt-5">--}}
{{--              <h4>Нет товаров</h4>--}}
{{--            </div>--}}
{{--          @endforelse--}}
{{--        </div>--}}
{{--      @endforeach--}}

{{--    </div>--}}
{{--  </section>--}}

  <section id="sale-all" class="mt-5 pt-5 pb-5">
    <div class="container-fluid mt-5">
      <div class="row px-md-5">
        <div class="col-md-3">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach($brands as $index => $brand)
              <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="pills-for-brand-{{$brand->id}}" data-toggle="pill" href="#pills-brand-{{$brand->id}}" role="tab" aria-controls="pills-brand-{{$brand->id}}" aria-selected="true">{{$brand->name}}</a>
            @endforeach
            @if(count($products) > 0)
              <a class="nav-link" id="pills-for-no-brand" data-toggle="pill" href="#pills-no-brand" role="tab" aria-controls="pills-no-brand" aria-selected="true">Без бренда</a>
            @endif
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content" id="v-pills-tabContent">
            @foreach($brands as $index => $brand)
              <div class="tab-pane fade {{ $index === 0 ? 'show active' : ''}}" id="pills-brand-{{$brand->id}}" role="tabpanel" aria-labelledby="pills-for-brand-{{$brand->id}}">
                <div class="row {{ $brand->products()->where('on_sale', true)->count() === 0 ? 'justify-content-center align-items-center' : null }}">
                  <div class="col-12"><h2 class="font-weight-bold d-block">{{ $brand->name }}</h2></div>
                  @forelse($brand->products()->where('on_sale', true)->with('skus', 'photos')->get() as $product)
                    <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
                  @empty
                    <div class="col-auto mt-5">
                      <h4>Нет товаров</h4>
                    </div>
                  @endforelse
                </div>
              </div>
            @endforeach
            @if(count($products) > 0)
              <div class="tab-pane fade" id="pills-no-brand" role="tabpanel" aria-labelledby="pills-for-no-brand">
                <div class="row">
                  <div class="col-12"><h2 class="font-weight-bold d-block">Без бренда</h2></div>
                  @forelse($products as $product)
                    <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
                  @empty
                    <div class="col-auto mt-5">
                      <h4>Нет товаров</h4>
                    </div>
                  @endforelse
                </div>
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')
  <script>
    $('.btn-to-cart-adaptive').height(Math.max.apply(Math, $('.btn-to-cart-adaptive').map(function(){ return $(this).width(); }).get()));
    window.addEventListener("resize", () => {
      $('.btn-to-cart-adaptive').height(Math.max.apply(Math, $('.btn-to-cart-adaptive').map(function(){ return $(this).width(); }).get()))
    });

    setTimeout(function () {
      $('.btn-to-cart-adaptive').height(Math.max.apply(Math, $('.btn-to-cart-adaptive').map(function(){ return $(this).width(); }).get()))
    }, 1000)
  </script>
@endsection
