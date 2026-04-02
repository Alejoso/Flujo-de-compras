@extends('layouts.tecnico')
@section('page-title', 'Editar Cotización')

@section('content')
  <div class="pj-wrapper" id="cotizacion-app">
    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-pencil-square me-2"></i>
        Nueva Versión desde v.{{ $viewData['version']->getNumeroVersion() }}
      </h1>
      <a href="{{ route('tecnico.cotizacion.show', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
        class="um-btn-icon um-btn-icon--secondary px-3 py-2">
        <i class="bi bi-x-circle me-1"></i> Cancelar
      </a>
    </div>

    <form action="{{ route('tecnico.cotizacion.update', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
      method="POST">
      @csrf
      @method('PATCH')

      <div class="cot-header-card mb-4">
        <p class="cot-project-name">
          <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
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
              <th style="width: 150px;">Cantidad</th>
              <th style="width: 50px;"></th>
            </tr>
          </thead>
          <tbody id="lista-materiales">
            @foreach ($viewData['materialesVersion'] as $index => $mat)
              <tr data-id="{{ $mat['ptmId'] }}">
                <td>
                  {{ $mat['descripcion'] }} — {{ $mat['especificacion'] }}
                  <input type="hidden" name="materiales[{{ $index }}][presentacionTipoMaterialId]"
                    value="{{ $mat['ptmId'] }}">
                </td>
                <td>{{ $mat['presentacion'] }}</td>
                <td>{{ $mat['unidad'] }}</td>
                <td>
                  <input type="number" name="materiales[{{ $index }}][cantidad]" class="form-control"
                    value="{{ $mat['cantidad'] }}" step="0.01" required>
                </td>
                <td>
                  <button type="button" class="btn btn-link text-danger btn-remove"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-success px-5 py-2">
          <i class="bi bi-save me-1"></i> Guardar Nueva Versión
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
    let rowIdx = {{ count($viewData['materialesVersion']) }};

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

      if (document.querySelector(`tr[data-id="${ptmId}"]`)) {
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
              <input type="number" name="materiales[${rowIdx}][cantidad]" class="form-control" value="1" step="0.01" required>
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
    });

    tbody.addEventListener('click', function(e) {
      if (e.target.closest('.btn-remove')) {
        e.target.closest('tr').remove();
      }
    });
  </script>
@endsection
