@extends('layouts.admin')
@section('page-title', $viewData['project']->getNombre())
 
@section('content')
<div class="pj-wrapper">
 
    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-fill"></i> {{ $viewData['project']->getNombre() }}</h1>
        <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>
 
    {{-- Info General --}}
    <div class="um-card mb-4">
        <div class="um-card-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-folder2-open" style="color: #F5C800;"></i>
                <span class="um-card-title" style="font-size: 0.95rem;">Información del Proyecto</span>
            </div>
            <span class="pj-badge pj-badge--{{ str_replace(' ', '_', strtolower($viewData['project']->getEstado())) }}">
                {{ $viewData['project']->getEstado() }}
            </span>
        </div>
 
        <div class="row g-4 p-4">
            <div class="col-md-6">
                <p class="pj-field-label">Nombre</p>
                <p class="pj-field-value">{{ $viewData['project']->getNombre() }}</p>
            </div>
            <div class="col-md-6">
                <p class="pj-field-label"><i class="bi bi-geo-alt me-1"></i> Dirección</p>
                <p class="pj-field-value">{{ $viewData['project']->getDireccion() }}</p>
            </div>
            <div class="col-md-6">
                <p class="pj-field-label"><i class="bi bi-building me-1"></i> Ciudad</p>
                <p class="pj-field-value">{{ $viewData['project']->getCiudad() }}</p>
            </div>
            <div class="col-md-6">
                <p class="pj-field-label"><i class="bi bi-person"></i> Cliente</p>
                <p class="pj-field-value">{{ $viewData['project']->getCliente()->getNombre() . ' - CC: ' . $viewData['project']->getCliente()->getCedula() }}</p>
            </div>
            <div class="col-md-6">
                <p class="pj-field-label"><i class="bi bi-person-check-fill"></i> Creado por</p>
                <p class="pj-field-value">{{ $viewData['project']->getCreadoPorUser()->getName() }}</p>
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
                        <p class="pj-field-label mb-1">Cotizaciones</p>
                        <p class="pj-kpi-value">--</p>
                        <p class="pj-field-label mb-0">Total registradas</p>
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
                        <p class="pj-field-label mb-1">Facturas</p>
                        <p class="pj-kpi-value">--</p>
                        <p class="pj-field-label mb-0">Total procesadas</p>
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
                        <p class="pj-field-label mb-1">Costo Total vs Ejecutado</p>
                        <div class="d-flex align-items-end justify-content-between">
                            <p class="pj-kpi-value mb-0">$ --</p>
                            <p class="mb-0" style="font-size: 0.85rem; color: #4ade80; font-weight: 600;">
                                $ -- <span style="color: #5A5A5A; font-weight: 400;">ejecutado</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="pj-progress-track">
                    <div class="pj-progress-fill" style="width: 0%"></div>
                </div>
                <p class="pj-field-label mb-0 mt-2">0% del presupuesto utilizado</p>
            </div>
        </div>
 
    </div>
 
    {{-- Acciones --}}
    <div class="row g-3">
 
        {{-- Ver Gráficas --}}
        <div class="col-md-6">
            <a href="#" class="um-card pj-action-card p-4 d-flex align-items-center gap-3 text-decoration-none">
                <div class="pj-kpi-icon pj-kpi-icon--yellow">
                    <i class="bi bi-bar-chart-line"></i>
                </div>
                <div class="flex-fill">
                    <p class="pj-field-value mb-1">Ver Gráficas</p>
                    <p class="pj-field-label mb-0">Visualiza el progreso, costos y estadísticas del proyecto</p>
                </div>
                <i class="bi bi-arrow-right pj-action-arrow"></i>
            </a>
        </div>
 
        {{-- Ver Cotizaciones --}}
        <div class="col-md-6">
            <a href="#" class="um-card pj-action-card p-4 d-flex align-items-center gap-3 text-decoration-none">
                <div class="pj-kpi-icon pj-kpi-icon--blue">
                    <i class="bi bi-file-earmark-ruled"></i>
                </div>
                <div class="flex-fill">
                    <p class="pj-field-value mb-1">Ver Cotizaciones</p>
                    <p class="pj-field-label mb-0">Revisa y gestiona todas las cotizaciones asociadas</p>
                </div>
                <i class="bi bi-arrow-right pj-action-arrow"></i>
            </a>
        </div>
 
    </div>
 
</div>
@endsection