
<div class="card product sale bg-transparent shadow-0 h-100">

  <div class="card-body d-flex flex-column">
    <div class="row">
      <div class="col-12 p-0">
        <div class="img-wrapper d-block">
          <picture>
            <source type="image/webp" srcset="{{ $item->product->thumbnail_webp }}">
            <source type="image/jpeg" srcset="{{ $item->product->thumbnail_jpg }}">
            <img src="{{ $item->product->thumbnail_jpg }}" class="w-100 h-100" alt="{{ $item->product->title }}">
          </picture>
        </div>
      </div>
    </div>
    <div class="row pt-3 mb-auto">
      <div class="col-12 p-0">
        <div class="title">{{ $item->product->title }}</div>
      </div>
    </div>
    <div class="row context mt-auto">
      <div class="col-md-4 col-12 d-flex flex-column align-self-end p-0 mt-2 mt-md-0">
          <span class="price font-weight-bolder">{{ number_format($item->price, 0,',', ' ') }} ₸</span>
      </div>
    </div>
  </div>
</div>
