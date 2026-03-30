@extends('layouts.app')
@section('title', 'Gestión de usuarios')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/css/notification.css') }}">
@endpush

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title">Gestión de usuarios</h1>
    </div>
 
    {{-- Card --}}
    <div class="um-card">
        <div class="um-card-header">
            <div>
                <div class="um-card-title">Personas a notificar</div>
                <div class="um-card-subtitle">Administra los usuarios que reciben notificaciones del sistema</div>
            </div>
            <a href="#" class="um-btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1z"/>
                </svg>
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
                        <td>
                            <div class="um-user-cell">
                                <div class="um-avatar">
                                    {{ strtoupper(substr($user['name'], 0, 1)) }}{{ strtoupper(substr(strstr($user['name'], ' '), 1, 1)) }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="um-user-name">
                                {{ $user->getName() }}
                            </span>
                        </td>
                        <td class="um-email">{{ $user['email'] }}</td>
                        <td>
                            <span class="um-badge um-badge--{{ $user->getRol() }}">
                                {{ ucfirst($user->getRol()) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('notification.destroy' , ['id' => $user->getId()]) }}" method="POST"
                                onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="um-btn-delete" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
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

            <form action="{{ route('notification.save') }}" method="POST">
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