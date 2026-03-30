<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tecnico.css') }}" rel="stylesheet">
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

                <a href="#" class="sidebar-link active">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>Proyectos</span>
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

        <div class="tecnico-main">
            <header class="tecnico-topbar">
                <h5 class="topbar-title">@yield('page-title', 'Formulario')</h5>
                <div class="topbar-right">
                    <span class="topbar-badge tecnico-badge">Técnico</span>
                </div>
            </header>

            <main class="tecnico-content">
                @yield('content')
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
