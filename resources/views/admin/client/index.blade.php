@extends('layouts.admin')
@section('page-title', 'Clientes')

@section('content')
<div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-person-heart"></i> Clientes</h1>
        <a href="{{ route('admin.client.create') }}" class="um-btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo cliente
        </a>
    </div>

    {{-- Search & Filters --}}
    <div class="um-card mb-4">
        <div class="um-card-header">
            <div class="d-flex gap-2 flex-wrap align-items-center w-100">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar clientes...">
                </div>
            </div>
        </div>
    </div>

    {{-- client Cards Grid --}}
    <div class="row g-4">
        @forelse($viewData['clients'] as $client)
        <div class="col-md-6 col-xl-4">
            <div class="pj-card">

                {{-- Nombre --}}
                <div class="d-flex justify-content-center align-items-start mb-1">
                    <h5 class="pj-title">{{ $client->getNombre() }}</h5>
                </div>

                {{-- Cedula --}}
                <p class="mb-3">
                    <span class="pj-meta-label">Cedula: </span>
                    <span class="pj-meta-value">
                        {{ $client->getCedula() }}
                    </span>
                </p>

                {{-- Correo --}}
                <div class="mb-3">
                    <span class="pj-meta-label">Correo: </span>
                    <span class="pj-meta-value">
                        {{ $client->getCorreo() }}
                    </span>
                </div>

                {{-- Celular --}}
                <div class="mb-3">
                    <span class="pj-meta-label">Celular: </span>
                    <span class="pj-meta-value">
                        {{ $client->getCelular() }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="mt-auto d-flex gap-2">
                    <a href="{{ route('admin.client.show', ['id' => $client->getId()]) }}"
                       class="um-btn-icon um-btn-icon--view flex-fill justify-content-center py-2">
                        <i class="bi bi-eye me-1"></i> Ver proyectos
                    </a>
                    <a href="{{ route('admin.client.edit', ['id' => $client->getId()]) }}"
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
                No hay clientes registrados aún.
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($viewData['clients']->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $viewData['clients']->links() }}
    </div>
    @endif

</div>
@endsection