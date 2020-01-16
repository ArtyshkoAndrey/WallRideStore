<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'WallRidestore') - WallRidestore</title>
  <!-- стиль -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="{{ route_class() }}-page">
  @include('layouts.header')
  <div id="blur-for-menu">
    <div class="container">
      @yield('content')
    </div>
    @include('layouts._footer')
  </div>
</div>
<!-- JS скрипт -->
<script src="{{ mix('js/app.js') }}"></script>
<script>
  /*
  Slidemenu
*/
  $(document).ready(function() {
    $('#nav-icon3').click(function(){
      var $body = document.body;
      $(this).toggleClass('open');
      $body.className = ( $body.className === 'menu-active' )? '' : 'menu-active';
    });
  });
</script>
@yield('scriptsAfterJs')
</body>
</html>
