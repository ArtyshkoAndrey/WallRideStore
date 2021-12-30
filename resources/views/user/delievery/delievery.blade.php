@extends('user.layouts.app')

@section('title', 'Главная страница')

@section('content')

  <section class="container py-5" id="profile">
    <div class="container mt-2 cart-page pb-5">

      <div class="row banner_delievery">
        <div class="col-md-6 col-sm-12" >
          <div class="inner">
            <h2><strong>Доставляем ваши заказы<br/>
                в течение недели</strong></h2>
            <p>Мы доставляем заказы по всему миру</p>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <img src="{{'/images/car.png' }}" width="100%"/>
        </div>
      </div>
      <div class="row container delievery_container">
        <div class="col-md-4 col-sm-12">
          <div class="row">
            <div class="col-12">
              <h3>Алматы</h3>
            </div>
            <div class="col-12">
              <h4>Доставка</h4>
            </div>
            <div class="col-12">
              <p>Осуществляется сервисом Яндекс.Go и рассчитывается по актуальным тарифам</p>
            </div>
            <div class="row">
              <div class="col-12">
                <h4>Бесплатная доставка</h4>
              </div>
              <div class="col-12">
                <p>При заказе товаров на сумму <br/><strong>выше 3 900 ₸</strong></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="row">
            <div class="col-12">
              <h3>Казахстан</h3>
            </div>
            <div class="col-12">
              <h4>Доставка</h4>
            </div>
            <div class="col-12">
              <p>Осуществляется сервисами EMS или Asia Sky Express от 1 417 ₸ в зависимости от региона</p>
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <div class="col-12">
                <h4>Бесплатная доставка</h4>
              </div>
              <div class="col-12">
                <p>При заказе товаров на сумму <br/><strong>выше 20 000 ₸</strong></p>
              </div>
            </div>
          </div>

        </div>
        <div class="col-md-4 col-sm-12">
          <div class="row">
            <div class="col-12">
              <h3>Россия</h3>
            </div>
            <div class="col-12">
              <h4>Доставка</h4>
            </div>
            <div class="col-12">
              <p>Осуществляется сервисами EMS или Asia Sky Express от 610 ₽ в зависимости от региона</p>
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <div class="col-12">
                <h4>Бесплатная доставка</h4>
              </div>
              <div class="col-12">
                <p>При заказе товаров на сумму<br/><strong>выше 6 000 Р</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row container">



      </div>

    </div>

  </section>

@endsection
