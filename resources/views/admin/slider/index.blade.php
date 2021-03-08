@extends('admin.layouts.app')

@section('title', 'Изображения слайдера')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing justify-content-center">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active">
              <a href="#">Слайдер</a>
            </li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Слайдер</h3>
          </div>

          <div class="col-md-auto col-12 mt-10 mt-md-0 px-0 px-md-10">
            <a href="{{ route('admin.slider.create') }}"
               class="btn d-block">
              Создать новый слайд
            </a>
          </div>

        </div>
      </div>

      <div class="col-12">
        <div class="row">
          <div class="col-md">
            {{ $sliders->links('vendor.pagination.halfmoon') }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="row"
             style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($sliders as $slider)
            <div class="col-12 p-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-auto col-md-auto">
                    <a href="{{ route('admin.slider.edit', $slider) }}"
                       class="text-decoration-none m-0 p-0 text-danger">
                      <h5 class="p-0 m-0 d-block">
                        {{ $slider->h1 }}
                      </h5>
                    </a>
                  </div>

                  <div class="col-md col-12">
                    <div class="row justify-content-center justify-content-md-end">
                      <div class="col-md-auto col-6 pl-0 pl-md-10 mt-10 mt-lg-0 mt-md-10">
                        <a href="{{ route('admin.slider.edit', $slider) }}"
                           class="btn bg-transparent text-success shadow-none border-0 d-md-block d-none">
                          <i class="bx bx-pencil font-size-16"></i>
                        </a>
                        <a href="{{ route('admin.slider.edit', $slider) }}"
                           class="btn btn-success d-block d-md-none w-full">
                          <i class="bx bx-pencil font-size-16"></i>
                        </a>
                      </div>
                      <div class="col-md-auto col-6 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.slider.destroy', $slider) }}"
                              method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger w-full d-block d-md-none">
                            <i class="bx bx-trash font-size-16"></i>
                          </button>
                          <button class="btn shadow-none bg-transparent text-danger border-0 w-full d-none d-md-block">
                            <i class="bx bx-trash font-size-16"></i>
                          </button>
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
