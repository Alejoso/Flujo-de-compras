@extends('layouts.app')
@section('title', 'Crear usuario')

@section('content')

<h2>Crear usuario</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('user.save') }}" method="POST">
    @csrf

    <div>
        <label>Nombre</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        <label>Correo</label>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <label>Contraseña</label>
        <input type="password" name="password">
    </div>

    <div>
        <label>Rol</label>
        <select name="rol">
            <option value="admin">Admin</option>
            <option value="técnico">Técnico</option>
        </select>
    </div>

    <div>
        <label>Cédula</label>
        <input type="text" name="cedula" value="{{ old('cedula') }}">
    </div>

    <div>
        <label>Sueldo</label>
        <input type="number" name="sueldo" step="0.01" value="{{ old('sueldo') }}">
    </div>

    <div>
        <label>Número de teléfono</label>
        <input type="text" name="numeroTelefono" value="{{ old('numeroTelefono') }}">
    </div>

    <div>
        <label>
            <input type="checkbox" name="recibeNotificaciones" value="1"
                {{ old('recibeNotificaciones') ? 'checked' : '' }}>
            Recibe notificaciones
        </label>
    </div>

    <div>
        <a href="{{ route('user.index') }}">Cancelar</a>
        <button type="submit">Guardar</button>
    </div>

</form>

@endsection