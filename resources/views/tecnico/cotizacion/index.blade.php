@extends('layouts.tecnico')
@section('page-title', __('tecnico_cotizacion.title_index'))

@section('content')
<div class="pj-wrapper">

    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-clipboard-data-fill me-2"></i>{{ __('tecnico_cotizacion.title_index') }}</h1>
        <a href="{{ route('tecnico.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> {{ __('tecnico_cotizacion.btn_back') }}
        </a>
    </div>

    <div class="cot-header-card mb-4">
        <p class="cot-project-name">
            <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
        </p>
        <p class="cot-project-meta">
            <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCiudad() }} — {{ $viewData['project']->getDireccion() }}
        </p>
    </div>

    @if(session('success'))
    <div class="alert mb-3 cot-alert-success">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('tecnico.cotizacion.create', $viewData['project']->getId()) }}" class="um-btn-primary px-4 py-2">
            <i class="bi bi-clipboard-plus me-1"></i> {{ __('tecnico_cotizacion.btn_new_quote') }}
        </a>
    </div>

    @if($viewData['cotizaciones']->isEmpty())
    <div class="cot-table-wrap">
        <div class="cot-empty py-4 text-center">
            <i class="bi bi-clipboard-x cot-empty-icon d-block mb-1"></i>
            {{ __('tecnico_cotizacion.msg_empty_cotizaciones') }}
        </div>
    </div>
    @else
    <div class="row g-3">
        @foreach($viewData['cotizaciones'] as $cotizacion)
        <div class="col-sm-6 col-lg-4">
            <div class="cot-card h-100">
                <div class="cot-card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="cot-version-number">{{ __('tecnico_cotizacion.title_index') }} {{ $loop->iteration }}</span>
                        <span class="cot-estado-label cot-estado--{{ str_replace(' ', '-', strtolower($cotizacion->getEstado())) }}">{{ $cotizacion->getEstado() }}</span>
                    </div>
                    <p class="cot-project-meta mb-1">
                        <i class="bi bi-layers me-1"></i>
                        {{ $cotizacion->version_cotizaciones_count }}
                        {{ $cotizacion->version_cotizaciones_count === 1
                            ? __('tecnico_cotizacion.version_singular')
                            : __('tecnico_cotizacion.version_plural') }}
                    </p>
                    <p class="cot-project-meta mb-1">
                        <i class="bi bi-calendar3 me-1"></i>{{ $cotizacion->getCreatedAt() }}
                    </p>
                    <p class="cot-project-meta mb-3">
                        <i class="bi bi-person me-1"></i>{{ $cotizacion->getCreadoPor()->getName() }}
                    </p>
                    <a href="{{ route('tecnico.cotizacion.versions', [$viewData['project']->getId(), $cotizacion->getId()]) }}"
                       class="um-btn-icon um-btn-icon--edit px-3 py-1 w-100 text-center">
                        <i class="bi bi-list-ul me-1"></i> {{ __('tecnico_cotizacion.btn_view_versions') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
