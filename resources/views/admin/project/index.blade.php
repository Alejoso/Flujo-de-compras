@extends('layouts.admin')
@section('page-title', __('proyecto.projects'))

@section('content')
<div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-fill me-2"></i>{{ __('proyecto.projects') }}</h1>
        <a href="{{ route('admin.project.create') }}" class="um-btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('proyecto.new_project') }}
        </a>
    </div>

    {{-- Search & Filters --}}
    <div class="um-card mb-4">
        <div class="um-card-header">
            <form method="GET" action="{{ route('admin.project.index') }}" class="d-flex gap-2 flex-wrap align-items-center w-100">
                @if($viewData['estado'])
                    <input type="hidden" name="estado" value="{{ $viewData['estado'] }}">
                @endif
                <div class="input-group search-group">
                    <button type="submit" class="input-group-text border-0 bg-transparent"><i class="bi bi-search"></i></button>
                    <input type="text" name="search" value="{{ $viewData['search'] }}" class="form-control" placeholder="{{ __('proyecto.search_projects') }}">
                </div>
                <div class="d-flex gap-2 ms-auto flex-wrap">
                    <a href="{{ request()->fullUrlWithQuery(['estado' => '', 'page' => null]) }}"
                       class="{{ $viewData['estado'] === '' ? 'um-btn-primary' : 'um-btn-filter' }}">
                        {{ __('proyecto.all') }}
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['estado' => __('proyecto.estado_negociacion'), 'page' => null]) }}"
                       class="{{ $viewData['estado'] === __('proyecto.estado_negociacion') ? 'um-btn-primary' : 'um-btn-filter' }}">
                        {{ __('proyecto.in_negotiation') }}
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['estado' => __('proyecto.estado_ejecucion'), 'page' => null]) }}"
                       class="{{ $viewData['estado'] === __('proyecto.estado_ejecucion') ? 'um-btn-primary' : 'um-btn-filter' }}">
                        {{ __('proyecto.in_progress') }}
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['estado' => __('proyecto.estado_finalizado'), 'page' => null]) }}"
                       class="{{ $viewData['estado'] === __('proyecto.estado_finalizado') ? 'um-btn-primary' : 'um-btn-filter' }}">
                        {{ __('proyecto.finished') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- proyecto Cards Grid --}}
    <div class="row g-4">
        @forelse($viewData['projects'] as $proyecto)
        <div class="col-md-6 col-xl-4">
            <div class="pj-card">

                {{-- Title and status--}}
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <h5 class="pj-title">{{ $proyecto->getNombre() }}</h5>
                    <span class="pj-badge pj-badge--{{ match($proyecto->getEstado()) { 'En Negociación' => 'negociacion', 'En Ejecución' => 'ejecucion', default => 'finalizado' } }}">
                        {{ $proyecto->getEstado() }}
                    </span>
                </div>

                {{-- Location --}}
                <p class="pj-location">
                    <i class="bi bi-geo-alt me-1"></i>
                    {{ $proyecto->getCiudad() }} — {{ $proyecto->getDireccion() }}
                </p>

                {{-- Cost --}}
                <div class="mb-3">
                    <span class="pj-meta-label">{{ __('proyecto.total_cost_label') }} </span>
                    <span class="pj-meta-value">
                        {{ $proyecto->getCostoTotal() ? '$ ' . number_format($proyecto->getCostoTotal(), 0, ',', '.') : '—' }}
                    </span>
                </div>

                {{-- Client --}}
                <div class="mb-3">
                    <span class="pj-meta-label">{{ __('proyecto.client_label') }} </span>
                    <span class="pj-meta-value">
                        {{ $proyecto->getCliente()->getNombre() . ' - ' . __('proyecto.cc_label') . ' ' . $proyecto->getCliente()->getCedula()}}
                    </span>
                </div>

                {{-- Creado por --}}
                <div class="mb-3">
                    <span class="pj-meta-label">{{ __('proyecto.created_by') }} </span>
                    <span class="pj-meta-value">
                        {{ $proyecto->getCreadoPorUser()->getName() }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="mt-auto d-flex gap-2">
                    <a href="{{ route('admin.project.show', ['id' => $proyecto->getId()]) }}"
                       class="um-btn-icon um-btn-icon--view flex-fill justify-content-center py-2">
                        <i class="bi bi-eye me-1"></i> {{ __('proyecto.view_details') }}
                    </a>
                    <a href="{{ route('admin.project.edit', ['id' => $proyecto->getId()]) }}"
                       class="um-btn-icon um-btn-icon--edit flex-fill justify-content-center py-2">
                        <i class="bi bi-pencil-fill me-1"></i> {{ __('proyecto.edit') }}
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="um-empty">
                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                {{ __('proyecto.no_projects') }}
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($viewData['projects']->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $viewData['projects']->links() }}
    </div>
    @endif

</div>
@endsection