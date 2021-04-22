@extends('admin.layouts.app')

@section('title', 'Административная панель')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">

        <div class="card p-0"> <!-- p-0 = padding: 0 -->
          <img src="{{ asset('images/admin-hello.png') }}" class="img-fluid rounded-top" alt="Приветствие"> <!-- rounded-top = rounded corners on the top -->
          <!-- Nested content container inside card -->
          <div class="content">
            <h2 class="content-title">
              Добро пожаловать
            </h2>
            <p class="text-muted">
              Ваш сайт перешёл на обновлённую администраативную панель. Версия административной панели обновилась до {{ config('app.admin.version') }}
            </p>
            <ul>
              <li>Безопасность системы от 20.04.2021</li>
              <li>Генерация промокода</li>
              <li>Подготовка к будущим обновлениям</li>
            </ul>
          </div>
        </div>

      </div>

      <div class="col-lg-4 col-md-6">
        <div class="row">
          <div class="col-12">
            <div class="card p-0"> <!-- p-0 = padding: 0 -->

              <div class="content">
                <h2 class="content-title">
                  Горячиее клавиши
                </h2>
                <p><code class="code">Shift+S</code> - Открыть/Закрыть меню</p>
                <p><code class="code">Shift+D</code> - Сменить тему</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
