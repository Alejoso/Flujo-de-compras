@extends('layouts.app')
@section('title', 'Usuarios')

@section('content')

<h2>Usuarios</h2>

<a href="{{ route('user.create') }}">+ Crear usuario</a>

@if ($viewData['users']->isEmpty())
    <p>No hay usuarios registrados.</p>
@else
<table border="1">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Sueldo</th>
            <th>Notificaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($viewData['users'] as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->rol }}</td>
            <td>{{ $user->cedula }}</td>
            <td>{{ $user->numeroTelefono }}</td>
            <td>{{ $user->sueldo }}</td>
            <td>{{ $user->recibeNotificaciones ? 'Sí' : 'No' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection