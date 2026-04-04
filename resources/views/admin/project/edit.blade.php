@extends('layouts.admin')
@section('page-title', 'Editar un proyecto')

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-plus me-2"></i>Editar un proyecto</h1>
        <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="um-card">
                <div class="um-card-header">
                    <div>
                        <p class="um-card-title">Editar el proyecto {{ $viewData['project']->getNombre() }}</p>
                        <p class="um-card-subtitle">Actualiza la información</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.project.update' , ['id' => $viewData['project']->getId() ]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            {{-- Nombre --}}
                            <div class="col-12">
                                <label class="form-label">Nombre</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{  $viewData['project']->getNombre() }}"
                                       placeholder="Ej: Renovación de oficinas">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dirección --}}
                            <div class="col-12">
                                <label class="form-label">Dirección</label>
                                <input type="text"
                                       name="direccion"
                                       class="form-control @error('direccion') is-invalid @enderror"
                                       value="{{ $viewData['project']->getDireccion() }}"
                                       placeholder="Ej: Calle 10 #45-20">
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ciudad --}}
                            <div class="col-md-6">
                                <label class="form-label">Ciudad</label>
                                <input type="text"
                                       name="ciudad"
                                       class="form-control @error('ciudad') is-invalid @enderror"
                                       value="{{ $viewData['project']->getCiudad() }}"
                                       placeholder="Ej: Medellín">
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Costo Total --}}
                            <div class="col-md-6">
                                <label class="form-label">Costo Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number"
                                           name="costoTotal"
                                           class="form-control @error('costoTotal') is-invalid @enderror"
                                           value="{{ $viewData['project']->getCostoTotal() }}"
                                           step="0.01"
                                           min="0"
                                           placeholder="0.00">
                                    @error('costoTotal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Cliente --}}
                            <div class="col-md-6">
                                <label class="form-label">Cliente</label>
                                <select name="clienteId"
                                        class="form-select @error('clienteId') is-invalid @enderror">
                                    <option value="{{  $viewData['project']->getCliente()->getId() }}">{{ $viewData['project']->getCliente()->getNombre() }}</option>
                                    @foreach($viewData['clients'] as $client)
                                        <option value="{{ $client->getId() }}">
                                            {{ $client->getNombre() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('clienteId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.project.index') }}"
                               class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                Cancelar
                            </a>
                            <button type="submit" class="um-btn-primary">
                                <i class="bi bi-floppy me-1"></i> Editar Proyecto
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection