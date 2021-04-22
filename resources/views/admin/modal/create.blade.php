@extends('admin.layouts.app')

@section('title', 'Создание нового модального окна')

@section('css')

@endsection

@section('content')

  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.modal.index') }}">Модальные окна</a></li>
            <li class="breadcrumb-item active">Создание нового модального окна</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Создание нового модального окна</h3>
      </div>
      @if ($errors->any())
        <div class="col-12">
          <div class="card bg-dark-dm">
            <div class="invalid-feedback">
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
        <form action="{{ route('admin.modal.store') }}" method="POST" class="w-full">
          @csrf
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">

              <div class="row">
                <div class="col-12">
                  <div class="card bg-dark-dm m-0">

                    <div class="wrapper-tabs">
                      <div class="tabs d-inline-flex w-full">
                        <button class="btn shadow-none align-items-center d-flex active" data-tabs-content-id="russian" type="button"><img src="{{ asset('images/flags/ru-flag.png') }}"  height="25px" class="w-auto" alt=""></button>

                        <button class="btn shadow-none align-items-center d-flex" data-tabs-content-id="english" type="button"><img src="{{ asset('images/flags/en-flag.png') }}" height="25px" class="w-auto" alt=""></button>
                      </div>

                      <div class="tabs-content active" id="russian">

                        <div class="form-group">
                          <label for="title" class="required">Заголовок</label>
                          <input type="text" class="form-control" name="ru[title]" id="title" placeholder="Название" value="{{ old('ru.title') }}" required>
                        </div>

                        <div class="form-group">
                          <label for="ru_description">Описание</label>
                          <textarea class="form-control" name="ru[description]" id="ru_description" cols="30" rows="20">{{ old('ru.description') }}</textarea>
                        </div>

                        <div class="form-group">
                          <label for="ru_text_to_link">Текст на кнопке</label>
                          <input type="text" class="form-control" name="ru[text_to_link]" id="ru_text_to_link" placeholder="Текст на кнопке" value="{{ old('ru.text_to_link') }}">
                        </div>

                      </div>

                      <div class="tabs-content" id="english">

                        <div class="form-group">
                          <label for="title" class="required">Заголовок</label>
                          <input type="text" class="form-control" name="en[title]" id="title" placeholder="Название" value="{{ old('en.title') }}" required>
                        </div>

                        <div class="form-group">
                          <label for="en_description">Описание</label>
                          <textarea class="form-control" name="en[description]" id="en_description" cols="30" rows="20">{{ old('en.description') }}</textarea>
                        </div>

                        <div class="form-group">
                          <label for="en_text_to_link">Текст на кнопке</label>
                          <input type="text" class="form-control" name="en[text_to_link]" id="en_text_to_link" placeholder="Текст на кнопке" value="{{ old('en.text_to_link') }}">
                        </div>

                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row mt-20">
                <div class="col-12">
                  <div class="card bg-dark-dm m-0">

                    <div class="form-group">
                      <label for="link">Ссылка на кнопке</label>
                      <input type="text" class="form-control" name="link" id="link" placeholder="Ссылка на кнопке" value="{{ old('link') }}">
                    </div>



                  </div>
                </div>
              </div>


            </div>

            <div class="col-lg-4 col-12 mt-10">
              <div class="card bg-dark-dm">

               <div class="row">
                 <div class="col-12">
                   <div class="custom-switch d-inline-block">
                     <input type="hidden" name="on_auth" value="0">
                     <input type="checkbox" name="on_auth" id="on_auth" value="1" {{ old('on_auth') ? 'checked' : null }}>
                     <label for="on_auth">Для зарегестрированых пользователей</label>
                   </div>
                 </div>


                 <div class="col-12 mt-10">
                   <div class="custom-switch d-inline-block">
                     <input type="hidden" name="status" value="0">
                     <input type="checkbox" name="status" id="status" value="1" {{ old('status') ? 'checked' : null }}>
                     <label for="status">Выкл/Вкл.</label>
                   </div>
                 </div>
               </div>


              </div>
            </div>

            <div class="col-lg-8 col-12 mt-10">
              <div class="card bg-dark-dm">
                <div class="row">
                  <div class="col-12" id="checker_images">

                    <ul class="row">
                      <li class="col-md-12 col-lg-6 col-xl-4 col-12">
                        <input type="radio" name="type" value="1" id="cb1" {{ old('type') === 1 || old('type') === null ? 'checked' : '' }}/>
                        <label for="cb1"><img src="{{ asset('images/modals/modal_1.png') }}" alt=""/></label>
                      </li>
                      <li class="col-md-12 col-lg-6 col-xl-4 col-12">
                        <input type="radio" name="type" value="2" id="cb2" {{ old('type') === 2 ? 'checked' : '' }} />
                        <label for="cb2"><img src="{{ asset('images/modals/modal_2.png') }}" alt=""/></label>
                      </li>
                      <li class="col-md-12 col-lg-6 col-xl-4 col-12">
                        <input type="radio" name="type" value="3" id="cb3" {{ old('type') === 3 ? 'checked' : '' }} />
                        <label for="cb3"><img src="{{ asset('images/modals/modal_3.png') }}" alt=""/></label>
                      </li>
                      <li class="col-md-12 col-lg-6 col-xl-4 col-12">
                        <input type="radio" name="type" value="4" id="cb4" {{ old('type') === 4 ? 'checked' : '' }} />
                        <label for="cb4"><img src="{{ asset('images/modals/modal_4.png') }}" alt=""/></label>
                      </li>
                    </ul>

                  </div>
                </div>
              </div>
            </div>


            <div class="col-12 mt-20">
              <div class="card bg-dark-dm">
                <div id="upload-widget" class="dropzone"></div>
              </div>
            </div>

            <div class="col-12 mt-10 text-right">
              <button class="btn bg-success">Сохранить</button>
            </div>
          </div>

          @if(old('image'))
            <input type="hidden" name="image" id="{{ old('image') }}" value="{{ old('image') }}">
          @endif
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
    tinymce.init({
      selector: 'textarea#ru_description',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
    });

    tinymce.init({
      selector: 'textarea#en_description',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
    });


    Dropzone.autoDiscover = false;
    let fileList = [];

    const uploader = new Dropzone('#upload-widget', {
      init: function() {
        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");
        this.on("success", function (file, serverFileName) {
          fileList[0] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": 0};
          $('form').append('<input type="hidden" name="image" id="' + serverFileName + '" value="' + serverFileName + '">')
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
            axios.post("{{ route('admin.modal.photo.delete') }}", {
              name: rmvFile,
              type: 'desktop',
            })
              .then(response => {
                console.log(response)
                $('input[name="image"]').remove();
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
      url: "{{ route('admin.modal.photo.store') }}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
      dictRemoveFile: 'Удалить файл'
    });


    $(document).ready(function() {
      let mockFile
      @if (old('photo'))
        mockFile = { name: '{{ old('photo') }}', size: {{ File::size(public_path(\App\Models\Modal::PHOTO_PATH . old('photo') . '.jpg')) }} };
        uploader.emit("addedfile", mockFile);
        uploader.emit("thumbnail", mockFile, '{{ asset(\App\Models\Modal::PHOTO_PATH . old('photo') . '.jpg') }}');
        uploader.emit("complete", mockFile);
        uploader.files.push(mockFile)
        fileList.push({"serverFileName": '{{ old('photo') }}', "fileName":'{{ old('photo') }}', "fileId": 1});
      @endif
    });
  </script>
@endsection
