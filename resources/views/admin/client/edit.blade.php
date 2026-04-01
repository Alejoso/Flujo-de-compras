@extends('layouts.admin')
@section('page-title', 'Editar cliente')

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-pencil-fill"></i> Editar cliente</h1>
        <a href="{{ route('admin.client.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="um-card">
                <div class="um-card-header">
                    <div>
                        <p class="um-card-title">Información del cliente {{ $viewData['client']->getNombre() }}</p>
                        <p class="um-card-subtitle">Actualiza la información</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.client.update' , ['id' => $viewData['client']->getId() ]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            {{-- Nombre --}}
                            <div class="col-12">
                                <label class="form-label">Nombre</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ $viewData['client']->getNombre() }}"
                                       placeholder="Ej: Carlos">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Cedula --}}
                            <div class="col-12">
                                <label class="form-label">Cedula</label>
                                <input type="text"
                                       name="cedula"
                                       class="form-control @error('cedula') is-invalid @enderror"
                                       value="{{ $viewData['client']->getCedula() }}"
                                       placeholder="Ej: 10179294...">
                                @error('cedula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Correo --}}
                            <div class="col-md-6">
                                <label class="form-label">Correo</label>
                                <input type="email"
                                       name="correo"
                                       class="form-control @error('correo') is-invalid @enderror"
                                       value="{{ $viewData['client']->getCorreo() }}"
                                       placeholder="Ej: simon@gmail.com">
                                @error('correo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Celular --}}
                            <div class="col-md-6">
                                <label class="form-label">Numero de celular</label>
                                <div class="input-group">
                                    <input type="string"
                                           name="celular"
                                           class="form-control @error('celular') is-invalid @enderror"
                                           value="{{ $viewData['client']->getCelular() }}"
                                           placeholder="Ej: 3215027448">
                                    @error('celular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center gap-2 mt-4">

                            {{-- Eliminar --}}
                            <form action="{{ route('admin.client.destroy', $viewData['client']->getId()) }} "method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="um-btn-icon um-btn-icon--delete px-3 py-2">
                                    <i class="bi bi-trash me-1"></i> Eliminar
                                </button>
                                
                            </form>

                            {{-- Cancelar + Guardar --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.client.index') }}"
                                class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                    Cancelar
                                </a>
                                <button type="submit" class="um-btn-primary">
                                    <i class="bi bi-floppy me-1"></i> Editar cliente
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection