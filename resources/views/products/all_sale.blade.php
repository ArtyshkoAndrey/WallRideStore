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

  <section id="sale-all" class="mt-5 pt-5 d-none d-md-block pb-5">
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

  <section id="sale-all" class="mt-5 pt-5 d-block d-md-none pb-5">
    <div class="container-fluid mt-5">
      <div class="row px-md-5">
{{--        <div class="col-md-3">--}}
{{--          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">--}}
{{--            @foreach($brands as $index => $brand)--}}
{{--              <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="pills-for-brand-{{$brand->id}}" data-toggle="pill" href="#pills-brand-{{$brand->id}}" role="tab" aria-controls="pills-brand-{{$brand->id}}" aria-selected="true">{{$brand->name}}</a>--}}
{{--            @endforeach--}}
{{--            @if(count($products) > 0)--}}
{{--              <a class="nav-link" id="pills-for-no-brand" data-toggle="pill" href="#pills-no-brand" role="tab" aria-controls="pills-no-brand" aria-selected="true">Без бренда</a>--}}
{{--            @endif--}}
{{--          </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-9">--}}
{{--          <div class="tab-content" id="v-pills-tabContent">--}}
{{--            @foreach($brands as $index => $brand)--}}
{{--              <div class="tab-pane fade {{ $index === 0 ? 'show active' : ''}}" id="pills-brand-{{$brand->id}}" role="tabpanel" aria-labelledby="pills-for-brand-{{$brand->id}}">--}}
{{--                <div class="row {{ $brand->products()->where('on_sale', true)->count() === 0 ? 'justify-content-center align-items-center' : null }}">--}}
{{--                  <div class="col-12"><h2 class="font-weight-bold d-block">{{ $brand->name }}</h2></div>--}}
{{--                  @forelse($brand->products()->where('on_sale', true)->with('skus', 'photos')->get() as $product)--}}
{{--                    <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>--}}
{{--                  @empty--}}
{{--                    <div class="col-auto mt-5">--}}
{{--                      <h4>Нет товаров</h4>--}}
{{--                    </div>--}}
{{--                  @endforelse--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            @endforeach--}}
{{--            @if(count($products) > 0)--}}
{{--              <div class="tab-pane fade" id="pills-no-brand" role="tabpanel" aria-labelledby="pills-for-no-brand">--}}
{{--                <div class="row">--}}
{{--                  <div class="col-12"><h2 class="font-weight-bold d-block">Без бренда</h2></div>--}}
{{--                  @forelse($products as $product)--}}
{{--                    <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>--}}
{{--                  @empty--}}
{{--                    <div class="col-auto mt-5">--}}
{{--                      <h4>Нет товаров</h4>--}}
{{--                    </div>--}}
{{--                  @endforelse--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            @endif--}}

{{--          </div>--}}
{{--        </div>--}}

        <div class="accordion w-100 p-3" id="accordionExample">

          @foreach($brands as $index => $brand)
            <div class="card rounded-0" style="background-color: inherit;">
              <div class="card-header p-0 rounded-0" id="heading-brand-{{$brand->id}}">
                <h5 class="m-0">
                  <button class="btn btn-link p-0 collapsed m-0 btn-block rounded-0 text-dark font-weight-bold" style="font-size: 22px!important;" onclick="$('html, body').animate({ scrollTop: (50 + {{(int)$index * 40}}) }, 1000)" type="button" data-toggle="collapse" data-target="#collapse-brand-{{$brand->id}}" aria-expanded="false" aria-controls="collapse-brand-{{$brand->id}}">
                    {{ $brand->name }}
                  </button>
                </h5>
              </div>

              <div id="collapse-brand-{{$brand->id}}" class="collapse" aria-labelledby="heading-brand-{{$brand->id}}" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="row p-0">
                    @forelse($brand->products()->where('on_sale', true)->with('skus', 'photos')->get() as $product)
                      <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}" :class="'col-12 offset-0 ml-0'"></product>
                    @empty
                      <div class="col-auto mt-5">
                        <h4>Нет товаров</h4>
                      </div>
                    @endforelse
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          @if(count($products) > 0)
            <div class="card rounded-0" style="background-color: inherit;">
              <div class="card-header p-0 rounded-0" id="heading-brand-no">
                <h5 class="m-0">
                  <button class="btn btn-link p-0 collapsed m-0 btn-block rounded-0 text-dark font-weight-bold" style="font-size: 22px!important;" onclick="$('html, body').animate({ scrollTop: (50 + {{count($brands) * 40}}) }, 1000)" type="button" data-toggle="collapse" data-target="#collapse-brand-no" aria-expanded="false" aria-controls="collapse-brand-no">
                    Без бренда
                  </button>
                </h5>
              </div>

              <div id="collapse-brand-no" class="collapse" aria-labelledby="heading-brand-no" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="row p-0">
                    @forelse($products as $product)
                      <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}" :class="'col-12 offset-0 ml-0'"></product>
                    @empty
                      <div class="col-auto mt-5">
                        <h4>Нет товаров</h4>
                      </div>
                    @endforelse
                  </div>
                </div>
              </div>
            </div>
          @endif
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

    setInterval(() => {
      $('.btn-to-cart-adaptive').height(Math.max.apply(Math, $('.btn-to-cart-adaptive').map(function(){ return $(this).width(); }).get()))
    }, 500)
  </script>
@endsection
