@extends('layouts.app')

@section('content')
  <auth-login inline-template>
    <section id="auth">
      <div class="container h-100">
        <div class="row h-100 mt-auto align-items-center">
          <div class="col-md-6 d-none d-md-block col-lg-8">
            <h2 class="text-white">У нас ты найдешь товар по душе.</h2>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card auth-card">
              <div class="card-body">
                <a href="#">Назад к сайту</a>
                <h3 class="mt-3">Войти</h3>
                <form>
                  <div class="md-form md-outline form-lg">
                    <input id="form-lg" class="form-control form-control-lg" type="text">
                    <label for="form-lg">E-mail или Логин</label>
                  </div>
                  <div class="md-form md-outline form-lg">
                    <input id="form-lg" class="form-control form-control-lg" :type="showPass ? 'text' : 'password'">
                    <label for="form-lg">Пароль</label>
                    <span @click="showPass = !showPass" :class="'fa fa-fw field-icon toggle-password' + (showPass ? ' fa-eye-slash c-red'  : ' fa-eye')"></span>
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
