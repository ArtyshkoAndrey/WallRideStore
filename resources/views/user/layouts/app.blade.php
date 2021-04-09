<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="robots" content="all" />
  <meta name="description" content="@yield('meta-description', '')">
  <meta name="keywords" content="@yield('meta-keywords', '')">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="preload" href="{{ asset('css/preloader.css') }}" as="style" />
  <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">

  <link rel="preload" href="{{ mix('css/app.css') }}" as="style" />

  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

  <title>{{ config('app.name') }} | @yield('title', '')</title>

  @if (config('app.metrics'))
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
<body id="{{ str_replace('.', '-', Route::currentRouteName()) . '-page' }}">

  <div class="preloader">
    <img src="{{ asset('images/logo-dark.svg') }}" alt="logo" class="img-fluid preloader__logo">
    <div class="preloader__row">
      <div class="preloader__item"></div>
      <div class="preloader__item"></div>
    </div>
  </div>

  <div class="wrapper">
    <div id="app" ref="app">

      @include('user.layouts.header.alerts')

      @include('user.layouts.header.header')

      <div id="main">
        @yield('content')
      </div>
    </div>

    @include('user.layouts.footer')
  </div>

  <script src="{{ mix('js/app.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>

  <script>
    window.onload = function () {
      document.body.classList.add('loaded_hiding');
      window.setTimeout(function () {
        document.body.classList.add('loaded');
        document.body.classList.remove('loaded_hiding');
      }, 300);
    }
  </script>
  @yield('js')
</body>
</html>
