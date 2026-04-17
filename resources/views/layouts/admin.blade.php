<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  @stack('styles')
</head>

<body>
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  <div class="admin-wrapper">

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-brand">
        <span class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></span>
        <span class="brand-name">{{ config('app.name') }}</span>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-section-label">General</div>

        <a href="{{ route('admin.project.index') }}"
          class="sidebar-link {{ request()->routeIs('admin.project*') ? 'active' : '' }}">
          <i class="bi bi-folder2-open"></i>
          <span>Proyectos</span>
        </a>

        <div class="nav-section-label mt-3">Administración</div>

        <a href="{{ route('admin.user.index') }}"
          class="sidebar-link {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
          <i class="bi bi-people-fill"></i>
          <span>Usuarios</span>
        </a>

        <a href="{{ route('admin.client.index') }}"
          class="sidebar-link {{ request()->routeIs('admin.client*') ? 'active' : '' }}">
          <i class="bi bi-person-heart"></i>
          <span>Clientes</span>
        </a>

        <a href="{{ route('admin.material.index') }}"
          class="sidebar-link {{ request()->routeIs('admin.material*') ? 'active' : '' }}">
          <i class="bi bi-box-seam"></i>
          <span>Materiales</span>
        </a>

        <a href="{{ route('admin.supplier.index') }}"
          class="sidebar-link {{ request()->routeIs('admin.supplier*') ? 'active' : '' }}">
          <i class="bi bi-truck"></i>
          <span>Proveedores</span>
        </a>

        <div class="nav-section-label mt-3">Configuración</div>

        <a href="{{ route('admin.notification.index') }}"
          class="sidebar-link {{ request()->routeIs('admin.notification*') ? 'active' : '' }}">
          <i class="bi bi-bell-fill"></i>
          <span>Notificaciones</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="user-avatar">{{ strtoupper(substr(Auth::user()->getName(), 0, 1)) }}</div>
          <div class="user-info">
            <span class="user-name">{{ Auth::user()->getName() }}</span>
            <span
              class="user-role">{{ match (Auth::user()->getRole()) {
                  'admin' => __('admin_user.rol_admin'),
                  'technician' => __('admin_user.rol_tecnico'),
                  'tecnico' => __('admin_user.rol_tecnico'),
                  default => Auth::user()->getRole(),
              } }}</span>
          </div>
        </div>
        <a href="{{ route('logout') }}" class="sidebar-logout"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
      </div>
    </aside>

    {{-- Main content --}}
    <div class="admin-main">
      <header class="admin-topbar">
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir menú">
          <i class="bi bi-list"></i>
        </button>
        <h5 class="topbar-title">@yield('page-title', 'Dashboard')</h5>
        <div class="topbar-right">
          <span class="topbar-badge">Admin</span>
        </div>
      </header>

      <main class="admin-content">

        {{-- Message popup --}}
        @if (session('success') || session('error') || session('warning') || session('info'))
          <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 admin-toast-container">
            <div class="toast show admin-toast" role="alert">
              <div
                class="toast-header
                            @if (session('success')) bg-success text-white
                            @elseif (session('error')) bg-danger text-white
                            @elseif (session('warning')) bg-warning
                            @else bg-info text-white @endif">
                <strong class="me-auto">
                  @if (session('success'))
                    {{ __('messages.success') }}
                  @elseif (session('error'))
                    {{ __('messages.error') }}
                  @elseif (session('warning'))
                    {{ __('messages.warning') }}
                  @else
                    {{ __('messages.info') }}
                  @endif
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
              </div>
              <div class="toast-body">
                {{ session('success') ?? (session('error') ?? (session('warning') ?? session('info'))) }}
              </div>
            </div>
          </div>
        @endif

        {{-- End Message popup --}}


        @yield('content')
      </main>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/admin/layout.js') }}"></script>
  @stack('scripts')
</body>

</html>
