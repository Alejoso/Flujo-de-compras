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
          <h2 class="um-card-title">{{ __('material.catalog_title') }}</h2>
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
              <th class="text-end">{{ __('material.th_actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($viewData['materials'] as $material)
              <tr class="um-row">

                {{-- Material name --}}
                <td data-label="{{ __('material.th_material') }}">
                  <span class="um-user-name mat-material-name">{{ $material->getDescription() }}</span>
                </td>

                {{-- Types with presentation details --}}
                <td data-label="{{ __('material.th_types') }}">
                  <div class="mat-types-list">
                    @foreach ($material->getMaterialTypes() as $mt)
                      <div class="mat-type-chip">
                        <span class="mat-type-chip-name">
                          {{ $mt->getType()->getSpecification() }}
                          @if ($mt->getType()->getUnitOfMeasure())
                            <span
                              class="mat-type-chip-unit">({{ $mt->getType()->getUnitOfMeasure()->getAbbreviation() }})</span>
                          @endif
                        </span>
                        @if ($mt->getPresentationMaterialTypes()->count() > 0)
                          <span class="mat-type-chip-pres-count"
                            title="@foreach ($mt->getPresentationMaterialTypes() as $pmt){{ $pmt->getPresentation()->getName() }}: {{ $pmt->getPresentationQuantity() }}{{ !$loop->last ? ' | ' : '' }} @endforeach">
                            <i class="bi bi-box-seam"></i> {{ $mt->getPresentationMaterialTypes()->count() }}
                          </span>
                        @endif
                      </div>
                    @endforeach
                  </div>
                </td>

                {{-- Actions --}}
                <td data-label="{{ __('material.th_actions') }}">
                  <div class="um-actions justify-content-end">
                    <form action="{{ route('admin.material.destroy', $material->getId()) }}" method="POST"
                      onsubmit="return confirm('{{ __('material.confirm_delete') }}')" class="mat-action-form">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="um-btn-icon um-btn-icon--delete mat-delete-btn"
                        title="{{ __('material.btn_delete') }}">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="um-empty">
                  <i class="bi bi-box-seam fs-3 d-block mb-2"></i>
                  {{ __('material.empty') }}
                </td>
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
