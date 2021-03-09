@extends('user.layouts.app')
@section('title', 'FAQ')

@section('content')
  <div class="container mt-2 cart-page pb-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="font-weight-bolder">FAQ</h2>
      </div>
      <div class="col-12 mt-2">
        <div class="row">
          @forelse($faqs as $faq)
            <div class="col-xl-6 col-lg-6 col-12 post mt-3">
              <div class="card shadow-0 h-100">
                <div class="card-body">
                  <div class="row h-100 align-items-stretch">
                    <div class="col-5 col-md-3 col-lg-4">
                      <img src="{{ $faq->photo_storage_jpg }}"
                           alt="{{ $faq->title }}"
                           class="w-100 h-100 object-fit-cover">
                    </div>
                    <div class="col-7 col-md col-lg justify-content-between d-flex flex-column">
                      <div class="">
                        <a href="{{ route('faq.show', $faq) }}" class="title">
                          {{ $faq->title }}
                        </a>
                      </div>

                      <a href="{{ route('faq.show', $faq) }}" class="text-danger text-right d-block">Далее</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <h5 class="font-weight-bolder text-center">Упс...</h5>
            <p class="text-center">Пока что нет FAQ</p>
          @endforelse
        </div>
        <div class="row mt-4 justify-content-center">
          <div class="col-auto">
            {{ $faqs->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')

@endsection
