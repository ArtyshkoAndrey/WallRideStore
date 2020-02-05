<nav id="slide-menu">
  <ul>
    <li class="close-submenu" style="display: none;" onclick="closeSubMenu()"> <i class="fas fa-long-arrow-alt-left"></i> Назад</li>
    <li class="sep"><a href="{{ route('root') }}">Главная</a></li>
    <li class="sep"><a href="{{ route('products.all') }}">Магазин</a></li>
    <li class="sep dropdown" rel=1>
      <a>Бренды</a>
      <ul class="dropdown-3 submenu-1">
        <li><a href="#">Adidas Skateboarding</a></li>
        <li><a href="#">All timers</a></li>
        <li><a href="#">Baker</a></li>
        <li><a href="#">BirdHouse</a></li>
        <li><a href="#">Bronson</a></li>
        <li><a href="#">Bronze56k</a></li>
        <li><a href="#">Converce</a></li>
        <li><a href="#">Creature</a></li>
        <li><a href="#">Deathwish</a></li>
        <li><a href="#">Dime</a></li>
        <li><a href="#">Fucking Awesome</a></li>
        <li><a href="#">Helas</a></li>
        <li><a href="#">Hockey</a></li>
        <li><a href="#">Huf</a></li>
        <li><a href="#">Illegal civilisation</a></li>
        <li><a href="#">Independent</a></li>
        <li><a href="#">Krux</a></li>
        <li><a href="#">Magente</a></li>
        <li><a href="#">Mob Grip</a></li>
        <li><a href="#">ObFive</a></li>
        <li><a href="#">Oj wheels</a></li>
        <li><a href="#">Polar</a></li>
        <li><a href="#">Ricta</a></li>
        <li><a href="#">Santa Junt</a></li>
        <li><a href="#">Shake Junt</a></li>
        <li><a href="#">Thrasher</a></li>
        <li><a href="#">Thunder</a></li>
        <li><a href="#">Nike SB</a></li>
        <li><a href="#">WallRide</a></li>
        <li><a href="#">Асфальт</a></li>
      </ul>
    </li>
    <li class="sep"><a href="{{ route('root') }}">Контакты</a></li>
    <li class="sep"><a href="{{ route('about') }}">О нас</a></li>
    <li class="sep c-red"><a href="{{ route('root') }}">Sale</a></li>
    <li class="sep c-red"><a href="{{ route('products.favorites') }}">Избранное</a></li>
  </ul>
