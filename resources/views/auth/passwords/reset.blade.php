@extends('layouts.app')
@section('title', 'Востановление пароля')

@section('content')

<auth-login inline-template>
    <section id="auth" class="h-100">
      <div class="container vh-100">
        <div class="row h-100 mt-auto align-items-center">
          <div class="col-md-6 d-none d-md-block col-lg-6">
            <h2 class="text-white">У нас ты найдешь товар по душе.</h2>
          </div>
          <div class="col-md-6 col-lg-6">
            <div class="card auth-card">
              <div class="card-body">
                <a href="{{ route('root') }}"><img src="../../img/Arrow%2010.png" alt="arrow" width="35" class="img-fluid mr-2">Назад к сайту</a>
                <h3 class="mt-3">Востановление пароля</h3>
                @if (session('status'))
                  <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                  </div>
                @endif
                <form class="needs-validation" novalidate method="POST" action="{{ route('password.update') }}">
                  @csrf
                  <input type="hidden" name="token" value="{{ $token }}">
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
                  <div class="md-form md-outline form-lg">
                    <input id="password-confirm" name="password_confirmation" class="mb-0 form-control form-control-lg pr-5 {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" :type="showPassConf ? 'text' : 'password'" required>
                    <label for="password-confirm">Подтвердите пароль</label>
                    <span @click="showPassConf = !showPassConf" :class="'fa fa-fw field-icon mr-3 toggle-password' + (showPassConf ? ' fa-eye-slash c-red'  : ' fa-eye')"></span>
                    <div class="invalid-feedback">
                      {{ $errors->first('password_confirmation') }}
                    </div>
                  </div>
                  <button type="submit" class="btn d-block w-100 btn-dark m-0">Востановить</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </auth-login>

<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection

@section('scriptsAfterJs')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/js/mdb.min.js"></script>
@endsection
