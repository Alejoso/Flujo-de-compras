@extends('layouts.admin')
@section('page-title', 'Proyectos')

@section('content')
<div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-fill me-2"></i>Proyectos</h1>
        <a href="{{ route('admin.project.create') }}" class="um-btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo Proyecto
        </a>
    </div>

    {{-- Search & Filters --}}
    <div class="um-card mb-4">
        <div class="um-card-header">
            <div class="d-flex gap-2 flex-wrap align-items-center w-100">
                <div class="input-group" style="max-width: 420px;">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar proyectos...">
                </div>
                <div class="d-flex gap-2 ms-auto flex-wrap">
                    <button class="um-btn-primary">Todos</button>
                    <button class="um-btn-filter">En negociación</button>
                    <button class="um-btn-filter">En ejecución</button>
                    <button class="um-btn-filter">Finalizado</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Project Cards Grid --}}
    <div class="row g-4">
        @forelse($viewData['projects'] as $project)
        <div class="col-md-6 col-xl-4">
            <div class="pj-card">

                {{-- Title and status--}}
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <h5 class="pj-title">{{ $project->getNombre() }}</h5>
                    <span class="pj-badge pj-badge--{{ str_replace(' ', '_', strtolower($project->getEstado())) }}">
                        {{ $project->getEstado() }}
                    </span>
                </div>

                {{-- Location --}}
                <p class="pj-location">
                    <i class="bi bi-geo-alt me-1"></i>
                    {{ $project->getCiudad() }} — {{ $project->getDireccion() }}
                </p>

                {{-- Cost --}}
                <div class="mb-3">
                    <span class="pj-meta-label">Costo total: </span>
                    <span class="pj-meta-value">
                        {{ $project->getCostoTotal() ? '$ ' . number_format($project->getCostoTotal(), 0, ',', '.') : '—' }}
                    </span>
                </div>

                {{-- Client --}}
                <div class="mb-3">
                    <span class="pj-meta-label">Cliente: </span>
                    <span class="pj-meta-value">
                        {{ $project->getCliente()->getNombre() . ' - CC: ' . $project->getCliente()->getCedula()}}
                    </span>
                </div>

                {{-- Creado por --}}
                <div class="mb-3">
                    <span class="pj-meta-label">Creado por: </span>
                    <span class="pj-meta-value">
                        {{ $project->getCreadoPorUser()->getName() }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="mt-auto d-flex gap-2">
                    <a href="{{ route('admin.project.show', ['id' => $project->getId()]) }}"
                       class="um-btn-icon um-btn-icon--view flex-fill justify-content-center py-2">
                        <i class="bi bi-eye me-1"></i> Ver Detalles
                    </a>
                    <a href="{{ route('admin.project.edit', ['id' => $project->getId()]) }}"
                       class="um-btn-icon um-btn-icon--edit flex-fill justify-content-center py-2">
                        <i class="bi bi-pencil-fill me-1"></i> Editar
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="um-empty">
                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                No hay proyectos registrados aún.
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