@extends('layouts.app')
@section('title', 'О нас')

@section('content')
  <section class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-12 text-center">
        <h1>О нас</h1>
      </div>
      <div class="col-8 col-md-3">
        <img src="{{ asset('public/images/LOGO_SITE 4.svg') }}" class="img-fluid" alt="">
        <img src="{{ asset('public/images/LOGO_SITE 3.svg') }}" class="position-absolute"  alt="" style="left: 70px; top: 60px; height: auto; width: 50%">
      </div>
      <div class="col-12 text-center mt-5">
        <h2 class="font-weight-bold text-uppercase">wallridestore.com</h2>
      </div>
      <div class="col-12 text-center">
        <p class="text-muted h4">Wallride Store – скейтшоп, созданный скейтерами для скейтеров.</p>
        <p class="text-muted h5">В бренд-листе магазина топовые бренды: Dime, Polar Skate co, Bronze56k, Fucking Awesome, Hockey, Stussy, Helas и многие другие.</p>
        <p class="text-muted h5">Помимо известных брендов, мы занимаемся развитием собственного бренда скейтбордов Wallride.</p>
      </div>
      <div class="col-12 text-center mt-5">
        <h2>Наши контакты</h2>
        <p class="text-dark h4 mt-3"><a href="tel:+7 (747) 556-23-83" class="text-reset">+7 (747) 556-23-83</a></p>
      </div>
      <div class="col-12 text-center mt-5">
        <h2>Соц. сети</h2>
        <a href="#" target="_blank" class="mx-3 mt-2 d-inline-flex text-dark text-decoration-none"><i class="fab fa-instagram fa-3x"></i></a>
        <a href="#" target="_blank" class="mx-3 mt-2 d-inline-flex text-dark text-decoration-none"><i class="fab fa-vk fa-3x"></i></a>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
