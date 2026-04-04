@extends('layouts.tecnico')
@section('page-title', 'Nueva Cotización')

@section('content')
  <div class="pj-wrapper" id="cotizacion-app">

    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-clipboard-plus me-2"></i>Nueva Cotización</h1>
      <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}"
        class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> Volver
      </a>
    </div>

    @if ($errors->any())
      <div class="alert mb-3 cot-alert-error">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Revisa los campos marcados antes de enviar.
      </div>
    @endif


    <form action="{{ route('tecnico.cotizacion.store', $viewData['project']->getId()) }}" method="POST"
      id="cotizacionForm">
      @csrf

      <div class="cot-header-card mb-4">
        <p class="cot-project-name">
          <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
        </p>
        <p class="cot-project-meta">
          <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCiudad() }} —
          {{ $viewData['project']->getDireccion() }}
        </p>

        <div class="row mt-3 g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label fw-bold">Material</label>
            <div class="ac-wrap">
              <input type="text" id="buscador-material" class="form-control" placeholder="Escriba para buscar..." autocomplete="off">
              <div id="autocomplete-list" class="ac-dropdown"></div>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">Presentación</label>
            <select id="selector-presentacion" class="form-select" disabled>
              <option value="">— elige material primero —</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-bold">Unidad</label>
            <input type="text" id="display-unidad" class="form-control" readonly placeholder="—">
          </div>
          <div class="col-md-3">
            <button type="button" id="btn-add-material" class="btn btn-primary w-100" disabled>
              <i class="bi bi-plus-lg me-1"></i> Agregar a la lista
            </button>
          </div>
        </div>
      </div>

      <div class="cot-table-wrap">
        <table class="cot-table cot-edit-table" id="tabla-materiales">
          <thead>
            <tr>
              <th>Material / Especificación</th>
              <th>Presentación</th>
              <th>Unidad</th>
              <th class="col-cantidad">Cantidad</th>
              <th class="col-actions"></th>
            </tr>
          </thead>
          <tbody id="lista-materiales">
            <tr id="emptyRow">
              <td colspan="5" class="cot-empty">
                <i class="bi bi-box-seam cot-empty-icon d-block mb-1"></i>
                Agrega materiales usando los selectores de arriba
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="cot-footer">
        <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}"
          class="um-btn-icon um-btn-icon--edit px-4 py-2">
          Cancelar
        </a>
        <button type="submit" class="um-btn-primary px-4 py-2" id="submitBtn">
          <i class="bi bi-send-fill me-1"></i> Enviar Cotización
        </button>
      </div>

    </form>
  </div>

  <script>
    let tmData = {};
    let selectedTmId = null;

    const buscadorMaterial = document.getElementById('buscador-material');
    const acList = document.getElementById('autocomplete-list');
    const selectorPres = document.getElementById('selector-presentacion');
    const displayUnidad = document.getElementById('display-unidad');
    const btnAdd = document.getElementById('btn-add-material');
    const tbody = document.getElementById('lista-materiales');
    const emptyRow = document.getElementById('emptyRow');
    let rowIdx = 0;

    function updateEmpty() {
      emptyRow.style.display = tbody.querySelectorAll('tr[data-id]').length > 0 ? 'none' : '';
    }

    function resetPresentacion() {
      selectorPres.innerHTML = '<option value="">— elige material primero —</option>';
      selectorPres.disabled = true;
      displayUnidad.value = '';
      btnAdd.disabled = true;
      selectedTmId = null;
    }

    function showDropdown(data) {
      acList.innerHTML = '';
      const keys = Object.keys(data);

      if (keys.length === 0) {
        acList.innerHTML = '<div class="ac-empty">Sin resultados</div>';
      } else {
        keys.forEach(tmId => {
          const item = document.createElement('div');
          item.className = 'ac-item';
          item.textContent = data[tmId].label;
          item.addEventListener('mousedown', function(e) {
            e.preventDefault();
            selectMaterial(tmId, data[tmId].label);
          });
          acList.appendChild(item);
        });
      }
      acList.style.display = 'block';
    }

    function hideDropdown() {
      acList.style.display = 'none';
    }

    function selectMaterial(tmId, label) {
      selectedTmId = tmId;
      buscadorMaterial.value = label;
      hideDropdown();

      selectorPres.innerHTML = '<option value="">Seleccione presentación...</option>';
      tmData[tmId].presentaciones.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id;
        opt.textContent = p.nombre;
        opt.dataset.unidad = p.unidad;
        selectorPres.appendChild(opt);
      });
      selectorPres.disabled = false;
      displayUnidad.value = '';
      btnAdd.disabled = true;
    }

    function fetchMateriales(query = '') {
      fetch(`{{ route('tecnico.materiales.search') }}?q=${encodeURIComponent(query)}`)
        .then(r => r.json())
        .then(data => {
          tmData = data;
          showDropdown(data);
        })
        .catch(err => console.error(err));
    }

    let timeoutId;
    buscadorMaterial.addEventListener('input', function() {
      clearTimeout(timeoutId);
      resetPresentacion();
      const query = this.value.trim();
      timeoutId = setTimeout(() => fetchMateriales(query), 300);
    });

    buscadorMaterial.addEventListener('focus', function() {
      if (Object.keys(tmData).length > 0) {
        showDropdown(tmData);
      } else {
        fetchMateriales('');
      }
    });

    buscadorMaterial.addEventListener('blur', function() {
      setTimeout(hideDropdown, 150);
    });

    selectorPres.addEventListener('change', function() {
      const opt = this.options[this.selectedIndex];
      if (opt.value) {
        displayUnidad.value = opt.dataset.unidad || '';
        btnAdd.disabled = false;
      } else {
        displayUnidad.value = '';
        btnAdd.disabled = true;
      }
    });

    btnAdd.addEventListener('click', function() {
      const ptmId = selectorPres.value;
      const ptmNombre = selectorPres.options[selectorPres.selectedIndex].textContent;
      const unidad = displayUnidad.value;
      const label = tmData[selectedTmId].label;

      if (tbody.querySelector(`tr[data-id="${ptmId}"]`)) {
        alert('Esta combinación ya está en la lista.');
        return;
      }

      const tr = document.createElement('tr');
      tr.setAttribute('data-id', ptmId);
      tr.innerHTML = `
        <td>
            ${label}
            <input type="hidden" name="materiales[${rowIdx}][presentacionTipoMaterialId]" value="${ptmId}">
        </td>
        <td>${ptmNombre}</td>
        <td>${unidad}</td>
        <td>
            <input type="number" name="materiales[${rowIdx}][cantidad]" class="form-control" value="1" min="0.01" step="0.01" required>
        </td>
        <td>
            <button type="button" class="btn btn-link text-danger btn-remove"><i class="bi bi-trash"></i></button>
        </td>
      `;
      tbody.appendChild(tr);
      rowIdx++;

      buscadorMaterial.value = '';
      tmData = {};
      resetPresentacion();
      updateEmpty();
    });

    tbody.addEventListener('click', function(e) {
      if (e.target.closest('.btn-remove')) {
        e.target.closest('tr').remove();
        updateEmpty();
      }
    });

    document.getElementById('cotizacionForm').addEventListener('submit', function(e) {
      if (tbody.querySelectorAll('tr[data-id]').length === 0) {
        e.preventDefault();
        alert('Debes agregar al menos un material antes de enviar.');
      }
    });

    updateEmpty();
  </script>
@endsection
