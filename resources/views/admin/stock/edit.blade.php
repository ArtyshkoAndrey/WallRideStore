@extends('admin.layouts.app')
@section('title', 'Магазин - Акции')
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
    #checker_images ul {
      list-style-type: none;
    }

    #checker_images li {
      display: inline-block;
    }

    #checker_images input[type="radio"][id^="cb"] {
      display: none;
    }

    #checker_images label {
      border: 1px solid #fff;
      padding: 10px;
      display: block;
      position: relative;
      margin: 10px;
      cursor: pointer;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    #checker_images label::before {
      background-color: white;
      color: white;
      content: " ";
      display: block;
      border-radius: 50%;
      border: 1px solid grey;
      position: absolute;
      top: -5px;
      left: -5px;
      width: 25px;
      height: 25px;
      text-align: center;
      line-height: 28px;
      transition-duration: 0.4s;
      transform: scale(0);
    }

    #checker_images label img {
      height: 200px;
      width: auto;
      transition-duration: 0.2s;
      transform-origin: 50% 50%;
    }

    #checker_images :checked+label {
      border-color: #ddd;
    }

    #checker_images :checked+label::before {
      content: "✓";
      background-color: grey;
      transform: scale(1);
    }

    #checker_images :checked+label img {
      transform: scale(0.9);
      box-shadow: 0 0 5px #333;
      z-index: -1;
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Акции</h2>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ url()->previous() }}" class="h4 d-flex align-content-center"><i class="fal fa-long-arrow-left mr-2"></i> Назад</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.store.stock.update', $st->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="image" value="{{ old('image') ? old('image') : $st->image }}">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-8">
                    <label for="title">Заголовок*</label>
                    <input type="text" name="title" id="title" class="w-100 px-2 form-control rounded-0 {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') ? old('title') : $st->title }}" required>
                    <span id="name-error" class="error invalid-feedback">{{ $errors->first('title') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <label for="description">Описание</label>
                    <input name="description" id="description" class="w-100 px-2 form-control rounded-0 {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') ? old('description') : $st->description }}">
                    <span id="descriptio-error" class="error invalid-feedback">{{ $errors->first('descriptio') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label for="link">Ссылка</label>
                    <input name="link" id="link" class="w-100 px-2 form-control rounded-0 {{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ old('link') ? old('link') : $st->link }}">
                    <span id="link-error" class="error invalid-feedback">{{ $errors->first('link') }}</span>
                    <small class="form-text text-muted">"/notification/subscribe/auth" - для подписки на рассылку</small>
                  </div>
                  <div class="col-md-4">
                    <label for="text_to_link">Текст ссылки</label>
                    <input name="text_to_link" id="text_to_link" class="w-100 px-2 form-control rounded-0 {{ $errors->has('text_to_link') ? ' is-invalid' : '' }}" value="{{ old('text_to_link') ? old('text_to_link') : $st->text_to_link }}">
                    <span id="text_to_link-error" class="error invalid-feedback">{{ $errors->first('text_to_link') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label for="delay">Промежуток показа (секунды, если для зарегестрированых)</label>

                    <input name="delay" id="delay" type="number" class="w-100 px-2 form-control rounded-0 {{ $errors->has('delay') ? ' is-invalid' : '' }}" value="{{ old('delay', $st->delay) }}">
                    <span id="delay-error" class="error invalid-feedback">{{ $errors->first('delay') }}</span>
                  </div>

                  <div class="col-md-12 mt-2 mb-2">
                    <input name="on_auth" type="checkbox" id="on_auth" class="p-5 rounded-0 {{ $errors->has('on_auth') ? ' is-invalid' : '' }}" @if(old('on_auth', $st->on_auth)) checked @endif>
                    <label for="on_auth">Только для зарегестрированных пользователей</label>
                    <span id="on_auth-error" class="error invalid-feedback">{{ $errors->first('on_auth') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8" id="checker_images">

                    <ul>
                      <li><input type="radio" name="view" value="1" id="cb1" {{ old('view') === 1 ? 'checked' :  $st->view === 1 ? 'checked' : ''  }}/>
                        <label for="cb1"><img src="{{ asset('images/modal_1.png') }}" /></label>
                      </li>
                      <li><input type="radio" name="view" value="2" id="cb2" {{ old('view') === 2 ? 'checked' :  $st->view === 2 ? 'checked' : ''  }} />
                        <label for="cb2"><img src="{{ asset('images/modal_2.png') }}" /></label>
                      </li>
                      <li><input type="radio" name="view" value="3" id="cb3" {{ old('view') === 3 ? 'checked' :  $st->view === 3 ? 'checked' : ''  }} />
                        <label for="cb3"><img src="{{ asset('images/modal_3.png') }}" /></label>
                      </li>
                    </ul>

                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row mt-3">
            <div class="col-md-8">
              <form id="upload-widget" method="post" action="{{route('admin.store.stock.photoCreate')}}" class="dropzone"></form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>

  <script>

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
          formData.append("id", "{{ $st->id }}");
        });

        this.on("success", function (file, serverFileName) {
          fileList = {"serverFileName": file.upload.filename, "fileName": file.name};
          serverFileName = file.upload.filename;
          $('input[name="image"]').val(serverFileName)
        });
        this.on("removedfile", function(file) {
          var rmvFile = fileList.serverFileName;
          $('input[name="image"]').val(null)
          console.log(123)
          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{route('admin.store.stock.photoDelete')}}", {
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
      url: "{{route('admin.store.stock.photoCreate')}}",
      renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        return newName;
      },
      addRemoveLinks: true,
    });

    @if(old('image'))
      fileList = {"serverFileName": '{{ old('image') }}', "fileName": '{{ old('image') }}'};
      let mockFile = { name: '{{ old('image') }}', size: 0 };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ asset('storage/stocks/') . '/' . old('image') }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
    @elseif($st->image)
      fileList = {"serverFileName": "{{ $st->image }}", "fileName": "{{ $st->image }}"};
      let mockFile = { name: '{{ $st->image }}', size: 0 };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ asset('storage/stocks/') . '/' . $st->image }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
    @endif
  </script>
@endsection
