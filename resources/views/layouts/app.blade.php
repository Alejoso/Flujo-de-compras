<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <title>@yield('title', __('layout.appTitle'))</title>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            Flujo de compra
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="{{ __('layout.toggleNavigationTitle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <a class="nav-link active" href="#">Nop hago nada xd</a>
            </div>
        </div>
    </div>
</nav>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<div class="container my-4">
    @yield('content')
</div>

<div class="copyright py-4 text-center text-white">
    <div class="container">
        <small>
            {{ __('layout.copyrightTitle') }} -
            <a class="text-reset fw-bold text-decoration-none" target="_blank" href='#'>
                {{ __('layout.appDevsTitle') }}
            </a>
        </small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>

</body>
</html>