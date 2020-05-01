<!DOCTYPE html>
<html class="h-100">
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
<body class="d-flex flex-column h-100">
<div id="app" amount="{{ $amount }}" class="{{ route_class() }}-page">
  @include('layouts.header')
  <div id="blur-for-menu">
    @yield('content')
  </div>
</div>
@include('layouts.footer')
<!-- JS скрипт -->
<script src="{{ mix('js/app.js') }}"></script>
<script src='{{ asset('public/js/jquery-ui.min.js') }}'></script>
<script src="{{ asset('public/js/jquery.mask.min.js') }}"></script>
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
  function resetListCity () {
    let param = $("input[name='location_city']").val()

    $.ajax({
      url: '{{ route('api.city', '') }}' + '/' + param,
      method: 'POST',
      success: function(data){
        $('#list-city').html('')
        data.items.forEach( city => {
          $('#list-city').append(
            '<a href="/location/' + city.id + '" class="list-group-item list-group-item-action">' + city.name + '</a>'
          )
        })
      }
    })
  }

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
      $body.className = ($body.className === 'menu-active d-flex flex-column h-100') ? 'd-flex flex-column h-100' : 'menu-active d-flex flex-column h-100';
    }
    return $body.className === 'menu-active d-flex flex-column h-100';
  }
</script>
@yield('scriptsAfterJs')
</body>
</html>
