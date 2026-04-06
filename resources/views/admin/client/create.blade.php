@extends('layouts.admin')
@section('page-title', __('cliente.new_client'))

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-person-heart"></i> {{ __('cliente.new_client') }}</h1>
        <a href="{{ route('admin.client.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> {{ __('cliente.back') }}
        </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="um-card">
                <div class="um-card-header">
                    <div>
                        <p class="um-card-title">{{ __('cliente.client_info') }}</p>
                        <p class="um-card-subtitle">{{ __('cliente.fill_fields') }}</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.client.save') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- Nombre --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('cliente.name') }}</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre') }}"
                                       placeholder="{{ __('cliente.placeholder_name') }}">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Cedula --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('cliente.cedula') }}</label>
                                <input type="text"
                                       name="cedula"
                                       class="form-control @error('cedula') is-invalid @enderror"
                                       value="{{ old('cedula') }}"
                                       placeholder="{{ __('cliente.placeholder_cedula') }}">
                                @error('cedula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Correo --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('cliente.email') }}</label>
                                <input type="email"
                                       name="correo"
                                       class="form-control @error('correo') is-invalid @enderror"
                                       value="{{ old('correo') }}"
                                       placeholder="{{ __('cliente.placeholder_email') }}">
                                @error('correo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Celular --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('cliente.phone') }}</label>
                                <div class="input-group">
                                    <input type="string"
                                           name="celular"
                                           class="form-control @error('celular') is-invalid @enderror"
                                           value="{{ old('celular') }}"
                                           placeholder="{{ __('cliente.placeholder_phone') }}">
                                    @error('celular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.client.index') }}"
                               class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                {{ __('cliente.cancel') }}
                            </a>
                            <button type="submit" class="um-btn-primary">
                                <i class="bi bi-floppy me-1"></i> {{ __('cliente.save_client') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection