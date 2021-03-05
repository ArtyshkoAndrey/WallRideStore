@extends('admin.layouts.app')

@section('title', 'Новости')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing justify-content-center">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active">
              <a href="#">Новости</a>
            </li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Новости</h3>
          </div>

          <div class="col-md-auto col-12 mt-10 mt-md-0 px-0 px-md-10">
            <a href="{{ route('admin.post.create') }}"
               class="btn d-block">
              Создать новую новость
            </a>
          </div>

        </div>
      </div>

      <div class="col col-md mb-20 mt-10 pr-10">
        <form action="{{ route('admin.post.index') }}"
              method="get">
          <div class="input-group">
            <label for="title"></label>
            <input value="{{ $filter['title'] }}"
                   type="text"
                   name="title"
                   id="title"
                   placeholder="Поиск по заголовку"
                   class="form-control shadow-none border-none"
                   required>
            <div class="input-group-append">
              <button class="btn rounded-right shadow-none border-none">
                <i class="bx bx-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-auto mt-10 col-auto">
        <a href="{{ route('admin.post.index') }}"
           class="btn">
          Сбросить
        </a>
      </div>

      <div class="col-12">
        <div class="row">
          <div class="col-md">
            {{ $posts->links('vendor.pagination.halfmoon') }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="row"
             style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($posts as $post)
            <div class="col-12 p-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-auto col-md-auto">
                    <a href="{{ route('admin.post.edit', $post) }}"
                       class="text-decoration-none m-0 p-0 text-danger">
                      <h5 class="p-0 m-0 d-block">
                        {{ $post->title }}
                      </h5>
                    </a>
                  </div>

                  <div class="col-md col-12">
                    <div class="row justify-content-center justify-content-md-end">
                      <div class="col-md-auto col-6 pl-0 pl-md-10 mt-10 mt-lg-0 mt-md-10">
                        <a href="{{ route('admin.post.edit', $post) }}"
                           class="btn bg-transparent text-success shadow-none border-0 d-md-block d-none">
                          <i class="bx bx-pencil font-size-16"></i>
                        </a>
                        <a href="{{ route('admin.post.edit', $post) }}"
                           class="btn btn-success d-block d-md-none w-full">
                          <i class="bx bx-pencil font-size-16"></i>
                        </a>
                      </div>
                      <div class="col-md-auto col-6 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.post.destroy', $post) }}"
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
