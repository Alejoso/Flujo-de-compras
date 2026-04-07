@extends('layouts.admin')
@section('page-title', __('proyecto.view_quotations'))

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-clipboard-data-fill me-2"></i>{{ __('proyecto.view_quotations') }}</h1>
      <a href="{{ route('admin.project.show', $viewData['project']->getId()) }}"
        class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('proyecto.back') }}
      </a>
    </div>

    <div class="cot-header-card mb-4">
      <p class="cot-project-name">
        <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
      </p>
      <p class="cot-project-meta">
        <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCiudad() }} —
        {{ $viewData['project']->getDireccion() }}
      </p>
    </div>

    @if ($viewData['cotizaciones']->isEmpty())
      <div class="cot-table-wrap">
        <div class="cot-empty py-4 text-center">
          <i class="bi bi-clipboard-x cot-empty-icon d-block mb-1"></i>
          {{ __('proyecto.no_quotations_registered') }}
        </div>
      </div>
    @else
      <div class="row g-3">
        @foreach ($viewData['cotizaciones'] as $cotizacion)
          <div class="col-sm-6 col-lg-4">
            <div class="cot-card h-100">
              <div class="cot-card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <span class="cot-version-number">{{ __('proyecto.quotation') }} {{ $loop->iteration }}</span>
                  <span
                    class="cot-estado-label cot-estado--{{ str_replace(' ', '-', strtolower($cotizacion->getEstado())) }}">{{ $cotizacion->getEstado() }}</span>
                </div>
                <p class="cot-project-meta mb-1">
                  <i class="bi bi-layers me-1"></i>
                  {{ $cotizacion->version_cotizaciones_count }}
                  {{ $cotizacion->version_cotizaciones_count === 1
                      ? __('proyecto.version_singular')
                      : __('proyecto.version_plural') }}
                </p>
                <p class="cot-project-meta mb-1">
                  <i class="bi bi-calendar3 me-1"></i>{{ $cotizacion->getCreatedAt() }}
                </p>
                <p class="cot-project-meta mb-3">
                  <i class="bi bi-person me-1"></i>{{ $cotizacion->creador->getName() }}
                </p>
                <a href="#" class="um-btn-icon um-btn-icon--edit px-3 py-1 w-100 text-center">
                  <i class="bi bi-list-ul me-1"></i> {{ __('proyecto.view_versions') }}
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

  </div>
@endsection
