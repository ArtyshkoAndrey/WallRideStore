<header>

  @include('user.layouts.header.left-menu')

  <nav class="navbar navbar-expand navbar-light bg-dark">
    <div class="container-fluid">
      <div class="collapse navbar-collapse align-items-center justify-content-center" id="main-menu">
        <ul class="navbar-nav w-100 px-0 px-lg-4">

          <li class="nav-item d-lg-none d-block">
            <div id="nav-toggle">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </li>

          <li class="nav-item dropdown d-none d-lg-flex">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="currencyDropdown"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              @{{ $store.state.currency.short_name ?? 'Загрузка' }}
            </a>
            <ul class="dropdown-menu p-4" aria-labelledby="currencyDropdown">
              @foreach(\App\Models\Currency::all() as $currency)
                <li>

                  <button
                    @click="$store.dispatch('set_currency', { currency: {{$currency}} })"
                    class="dropdown-item px-0"
                    v-bind:class="$store.state.currency.id === {{ $currency->id }} ? 'active' : '' ">
                    {{ $currency->short_name }}
                  </button>

                </li>
              @endforeach
            </ul>
          </li>

          <li class="nav-item dropdown d-none d-lg-flex">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="languageDropdown"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              RUS
            </a>
            <ul class="dropdown-menu p-4" aria-labelledby="languageDropdown">
              <li>
                <button
                  class="dropdown-item px-0 active">
                  Русский
                </button>
              </li>

              <li>
                <button
                  class="dropdown-item px-0">
                  English
                </button>
              </li>
            </ul>
          </li>

          <li class="divider d-none d-lg-block"></li>

          <li class="nav-item dropdown d-none d-lg-flex" id="search-nav-item">
            <a
              class="nav-link dropdown-toggle not-after"
              href="#"
              id="searchDropdown"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="far fa-search d-block"></i>
            </a>
            <ul class="dropdown-menu p-4" aria-labelledby="searchDropdown">
              <li class="dropdown-item px-0">
                <form action="" class="h-100" method="POST">
                  @csrf
                  <div class="row h-100 m-0">
                    <div class="col-9 offset-1 px-0">
                      <input type="text" id="search" name="search" class="w-100" placeholder="Название товара, бренд категория" />
                    </div>
                    <div class="col-1 px-0">
                      <button class="btn btn-dark shadow-none w-100 h-100 h4"><i class="far fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </li>
            </ul>
          </li>

{{--      LOGo Image    --}}
          <li class="nav-item mx-auto">
            <a class="navbar-brand" href="{{ route('index') }}">
              <img src="{{ asset('images/logo.svg') }}" class="logo" alt="wallridestore">
            </a>
          </li>

          <li class="nav-item dropdown d-none d-lg-flex">
            <a
              class="nav-link nav-link-end dropdown-toggle not-after"
              href="#"
              id="userDropdown"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="far fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-4" aria-labelledby="userDropdown">
              <li class="dropdown-item px-0">
                <a href="{{ route('login') }}" class="text-gray-1">Вход</a>
              </li>
              <li class="dropdown-item px-0">
                <a href="{{ route('register') }}" class="text-gray-1">Регистрация</a>
              </li>
            </ul>
          </li>

          <li class="divider d-none d-lg-block"></li>

          <li class="nav-item dropdown d-none d-lg-flex">
            <a
              class="nav-link"
              href="#"
            >
              <i class="far fa-heart"></i>
            </a>
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link nav-link-end dropdown-toggle not-after"
              href="#"
              id="userDropdown"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="far fa-shopping-bag"></i>
              <span class="badge rounded-pill badge-notification bg-danger text-black">0</span>
            </a>
            <div class="dropdown-menu full-width dropdown-menu-end p-4">

              <div class="row mx-0 mb-3 mb-sm-2" v-for="i in 10">
                <div class="col-sm-2 col-3 d-flex align-items-center p-0 pb-2">
                  <img src="{{ asset('images/product.jpg') }}" class="img-fluid" alt="product">
                </div>

                <div class="col-9 col-sm-10 pb-2">
                  <div class="row align-items-center justify-content-between h-100">

                    <div class="col-6 col-sm-5 order-1 d-flex align-self-stretch align-self-sm-auto">
                      <p class="m-0 font-weight-bold product-name">
                        Lorem ipsum dolor sit amet.
                      </p>
                    </div>

                    <div class="col-7 col-sm-auto order-3 order-sm-2 ml-sm-auto mt-auto mt-sm-0">
                      <p class="m-0 font-weight-normal product-price">
                        42 000 ₽
                      </p>
                    </div>

                    <div class="col-5 col-sm-auto order-4 order-sm-3 d-flex justify-content-between align-items-center mt-auto mt-sm-0">
                      <button type="button" class="btn btn-dark p-2">
                        <i class="far fa-minus"></i>
                      </button>
                      <p class="mx-2 my-auto">10</p>
                      <button type="button" class="btn btn-dark p-2">
                        <i class="far fa-plus"></i>
                      </button>
                    </div>

                    <div class="col-6 col-sm-auto order-2 order-sm-4 d-flex align-items-start justify-content-end align-self-stretch align-self-sm-auto">
                      <button type="button" class="p-0 btn bg-transparent shadow-0 border-0 text-danger">
                        <i class="far fa-trash h5"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row align-items-center flex-wrap-reverse justify-content-between mt-3">

                <div class="col-12 col-md-6 d-flex d-md-block justify-content-between ml-2 mb-3 mb-md-0 text-left">
                  <div class="row m-0">
                    <div class="col-6 col-12 d-flex justify-content-start align-items-center p-0">
                      <p class="h5 font-weight-bold mb-1"> 999 000 Р</p>
                    </div>
                    <div class="col-12 d-flex justify-content-start p-0">
                      <button class="bg-transparent border-0 text-decoration-none p-0">Очистить корзину</button>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-5 d-flex align-items-end align-self-start p-0">
                  <a href="https://dockuboardhouse.com/cart" class="btn btn-dark py-3 w-100">Перейти в корзину</a>
                </div>
              </div>

            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</header>
