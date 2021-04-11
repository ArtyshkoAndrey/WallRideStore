@extends('admin.layouts.app')

@section('title', 'Создание новой FAQ')

@section('css')

@endsection

@section('content')

  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('admin.notification.index') }}">Уведомления по почте</a>
            </li>
            <li class="breadcrumb-item active">Рассылка</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Рассылка</h3>
      </div>
      @if ($errors->any())
        <div class="col-12">
          <div class="card bg-dark-dm">
            <div class="invalid-feedback d-block">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endif
      <div class="col-12 p-0">
        <form action="{{ route('admin.notification.store') }}" enctype="multipart/form-data" method="POST" class="w-full">
          @csrf
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="row row-eq-spacing-sm m-0 p-0">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="title" class="required">Заголовок</label>
                      <input type="text" class="form-control" name="title" id="title" placeholder="Заголовок" value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                      <label for="content" class="required">Контент</label>
                      <textarea class="form-control" name="content" id="content" cols="30" rows="20">{{ old('content') }}</textarea>
                    </div>

                    <div class="custom-file">
                      <input type="file" id="image" name="image" accept=".jpg,.png">
                      <label for="image">Выбирете главную картинке</label>
                    </div>
                  </div>

                  <div class="col-12 mt-20 justify-content-end d-flex">
                    <button type="submit" class="btn btn-success">Создать</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
@endsection

@section('script')

  <script src="https://cdn.tiny.cloud/1/z826n1n5ayf774zeqdphsta5v2rflavdm2kvy7xtmczyokv3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    let useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;


    $(document).ready(() => {
      tinymce.init({
        selector: 'textarea#content',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
      });
    })
  </script>
@endsection
