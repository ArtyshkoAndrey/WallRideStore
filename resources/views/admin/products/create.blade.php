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
          <form action="{{ route('admin.production.products.store') }}" method="post">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <label for="title">Наименование</label>
                <input type="text" class="form-control rounded-0" name="title" id="title">
              </div>
              <div class="col-12">

              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-12">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                  </div>
                  <div class="col-12 col-md-6 mt-2">
                    <label for="category">Категории</label>
                    <select name="category[]" class="form-control rounded-0" multiple id="category">
                    </select>
                  </div>
                  <div class="col-12 col-md-6 mt-2">
                    <label for="brands">Бренды</label>
                    <select name="brands[]" class="form-control rounded-0" multiple id="brands">
                    </select>
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price">Цена</label>
                    <input type="number" min="0" name="price" class="form-control rounded-0" id="price">
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price_sale">Цена со скидкой</label>
                    <input type="number" min="0" name="price_sale" class="form-control rounded-0" id="price_sale">
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="stock">Запасы</label>
                    <input type="number" min="0" name="stock" class="form-control rounded-0" id="stock">
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="weight">Вес товара (кг)</label>
                    <input type="number" min="0" name="weight" step="0.01" class="form-control rounded-0" id="weight" value="0">
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-11 offset-md-1 mt-4">
                    <label>
                      <input type="checkbox" name="on_new" id="new">
                      NEW
                    </label>

                    <label class="ml-3">
                      <input type="checkbox" name="on_sale" id="sale">
                      SALE
                    </label>
                  </div>
                  <div class="col-md-11 offset-md-1 mt-4">
                    <h4 class="font-weight-bold">Атрибуты</h4>
                    <div class="row">
                      <div class="col-12">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="customSwitch">
                          <label class="custom-control-label" for="customSwitch">Размеры</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="row">
                          <?php $ch = 'disabled'; ?>
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
                                        <input type="number" min="0" class="form-control col-12 skus" id="skus-{{ $sku->id }}" name="skus[{{ $sku->id }}]" {{ $ch }} value="">
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
                        <div class="row">
                          <div class="accordion col-12" id="pr">
                            <div class="card">
                              <div class="card-header" id="heading-pr">
                                <h5 class="mb-0">
                                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-pr" aria-expanded="true" aria-controls="collapse-pr-">
                                    Акции
                                  </button>
                                </h5>
                              </div>
                              <div id="collapse-pr" class="collapse" aria-labelledby="heading-pr" data-parent="#pr">
                                <div class="card-body">
                                  <div class="row">
                                    @foreach(App\Models\Promotion::all() as $pr)
                                      <div class="col-12">
                                        <div class="form-group form-check">
                                          <input type="checkbox" class="form-check-input" id="pr-{{$pr->id}}" name="promotions[]" value="{{ $pr->id }}">
                                          <label class="form-check-label" for="pr-{{$pr->id}}">{{ $pr->name}}</label>
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
                      <input type="hidden" name="photo[0]" value="">
                      <input type="hidden" name="photo[1]" value="">
                      <input type="hidden" name="photo[2]" value="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row mt-3">
            <div class="col-md-8">
              <form id="upload-widget" method="post" action="{{route('admin.production.products.photoCreate')}}" class="dropzone"></form>
            </div>
            <div class="col-12">
              <p class="small">Рекомендуем использовать раличные наименования файлов перед отправкой</p>
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
          fileList[i] = {"serverFileName": file.upload.filename, "fileName": file.name, "fileId": i};
          serverFileName = file.upload.filename;
          if ($('input[name="photo['+ i +']"]').val() === '') {
            $('input[name="photo[' + i + ']"]').val(serverFileName)
          } else {
            if (i === 2) {
              $('input[name="photo[1]"]').val() === '' ? $('input[name="photo[1]"]').val(serverFileName) : $('input[name="photo[0]"]').val() === '' ? $('input[name="photo[0]"]').val(serverFileName) : console.error('Error', i)
            } else if (i === 1) {
              $('input[name="photo[2]"]').val() === '' ? $('input[name="photo[2]"]').val(serverFileName) : $('input[name="photo[0]"]').val() === '' ? $('input[name="photo[0]"]').val(serverFileName) : console.error('Error', i)
            } else if (i === 0) {
              $('input[name="photo[1]"]').val() === '' ? $('input[name="photo[1]"]').val(serverFileName) : $('input[name="photo[2]"]').val() === '' ? $('input[name="photo[2]"]').val(serverFileName) : console.error('Error', i)
            }

          }

          i++;
        });
        this.on("removedfile", function(file) {
          var rmvFile = "";
          for(let f=0;f<fileList.length;f++){

            if(fileList[f].fileName == file.name)
            {
              rmvFile = fileList[f].serverFileName;
              fileList.splice(f, 1);
              i = fileList.length;
              $('input[value="'+ rmvFile +'"]').val(null)
              break;
            }

          }
          console.log(fileList)

          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{route('admin.production.products.photoDeleteCreate')}}", {
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
      url: "{{route('admin.production.products.photoCreate')}}",
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
