@extends('layouts.app')
@section('title', $product->title)
@section('meta-description', isset($product->meta->description) ? $product->meta->description : '')
@section('meta-keywords', isset($product->meta->keywords) ? $product->meta->keywords : '')

@section('content')
<section class="container pt-5 my-5">
  <product-show :product="{{ $product }}" :currency="{{ $currency }}" :skus_not_order="{{ $product->skus }}" :favor="{{ $favored ? 'true' : 'false' }}" inline-template>
    <div class="row justify-content-center justify-content-md-around mt-5">
      <div class="col-md-5 col-10">
        <div class="slider-for mx-3">
          @if ($product->photos)
            @forelse($product->photos as $ph)
              <div class="slider-for__item">
                <img src="{{ asset('storage/products/'.$ph->name) }}" alt="{{ $ph->name }}">
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
        <div class="col-12 px-0">
          <?php
            $categoriesProduct = [];
            $childCategory = $product->categories->last();
            //            array_unshift($categoriesProduct, $catP);
            if ($childCategory) {
              while($catP = $childCategory->parents()->first()) {
                array_unshift($categoriesProduct, $catP);
                $childCategory = $catP;
              }
            }
            array_push($categoriesProduct, $product->categories->last());
          ?>
          <ol class="breadcrumb bg-transparent mb-0 text-black px-0">
            <li class="breadcrumb-item px-0"><a href="{{ route('products.all') }}" class="c-red pr-1">Магазин</a></li>
            @foreach($categoriesProduct as $c)
              <li class="breadcrumb-item px-0"><a href="{{ route('products.all', ['category' => $c->id]) }}" class="c-red px-1">{{ $c->name }} </a></li>
            @endforeach
            <li class="breadcrumb-item active px-0" aria-current="page"><span class="px-1">{{ ucwords(strtolower($product->title)) }}</span></li>
          </ol>
        </div>
        <h3 style="line-height: 35px;">{{ $product->title }}</h3>
        <div class="col-12 px-0">
          @foreach($product->brands()->get() as $brand)
            <a href="{{ route('products.all', ['brand' => $brand->id]) }}" class="btn btn-default border-dark rounded-0 mr-2">{{ $brand->name }}</a>
          @endforeach
        </div>
        <h1 class="font-weight-bold mt-4 text-uppercase">@{{ product.on_sale && product.price_sale ? $cost(Number(product.price_sale) * currency.ratio)  : $cost(Number(product.price) * currency.ratio) }} @{{ currency.symbol }}</h1>
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

      <div id="wrapper-big-slider" style="top: 0; left: 0; width: 100vw; height: 100vh; position: absolute; opacity: 0">
        <button id="close-big-slider" class="btn rounded-circle position-absolute text-black" style="right: 10px; top: 10px; z-index: 1000"><i class="far fa-times h1"></i></button>
        <div class="slider-for-big">

          @if ($product->photos)
            @forelse($product->photos as $ph)
              <div class="item">
                <div class="img-fill">
                  <img src="{{ asset('storage/products/'.$ph->name) }}" class="zoom" alt="{{ $ph->name }}">
                </div>
              </div>
            @empty
              <div class="item">
                <div class="img-fill">
                  <img class="zoom" src="https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png" alt="error" />
                </div>
              </div>
            @endforelse
          @else
            <div class="item">
              <div class="img-fill">
                <img class="zoom" src="https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png" alt="error" />
              </div>
            </div>
          @endif

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
      <product :slider=false :currency="{{ $currency }}" :item_not_soted="{{ $prod }}"></product>
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
  <style>
    body {
      overflow-x: hidden;
    }
  </style>
@endsection
