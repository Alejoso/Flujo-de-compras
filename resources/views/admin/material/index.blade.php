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

    {{-- Search --}}
    <div class="um-card mb-3 mb-md-4">
      <div class="um-card-header mat-col">
        <div>
          <h2 class="um-card-title">{{ __('material.catalog_title') }}</h2>
          <p class="um-card-subtitle">{{ __('material.catalog_subtitle') }}</p>
        </div>
        <form action="{{ route('admin.material.index') }}" method="GET">
          <div class="input-group mat-search-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control"
              placeholder="{{ __('material.search_placeholder') }}" value="{{ $viewData['search'] }}">
          </div>
        </form>
      </div>
    </div>

    {{-- Accordion --}}
    @if ($viewData['materials']->isEmpty())
      <div class="mat-empty-state">
        <i class="bi bi-box-seam"></i>
        <p>{{ __('material.empty') }}</p>
      </div>
    @else
      <div class="mat-accordion mb-4">
        @foreach ($viewData['materials'] as $material)
          <div class="mat-accordion-item">

            {{-- Header (always visible) --}}
            <div class="mat-accordion-header">
              <button type="button" class="mat-accordion-trigger" data-target="mat-body-{{ $material->getId() }}">
                <i class="bi bi-chevron-right mat-accordion-chevron"></i>
                <span class="mat-accordion-name">{{ $material->getDescription() }}</span>
                <span class="mat-accordion-count">
                  {{ $material->getMaterialTypes()->count() }}
                  {{ $material->getMaterialTypes()->count() === 1 ? 'tipo' : 'tipos' }}
                </span>
              </button>
              <form action="{{ route('admin.material.destroy', $material->getId()) }}" method="POST"
                onsubmit="return confirm('{{ __('material.confirm_delete') }}')">
                @csrf @method('DELETE')
                <button type="submit" class="um-btn-icon um-btn-icon--delete mat-accordion-delete"
                  title="{{ __('material.btn_delete') }}">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </div>

            {{-- Body (collapsible) --}}
            <div class="mat-accordion-body" id="mat-body-{{ $material->getId() }}">
              @forelse ($material->getMaterialTypes() as $mt)
                <div class="mat-type-entry">
                  <div class="mat-type-entry-header">
                    <i class="bi bi-tag-fill mat-type-icon"></i>
                    <span class="mat-type-spec">{{ $mt->getType()->getSpecification() }}</span>
                    @if ($mt->getType()->getUnitOfMeasure())
                      <span class="mat-type-unit">{{ $mt->getType()->getUnitOfMeasure()->getAbbreviation() }}</span>
                    @endif
                  </div>
                  @if ($mt->getPresentationMaterialTypes()->count() > 0)
                    <div class="mat-pres-pills">
                      @foreach ($mt->getPresentationMaterialTypes() as $pmt)
                        <span class="mat-pres-pill">
                          <i class="bi bi-box mat-pres-icon"></i>
                          {{ $pmt->getPresentation()->getName() }}
                          <span class="mat-pres-qty">× {{ $pmt->getPresentationQuantity() }}@if ($mt->getType()->getUnitOfMeasure() && strtolower($pmt->getPresentation()->getName()) !== 'unidad') {{ $mt->getType()->getUnitOfMeasure()->getAbbreviation() }}@endif</span>
                        </span>
                      @endforeach
                    </div>
                  @endif
                </div>
              @empty
                <p class="mat-no-types">Sin tipos registrados</p>
              @endforelse
            </div>

          </div>
        @endforeach
      </div>
    @endif

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3 mat-pagination">
      {{ $viewData['materials']->appends(['search' => $viewData['search']])->links() }}
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/admin/material-index.js') }}"></script>
@endpush
