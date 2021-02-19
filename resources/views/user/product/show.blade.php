@extends('user.layouts.app')

@section('title', $product->title)

@section('content')
  <div class="container my-5 ">
    <div class="row">
      <div class="col-12 ps-3 breadcrumb">
        @foreach($categories as $category)
          <a class="breadcrumb-link" href="{{ route('product.all', ['category' => $category->id]) }}">{{ $category->name }}</a>
        @endforeach
        <p>{{ $product->title }}</p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <img src="{{ asset('images/product.jpg') }}" class="w-100 h-100 object-fit-cover" alt="">
      </div>
    </div>
  </div>
@endsection
