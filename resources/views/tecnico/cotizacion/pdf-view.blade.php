@extends('layouts.tecnico')
@section('page-title', 'Cotización — V' . $version->getNumeroVersion())


@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-file-earmark-pdf me-2"></i>
        Cotización — V{{ $version->getNumeroVersion() }}
      </h1>
      <div class="d-flex gap-2">
        <a href="{{ route('tecnico.cotizacion.pdfDownload', [$project->getId(), $version->getId()]) }}"
          class="um-btn-primary px-3 py-2">
          <i class="bi bi-download me-1"></i> Descargar PDF
        </a>
        <a href="{{ route('tecnico.cotizacion.versions', [$project->getId(), $version->getCotizacion()->getId()]) }}"
          class="um-btn-icon um-btn-icon--edit px-3 py-2">
          <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
      </div>
    </div>

    <div class="cot-doc-wrapper">

      <div class="cot-doc-header">
        <h2>{{ $tecnico->getName() }}</h2>
        <p>Tel: {{ $tecnico->getNumeroTelefono() }} &nbsp;&nbsp; Email: {{ $tecnico->getEmail() }}</p>
        <p>{{ $project->getCiudad() }}, Colombia</p>
      </div>

      <div class="cot-doc-title">Cotización {{ $numeroCotizacion }} - V{{ $version->getNumeroVersion() }}</div>
      <div class="cot-doc-title">{{ $project->getNombre() }}</div>
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

    </div>

  </div>
@endsection
