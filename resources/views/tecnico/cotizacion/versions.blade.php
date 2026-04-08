@extends('layouts.tecnico')
@section('page-title', __('tecnico_cotizacion.title_versions', ['number' => $viewData['numeroCotizacion']]))

@section('content')
<div class="pj-wrapper">

    <div class="um-header">
        <h1 class="um-title">
            <i class="bi bi-clipboard-data-fill me-2"></i>
            {{ __('tecnico_cotizacion.title_index') }} {{ $viewData['numeroCotizacion'] }}
            <span class="cot-estado-label cot-estado--{{ str_replace(' ', '-', strtolower($viewData['cotizacion']->getEstado())) }}">{{ $viewData['cotizacion']->getEstado() }}</span>
        </h1>
        <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
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

    @if($viewData['versionActual'])
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('tecnico.cotizacion.edit', [$viewData['project']->getId(), $viewData['versionActual']->getId()]) }}"
           class="um-btn-primary px-4 py-2">
            <i class="bi bi-clipboard-plus me-1"></i> {{ __('tecnico_cotizacion.btn_new_version') }}
        </a>
    </div>
    @endif

    <div class="cot-table-wrap">
        <table class="cot-table cot-versions-table">
            <thead>
                <tr>
                    <th>{{ __('tecnico_cotizacion.label_version') }}</th>
                    <th>{{ __('tecnico_cotizacion.label_date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($viewData['versiones'] as $version)
                <tr>
                    <td data-label="{{ __('tecnico_cotizacion.label_version') }}">
                        <span class="cot-version-number">V{{ $version->getNumeroVersion() }}</span>
                        @if($version->getEsLaMasReciente())
                            <span class="cot-counter ms-1">{{ __('tecnico_cotizacion.label_current') }}</span>
                        @endif
                    </td>
                    <td class="cot-td-date" data-label="{{ __('tecnico_cotizacion.label_date') }}">{{ $version->getCreatedAt() }}</td>
                    <td class="cot-td-actions" data-label="{{ __('tecnico_cotizacion.th_actions') }}">
                        <a href="{{ route('tecnico.cotizacion.show', [$viewData['project']->getId(), $version->getId()]) }}"
                           class="um-btn-icon um-btn-icon--edit px-3 py-1">
                            <i class="bi bi-eye me-1"></i> {{ __('tecnico_cotizacion.btn_view_detail') }}
                        </a>
                        @if(!$version->getEsLaMasReciente() && $version->getNumeroVersion() !== '1')
                        <a href="{{ route('tecnico.cotizacion.pdfView', [$viewData['project']->getId(), $version->getId()]) }}"
                           class="um-btn-icon um-btn-icon--edit px-3 py-1 ms-1">
                            <i class="bi bi-file-earmark-pdf me-1"></i> {{ __('tecnico_cotizacion.btn_view_pdf') }}
                        </a>
                        @endif
                        @if($version->getEsLaMasReciente())
                        <a href="{{ route('tecnico.cotizacion.edit', [$viewData['project']->getId(), $version->getId()]) }}"
                           class="um-btn-icon um-btn-icon--edit px-3 py-1 ms-1">
                            <i class="bi bi-pencil-square me-1"></i> {{ __('tecnico_cotizacion.btn_edit_materials') }}
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="cot-empty">
                        <i class="bi bi-clipboard-x cot-empty-icon d-block mb-1"></i>
                        {{ __('tecnico_cotizacion.msg_empty_versiones') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
