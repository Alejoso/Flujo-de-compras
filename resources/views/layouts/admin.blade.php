<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div class="admin-wrapper">

        {{-- Sidebar --}}
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <span class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></span>
                <span class="brand-name">{{ config('app.name') }}</span>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">General</div>

                <a href="#" class="sidebar-link active">
                    <i class="bi bi-folder2-open"></i>
                    <span>Proyectos</span>
                </a>

                <div class="nav-section-label mt-3">Administración</div>

                <a href="#" class="sidebar-link">
                    <i class="bi bi-people-fill"></i>
                    <span>Usuarios</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i class="bi bi-gear-fill"></i>
                    <span>Configuración</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->getName(), 0, 1)) }}</div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->getName() }}</span>
                        <span class="user-role">{{ Auth::user()->getRol() }}</span>
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
                <h5 class="topbar-title">@yield('page-title', 'Dashboard')</h5>
                <div class="topbar-right">
                    <span class="topbar-badge">Admin</span>
                </div>
            </header>

            <main class="admin-content">
                @yield('content')
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
