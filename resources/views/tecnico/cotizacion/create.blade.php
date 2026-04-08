@extends('layouts.admin')
@section('page-title', 'Nuevo Material')

@section('content')
  <div class="um-wrapper" id="material-app" data-unidades='@json(
      $viewData['unidades']->map(
          fn($u) => ['id' => $u->getId(), 'nombre' => $u->getNombre(), 'abreviatura' => $u->getAbreviatura()]))'
    data-presentaciones='@json($viewData['presentaciones']->map(fn($p) => ['id' => $p->getId(), 'nombre' => $p->getNombre()]))'>

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-box-seam"></i> Nuevo Material</h1>
      <a href="{{ route('admin.material.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> Volver
      </a>
    </div>

    {{-- Errores --}}
    @if ($errors->any())
      <div class="alert mb-4"
        style="background-color: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #f87171; border-radius: 10px; padding: 1rem;">
        <strong><i class="bi bi-exclamation-triangle me-1"></i> Errores:</strong>
        <ul class="mb-0 mt-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.material.save') }}" method="POST" id="materialForm">
      @csrf

      {{-- ═══ SECCIÓN 1: MATERIAL ═══ --}}
      <div class="um-card mb-4">
        <div class="um-card-header">
          <div>
            <p class="um-card-title">1. Material</p>
            <p class="um-card-subtitle">Seleccione uno existente o cree uno nuevo</p>
          </div>
        </div>
        <div class="p-4">
          <div class="row g-3">
            <div class="col-12">
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="material_mode" id="modeNew" value="new"
                    {{ old('material_mode', 'new') === 'new' ? 'checked' : '' }}>
                  <label class="form-check-label" for="modeNew" style="color: #fff;">Crear nuevo</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="material_mode" id="modeExisting" value="existing"
                    {{ old('material_mode') === 'existing' ? 'checked' : '' }}>
                  <label class="form-check-label" for="modeExisting" style="color: #fff;">Seleccionar existente</label>
                </div>
              </div>
            </div>

            <div class="col-12" id="newMaterialField">
              <label class="form-label">Descripción del material</label>
              <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                value="{{ old('descripcion') }}" placeholder="Ej: Cable, Panel LED, Conector...">
              @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12" id="existingMaterialField" style="display: none;">
              <label class="form-label">Material existente</label>
              <select name="material_id" class="form-select @error('material_id') is-invalid @enderror">
                <option value="">— Seleccione —</option>
                @foreach ($viewData['materiales'] as $mat)
                  <option value="{{ $mat->getId() }}" {{ old('material_id') == $mat->getId() ? 'selected' : '' }}>
                    {{ $mat->getDescripcion() }}
                  </option>
                @endforeach
              </select>
              @error('material_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      {{-- ═══ SECCIÓN 2: TIPOS ═══ --}}
      <div class="um-card mb-4">
        <div class="um-card-header">
          <div>
            <p class="um-card-title">2. Tipos y Presentaciones</p>
            <p class="um-card-subtitle">Agregue los tipos (especificaciones) con sus presentaciones</p>
          </div>
          <button type="button" class="um-btn-primary" id="btnAddTipo">
            <i class="bi bi-plus-lg"></i> Agregar Tipo
          </button>
        </div>
        <div class="p-4" id="tiposContainer">
          {{-- Los tipos se agregan dinámicamente via JS --}}
        </div>
      </div>

      {{-- ═══ ACCIONES ═══ --}}
      <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.material.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
          Cancelar
        </a>
        <button type="submit" class="um-btn-primary">
          <i class="bi bi-floppy me-1"></i> Guardar Material
        </button>
      </div>
    </form>

  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/admin/material-form.js') }}"></script>
@endpush
