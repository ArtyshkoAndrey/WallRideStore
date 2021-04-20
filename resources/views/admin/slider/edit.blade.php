@extends('admin.layouts.app')

@section('title', 'Редактирование слайда')

@section('css')

@endsection

@section('content')

  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('admin.slider.index') }}">Слайдер</a>
            </li>
            <li class="breadcrumb-item active">Редактирование слайда</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Редактирование слайда</h3>
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
        <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" class="w-full">
          @csrf
          @method('PUT')
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="row row-eq-spacing-sm m-0 p-0">
                  <div class="col-12">
                    <div class="wrapper-tabs">
                      <div class="tabs d-inline-flex w-full">
                        <button class="btn shadow-none align-items-center d-flex active" data-tabs-content-id="russian" type="button"><img src="{{ asset('images/flags/ru-flag.png') }}"  height="25px" class="w-auto" alt=""></button>

                        <button class="btn shadow-none align-items-center d-flex" data-tabs-content-id="english" type="button"><img src="{{ asset('images/flags/en-flag.png') }}" height="25px" class="w-auto" alt=""></button>
                      </div>

                      <div class="tabs-content active" id="russian">

                        <div class="form-group">
                          <label for="ru_h1" class="required">Заголовок</label>
                          <input type="text" class="form-control" name="ru[h1]" id="ru_h1" placeholder="Заголовок" value="{{ old('ru.h1', $slider->{'h1:ru'}) }}" required>
                        </div>

                        <div class="form-group">
                          <label for="ru_h2" class="required">Подзаголовок</label>
                          <input type="text" class="form-control" name="ru[h2]" id="ru_h2" placeholder="Подзаголовок" value="{{ old('ru.h2', $slider->{'h2:ru'}) }}" required>
                        </div>

                        <div class="form-group">
                          <label for="ru_btn_text" class="required">Текст на кнопке</label>
                          <input type="text" class="form-control" name="ru[btn_text]" id="ru_btn_text" placeholder="Текст на кнопке" value="{{ old('ru.btn_text', $slider->{'btn_text:ru'}) }}" required>
                        </div>


                      </div>

                      <div class="tabs-content" id="english">

                        <div class="form-group">
                          <label for="en_h1" class="required">Заголовок</label>
                          <input type="text" class="form-control" name="en[h1]" id="en_h1" placeholder="Заголовок" value="{{ old('en.h1', $slider->{'h1:en'}) }}" required>
                        </div>

                        <div class="form-group">
                          <label for="en_h2" class="required">Подзаголовок</label>
                          <input type="text" class="form-control" name="en[h2]" id="en_h2" placeholder="Подзаголовок" value="{{ old('en.h2', $slider->{'h2:en'}) }}" required>
                        </div>

                        <div class="form-group">
                          <label for="en_btn_text" class="required">Текст на кнопке</label>
                          <input type="text" class="form-control" name="en[btn_text]" id="en_btn_text" placeholder="Текст на кнопке" value="{{ old('en.btn_text', $slider->{'btn_text:en'}) }}" required>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <hr>
                    <div class="form-group">
                      <label for="url" class="required">Ссылка на кнопке</label>
                      <input type="text" class="form-control" name="url" id="url" placeholder="Ссылка на кнопке" value="{{ old('url', $slider->url) }}" required>
                    </div>
                  </div>

                  <div class="col-12">
                    <p>Фотография</p>
                    <div id="upload-widget-photo" class="dropzone"></div>
                  </div>

                  @if(old('photo', $slider->photo))
                    <input type="hidden" name="photo" id="{{ old('photo', $slider->photo) }}" value="{{ old('photo', $slider->photo) }}">
                  @endif

                  <div class="col-12 mt-10">
                    <p>Мобильная фотография</p>
                    <div id="upload-widget-photo-mobile" class="dropzone"></div>
                  </div>

                  @if(old('mobile_photo', $slider->mobile_photo))
                    <input type="hidden" name="mobile_photo" id="{{ old('mobile_photo', $slider->mobile_photo) }}" value="{{ old('mobile_photo', $slider->mobile_photo) }}">
                  @endif

                  <div class="col-12 mt-20 justify-content-end d-flex">
                    <button type="submit" class="btn btn-success">Обновить</button>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>

  <script>
    let useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    Dropzone.autoDiscover = false;
    let fileList = [];

    const uploader = new Dropzone('#upload-widget-photo', {
      init: function() {
        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");
        this.on("success", function (file, serverFileName) {
          fileList[0] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": 0};
          $('form').append('<input type="hidden" name="photo" id="' + serverFileName + '" value="' + serverFileName + '">')
        });
        this.on("removedfile", function(file) {
          let rmvFile = "";
          for(let f=0;f<fileList.length;f++){
            if(fileList[f].fileName === file.name)
            {
              rmvFile = fileList[f].serverFileName;
            }
          }
          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{ route('admin.slider.photo.delete') }}", {
              name: rmvFile,
              type: 'desktop',
            })
              .then(response => {
                console.log(response)
                $('input[name="photo"]').remove();
              })
              .catch(response => {
                alert(response.data.status)
              })
          }
        });
      },
      paramName: 'file',
      dictDefaultMessage: 'Переместите фотографии или кликните на поле',
      headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
      },
      sending: function(file, xhr, formData){
        formData.append('type', 'desktop');
      },
      maxFiles: 1,
      acceptedFiles: 'image/*',
      url: "{{ route('admin.slider.photo.store') }}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
      dictRemoveFile: 'Удалить файл'
    });

    let fileListMobile = [];

    const uploaderMobile = new Dropzone('#upload-widget-photo-mobile', {
      init: function() {
        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");
        this.on("success", function (file, serverFileName) {
          fileListMobile[0] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": 0};
          $('form').append('<input type="hidden" name="mobile_photo" id="' + serverFileName + '" value="' + serverFileName + '">')
        });
        this.on("removedfile", function(file) {
          let rmvFile = "";
          for(let f=0;f<fileList.length;f++){
            if(fileList[f].fileName === file.name)
            {
              rmvFile = fileList[f].serverFileName;
            }
          }
          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{ route('admin.slider.photo.delete') }}", {
              name: rmvFile,
              type: 'mobile',
            })
              .then(response => {
                console.log(response)
                $('input[name="mobile_photo"]').remove();
              })
              .catch(response => {
                alert(response.data.status)
              })
          }
        });
      },
      paramName: 'file',
      dictDefaultMessage: 'Переместите фотографии или кликните на поле',
      headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
      },
      sending: function(file, xhr, formData){
        formData.append('type', 'mobile');
      },
      maxFiles: 1,
      acceptedFiles: 'image/*',
      url: "{{ route('admin.slider.photo.store') }}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
      dictRemoveFile: 'Удалить файл'
    });

    $(document).ready(() => {

      let mockFile
      @if (old('photo', $slider->photo))
        mockFile = { name: '{{ old('photo', $slider->photo) }}', size: {{ File::size(public_path(\App\Models\Slider::PHOTO_PATH . old('photo', $slider->photo) . '.jpg')) ?? 0 }} };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ asset(\App\Models\Slider::PHOTO_PATH . old('photo', $slider->photo) . '.jpg') }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
      fileList.push({"serverFileName": '{{ old('photo', $slider->photo) }}', "fileName":'{{ old('photo', $slider->photo) }}', "fileId": 1});
      @endif

        @if (old('mobile_photo', $slider->mobile_photo))
        mockFile = { name: '{{ old('mobile_photo', $slider->mobile_photo) }}', size: {{ File::size(public_path(\App\Models\Slider::PHOTO_PATH_MOBILE . old('mobile_photo', $slider->mobile_photo) . '.jpg')) ?? 0 }} };
      uploaderMobile.emit("addedfile", mockFile);
      uploaderMobile.emit("thumbnail", mockFile, '{{ asset(\App\Models\Slider::PHOTO_PATH_MOBILE . old('mobile_photo', $slider->mobile_photo) . '.jpg') }}');
      uploaderMobile.emit("complete", mockFile);
      uploaderMobile.files.push(mockFile)
      fileListMobile.push({"serverFileName": '{{ old('photo', $slider->mobile_photo) }}', "fileName":'{{ old('mobile_photo', $slider->mobile_photo) }}', "fileId": 1});
      @endif
    })
  </script>
@endsection
