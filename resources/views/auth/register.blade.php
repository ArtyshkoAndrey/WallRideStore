@extends('layouts.app')

@section('content')
<auth-login inline-template>
  <section id="auth">
    <div class="container vh-100">
      <div class="row h-100 mt-auto align-items-center">
        <div class="col-md-6 d-none d-md-block col-lg-6">
          <h2 class="text-white">О, привет! <br> Надеюсь, ты с нами на долго :)</h2>
        </div>
        <div class="col-md-6 col-lg-6">
          <div class="card auth-card">
            <div class="card-body">
              <a href="{{ route('root') }}">Назад к сайту</a>
              <h3 class="mt-3">Регистрация</h3>
              <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                @csrf
                <div class="md-form md-outline form-lg">
                  <input id="name" name="name" class="form-control form-control-lg {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" value="{{ old('name') }}" required autofocus>
                  <label for="name">Имя</label>
                  <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                  </div>
                </div>
                <div class="md-form md-outline form-lg">
                  <input id="email" name="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" value="{{ old('email') }}" required>
                  <label for="email">E-mail</label>
                  <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                  </div>
                </div>
                <div class="md-form md-outline form-lg mb-0">
                  <input id="password" name="password" class="mb-0 form-control form-control-lg pr-5 {{ $errors->has('password') ? ' is-invalid' : '' }}" :type="showPass ? 'text' : 'password'" required>
                  <label for="password">Пароль</label>
                  <span @click="showPass = !showPass" :class="'fa fa-fw field-icon mr-3 toggle-password' + (showPass ? ' fa-eye-slash c-red'  : ' fa-eye')"></span>
                  <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                  </div>
                </div>
                <div class="md-form md-outline form-lg mb-0">
                  <input id="password-confirm" name="password_confirmation" class="mb-0 form-control form-control-lg pr-5 {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" :type="showPassConf ? 'text' : 'password'" required>
                  <label for="password-confirm">Подтвердите пароль</label>
                  <span @click="showPassConf = !showPassConf" :class="'fa fa-fw field-icon mr-3 toggle-password' + (showPassConf ? ' fa-eye-slash c-red'  : ' fa-eye')"></span>
                  <div class="invalid-feedback">
                    {{ $errors->first('password_confirmation') }}
                  </div>
                </div>
                <div class="checkbox mt-3">
                  <label>
                    <input type="checkbox" data-ng-model="example.check" name="privacy" id="privacy" required>
                    <span class="box"></span>
                    <span>Я принимаю условия <a href="{{ route('policy') }}" class="c-red text-danger">политики конфиденциальности</a></span>
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" data-ng-model="example.check1" name="email_notifications" id="email-notifications">
                    <span class="box"></span>
                    <span>Я хочу получать e-mail уведомления об акциях и скидках</span>
                  </label>
                </div>
                <button type="submit" class="btn d-block w-100 btn-dark m-0">Зарегистироваться</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</auth-login>
@endsection

@section('scriptsAfterJs')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/js/mdb.min.js"></script>
@endsection
