@extends('layouts.app')
@section('title', 'FAQ - ' . $f->title)

@section('content')
  <section class="container-fluid p-0 text-white" id="slider">
    <div class="row p-0 m-0">
      <div class="col-12 p-0">
        <div style="width: 100%; height: 100%; background: rgba(0,0,0,0.6); position: absolute"></div>
        <img class="img-fluid" style="object-position: top" src="{{ $f->getImage() }}" alt="{{ $f->title}}">
      </div>
      <div class="col-12 p-0 position-absolute text-center">
        <h1>{{ $f->title }}</h1>
        <a href="javascript:window.history.back()" class="btn">Назад</a>
      </div>
    </div>
  </section>
  <section class="container mt-5 mb-5" id="news">
    <div class="row">
      <div class="col-12">
        {!! $f->content !!}
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
