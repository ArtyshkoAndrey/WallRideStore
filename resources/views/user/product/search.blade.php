@extends('user.layouts.app')

@section('title', count($products) > 0 ? 'Резултаты поиска' : 'Ничего не найдено')
@section('content')
  <div class="container search-page pb-5">
    <div>
      <h3 class="font-weight-bolder">Результат поиска</h3>
      <span class="badge">{{ count($products) }}</span>
    </div>
    <div class="row">
      @forelse($products as $product)
        <div class="col-6 col-lg-4 col-xl-3">
          @include('user.layouts.item', ['product' => $product])
        </div>
      @empty
        <div class="col-12 ">
          <div class="row justify-content-center">
            <div class="col-md-6 text-center col-12">
              <div class="not-found">
                <p class="mt-2">
                  Извените, мы не смогли найти<br>ничего по запросу
                  <span class="font-weight-bolder">{{ Request::get('q', '') }}</span>
                </p>
                <p class="another mt-2">Попробуйте найти что-то другое</p>
                <a href="{{ route('product.all') }}" class="btn btn-dark mt-2">Вернуться в каталог</a>
              </div>

            </div>

          </div>

        </div>
      @endforelse
    </div>
  </div>
@endsection

