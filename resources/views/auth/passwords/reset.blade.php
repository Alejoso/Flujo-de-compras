<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restablecer contraseña — {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body class="login-page">

    <div class="login-container">

        {{-- Brand --}}
        <div class="login-brand">
            <div class="login-brand-icon">🏗️</div>
            <span class="login-brand-name">{{ config('app.name', 'Laravel') }}</span>
            <span class="login-brand-sub">Gestión de compras y proyectos</span>
        </div>

        {{-- Card --}}
        <div class="login-card">
            <p class="login-card-title">Restablecer contraseña</p>
            <p class="login-card-subtitle">Ingresa tu nueva contraseña</p>
            <div class="login-divider"></div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="login-field">
                    <label for="email" class="login-label">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="login-input @error('email') is-invalid @enderror"
                        value="{{ $email ?? old('email') }}"
                        placeholder="tucorreo@ejemplo.com"
                        required
                        autocomplete="email"
                        autofocus
                    >
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="login-field">
                    <label for="password" class="login-label">Nueva contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="login-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    >
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="login-field">
                    <label for="password-confirm" class="login-label">Confirmar contraseña</label>
                    <input
                        id="password-confirm"
                        type="password"
                        name="password_confirmation"
                        class="login-input"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <button type="submit" class="login-btn">
                    Restablecer contraseña
                </button>

                <a class="login-forgot" href="{{ route('login') }}">
                    Volver al inicio de sesión
                </a>
            </form>
        </div>

        <p class="login-footer">© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
    </div>

</body>
</html>
