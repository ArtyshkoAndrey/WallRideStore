@extends('layouts.app')
@section('title', 'Оформление заказа')

@section('content')
  <section class="container mt-5 pt-5 mb-5" id="cart">
    <create-order :amount="{{ $amount }}" :pickup="{{ $pickup }}" :currency="{{ $currency }}" :express_companies="{{ json_encode($express_companies) }}" :cart_items="{{ json_encode($cartItems) }}" inline-template>
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-12 col-md-6">
              <h1 class="font-weight-bold">Оформление заказа</h1>
            </div>
            <div class="col-12 mb-2 mb-md-0 col-md-6 text-left text-md-right">
              <h2 v-if="step === 1"><span class="c-red" style="border-bottom: 3px solid #F33C3C">Шаг 1</span> <span class="ml-3" style="color: #A3A3A3">Шаг 2</span></h2>
              <h2 v-else><span @click="step = 1" style="color: #A3A3A3; cursor: pointer">Шаг 1</span> <span class="c-red ml-3" style="border-bottom: 3px solid #F33C3C" >Шаг 2</span></h2>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card">
            <div class="card-body mt-2" v-if="step === 1">
              <h4 class="font-weight-bold">Контактные данные</h4>
              <input type="text" value="{{ auth()->user() ?  auth()->user()->name : '' }}" v-model="order.name" name="username" class="w-100 py-2 px-2 mt-2" placeholder="Имя">
              <input type="email" value="{{ auth()->user() ?  auth()->user()->email : '' }}" v-model="order.email" name="email" class="w-100 py-2 px-2 mt-2" placeholder="E-mail">
              <input type="text" maxlength="14" value="{{ auth()->user() ? auth()->user()->address !== null ? auth()->user()->address->contact_phone !== null ? auth()->user()->address->contact_phone : '' : '' : '' }}" v-model="order.phone" id="contact_phone" name="contact_phone" class="w-100 py-2 px-2 mt-2" placeholder="Телефон">
            </div>
            <div class="card-body mt-2" v-else>
              <h4 class="font-weight-bold">Адрессные данные</h4>
              <div class="mt-2">
                <select name="country" id="country" v-model="order.country" class="rounded-0 mt-2 form-control" placeholder="Страна">
                  @if (auth()->user() ? auth()->user()->address !== null : $_COOKIE['city'] !== null)
                    <option value="{{ auth()->user() ? auth()->user()->address->country_id : App\Models\City::find($_COOKIE['city'])->country->id }}" selected>{{ auth()->user() ? auth()->user()->address->country->name : App\Models\City::find($_COOKIE['city'])->country->name }}</option>
                  @endif
                </select>
              </div>
              <div class="mt-2">
                <select name="city" id="city1" class="rounded-0 mt-2 form-control" v-model="order.city" placeholder="Город">
                  @if (auth()->user() ? auth()->user()->address !== null : $_COOKIE['city'] !== null)
                    <option value="{{ auth()->user() ?  auth()->user()->address->city_id : $_COOKIE['city'] }}" selected>{{ auth()->user() ? auth()->user()->address->city->name : App\Models\City::find($_COOKIE['city'])->name }}</option>
                  @endif
                </select>
              </div>
              <input type="text" value="{{ auth()->user() ? auth()->user()->address !== null ? auth()->user()->address->street !== null ? auth()->user()->address->street : '' : '' : ''}}" v-model="order.street" name="street" class="w-100 py-2 px-2 mt-2" placeholder="Адрес">
              <div class="mt-2">
                <div class="row">
                  <div class="col-8">
                    <input type="text" id="coupon" v-model="order.coupon" class="form-control rounded-0" placeholder="Промокод">
                  </div>
                  <div class="col-4 p-0">
                    <button class="btn rounded-0 bg-dark text-white" id="checkCoupon" @click="checkCoupon">Применить</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-8 mt-3 mt-md-0">
          <div class="card">
            <div class="card-body" v-if="step === 1">
              @forelse($cartItems as $item)
                <div class="row mt-3 justify-content-center align-items-center">
                  <div class="col-md-2 offset-md-1 col-4">
                    <img src="{{ $item->productSku->product->photos()->get()->toArray() ?  asset('storage/products/' . $item->productSku->product->photos()->first()->name) : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png' }}" class="img-fluid" alt="{{ $item->productSku->product->title }}">
                  </div>
                  <div class="col-4 col-md-4">
                    {{ ucwords(strtolower($item->productSku->product->title)) }}
                    <br>
                    <p class="text-muted font-small">Размер: {{ $item->productSku->skus ? $item->productSku->skus->title : 'One Size' }}</p>
                  </div>
                  <div class="col-4 col-md text-center font-weight-bold">
                    {{ cost(round(($item->productSku->product->on_sale ? $item->productSku->product->price_sale : $item->productSku->product->price) * $currency->ratio, 0)) }} {{ $currency->symbol }} X {{ $item->amount }}
                  </div>
                </div>
              @empty
                <h3 class="font-weight-bold mt-3">Корзина пуста</h3>
              @endforelse
            </div>

            <div class="card-body mt-3 mt-sm-0" v-else>
              <div class="row p-2">
                <div class="col-12" v-if="Number(order.country) === 1">
                  <p class="text-danger m-0" style="font-size: 12px;">В связи с коронавирусом, доставка осуществляется от 2-х недель</p>
                </div>
                <div class="col-md-6 mb-3">
                  <h5 class="font-weight-bold">Методы доставки</h5>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <div v-for="(company, index) in companies" v-if="!isNaN(company.costedTransfer) && company.costedTransfer !== null && company.enabled === true" class="btn p-0 rounded-0 border-0 ml-2" :disabled="company.costedTransfer == null || company.enabled == false">
                      <label  class="btn-white border-0 rounded-0 p-3 mb-0 h-100 d-flex align-items-center justify-content-center" style="min-width: 100px;" :disabled="company.costedTransfer == null" @click="() => { !order.pickup && company.costedTransfer !== null ? (order.express_company = company.id, order.costTransfer = company.costedTransfer) : null}">
                        <input type="radio" :value="company.id" name="express_company" autocomplete="off" :checked="order.express_company === company.id">
                        @{{ company.name }}
                      </label>
                      <p class="m-0 p-0 text-center w-100 position-absolute font-weight-bold">@{{ !isNaN(company.costedTransfer) && company.costedTransfer !== null ? $cost(Number(company.costedTransfer)) + ' тг.' : '' }}</p>
                    </div>
                    <label class="btn btn-white border-0 rounded-0 p-3 ml-2" v-if="pickup.enabled" :disabled="pickup.enabled === false" @click="() => {pickup.enabled ? order.pickup = true : null}">
                      <input type="radio" name="express_company_pickup" id="option2" autocomplete="off" :checked="order.pickup === true"> <i class="fal fa-shopping-basket"></i> Самовывоз
                    </label>
                  </div>
                </div>
                {{--                <div class="col-md-6 mt-3 mt-md-0">--}}
                {{--                  <h5 class="font-weight-bold">Выберите службу доставки</h5>--}}
                {{--                  <div class="btn-group btn-group-toggle" data-toggle="buttons" v-if="!order.pickup">--}}
                {{--                    <div v-for="(company, index) in companies" v-if="!isNaN(company.costedTransfer) && company.costedTransfer !== null" class="btn p-0 rounded-0 border-0 ml-2" :disabled="order.pickup || company.costedTransfer == null || company.enabled == false">--}}
                {{--                      <label  class="btn-white border-0 rounded-0 p-3 mb-0" :disabled="order.pickup || company.costedTransfer == null" @click="() => { !order.pickup && company.costedTransfer !== null ? (order.express_company = company.id, order.costTransfer = company.costedTransfer) : null}">--}}
                {{--                        <input type="radio" :value="company.id" name="express_company" autocomplete="off" :checked="order.express_company === company.id">--}}
                {{--                        @{{ company.name }}--}}
                {{--                      </label>--}}
                {{--                      <p class="m-0 p-0 position-absolute font-weight-bold">@{{ !isNaN(company.costedTransfer) && company.costedTransfer !== null ? $cost(Number(company.costedTransfer)) + ' тг.' : '' }}</p>--}}
                {{--                    </div>--}}
                {{--                  </div>--}}

                {{--                  <div v-else class="mt-3">--}}
                {{--                    <p class="m-0 p-0 d-flex">Вы можете забрать свой заказ по адресу мкр.Самал-3, 1</p>--}}
                {{--                  </div>--}}
                {{--                </div>--}}
                <div class="col-md-8 mt-3">
                  <h5 class="font-weight-bold">Как будете платить?</h5>
                  <div class="btn-group btn-group-toggle ml-2" data-toggle="buttons">
                    <label class="btn btn-white border-0 rounded-0 p-3" @click="() => {order.payment_method = 'card'}">
                      <input type="radio" value="card" name="payment_method" id="option5" autocomplete="off" :checked="order.payment_method === 'card'"> <i class="fal fa-credit-card-front"></i> Оплатить онлайн
                    </label>
                    <label class="btn btn-white border-0 rounded-0 p-3 ml-2" v-if="getCompany.enabled_cash" :disabled="getCompany ? getCompany.enabled_cash === false : true" @click="() => {getCompany ? getCompany.enabled_cash ? order.payment_method = 'cash' : null : null}">
                      <input type="radio" value="cash" name="payment_method" id="option6" autocomplete="off" :checked="order.payment_method === 'cash'"> <i class="fad fa-coins"></i> Наличными
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 mt-3">
          <div :class="(step === 1 ? 'justify-content-end' : 'justify-content-between') + ' row'">
            <div class="col-sm-auto col-12 ml-2 ml-sm-0" v-if="step === 2">
              <h4 ref="totalAmountBottom">Общая сумма {{ cost(round($priceAmount * $currency->ratio, 0)) }} {{ $currency->symbol }}</h4>
            </div>
            <div class="col-sm-auto col-12 mt-2 mt-sm-0">
              <button v-if="step === 1" class="btn btn-dark rounded-0" @click="ordered" id="offer-payment">Следующий шаг</button>
              <button v-else class="btn btn-dark rounded-0" @click="ordered" id="offer-payment">Завершить оформление заказа и оплатить</button>
            </div>
          </div>
        </div>
      </div>
    </create-order>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
