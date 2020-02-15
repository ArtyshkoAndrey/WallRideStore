<!-- Navbar -->
@auth('admin')
<nav class="main-header navbar navbar-expand navbar-dark navbar-light ml-0 border-0" style="height: 56px;">
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    @auth('admin')
      <li class="nav-item dropdown row">
        <section class="col">
          <a class="row nav-link p-0 h-auto" id="name" style="cursor: pointer" role="button">{{ auth()->user()->name }}</a>
          <div class="row">
            <a href="{{ route('admin.dashboard') }}" style="font-size: 12px; color: #F33C3C; line-height: 12px; z-index: 1000">
              настройки пользователя
            </a>
          </div>
        </section>
        <section class="col-auto"><img src="{{ asset('public/images/person.png') }}" class="rounded-circle w-auto" height="40" alt="person"></section>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="list-auth">
          <a class="dropdown-item" href="{{ route('admin.logout') }}">Выход</a>
        </div>
      </li>
    @endauth
  </ul>
</nav>
@endauth
<!-- /.navbar -->
