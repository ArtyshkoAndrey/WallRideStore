@extends('user.layouts.app')

@section('title', 'Каталог товаров')

@section('content')
  <div class="container" id="catalog">
    <div class="mb-2">
      <span class="title">{{ __('Каталог товаров') }}</span>
      <span class="badge text-dark">{{ $itemsCount }}</span>
      <button class="ms-auto d-block d-md-none position-relative"
              style="border: none; background: transparent; color: #2D3134;">
        <span class="fas fa-filter" style="font-size: 1.4em;"></span>
        <span class="badge rounded-pill badge-notification bg-dark text-white">{{ $counter }}</span>
      </button>
    </div>

    <form action="{{ route('product.all') }}" class="" method="get" id="product-all">
      <input type="hidden" name="order" id="order" value="{{ $filter['order'] }}">
      <div class="row m-0 w-100 align-items-center">

        <div class="col-12 col-md-auto ps-md-0 px-0 px-md-3 dropdown d-sm-block d-none">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button"
             id="dropdownCategoryLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span
              class="{{ count($filter['category']) > 0 ? 'font-weight-bolder' : null }}">{{ __('Категории') }}</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto"
               aria-labelledby="dropdownCategoryLink">
            @foreach(\App\Models\Category::orderByTranslation('name')->get() as $category)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="category-{{$category->id}}" name="category[]"
                           value="{{ $category->id }}" {{ in_array($category->id, $filter['category']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="category-{{$category->id}}">{{ $category->name }} <span
                        class="text-muted pl-1">{{ $category->countProducts() }}</span> </label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-12 col-md-auto px-0 px-md-3 dropdown d-sm-none">
          <div class="select d-sm-none col-12">
            <select class="col-12" name="category_mobile">
              <option value="0">{{ __('Категории') }}</option>
              @foreach(\App\Models\Category::orderByTranslation('name')->get() as $category)
                @if(request()->get('category_mobile') == $category->id):
                  <option value="{{ $category->id }}" selected> {{ $category-> name }}</option>
                @else
                  <option value="{{ $category->id }}"> {{ $category-> name }}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>

        <hr class="mt-2 mb-1 d-md-none d-block">

        <div class="col-12 col-md-auto ps-md-0 px-0 px-md-3 dropdown d-sm-block d-none">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button"
             id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['brand']) > 0 ? 'font-weight-bolder' : null }}">{{ __('Бренды') }}</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto"
               aria-labelledby="dropdownBrandLink">
            @foreach($brands as $brand)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="brand-{{$brand->id}}" name="brand[]"
                           value="{{ $brand->id }}" {{ in_array($brand->id, $filter['brand'], true) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="brand-{{$brand->id}}">{{ $brand->name }} <span
                        class="text-muted pl-1">{{ $brand->products()->count() }}</span> </label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-12 col-md-auto px-0 px-md-3 dropdown d-sm-none">
          <div class="select d-sm-none col-12">
            <select class="col-12" name="brand_mobile">
              <option value="0">{{ __('Бренды') }}</option>
              @foreach($brands as $brand)
                @if(request()->get('brand_mobile') == $brand->id):
                 <option value="{{ $brand->id }}" selected> {{ $brand-> name }}</option>
                @else
                  <option value="{{ $brand->id }}"> {{ $brand-> name }}</option>
                @endif

              @endforeach
            </select>
          </div>
        </div>

        <hr class="mt-2 mb-1 d-md-none d-block">

        <div class="col-12 col-md-auto px-0 px-md-3 dropdown d-sm-block d-none">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button"
             id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['size']) > 0 ? 'font-weight-bolder' : null }}">{{ __('Размеры') }}</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto"
               aria-labelledby="dropdownBrandLink">
            @foreach($attributes as $attr)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="attr-{{$attr->id}}" name="size[]"
                           value="{{ $attr->id }}" {{ in_array($attr->id, $filter['size']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="attr-{{$attr->id}}">{{ $attr->title }} <span
                        class="text-muted pl-1">{{ $attr->category->name }}</span></label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-12 col-md-auto px-0 px-md-3 dropdown d-sm-none">
          <div class="select d-sm-none col-12">
            <select class="col-12" name="size_mobile">
              <option value="">Размеры</option>
              @foreach($attributes as $attr)
                @if(request()->get('size_mobile') == $attr->id):
                  <option value="{{ $attr->id }}" selected> {{ $attr-> title }}</option>
                @else
                  <option value="{{ $attr->id }}"> {{ $attr-> title }}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        <hr class="mt-2 mb-1 d-md-none d-block">

        <div class="col-auto mt-2 mt-md-0 px-0 px-md-1 hiddable-filter">
          <div class="checkbox w-100 h-100 d-flex align-items-center">
            <div class="row align-items-start">
              <div class="col-auto pe-0 d-flex align-items-center">
                <input type="checkbox" class="form-check-input" id="sale" name="sale"
                       value="true" {{ $filter['sale'] ? 'checked' : null }}>
              </div>
              <div class="col m-0 ps-0">
                <label class="form-check-label" for="sale">Sale</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-auto mt-2 mt-md-0 hiddable-filter">
          <div class="checkbox w-100 h-100 d-flex align-items-center">
            <div class="row align-items-start">
              <div class="col-auto pe-0 d-flex align-items-center">
                <input type="checkbox" class="form-check-input" id="new" name="new"
                       value="true" {{ $filter['new'] ? 'checked' : null }}>
              </div>
              <div class="col m-0 ps-0">
                <label class="form-check-label" for="new">New</label>
              </div>
            </div>
          </div>
        </div>

        <hr class="mt-2 mb-1 d-md-none d-block">

        <div class="col-12 col-md-auto px-0 mt-3 mt-md-0">
          <button class="btn btn-dark w-100">{{ __('Применить') }}</button>
        </div>

        <div class="col-12 col-md-auto dropdown ms-auto px-0 mt-4 mt-md-0">
          <a href="#" class="text-dark dropdown-toggle text-decoration-none" role="button" id="dropdownOrderLink"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if($filter['order'] === 'sort-old')
              <i class="fas fa-sort-amount-down"></i> {{ __('Сначала старые') }}
            @elseif($filter['order'] === 'sort-new')
              <i class="fas fa-sort-amount-up"></i> {{ __('Сначала новые') }}
            @elseif($filter['order'] === 'sort-expensive')
              <i class="fas fa-sort-amount-up"></i> {{ __('Сначала дорогие') }}
            @elseif($filter['order'] === 'sort-cheap')
              <i class="fas fa-sort-amount-down"></i> {{ __('Сначала дешёвые') }}
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4"
               aria-labelledby="dropdownOrderLink">
            <a href="#" role="button" onclick="orderSort('sort-old')"
               class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-old' ? 'active' : '' }}"><i
                class="fas fa-sort-amount-down"></i> {{ __('Сначала старые') }}</a>
            <a href="#" role="button" onclick="orderSort('sort-new')"
               class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-new' ? 'active' : '' }}"><i
                class="fas fa-sort-amount-up"></i> {{ __('Сначала новые') }}</a>
            <a href="#" role="button" onclick="orderSort('sort-expensive')"
               class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-expensive' ? 'active' : '' }}"><i
                class="fas fa-sort-amount-up"></i> {{ __('Сначала дорогие') }}</a>
            <a href="#" role="button" onclick="orderSort('sort-cheap')"
               class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-cheap' ? 'active' : '' }}"><i
                class="fas fa-sort-amount-down"></i> {{ __('Сначала дешёвые')}}</a>
          </div>
        </div>
      </div>
    </form>
    <hr>
    <div class="row ms-1">
      @foreach($filter['category'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Category::find($value)->name }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0"
                  onclick="uncheckProps($('#category-{{$value}}'))"><i class="far fa-times"></i></button>
        </div>
      @endforeach

      @foreach($filter['brand'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Brand::find($value)->name }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#brand-{{$value}}'))">
            <i class="far fa-times"></i></button>
        </div>
      @endforeach
      @foreach($filter['size'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Skus::find($value)->title }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#attr-{{$value}}'))">
            <i class="far fa-times"></i></button>
        </div>
      @endforeach

      <div class="col-auto px-2 py-1 m-1 clear-filters">
        <a href="{{ route('product.all') }}">{{ __('Очистить всё') }}</a>
      </div>
    </div>
    <hr>
  </div>


  <div class="container">
    <div class="row">
      @foreach($items as $item)
        <div class="col-xl-3 col-lg-4 col-6">
          @include('user.layouts.item', array('product' => $item))
        </div>
      @endforeach
    </div>
    <div class="row mt-4 justify-content-center">
      <div class="col-auto">
        {{ $items->onEachSide(1)->appends($filter)->links('vendor.pagination.bootstrap-4') }}
      </div>
    </div>
  </div>

@endsection

@section('js')
  <script>
    $(function () {
      $("#catalog .dropdown-menu").on('click', function (event) {
        event.stopPropagation();
      });
    })

    function uncheckProps(el) {
      el.prop('checked', false)
      $('#product-all').submit()
    }

    function orderSort(type) {
      $('#order').val(type)
      $('#product-all').submit()
    }

    function toggleFilters() {
      for (let filter of $('.hiddable-filter')) {
        $(filter).toggleClass('d-block')
      }
    }
  </script>
@endsection
