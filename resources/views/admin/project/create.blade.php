@extends('layouts.admin')
@section('page-title', __('proyecto.new_project'))

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-plus me-2"></i>{{ __('proyecto.new_project') }}</h1>
        <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> {{ __('proyecto.back') }}
        </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="um-card">
                <div class="um-card-header">
                    <div>
                        <p class="um-card-title">{{ __('proyecto.project_info') }}</p>
                        <p class="um-card-subtitle">{{ __('proyecto.fill_fields') }}</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.project.save') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- Nombre --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('proyecto.name') }}</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre') }}"
                                       placeholder="{{ __('proyecto.placeholder_name') }}">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dirección --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('proyecto.address') }}</label>
                                <input type="text"
                                       name="direccion"
                                       class="form-control @error('direccion') is-invalid @enderror"
                                       value="{{ old('direccion') }}"
                                       placeholder="{{ __('proyecto.placeholder_address') }}">
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ciudad --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('proyecto.city') }}</label>
                                <input type="text"
                                       name="ciudad"
                                       class="form-control @error('ciudad') is-invalid @enderror"
                                       value="{{ old('ciudad') }}"
                                       placeholder="{{ __('proyecto.placeholder_city') }}">
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Costo Total --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('proyecto.total_cost') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number"
                                           name="costoTotal"
                                           class="form-control @error('costoTotal') is-invalid @enderror"
                                           value="{{ old('costoTotal') }}"
                                           step="0.01"
                                           min="0"
                                           placeholder="{{ __('proyecto.placeholder_cost') }}">
                                    @error('costoTotal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Cliente --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('proyecto.client') }}</label>
                                <select name="clienteId"
                                        class="form-select @error('clienteId') is-invalid @enderror">
                                    <option value="" disabled selected>{{ __('proyecto.select_client') }}</option>
                                    @foreach($viewData['clients'] as $client)
                                        <option value="{{ $client->getId() }}"
                                            {{ old('clienteId') == $client->getId() ? 'selected' : '' }}>
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
                                {{ __('proyecto.cancel') }}
                            </a>
                            <button type="submit" class="um-btn-primary">
                                <i class="bi bi-floppy me-1"></i> {{ __('proyecto.save_project') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection