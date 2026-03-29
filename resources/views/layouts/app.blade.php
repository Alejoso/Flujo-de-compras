<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <title>@yield('title', 'Notificaciones')</title>

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
                <a class="nav-link active" href="#">No hago nada xd</a>
            </div>
        </div>
    </div>
</nav>

<!-- Block for showing session messages -->
@if (session('success') || session('error'))
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
    <div class="toast show bg-white" role="alert" style="min-width: 600px;">
        <div class="toast-header
            @if(session('success')) bg-success text-white
            @else bg-warning
            @endif">
            <strong class="me-auto">
                {{ session('success') ? 'Éxito' : 'Advertencia' }}
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') ?? session('error') }}
        </div>
    </div>
</div>

<script>
    const toastEl = document.querySelector('.toast');
    toast.show();
</script>
@endif
<!-- End block of session messages -->

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