@extends('layouts.app')

@section('content')
  <auth-login inline-template>
    <section id="auth">
      <div class="container vh-100">
        <div class="row h-100 mt-auto align-items-center">
          <div class="col-md-6 d-none d-md-block col-lg-6">
            <h2 class="text-white">У нас ты найдешь товар по душе.</h2>
          </div>
          <div class="col-md-6 col-lg-6">
            <div class="card auth-card">
              <div class="card-body">
                <a href="{{ route('root') }}">Назад к сайту</a>
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
                  <div class="md-form md-outline form-lg mb-3">
                    <input id="password" name="password" class="mb-0 form-control form-control-lg pr-5 {{ $errors->has('password') ? ' is-invalid' : '' }}" :type="showPass ? 'text' : 'password'" required>
                    <label for="password">Пароль</label>
                    <span @click="showPass = !showPass" :class="'fa fa-fw field-icon mr-3 toggle-password' + (showPass ? ' fa-eye-slash c-red'  : ' fa-eye')"></span>
                    <div class="invalid-feedback">
                      {{ $errors->first('password') }}
                    </div>
                  </div>
                  <a href="{{ route('password.request') }}" class="c-red">Забыли пароль?</a>
{{--                  TODO баг с галочкой --}}
                  <div class="checkbox mt-2">
                    <label>
                      <input type="checkbox" data-ng-model="example.check" name="remember" id="remember">
                      <span class="box"></span>
                      <span>Запомнить меня</span>
                    </label>
                  </div>
                  <button type="submit" class="btn d-block w-100 btn-dark m-0">Войти</button>
                  <div class="row justify-content-center">
                    <a href="{{ route('vk.redirect') }}" id="vk-auth" class="btn text-white mx-0 px-3 mt-2"><i class="fab fa-2x fa-vk"></i></a>
                    <a href="{{ route('google.redirect') }}" id="google-auth" class="btn text-white mx-0 px-3 mt-2 ml-2"><i class="fab fa-2x fa-google-plus-g"></i></a>
{{--                    <a href="{{ route('vk.redirect') }}" id="vk-auth" class="btn text-white mx-0 px-4 mt-2 ml-2"><i class="fab fa-2x fa-facebook-f"></i></a>--}}
                  </div>
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
