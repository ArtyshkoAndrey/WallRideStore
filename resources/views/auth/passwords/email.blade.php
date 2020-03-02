@extends('layouts.app')
@section('title', 'Сброс пароля')

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
                <a href="{{ route('root') }}">Назад к сайту</a>
                <h3 class="mt-3">Сброс пароля</h3>
                @if (session('status'))
                  <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                  </div>
                @endif
                <form class="needs-validation" novalidate method="POST" action="{{ route('password.email') }}">
                  @csrf
                  <div class="md-form md-outline form-lg">
                    <input id="email" name="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" value="{{ old('email') }}" required autofocus>
                    <label for="email">E-mail</label>
                    <div class="invalid-feedback">
                      {{ $errors->first('email') }}
                    </div>
                  </div>
                  <button type="submit" class="btn d-block w-100 btn-dark m-0">Сброс</button>
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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
