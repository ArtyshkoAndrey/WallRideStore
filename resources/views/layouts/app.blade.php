<!DOCTYPE html>
<html class="h-100">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- Meta --}}
  <meta name="description" content="@yield('meta-description', '')">
  <meta name="keywords" content="@yield('meta-keywords', '')">
  <meta name="robots" content="all" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'WallRidestore') - WallRidestore</title>
  <!-- стиль -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simptip@1.0.4/simptip.min.css">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('headerScript')
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
    @if (session()->has('success'))
      @foreach (session('success') as $message)
        <div class="alert alert-success alert-dismissible position-absolute d-table" style="right:0; z-index: 101;" role="alert">
          <button type="button" class="close mt-2" data-dismiss="alert">×</button>
          <h5 class="mt-2"><strong>{{ $message }}</strong></h5>
        </div>
      @endforeach
    @endif
    @yield('content')
  </div>
</div>

{{--МОДАЛЬНОЕ ОКНО АКЦИЙ--}}
@if($stocksToView)
  @include('layouts.modals', ['stock' => $stocksToView, 'coockie' => true])
@elseif(auth()->user())
  @foreach(\App\Models\Stock::where('on_auth', true)->get() as $stock)
    @if(!auth()->user()->checkedStockView($stock) && !auth()->user()->notification)
      @php
        $stocksToView = $stock;
        break;
      @endphp
    @endif
  @endforeach
  @include('layouts.modals', ['stock' => $stocksToView, 'coockie' => false])
@endif

@include('layouts.footer')
<!-- JS скрипт -->
<script src="{{ mix('js/app.js') }}"></script>
<script src='{{ asset('public/js/jquery-ui.min.js') }}'></script>
<script src="{{ asset('public/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('public/js/menu.js') }}"></script>
<script type="text/javascript">

  function subscribe() {
    let email = $('#email-notify').val()
    let name = $('#name-notify').val()
    if (email !== '' && name !== '') {
      axios.post('{{ route('notification.subscribe.not-auth') }}', {email: email, name: name})
        .then((response) => {
          if (response.data.status) {
            location.reload();
          } else {
            alert('Ошибка')
          }
        })
    } else if (email !== '') {
      axios.post('{{ route('api.check.email') }}', {email: email})
        .then((response) => {
          if (!response.data.status) {
            $('#name-block-notify').removeClass('d-none')
          } else {
            axios.post('{{ route('notification.subscribe.not-auth-email') }}', {email: email})
              .then((response) => {
                if (response.data.status) {
                  location.reload();
                } else {
                  alert('Ошибка')
                }
              })
          }
        })
    }
  }

  (function($){
    $.fn.isActive = function(){
      console.log(this)
      let ch = false
      let obj = this
      if(!Array.isArray(this))
        obj = [obj]

      obj.forEach(el => {
        el.hasClass('show') ? ch = true : null
      })
      return ch
    }
  })(jQuery)

  window.onload = function() {

    // ПРОВЕРКА ЧТО БЫ ОТКРЫТЬ ОКНО АКЦИЙ
    @if(isset($stocksToView))
      setTimeout(() => {
        $('#stock').modal('toggle')
      }, 1000)

    @endif

    $(document).on('click', 'ul.navbar-nav > li > .dropdown-menu', function (e) {
      e.stopPropagation();
    });

    $('#firstNav').on('show.bs.dropdown', function () {
      setTimeout(() => {checkOpenCart()}, 100)
    })

    $('#firstNav').on('hidden.bs.dropdown', function () {
      setTimeout(() => {checkOpenCart()}, 100)
    })

    $('#navbarSupportedContent1').on('show.bs.dropdown', function () {
      setTimeout(() => {checkOpenCart()}, 100)
    })

    $('#navbarSupportedContent1').on('hidden.bs.dropdown', function () {
      setTimeout(() => {checkOpenCart()}, 100)
    })

    $('#nav-icon3').click(function () {
      $(this).toggleClass('open');
      checkToggableMenu(true)
    });

    $('#blur-for-menu').click(() => {
      if (checkToggableMenu()) {
        $('#nav-icon3').toggleClass('open');
        checkToggableMenu(true);
      }
    });
  };

  function checkOpenCart() {
    if($('[aria-labelledby="cart"]').isActive() || $('[aria-labelledby="top-brands"]').isActive()) {
      $('body').css("overflow","hidden");
    } else {
      $('body').css("overflow","auto");
    }
  }

  function checkToggableMenu(toggle = false) {
    let $body = document.body;
    if (toggle) {
      $body.className = ($body.className === 'menu-active d-flex flex-column h-100') ? 'd-flex flex-column h-100' : 'menu-active d-flex flex-column h-100';
    }
    return $body.className === 'menu-active d-flex flex-column h-100';
  }
</script>
@yield('scriptsAfterJs')
</body>
</html>
