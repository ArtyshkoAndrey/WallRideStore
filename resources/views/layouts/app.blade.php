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
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="{{ route_class() }}-page">
  @include('layouts.header')
  <div id="blur-for-menu">
    @yield('content')
{{--    @include('layouts._footer')--}}
  </div>
</div>
<!-- JS скрипт -->
<script src="{{ mix('js/app.js') }}"></script>
<script src='{{ asset('public/js/jquery-ui.min.js') }}'></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script type="text/javascript">
  window.onload = function() {
    if(!window.matchMedia('(max-width: 768px)').matches) {
      $("li.dropdown").hover(function () {
        var id = $(this).attr("rel");
        $(this).toggleClass("active");
      }, function () {
        $('.close-submenu').hide();
        $(this).toggleClass("active");
      });
    } else {
      $("li.dropdown").click(function () {
        $('.close-submenu').show();
        $(this).toggleClass("active");
        window.setInterval(checkVisibleSubMenu, 100);
      });
    }

    $('#nav-icon3').click(function () {
      $(this).toggleClass('open');
      console.log('Меню ' + (checkToggableMenu(true) ? 'открыто' : 'закрыто'))
    });

    $('#blur-for-menu').click(() => {
      if (checkToggableMenu()) {
        $('#nav-icon3').toggleClass('open');
        checkToggableMenu(true);
      }
    });
  };
  function closeSubMenu() {
    $('.close-submenu').hide();
    $('li.dropdown').filter('.active').toggleClass("active")
  }

  function checkVisibleSubMenu() {
    if($('li.dropdown').filter('.active').length < 1) {
      closeSubMenu()
    }
  }
  function checkToggableMenu(toggle = false) {
    let $body = document.body;
    if (toggle) {
      closeSubMenu()
      $body.className = ($body.className === 'menu-active') ? '' : 'menu-active';
    }
    return $body.className === 'menu-active';
  }
</script>
@yield('scriptsAfterJs')
</body>
</html>
