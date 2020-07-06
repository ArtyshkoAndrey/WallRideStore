@extends('layouts.app')
@section('title', 'Корзина покупок')

@section('content')
  <section class="container mt-5 pt-5 mb-5" id="cart">
    <div class="row">
      <div class="col-12">
        <h1 class="font-weight-bold">Корзина</h1>
      </div>
      <div class="col-12 col-md-4">
        <div class="card">
          <div class="card-body mt-2">
            <h4 class="font-weight-bold">Количество товаров</h4>
            <p class="h5 mt-3" id="amount">{{ $amount }} шт.</p>
            <h4 class="font-weight-bold mt-4">Сумма товаров</h4>
            <p class="h5 mt-3" id="priceAmount">{{ cost(round((integer) $priceAmount * $currency->ratio, 0)) }} {{ $currency->symbol }}</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-8 mt-3 mt-sm-0">
        <div class="card">
          <div class="card-body">
            <mini-cart-item v-if="cartItems.length >= 1" v-for="(item, index) in cartItems" :id="item.product_sku.id" :key="item.product_sku.id + '-' + Math.random() * (99999 - 1) + 1" :item="item" :currency="{{$currency}}" inline-template>
              <div class="row mt-2 justify-content-center align-items-center">
                <div class="col-md col-4">
                  <img :src="item.product_sku.product.photos.length > 0 ? 'storage/products/' + item.product_sku.product.photos[0].name : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png'" class="img-fluid">
                </div>
                <div class="col-8 col-md-4">
                  @{{ item.product_sku.product.title.toLowerCase().replace(/^(.)|\s(.)/g, function ( $1 ) { return $1.toUpperCase();}) }}
                  <br>
                  <p class="text-muted mb-0 font-small">Размер:
                    @{{ item.product_sku.skus ? item.product_sku.skus.title : 'One Size' }}
                  </p>
                  <p class="text-muted mt-0 pt-0 font-small">
                    @{{ item.product_sku.product.isPromotion ? 'По акци:' + item.product_sku.product.namePromotion : '' }}
                  </p>
                </div>
                <div class="col-4 col-md">
                  <div class="row m-0">
                    <div class="col-2 m-0 p-0 d-flex justify-content-center">
                      <button class="p-0 m-0 bg-transparent btn-angle h-100" @click="removeCounter"><i class="fal fa-minus mt-1"></i></button>
                    </div>
                    <div class="col-6 m-0 p-0">
                      <input class="form-control w-100 bg-white border-0 m-0 px-0 font-weight-bolder text-center" type="text" v-model.number="cartItem.amount" readonly disabled>
                    </div>
                    <div class="col-2 m-0 p-0 d-flex justify-content-center">
                      <button class="p-0 m-0 bg-transparent btn-angle h-100" @click="addCounter"><i class="fal fa-plus mt-1"></i></button>
                    </div>
                  </div>
                </div>
                <div class="col-4 col-md text-center">
                  @{{ item.product_sku.product.on_sale && item.product_sku.product.price_sale ? $cost(Number(item.product_sku.product.price_sale) * currency.ratio)  : $cost(Number(item.product_sku.product.price) * currency.ratio) }} @{{currency.symbol}}
                </div>
                <div class="col-4 col-md">
                  <button class="btn-angle d-block w-100 m-0" @click="deleteItem"><i class="fal fa-times"></i></button>
                </div>
              </div>
            </mini-cart-item>
            <div class="row mt-2 justify-content-center align-items-center" v-if="cartItems.length < 1">
              <p>Нет товаров</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 mt-3 d-flex justify-content-end">
        <a class="btn btn-dark font-weight-bold col-12 col-sm-auto rounded-0" href="{{ route('orders.create') }}" id="offer-payment">Перейти к оформелению заказа</a>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
