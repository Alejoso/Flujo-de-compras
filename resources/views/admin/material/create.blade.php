@extends('layouts.admin')
@section('page-title', __('material.title_create'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/materiales.css') }}">
@endpush

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header mat-responsive">
      <h1 class="um-title"><i class="bi bi-box-seam"></i>
        {{ __('material.title_create') }}</h1>
      <a href="{{ route('admin.material.index') }}" class="um-btn-icon um-btn-icon--edit px-2 px-md-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> <span class="d-none d-sm-inline">{{ __('material.btn_back') }}</span>
      </a>
    </div>

    {{-- Global errors --}}
    @if ($errors->any())
      <div class="alert mat-error-alert mb-3 mb-md-4">
        <strong><i class="bi bi-exclamation-triangle me-1"></i> {{ __('material.errors_title') }}</strong>
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.material.save') }}" method="POST" id="materialForm">
      @csrf

      {{-- ═══ SECTION 1: MATERIAL ═══ --}}
      <div class="um-card mb-3 mb-md-4">
        <div class="um-card-header mat-col">
          <div>
            <h2 class="um-card-title">{{ __('material.section_material_title') }}</h2>
            <p class="um-card-subtitle">{{ __('material.section_material_subtitle') }}</p>
          </div>
        </div>
        <div class="p-2 p-sm-3 p-md-4">
          <div class="row g-2 g-md-3">

            {{-- Mode --}}
            <div class="col-12">
              <div class="d-flex gap-2 gap-md-3 flex-wrap">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="material_mode" id="modeNew" value="new"
                    {{ old('material_mode', 'new') === 'new' ? 'checked' : '' }}>
                  <label class="form-check-label mat-check-label" for="modeNew">{{ __('material.mode_new') }}</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="material_mode" id="modeExisting" value="existing"
                    {{ old('material_mode') === 'existing' ? 'checked' : '' }}>
                  <label class="form-check-label mat-check-label" for="modeExisting">{{ __('material.mode_existing') }}</label>
                </div>
              </div>
            </div>

            {{-- New --}}
            <div class="col-12" id="newMaterialField">
              <label class="form-label mat-label">{{ __('material.label_description') }}</label>
              <input type="text" name="description" class="form-control mat-input @error('description') is-invalid @enderror"
                value="{{ old('description') }}" placeholder="{{ __('material.placeholder_description') }}">
              @error('description')
                <div class="invalid-feedback mat-invalid">{{ $message }}</div>
              @enderror
            </div>

            {{-- Existing --}}
            <div class="col-12 d-none" id="existingMaterialField">
              <label class="form-label mat-label">{{ __('material.label_existing_material') }}</label>
              <select name="material_id" class="form-select mat-input @error('material_id') is-invalid @enderror">
                <option value="">{{ __('material.option_select') }}</option>
                @foreach ($viewData['materials'] as $mat)
                  <option value="{{ $mat->getId() }}" {{ old('material_id') == $mat->getId() ? 'selected' : '' }}>
                    {{ $mat->getDescription() }}
                  </option>
                @endforeach
              </select>
              @error('material_id')
                <div class="invalid-feedback mat-invalid">{{ $message }}</div>
              @enderror
            </div>

          </div>
        </div>
      </div>

      {{-- ═══ SECTION 2: TYPES ═══ --}}
      <div class="um-card mb-3 mb-md-4">
        <div class="um-card-header mat-col">
          <div>
            <h2 class="um-card-title">{{ __('material.section_types_title') }}</h2>
            <p class="um-card-subtitle">{{ __('material.section_types_subtitle') }}</p>
          </div>
          <button type="button" class="um-btn-primary" id="btnAddType">
            <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">{{ __('material.btn_add_type') }}</span>
          </button>
        </div>
        <div class="p-2 p-sm-3 p-md-4" id="typesContainer">
          {{-- Types are added dynamically here --}}
        </div>
      </div>

      {{-- ═══ ACTIONS ═══ --}}
      <div class="d-flex justify-content-end gap-2 flex-column-reverse flex-sm-row">
        <a href="{{ route('admin.material.index') }}" class="um-btn-icon um-btn-icon--edit mat-btn-cancel px-2 px-md-3 py-2">
          {{ __('material.btn_cancel') }}
        </a>
        <button type="submit" class="um-btn-primary mat-btn">
          <i class="bi bi-floppy me-1"></i> {{ __('material.btn_save') }}
        </button>
      </div>
    </form>

  </div>

  {{-- ═══ TEMPLATES (hidden, cloned via JS) ═══ --}}

  {{-- Template for a Type block --}}
  <template id="typeTemplate">
    <div class="type-block mat-type-block mb-2 mb-md-3">
      <div class="d-flex justify-content-between align-items-center mb-2 mb-md-3 flex-wrap gap-2">
        <h3 class="mat-type-label">
          <i class="bi bi-tag"></i> Tipo #<span class="type-number">1</span>
        </h3>
        <button type="button" class="um-btn-icon um-btn-icon--delete btn-remove-type mat-type-remove p-1"
          title="{{ __('material.btn_delete_type_title') }}">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div class="row g-2 g-md-3 mb-2 mb-md-3">
        <div class="col-12 col-md-7">
          <label class="form-label mat-type-field-label">{{ __('material.label_specification') }}</label>
          <input type="text" class="form-control mat-type-field-input" data-name="types[__INDEX__][specification]"
            placeholder="{{ __('material.placeholder_specification') }}">
        </div>
        <div class="col-12 col-md-5">
          <label class="form-label mat-type-field-label">{{ __('material.label_unit') }}
            <small class="mat-optional">{{ __('material.label_optional') }}</small></label>
          <select class="form-select mat-type-field-input" data-name="types[__INDEX__][unit_of_measure_id]">
            <option value="">{{ __('material.option_none') }}</option>
            @foreach ($viewData['unitOfMeasures'] as $unidad)
              <option value="{{ $unidad->getId() }}">{{ $unidad->getName() }} ({{ $unidad->getAbbreviation() }})</option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Presentations for this type --}}
      <div class="mat-pres-section">
        <div class="d-flex justify-content-between align-items-center mb-2 gap-2 flex-wrap">
          <h4 class="mat-pres-label">{{ __('material.label_presentations') }}</h4>
          <button type="button" class="btn-add-presentation mat-add-pres-btn">
            <i class="bi bi-plus"></i> <span class="d-none d-sm-inline">{{ __('material.btn_add_presentation') }}</span>
          </button>
        </div>
        <div class="presentations-container"></div>
      </div>
    </div>
  </template>

  {{-- Template for a Presentation row --}}
  <template id="presentationTemplate">
    <div class="presentation-row d-flex gap-2 align-items-end mb-2 flex-wrap">
      <div class="flex-grow-1 mat-pres-field">
        <label class="form-label mat-pres-row-label">{{ __('material.label_presentation') }}</label>
        <select class="form-select form-select-sm mat-pres-input"
          data-name="types[__TIPO_INDEX__][presentations][__PRES_INDEX__][presentation_id]">
          <option value="">{{ __('material.option_select') }}</option>
          @foreach ($viewData['presentations'] as $pres)
            <option value="{{ $pres->getId() }}">{{ $pres->getName() }}</option>
          @endforeach
        </select>
      </div>
      <div class="mat-pres-qty-field">
        <label class="form-label mat-pres-row-label">{{ __('material.label_quantity') }}</label>
        <input type="text" class="form-control form-control-sm mat-pres-input"
          data-name="types[__TIPO_INDEX__][presentations][__PRES_INDEX__][presentation_quantity]"
          placeholder="{{ __('material.placeholder_quantity') }}">
      </div>
      <button type="button" class="um-btn-icon um-btn-icon--delete btn-remove-presentation mat-pres-remove"
        title="{{ __('material.btn_delete') }}">
        <i class="bi bi-dash-circle"></i>
      </button>
    </div>
  </template>

@endsection

@push('scripts')
  <script src="{{ asset('js/admin/material-form.js') }}"></script>
@endpush
