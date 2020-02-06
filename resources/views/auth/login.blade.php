@extends('layouts.app')

@section('content')
  <auth-login inline-template>
    <section id="auth">
      <div class="container h-100">
        <div class="row h-100 mt-auto align-items-center">
          <div class="col-md-6 d-none d-md-block col-lg-6">
            <h2 class="text-white">У нас ты найдешь товар по душе.</h2>
          </div>
          <div class="col-md-6 col-lg-6">
            <div class="card auth-card">
              <div class="card-body">
                <a href="{{ route('root') }}"><img src="../../img/Arrow%2010.png" alt="arrow" width="35" class="img-fluid mr-2">Назад к сайту</a>
                <h3 class="mt-3">Войти</h3>
                <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="md-form md-outline form-lg">
                    <input id="email" name="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" value="{{ old('email') }}" required autofocus>
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
                  <a href="{{ route('password.request') }}" class="c-red">Забыли пароль?</a>
{{--                  TODO баг с галочкой --}}
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" data-ng-model="example.check" name="remember" id="remember">
                      <span class="box"></span>
                      <span>Запомнить меня</span>
                    </label>
                  </div>
                  <button type="submit" class="btn d-block w-100 btn-dark m-0">Войти</button>
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
