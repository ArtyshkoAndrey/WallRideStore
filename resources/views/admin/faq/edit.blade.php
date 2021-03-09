@extends('admin.layouts.app')

@section('title', 'Редактирование FAQ')

@section('css')

@endsection

@section('content')

  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('admin.faq.index') }}">FAQ</a>
            </li>
            <li class="breadcrumb-item active">Редактирование FAQ</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Редактирование FAQ</h3>
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
        <form action="{{ route('admin.faq.update', $faq) }}" method="POST" class="w-full">
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
                          <label for="ru_title" class="required">Название</label>
                          <input type="text" class="form-control" name="ru[title]" id="ru_title" placeholder="Название" value="{{ old('ru.title', $faq->{'title:ru'}) }}" required>
                        </div>

                        <div class="form-group">
                          <label for="ru_content" class="required">Контент</label>
                          <textarea class="form-control" name="ru[content]" id="ru_content" cols="30" rows="20">{{ old('ru.content', $faq->{'content:ru'}) }}</textarea>
                        </div>

                      </div>

                      <div class="tabs-content" id="english">

                        <div class="form-group">
                          <label for="en_title" class="required">Название</label>
                          <input type="text" class="form-control" name="en[title]" id="en_title" placeholder="Название" value="{{ old('en.title', $faq->{'title:en'}) }}" required>
                        </div>

                        <div class="form-group">
                          <label for="en_content" class="required">Контент</label>
                          <textarea class="form-control h-100" name="en[content]" id="en_content" cols="30" rows="30">{{ old('en.content', $faq->{'content:en'}) }}</textarea>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-12 mt-20">
                    <div id="upload-widget" class="dropzone"></div>
                  </div>
                  @if($image = old('image', $faq->image))
                    @if(File::exists(public_path(\App\Models\Faqs::PHOTO_PATH . $image . '.jpg')))
                      <input type="hidden" name="image" id="{{ $image }}" value="{{ $image }}">
                    @endif
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
            axios.post("{{ route('admin.faq.photo.delete') }}", {
              name: rmvFile
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
      maxFiles: 1,
      acceptedFiles: 'image/*',
      url: "{{ route('admin.faq.photo.store') }}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
      dictRemoveFile: 'Удалить файл'
    });

    $(document).ready(() => {
      tinymce.init({
        selector: 'textarea',
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons paste',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        paste_text_sticky: true,
        paste_text_sticky_default: true,
        setup: function (editor) {
          editor.on('init change', function () {
            editor.save();
          });
        },
        images_upload_url: '{{ route('admin.faq.content-image') }}',
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
          let input = document.createElement('input');
          input.setAttribute('type', 'file');
          input.setAttribute('accept', 'image/*');
          input.onchange = function() {
            let file = this.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
              let id = 'blobid' + (new Date()).getTime();
              let blobCache =  tinymce.activeEditor.editorUpload.blobCache;
              let base64 = reader.result.split(',')[1];
              let blobInfo = blobCache.create(id, file, base64);
              blobCache.add(blobInfo);
              cb(blobInfo.blobUri(), { title: file.name });
            };
          };
          input.click();
        }
      });

      let mockFile
      @if ($image = old('image', $faq->image))
        @if(File::exists(public_path(\App\Models\Faqs::PHOTO_PATH . $image . '.jpg')))
          mockFile = { name: '{{ $image }}', size: {{ File::size(public_path(\App\Models\Faqs::PHOTO_PATH . $image . '.jpg')) }} };
          uploader.emit("addedfile", mockFile);
          uploader.emit("thumbnail", mockFile, '{{ asset(\App\Models\Faqs::PHOTO_PATH . $image . '.jpg') }}');
          uploader.emit("complete", mockFile);
          uploader.files.push(mockFile)
          fileList.push({"serverFileName": '{{ $image }}', "fileName":'{{ $image }}', "fileId": 1});
        @endif
      @endif
    })
  </script>
@endsection
