@extends('layouts.admin')
@section('page-title', $viewData['project']->getName())

@section('content')
  <div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-folder-fill"></i> {{ $viewData['project']->getName() }}</h1>
      <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('proyecto.back') }}
      </a>
    </div>

    {{-- Info General --}}
    <div class="um-card mb-4">
      <div class="um-card-header">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-folder2-open pj-header-icon"></i>
          <span class="um-card-title um-card-title--sm">{{ __('proyecto.project_info') }}</span>
        </div>
        <span
          class="pj-badge pj-badge--{{ match ($viewData['project']->getStatus()) {'Negotiation' => 'negociacion','In Progress' => 'ejecucion',default => 'finalizado'} }}">
          {{ match ($viewData['project']->getStatus()) {
              'Negotiation' => __('proyecto.status_negotiation'),
              'In Progress' => __('proyecto.status_in_progress'),
              default => __('proyecto.status_completed'),
          } }}
        </span>
      </div>

      <div class="row g-4 p-4">
        <div class="col-md-6">
          <p class="pj-field-label">{{ __('proyecto.name') }}</p>
          <p class="pj-field-value">{{ $viewData['project']->getName() }}</p>
        </div>
        <div class="col-md-6">
          <p class="pj-field-label"><i class="bi bi-geo-alt me-1"></i> {{ __('proyecto.address') }}</p>
          <p class="pj-field-value">{{ $viewData['project']->getAddress() }}</p>
        </div>
        <div class="col-md-6">
          <p class="pj-field-label"><i class="bi bi-building me-1"></i> {{ __('proyecto.city') }}</p>
          <p class="pj-field-value">{{ $viewData['project']->getCity() }}</p>
        </div>
        <div class="col-md-6">
          <p class="pj-field-label"><i class="bi bi-person"></i> {{ __('proyecto.client') }}</p>
          <p class="pj-field-value">
            {{ $viewData['project']->getClient()->getName() . ' - ' . __('proyecto.cc_label') . ' ' . $viewData['project']->getClient()->getIdNumber() }}
          </p>
        </div>
        <div class="col-md-6">
          <p class="pj-field-label"><i class="bi bi-person-check-fill"></i> {{ __('proyecto.created_by') }}</p>
          <p class="pj-field-value">{{ $viewData['project']->getCreatedByUser()->getName() }}</p>
        </div>
      </div>
    </div>

    {{-- KPIs --}}
    <div class="row g-3 mb-4">

      {{-- Cotizaciones --}}
      <div class="col-md-4">
        <div class="um-card p-4 h-100">
          <div class="d-flex align-items-center gap-3">
            <div class="pj-kpi-icon pj-kpi-icon--blue">
              <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
              <p class="pj-field-label mb-1">{{ __('proyecto.quotations') }}</p>
              <p class="pj-kpi-value">--</p>
              <p class="pj-field-label mb-0">{{ __('proyecto.total_registered') }}</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Facturas --}}
      <div class="col-md-4">
        <div class="um-card p-4 h-100">
          <div class="d-flex align-items-center gap-3">
            <div class="pj-kpi-icon pj-kpi-icon--purple">
              <i class="bi bi-receipt"></i>
            </div>
            <div>
              <p class="pj-field-label mb-1">{{ __('proyecto.invoices') }}</p>
              <p class="pj-kpi-value">--</p>
              <p class="pj-field-label mb-0">{{ __('proyecto.total_processed') }}</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Costo --}}
      <div class="col-md-4">
        <div class="um-card p-4 h-100">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="pj-kpi-icon pj-kpi-icon--yellow">
              <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="flex-fill">
              <p class="pj-field-label mb-1">{{ __('proyecto.cost_vs_executed') }}</p>
              <div class="d-flex align-items-end justify-content-between">
                <p class="pj-kpi-value mb-0">$ --</p>
                <p class="mb-0 pj-kpi-executed">
                  $ -- <span class="pj-kpi-executed-suffix">{{ __('proyecto.executed') }}</span>
                </p>
              </div>
            </div>
          </div>
          <div class="pj-progress-track">
            <div class="pj-progress-fill"></div>
          </div>
          <p class="pj-field-label mb-0 mt-2">{{ __('proyecto.budget_used') }}</p>
        </div>
      </div>

    </div>

    {{-- Acciones --}}
    <div class="row g-3">

      {{-- Ver Gráficas --}}
      <div class="col-md-4">
        <a href="#" class="um-card pj-action-card p-4 d-flex align-items-center gap-3 text-decoration-none">
          <div class="pj-kpi-icon pj-kpi-icon--yellow">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="flex-fill">
            <p class="pj-field-value mb-1">{{ __('proyecto.view_charts') }}</p>
            <p class="pj-field-label mb-0">{{ __('proyecto.charts_desc') }}</p>
          </div>
          <i class="bi bi-arrow-right pj-action-arrow"></i>
        </a>
      </div>

      {{-- Ver Cotizaciones --}}
      <div class="col-md-4">
        <a href="{{ route('admin.project.showQuotations', $viewData['project']->getId()) }}"
          class="um-card pj-action-card p-4 d-flex align-items-center gap-3 text-decoration-none">
          <div class="pj-kpi-icon pj-kpi-icon--blue">
            <i class="bi bi-file-earmark-ruled"></i>
          </div>
          <div class="flex-fill">
            <p class="pj-field-value mb-1">{{ __('proyecto.view_quotations') }}</p>
            <p class="pj-field-label mb-0">{{ __('proyecto.quotations_desc') }}</p>
          </div>
          <i class="bi bi-arrow-right pj-action-arrow"></i>
        </a>
      </div>

      {{-- OCR --}}
      <div class="col-md-4">
        <a href="{{ route('admin.invoice.index') }}"
          class="um-card pj-action-card p-4 d-flex align-items-center gap-3 text-decoration-none">
          <div class="pj-kpi-icon pj-kpi-icon--green">
            <i class="bi bi-file-earmark-richtext"></i>
          </div>
          <div class="flex-fill">
            <p class="pj-field-value mb-1">{{ __('proyecto.process_invoice_ocr') }}</p>
            <p class="pj-field-label mb-0">{{ __('proyecto.ocr_desc') }}</p>
          </div>
          <i class="bi bi-arrow-right pj-action-arrow"></i>
        </a>
      </div>

    </div>

  </div>
@endsection
