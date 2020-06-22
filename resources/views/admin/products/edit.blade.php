@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.0.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
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
        <h2>Товары</h2>
      </div>
    </div>
    @include('admin.layouts.menu_production')
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
          <form action="{{ route('admin.production.products.update', $product->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <label for="title">Наименование</label>
                <input type="text" class="form-control rounded-0" name="title" id="title" value="{{ $product->title }}">
              </div>
              <div class="col-12 ml-md-4 ml-2">
                <p class="font-smaller">Ссылка: <a href="{{ route('products.show', $product->id) }}" target="_blank" class="text-red" style="text-decoration: underline">{{ route('products.show', $product->id) }}</a></p>
              </div>

              <div class="col-md-8">
                <div class="row">
                  <div class="col-12">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $product->description }}</textarea>
                  </div>
                  <div class="col-12 col-md-6 mt-2">
                    <label for="category">Категории</label>
                    <select name="category[]" class="form-control rounded-0" multiple id="category">
                      @foreach($product->categories as $category)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12 col-md-6 mt-2">
                    <label for="brands">Бренды</label>
                    <select name="brands[]" class="form-control rounded-0" multiple id="brands">
                      @foreach($product->brands as $brand)
                        <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price">Цена</label>
                    <input type="number" min="0" name="price" class="form-control rounded-0" id="price" value="{{ $product->price }}">
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price_sale">Цена со скидкой</label>
                    <input type="number" min="0" name="price_sale" class="form-control rounded-0" id="price_sale" value="{{ $product->price_sale }}">
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="stock">Запасы</label>
                    <input type="number" min="0" name="stock" class="form-control rounded-0" id="stock" value="{{ $product->skus->count() === 1 && $product->skus->first()->skus_id === null ? $product->skus->first()->stock : null }}" {{ $product->skus->count() > 1 || $product->skus->first() ? $product->skus->first()->skus_id !== null ? 'disabled' : null : null }}>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="weight">Вес товара (кг)</label>
                    <input type="number" min="0" name="weight" step="0.01" class="form-control rounded-0" id="weight" value="{{ $product->weight }}">
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-11 offset-md-1 mt-4">
                    <label>
                      <input type="checkbox" name="on_new" id="new" {{ $product->on_new ? 'checked' : null }}>
                      NEW
                    </label>

                    <label class="ml-3">
                      <input type="checkbox" name="on_sale" id="sale" {{ $product->on_sale ? 'checked' : null }}>
                      SALE
                    </label>
                  </div>
                  <div class="col-md-11 offset-md-1 mt-4">
                    <h4 class="font-weight-bold">Атрибуты</h4>
                    <div class="row">
                      <div class="col-12">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="customSwitch" {{ $product->skus->count() >= 1 &&  $product->skus->first()->skus_id !== null ? 'checked' : null }}>
                          <label class="custom-control-label" for="customSwitch">Размеры</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="row">

                          <? $ch = $product->skus->count() >= 1 &&  $product->skus->first()->skus_id !== null ? null : 'disabled'; ?>
                          <div class="accordion col-12" id="sc">
                            @foreach(App\Models\SkusCategory::all() as $sc)
                              <div class="card">
                                <div class="card-header" id="heading-{{ $sc->id }}">
                                  <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{$sc->id}}" aria-expanded="true" aria-controls="collapse-{{$sc->id}}">
                                      {{ $sc->name }}
                                    </button>
                                  </h5>
                                </div>
                                <div id="collapse-{{$sc->id}}" class="collapse" aria-labelledby="heading-{{ $sc->id }}" data-parent="#sc">
                                  <div class="card-body">
                                    <div class="row">
                                      @foreach($sc->skuses as $sku)
                                        <div class="col-12">
                                          <div class="row mt-2">
                                            <label for="skus[{{ $sku->id }}]" class="col-12">{{ $sku->title }}</label>
                                            <input type="number" min="0" class="form-control col-12 skus rounded-0" id="skus-{{ $sku->id }}" name="skus[{{ $sku->id }}]" {{ $ch }} value="{{ $product->skus()->where('skus_id', $sku->id)->first() ? $product->skus()->where('skus_id', $sku->id)->first()->stock : null }}">
                                          </div>
                                        </div>
                                      @endforeach
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row mt-3">
            <div class="col-md-8">
              <form id="upload-widget" method="post" action="{{route('admin.production.products.photo', $product->id)}}" class="dropzone"></form>
            </div>
          </div>
          <div class="row mt-3 justify-content-end">
            <div class="col-auto">
              <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src='https://cdn.tiny.cloud/1/z826n1n5ayf774zeqdphsta5v2rflavdm2kvy7xtmczyokv3/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
  <script !src="">
    // let editor = new FroalaEditor('textarea')
    tinymce.init({
      selector: 'textarea'
    });

    $('#category').select2({
      width: '100%',
      ajax: {
        type: "POST",
        dataType: 'json',
        url: function (params) {
          return '{{ route('api.category', '') }}' + '/' + params.term;
        },
        processResults: function (data) {
          return {
            results: data.items.map((e) => {
              return {
                text: e.name,
                id: e.id
              };
            })
          };
        }
      }
    });

    $('#brands').select2({
      width: '100%',
      ajax: {
        type: "POST",
        dataType: 'json',
        url: function (params) {
          return '{{ route('api.brand', '') }}' + '/' + params.term;
        },
        processResults: function (data) {
          return {
            results: data.items.map((e) => {
              return {
                text: e.name,
                id: e.id
              };
            })
          };
        }
      }
    });

    Dropzone.autoDiscover = false;
    var i =0;
    var fileList = new Array;
    const uploader = new Dropzone('#upload-widget', {
      init: function() {

        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");

        this.on("success", function (file, serverFileName) {
          fileList[i] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": i};
          //console.log(fileList);
          i++;
        });
        this.on("removedfile", function(file) {
          var rmvFile = "";
          for(let f=0;f<fileList.length;f++){

            if(fileList[f].fileName == file.name)
            {
              rmvFile = fileList[f].serverFileName;
            }

          }

          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{route('admin.production.products.photoDelete', $product->id)}}", {
              name: rmvFile
            })
            .then(response => {
              console.log(response)
            })
          }
        });
      },
      paramName: 'file',
      maxFiles: 3,
      dictDefaultMessage: 'Drag an image here to upload, or click to select one',
      headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
      },
      acceptedFiles: 'image/*',
      url: "{{route('admin.production.products.photo', $product->id)}}",
      renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        return newName;
      },
      addRemoveLinks: true,
    });



    $(document).ready(function() {
      $('.select2-selection').css('border-radius','0px')
      $('.fr-toolbar').css('border-radius','0px')
      $('.second-toolbar').css('border-radius','0px')
      <? $i = 0;?>
      @foreach($product->photos as $photo)
      var mockFile = { name: '{{ $photo->name }}', size: 0 };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ asset('storage/products/') . '/' . $photo->name }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
      fileList.push({"serverFileName": '{{ $photo->name }}', "fileName":'{{ $photo->name }}', "fileId": {{ $i }}});
      <? $i++?>
      @endforeach

      $('#new').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
      });
      $('#sale').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
      });


      $('.custom-control-label').click(function(evt) {
        let ch = !$('#' + $(this).attr('for')).prop("checked");
        let id = $(this).attr('for').replace(/\D+/g,"");
        console.log(ch ? 1 : 0);
        if (!ch) {
          $('.skus').attr('disabled', true)
          $('#stock').attr('disabled', false)
          $('.skus').val('')
        } else {
          $('.skus').attr('disabled', false)
          $('#stock').attr('disabled', true)
          $('#stock').val('')
        }
      })
    });

  </script>
@endsection
