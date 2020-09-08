@extends('admin.layouts.app')
@section('title', 'Магазин - Настройки')
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
        <h2>Настройки шапки телефонов</h2>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-body">
          <form action="{{ route('admin.header-mobile.update', $h->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="photo" value="{{ old('photo') ? old('photo') : $h->photo }}">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-8">
                    <label for="h1">Заголовок</label>
                    <input type="text" name="h1" id="h1" class="w-100 px-2 form-control rounded-0 {{ $errors->has('h1') ? ' is-invalid' : '' }}" value="{{ old('h1') ? old('h1') : $h->h1 }}" required>
                    <span id="h1-error" class="error invalid-feedback">{{ $errors->first('h1') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <label for="h2">Подзаголовок</label>
                    <input type="text" name="h2" id="h2" class="w-100 px-2 form-control rounded-0 {{ $errors->has('h2') ? ' is-invalid' : '' }}" value="{{ old('h2') ? old('h2') : $h->h2 }}" required>
                    <span id="h2-error" class="error invalid-feedback">{{ $errors->first('h2') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <label for="url">URL на кнопке</label>
                    <input type="text" name="url" id="url" class="w-100 px-2 form-control rounded-0 {{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{ old('url') ? old('url') : $h->url }}" required>
                    <span id="url-error" class="error invalid-feedback">{{ $errors->first('url') }}</span>
                    <span class="small">Не вписывать название домена. В начале ссылки вставлять ' / '</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <label for="btn_text">Текст на пноке</label>
                    <input type="text" name="btn_text" id="btn_text" class="w-100 px-2 form-control rounded-0 {{ $errors->has('btn_text') ? ' is-invalid' : '' }}" value="{{ old('btn_text') ? old('btn_text') : $h->btn_text }}" required>
                    <span id="btn_text-error" class="error invalid-feedback">{{ $errors->first('btn_text') }}</span>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row mt-3">
            <div class="col-md-8">
              <form id="upload-widget" method="post" action="{{route('admin.header-mobile.photoCreate')}}" class="dropzone"></form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>

  <script !src="">
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
          formData.append("id", "{{ $h->id }}");
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
            axios.post("{{route('admin.header-mobile.photoDelete')}}", {
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
      url: "{{route('admin.header-mobile.photoCreate')}}",
      renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        return newName;
      },
      addRemoveLinks: true,
    });

    @if(old('photo'))
      fileList = {"serverFileName": '{{ old('photo') }}', "fileName": '{{ old('photo') }}'};
      var mockFile = { name: '{{ old('photo') }}', size: 0 };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ asset('storage/header-mobile/') . '/' . old('photo') }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
    @elseif($h->photo)
      fileList = {"serverFileName": "{{ $h->photo }}", "fileName": "{{ $h->photo }}"};
      var mockFile = { name: '{{ $h->photo }}', size: 0 };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ asset('storage/header-mobile/') . '/' . $h->photo }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
    @endif
  </script>
@endsection
