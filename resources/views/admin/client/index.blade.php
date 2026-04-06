@extends('layouts.admin')
@section('page-title', __('cliente.clients'))

@section('content')
<div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-person-heart"></i> {{ __('cliente.clients') }}</h1>
        <a href="{{ route('admin.client.create') }}" class="um-btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('cliente.new_client') }}
        </a>
    </div>

    {{-- Search & Filters --}}
    <div class="um-card mb-4">
        <div class="um-card-header">
            <div class="d-flex gap-2 flex-wrap align-items-center w-100">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="{{ __('cliente.search_clients') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- cliente Cards Grid --}}
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
                    <span class="pj-meta-label">{{ __('cliente.cedula_label') }} </span>
                    <span class="pj-meta-value">
                        {{ $client->getCedula() }}
                    </span>
                </p>

                {{-- Correo --}}
                <div class="mb-3">
                    <span class="pj-meta-label">{{ __('cliente.email_label') }} </span>
                    <span class="pj-meta-value">
                        {{ $client->getCorreo() }}
                    </span>
                </div>

                {{-- Celular --}}
                <div class="mb-3">
                    <span class="pj-meta-label">{{ __('cliente.phone_label') }} </span>
                    <span class="pj-meta-value">
                        {{ $client->getCelular() }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="mt-auto d-flex gap-2">
                    <a href="{{ route('admin.client.show', ['id' => $client->getId()]) }}"
                       class="um-btn-icon um-btn-icon--view flex-fill justify-content-center py-2">
                        <i class="bi bi-eye me-1"></i> {{ __('cliente.view_projects') }}
                    </a>
                    <a href="{{ route('admin.client.edit', ['id' => $client->getId()]) }}"
                       class="um-btn-icon um-btn-icon--edit flex-fill justify-content-center py-2">
                        <i class="bi bi-pencil-fill me-1"></i> {{ __('cliente.edit') }}
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="um-empty">
                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                {{ __('cliente.no_clientes') }}
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($viewData['clients']->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $viewData['clientes']->links() }}
    </div>
    @endif

</div>
@endsection