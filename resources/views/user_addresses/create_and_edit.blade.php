@extends('layouts.app')
@section('title', ($address->id ? 'Изменить': 'Новый') . 'адрес доставки')

@section('content')
<div class="row">
  <div class="col-md-10 offset-lg-1">
    <div class="card">
      <div class="card-header">
        <h2 class="text-center">
          {{ $address->id ? 'Изменить': 'Новый' }} адрес доставки
        </h2>
      </div>
      <div class="card-body">
        <!-- Ошибка выходного бэкенда -->
        @if (count($errors) > 0)
          <div class="alert alert-danger">
            <h4>Произошла ошибка：</h4>
            <ul>
              @foreach ($errors->all() as $error)
                <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <!-- Ошибка конца выходного сервера -->
        <!-- встроенный шаблон для введения встроенных компонентов -->
        <user-addresses-create-and-edit inline-template>
          @if($address->id)
            <form class="form-horizontal" role="form" action="{{ route('user_addresses.update', ['user_address' => $address->id]) }}" method="post">
              {{ method_field('PUT') }}
          @else
            <form class="form-horizontal" role="form" action="{{ route('user_addresses.store') }}" method="post">
          @endif
          {{ csrf_field() }}
          <!-- Обратите внимание, что здесь больше @change -->
            <select-district :init-value="{{ json_encode([$address->province, $address->city, $address->district]) }}" @change="onDistrictChanged" inline-template>
              <div class="form-group row">
                <label class="col-form-label col-sm-2 text-md-right">Страна</label>
                <div class="col-sm-3">
                  <select class="form-control" v-model="provinceId">
                    <option value="">Страна</option>
                    <option v-for="(name, id) in provinces" :value="id">@{{ name }}</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <select class="form-control" v-model="cityId">
                    <option value="">Выберите город</option>
                    <option v-for="(name, id) in cities" :value="id">@{{ name }}</option>
                  </select>
                </div>
              </div>
            </select-district>
            <!-- Вставлено 3 скрытых поля -->
            <!-- Свяжите значения в компоненте user-address-create-and-edit с v-моделью -->
            <!-- Когда значение в компоненте изменяется, значение здесь также изменяется. -->
            <input type="hidden" name="province" v-model="province">
            <input type="hidden" name="city" v-model="city">
            <div class="form-group row">
              <label class="col-form-label text-md-right col-sm-2">Подробный адрес</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="address" value="{{ old('address', $address->address) }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label text-md-right col-sm-2">Почтовый индекс</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="zip" value="{{ old('zip', $address->zip) }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label text-md-right col-sm-2">Полное имя</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name', $address->contact_name) }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label text-md-right col-sm-2">Телефон</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="contact_phone" value="{{ old('contact_phone', $address->contact_phone) }}">
              </div>
            </div>
            <div class="form-group row text-center">
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Сохранить</button>
              </div>
            </div>
          </form>
        </user-addresses-create-and-edit>
      </div>
    </div>
  </div>
</div>
@endsection
