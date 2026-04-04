@extends('layouts.admin')
@section('page-title', 'Usuarios')

@section('content')
<div class="um-wrapper">

    <div class="um-header">
        
        <h1 class="um-title"><i class="bi bi-people-fill"></i> Usuarios</h1>
    </div>

    <div class="um-card">
        <div class="um-card-header">
            <div>
                <div class="um-card-title">Lista de usuarios</div>
                <div class="um-card-subtitle">Administra los usuarios del sistema</div>
            </div>
            <a href="{{ route('admin.user.create') }}" class="um-btn-primary">
                <i class="bi bi-plus-lg"></i>
                Crear usuario
            </a>
        </div>

        <div class="um-table-wrapper">
            <table class="um-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Cédula</th>
                        <th>Teléfono</th>
                        <th>Sueldo</th>
                        <th>Notificaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['users'] as $user)
                    <tr class="um-row">
                        <td class="um-td-avatar">
                            <div class="um-user-cell">
                                <div class="um-avatar">
                                    {{ strtoupper(substr($user->getName(), 0, 1)) }}{{ strtoupper(substr(strstr($user->getName(), ' '), 1, 1)) }}
                                </div>
                            </div>
                        </td>
                        <td data-label="Nombre"><span class="um-user-name">{{ $user->getName() }}</span></td>
                        <td data-label="Correo" class="um-email">{{ $user->getEmail() }}</td>
                        <td data-label="Rol">
                            <span class="um-badge um-badge--{{ $user->getRol() }}">
                                {{ ucfirst($user->getRol()) }}
                            </span>
                        </td>
                        <td data-label="Cédula">{{ $user->getCedula() }}</td>
                        <td data-label="Teléfono">{{ $user->getNumeroTelefono() }}</td>
                        <td data-label="Sueldo">{{ $user->getSueldo() }}</td>
                        <td data-label="Notificaciones">
                            <span class="um-status um-status--{{ $user->getRecibeNotificaciones() ? '1' : '0' }}">
                                {{ $user->getRecibeNotificaciones() ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td data-label="Acciones">
                            <div class="um-actions">
                                <a href="{{ route('admin.user.edit', $user->getId()) }}" class="um-btn-icon um-btn-icon--edit" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.user.destroy', $user->getId()) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="um-btn-icon um-btn-icon--delete" title="Eliminar">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="um-empty">No hay usuarios registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
