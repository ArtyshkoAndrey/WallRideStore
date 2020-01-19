<nav id="slide-menu">
  <ul>
    <li class="close-submenu" style="display: none;" onclick="closeSubMenu()"> <i class="fas fa-long-arrow-alt-left"></i> Назад</li>
    <li class="sep">Главная страница</li>
    <li class="sep">Магазин</li>
    <li class="sep dropdown" rel=1>
      Бренды
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
    <li class="sep">Контакты</li>
    <li class="sep">О нас</li>
    <li class="sep c-red">Sale</li>
    <li class="sep dropdown" rel=2>
      Избранное (3)
      <ul class="dropdown-1 submenu-2">
        <li><a href="#">Adidas Skateboarding</a></li>
        <li><a href="#">All timers</a></li>
      </ul>
    </li>
  </ul>
</nav>
<!-- Content panel -->
<nav class="navbar navbar-expand navbar-light bg-light">
  <div id="nav-icon3">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav justify-content-end">
      <li class="nav-item dropdown" rel="city">
        <a class="nav-link d-flex align-items-center" id="city" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span>Вы находитесь в: г. Москва</span>
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
      <li class="nav-item" rel="profile">
        <a class="nav-link p-0" id="nav-profile" href="#">
          <img class="img-fluid rounded-circle p-0" src="{{ asset('public/storage/inventory/t-short.png') }}" alt="">
        </a>
      </li>
      <li class="nav-item dropdown" rel="cart">
        <a class="nav-link" id="cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-shopping-bag fa-2x fa-fw"></i>
          <div id="counter">
            <span>3</span>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="cart">
          <div class="row align-items-center">
            <div class="col-md-3 h-100">
              <img src="{{ asset('public/storage/inventory/t-short.png') }}" alt="t-short" class="img-fluid">
            </div>
            <div class="col-md-5 h-100">
              <p class="p-0 m-0">Fucking Awesome – <br> Flowers Hoodie Black</p>
            </div>
            <div class="col-md-4 h-100">
              <div class="row">
                  <span class="col-md-9 p-0 cart-price">1 х 42 900 тг.</span>
                  <button class="btn btn-default col-md-3 p-0"><i class="fal fa-times fa-fw fa-lg c-red"></i></button>
              </div>
            </div>
          </div>

          <div class="row align-items-center">
            <div class="col-md-3 h-100">
              <img src="{{ asset('public/storage/inventory/t-short.png') }}" alt="t-short" class="img-fluid">
            </div>
            <div class="col-md-5 h-100">
              <p class="p-0 m-0">Fucking Awesome – <br> Flowers Hoodie Black</p>
            </div>
            <div class="col-md-4 h-100">
              <div class="row">
                <span class="col-md-9 p-0 cart-price">1 х 42 900 тг.</span>
                <button class="btn btn-default col-md-3 p-0"><i class="fal fa-times fa-fw fa-lg c-red"></i></button>
              </div>
            </div>
          </div>

          <div class="row align-items-center">
            <div class="col-md-6 h-100">
              <a class="btn btn-dark" href="#" role="button">Перейти в корзину</a>
            </div>
            <div class="col-md-6 h-100"><p class="p-0 cart-price m-0">Итого: 85 800 тг.</p></div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>
