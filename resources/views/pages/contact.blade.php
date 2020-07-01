@extends('layouts.app')
@section('title', 'Контакты')

@section('content')
  <section class="container mt-5 pt-5 mb-5 h-100">
    <div class="row align-items-md-center h-100">
      <div class="col-md-6">
        <iframe style="width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2907.1284967109227!2d76.95751089621007!3d43.22776549176683!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836f0690dabfcd%3A0x45c067898a21749c!2z0KLQvtGA0LPQvtCy0YvQuSDQutC-0LzQv9C70LXQutGBINCg0LjRgtGGINCf0LDQu9Cw0YE!5e0!3m2!1sru!2sru!4v1580977776099!5m2!1sru!2sru" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
      </div>
      <div class="col-md-6">
        <h1 class="font-weight-bold">Адрес</h1>
        <h5>РК, Алматы Мкр. Самал-3,1 050059</h5>
        <h5 class="text-muted mt-3">Аль Фараби угол ул. Достык, слева от центрального входа в ТРЦ “Ритц Палас”</h5>
        <h1 class="font-weight-bold mt-4">Контактная информация</h1>
        <h5 class="text-dark"><a href="tel:+7 (747) 556-23-83" class="text-reset">+7 (747) 556-23-83</a></h5>
        <div class="row">
          <div class="col-6 col-md-5 col-sm-6">
            <hr>
          </div>
        </div>
        <a href="https://www.instagram.com/wallride_store/" target="_blank" class="mx-3 mt-2 d-inline-flex text-dark text-decoration-none"><i class="fab fa-instagram fa-2x"></i></a>
        <a href="https://vk.com/wrstore" target="_blank" class="mx-3 mt-2 d-inline-flex text-dark text-decoration-none"><i class="fab fa-vk fa-2x"></i></a>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
