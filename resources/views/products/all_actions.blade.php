@extends('layouts.app')
@section('title', 'Список товаров со скидкой')

@section('content')
  <section id="sale-all" class="mt-5 pt-5 d-none d-md-block pb-5">
    <div class="container-fluid mt-5">
      <div class="row px-md-5">
        <div class="col-md-3">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach($promotions as $index => $promotion)
              <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="pills-for-promotion-{{$promotion->id}}" data-toggle="pill" href="#pills-promotion-{{$promotion->id}}" role="tab" aria-controls="pills-promotion-{{$promotion->id}}" aria-selected="true">{{$promotion->name}}</a>
            @endforeach
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content" id="v-pills-tabContent">
            @foreach($promotions as $index => $promotion)
              <div class="tab-pane fade {{ $index === 0 ? 'show active' : ''}}" id="pills-promotion-{{$promotion->id}}" role="tabpanel" aria-labelledby="pills-for-promotion-{{$promotion->id}}">
                <div class="row {{ $promotion->products->count() === 0 ? 'justify-content-center align-items-center' : null }}">
                  <div class="col-12"><h2 class="font-weight-bold d-block">{{ $promotion->name }}</h2></div>
                  @forelse($promotion->products as $product)
                    @if ($product->on_sale === false)
                      <product :slider=false :currency="{{ $currency }}" :item_not_soted="{{ $product }}"></product>
                    @endif
                  @empty
                    <div class="col-auto mt-5">
                      <h4>Нет товаров</h4>
                    </div>
                  @endforelse
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="sale-all" class="mt-5 pt-5 d-block d-md-none pb-5">
    <div class="container-fluid mt-5">
      <div class="row px-md-5">
        <div class="accordion w-100" id="accordionExample">
          @foreach($promotions as $index => $promotion)
            <div class="card border-0 rounded-0" style="background-color: inherit;">
              <div class="card-header p-0 rounded-0" id="heading-promotion-{{$promotion->id}}">
                <h5 class="m-0">
                  <button class="btn btn-link p-0 collapsed m-0 btn-block rounded-0 text-dark font-weight-bold" style="font-size: 22px!important;" onclick="$('html, body').animate({ scrollTop: (50 + {{(int)$index * 40}}) }, 1000)" type="button" data-toggle="collapse" data-target="#collapse-promotion-{{$promotion->id}}" aria-expanded="false" aria-controls="collapse-promotion-{{$promotion->id}}">
                    {{ $promotion->name }}
                  </button>
                </h5>
              </div>

              <div id="collapse-promotion-{{$promotion->id}}" class="collapse" aria-labelledby="heading-promotion-{{$promotion->id}}" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="row p-0">
                    @forelse($promotion->products as $product)
                      @if($product->on_sale === false)
                        <product :slider=false :currency="{{ $currency }}" :item_not_soted="{{ $product }}" :class="'col-12 offset-0 ml-0'"></product>
                      @endif
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
