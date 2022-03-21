@extends('user.layouts.app')
@section('title', 'Оплата товаров')

@section('style')
  <style>
  </style>
@endsection

@section('content')
  <div class="container mt-2 order-create-page pb-5">
    <order inline-template >
      <transition name="slide-fade" mode="out-in" appear>
        <div key="windowOrder" class="row justify-content-start flex-column flex-md-row mt-5" v-if="!windowsLoader">
          <div class="col-12 col-md-7">
            <div class="row">

              <div class="col-12 mb-4">
                <p class="h4 title">{{ __('Адрес доставки') }}</p>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <country :id="'country'"
                         :name="'country'"
                         v-on:set="setCountry"
                         :country_props="{{ json_encode(auth()->user()->country ?? null) }}"
                         ref="country"></country>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <city :id="'city'"
                      :name="'city'"
                      v-on:set="setCity"
                      :city_props="{{ json_encode(auth()->user()->city ?? null, JSON_THROW_ON_ERROR) }}"
                      ref="city"></city>
              </div>

              <div class="col-md-6 mb-3">
                <div class="form-outline">
                  <input type="text"
                         id="address"
                         name="address"
                         class="form-control {{ (auth()->user()->address ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->address ?? null }}"
                         @input="setAddress"/>
                  <label class="form-label"
                         for="address">
                    {{ __('Точный адрес') }}
                    <span class="required">*</span>
                  </label>
                </div>
              </div>

              <div class="col-md-6 mb-5">
                <div class="form-outline">
                  <input type="text"
                         id="post_code"
                         name="post_code"
                         class="form-control {{ (auth()->user()->post_code ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->post_code ?? null }}"
                         @input="setPostCode"/>
                  <label class="form-label"
                         for="post_code">
                    {{ __('Индекс') }}
                    <span class="required">*</span>
                  </label>
                </div>
              </div>

              <div class="col-12 mb-4">
                <p class="h4 title">{{ __('Контактные данные') }}</p>
              </div>

              <div class="col-12 mb-3">
                <div class="form-outline">
                  <input type="text"
                         id="name"
                         name="name"
                         class="form-control {{ (auth()->user()->name ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->name ?? null }}"
                         @input="setName"/>
                  <label class="form-label"
                         for="name">
                    {{ __('ФИО') }}
                    <span class="required">*</span>
                  </label>
                </div>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <div class="form-outline">
                  <input type="email"
                         id="email"
                         name="email"
                         class="form-control {{ (auth()->user()->email ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->email ?? null }}"
                         @input="setEmail" />
                  <label class="form-label"
                         for="email">
                    E-mail
                    <span class="required">*</span>
                  </label>
                </div>
              </div>

              <div class="col-12 col-md-6 mb-5">
                <div class="form-outline">
                  <input id="phone"
                         name="phone"
                         type="tel"
                         class="form-control {{ (auth()->user()->phone ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->phone ?? '' }}"
                         placeholder="+7 (999) 999-99-99"
                         @input="setPhone"/>
                  <label class="form-label"
                         for="phone">
                    {{ __('Телефон') }}
                    <span class="required">*</span>
                  </label>
                </div>
              </div>

              <div class="col-12 mb-4">
                <p class="h4 title">{{ __('Доставка') }}</p>
              </div>

              <transition name="slide-fade" mode="out-in" appear>
                <div class="col-12 mb-3" v-if="info.city ? info.city.pickup : false" key="1">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="flexRadioDefault"
                        id="flexRadioDefault0"
                        checked = "true"
                        @click="setPickupTransfer"
                      />
                    </div>
                    <div class="col ps-0">
                      <label class="form-check-label d-block ps-2" for="flexRadioDefault0">
                        <strong>{{ __('Самовывоз из магазина') }} - 0 @{{ $store.state.currency.symbol }}</strong>
                        <br>
                        <span class="text-muted">{{ __('Закажите онлайн и заберите в нашем магазине') }}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </transition>

              <transition name="slide-fade" mode="out-in" appear>
                <div class="col-12 mb-3" v-if="!ems.error && ems.price !== null && freeCompany === false" :key="1">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="flexRadioDefault"
                        id="flexRadioDefault2"
                        checked="true"
                        @click="setEmsTransfer"
                      />
                    </div>
                    <div class="col ps-0">
                      <label class="form-check-label d-block ps-2" for="flexRadioDefault2">
                        <strong>{{ __('Стандартная доставка') }} - @{{ $cost(ems.price * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</strong>
                        <br>
                        <span class="text-muted">{{ __('Доставка осуществляется от 4 до 7 дней сервисом Kaz Post') }}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </transition>
              <transition-group>
                <div class="col-12 mb-3" v-for="company in customCompanies" :key="company.id">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="flexRadioDefault"
                        :id="'flexRadioDefault-' + company.name"
                        :checked="transfer.name === company.name"
                        @click="setCompanyTransfer(company)"
                      />
                    </div>
                    <div class="col ps-0">
                      <label class="form-check-label d-block ps-2" :for="'flexRadioDefault-' + company.name">
                        <strong>@{{ company.name }} - @{{ $cost(company.price * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</strong>
                        <br>
                        <span class="text-muted">@{{ company.description }}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </transition-group>

              <transition name="slide-fade" mode="out-in" appear>
                <div v-if="checkTransferZero" key="1">
                  <p class="text-danger">{{ __('В ваш город нету ни одной доставки') }}</p>
                  <a target="_blank" href="https://wa.me/+77475562383?text=Здравствуйте!%20На%20вашем%20сайте%20нет%20моего%20города%20для%20доставки">{{ __('Написать в поддержку') }}</a>
                </div>
              </transition>

              <transition name="slide-fade" mode="out-in" appear>
                <div class="col-12" v-if="transfer.name !== null">
                  <div class="row">
                    <div class="col-12 mb-4">
                      <p class="h4 title">{{ __('Оплата') }}</p>
                    </div>
                    @if($cash  &&  $cash->data === '1')
                      <div class="col-12 mb-3" v-if="transfer.name !== 'ems' && transfer.enabled_cash || transfer.name === 'pickup'">
                        <div class="row choosable-field align-items-center">
                          <div class="col-auto">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="cash"
                              id='cash'
                              :checked="method_pay === 'cash'"
                              @click="setCashMethod"
                            />
                          </div>
                          <div class="col">
                            <label class="form-check-label d-block ps-2" for="cash">
                              <strong>{{ __('Оплата при получении') }}</strong>
                              <br>
                              <span class="text-muted">{{ __('Оплатите курьеру или в магазине после получения') }}</span>
                            </label>
                          </div>
                        </div>
                      </div>
                    @endif

                    @if($cloudPayment  &&  $cloudPayment->data === '1')
                      <div class="col-12 mb-3">
                        {{--                      <div class="col-12 mb-3" v-if="!isNaN(transfer.enabled_card) ? transfer.enabled_card : true">--}}
                        <div class="row choosable-field align-items-center">
                          <div class="col-auto">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="cloudPay"
                              id='cloudPayment'
                              :checked="method_pay === 'cloudPayment'"
                              @click="setCloudPaymentMethod"
                            />
                          </div>
                          <div class="col">
                            <label class="form-check-label d-block ps-2" for="cloudPayment">
                              <strong>{{ __('Оплатить онлайн') }}</strong>
                              <br>
                              {{--                              <span class="text-muted">{{ __('Оплатите онлайн любым удобным способом через сервис cloud payments') }}</span>--}}
                            </label>
                          </div>
                        </div>
                      </div>
                    @endif

                    <div class="col-12 mb-3">
                      <div class="row choosable-field align-items-center">
                        <div class="col-auto">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="qr"
                            id='qr'
                            :checked="method_pay === 'qr'"
                            @click="method_pay = 'qr'"
                          />
                        </div>
                        <div class="col">
                          <label class="form-check-label d-block ps-2" for="qr">
                            <strong>{{ __('Оплатить онлайн') }}</strong>
                            <br>
                          </label>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </transition>
            </div>
          </div>
          <div class="col-12 col-md-5">
            <div class="row">
              <div class="col-12 justify-content-end d-flex mb-3 mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none" v-if="!$store.state.auth" style="font-size: .9em;">{{ __('Для более удобного оформления заказа, советуем войти в ваш аккаунт') }}</a>
              </div>
              <div class="col-12 mb-2" :class="$store.state.auth ? 'mt-3' : null">
                <div class="order-results">
                  <div class="row">
                    <div class="col-12">
                      <span>{{ __('Сумма покупок') }}</span>
                      <span>@{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12">
                      <span>{{ __('Доставка') }}</span>
                      <span>@{{ $cost(transfer.price * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12" v-if="sale">
                      <span>{{ __('Скидка') }}</span>
                      <span>- @{{ $cost(price_with_sale * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12">
                      <span>{{ __('Итог заказа') }}</span>
                      <span class="font-weight-bold">@{{ $cost(price) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-outline">
                  <input type="text" id="promocode" name="promocode" class="form-control" v-model="code"/>
                  <label class="form-label" for="promocode">{{ __('Введите промокод (при наличии)') }}</label>
                </div>
              </div>
              <div class="col-12 mb-5">
                <button @click="checkSale" class="btn btn-dark d-block w-100 mt-2 py-3 promocode-button" :disabled="disabledButtonCode">{{ __('Активировать промокод') }}</button>
              </div>

              <div class="col-12">
                <div class="row">
                  <div class="col-12 mb-3">
                    <span class="h5 title">{{ __('Позиции заказа') }}</span>
                  </div>
                  <transition name="slide-fade" mode="out-in" appear>
                    <div class="col-12" v-if="!$root.cartLoader" key="products">
                      <div class="row">
                        <div class="col-12 mb-3" v-for="product in $store.getters.productsCart">
                          <div class="row">
                            <div class="col-3">
                              <img :src="product.thumbnail_jpg" :alt="product.title" class="w-100" style="object-fit: cover">
                            </div>
                            <div class="col-9 d-flex flex-column justify-content-around pl-0"
                                 style="border-bottom: 1px solid #E9EAEC;">
                              <span style="font-weight: 500;">@{{ product.title }}</span>
                              <span class="font-weight-bold">
                            @{{ $cost((product.on_sale ? product.price_sale : product.price) * $store.state.currency.ratio * product.item.amount) }} @{{ $store.state.currency.symbol }}
                          </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12" v-else key="loader">
                      <div class="row justify-content-center">
                        <div class="col-auto">
                          <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </transition>

                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-7">
            <div class="row">
              <div class="col-md-6 d-flex">
                <button class="btn btn-dark complete" id="checkout" @click="cashQr" :disabled="disabledButton">
                  <span v-if="!loaderButton">{{ __('Завершить и перейти к оплате') }}</span>
                  <div v-else class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </button>
{{--                TODO: Востановить ниже код потом--}}
{{--                <button class="btn btn-dark complete" id="checkout" @click="orderedNow" :disabled="disabledButton">--}}
{{--                  <span v-if="!loaderButton">{{ __('Завершить и перейти к оплате') }}</span>--}}
{{--                  <div v-else class="spinner-border text-light" role="status">--}}
{{--                    <span class="visually-hidden">Loading...</span>--}}
{{--                  </div>--}}
{{--                </button>--}}
              </div>

{{--              TODO: Убрано завершить попозже--}}
{{--              <div class="col-md-6 d-flex">--}}
{{--                <button class="btn btn-outline-dark complete" @click="orderAfter" data-mdb-ripple-color="dark" id="checkout" :disabled="disabledButtonAfter">--}}
{{--                  <span v-if="!loaderButtonAfter">{{ __('Завершить и оплатить позже') }}</span>--}}

{{--                  <div v-else class="spinner-border text-dark" role="status">--}}
{{--                    <span class="visually-hidden">Loading...</span>--}}
{{--                  </div>--}}
{{--                </button>--}}
{{--              </div>--}}

{{--              TODO: востановить выше код что бы можно было оплатить потом--}}
            </div>
          </div>
        </div>

        <div v-else key="loaderWindow" class="mt-5">
          <div class="row">
            <div class="col-12 text-center">
              <h3>
                Необходимо оплатить заказ через сервис KaspiBank
                <br>
                Отсканируйте QR код или перейдите по ссылке
              </h3>
              <span class="text-muted">Оплатите заказ через KaspiBank, а после подвердите нажав на кнопку "Подвердить"</span>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-12 mt-3 col-md-6 col-lg-3">
              <img src="{{ asset('images/qr_kispibank.jpg') }}" class="img-fluid" alt="qr">
            </div>
          </div>
          <div class="row mt-3 justify-content-center">
            <div class="col-12 col-md-6 col-lg-3">
              <a class="btn btn-black d-block" target="_blank" href="https://pay.kaspi.kz/pay/t7w6tcen">Оплатить заказ</a>
            </div>
          </div>
          <div class="row mt-5 justify-content-center">
            <div class="col-10 col-md-6 col-lg-5">
              <span class="text-muted">В случае не оплаты, Ваш заказ отменят. В нелёгкое время, администраторы проверяют оплату и заказ в ручную. Но скоро всё наладится</span>
            </div>
          </div>

          <div class="row mt-3 justify-content-center">
            <div class="col-12 col-md-6 col-lg-3">
              <button class="btn btn-dark d-block w-100" @click="payQr">Подвердить</button>
            </div>
          </div>
        </div>

{{--        TODO: Востановить код ниже что бы показывать об проверки оплаты заказа--}}
{{--        <div v-else key="loaderWindow" class="mt-5">--}}
{{--          <div class="row">--}}
{{--            <div class="col-12 text-center">--}}
{{--              <h3><strong>{{ __('Не закрывайте браузер.') }}</strong> {{ __('Ожидаем подтверждения оплаты') }}. {{ __('Иначе он будет отменён') }}</h3>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <div class="row justify-content-center my-5">--}}
{{--            <div class="col-auto">--}}
{{--              <div class="spinner-border" role="status">--}}
{{--                <span class="visually-hidden">Loading...</span>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
      </transition>

    </order>

  </div>
@endsection

@section('js')
  <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
  {{--  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>--}}
  {{--  <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@3.3.7/dist/inputmask/inputmask.js"></script>--}}
  {{--  <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@3.3.7/dist/inputmask/inputmask.extensions.js"></script>--}}
  {{--  <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@3.3.7/dist/inputmask/inputmask.numeric.extensions.js"></script>--}}
  {{--  <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@3.3.7/dist/inputmask/inputmask.date.extensions.js"></script>--}}
  {{--  <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@3.3.7/dist/inputmask/inputmask.phone.extensions.js"></script>--}}
  {{--  <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@3.3.7/dist/inputmask/jquery.inputmask.js"></script>--}}
  {{--  <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@3.3.7/dist/inputmask/phone-codes/phone.js"></script>--}}

  <script>
    // $('#phone').mask('+7 (000) 000-00-00')
    // $('#phone').inputmask({ alias: "phone"});
  </script>
@endsection
