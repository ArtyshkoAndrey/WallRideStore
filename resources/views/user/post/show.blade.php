@extends('user.layouts.app')
@section('title', $post->title)

@section('content')
  <div class="container-fluid container-md">
    <div class="row justify-content-center">
      <div class="col-12 p-0 position-relative">
        <div class="header-image-post">
          <picture >
            <source srcset="{{ $post->photo_storage_jpg }}" type="image/webp">
            <source srcset="{{ $post->photo_storage_webp }}" type="image/jpeg">
            <img src="{{ $post->photo_storage_jpg }}" style="width: 100%" alt="{{ $post->title }}">
          </picture>
        </div>
        <h2 class="text-white font-weight-bolder position-absolute title text-center w-100">{{ $post->title }}</h2>
      </div>
    </div>
  </div>
  <div class="container mt-5 mb-5 post-content">
    <div class="row">
      <div class="col-12">
        {!! $post->content !!}
      </div>
    </div>
  </div>
@endsection


@section('js')

@endsection
