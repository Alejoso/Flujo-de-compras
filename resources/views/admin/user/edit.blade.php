@extends('layouts.admin')
@section('page-title', 'Editar usuario')

@section('content')

<div class="um-form-page">
    <div class="um-form-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Editar usuario</h4>
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
                <form action="{{ route('admin.user.update', $viewData['user']->getId()) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $viewData['user']->getName()) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $viewData['user']->getEmail()) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña <small class="text-muted">(dejar vacío para no cambiar)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-select">
                            <option value="admin" {{ old('rol', $viewData['user']->getRol()) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="tecnico" {{ old('rol', $viewData['user']->getRol()) === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cédula</label>
                        <input type="text" name="cedula" class="form-control" value="{{ old('cedula', $viewData['user']->getCedula()) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sueldo</label>
                        <input type="number" name="sueldo" class="form-control" step="0.01" value="{{ old('sueldo', $viewData['user']->getSueldo()) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de teléfono</label>
                        <input type="text" name="numeroTelefono" class="form-control" value="{{ old('numeroTelefono', $viewData['user']->getNumeroTelefono()) }}">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="recibeNotificaciones" class="form-check-input" value="1"
                            {{ old('recibeNotificaciones', $viewData['user']->getRecibeNotificaciones()) ? 'checked' : '' }}>
                        <label class="form-check-label">Recibe notificaciones</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection
