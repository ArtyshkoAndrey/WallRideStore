<!doctype html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Admin</title>
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    @yield('css')
  </head>
  <body class="sidebar-mini  {{ Route::currentRouteNamed('admin.login') ? 'login-page' : '' }}">
    <div class="wrapper">
      @include('admin.layouts.navbar')

      @include('admin.layouts.aside')

      @yield('content')
    </div>
    <script src="{{ mix('js/admin.js') }}"></script>
    <script>
      $( document ).ready( () => {
        $('#name').click(() => {
          $('#list-auth').css('display', 'block')
        });
        $(document).click(function (event) {
          if (!$(event.target).closest('nav').length) {
            $('#list-auth').css('display', 'none')
          }
        })
      })
    </script>
  </body>
</html>
