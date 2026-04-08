@extends('layouts.tecnico')
@section('page-title', __('proyecto.projects'))

@section('content')
<div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-fill me-2"></i>{{ __('proyecto.projects') }}</h1>
    </div>

    {{-- Search & Filters --}}
    <div class="um-card mb-4">
        <div class="um-card-header">
            <form method="GET" action="{{ route('tecnico.project.index') }}" class="d-flex gap-2 flex-wrap align-items-center w-100">
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
        @forelse($viewData['projects'] as $project)
        <div class="col-md-6 col-xl-4">
            <div class="pj-card">

                {{-- Title and status --}}
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <h5 class="pj-title">{{ $project->getNombre() }}</h5>
                    <span class="pj-badge pj-badge--{{ match($project->getEstado()) { 'En Negociación' => 'negociacion', 'En Ejecución' => 'ejecucion', default => 'finalizado' } }}">
                        {{ $project->getEstado() }}
                    </span>
                </div>

                {{-- Location --}}
                <p class="pj-location">
                    <i class="bi bi-geo-alt me-1"></i>
                    {{ $project->getCiudad() }} — {{ $project->getDireccion() }}
                </p>

                {{-- Buttons --}}
                <div class="mt-auto d-flex gap-2">
                    <a href="{{ route('tecnico.cotizacion.index', $project->getId()) }}"
                       class="um-btn-icon um-btn-icon--edit flex-fill d-flex justify-content-center py-2">
                        <i class="bi bi-clipboard-data me-1"></i> {{ __('proyecto.view_quotations_short') }}
                    </a>
                    <a href="{{ route('tecnico.cotizacion.create', $project->getId()) }}"
                       class="um-btn-primary flex-fill d-flex justify-content-center py-2">
                        <i class="bi bi-clipboard-plus me-1"></i> {{ __('proyecto.new') }}
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