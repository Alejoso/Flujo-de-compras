<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <style>
    {!! file_get_contents(public_path('css/tecnico.css')) !!}
  </style>
</head>

<body>

  <div class="cot-doc-header">
    <h2>{{ $tecnico->getName() }}</h2>
    <p>Tel: {{ $tecnico->getPhoneNumber() }} &nbsp;&nbsp; Email: {{ $tecnico->getEmail() }}</p>
    <p>{{ $project->getCity() }}, {{ __('tecnico_cotizacion.pdf_country') }}</p>
  </div>

  <div class="cot-doc-title">{{ __('tecnico_cotizacion.title_index') }} {{ $quotationNumber }} -
    V{{ $version->getVersionNumber() }}</div>
  <div class="cot-doc-title">{{ $project->getName() }}</div>
  <div class="cot-doc-date">{{ $fecha }}</div>

  <p class="cot-doc-intro">{{ __('tecnico_cotizacion.pdf_intro') }}</p>

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
          <td>
            @if ($item['presentacion'])
              {{ $item['cantidad'] }} {{ $item['presentacion'] }} de {{ $item['unidades'] }}
            @else
              {{ $item['cantidad'] }} {{ $item['unidades'] }}
            @endif
          </td>
          <td>{{ $item['descripcion'] }}</td>
          <td><strong>{{ $item['especificacion'] }}</strong></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="cot-doc-page-number">1</div>

</body>

</html>
