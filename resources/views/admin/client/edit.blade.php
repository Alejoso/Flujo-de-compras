@extends('layouts.admin')
@section('page-title', __('cliente.edit_client'))

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-pencil-fill"></i> {{ __('cliente.edit_client') }}</h1>
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
                        <p class="um-card-title">{{ __('cliente.client_info_name', ['name' => $viewData['client']->getName()]) }}</p>
                        <p class="um-card-subtitle">{{ __('cliente.update_info') }}</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.client.update' , ['id' => $viewData['client']->getId() ]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            {{-- Nombre --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('cliente.name') }}</label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ $viewData['client']->getName() }}"
                                       placeholder="{{ __('cliente.placeholder_name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Cedula --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('cliente.cedula') }}</label>
                                <input type="text"
                                       name="id_number"
                                       class="form-control @error('id_number') is-invalid @enderror"
                                       value="{{ $viewData['client']->getIdNumber() }}"
                                       placeholder="{{ __('cliente.placeholder_cedula') }}">
                                @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Correo --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('cliente.email') }}</label>
                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ $viewData['client']->getEmail() }}"
                                       placeholder="{{ __('cliente.placeholder_email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Celular --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('cliente.phone') }}</label>
                                <div class="input-group">
                                    <input type="string"
                                           name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ $viewData['client']->getPhone() }}"
                                           placeholder="{{ __('cliente.placeholder_phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center gap-2 mt-4">

                            {{-- Placeholder para alinear el botón eliminar --}}
                            <div></div>

                            {{-- Cancelar + Guardar --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.client.index') }}"
                                class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                    {{ __('cliente.cancel') }}
                                </a>
                                <button type="submit" class="um-btn-primary">
                                    <i class="bi bi-floppy me-1"></i> {{ __('cliente.edit_client') }}
                                </button>
                            </div>

                        </div>

                    </form>

                    {{-- Eliminar (fuera del form de edición) --}}
                    <form action="{{ route('admin.client.destroy', $viewData['client']->getId()) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="um-btn-icon um-btn-icon--delete px-3 py-2">
                            <i class="bi bi-trash me-1"></i> {{ __('cliente.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection