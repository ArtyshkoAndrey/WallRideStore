@extends('layouts.app')
@section('title', 'FAQ')

@section('content')

  <section class="container-fluid mt-5 pt-5 mb-5">
    <div class="row">
      <div class="col-12 mt-5 offset-md-1 col-lg-4 col-md-6">
        <h1 class="font-weight-bold">FAQ - все для скейтеров</h1>
        <p>Здесь можно найти всю интересующую информацию о скейтборде: что выбрать, как собрать скейтборд, в чем кататься и т.д</p>
      </div>
    </div>
    <div class="row align-content-center justify-content-center">
      @forelse($faqs as $f)
      <div class="col-xl-2 mt-3 col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="card h-100 faq m-0 p-0 rounded-0">
          <div class="card-header position-relative border-0 p-0">
            <img src="{{ $f->getImage() }}" class="img-fluid w-100 p-0" alt="{{ $f->title }}">
          </div>
          <div class="card-body">
            <p class="h4 font-weight-bolder">{{ $f->title }}</p>
            <a href="{{ route('faqs.show', $f->id) }}" class="btn btn-dark mt-3 rounded-0 d-block font-weight-bolder">Читать</a>
          </div>
        </div>
      </div>
      @empty
        <h4>Нет FAQ</h4>
      @endforelse
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
