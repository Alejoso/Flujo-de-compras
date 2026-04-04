@extends('layouts.tecnico')
@section('page-title', 'Detalle Cotización')

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-clipboard-check-fill me-2"></i>
        Versión {{ $viewData['version']->getNumeroVersion() }}
        @if ($viewData['version']->getEsLaMasReciente())
          <span class="cot-counter ms-2">Actual</span>
        @endif
      </h1>
      <div class="d-flex gap-2">
        <a href="{{ route('tecnico.cotizacion.versions', [$viewData['project']->getId(), $viewData['version']->getCotizacion()->getId()]) }}"
          class="um-btn-icon um-btn-icon--secondary px-3 py-2">
          <i class="bi bi-arrow-left me-1"></i> Volver
        </a>

        @if ($viewData['version']->getEsLaMasReciente())
          <a href="{{ route('tecnico.cotizacion.edit', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
            class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-pencil-square me-1"></i> Editar Materiales
          </a>
        @endif
      </div>
    </div>

    <div class="cot-header-card mb-4">
      <p class="cot-project-name">
        <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
      </p>
      <p class="cot-project-meta">
        <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCiudad() }} —
        {{ $viewData['project']->getDireccion() }}
        &nbsp;·&nbsp;
        <i class="bi bi-calendar3 me-1"></i>{{ $viewData['version']->getCreatedAt() }}
      </p>
    </div>

    <div class="cot-table-wrap">
      <table class="cot-table cot-show-table">
        <thead>
          <tr>
            <th class="cot-col-show-material">Material</th>
            <th class="cot-col-show-tipo">Tipo / Especificación</th>
            <th>Presentación</th>
            <th class="cot-col-show-unidad">Unidad</th>
            <th class="cot-col-show-cantidad">Cantidad</th>
          </tr>
        </thead>
        <tbody>
          @forelse($viewData['materialesVersion'] as $mat)
            <tr>
              <td class="cot-td-material" data-label="Material">{{ $mat['descripcion'] }}</td>
              <td class="cot-td-tipo" data-label="Tipo / Especificación">{{ $mat['especificacion'] }}</td>
              <td data-label="Presentación">{{ $mat['presentacion'] }}</td>
              <td class="cot-td-unidad" data-label="Unidad">{{ $mat['unidad'] ?: '—' }}</td>
              <td class="cot-td-cantidad" data-label="Cantidad">{{ number_format($mat['cantidad'], 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="cot-empty">Sin materiales registrados.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
@endsection