</nav>
<!-- Content panel -->
<nav class="navbar navbar-expand">
  <div id="nav-icon3">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav justify-content-end">
      <li class="nav-item dropdown d-none d-sm-block" rel="city">
        <a class="nav-link d-flex align-items-center" id="city" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="d-none d-md-block">Вы находитесь в: г. Москва</span>
          <span class="d-block d-md-none">г. Москва</span>
          <i class="fal fa-angle-down fa-fw"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="city">
          <div class="material_input">
            <input type="text" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label id="mla">Начните печатать</label>
          </div>
          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
              Москва
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              Питер
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              Махачкала
            </a>
            <a href="#" class="list-group-item list-group-item-action">Красноярск</a>
            <a href="#" class="list-group-item list-group-item-action">Новосибирск</a>
            <a href="#" class="list-group-item list-group-item-action">Санкт-Петербурк</a>
          </div>
        </div>
      </li>
      @guest
      <li class="nav-item mr-0 mr-sm-4" rel="profile" style="display: flex;">

        <span class="d-flex align-items-center">
          <a class="nav-link p-0 mr-2 border-bottom border-white d-flex align-items-center" href="{{ route('login') }}">Войдите</a>
          или
          <a class="nav-link p-0 ml-2 border-bottom border-white d-flex align-items-center" href="{{ route('register') }}">Зарегистрируйтесь</a>
        </span>
      @else
      <li class="nav-item dropdown mr-0 mr-sm-4" rel="profile">
        <a class="nav-link p-0" id="nav-profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="img-fluid rounded-circle p-0" src="{{ asset('public/storage/inventory/t-short.png') }}" alt="">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile">
          <a href="{{ route('profile.index') }}" class="dropdown-item">Мой профиль</a>
          <a href="{{ route('orders.index') }}" class="dropdown-item">Мои заказы</a>
          <a href="{{ route('products.favorites') }}" class="dropdown-item">Моя коллекция</a>
          <a class="dropdown-item" id="logout" href="#"
             onclick="event.preventDefault();document.getElementById('logout-form').submit();">Выйти</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </li>
      @endguest
      <li class="nav-item dropdown mr-0 mr-sm-4" rel="cart">
        <a class="nav-link" id="cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-shopping-bag fa-2x fa-fw"></i>
          <div id="counter">
            <span>3</span>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cart">

          <div class="row align-items-center m-0">
            <div class="col-md-3 col-6 h-100">
              <img src="{{ asset('public/storage/inventory/t-short.png') }}" alt="t-short" class="img-fluid">
            </div>
            <div class="col-md-5 col-6 h-100">
              <p class="p-0 m-0">Fucking Awesome – <br> Flowers Hoodie Black</p>
            </div>
            <div class="col-md-4 mt-2 mt-md-0 h-100">
              <div class="row px-3 px-md-0">
                <span class="col-md-9 col-9 p-0 cart-price">1 х 42 900 тг.</span>
                <button class="btn btn-default col-md-3 col-3 p-0"><i class="fal fa-times fa-fw fa-lg c-red"></i></button>
              </div>
            </div>
          </div>

          <div class="row align-items-center m-0">
            <div class="col-md-3 col-6 h-100">
              <img src="{{ asset('public/storage/inventory/t-short.png') }}" alt="t-short" class="img-fluid">
            </div>
            <div class="col-md-5 col-6 h-100">
              <p class="p-0 m-0">Fucking Awesome – <br> Flowers Hoodie Black</p>
            </div>
            <div class="col-md-4 mt-2 mt-md-0 h-100">
              <div class="row px-3 px-md-0">
                <span class="col-md-9 col-9 p-0 cart-price">1 х 42 900 тг.</span>
                <button class="btn btn-default col-md-3 col-3 p-0"><i class="fal fa-times fa-fw fa-lg c-red"></i></button>
              </div>
            </div>
          </div>

          <div class="row align-items-center m-0">
            <div class="col-md-3 col-6 h-100">
              <img src="{{ asset('public/storage/inventory/t-short.png') }}" alt="t-short" class="img-fluid">
            </div>
            <div class="col-md-5 col-6 h-100">
              <p class="p-0 m-0">Fucking Awesome – <br> Flowers Hoodie Black</p>
            </div>
            <div class="col-md-4 mt-2 mt-md-0 h-100">
              <div class="row px-3 px-md-0">
                <span class="col-md-9 col-9 p-0 cart-price">1 х 42 900 тг.</span>
                <button class="btn btn-default col-md-3 col-3 p-0"><i class="fal fa-times fa-fw fa-lg c-red"></i></button>
              </div>
            </div>
          </div>

          <div class="row align-items-center m-0">
            <div class="col-md-3 col-6 h-100">
              <img src="{{ asset('public/storage/inventory/t-short.png') }}" alt="t-short" class="img-fluid">
            </div>
            <div class="col-md-5 col-6 h-100">
              <p class="p-0 m-0">Fucking Awesome – <br> Flowers Hoodie Black</p>
            </div>
            <div class="col-md-4 mt-2 mt-md-0 h-100">
              <div class="row px-3 px-md-0">
                <span class="col-md-9 col-9 p-0 cart-price">1 х 42 900 тг.</span>
                <button class="btn btn-default col-md-3 col-3 p-0"><i class="fal fa-times fa-fw fa-lg c-red"></i></button>
              </div>
            </div>
          </div>

          <div class="row align-items-center m-0">
            <div class="col-md-6 col-6 h-100">
              <a class="btn btn-dark" href="{{ route('cart.index') }}" role="button">Перейти в корзину</a>
            </div>
            <div class="col-md-6 col-6 h-100"><p class="p-0 cart-price m-0">Итого: 85 800 тг.</p></div>
          </div>

        </div>
      </li>
    </ul>
  </div>
</nav>
