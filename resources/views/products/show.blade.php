@extends('layouts.app')
@section('title', $product->title)

@section('content')
<section class="container pt-5 my-5">
  <product-show :product="{{ $product }}" :currency="{{ $currency }}" :skus="{{$product->skus}}" :favor="{{ $favored ? 'true' : 'false' }}" inline-template>
    <div class="row justify-content-center justify-content-md-around mt-5">
      <div class="col-md-5 col-10">
        <div class="slider-for d-md-block mx-3 d-none">
          @if ($product->photos)
            @forelse($product->photos as $ph)
              <div class="slider-for__item">
                <img src="{{ asset('storage/products/'.$ph->name) }}" alt="{{ $ph->name }}" data-image="{{ asset('storage/products/'.$ph->name) }}" data-title="{{ucwords(strtolower($product->title))}}" data-caption="{{
                  $product->brands()->count() > 0 && $product->categories()->count() > 0 ? $product->brands()->first()->name . ' - ' . $product->categories()->first()->name : ''
                }}" class="demo-image">
              </div>
            @empty
              <div class="slider-for__item ex1">
                <img src="https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png" alt="error" />
              </div>
            @endforelse
          @else
            <div class="slider-for__item ex1">
              <img src="https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png" alt="error" />
            </div>
          @endif

        </div>
        <div class="slider-for d-md-none d-block">
          @if ($product->photos)
            @forelse($product->photos as $ph)
              <div class="slider-for__item">
                <img src="{{ asset('storage/products/'.$ph->name) }}" alt="{{ $ph->name }}" data-image="{{ asset('storage/products/'.$ph->name) }}" data-title="{{ucwords(strtolower($product->title))}}" data-caption="{{
                  $product->brands()->count() > 0 && $product->categories()->count() > 0 ? $product->brands()->first()->name . ' - ' . $product->categories()->first()->name : ''
                }}" class="demo-image"/>
              </div>
            @empty
              <div class="slider-for__item">
                <img src="https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png" alt="error" />
              </div>
            @endforelse
          @else
            <div class="slider-for__item">
              <img src="https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png" alt="error" />
            </div>
          @endif

        </div>
      </div>
      <div class="col-md-7 mt-5 mt-md-0">
        <h3 style="line-height: 35px;">{{ $product->title }}</h3>
        <div class="col-12 px-0">
          @foreach($product->brands()->get() as $brand)
            <a href="{{ route('products.all', ['brand' => $brand->id]) }}" class="btn btn-default border-dark rounded-0 mr-2">{{ $brand->name }}</a>
          @endforeach
        </div>
        <div class="col-12 px-0">
          <ol class="breadcrumb bg-transparent text-black px-0">
            <li class="breadcrumb-item px-0"><a href="{{ route('products.all') }}" class="text-dark">Магазин</a></li>
            <li class="breadcrumb-item active px-0" aria-current="page">{{ ucwords(strtolower($product->title)) }}</li>
          </ol>
        </div>
        <h1 class="font-weight-bold text-uppercase">@{{ product.on_sale && product.price_sale ? $cost(Number(product.price_sale) * currency.ratio)  : $cost(Number(product.price) * currency.ratio) }} @{{ currency.symbol }}</h1>
        <div class="row mt-2">
          <div class="col-12">
            {!! $product->description !!}
          </div>
        </div>
        <h4 class="font-weight-bold mt-1">Размер</h4>
        <div class="btn-group btn-group-toggle btn-group-toggle-skus">
          <label v-for="(sku, index) in skus" v-if="sku.stock > 0" :key="sku.id" :class="(index===0 ? 'mr-0 mr-md-2 mx-2 mx-md-0' : 'mx-2') + ' btn sku-btn mt-2 mt-md-0' + (idSku === sku.id ? ' active' : '')">
            <input type="radio" :id="'gender_' + index" autocomplete="off" name="sku_id" :value="sku.id" v-model.number='idSku'>
            @{{  sku.skus !== null ? sku.skus.title : 'One Size'}}
          </label>
        </div>

        <div class="row mt-4 align-items-center">
          <div class="col-12">
            <h4 class="font-weight-bold">Количество</h4>
          </div>
          <div class="col-12">
            <p class="text-muted pb-0 mb-0">В наличии: @{{ size.stock }}</p>
          </div>
          <div class="col-12">
            <p class="text-muted pb-0 mb-0">Вес: @{{ Number(product.weight) }} кг.</p>
          </div>
          <div class="col-auto h-100 mt-1"><button class="btn btn-angle text-white" @click="removeCounter"><i class="fal fa-minus mt-1"></i></button></div>
          <div class="col-md-2 h-100 col-sm-2 col-2 p-0">
            <input class="form-control bg-white border-0 px-0 font-weight-bolder text-center" type="number" v-model="counter" readonly disabled>
          </div>
          <div class="col-auto h-100"><button class="btn btn-angle text-white" @click="addCounter"><i class="fal fa-plus mt-1"></i></button></div>

          <div class="col-md-auto col-sm-6 h-100 mt-md-1 mt-3">
            <button class="btn btn-block py-3" id="btn-add-to-cart" @click="addToCart" v-if="!cart"><i class="fal fa-shopping-bag"></i> Добавить в корзину</button>
            <button class="btn btn-block py-3" id="btn-remove-in-cart" v-else disabled readonly><i class="fal fa-check"></i> Добавлено</button>
          </div>
          <div class="col-md-auto col-sm-6 h-100 mt-md-1 mt-3">
            <button class="btn h-100 py-3 btn-block bg-transparent p-0 text-dark" @click="favored" v-if="!favoredData"><i class="fal fa-heart"></i> Добавить в избранное</button>
            <button class="btn h-100 py-3 btn-block bg-transparent p-0 text-dark" @click="disFavored" v-else><i class="fad fa-heart"></i> Удалить из избранных</button>
          </div>
        </div>
      </div>
    </div>
  </product-show>
</section>
<section class="container mb-5">
  <div class="row">
    <div class="col-12">
      <h2 class="font-weight-bold">Похожие товары</h2>
    </div>
  </div>
  <div class="row">
    @foreach($products as $prod)
      <product :slider=false :currency="{{ $currency }}" :item="{{ $prod }}"></product>
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
