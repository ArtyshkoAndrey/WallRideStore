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
  @if (env('METRICS', true))
    <!— Global site tag (gtag.js) - Google Analytics —>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-167190105-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-167190105-1');
    </script>
    <!— Yandex.Metrika counter —>
    <script type="text/javascript" >
      (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
      (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

      ym(62982313, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
      });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/62982313" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!— /Yandex.Metrika counter —>
  @endif
</head>
<body class="d-flex flex-column h-100">
<div id="app" amount="{{ $amount }}" class="{{ route_class() }}-page">
  @include('layouts.header')
  <div id="blur-for-menu" class="h-100">
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
    // $('ul.navbar-nav > li > .dropdown-menu a').on('click', function (event) {
    //   $(this).parent().parent().parent().toggleClass('show');
    // });
    // $('ul.navbar-nav > li').on('click', function (event) {
    //   $(this).children('.dropdown-menu').toggleClass('show');
    // });
    // $('body').on('click', function (e) {
    //   if (!$('ul.navbar-nav > li > .dropdown-menu').is(e.target)
    //     && $('ul.navbar-nav > li > .dropdown-menu').has(e.target).length === 0
    //     && $('.show').has(e.target).length === 0
    //   ) {
    //     $('ul.navbar-nav > li > .dropdown-menu').removeClass('show');
    //   }
    // });

    $(document).on('click', 'ul.navbar-nav > li > .dropdown-menu', function (e) {
      e.stopPropagation();
    });

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
