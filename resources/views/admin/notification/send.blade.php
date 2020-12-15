@extends('admin.layouts.app')
@section('title', 'Магазин - Уведомления пользователей')
@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
  <style>
    .dz-image > img {
      width: 100%;
      height: auto;
    }
    .dropzone {
      background: white;
      border-radius: 5px;
      border: 2px dashed rgb(0, 135, 247);
      border-image: none;
      max-width: 100%;
      margin-left: auto;
      margin-right: auto;
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Уведомления</h2>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-body">
          <form action="{{ route('admin.notification.create') }}" method="post">
            @csrf
            <input type="hidden" name="photo" value="{{ old('photo') ? old('photo') : null}}">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-8">
                    <label for="text">Заголовок сообщения</label>
                    <input type="text" name="header" id="header" class="w-100 px-2 form-control rounded-0 {{ $errors->has('header') ? ' is-invalid' : '' }}" value="{{ old('header') }}" required>
                    <span id="header-error" class="error invalid-feedback">{{ $errors->first('header') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <label for="text">Основной текст</label>
                    <textarea name="text" id="text" class="w-100 px-2 form-control rounded-0 {{ $errors->has('text') ? ' is-invalid' : '' }}">{{ old('text') }}</textarea>
                    <span id="text-error" class="error invalid-feedback">{{ $errors->first('text') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <label for="url">URL на кнопке</label>
                    <input type="text" name="url" id="url" class="w-100 px-2 form-control rounded-0 {{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{ old('url') ? old('url') : '' }}">
                    <span id="url-error" class="error invalid-feedback">{{ $errors->first('url') }}</span>
                    <span class="small">Не вписывать название домена. В начале ссылки вставлять ' / '</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <label for="btn_text">Текст на кнопке</label>
                    <input type="text" name="btn_text" id="btn_text" class="w-100 px-2 form-control rounded-0 {{ $errors->has('btn_text') ? ' is-invalid' : '' }}" value="{{ old('btn_text') ? old('btn_text') : '' }}">
                    <span id="btn_text-error" class="error invalid-feedback">{{ $errors->first('btn_text') }}</span>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row mt-3">
            <div class="col-md-8">
              <form id="upload-widget" method="post" action="{{route('admin.notification.photoCreate')}}" class="dropzone"></form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
  <script src='https://cdn.tiny.cloud/1/z826n1n5ayf774zeqdphsta5v2rflavdm2kvy7xtmczyokv3/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script !src="">
    tinymce.init({
      selector: 'textarea',
      plugins : "paste",
      paste_text_sticky: true,
      paste_text_sticky_default: true
    });
    Dropzone.autoDiscover = false;
    var fileList = {};
    const uploader = new Dropzone('#upload-widget', {
      maxFiles: 1,
      init: function() {

        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");
        this.on("addedfile", function(event) {
          while (this.files.length > this.options.maxFiles) {
            this.removeFile(this.files[0]);
          }
        });

        this.on("sending", function(file, xhr, formData){
          formData.append("id", "null");
        });

        this.on("success", function (file, serverFileName) {
          fileList = {"serverFileName": file.upload.filename, "fileName": file.name};
          serverFileName = file.upload.filename;
          $('input[name="photo"]').val(serverFileName)
        });
        this.on("removedfile", function(file) {
          var rmvFile = fileList.serverFileName;
          $('input[name="photo"]').val(null)
          console.log(123)
          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{route('admin.notification.photoDelete')}}", {
              name: rmvFile,
            })
              .then(response => {
                console.log(response)
              })
          }
        });
      },
      paramName: 'file',
      dictDefaultMessage: 'Drag an image here to upload, or click to select one',
      headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
      },
      acceptedFiles: 'image/*',
      url: "{{route('admin.notification.photoCreate')}}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
    });

    @if(old('photo'))
      fileList = {"serverFileName": '{{ old('photo') }}', "fileName": '{{ old('photo') }}'};
    var mockFile = { name: '{{ old('photo') }}', size: 0 };
    uploader.emit("addedfile", mockFile);
    uploader.emit("thumbnail", mockFile, '{{ asset('storage/email/') . '/' . old('photo') }}');
    uploader.emit("complete", mockFile);
    uploader.files.push(mockFile)
    @endif
  </script>
@endsection
