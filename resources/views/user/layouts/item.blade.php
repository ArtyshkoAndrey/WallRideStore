
<div class="card product sale bg-transparent shadow-0 h-100">

  <div class="card-body d-flex flex-column">
    <div class="row">
      <div class="col-12 p-0">
        <a href="#" class="img-wrapper d-block">
          <picture>
            <source type="image/webp" srcset="{{ $product->thumbnail_webp }}">
            <source type="image/jpeg" srcset="{{ $product->thumbnail_jpg }}">
            <img src="{{ $product->thumbnail_jpg }}" class="w-100 h-100" alt="{{ $product->title }}">
          </picture>
          <div class="info">
            <p class="py-2 mb-0 text-white px-3">
              @foreach($product->skuses as $skus)
                @if($loop->last)
                  {{ $skus->title }}
                @else
                  {{ $skus->title }} /
                @endif
              @endforeach
            </p>
          </div>
        </a>
      </div>
    </div>
    <div class="row pt-3 mb-auto">
      <div class="col-12 p-0">
        <a class="title" href="{{ route('product.show', $product->id) }}">{{ $product->title }}</a>
      </div>
    </div>
    <div class="row context mt-auto">
      <div class="col-md-5 col-12 d-flex flex-column align-self-end p-0">
        @if($product->on_sale)
          <span class="old-price">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
          <span class="price">{{ $cost($store.state.currency.ratio * <?= $product->price_sale ?>) }} @{{ $store.state.currency.symbol }}</span>
        @else
          <span class="price font-weight-bolder">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
        @endif
      </div>
      <div class="col-md-7 mt-3 col-12 p-0">
        <a href="#" class="btn btn-dark h-100 w-100 d-block btn-to-cart">
          <span class="pe-2">{{ __('Выбрать') }}</span>
          <i class="far fa-shopping-bag"></i>
        </a>
      </div>
    </div>
  </div>
</div>
