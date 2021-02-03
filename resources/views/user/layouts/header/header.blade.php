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
            <ul class="dropdown-menu" aria-labelledby="currencyDropdown">
              @foreach(\App\Models\Currency::all() as $currency)
                <li>

                  <button
                    @click="$store.dispatch('set_currency', { currency: {{$currency}} })"
                    class="dropdown-item"
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
            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
              <li>
                <button
                  class="dropdown-item active">
                  Русский
                </button>
              </li>

              <li>
                <button
                  class="dropdown-item">
                  English
                </button>
              </li>
            </ul>
          </li>

          <li class="divider d-none d-lg-block"></li>

          <li class="nav-item dropdown d-none d-lg-flex">
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
            <ul class="dropdown-menu" aria-labelledby="searchDropdown">
              <li class="dropdown-item my-3" style="width: 400px;">
                <form action="" method="POST">
                  @csrf
                  <div class="form-outline">
                    <input type="text" id="search" name="search" class="form-control" />
                    <label class="form-label" for="search">Поиск</label>
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
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li class="dropdown-item">
                <a href="{{ route('login') }}">Вход</a>
              </li>
              <li class="dropdown-item">
                <a href="{{ route('register') }}">Регистрация</a>
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
              <span class="badge rounded-pill badge-notification bg-red text-black">0</span>
            </a>
            <div class="dropdown-menu full-width dropdown-menu-end">
              <div class="row ml-0 mb-2"><div class="col-3 col-sm-2 d-flex align-items-start p-0 pb-2"><img src="https://dockuboardhouse.com/storage/images/thumbnails/1612338680849_nitro%20ripper.jpg" alt="" class="img-fluid" style="border-radius: 6px;"></div> <div class="col-9 col-sm-10"><div class="row align-items-center justify-content-between h-100 pb-2 pb-md-0"><div class="col-6 col-sm-5 order-1 d-flex align-self-stretch align-self-sm-auto"><p class="m-0 font-weight-bold">Nitro Ripper Youth 142 -  142</p></div> <div class="col-7 col-sm-auto order-3 order-sm-2 ml-sm-auto mt-auto mt-sm-0"><p class="m-0" style="font-size: 1.3em;">
                        89&nbsp;605 ₽
                      </p></div> <div class="col-5 col-sm-auto order-4 order-sm-3 d-flex justify-content-between align-items-center mt-auto mt-sm-0"><button type="button" onclick="event.stopPropagation();" class="btn btn-dark cart-button"><i class="bx bx-minus"></i></button> <p id="cart-item-amount-1" class="mx-2 my-auto">
                        1
                      </p> <button type="button" onclick="event.stopPropagation();" class="btn btn-dark cart-button"><i class="bx bx-plus"></i></button></div> <div class="col-6 col-sm-auto order-2 order-sm-4 d-flex align-items-start justify-content-end align-self-stretch align-self-sm-auto"><button type="button" name="submit" onclick="event.stopPropagation();" class="p-0 btn bg-transparent shadow-0 border-0" style="color: rgb(222, 109, 45);"><i class="bx bxs-trash bx-sm"></i></button></div></div></div></div>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</header>
