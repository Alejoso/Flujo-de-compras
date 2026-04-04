@extends('layouts.admin')
@section('page-title', 'Notificaciones')

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-bell-fill"></i> Gestión de notificaciones</h1>
    </div>

    {{-- Card --}}
    <div class="um-card">
        <div class="um-card-header">
            <div>
                <div class="um-card-title">Personas a notificar</div>
                <div class="um-card-subtitle">Administra los usuarios que reciben notificaciones del sistema</div>
            </div>
            <a href="#" class="um-btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
                <i class="bi bi-plus-lg"></i>
                Agregar usuario
            </a>
        </div>

        {{-- Table --}}
        <div class="um-table-wrapper">
            <table class="um-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['userWithNotifications'] as $user)
                    <tr class="um-row">
                        <td class="um-td-avatar">
                            <div class="um-user-cell">
                                <div class="um-avatar">
                                    {{ strtoupper(substr($user->getName(), 0, 1)) }}{{ strtoupper(substr(strstr($user->getName(), ' '), 1, 1)) }}
                                </div>
                            </div>
                        </td>
                        <td data-label="Nombre">
                            <span class="um-user-name">{{ $user->getName() }}</span>
                        </td>
                        <td data-label="Correo" class="um-email">{{ $user->getEmail() }}</td>
                        <td data-label="Rol">
                            <span class="um-badge um-badge--{{ $user->getRol() }}">
                                {{ ucfirst($user->getRol()) }}
                            </span>
                        </td>
                        <td data-label="Acciones">
                            <form action="{{ route('admin.notification.destroy', ['id' => $user->getId()]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="um-btn-delete" title="Eliminar">
                                    <i class="bi bi-x-square-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="um-empty">No hay usuarios registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Agregar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.notification.save') }}" method="POST">
                @csrf
                @method('PATCH')
                @if(count($viewData['usersWithNoNotifications']) == 0)
                    <div class="modal-body">
                        <label class="form-label">No hay usuarios disponibles</label>
                    </div>
                @else
                    <div class="modal-body">
                        <label class="form-label">Seleccionar usuario</label>
                        <select name="user_id" class="form-select">
                            <option value="">-- Selecciona un usuario --</option>
                            @foreach ($viewData['usersWithNoNotifications'] as $user)
                                <option value="{{ $user->getId() }}">{{ $user->getName() }} — {{ $user->getEmail() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                @endif
            </form>

        </div>
    </div>
</div>
@endsection
