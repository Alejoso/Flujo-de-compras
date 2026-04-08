@extends('layouts.admin')
@section('page-title', 'Nuevo Material')

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-box-seam"></i> Nuevo Material</h1>
      <a href="{{ route('admin.material.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> Volver
      </a>
    </div>

    {{-- Errores globales --}}
    @if ($errors->any())
      <div class="alert alert-danger mb-4"
        style="background-color: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.3); color: #f87171; border-radius: 10px;">
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
            {{-- Modo --}}
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

            {{-- Nuevo --}}
            <div class="col-12" id="newMaterialField">
              <label class="form-label">Descripción del material</label>
              <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                value="{{ old('descripcion') }}" placeholder="Ej: Cable, Panel LED, Conector...">
              @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Existente --}}
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
          {{-- Los tipos se agregan dinámicamente aquí --}}
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

  {{-- ═══ TEMPLATES (ocultos, se clonan con JS) ═══ --}}

  {{-- Template de un bloque Tipo --}}
  <template id="tipoTemplate">
    <div class="tipo-block mb-3"
      style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 1.25rem;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <strong style="color: #F5C800; font-size: 0.9rem;">
          <i class="bi bi-tag"></i> Tipo #<span class="tipo-number">1</span>
        </strong>
        <button type="button" class="um-btn-icon um-btn-icon--delete btn-remove-tipo" title="Eliminar tipo">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-7">
          <label class="form-label">Especificación</label>
          <input type="text" class="form-control" data-name="tipos[__INDEX__][especificacion]"
            placeholder="Ej: # 12 NEGRO, 20 Amperios, REDONDA 18 WATTS...">
        </div>
        <div class="col-md-5">
          <label class="form-label">Unidad de medida <small style="color:#5A5A5A">(opcional)</small></label>
          <select class="form-select" data-name="tipos[__INDEX__][unidadMedidaId]">
            <option value="">— Ninguna —</option>
            @foreach ($viewData['unidades'] as $unidad)
              <option value="{{ $unidad->getId() }}">{{ $unidad->getNombre() }} ({{ $unidad->getAbreviatura() }})
              </option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Presentaciones de este tipo --}}
      <div style="margin-left: 1rem; border-left: 2px solid rgba(245,200,0,0.2); padding-left: 1rem;">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span
            style="color: #A0A0A0; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
            Presentaciones
          </span>
          <button type="button" class="btn-add-presentacion"
            style="background: none; border: 1px solid rgba(245,200,0,0.3); color: #F5C800; font-size: 0.78rem; padding: 3px 10px; border-radius: 6px; cursor: pointer;">
            <i class="bi bi-plus"></i> Presentación
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
    <div class="presentacion-row d-flex gap-2 align-items-end mb-2">
      <div class="flex-grow-1">
        <label class="form-label" style="font-size: 0.78rem;">Presentación</label>
        <select class="form-select form-select-sm"
          data-name="tipos[__TIPO_INDEX__][presentaciones][__PRES_INDEX__][presentacionId]">
          <option value="">— Seleccione —</option>
          @foreach ($viewData['presentaciones'] as $pres)
            <option value="{{ $pres->getId() }}">{{ $pres->getNombre() }}</option>
          @endforeach
        </select>
      </div>
      <div style="width: 140px;">
        <label class="form-label" style="font-size: 0.78rem;">Cantidad</label>
        <input type="text" class="form-control form-control-sm"
          data-name="tipos[__TIPO_INDEX__][presentaciones][__PRES_INDEX__][cantidadPresentacion]" placeholder="Ej: 100">
      </div>
      <button type="button" class="um-btn-icon um-btn-icon--delete btn-remove-presentacion"
        style="margin-bottom: 2px;" title="Eliminar">
        <i class="bi bi-dash-circle"></i>
      </button>
    </div>
  </template>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tiposContainer = document.getElementById('tiposContainer');
      const btnAddTipo = document.getElementById('btnAddTipo');
      const tipoTemplate = document.getElementById('tipoTemplate');
      const presTemplate = document.getElementById('presentacionTemplate');

      let tipoIndex = 0;

      // ── Toggle material mode ──
      const modeRadios = document.querySelectorAll('input[name="material_mode"]');
      const newField = document.getElementById('newMaterialField');
      const existField = document.getElementById('existingMaterialField');

      function toggleMode() {
        const mode = document.querySelector('input[name="material_mode"]:checked').value;
        newField.style.display = mode === 'new' ? '' : 'none';
        existField.style.display = mode === 'existing' ? '' : 'none';
      }
      modeRadios.forEach(r => r.addEventListener('change', toggleMode));
      toggleMode();

      // ── Agregar Tipo ──
      btnAddTipo.addEventListener('click', function() {
        addTipo();
      });

      function addTipo() {
        const clone = tipoTemplate.content.cloneNode(true);
        const block = clone.querySelector('.tipo-block');

        // Actualizar número visual
        block.querySelector('.tipo-number').textContent = tipoIndex + 1;

        // Actualizar names con el índice correcto
        block.querySelectorAll('[data-name]').forEach(el => {
          el.setAttribute('name', el.getAttribute('data-name').replace('__INDEX__', tipoIndex));
        });

        // Botón eliminar tipo
        block.querySelector('.btn-remove-tipo').addEventListener('click', function() {
          block.remove();
          renumberTipos();
        });

        // Botón agregar presentación dentro de este tipo
        const presContainer = block.querySelector('.presentaciones-container');
        const btnAddPres = block.querySelector('.btn-add-presentacion');
        let presIndex = 0;

        btnAddPres.addEventListener('click', function() {
          addPresentacion(presContainer, tipoIndex, presIndex);
          presIndex++;
        });

        // Agregar una presentación por defecto
        addPresentacion(presContainer, tipoIndex, presIndex);
        presIndex++;

        tiposContainer.appendChild(block);
        tipoIndex++;
      }

      function addPresentacion(container, tIdx, pIdx) {
        const clone = presTemplate.content.cloneNode(true);
        const row = clone.querySelector('.presentacion-row');

        row.querySelectorAll('[data-name]').forEach(el => {
          el.setAttribute('name',
            el.getAttribute('data-name')
            .replace('__TIPO_INDEX__', tIdx)
            .replace('__PRES_INDEX__', pIdx)
          );
        });

        row.querySelector('.btn-remove-presentacion').addEventListener('click', function() {
          row.remove();
        });

        container.appendChild(row);
      }

      function renumberTipos() {
        const blocks = tiposContainer.querySelectorAll('.tipo-block');
        blocks.forEach((block, i) => {
          block.querySelector('.tipo-number').textContent = i + 1;
        });
      }

      // Agregar un tipo por defecto al cargar
      addTipo();
    });
  </script>
@endpush
