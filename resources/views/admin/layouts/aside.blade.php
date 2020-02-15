<!-- Main Sidebar Container -->
@auth('admin')
<aside class="main-sidebar sidebar-dark-primary" style="margin-top: 56px; min-height: calc(100vh - 56px)">
  <!-- Brand Logo -->
  <a href="{{ route('admin.dashboard') }}" class="brand-link">
    <img src="{{ asset('public/images/person.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar p-0">
    <!-- Sidebar Menu -->
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.dashboard') ? 'active' : '' }}">
            <i class="fal fa-store mr-3"></i>
            <p>
              Магазин
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.currencies') ? 'active' : '' }}">
            <i class="fal fa-badge-dollar mr-3"></i>
            <p>
              Валюта
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.products') ? 'active' : '' }}">
            <i class="fas fa-cube mr-3"></i>
            <p>
              Товары
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.users') ? 'active' : '' }}">
            <i class="fas fa-cube mr-3"></i>
            <p>
              Пользователи
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
@endauth
