@extends('layouts.app')
@section('title' , 'Formulario técnico')
@section('content')
<form action={{ route('notification.send') }} method="GET">
    <div>
        <label>Ingrese su correo por favor</label>
        <input 
        type="email" 
        name="email"
        value="{{ old('email') }}"
        placeholder="Correo electronico..."
        required="true"
        >
    </div>
    
    <div>
        <button type="submit" class="btn btn-success">Enviar</button>
    </div>
</form>
@endsection


