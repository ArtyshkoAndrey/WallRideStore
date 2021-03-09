@extends('user.layouts.app')
@section('title', $faq->title)

@section('content')
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 p-0">
        <div class="header-image-post">
          <picture >
            <source srcset="{{ $faq->photo_storage_jpg }}" type="image/webp">
            <source srcset="{{ $faq->photo_storage_webp }}" type="image/jpeg">
            <img src="{{ $faq->photo_storage_jpg }}" style="width: 100%" alt="{{ $faq->title }}">
          </picture>
        </div>
        <h2 class="text-white font-weight-bolder position-absolute title text-center w-100">{{ $faq->title }}</h2>
      </div>
    </div>
  </div>
  <div class="container mt-5 mb-5 post-content">
    <div class="row">
      <div class="col-12">
        {!! $faq->content !!}
      </div>
    </div>
  </div>
@endsection


@section('js')

@endsection
