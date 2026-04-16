@extends('layouts.admin')
@section('page-title', __('material.title_index'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/materiales.css') }}">
@endpush

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header mat-responsive">
      <h1 class="um-title"><i class="bi bi-box-seam"></i>
        {{ __('material.title_index') }}</h1>
      <a href="{{ route('admin.material.create') }}" class="um-btn-primary">
        <i class="bi bi-plus-lg me-1"></i> <span class="d-none d-sm-inline">{{ __('material.btn_new') }}</span>
      </a>
    </div>

    {{-- Card --}}
    <div class="um-card mb-3 mb-md-4">
      <div class="um-card-header mat-col">
        <div>
          <p class="um-card-title">{{ __('material.catalog_title') }}</p>
          <p class="um-card-subtitle">{{ __('material.catalog_subtitle') }}</p>
        </div>
        <form action="{{ route('admin.material.index') }}" method="GET" class="d-flex gap-2 search-group">
          <div class="input-group mat-search-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control"
              placeholder="{{ __('material.search_placeholder') }}" value="{{ $viewData['search'] }}">
          </div>
        </form>
      </div>

      <div class="um-table-wrapper">
        <table class="um-table">
          <thead>
            <tr>
              <th>{{ __('material.th_material') }}</th>
              <th>{{ __('material.th_types') }}</th>
              <th>{{ __('material.th_actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($viewData['materials'] as $material)
              <tr class="um-row">
                <td data-label="{{ __('material.th_material') }}">
                  <span class="um-user-name mat-material-name">{{ $material->getDescription() }}</span>
                </td>
                <td data-label="{{ __('material.th_types') }}">
                  @foreach ($material->getMaterialTypes() as $tm)
                    <span class="um-badge um-badge--technician mat-type-badge me-1 mb-1">
                      {{ $tm->getType()->getSpecification() }}
                      @if ($tm->getType()->getUnitOfMeasure())
                        ({{ $tm->getType()->getUnitOfMeasure()->getAbbreviation() }})
                      @endif
                    </span>
                  @endforeach
                </td>
                <td data-label="{{ __('material.th_actions') }}">
                  <div class="um-actions">
                    <form action="{{ route('admin.material.destroy', $material->getId()) }}" method="POST"
                      onsubmit="return confirm('{{ __('material.confirm_delete') }}')"
                      class="mat-action-form">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="um-btn-icon um-btn-icon--delete mat-delete-btn">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="um-empty">{{ __('material.empty') }}</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3 mat-pagination">
      {{ $viewData['materials']->appends(['search' => $viewData['search']])->links() }}
    </div>

  </div>
@endsection
