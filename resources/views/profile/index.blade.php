@extends('layouts.app')
@section('title', 'Личный профиль')

@section('content')
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show position-absolute d-table" style="right:0; z-index: 1000" role="alert">
      <button type="button" class="close mt-2" data-dismiss="alert">×</button>
      <h5 class="mt-2"><strong>{{ session('status') }}</strong></h5>
    </div>
  @endif
  <section class="container py-5" id="profile">
    <div class="card px-0">
      <div class="card-body px-0 py-0">
        <div class="row">
          <div class="col-md-3">
            <div class="nav flex-column nav-pills h-100" role="tablist" aria-orientation="vertical">
              <a class="nav-link active border-0" href="{{ route('profile.index') }}" aria-selected="true"><i class="fal fa-user pr-1"></i> Мой профиль</a>
              <a class="nav-link border-0" href="{{ route('orders.index') }}" aria-selected="true"><i class="fal fa-tasks pr-1"></i> Мои заказы</a>
            </div>
          </div>
          <div class="col-md-9">
            <div class="row">
              <div class="col-12">
                <h3 class="font-weight-bold">Мой профиль</h3>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-3">
                <img src="{{ isset(auth()->user()->avatar) ? asset('storage/avatar/thumbnail/'.auth()->user()->avatar) : asset('public/images/person.png') }}" class="img-fluid w-100 px-4 px-md-0" alt="{{ auth()->user()->name }}">
                <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST" id="form-photo" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <input type="file" id="photo" name="photo" size="chars" accept="image/jpeg,image/png" style="visibility: hidden">
                  <input type="hidden" value="photo" name="metadata">
                  <button type="button" class="btn btn-dark position-absolute" id="add-photo">
                    <i class="fal fa-camera"></i>
                  </button>
                </form>
              </div>
              <div class="col-md-9 pl-md-5 pl-0 px-3 mt-4 mt-md-0">
                <h4 class="font-weight-bold">{{ auth()->user()->name }}</h4>

                @if($address !== null)
                  @if($address->full_address)
                    <p class="font-weight-light mb-0">{{ $address->full_address }}</p>
                  @else
                    <p class="font-weight-light mb-0">Адреса нет</p>
                  @endif
                  @if($address->currency !== null)
                    <p class="font-weight-light mb-0">Валюта: {{ $address->currency->name }}</p>
                  @else
                    <p class="font-weight-light mb-0">Валюта не выбрана</p>
                  @endif
                  @if($address->contact_phone !== null)
                    <p class="font-weight-light mb-0">{{ $address->contact_phone }}</p>
                  @else
                    <p class="font-weight-light mb-0">Нет номера телефона</p>
                  @endif
                @else
                  <p class="font-weight-light mb-0">Адреса нет</p>
                  <p class="font-weight-light mb-0">Валюта не выбрана</p>
                  <p class="font-weight-light mb-0">Нет номера телефона</p>
                @endif
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4 px-3 px-md-2">
                <div class="row">
                  <div class="col-12">
                    <h4 class="font-weight-bold">Сменить пароль</h4>
                  </div>
                  <div class="col-12">
                    <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <input type="hidden" value="password" name="metadata">
                      <input type="password" name="password" class="form-control mb-4" placeholder="Новый пароль">
                      <input type="password" name="password_confirmation" class="form-control mb-4" placeholder="Повторите пароль">
                      <button type="submit" class="btn btn-dark m-0">Сохранить</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-8 px-3 px-md-2 mt-4 mt-md-0">
                <div class="row">
                  <div class="col-12">
                    <h4 class="font-weight-bold">Настройки профиля</h4>
                  </div>
                  <div class="col-12">
                    <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <input type="hidden" value="address" name="metadata">
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <input type="text" name="name" class="form-control mb-4" placeholder="Имя" value="{{ old('name', auth()->user()->name) }}" required>
                          @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12">
                          <input type="text" class="form-control mb-4" name="contact_phone" placeholder="Номер телефона" value="{{ old('contact_phone', $address ? $address->contact_phone ? $address->contact_phone : null : null) }}" required>
                          @if ($errors->has('contact_phone'))
                            <span class="text-danger">{{ $errors->first('contact_phone') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12">
                          <input type="email" class="form-control mb-4" name="email" placeholder="Email" value="{{ old('email', auth()->user()->email) }}" required>
                          @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12">
                          <select class="form-control mb-4" name="currency" placeholder="Валюта">
                            @foreach($currencies as $currencyProfile)
                              @if($address && $address->currency->id == $currencyProfile->id)
                                <option selected value="{{ $currencyProfile->id }}">{{ $currencyProfile->name }}</option>
                              @else
                                <option  value="{{ $currencyProfile->id }}">{{ $currencyProfile->name }}</option>
                              @endif
                            @endforeach
                          </select>
                          @if ($errors->has('currency'))
                            <span class="text-danger">{{ $errors->first('currency') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12">
                          <select id="mySelect3" name="country" class="w-100 h-100 form-control">
                            <option value="{{ $address->country->id }}" selected>{{ $address->country->name }}</option>
                          </select>
                          @if ($errors->has('country'))
                            <span class="text-danger">{{ $errors->first('country') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12 mb-4">
{{--                          <input type="text" class="form-control mb-4" name="city" placeholder="Город" value="{{ old('city', $address ? $address->city? $address->city : null : null) }}" required>--}}
{{--                          @if ($errors->has('city'))--}}
{{--                            <span class="text-danger">{{ $errors->first('city') }}</span>--}}
{{--                          @endif--}}
                          <select id="mySelect2" name="city" class="w-100 h-100 form-control">
                            <option value="{{ $address->city->id }}" selected>{{ $address->city->name }}</option>
                          </select>
                        </div>
                        <div class="col-12">
                          <input type="text" class="form-control mb-0" name="street" placeholder="Улица, индекс" value="{{ old('country', $address ? $address->street ? $address->street : null : null) }}" required>
                          <small class="form-text text-muted">Пример: ул. Ленина, 111 кв. 666, 143080 (индекс)</small>
                          @if ($errors->has('street'))
                            <span class="text-danger">{{ $errors->first('street') }}</span>
                          @endif
                        </div>
                      </div>
                      <button type="submit" class="btn btn-dark m-0">Сохранить</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')
  <script>
    $(document).ready(function() {
      $('#mySelect2').select2({
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.city', '') }}' + '/' + params.term;
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

      $('#mySelect3').select2({
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.country', '') }}' + '/' + params.term;
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
      $('#add-photo').click(() => {
        $('#photo').click();
      });
      $("#photo").change(() => {
        swal({
          title: "Вы уверены?",
          text: "Данные действие обновит фотографию профиля!",
          icon: "warning",
          buttons: {
            success: "Да, обноить!",
            cancle: {
              text: "Нет!",
              value: "cancle",
              className: "btn-danger"
            }
          },
          dangerMode: true,
        })
          .then((answer) => {
            switch (answer) {
              case "success":
                swal("Фотография обновлена!", 'success');
                $('#form-photo').submit()
                break;
              case "cancle":
                swal("Действик отменено");
                break;
              default:
                swal("Действик отменено");
            }
          })
      });
    });
  </script>
@endsection
