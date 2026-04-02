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
            <input type="text" id="buscador-material" class="form-control mb-2" placeholder="Escriba para buscar...">
            <select id="selector-tipo-material" class="form-select">
              <option value="">— Busca y selecciona un material —</option>
            </select>
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

    const buscadorMaterial = document.getElementById('buscador-material');
    const selectorTm = document.getElementById('selector-tipo-material');
    const selectorPres = document.getElementById('selector-presentacion');
    const displayUnidad = document.getElementById('display-unidad');
    const btnAdd = document.getElementById('btn-add-material');
    const tbody = document.getElementById('lista-materiales');
    let rowIdx = {{ count($viewData['materialesVersion']) }};

    function fetchMateriales(query = '') {
      fetch(`{{ route('tecnico.materiales.search') }}?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
          tmData = data;

          selectorTm.innerHTML = '<option value="">Seleccione un material...</option>';

          if (Object.keys(data).length === 0) {
            selectorTm.innerHTML = '<option value="">No se encontraron resultados</option>';
            return;
          }

          for (const [tmId, tm] of Object.entries(data)) {
            const opt = document.createElement('option');
            opt.value = tmId;
            opt.textContent = tm.label;
            selectorTm.appendChild(opt);
          }
        })
        .catch(error => console.error('Error:', error));
    }

    fetchMateriales('');

    let timeoutId;
    buscadorMaterial.addEventListener('input', function() {
      clearTimeout(timeoutId);
      const query = this.value.trim();

      timeoutId = setTimeout(() => {
        fetchMateriales(query);
        selectorPres.disabled = true;
        displayUnidad.value = '';
        btnAdd.disabled = true;
      }, 300);
    });

    selectorTm.addEventListener('change', function() {
      const tmId = this.value;
      selectorPres.innerHTML = '<option value="">Seleccione presentación...</option>';
      displayUnidad.value = '';
      btnAdd.disabled = true;

      if (!tmId || !tmData[tmId]) {
        selectorPres.disabled = true;
        return;
      }

      tmData[tmId].presentaciones.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id;
        opt.textContent = p.nombre;
        opt.dataset.unidad = p.unidad;
        selectorPres.appendChild(opt);
      });
      selectorPres.disabled = false;
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
      const tmId = selectorTm.value;
      const label = tmData[tmId].label;

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
      selectorTm.innerHTML = '<option value="">— Busca y selecciona un material —</option>';
      selectorPres.innerHTML = '<option value="">— elige material primero —</option>';
      selectorPres.disabled = true;
      displayUnidad.value = '';
      btnAdd.disabled = true;
    });

    tbody.addEventListener('click', function(e) {
      if (e.target.closest('.btn-remove')) {
        e.target.closest('tr').remove();
      }
    });
  </script>
@endsection
