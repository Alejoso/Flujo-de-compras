@extends('layouts.admin')
@section('page-title', 'Nuevo Proyecto')

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-plus me-2"></i>Nuevo Proyecto</h1>
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
                        <p class="um-card-title">Información del Proyecto</p>
                        <p class="um-card-subtitle">Completa los campos para registrar el proyecto</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.project.save') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- Nombre --}}
                            <div class="col-12">
                                <label class="form-label">Nombre</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ $viewData['project'] }}"
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
                                       value="{{ old('direccion') }}"
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
                                       class="form-control @error('cuidad') is-invalid @enderror"
                                       value="{{ old('cuidad') }}"
                                       placeholder="Ej: Medellín">
                                @error('cuidad')
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
                                           class="form-control @error('costo_total') is-invalid @enderror"
                                           value="{{ old('costo_total') }}"
                                           step="0.01"
                                           min="0"
                                           placeholder="0.00">
                                    @error('costo_total')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.project.index') }}"
                               class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                Cancelar
                            </a>
                            <button type="submit" class="um-btn-primary">
                                <i class="bi bi-floppy me-1"></i> Guardar Proyecto
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection