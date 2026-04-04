@extends('layouts.tecnico')
@section('page-title', 'Versiones — Cotización ' . $viewData['numeroCotizacion'])

@section('content')
<div class="pj-wrapper">

    <div class="um-header">
        <h1 class="um-title">
            <i class="bi bi-clipboard-data-fill me-2"></i>Cotización {{ $viewData['numeroCotizacion'] }} — Estado: {{ $viewData['cotizacion']->getEstado() }}
        </h1>
        <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Volver
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

    @php
        $versionActual = $viewData['versiones']->firstWhere('esLaMasReciente', true);
    @endphp

    @if($versionActual)
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('tecnico.cotizacion.edit', [$viewData['project']->getId(), $versionActual->getId()]) }}"
           class="um-btn-primary px-4 py-2">
            <i class="bi bi-clipboard-plus me-1"></i> Nueva Versión
        </a>
    </div>
    @endif

    <div class="cot-table-wrap">
        <table class="cot-table cot-versions-table">
            <thead>
                <tr>
                    <th>Versión</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($viewData['versiones'] as $version)
                <tr>
                    <td data-label="Versión">
                        <span class="cot-version-number">V{{ $version->getNumeroVersion() }}</span>
                        @if($version->getEsLaMasReciente())
                            <span class="cot-counter ms-1">Actual</span>
                        @endif
                    </td>
                    <td class="cot-td-date" data-label="Fecha">{{ $version->getCreatedAt() }}</td>
                    <td class="cot-td-actions" data-label="Acciones">
                        <a href="{{ route('tecnico.cotizacion.show', [$viewData['project']->getId(), $version->getId()]) }}"
                           class="um-btn-icon um-btn-icon--edit px-3 py-1">
                            <i class="bi bi-eye me-1"></i> Ver detalle
                        </a>
                        @if(!$version->getEsLaMasReciente() && $version->getNumeroVersion() !== '1')
                        <a href="{{ route('tecnico.cotizacion.pdfView', [$viewData['project']->getId(), $version->getId()]) }}"
                           class="um-btn-icon um-btn-icon--edit px-3 py-1 ms-1">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Ver PDF
                        </a>
                        @endif
                        @if($version->getEsLaMasReciente())
                        <a href="{{ route('tecnico.cotizacion.edit', [$viewData['project']->getId(), $version->getId()]) }}"
                           class="um-btn-icon um-btn-icon--edit px-3 py-1 ms-1">
                            <i class="bi bi-pencil-square me-1"></i> Editar materiales
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="cot-empty">
                        <i class="bi bi-clipboard-x cot-empty-icon d-block mb-1"></i>
                        Esta cotización no tiene versiones aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
