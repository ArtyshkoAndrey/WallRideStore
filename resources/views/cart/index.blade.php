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
{{--            {{ dd($currency->ratio) }}--}}
            <input type="text" value="{{ auth()->user() ?  auth()->user()->name : '' }}" name="name" class="w-100 py-2 px-2 mt-2" placeholder="Имя">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-8 mt-3 mt-sm-0">
        <div class="card">
          <div class="card-body">
            @forelse($cartItems as $item)
              <mini-cart-item :id="{{isset($item->productSku) ? $item->productSku->id : $item['productSku']->id}}" :item="{{ json_encode($item) }}" :currency="{{$currency}}" inline-template>
                <div class="row mt-2 justify-content-center align-items-center">
                  <div class="col-md col-4">
                    <img src="{{ isset($item->productSku) ?
                      $item->productSku->product->photos ?
                        asset('storage/products/' . $item->productSku->product->photos()->first()->name) :
                        'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png' :
                      $item['productSku']->product->photos ?
                        asset('storage/products/' . $item['productSku']->product->photos()->first()->name) :
                        'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png' }}" class="img-fluid">
                  </div>
                  <div class="col-8 col-md-4">
                    {{ ucwords(strtolower(isset($item->productSku) ? $item->productSku->product->title : $item['productSku']->product->title )) }}
                    <br>
                    <p class="text-muted font-small">Размер: {{isset($item->productSku) ?  $item->productSku->skus ? $item->productSku->skus->title : 'One Size' : $item['productSku']->skus ? $item['productSku']->skus->title : 'One Size' }}</p>
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
                    {{ cost(round(isset($item->productSku) ? $item->productSku->product->price : $item['productSku']->product->price  * $currency->ratio, 0)) }} {{ $currency->symbol }}
                  </div>
                  <div class="col-4 col-md">
                    <button class="btn-angle d-block w-100 m-0" @click="deleteItem"><i class="fal fa-times"></i></button>
                  </div>
                </div>
              </mini-cart-item>
            @empty
              <h3 class="font-weight-bold mt-3">Корзина пуста</h3>
            @endforelse
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
