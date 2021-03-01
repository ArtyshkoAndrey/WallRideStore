@extends('user.layouts.app')

@section('title', 'Главаня страница')

@section('content')

  <div class="container-fluid p-0">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-mdb-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" :data-slide-to="i-1" :class="i === 1 ? 'active' : ''" v-for="i in 3"></li>
      </ol>
      <div class="carousel-inner">

        <div class="carousel-item" :class="i === 1 ? 'active' : ''" v-for="i in 3">
          <div class="image">
            <img src="{{ asset('storage/slider/photos/slider.jpg') }}" class="d-block d-lg-none w-100" alt="...">

            <img src="{{ asset('storage/slider/photos/slider1.jpg') }}" class="d-lg-block d-none w-100" alt="...">
          </div>
          <div class="carousel-caption">
            <h2 class="text-uppercase">Vans</h2>
            <p>“OF THE WALL”</p>
            <a href="#" class="btn btn-dark">Перейти в магазин</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <section class="container mt-5 mb-5">
    <div class="row">
      <div class="col-6">
        <h3 class="font-weight-bolder">{{ __('Новые товары') }}</h3>
      </div>

      <div class="col-6">
        <a href="{{ route('product.all', ['sale' => true]) }}" class="text-dark d-block text-right">{{ __('Перейти в каталог') }}</a>
      </div>
    </div>

    <div class="row">
      @foreach($newProducts as $product)
        <div class="col-lg-3 col-md-4 col-6">
          @include('user.layouts.item', ['product' => $product])
        </div>
      @endforeach
    </div>
  </section>

  <section class="container my-5" id="brands-section">
    <div class="row m-0">
      <div class="col-lg-4 col-md-6 col-12 bg-white py-4 px-5 mb-3 mb-md-0">
        <div class="row align-self-end h-100">
          <div class="col-12">
            <h4 class="h3 font-weight-bolder">Заголовок про <br/> бренды</h4>
            <p class="text-gray-1 d-block mt-4">Наш скейтшоп находится в чудесном городе Алма-Ата, на высоте 900 метров над уровнем моря. Иногда мы сравниваем ландшафт города </p>
          </div>
          <div class="col-12 mt-auto">
            <a href="#" class="btn btn-dark d-block py-3 my-auto mb-0">{{ __('Смотреть все бренды') }}</a>
          </div>
        </div>
      </div>

      <div class="col-lg-8 col-md-6 col-12 p-0 ps-md-3">

        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="row">
              @if(count($brands) > 0)
                <div class="col-lg-12 col-md-12 col-4 mb-3 position-relative">
                  <img src="{{ $brands[0]->photo_jpg_storage }}" class="w-100 h-100 object-fit-cover dark-image-25" alt="{{ $brands[0]->name }}">
                  <p class="text-white text-center position-absolute">{{ $brands[0]->name }}</p>
                </div>
              @endif

              @if(count($brands) > 1)
                <div class="col-lg-6 col-md-12 col-4 mb-3 mb-lg-0 position-relative">
                  <img src="{{ $brands[1]->photo_jpg_storage }}" class="w-100 h-100 object-fit-cover dark-image-25" alt="{{ $brands[1]->name }}">
                  <p class="text-white text-center position-absolute">{{ $brands[1]->name }}</p>
                </div>
              @endif

              @if(count($brands) > 2)
                <div class="col-lg-6 col-md-12 col-4 mb-3 mb-lg-0 position-relative">
                  <img src="{{ $brands[2]->photo_jpg_storage }}" class="w-100 h-100 object-fit-cover dark-image-25" alt="{{ $brands[2]->name }}">
                  <p class="text-white text-center position-absolute">{{ $brands[2]->name }}</p>
                </div>
              @endif
            </div>
          </div>

          <div class="col-lg-6 col-md-6">
            <div class="row">

              @if(count($brands) > 3)
                <div class="col-lg-6 col-md-12 col-4 mb-3 position-relative">
                  <img src="{{ $brands[3]->photo_jpg_storage }}" class="w-100 h-100 object-fit-cover dark-image-25" alt="{{ $brands[3]->name }}">
                  <p class="text-white text-center position-absolute">{{ $brands[3]->name }}</p>
                </div>
              @endif

              @if(count($brands) > 4)
                <div class="col-lg-6 col-md-12 col-4 mb-3 position-relative">
                  <img src="{{ $brands[4]->photo_jpg_storage }}" class="w-100 h-100 object-fit-cover dark-image-25" alt="{{ $brands[4]->name }}">
                  <p class="text-white text-center position-absolute">{{ $brands[4]->name }}</p>
                </div>
              @endif

              @if(count($brands) > 5)
                <div class="col-lg-12 col-md-12 col-4 mb-3 mb-lg-0 position-relative">
                  <img src="{{ $brands[5]->photo_jpg_storage }}" class="w-100 h-100 object-fit-cover dark-image-25" alt="{{ $brands[5]->name }}">
                  <p class="text-white text-center position-absolute">{{ $brands[5]->name }}</p>
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
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A6358423497b39c18edf3d1526a35662c1cb50b361ebf554585d2d0b14456a080&amp;source=constructor" width="100%" height="350px" frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
        <div class="col-lg-3 col-md-4 col-6">
          @include('user.layouts.item', ['product' => $product])
        </div>
      @endforeach
    </div>
  </section>

@endsection
