@extends('layouts.admin')
@section('page-title', 'Crear usuario')

@section('content')

<div style="min-height: calc(100vh - 57px); display: flex; align-items: center; justify-content: center;">
    <div style="width: 100%; max-width: 520px;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Crear usuario</h4>
            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.user.save') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Bootstrap for seeing password -->
                    <script>
                        function togglePassword() {
                            const input = document.getElementById('password');
                            const icon  = document.getElementById('toggleIcon');
                            const show  = input.type === 'password';

                            input.type          = show ? 'text' : 'password';
                            icon.className      = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                        }
                    </script>

                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-select">
                            <option value="admin">Admin</option>
                            <option value="técnico">Técnico</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cédula</label>
                        <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sueldo</label>
                        <input type="number" name="sueldo" class="form-control" step="0.01" value="{{ old('sueldo') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de teléfono</label>
                        <input type="text" name="numeroTelefono" class="form-control" value="{{ old('numeroTelefono') }}">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="recibeNotificaciones" class="form-check-input" value="1"
                            {{ old('recibeNotificaciones') ? 'checked' : '' }}>
                        <label class="form-check-label">Recibe notificaciones</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection
