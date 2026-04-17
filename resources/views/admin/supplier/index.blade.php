@extends('layouts.admin')
@section('page-title', __('supplier.suppliers'))

@section('content')
<div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-truck"></i> {{ __('supplier.suppliers') }}</h1>
        <a href="{{ route('admin.supplier.create') }}" class="um-btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('supplier.new_supplier') }}
        </a>
    </div>

    {{-- Search --}}
    <div class="um-card mb-4">
        <div class="um-card-header">
            <form method="GET" action="{{ route('admin.supplier.index') }}" class="d-flex gap-2 flex-wrap align-items-center w-100">
                <div class="input-group search-group-client flex-grow-1">
                    <button type="submit" class="input-group-text border-0 bg-transparent"><i class="bi bi-search"></i></button>
                    <input type="text" name="search" value="{{ $viewData['search'] }}" class="form-control" placeholder="{{ __('supplier.search_suppliers') }}">
                </div>
            </form>
        </div>
    </div>

    {{-- Supplier cards grid --}}
    <div class="row g-4">
        @forelse($viewData['suppliers'] as $supplier)
        <div class="col-md-6 col-xl-4">
            <div class="pj-card">

                {{-- Name --}}
                <div class="d-flex justify-content-center align-items-start mb-1">
                    <h5 class="pj-title">{{ $supplier->getName() }}</h5>
                </div>

                {{-- NIT --}}
                <p class="mb-3">
                    <span class="pj-meta-label">{{ __('supplier.nit_label') }} </span>
                    <span class="pj-meta-value">{{ $supplier->getNit() }}</span>
                </p>

                {{-- Advisor --}}
                <div class="mb-3">
                    <span class="pj-meta-label">{{ __('supplier.advisor_name_label') }} </span>
                    <span class="pj-meta-value">{{ $supplier->getAdvisorName() }}</span>
                </div>

                {{-- Account number --}}
                <div class="mb-3">
                    <span class="pj-meta-label">{{ __('supplier.account_number_label') }} </span>
                    <span class="pj-meta-value">
                        {{ $supplier->getAccountNumber() ?? __('supplier.null_data') }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="mt-auto d-flex gap-2">
                    <a href="{{ route('admin.supplier.edit', ['id' => $supplier->getId()]) }}"
                       class="um-btn-icon um-btn-icon--edit flex-fill justify-content-center py-2">
                        <i class="bi bi-pencil-fill me-1"></i> {{ __('supplier.edit') }}
                    </a>
                    <form action="{{ route('admin.supplier.destroy', $supplier->getId()) }}" method="POST"
                          onsubmit="return confirm('{{ __('supplier.confirm_delete') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="um-btn-icon um-btn-icon--delete py-2 px-3">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="um-empty">
                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                {{ __('supplier.no_suppliers') }}
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($viewData['suppliers']->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $viewData['suppliers']->links() }}
    </div>
    @endif

</div>
@endsection
