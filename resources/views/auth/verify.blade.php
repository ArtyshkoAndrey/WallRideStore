@extends('layouts.app')

@section('content')
  <auth-verify inline-template>
    <section id="auth">
      <div class="container h-100">
        <div class="row h-100 mt-auto align-items-center">
          <div class="col-md-6 d-none d-md-block col-lg-6">
            <h2 class="text-white">Круто, что ты с нами!</h2>
          </div>
          <div class="col-md-6 col-lg-6">
            <div class="card auth-card">
              <div class="card-body">
                @if (session('resent'))
                  <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                  </div>
                @endif
                <h3>Вы успешно, зарегистрировались</h3>
                <p>Мы отправили Вам на почту <span class="c-red">{{ Auth::user()->email }}</span> письмо с подтверждением.</p>
                <p>Пожалуйста подтвердите Ваш аккаунт, чтобы пользоваться личным кабинетом</p>
                <p>Если письмо не пришло - проверьте в папке спам</p>
                <p>Если Вы не получили письмо , <a style="color: #F33C3C!important" href="{{ route('verification.resend') }}">нажмите здесь, чтобы отправить ещё раз</a></p>
                <div class="row">
                  <div class="col-md-6 col-12 text-center align-items-center justify-content-center d-flex"><a href="{{ route('profile.index') }}" style="color: #F33C3C!important" class="">Изменить почту</a></div>
                  <div class="col-md-6 col-12"><a href="{{ route('root') }}" class="btn d-block w-100 btn-dark m-0e" style="color: #ffffff!important; text-decoration: none!important;">Вернуться на сайт</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </auth-verify>
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Verify Your Email Address') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('resent'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ __('A fresh verification link has been sent to your email address.') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    {{ __('Before proceeding, please check your email for a verification link.') }}--}}
{{--                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
