@extends('layouts.admin')
@section('page-title', 'Usuarios')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/css/notification.css') }}">
@endpush

@section('content')
<div class="um-wrapper">

    <div class="um-header">
        <h1 class="um-title">Usuarios</h1>
    </div>

    <div class="um-card">
        <div class="um-card-header">
            <div>
                <div class="um-card-title">Lista de usuarios</div>
                <div class="um-card-subtitle">Administra los usuarios del sistema</div>
            </div>
            <a href="{{ route('admin.user.create') }}" class="um-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1z"/>
                </svg>
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
                        <td>
                            <div class="um-user-cell">
                                <div class="um-avatar">
                                    {{ strtoupper(substr($user->getName(), 0, 1)) }}{{ strtoupper(substr(strstr($user->getName(), ' '), 1, 1)) }}
                                </div>
                            </div>
                        </td>
                        <td><span class="um-user-name">{{ $user->getName() }}</span></td>
                        <td class="um-email">{{ $user->getEmail() }}</td>
                        <td>
                            <span class="um-badge um-badge--{{ $user->getRol() }}">
                                {{ ucfirst($user->getRol()) }}
                            </span>
                        </td>
                        <td>{{ $user->getCedula() }}</td>
                        <td>{{ $user->getNumeroTelefono() }}</td>
                        <td>{{ $user->getSueldo() }}</td>
                        <td>
                            <span class="um-status um-status--{{ $user->getRecibeNotificaciones() ? '1' : '0' }}">
                                {{ $user->getRecibeNotificaciones() ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <div class="um-actions">
                                <a href="{{ route('admin.user.edit', $user->getId()) }}" class="um-btn-icon um-btn-icon--edit" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.user.destroy', $user->getId()) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="um-btn-icon um-btn-icon--delete" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
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
