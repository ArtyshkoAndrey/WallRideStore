@extends('admin.layouts.app')

@section('title', 'FAQ')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing justify-content-center">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">FAQ</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>FAQ</h3>
          </div>

          <div class="col-md-auto col-12 mt-10 mt-md-0 px-10">
            <a href="{{ route('admin.faq.create') }}" class="btn d-block">Создать новую FAQ</a>
          </div>

        </div>
      </div>

      <div class="col col-md mb-20 mt-10 pr-10">
        <form action="{{ route('admin.faq.index') }}" method="get">
          <div class="input-group">
            <label for="title"></label>
            <input value="{{ $filter['title'] }}" type="text" name="title" id="title" placeholder="Поиск по заголовке" class="form-control shadow-none border-none" required>
            <div class="input-group-append">
              <button class="btn rounded-right shadow-none border-none">
                <i class="bx bx-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-auto mt-10 col-auto">
        <a href="{{ route('admin.faq.index') }}" class="btn">Сбросить</a>
      </div>

      <div class="col-12">
        <div class="row">
          <div class="col-md">
            {{ $faqs->links('vendor.pagination.halfmoon') }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($faqs as $faq)
            <div class="col-12 col-md-12 col-xl-6 p-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-auto col-md-auto">
                    <a href="{{ route('admin.faq.edit', $faq) }}" class="text-decoration-none m-0 p-0 text-danger">
                      <h5 class="p-0 m-0 d-block">{{ $faq->title }}</h5>
                    </a>
                  </div>

                  <div class="col-lg col-12">
                    <div class="row justify-content-end">
                      <div class="col-md-auto col-6 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <a href="{{ route('admin.faq.edit', $faq) }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                      </div>
                      <div class="col-md-auto col-6 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn shadow-none bg-transparent text-danger border-0 w-full d-block"><i class="bx bx-trash font-size-16"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
@endsection


@section('script')

@endsection
