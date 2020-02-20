<!-- Main Sidebar Container -->
@auth('admin')
<aside class="main-sidebar sidebar-dark-primary" style="margin-top: 56px; min-height: calc(100vh - 56px); height: 100%;">

  <!-- Sidebar -->
  <div class="sidebar p-0 mt-3">
    <!-- Sidebar Menu -->
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="{{ route('admin.store.order.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.store.*') ? 'active' : '' }}">
            <i class="fal fa-store mr-3"></i>
            <p>
              Магазин
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.store.order.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.currencies.*') ? 'active' : '' }}">
            <i class="fal fa-badge-dollar mr-3"></i>
            <p>
              Валюта
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.store.order.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.order') ? 'active' : '' }}">
            <i class="fas fa-cube mr-3"></i>
            <p>
              Товары
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.store.order.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.user') ? 'active' : '' }}">
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
