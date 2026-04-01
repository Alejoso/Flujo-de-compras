<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/tecnico.css') }}">
</head>
<body>

    <div class="cot-doc-header">
        <h2>{{ $tecnico->getName() }}</h2>
        <p>Tel: {{ $tecnico->getNumeroTelefono() }} &nbsp;&nbsp; Email: {{ $tecnico->getEmail() }}</p>
        <p>{{ $project->getCiudad() }}, Colombia</p>
    </div>

    <div class="cot-doc-title">Cotización {{ $numeroCotizacion }} V{{ $version->getNumeroVersion() }} {{ $project->getNombre() }}</div>
    <div class="cot-doc-date">{{ $fecha }}</div>

    <p class="cot-doc-intro">A continuación se presenta una tabla con los materiales a cotizar:</p>

    <table class="cot-doc-table">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Especificación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materiales as $item)
                <tr>
                    <td>{{ $item['cantidad'] }} ({{ $item['unidades'] }})</td>
                    <td>{{ $item['descripcion'] }}</td>
                    <td><strong>{{ $item['especificacion'] }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="cot-doc-page-number">1</div>

</body>
</html>
