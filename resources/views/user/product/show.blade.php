@extends('user.layouts.app')

@section('title', $product->title)

@section('content')
  <div class="container my-5 item-page">
    <div class="row">

      <div class="col-12 ps-3 breadcrumb d-lg-none d-block">
        @foreach($categories as $category)
          <a class="breadcrumb-link mb-0" href="{{ route('product.all', ['category' => $category->id]) }}">{{ $category->name }}</a>
        @endforeach
        <p class="mb-0">{{ $product->title }}</p>
      </div>

      <div class="row d-none d-lg-block">
        <div class="col-6">
          <div class="row">
            <div class="col-3 d-flex justify-content-center">
              <button id="prev" class="slider-button"><i class="far fa-chevron-up"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6 slider">
        <div class="row flex-column-reverse flex-lg-row">
          <div class="col-12 col-lg-3 slider-nav">
            <div class="scroll-wrapper flex-row flex-lg-column justify-content-start">

              @foreach($product->photos as $photo)

                <div class="item">
                  <div class="img-wrapper" data-image-id="{{ $photo->id }}">
                    <picture>
                      <source type="image/webp" srcset="{{ $photo->thumbnail_url_webp }}">
                      <source type="image/jpeg" srcset="{{ $photo->thumbnail_url_jpg }}">
                      <img class="w-100" src="{{ $photo->thumbnail_url_jpg }}" alt="{{ $photo->name }}">
                    </picture>

                  </div>
                </div>

              @endforeach

            </div>
          </div>
          <div class="col-12 col-lg-9 slider-for">
            @foreach($product->photos as $index => $photo)
              <div class="img-wrapper {{ $index === 0 ? 'active' : null }}" data-id="{{ $photo->id }}">
                <picture>
                  <source type="image/webp" srcset="{{  $photo->url_webp }}">
                  <source type="image/jpeg" srcset="{{  $photo->url_jpg }}">
                  <img class="w-100 img-product" src="{{ $photo->url_jpg }}" alt="{{ $photo->name }}">
                </picture>
              </div>
            @endforeach

          </div>
          <div class="col-12 d-none d-lg-block">
            <div class="row">
              <div class="col-3 d-flex justify-content-center">
                <button id="next" class="slider-button"><i class="far fa-chevron-down"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12 pl-md-4 item-details ">
        <div class="row flex-column">
          <div class="col-12 ps-3 breadcrumb d-none d-lg-block">
            @foreach($categories as $category)
              <a class="breadcrumb-link mb-0" href="{{ route('product.all', ['category' => $category->id]) }}">{{ $category->name }}</a>
            @endforeach
            <p class="mb-0">{{ $product->title }}</p>
          </div>
          <h2 class="font-weight-bolder col-md-8 mb-4 mt-3 mt-lg-0 col-12">{{ $product->title }}</h2>

          <div class="col-12 prices-wrapper sale mb-2">
            @if($product->on_sale)
              <span class="old-price">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
            @endif
            <span class="price">{{ $cost($store.state.currency.ratio * <?= $product->on_sale ? $product->price_sale : $product->price?>) }} @{{ $store.state.currency.symbol }}</span>
          </div>

          <div class="col-md-12 mb-2">
            <select name="skus" class="form-control rounded-0" id="skus" v-model.number="selectSkus">
              <option value="null" selected disabled>{{ __('Размер') }}</option>
              @foreach($product->skuses()->orderBy('weight')->get() as $skus)
                <option value="{{ $skus->pivot->id }}" {{ $skus->pivot->stock === 0 ? 'disabled' : null }}>{{ $skus->title }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12">

            <div class="row">
              <div class="col-md-6 mt-2">
{{--                <button class="btn w-100 btn-dark btn-to-cart-show mt-2 mt-md-0"--}}
{{--                        :disabled="selectSkus === null"--}}
{{--                        @click="$store.commit('addItem', {id: selectSkus, amount: 1})">--}}
{{--                  <span>{{ __('Добавить в корзину') }}</span>--}}
{{--                  <i class="ms-2 far fa-shopping-bag"></i>--}}
{{--                </button>--}}
                <btn-product :id="selectSkus" :label="'{{ __('Добавить в корзину') }}'" :disabled="selectSkus === null"></btn-product>
              </div>

              <div class="col-md-6 mt-2">
                <button class="btn w-100 btn-dark btn-to-cart-show mt-2 mt-md-0"
                        @click="$store.commit('addItemFavor', {{ $product->id }})">
                  <span v-if="!$store.getters.productFavor( {{$product->id}} )">{{ __('Добавить в избранные') }}</span>
                  <span v-else>{{ __('Убрать из избранных') }}</span>
                  <i class="ms-2 far fa-heart"></i>
                </button>
              </div>

            </div>
          </div>
          <div class="col-12 mt-3 description-wrapper">
            <div class="row">
              <div class="col-12 title">{{ __('Описание') }}</div>
              <div class="col-12 description">
                {!! $product->description !!}
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>

    <div class="row mt-5">
      <div class="col-12">
        <h4 class="font-weight-bolder">{{ __('Похожие товары') }}</h4>
      </div>
      @foreach($similarProducts as $product)
        <div class="col-xl-3 col-lg-4 col-6">
          @include('user.layouts.item', ['product' => $product])
        </div>
      @endforeach
    </div>


  </div>
@endsection

@section('js')
  <script src="https://unpkg.com/zooming"></script>
  <script>
    let showItemAmount = 4
    let currentPosition = 0
    let currentItem = 0
    let scrollStep = 0
    let itemAmount = {{ count($product->photos) }};
    let itemHeight = 0
    // let itemMarginBottom = parseInt($('.slider-nav .item .img-wrapper').css('marginBottom'))
    let itemMarginBottom = 20
    function initSliderSize() {
      let previewImageHeight = $('.slider-for .img-wrapper').height()
      $('.slider-nav').height(previewImageHeight)
      itemHeight = previewImageHeight / showItemAmount - itemMarginBottom + itemMarginBottom / 4
      for (let item of $('.slider-nav .item .img-wrapper')) {
        $(item).css('height', itemHeight)
        $(item).css('width', itemHeight)
      }
      return itemHeight
    }
    document.addEventListener('animationstart', function (e) {
      if (e.animationName === 'fade-in') {
        e.target.classList.add('did-fade-in');
      }
    });
    document.addEventListener('animationend', function (e) {
      if (e.animationName === 'fade-out') {
        e.target.classList.remove('did-fade-in');
      }
    });
    $(window).resize(function() {
      itemHeight = initSliderSize()
      scrollStep = itemHeight + itemMarginBottom
      currentPosition = currentItem * scrollStep
      $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
    })
    $(window).ready(function() {
      itemHeight = initSliderSize()
      currentPosition = 0
      scrollStep = itemHeight + itemMarginBottom
      $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
    })
    $('.slider-button#prev').click(function() {
      if (currentPosition > 0) {
        currentItem--
        currentPosition -= scrollStep
        $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
      }
    })
    $('.slider-button#next').click(function() {
      if (currentPosition < (itemAmount - 2) * itemHeight) {
        currentItem++
        currentPosition += scrollStep
        $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
      }
    })
    $('.slider-nav .img-wrapper').click(function() {
      let imageID = $(this).attr('data-image-id')
      console.log($('.slider-for .img-wrapper[data-id=' + imageID + ']'))
      $('.slider-for .img-wrapper.active').removeClass('active')
      $('.slider-for .img-wrapper[data-id=' + imageID + ']').addClass('active')
    })
    new Zooming({
      onBeforeOpen: () => {
        $('body').css('overflow','hidden')
        $('hidden-overflow').css('overflow', 'auto')
      },
      onBeforeClose: () => {
        $('body').css('overflow','auto')
        $('hidden-overflow').css('overflow', 'hidden')
      },
      scaleBase: 1,
      scaleExtra: 1.5,
      scrollThreshold: 99999
    }).listen('.img-product')
  </script>
@endsection
