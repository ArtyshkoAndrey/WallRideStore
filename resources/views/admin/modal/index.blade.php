@extends('admin.layouts.app')

@section('title', 'Модальные окна')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">Модальные окна</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Модальные окна</h3>
          </div>

          <div class="col-auto px-10">
            <a href="{{ route('admin.modal.create') }}" class="btn d-block">Создать новое модальное окно</a>
          </div>

        </div>
      </div>

      <div class="col-md-4 col-8">
        <form action="{{ route('admin.modal.index') }}" method="get">
          <div class="input-group">
            <label for="name"></label>
            <input value="{{ $filter['title'] }}" type="text" name="title" id="title" placeholder="Заголовок" class="form-control shadow-none border-none" required>
            <div class="input-group-append">
              <button type="submit" class="btn rounded-right shadow-none border-none">
                <i class="bx bx-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-auto col">
        <a href="{{ route('admin.modal.index') }}" class="btn">Сбросить</a>
      </div>

      <div class="col-12 mt-10">
        <div class="row">
          <div class="col-md">
            {{ $modals->links('vendor.pagination.halfmoon') }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($modals as $modal)
            <div class="col-12 mt-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-md-1">
                    <img src="{{ $modal->photo_jpg_storage }}" class="img-fluid rounded" alt="{{ $modal->title }}">
                  </div>
                  <div class="col-4 col-md-4 pl-10 col-lg-auto">
                    <a href="{{ route('admin.modal.edit', $modal->id) }}" class="text-decoration-none text-danger m-0 p-0"><h5 class="p-0 m-0 d-block">{{ $modal->title }}</h5></a>
                  </div>

                  <div class="col-auto h-full col-md-auto ml-auto ml-md-10 d-none d-md-block">
                    @if($modal->status)
                      <p class="m-0 text-success">Активно</p>
                    @else
                      <p class="m-0 text-danger">Не активно</p>
                    @endif
                  </div>

                  <div class="col-md col">
                    <div class="row justify-content-center">

                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10 ml-lg-auto">
                        <a href="{{ route('admin.modal.edit', $modal->id) }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                      </div>
                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.modal.destroy', $modal->id) }}" method="POST">
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

@section('modal')

@endsection

@section('script')
  <script>
    document.addEventListener("DOMContentLoaded", function() {

    });
  </script>
@endsection
