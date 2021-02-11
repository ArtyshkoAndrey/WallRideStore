<div class="card product sale bg-transparent shadow-0 h-100">

  <div class="card-body d-flex flex-column">
    <div class="row">
      <div class="col-12 p-0">
        <a href="#" class="img-wrapper d-block">
          <picture>
            <source type="image/webp" srcset="{{ asset('images/product.jpg') }}">
            <source type="image/jpeg" srcset="{{ asset('images/product.jpg') }}">
            <img src="{{ asset('images/product.jpg') }}" class="w-100 h-100" alt="...">
          </picture>
          <div class="info">
            <p class="py-2 mb-0 text-white px-3">L / M / XXL</p>
          </div>
        </a>
      </div>
    </div>
    <div class="row pt-3 mb-auto">
      <div class="col-12 p-0">
        <a class="title" href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis, quidem.</a>
      </div>
    </div>
    <div class="row context mt-auto">
      <div class="col-md-5 col-12 d-flex flex-column justify-content-center p-0">
{{--        @if($item->on_sale)--}}
          <span class="old-price">123 000 @{{ $store.state.currency.symbol }}</span>
          <span class="price">120 000 @{{ $store.state.currency.symbol }}</span>
{{--        @else--}}
{{--          <span class="price">123 000 @{{ $store.state.currency.symbol }}</span>--}}
{{--        @endif--}}
      </div>
      <div class="col-md-7 col-12 p-0">
{{--        @if($item->skuses()->count() >=  2)--}}
          <a href="#" class="btn btn-dark h-100 w-100 d-block btn-to-cart">
            <span class="pe-2">{{ __('Выбрать') }}</span>
            <i class="far fa-shopping-bag"></i>
          </a>
{{--        @elseif($item->skuses()->count() === 1)--}}
{{--          <button class="btn btn-outline-dark btn-to-cart w-100 mt-2 mt-md-0"--}}
{{--                  @click="$store.commit('addItem', {id: {{ $item->skuses()->first()->pivot->id }}, amount: 1})">--}}
{{--            <i class="bx bx-cart"></i>--}}
{{--            <span>В корзину</span>--}}
{{--          </button>--}}
{{--        @else--}}
{{--          <button class="btn btn-outline-dark btn-to-cart w-100 mt-2 mt-md-0" disabled>--}}
{{--            Товар распродан--}}
{{--          </button>--}}
{{--        @endif--}}

      </div>
    </div>
  </div>
</div>
