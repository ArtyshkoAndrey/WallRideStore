@extends('user.layouts.app')

@section('title', 'Избранный товары')

@section('content')
  <div class="container">
    <div class="row">
      <div class="mb-2">
        <h3 class="font-weight-bolder">{{ __('Избранные товары') }}</h3>
      </div>
    </div>
    <div class="row">
      @foreach($products as $product)
        <div class="col-xl-3 col-lg-4 col-6">
          @include('user.layouts.item', ['product' => $product])
        </div>
      @endforeach
    </div>
  </div>
@endsection
