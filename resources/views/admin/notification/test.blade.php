@extends('layouts.app')
@section('title' , 'Formulario técnico')
@section('content')
<form action={{ route('admin.notification.send') }} method="GET">
    <div>
        <button type="submit" class="btn btn-success">Enviar</button>
    </div>
</form>
@endsection


