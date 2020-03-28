<nav id="slide-menu">
  <ul>
    <li class="close-submenu" style="display: none;" onclick="closeSubMenu()"> <i class="fas fa-long-arrow-alt-left"></i> Назад</li>
    <li class="sep"><a href="{{ route('root') }}">Главная</a></li>
    <li class="sep"><a href="{{ route('products.all') }}">Магазин</a></li>
    <li class="sep dropdown" rel=1>
      <a>Бренды</a>
      <ul class="dropdown-3 submenu-1">
        @foreach(App\Models\Brand::all() as $brand)
          <li><a href="{{ route('products.all', ['brand' => $brand->id]) }}">{{ $brand->name }}</a></li>
        @endforeach
      </ul>
    </li>
    <li class="sep dropdown" rel=1>
      <a>Категории</a>
      <ul class="dropdown-3 submenu-1">
        @foreach(App\Models\Category::all() as $cat)
          <li><a href="{{ route('products.all', ['category' => $cat->id]) }}">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </li>
    <li class="sep"><a href="{{ route('contact') }}">Контакты</a></li>
    <li class="sep"><a href="{{ route('about') }}">О нас</a></li>
    <li class="sep c-red"><a style="color: #F33C3C!important;" href="{{ route('products.allsale') }}">Sale</a></li>
    <li class="sep"><a href="{{ route('products.favorites') }}">Избранное</a></li>
    <li style="width: 100vw; margin-left: -20px" id="logo-leftbar"><img src="{{ asset('public/images/logo.png') }}" class="img-fluid mr-auto ml-auto mt-5 position-absolute" style="width: 20vw;bottom: 35px; left: calc(50% - 10vw);" alt=""></li>
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
          @guest
            @if(!isset($_COOKIE['whooip']) || (int) $_COOKIE['whooip'] == 0)
              <span class="d-none d-md-block">Вы находитесь в
                <?php
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'http://pro.ipwhois.io/json/' . \Request::ip() . '?key=gFoMKlSHuw23CWwm&lang=ru');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, []);
                $out = curl_exec($curl);
                curl_close($curl);
                if(App\Models\City::where('name',json_decode($out)->city)->first()) {
                  echo App\Models\City::where('name',json_decode($out)->city)->first()->name;
                  $ctr = App\Models\City::where('name',json_decode($out)->city)->first();
                } else if (App\Models\City::where('name', 'LIKE', '%'.json_decode($out)->city . '%')->first()) {
                  echo App\Models\City::where('name', 'LIKE', '%'.json_decode($out)->city . '%')->first()->name;
                  $ctr = App\Models\City::where('name', 'LIKE', '%'.json_decode($out)->city . '%')->first();
                } else {
                  $ctr = App\Models\City::first();
                  echo $ctr->name;
                }
                ?>
                ?
                <div class="d-none d-md-flex" style="background: #fff; position:absolute; padding: 10px 10px 10px 0px; border-radius: 0; margin-top: 8px; margin-left: 80px">
                  <a href="/location/{{$ctr->id}}" class="btn btn-success rounded-0">Да</a>
                  <a href="/location/{{App\Models\City::first()->id}}" class="btn btn-danger rounded-0 ml-3">Нет</a>
                </div>
              </span>
            @elseif(!isset($_COOKIE['city']))
              <? setcookie('city', App\Models\City::first()->id, time() + (86400 * 30), "/"); ?>
              <span class="d-none d-md-block">Вы находитесь в: г. Москва</span>
              <span class="d-block d-md-none">г. Москва</span>
              <i class="fal fa-angle-down fa-fw"></i>
            @else
              <span class="d-none d-md-block">Вы находитесь в: г. {{ App\Models\City::find($_COOKIE['city'])->name }}</span>
              <span class="d-block d-md-none">г. {{ App\Models\City::find($_COOKIE['city'])->name }}</span>
              <i class="fal fa-angle-down fa-fw"></i>
            @endif
          @else
            @if(isset(auth()->user()->address))
              <span class="d-none d-md-block">Вы находитесь в: г. {{ auth()->user()->address->city->name }}</span>
              <span class="d-block d-md-none">г. {{ auth()->user()->address->city->name }}</span>
              <i class="fal fa-angle-down fa-fw"></i>
            @else
              @if(!isset($_COOKIE['city']))
                <? setcookie('city', App\Models\City::first()->id, time() + (86400 * 30), "/"); ?>
                <span class="d-none d-md-block">Вы находитесь в: г. Москва</span>
                <span class="d-block d-md-none">г. Москва</span>
                  <i class="fal fa-angle-down fa-fw"></i>
              @else
                <span class="d-none d-md-block">Вы находитесь в: г. {{ App\Models\City::find($_COOKIE['city'])->name }}</span>
                <span class="d-block d-md-none">г. {{ App\Models\City::find($_COOKIE['city'])->name }}</span>
                <i class="fal fa-angle-down fa-fw"></i>
              @endif
            @endif
          @endguest
        </a>
        <div class="dropdown-menu" aria-labelledby="city">
          <div class="material_input">
            <input type="text" name="location_city" autocomplete="off" onkeyup="resetListCity()" readonly onfocus="this.removeAttribute('readonly');">
            <span class="highlight"></span>
            <span class="bar"></span>
            <label id="mla">Начните печатать</label>
          </div>
          <div class="list-group" id="list-city">
            @foreach(App\Models\City::paginate(10) as $city)
              <a href="/location/{{$city->id}}" class="list-group-item list-group-item-action">
                {{ $city->name }}
              </a>
            @endforeach
          </div>
        </div>
      </li>
      <li class="nav-item d-none d-lg-block position-absolute" style="display: flex; left: calc( 50vw  - 25px )">
        <a href="{{ route('root') }}"><img src="{{ asset('public/images/logo.png') }}" height="45" alt=""></a>
      </li>
      <li class="nav-item mr-2 d-none d-sm-block ml-auto" style="display: flex;">
        <form action="{{ route('products.search') }}" id="big-search" class="form-inline w-100">
          <div class="form-group mb-0 mr-0">
            <label class="sr-only">Что-то искали?</label>
            <input type="text" name="name" value="{{ isset($name) ? $name : null }}" class="form-control border-0 rounded-0" placeholder="Что-то искали?">
          </div>
          <button type="submit" class="btn btn-primary border-0 ml-0 rounded-0"><i class="far fa-search"></i></button>
        </form>
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
        <a class="nav-link p-0 align-items-center" id="nav-profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="img-fluid rounded-circle p-0" src="{{ isset(auth()->user()->avatar) ? asset('storage/avatar/thumbnail/'.auth()->user()->avatar) : asset('public/images/person.png') }}" alt="">
          <span class="d-block ml-2">{{ auth()->user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile">
          <a href="{{ route('profile.index') }}" class="dropdown-item">Мой профиль</a>
          <a href="{{ route('orders.index') }}" class="dropdown-item">Мои заказы</a>
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
            <span>@{{ amount }}</span>
          </div>
        </a>
        <header-cart :cartitems="{{ json_encode($cartItems) }}" :currency="{{ $currency }}" :priceamount="{{ $priceAmount }}" inline-template>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cart">
            <mini-cart-item v-for="item in $parent.cartItems" :key="item.id" :item="item" :currency="{{ $currency }}" :id="item.product_sku.id" inline-template>
              <div class="row align-items-center m-0">
                <div class="col-md-3 col-6 h-100">
                  <img :src="item.product_sku.product.photos !== null && item.product_sku.product.photos.length > 0  ? '/public/storage/products/' + item.product_sku.product.photos[0].name : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png'" alt="t-short" class="img-fluid">
                </div>
                <div class="col-md-5 col-6 h-100">
                  <p class="p-0 m-0">@{{ item.product_sku.product.title }}</p>
                </div>
                <div class="col-md-4 mt-2 mt-md-0 h-100">
                  <div class="row px-3 px-md-0">
                    <span class="col-md-9 col-9 p-0 cart-price">@{{ item.amount }} х @{{ item.product_sku.product.on_sale && item.product_sku.product.price_sale ? $cost(Number(item.product_sku.product.price_sale) * currency.ratio)  : $cost(Number(item.product_sku.product.price) * currency.ratio) }} @{{currency.symbol}}</span>
                    <button class="btn btn-default col-md-3 col-3 p-0" @click="deleteItem"><i class="fal fa-times fa-fw fa-lg text-dark"></i></button>
                  </div>
                </div>
              </div>
            </mini-cart-item>


            <div class="row align-items-center m-0">
              <div class="col-md-6 col-6 h-100">
                <a class="btn btn-dark" href="{{ route('cart.index') }}" role="button">Перейти в корзину</a>
              </div>
              <div class="col-md-6 col-6 h-100"><p class="p-0 cart-price m-0">Итого: @{{ $cost($parent.priceAmount * currency.ratio) }} @{{currency.symbol}}</p></div>
            </div>
          </div>
        </header-cart>
      </li>
    </ul>
  </div>
</nav>

<nav class="navbar navbar-expand" style="position: fixed; margin-top: 50px; background: rgba(0, 0, 0, 0.58)!important; z-index: 99;width: 100vw">
  <div class="collapse navbar-collapse" id="navbarSupportedContent" style="width: 100vw;">
    <ul class="navbar-nav justify-content-center" style="width: 100vw;">
      <li class="nav-item mr-0 mr-sm-4">
        <a class="nav-link d-flex align-items-center" href="{{ route('root') }}">Главная</a>
      </li>
      <li class="nav-item mr-0 mr-sm-4">
        <a class="nav-link d-flex align-items-center" href="{{ route('products.all') }}">Магазин</a>
      </li>
      <li class="nav-item mr-0 mr-sm-4">
        <a class="nav-link d-flex align-items-center" id="top-brands" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Бренды
        </a>
        <div class="dropdown-menu border-0 m-0 rounded-0 p-0" style="left: auto; top: 50px; max-height: 300px" aria-labelledby="top-brands">
          <ul class="list-group rounded-0 d-flex p-2" id="top-drop-ul-brands" style="max-height: 300px; overflow-y:scroll; webkit-overflow-scrolling: touch;">
            @foreach(App\Models\Brand::all() as $brand)
              <li class="list-group-item rounded-0 border-0 p-2"><a href="{{ route('products.all', ['brand' => $brand->id]) }}" class="c-red">{{ $brand->name }}</a></li>
            @endforeach
          </ul>
        </div>
      </li>
      <li class="nav-item mr-0 mr-sm-4">
        <a class="nav-link d-flex align-items-center c-red" href="{{ route('products.allsale') }}">Sale</a>
      </li>
    </ul>
  </div>
</nav>
