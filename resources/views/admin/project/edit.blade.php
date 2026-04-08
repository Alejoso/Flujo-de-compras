@extends('layouts.admin')
@section('page-title', __('proyecto.edit_a_project'))

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-folder-plus me-2"></i>{{ __('proyecto.edit_a_project') }}</h1>
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
                        <p class="um-card-title">{{ __('proyecto.edit_project_name', ['name' => $viewData['project']->getNombre()]) }}</p>
                        <p class="um-card-subtitle">{{ __('proyecto.update_info') }}</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.project.update' , ['id' => $viewData['project']->getId() ]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            {{-- Nombre --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('proyecto.name') }}</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{  $viewData['project']->getNombre() }}"
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
                                       value="{{ $viewData['project']->getDireccion() }}"
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
                                       value="{{ $viewData['project']->getCiudad() }}"
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
                                    <input type="text"
                                        id="costoTotalFormatted"
                                        class="form-control @error('costoTotal') is-invalid @enderror"
                                        value="{{ number_format($viewData['project']->getCostoTotal(), 0, ',', '.') }}"
                                        placeholder="{{ __('proyecto.placeholder_cost') }}"
                                        inputmode="numeric">
                                    <input type="hidden"
                                        name="costoTotal"
                                        id="costoTotalReal"
                                        value="{{ $viewData['project']->getCostoTotal() }}">
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

                            <div class="col-md-6">
                                <label class="form-label">{{ __('proyecto.client') }}</label>
                                <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                                    @foreach($viewData['states'] as $state)
                                    {{-- Show only the states that are not selected --}}
                                        <option value="{{ $state }}"
                                            {{ $viewData['project']->getEstado() === $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            {{-- Lado izquierdo: Eliminar --}}
                            <button type="button" class="um-btn-icon um-btn-icon--delete px-3 py-2"
                                    data-bs-toggle="modal" data-bs-target="#deleteProjectModal">
                                <i class="bi bi-trash me-1"></i> {{ __('proyecto.delete') }}
                            </button>

                            {{-- Lado derecho: Cancelar + Guardar --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.project.index') }}"
                                class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                    {{ __('proyecto.cancel') }}
                                </a>
                                <button type="submit" class="um-btn-primary">
                                    <i class="bi bi-floppy me-1"></i> {{ __('proyecto.edit_project') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for confirmation on delete --}}
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">{{ __('proyecto.confirm_delete_title') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ __('proyecto.confirm_delete' , ['name' => $viewData['project']->getNombre()]) }}
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="um-btn-icon um-btn-icon--edit px-3 py-2" data-bs-dismiss="modal">
                        {{ __('proyecto.cancel') }}
                    </button>
                    <form action="{{ route('admin.project.destroy', $viewData['project']->getId()) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="um-btn-icon um-btn-icon--delete px-3 py-2">
                            <i class="bi bi-trash me-1"></i> {{ __('proyecto.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    @push('scripts')
    <script src="{{ asset('js/Format/formatMiles.js') }}"></script>
    <script>
        formatMiles('costoTotalFormatted', 'costoTotalReal');
    </script>
    @endpush
    
</div>
@endsection