@extends('layouts.app')
@section('title', 'Оформление заказа')

@section('content')
  <section class="container mt-5 pt-5 mb-5" id="cart">
    <create-order :amount="{{ $amount }}" :currency="{{ $currency }}" :cart_items="{{ json_encode($cartItems) }}" :pays="{{ json_encode((array) $pays) }}" inline-template>
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-12 col-md-6">
              <h1 class="font-weight-bold">Оформление заказа</h1>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="card">
            <div class="card-body mt-2">
              <h4 class="font-weight-bold">Контактные данные</h4>
              <input type="text" value="{{ auth()->user() ?  auth()->user()->name : '' }}" v-model="order.name" name="username" class="w-100 py-2 px-2 mt-2" placeholder="Имя">
              <input type="email" value="{{ auth()->user() ?  auth()->user()->email : '' }}" v-model="order.email" name="email" class="w-100 py-2 px-2 mt-2" placeholder="E-mail">
              <input type="text" maxlength="14" value="{{ auth()->user() ? auth()->user()->address !== null ? auth()->user()->address->contact_phone !== null ? auth()->user()->address->contact_phone : '' : '' : '' }}" v-model="order.phone" id="contact_phone" name="contact_phone" class="w-100 py-2 px-2 mt-2" placeholder="Телефон">

              <h4 class="font-weight-bold mt-4">Адрессные данные</h4>

              <div class="mt-2">
                <select name="country" id="country" class="rounded-0 mt-2 form-control" placeholder="Страна">
                  @if (auth()->user())
                    @if (auth()->user()->address !== null)
                      <option value="{{ auth()->user()->address->country_id }}" selected>{{ auth()->user()->address->country->name}}</option>
                    @endif
                  @endif
                </select>
              </div>

              <div class="mt-2">
                <select name="city" id="city1" class="rounded-0 mt-2 form-control" placeholder="Город">
                  @if (auth()->user())
                    @if (auth()->user()->address !== null)
                      <option value="{{auth()->user()->address->city_id }}" selected>{{ auth()->user()->address->city->name }}</option>
                    @endif
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
              <div class="checkbox mt-3">
                <label>
                  <input type="checkbox" data-ng-model="example.check" name="privacy" id="privacy" required>
                  <span class="box"></span>
                  <span>Я принимаю условия <a href="{{ route('policy') }}" target="_blank" class="c-red text-danger">политики конфиденциальности</a></span>
                </label>
              </div>

            </div>
          </div>
        </div>

        <div class="col-12 col-md-8 mt-3 mt-md-0">

          <div class="card">
            <div class="card-body">
              @if(count($cartItems) > 0)
                @php($item = $cartItems[0])
                <div class="row mt-3 justify-content-between align-items-center">
                  <div class="col-md-2 col-4">
                    <img src="{{ $item['product_sku']->product->photos && count($item['product_sku']->product->photos) > 0 ? asset('storage/products/' . $item['product_sku']->product->photos[0]->name) : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png' }}" class="img-fluid" alt="{{ $item['product_sku']->product->title }}">
                  </div>
                  <div class="col-4 col-md-4">
                    {{ ucwords(strtolower($item['product_sku']->product->title)) }}
                    <br>
                    <p class="text-muted font-small">Размер: {{ isset($item['product_sku']->skus) ? $item['product_sku']->skus->title : 'One Size' }}</p>
                  </div>
                  <div class="col col-md text-right font-weight-bold">
                    {{ cost(round(($item['product_sku']->product->on_sale ? $item['product_sku']->product->price_sale : $item['product_sku']->product->price) * $currency->ratio, 0)) }} {{ $currency->symbol }} X {{ $item['amount'] }}
                  </div>
                </div>
              @endif

              @if(count($cartItems) > 1)
              <div class="collapse multi-collapse" id="multiCollapseExample1">
                @foreach($cartItems as $index => $item)
                  @if ($index >= 1)
                    <div class="row mt-3 justify-content-between align-items-center">
                      <div class="col-md-2 offset-md-1 col-4">
                        <img src="{{ $item['product_sku']->product->photos && count($item['product_sku']->product->photos) > 0 ? asset('storage/products/' . $item['product_sku']->product->photos[0]->name) : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png' }}" class="img-fluid" alt="{{ $item['product_sku']->product->title }}">
                      </div>
                      <div class="col-4 col-md-4">
                        {{ ucwords(strtolower($item['product_sku']->product->title)) }}
                        <br>
                        <p class="text-muted font-small">Размер: {{ isset($item['product_sku']->skus) ? $item['product_sku']->skus->title : 'One Size' }}</p>
                      </div>
                      <div class="col col-md text-right font-weight-bold">
                        {{ cost(round(($item['product_sku']->product->on_sale ? $item['product_sku']->product->price_sale : $item['product_sku']->product->price) * $currency->ratio, 0)) }} {{ $currency->symbol }} X {{ $item['amount'] }}
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="row justify-content-center">
                <div class="col-auto">
                  <a class="btn btn-dark mx-auto d-block w-auto mt-2" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Все товары</a>
                </div>
              </div>

              @endif

              <div class="row">
                <div class="col-md-6 mb-3 mx-0">
                  <h5 class="font-weight-bold">Методы доставки</h5>
                  <div class="btn-group">
                    <div v-for="(company) in getCompanies" class="btn p-0 rounded-0 border-0 mr-2">
                      <label  :class="'company-item btn-white rounded-0 p-3 mb-0 h-100 d-flex align-items-center justify-content-center ' +  (getCompany === company ? 'active' : '')" @click="setCompany(company)" style="min-width: 100px;">
                        @{{ company.name }}
                      </label>
                      <p class="m-0 p-0 text-center w-100 position-absolute font-weight-bold">@{{ $cost(company.costedTransfer * currency.ratio) + ' ' + currency.symbol }}</p>
                    </div>
                  </div>
                </div>
{{--                <div class="col-md-8 mt-3">--}}
{{--                  <h5 class="font-weight-bold">Как будете платить?</h5>--}}
{{--                  <div class="btn-group btn-group-toggle mr-2" data-toggle="buttons" v-if="getCompany !== null">--}}
{{--                    <label v-if="getCompany.enabled_card" :class="'btn btn-white border-0 rounded-0 p-3 ' + (getMethod === 'card' ? 'active' : '')" @click="setMethod('card')">--}}
{{--                      <input type="radio" value="card" name="payment_method" id="option5" autocomplete="off"> <i class="fal fa-credit-card-front"></i> Оплатить онлайн--}}
{{--                    </label>--}}
{{--                    <label v-if="getCompany.enabled_cash" :class="'btn btn-white border-0 rounded-0 p-3 mr-2 ' + (getMethod === 'cash' ? 'active' : '')" @click="setMethod('cash')">--}}
{{--                      <input type="radio" value="cash" name="payment_method" id="option6" autocomplete="off"> <i class="fad fa-coins"></i> Наличными--}}
{{--                    </label>--}}
{{--                  </div>--}}
{{--                </div>--}}

                <div class="col-md-8 mt-3">
                  <h5 class="font-weight-bold">Сервис оплаты?</h5>
                  <div class="btn-group btn-group-toggle mr-2" data-toggle="buttons" v-if="getCompany !== null">
                    <label v-if="pays.paybox.enabled" :class="'btn btn-white border-0 rounded-0 p-3 ' + (getService === 'Paybox' ? 'active' : '')" @click="setService('Paybox')">
                      <input type="radio" value="card" name="payment_method" id="option5" autocomplete="off"> Paybox
                    </label>

                    <label v-if="pays.cloudpayment.enabled" :class="'btn btn-white border-0 rounded-0 p-3 mr-2 ' + (getService === 'PayPal' ? 'active' : '')" @click="setService('PayPal')">
                      <input type="radio" value="cash" name="payment_method" id="option6" autocomplete="off"> PayPal
                    </label>

                    <label v-if="pays.paypal.enabled" :class="'btn btn-white border-0 rounded-0 p-3 mr-2 ' + (getService === 'CloudPayment' ? 'active' : '')" @click="setService('CloudPayment')">
                      <input type="radio" value="cash" name="payment_method" id="option6" autocomplete="off"> CloudPayment
                    </label>
                    <label v-if="getCompany.enabled_cash" :class="'btn btn-white border-0 rounded-0 p-3 mr-2 ' + (getMethod === 'cash' ? 'active' : '')" @click="setMethod('cash')">
                      <input type="radio" value="cash" name="payment_method" id="option6" autocomplete="off"> <i class="fad fa-coins"></i> Наличными
                    </label>
                  </div>
                </div>
              </div>


            </div>
          </div>

        </div>
        <div class="col-12 mt-3">
          <div class="justify-content-between row">
            <div class="col-sm-auto col-12 ml-2 ml-sm-0">
              <h4 ref="totalAmountBottom">Общая сумма {{ cost(round($priceAmount * $currency->ratio, 0)) }} {{ $currency->symbol }}</h4>
            </div>
            <div class="col-sm-auto col-12 mt-2 mt-sm-0">
              <button class="btn btn-dark rounded-0" @click="ordered" id="offer-payment">Завершить оформление заказа и оплатить</button>
            </div>
          </div>
        </div>
      </div>
    </create-order>
  </section>

@endsection

@section('scriptsAfterJs')
  <script>
    $('#country').select2({
      width: '100%',
      placeholder: '*Страна',
      "language": {
        "noResults": function(){
          return "Нет результатов";
        },
      },
      ajax: {
        type: "POST",
        dataType: 'json',
        url: function (params) {
          return '{{ route('api.country', '') }}' + '/' + params.term;
        },
        processResults: function (data) {
          return {
            results: data.items.map((e) => {
              return {
                text: e.name,
                id: e.id
              };
            })
          };
        }
      }
    })

    $('#city1').select2({
      width: '100%',
      placeholder: '*Город',
      "language": {
        "noResults": function(){
          return "Нет результатов";
        },
      },
      ajax: {
        type: "POST",
        dataType: 'json',
        url: function (params) {
          return '{{ route('api.city', '') }}' + '/' + params.term;
        },
        processResults: function (data) {
          return {
            results: data.items.map((e) => {
              return {
                text: e.name,
                id: e.id
              };
            })
          };
        }
      }
    });
  </script>
@endsection
