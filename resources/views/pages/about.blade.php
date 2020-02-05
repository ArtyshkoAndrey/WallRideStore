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
        <h2 class="font-weight-bold">WALLRIDESTORE.KZ</h2>
      </div>
      <div class="col-12 text-center">
        <p class="text-muted h4">WallRide – это независимый интернет магазин уличнойодежды и скейтбордов.
          Мы быстро набираем обороты и запасаемся только самым свежим продуктом. Осуществляем доставку до 3х дней по всему миру.
        </p>
      </div>
      <div class="col-12 text-center mt-5">
        <h2>Наши контакты</h2>
        <p class="c-red h4 mt-3">+7 (727) 332-27-09</p>
        <p class="c-red h4">+7 (727) 332-27-09</p>
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
