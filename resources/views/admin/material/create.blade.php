@extends('layouts.admin')
@section('page-title', 'Nuevo Material')

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header" style="gap: 1rem; flex-wrap: wrap;">
      <h1 class="um-title" style="font-size: clamp(1.5rem, 5vw, 2rem); margin-bottom: 0;"><i class="bi bi-box-seam"></i>
        Nuevo Material</h1>
      <a href="{{ route('admin.material.index') }}" class="um-btn-icon um-btn-icon--edit px-2 px-md-3 py-2"
        style="font-size: clamp(0.85rem, 2vw, 1rem);">
        <i class="bi bi-arrow-left me-1"></i> <span class="d-none d-sm-inline">Volver</span>
      </a>
    </div>

    {{-- Errores globales --}}
    @if ($errors->any())
      <div class="alert alert-danger mb-3 mb-md-4"
        style="background-color: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.3); color: #f87171; border-radius: 10px; font-size: clamp(0.85rem, 2vw, 1rem);">
        <strong><i class="bi bi-exclamation-triangle me-1"></i> Errores:</strong>
        <ul class="mb-0 mt-2" style="padding-left: 1.25rem;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.material.save') }}" method="POST" id="materialForm">
      @csrf

      {{-- ═══ SECCIÓN 1: MATERIAL ═══ --}}
      <div class="um-card mb-3 mb-md-4">
        <div class="um-card-header" style="flex-direction: column; gap: 1rem;">
          <div>
            <p class="um-card-title" style="font-size: clamp(1.1rem, 4vw, 1.25rem);">1. Material</p>
            <p class="um-card-subtitle" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Seleccione uno existente o cree
              uno nuevo</p>
          </div>
        </div>
        <div class="p-2 p-sm-3 p-md-4">
          <div class="row g-2 g-md-3">
            {{-- Modo --}}
            <div class="col-12">
              <div class="d-flex gap-2 gap-md-3 flex-wrap">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="material_mode" id="modeNew" value="new"
                    {{ old('material_mode', 'new') === 'new' ? 'checked' : '' }}>
                  <label class="form-check-label" for="modeNew"
                    style="color: #fff; font-size: clamp(0.85rem, 2vw, 1rem);">Crear nuevo</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="material_mode" id="modeExisting" value="existing"
                    {{ old('material_mode') === 'existing' ? 'checked' : '' }}>
                  <label class="form-check-label" for="modeExisting"
                    style="color: #fff; font-size: clamp(0.85rem, 2vw, 1rem);">Seleccionar existente</label>
                </div>
              </div>
            </div>

            {{-- Nuevo --}}
            <div class="col-12" id="newMaterialField">
              <label class="form-label" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Descripción del material</label>
              <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                value="{{ old('descripcion') }}" placeholder="Ej: Cable, Panel LED, Conector..."
                style="font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px;">
              @error('descripcion')
                <div class="invalid-feedback" style="font-size: clamp(0.75rem, 2vw, 0.85rem);">{{ $message }}</div>
              @enderror
            </div>

            {{-- Existente --}}
            <div class="col-12" id="existingMaterialField" style="display: none;">
              <label class="form-label" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Material existente</label>
              <select name="material_id" class="form-select @error('material_id') is-invalid @enderror"
                style="font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px;">
                <option value="">— Seleccione —</option>
                @foreach ($viewData['materiales'] as $mat)
                  <option value="{{ $mat->getId() }}" {{ old('material_id') == $mat->getId() ? 'selected' : '' }}>
                    {{ $mat->getDescripcion() }}
                  </option>
                @endforeach
              </select>
              @error('material_id')
                <div class="invalid-feedback" style="font-size: clamp(0.75rem, 2vw, 0.85rem);">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      {{-- ═══ SECCIÓN 2: TIPOS ═══ --}}
      <div class="um-card mb-3 mb-md-4">
        <div class="um-card-header" style="flex-direction: column; gap: 1rem; align-items: flex-start;">
          <div>
            <p class="um-card-title" style="font-size: clamp(1.1rem, 4vw, 1.25rem);">2. Tipos y Presentaciones</p>
            <p class="um-card-subtitle" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Agregue los tipos
              (especificaciones) con sus presentaciones</p>
          </div>
          <button type="button" class="um-btn-primary" id="btnAddTipo"
            style="font-size: clamp(0.85rem, 2vw, 0.95rem); min-height: 40px; white-space: nowrap;">
            <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Agregar Tipo</span>
          </button>
        </div>
        <div class="p-2 p-sm-3 p-md-4" id="tiposContainer">
          {{-- Los tipos se agregan dinámicamente aquí --}}
        </div>
      </div>

      {{-- ═══ ACCIONES ═══ --}}
      <div class="d-flex justify-content-end gap-2 flex-column-reverse flex-sm-row">
        <a href="{{ route('admin.material.index') }}" class="um-btn-icon um-btn-icon--edit px-2 px-md-3 py-2"
          style="text-align: center; font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px; display: flex; align-items: center; justify-content: center;">
          Cancelar
        </a>
        <button type="submit" class="um-btn-primary" style="font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px;">
          <i class="bi bi-floppy me-1"></i> Guardar Material
        </button>
      </div>
    </form>

  </div>

  {{-- ═══ TEMPLATES (ocultos, se clonan con JS) ═══ --}}

  {{-- Template de un bloque Tipo --}}
  <template id="tipoTemplate">
    <div class="tipo-block mb-2 mb-md-3"
      style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 1rem;">
      <div class="d-flex justify-content-between align-items-center mb-2 mb-md-3 flex-wrap gap-2">
        <strong style="color: #F5C800; font-size: clamp(0.8rem, 2vw, 0.9rem);">
          <i class="bi bi-tag"></i> Tipo #<span class="tipo-number">1</span>
        </strong>
        <button type="button" class="um-btn-icon um-btn-icon--delete btn-remove-tipo p-1" title="Eliminar tipo"
          style="min-height: 36px; min-width: 36px;">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div class="row g-2 g-md-3 mb-2 mb-md-3">
        <div class="col-12 col-md-7">
          <label class="form-label" style="font-size: clamp(0.8rem, 2vw, 0.9rem);">Especificación</label>
          <input type="text" class="form-control" data-name="tipos[__INDEX__][especificacion]"
            placeholder="Ej: # 12 NEGRO, 20 Amperios..."
            style="font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px;">
        </div>
        <div class="col-12 col-md-5">
          <label class="form-label" style="font-size: clamp(0.8rem, 2vw, 0.9rem);">Unidad de medida <small
              style="color:#5A5A5A;">(opcional)</small></label>
          <select class="form-select" data-name="tipos[__INDEX__][unidadMedidaId]"
            style="font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px;">
            <option value="">— Ninguna —</option>
            @foreach ($viewData['unidades'] as $unidad)
              <option value="{{ $unidad->getId() }}">{{ $unidad->getNombre() }} ({{ $unidad->getAbreviatura() }})
              </option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Presentaciones de este tipo --}}
      <div style="margin-left: 0.5rem; border-left: 2px solid rgba(245,200,0,0.2); padding-left: 1rem;">
        <div class="d-flex justify-content-between align-items-center mb-2 gap-2 flex-wrap">
          <span
            style="color: #A0A0A0; font-size: clamp(0.75rem, 2vw, 0.8rem); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
            Presentaciones
          </span>
          <button type="button" class="btn-add-presentacion"
            style="background: none; border: 1px solid rgba(245,200,0,0.3); color: #F5C800; font-size: clamp(0.7rem, 2vw, 0.78rem); padding: 4px 8px; border-radius: 6px; cursor: pointer; min-height: 32px; white-space: nowrap;">
            <i class="bi bi-plus"></i> <span class="d-none d-sm-inline">Presentación</span>
          </button>
        </div>
        <div class="presentaciones-container">
          {{-- Las presentaciones se agregan aquí --}}
        </div>
      </div>
    </div>
  </template>

  {{-- Template de una fila Presentación --}}
  <template id="presentacionTemplate">
    <div class="presentacion-row d-flex gap-2 align-items-end mb-2 flex-wrap">
      <div class="flex-grow-1" style="min-width: 200px;">
        <label class="form-label" style="font-size: clamp(0.75rem, 2vw, 0.8rem);">Presentación</label>
        <select class="form-select form-select-sm"
          data-name="tipos[__TIPO_INDEX__][presentaciones][__PRES_INDEX__][presentacionId]"
          style="font-size: clamp(0.8rem, 2vw, 0.9rem); min-height: 40px;">
          <option value="">— Seleccione —</option>
          @foreach ($viewData['presentaciones'] as $pres)
            <option value="{{ $pres->getId() }}">{{ $pres->getNombre() }}</option>
          @endforeach
        </select>
      </div>
      <div style="min-width: 120px;">
        <label class="form-label" style="font-size: clamp(0.75rem, 2vw, 0.8rem);">Cantidad</label>
        <input type="text" class="form-control form-control-sm"
          data-name="tipos[__TIPO_INDEX__][presentaciones][__PRES_INDEX__][cantidadPresentacion]" placeholder="Ej: 100"
          style="font-size: clamp(0.8rem, 2vw, 0.9rem); min-height: 40px;">
      </div>
      <button type="button" class="um-btn-icon um-btn-icon--delete btn-remove-presentacion"
        style="padding: 0.5rem; min-height: 40px; min-width: 40px; display: flex; align-items: center; justify-content: center;"
        title="Eliminar">
        <i class="bi bi-dash-circle"></i>
      </button>
    </div>
  </template>

@endsection

@push('scripts')
  <script src="{{ asset('js/admin/material-form.js') }}"></script>
@endpush
