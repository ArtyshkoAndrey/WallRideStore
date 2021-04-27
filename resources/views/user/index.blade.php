@extends('user.layouts.app')

@section('title', 'Главная страница')

@section('content')

  @if(count($sliders) > 0)
    <div class="container-fluid p-0">
      <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-mdb-ride="carousel">
        <ol class="carousel-indicators">
          @foreach($sliders as $il)
            <li data-mdb-target="#carouselExampleCaptions" class="{{ $loop->index === 0 ? 'active' : '' }}" data-mdb-slide-to="{{ $loop->index }}"></li>
          @endforeach
        </ol>
        <div class="carousel-inner">

          @foreach($sliders as $slider)

            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
              <div class="image">
                <img src="{{ $slider->photo_url_jpg }}" class="d-none d-lg-block w-100" alt="...">

                <img src="{{ $slider->photo_mobile_url_jpg }}" class="d-lg-none d-block w-100" alt="...">
              </div>
              <div class="carousel-caption">
                <h2 class="text-uppercase">{{ $slider->h1 }}</h2>
                <p>{{ $slider->h2 }}</p>
                <a href="{{ url($slider->url) }}" class="btn btn-dark">{{ $slider->btn_text }}</a>
              </div>
            </div>

          @endforeach

        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-mdb-target="#carouselExampleCaptions"
          data-mdb-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-mdb-target="#carouselExampleCaptions"
          data-mdb-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  @else
    <div class="container pb-4">
      <div class="row"></div>
    </div>
  @endif

  @if(count($newProducts) > 0)
    <section class="container mt-5 mb-5">
      <div class="row">
        <div class="col-6">
          <h3 class="font-weight-bolder">{{ __('Новые товары') }}</h3>
        </div>

        <div class="col-6">
          <a href="{{ route('product.all', ['new' => true]) }}" class="text-dark d-block text-right">{{ __('Перейти в каталог') }}</a>
        </div>
      </div>

      <div class="row">
        @foreach($newProducts as $product)
          <div class="col-xl-3 col-lg-4 col-6">
            @include('user.layouts.item', ['product' => $product])
          </div>
        @endforeach
      </div>
    </section>
  @endif

  <section class="container my-5" id="brands-section">
    <div class="row m-0">
      <div class="col-lg-4 col-md-6 col-12 bg-white py-4 px-5 mb-3 mb-md-0">
        <div class="row align-self-end h-100">
          <div class="col-12">
            <h4 class="h3 font-weight-bolder">Бренды</h4>
            <p class="text-gray-1 d-block mt-4">
              В бренд листе магазина представлены такие бренды, как Butter Goods, Dime, Polar Skate Co, Helas, Sour Solution, Vans, Nike SB - и это далеко не всё.
            </p>
            <p class="text-gray-1 d-block mt-2">
              Чтобы ознакомиться с полным списком, перейдите по ссылке ниже.
            </p>
          </div>
          <div class="col-12 mt-auto">
            <a href="{{ route('product.all') }}" class="btn btn-dark d-block py-3 my-auto mb-0">{{ __('Смотреть все бренды') }}</a>
          </div>
        </div>
      </div>

      <div class="col-lg-8 col-md-6 col-12 p-0 ps-md-3">

        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="row">
              @if(count($brands) > 0)
                <div class="col-lg-12 col-md-12 col-4 mb-3 position-relative">
                  <a href="{{ route('brand.show', $brands[0]->id) }}" class="d-block">
                    <img src="{{ $brands[0]->photo_jpg_storage }}"
                         class="w-100 h-100 object-fit-cover dark-image-25"
                         alt="{{ $brands[0]->name }}">
                    <p class="text-white text-center position-absolute">{{ $brands[0]->name }}</p>
                  </a>
                </div>
              @endif

              @if(count($brands) > 1)
                <div class="col-lg-6 col-md-12 col-4 mb-3 mb-lg-0 position-relative">
                  <a href="{{ route('brand.show', $brands[1]->id) }}" class="d-block">
                    <img src="{{ $brands[1]->photo_jpg_storage }}"
                         class="w-100 h-100 object-fit-cover dark-image-25"
                         alt="{{ $brands[1]->name }}">
                    <p class="text-white text-center position-absolute">{{ $brands[1]->name }}</p>
                  </a>
                </div>
              @endif

              @if(count($brands) > 2)
                <div class="col-lg-6 col-md-12 col-4 mb-3 mb-lg-0 position-relative">
                  <a href="{{ route('brand.show', $brands[2]->id) }}" class="d-block">
                    <img src="{{ $brands[2]->photo_jpg_storage }}"
                         class="w-100 h-100 object-fit-cover dark-image-25"
                         alt="{{ $brands[2]->name }}">
                    <p class="text-white text-center position-absolute">{{ $brands[2]->name }}</p>
                  </a>
                </div>
              @endif
            </div>
          </div>

          <div class="col-lg-6 col-md-6">
            <div class="row">

              @if(count($brands) > 3)
                <div class="col-lg-6 col-md-12 col-4 mb-3 position-relative">
                  <a href="{{ route('brand.show', $brands[3]->id) }}" class="d-block">
                    <img src="{{ $brands[3]->photo_jpg_storage }}"
                         class="w-100 h-100 object-fit-cover dark-image-25"
                         alt="{{ $brands[3]->name }}">
                    <p class="text-white text-center position-absolute">{{ $brands[3]->name }}</p>
                  </a>
                </div>
              @endif

              @if(count($brands) > 4)
                <div class="col-lg-6 col-md-12 col-4 mb-3 position-relative">
                  <a href="{{ route('brand.show', $brands[4]->id) }}" class="d-block">
                    <img src="{{ $brands[4]->photo_jpg_storage }}"
                         class="w-100 h-100 object-fit-cover dark-image-25"
                         alt="{{ $brands[4]->name }}">
                    <p class="text-white text-center position-absolute">{{ $brands[4]->name }}</p>
                  </a>
                </div>
              @endif

              @if(count($brands) > 5)
                <div class="col-lg-12 col-md-12 col-4 mb-3 mb-lg-0 position-relative">
                  <a href="{{ route('brand.show', $brands[5]->id) }}" class="d-block">
                    <img src="{{ $brands[5]->photo_jpg_storage }}"
                         class="w-100 h-100 object-fit-cover dark-image-25"
                         alt="{{ $brands[5]->name }}">
                    <p class="text-white text-center position-absolute">{{ $brands[5]->name }}</p>
                  </a>
                </div>
              @endif
            </div>
          </div>


        </div>
      </div>
    </div>
  </section>

  <section class="container my-5">
    <div class="row">
      <div class="col-lg-5 col-md-6 col-12">
        <img src="{{ asset('images/shop_photo.jpg') }}" id="shop-image" class="w-100 object-fit-cover" alt="WallrideStore shop Kazhstan">
      </div>

      <div class="col-lg-7 col-md-6 col-12">
        <div class="row" id="row-map">
          <div class="col-12">
            <div class="card bg-white shadow-0">
              <div class="card-body px-4">
                <div class="row">
                  <div class="col-lg-7 col-12">
                    <h3 class="font-weight-bolder mt-2">Приходите в гости в магазин Wallridestore</h3>
                  </div>
                  <p class="text-gray-1 mt-lg-3">Наш скейтшоп находится в чудесном городе Алма-Ата, на высоте 900 метров над уровнем моря. Иногда мы сравниваем ландшафт города с Сан-Франциско: здесь крутой даунхил и много спотов, наверное, поэтому Казахстанский скейтбординг обрел здесь свое начало и продолжает развиваться.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 h-50">
            <div class="card shadow-0 h-100">
              <div class="card-body p-0 h-100">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A6358423497b39c18edf3d1526a35662c1cb50b361ebf554585d2d0b14456a080&amp;source=constructor" width="100%" height="500" frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @if(count($bestseller) > 0)
    <section class="container mt-5 mb-5">
      <div class="row">
        <div class="col-6">
          <h3 class="font-weight-bolder">{{ __('Хит продаж') }}</h3>
        </div>

        <div class="col-6">
          <a href="{{ route('product.all') }}" class="text-dark d-block text-right">{{ __('Перейти в каталог') }}</a>
        </div>
      </div>

      <div class="row">
        @foreach($bestseller as $product)
          <div class="col-xl-3 col-lg-4 col-6">
            @include('user.layouts.item', ['product' => $product])
          </div>
        @endforeach
      </div>
    </section>
  @endif

@endsection
