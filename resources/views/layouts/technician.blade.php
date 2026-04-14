<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} | Técnico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/technician.css') }}" rel="stylesheet">
  @stack('styles')
</head>

<body>
  <div class="tecnico-wrapper">

    <aside class="tecnico-sidebar">
      <div class="sidebar-brand">
        <span class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></span>
        <span class="brand-name">{{ config('app.name') }}</span>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-section-label">Menú</div>

        <a href="{{ route('technician.project.index') }}" class="sidebar-link active">
          <i class="bi bi-file-earmark-text-fill"></i>
          <span>Proyectos</span>
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

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="tecnico-main">
      <header class="tecnico-topbar">
        <div class="d-flex align-items-center gap-3">
          <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir menú">
            <i class="bi bi-list"></i>
          </button>
          <h5 class="topbar-title">@yield('page-title', 'Formulario')</h5>
        </div>
        <div class="topbar-right">
          <span class="topbar-badge tecnico-badge">Técnico</span>
        </div>
      </header>

      <main class="tecnico-content">
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
  @stack('scripts')
  <script src="{{ asset('js/tecnico/layout.js') }}"></script>
</body>

</html>
