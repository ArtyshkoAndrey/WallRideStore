<footer class="py-5 bg-dark text-white">
  <div class="container py-3">
    <div class="row ps-3 ps-md-0">
      <div class="col-md-3 col-sm-6 col-12 mt-3">
        <p>{{ __('Есть вопросы? Свяжитесь с нами ;)') }}</p>
        <a href="tel:+77475562383" class="h2 text-white">+7 (747) 556-23-83</a>

        <ul class="mt-3 list-unstyled">
          <li>
            <i class="far fa-envelope text-gray-1 me-2"></i>
            <a href="mailto:info@wallridestore.com" class="text-white">info@wallridestore.com</a>
          </li>
          <li>
            <i class="fab fa-instagram text-gray-1 me-2"></i>
            <a href="https://www.instagram.com/wallride_store/" target="_blank" class="text-white">wallride_store</a>
          </li>
        </ul>
      </div>

      <div class="col-md-3 col-sm-6 col-12 mt-3">
        <h5>{{ __('Помощь по заказам') }}</h5>

        <a href="" class="text-gray-1 d-block mt-2">{{ __('Доставка и оплата') }}</a>
        <a href="{{ route('policy') }}" class="text-gray-1 d-block mt-2">{{ __('Политика конфиденциальности') }}</a>
        <a href="" class="text-gray-1 d-block mt-2">{{ __('Свяжитесь с нами') }}</a>
      </div>

      <div class="col-md-3 col-sm-6 col-12 mt-3">
        <h5>{{ __('Категории') }}</h5>

        @widget("footer-categories")

      </div>

      <div class="col-md-3 col-sm-6 col-12 mt-3">
        <h5>{{ __('Как нас найти') }}</h5>

        <p class="text-gray-1 d-block">{{ __('РК, Алматы Мкр. Самал-3,1 050059') }}</p>
        <p class="text-gray-1 d-block mt-2">{{ __("Аль Фараби угол ул. Достык, слева от центрального входа в ТРЦ 'Ритц Палас'") }}</p>
      </div>

    </div>
    <div class="row mt-3 ps-3 ps-md-0">
      <div class="col-md-3">
        <p>©Wallridestore, {{ date('Y') }}. {{ __('Все права защищены') }}</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-3">
        <p class="text-center">Powered by <a href="{{ config('app.admin.link') }}" class="text-danger">{{ config('app.admin.name') }}</a></p>
      </div>
      <div class="col-12">
        <p class="text-center">Supported by <a href="{{ url('https://www.instagram.com/shopper.pro/') }}"class="text-danger"> Shopper</a></p>
      </div>
    </div>
  </div>
</footer>
