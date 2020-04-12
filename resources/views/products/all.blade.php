@extends('layouts.app')
@section('title', 'Список товаров')

@section('content')
{{--    {{ dd($products) }}--}}
  <section class="container mt-5 pt-5">
    <form action="{{ route('products.all') }}" class="mt-3">
      <div class="row">
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="order" class="form-control js-example-basic" placeholder="Сортировать">
            <option value="new_desc">Сначала новые</option>
            <option value="price_asc">Сначала дешевые</option>
            <option value="price_desc">Сначало дорогие</option>
            <option value="sold_count_desc">По убыванию продаж</option>
            <option value="sold_count_asc">По возрастанию продаж</option>
          </select>
        </div>
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="brand" class="form-control js-example-basic" placeholder="Бренд">
            @foreach(App\Models\Brand::all()    as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="category" class="form-control js-example-basic" placeholder="Категория">
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md col-6 mt-4 mt-md-0">
          <select name="size" class="form-control js-example-basic" placeholder="Размер">
            @foreach($attributes as $attr)
              <option value="{{ $attr->id }}">{{ $attr->title }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </form>
  </section>
  <section class="mt-5">
    <div class="container">
      <div class="row align-items-center px-3">
        <div class="col-12"><h2 class="font-weight-bold d-block">Все товары</h2></div>
        @if ($message = Session::get('filter'))
          <div class="col-12">
            <h4 class="text-muted">
              {{ $message }}
            </h4>
          </div>
        @endif
      </div>
    </div>
    <div class="container">
      <div class="row">
        @foreach($products as $product)
          <product :slider=false :currency="{{ $currency }}" :item="{{ $product }}"></product>
        @endforeach
        <div class="col-12 d-flex justify-content-center mt-2 mb-5">
          <div>{{ $products->appends($filters)->render() }}</div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')
  <script>
    let filters = {!! json_encode($filters) !!};
    $(document).ready(function () {
      $('form select[name=order]').on('change', function() {
        $('form').submit();
      });
      $('form select[name=brand]').on('change', function() {
        $('form').submit();
      });
      $('form select[name=category]').on('change', function() {
        $('form').submit();
      });
      $('form select[name=size]').on('change', function() {
        $('form').submit();
      });
    })
    $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width());
    window.addEventListener("resize", () => {
      $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width())
    });
    $('select[name="brand"]').select2({
      width: 'resolve',
      closeOnSelect: false,
      placeholder: 'Бренд',
      allowClear: true
    })
    $('select[name="category"]').select2({
      width: 'resolve',
      closeOnSelect: false,
      placeholder: 'Категория',
      allowClear: true
    })
    $('select[name="order"]').select2({
      width: 'resolve',
      closeOnSelect: false,
      placeholder: 'Сортировать по',
      allowClear: true
    })
    $('select[name="size"]').select2({
      width: 'resolve',
      closeOnSelect: false,
      placeholder: 'Размер',
      allowClear: true
    })

    $('select[name="brand"]').val(filters.brand)
    $('select[name="category"]').val(filters.category)
    $('select[name="order"]').val(filters.order)
    $('select[name="size"]').val(filters.size)

    $('.js-example-basic').trigger("change")
    $('.select2-selection').css('border-radius','0px')
    $('.fr-toolbar').css('border-radius','0px')
    $('.second-toolbar').css('border-radius','0px')
  </script>
@endsection
