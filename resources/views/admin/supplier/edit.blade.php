@extends('layouts.admin')
@section('page-title', __('supplier.edit_supplier'))

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-pencil-fill"></i> {{ __('supplier.edit_supplier') }}</h1>
        <a href="{{ route('admin.supplier.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> {{ __('supplier.back') }}
        </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="um-card">
                <div class="um-card-header">
                    <div>
                        <p class="um-card-title">{{ __('supplier.supplier_info_name', ['name' => $viewData['supplier']->getName()]) }}</p>
                        <p class="um-card-subtitle">{{ __('supplier.update_info') }}</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.supplier.update', ['id' => $viewData['supplier']->getId()]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('supplier.name') }}</label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $viewData['supplier']->getName()) }}"
                                       placeholder="{{ __('supplier.placeholder_name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NIT --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('supplier.nit') }}</label>
                                <input type="text"
                                       name="nit"
                                       class="form-control @error('nit') is-invalid @enderror"
                                       value="{{ old('nit', $viewData['supplier']->getNit()) }}"
                                       placeholder="{{ __('supplier.placeholder_nit') }}">
                                @error('nit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Advisor name --}}
                            <div class="col-md-6">
                                <label class="form-label">{{ __('supplier.advisor_name') }}</label>
                                <input type="text"
                                       name="advisor_name"
                                       class="form-control @error('advisor_name') is-invalid @enderror"
                                       value="{{ old('advisor_name', $viewData['supplier']->getAdvisorName()) }}"
                                       placeholder="{{ __('supplier.placeholder_advisor_name') }}">
                                @error('advisor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Account number --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('supplier.account_number') }}</label>
                                <input type="text"
                                       name="account_number"
                                       class="form-control @error('account_number') is-invalid @enderror"
                                       value="{{ old('account_number', $viewData['supplier']->getAccountNumber()) }}"
                                       placeholder="{{ __('supplier.placeholder_account_number') }}">
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center gap-2 mt-4">
                            <div></div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.supplier.index') }}"
                                   class="um-btn-icon um-btn-icon--edit px-3 py-2">
                                    {{ __('supplier.cancel') }}
                                </a>
                                <button type="submit" class="um-btn-primary">
                                    <i class="bi bi-floppy me-1"></i> {{ __('supplier.edit_supplier') }}
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
