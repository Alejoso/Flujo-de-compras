@extends('layouts.admin')
@section('page-title', __('client.edit_client'))

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-pencil-fill"></i> {{ __('client.edit_client') }}</h1>
        <a href="{{ route('admin.client.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> {{ __('client.back') }}
        </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="um-card">
                <div class="um-card-header">
                    <div>
                        <p class="um-card-title">{{ __('client.client_info_name', ['name' => $viewData['client']->getName()]) }}</p>
                        <p class="um-card-subtitle">{{ __('client.update_info') }}</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.client.update' , ['id' => $viewData['client']->getId() ]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('client.name') }}</label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ $viewData['client']->getName() }}"
                                       placeholder="{{ __('client.placeholder_name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ID number --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('client.cedula') }}</label>
                                <input type="text"
                                       name="id_number"
                                       class="form-control @error('id_number') is-invalid @enderror"
                                       value="{{ $viewData['client']->getIdNumber() }}"
                                       placeholder="{{ __('client.placeholder_cedula') }}">
                                @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('client.email') }}</label>
                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ $viewData['client']->getEmail() }}"
                                       placeholder="{{ __('client.placeholder_email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('client.phone') }}</label>
                                <div class="input-group">
                                    <input type="string"
                                           name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ $viewData['client']->getPhone() }}"
                                           placeholder="{{ __('client.placeholder_phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center gap-2 mt-4">

                            {{-- Spacer to align the delete button --}}
                            <div></div>

                            {{-- Cancel + Save --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.client.index') }}"
                                class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                    {{ __('client.cancel') }}
                                </a>
                                <button type="submit" class="um-btn-primary">
                                    <i class="bi bi-floppy me-1"></i> {{ __('client.edit_client') }}
                                </button>
                            </div>

                        </div>

                    </form>

                    {{-- Delete (outside the edit form) --}}
                    <form action="{{ route('admin.client.destroy', $viewData['client']->getId()) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="um-btn-icon um-btn-icon--delete px-3 py-2">
                            <i class="bi bi-trash me-1"></i> {{ __('client.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection