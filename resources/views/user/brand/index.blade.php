@extends('user.layouts.app')

@section('title', 'Бренд - ' . $brand->name)

@section('content')
  <div class="container" id="catalog">
    <div class="row justify-content-md-between justify-content-center">
      <div class="col-md-8 col-12 text-gray-1 mb-4 order-1 order-md-0">
        <div class="mb-2">
          <h2 class="font-weight-bolder text-dark">{{ $brand->name }}</h2>
        </div>
        {!! $brand->description !!}
      </div>
      <div class="col-lg-2 col-md-4 col-6 order-0 order-md-1 mb-4">
        <pircture>
          <img src="{{ $brand->logo_jpg_storage }}" class="img-fluid" alt="{{ $brand->name }}">
        </pircture>
      </div>
    </div>

    <form action="{{ route('brand.show', $brand->id) }}" class="mt-3" method="get" id="product-all">
      <input type="hidden" name="order" id="order" value="{{ $filter['order'] }}">
      <div class="row m-0 w-100 align-items-center">

        <div class="col-12 col-md-auto ps-md-0 px-0 px-md-2 dropdown">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownCategoryLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['category']) > 0 ? 'font-weight-bolder' : null }}">{{ __('Категории') }}</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownCategoryLink">
            @foreach(\App\Models\Category::all() as $category)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="category-{{$category->id}}" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, $filter['category']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="category-{{$category->id}}">{{ $category->name }} <span class="text-muted pl-1">{{ $category->countProducts() }}</span> </label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <hr class="mt-2 mb-1 d-md-none d-block">

        <div class="col-12 col-md-auto px-0 px-md-2 dropdown">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['size']) > 0 ? 'font-weight-bolder' : null }}">{{ __('Размеры') }}</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
            @foreach($attributes as $attr)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="attr-{{$attr->id}}" name="size[]" value="{{ $attr->id }}" {{ in_array($attr->id, $filter['size']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="attr-{{$attr->id}}">{{ $attr->title }} <span class="text-muted pl-1">{{ $attr->category->name }}</span></label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <hr class="mt-2 mb-1 d-md-none d-block">

        <div class="col-12 col-md-auto px-0 mt-3 px-md-2 mt-md-0">
          <button class="btn btn-dark w-100">{{ __('Применить') }}</button>
        </div>

        <div class="col-12 col-md-auto dropdown ms-auto px-0 mt-4 mt-md-0">
          <a href="#" class="text-dark dropdown-toggle text-decoration-none" role="button" id="dropdownOrderLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if($filter['order'] === 'sort-old')
              <i class="fas fa-sort-amount-down"></i> {{ __('С начало старые') }}
            @elseif($filter['order'] === 'sort-new')
              <i class="fas fa-sort-amount-up"></i> {{ __('С начало новые') }}
            @elseif($filter['order'] === 'sort-expensive')
              <i class="fas fa-sort-amount-up"></i> {{ __('С начало дорогие') }}
            @elseif($filter['order'] === 'sort-cheap')
              <i class="fas fa-sort-amount-down"></i> {{ __('С начало дешёвые') }}
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownOrderLink">
            <a href="#" role="button" onclick="orderSort('sort-old')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-old' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> {{ __('С начало старые') }}</a>
            <a href="#" role="button" onclick="orderSort('sort-new')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-new' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> {{ __('С начало новые') }}</a>
            <a href="#" role="button" onclick="orderSort('sort-expensive')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-expensive' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> {{ __('С начало дорогие') }}</a>
            <a href="#" role="button" onclick="orderSort('sort-cheap')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-cheap' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> {{ __('С начало дешёвые')}}</a>
          </div>
        </div>
      </div>
    </form>
    <hr>
    <div class="row ms-1">
      @foreach($filter['category'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Category::find($value)->name }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#category-{{$value}}'))"><i class="far fa-times"></i></button>
        </div>
      @endforeach

      @foreach($filter['size'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Skus::find($value)->title }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#attr-{{$value}}'))"><i class="far fa-times"></i></button>
        </div>
      @endforeach

      <div class="col-auto px-2 py-1 m-1 clear-filters">
        <a href="{{ route('brand.show', $brand->id) }}">{{ __('Очистить всё') }}</a>
      </div>
    </div>
    <hr>
  </div>


  <div class="container">
    <div class="row">
      @forelse($items as $item)
        <div class="col-xl-3 col-lg-4 col-6">
          @include('user.layouts.item', array('product' => $item))
        </div>

      @empty

        <div class="col-12">
          <p class="font-weight-bolder h4 mt-3 text-center">{{ __('Товары отсутствуют') }}</p>
        </div>

      @endforelse
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
