<div class="card product sale bg-transparent shadow-0 h-100">

  <div class="card-body d-flex flex-column">
    <div class="row">
      <div class="col-12 p-0">
        <a href="{{ route('product.show', $product->id) }}" class="img-wrapper d-block">
          <picture>
            <source type="image/webp" srcset="{{ $product->thumbnail_webp }}">
            <source type="image/jpeg" srcset="{{ $product->thumbnail_jpg }}">
            <img src="{{ $product->thumbnail_jpg }}" class="w-100 h-100" alt="{{ $product->title }}">
          </picture>
          <div class="info">
            <p class="py-2 mb-0 text-white px-3">
              @if(isset($product->skusesnew))
                @for($i=0;$i<count($product->skusesnew[0]);$i++)
                  @if($product->skusesnew[2][$i]> 0)
                    @if($loop->last)
                      <span style="white-space: nowrap">{{ $product->skusesnew[1][$i] }}</span>
                    @else

                      <span style="white-space: nowrap">{{ $product->skusesnew[1][$i] }}</span>

                    @endif
                  @endif
                @endfor
              @endif
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
      <div class="col-md-4 col-12 d-flex flex-column align-self-end p-0 mt-2 mt-md-0">
        @if($product->on_sale)
          <span class="old-price">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
          <span class="price text-danger">{{ $cost($store.state.currency.ratio * <?= $product->price_sale ?>) }} @{{ $store.state.currency.symbol }}</span>
        @else
          <span class="price font-weight-bolder">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
        @endif
      </div>
      <div class="col-md-8 mt-2 mt-md-3 col-12 p-0">
        @if(count($product->skuses) > 1)
          <a href="{{ route('product.show', $product->id) }}" class="btn btn-dark h-100 w-100 d-block btn-to-cart">
            <span class="pe-2">{{ __('Выбрать размер') }}</span>
            <i class="far fa-shopping-bag"></i>
          </a>
        @elseif(count($product->skuses) === 1)
          {{--          <button class="btn btn-dark h-100 w-100 d-block btn-to-cart"--}}
          {{--                  @click="$store.commit('addItem', {id: {{ $product->skuses()->first()->pivot->id }}, amount: 1})">--}}
          {{--            <span class="pe-2">{{ __('В корзину') }}</span>--}}
          {{--            <i class="far fa-shopping-bag"></i>--}}
          {{--          </button>--}}
          <btn-product :id="{{ $product->skuses()->first()->pivot->id }}"
                       :label="'{{ __('В корзину') }}'"></btn-product>

        @else
          <button disabled="disabled" class="btn btn-dark h-100 w-100 d-block btn-to-cart">
            <span class="pe-2">{{ __('Товар закончился') }}</span>
          </button>
        @endif

      </div>
    </div>
  </div>
</div>
