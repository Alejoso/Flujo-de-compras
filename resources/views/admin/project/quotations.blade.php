@extends('layouts.admin')
@section('page-title', __('proyecto.view_quotations'))

@push('styles')
  <link href="{{ asset('css/tecnico.css') }}" rel="stylesheet">
@endpush

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-clipboard-data-fill me-2"></i>{{ __('proyecto.view_quotations') }}</h1>
      <a href="{{ route('admin.project.show', $viewData['project']->getId()) }}"
        class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('proyecto.back') }}
      </a>
    </div>

    <div class="cot-header-card mb-4 text-center">
      <p class="cot-project-label mb-1"><i class="bi bi-folder-fill cot-icon-primary me-1"></i>{{ __('tecnico_cotizacion.label_project') }}</p>
      <h2 class="cot-project-title mb-2">{{ $viewData['project']->getName() }}</h2>
      <span class="cot-estado-label cot-estado--{{ str_replace(' ', '-', strtolower($viewData['project']->getStatus())) }}">
        {{ match($viewData['project']->getStatus()) {
            'Negotiation' => __('proyecto.status_negotiation'),
            'In Progress'  => __('proyecto.status_in_progress'),
            default        => __('proyecto.status_completed'),
        } }}
      </span>
      <div class="cot-project-details justify-content-center mt-3">
        <span><i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCity() }}, {{ $viewData['project']->getAddress() }}</span>
        @if($viewData['project']->getClient())
          <span><i class="bi bi-building me-1"></i>{{ $viewData['project']->getClient()->getName() }}</span>
        @endif
        @if($viewData['project']->getTotalCost())
          <span><i class="bi bi-cash-stack me-1"></i>$ {{ number_format($viewData['project']->getTotalCost(), 0, ',', '.') }}</span>
        @endif
        <span><i class="bi bi-clipboard-data me-1"></i>{{ $viewData['quotations']->count() }} {{ $viewData['quotations']->count() === 1 ? __('tecnico_cotizacion.version_singular') : __('tecnico_cotizacion.label_quotations') }}</span>
      </div>
    </div>

    @if ($viewData['quotations']->isEmpty())
      <div class="cot-table-wrap">
        <div class="cot-empty py-4 text-center">
          <i class="bi bi-clipboard-x cot-empty-icon d-block mb-1"></i>
          {{ __('proyecto.no_quotations_registered') }}
        </div>
      </div>
    @else
      <div class="row g-3">
        @foreach ($viewData['quotations'] as $cotizacion)
          <div class="col-sm-6 col-lg-4">
            <div class="cot-card h-100">
              <div class="cot-card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <span class="cot-version-number">{{ __('proyecto.quotation') }} {{ $loop->iteration }}</span>
                  <span class="cot-estado-label cot-estado--{{ str_replace(' ', '-', strtolower($cotizacion->getStatus())) }}">
                    {{ match ($cotizacion->getStatus()) {
                        'Technician' => __('tecnico_cotizacion.status_technician'),
                        'Technician Edited' => __('tecnico_cotizacion.status_technician_edited'),
                        'Pending' => __('tecnico_cotizacion.status_pending'),
                        'Admin Edited' => __('tecnico_cotizacion.status_admin_edited'),
                        'In Process' => __('tecnico_cotizacion.status_in_process'),
                        'Invoiced' => __('tecnico_cotizacion.status_invoiced'),
                        default => __('tecnico_cotizacion.status_cancelled'),
                    } }}
                  </span>
                </div>
                <p class="cot-project-meta mb-1">
                  <i class="bi bi-layers me-1"></i>
                  {{ $cotizacion->quotation_versions_count }}
                  {{ $cotizacion->quotation_versions_count === 1
                      ? __('proyecto.version_singular')
                      : __('proyecto.version_plural') }}
                </p>
                <p class="cot-project-meta mb-1">
                  <i class="bi bi-calendar3 me-1"></i>{{ $cotizacion->getCreatedAt() }}
                </p>
                <p class="cot-project-meta mb-3">
                  <i class="bi bi-person me-1"></i>{{ $cotizacion->getCreator()->getName() }}
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
