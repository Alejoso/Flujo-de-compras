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
        <div class="row mt-3">
          <div class="col-md-8">
            <label class="form-label fw-bold">Seleccionar Material para agregar</label>
            <select id="material-selector" class="form-select">
              <option value="">Elija un material...</option>
              @foreach ($viewData['tipoMateriales'] as $tm)
                @php
                    $label = $tm->getMaterial()->getDescripcion().' — '.$tm->getTipo()->getEspecificacion();
                    $unidades = $tm->getTipo()->getUnidadMedidaCantidades()->map(fn($umc) => $umc->getUnidadMedida()->getAbreviatura())->unique()->implode(' / ');
                @endphp
                <option value="{{ $tm->getId() }}" data-label="{{ $label }}" data-unidades="{{ $unidades }}">
                  {{ $label }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <button type="button" id="btn-add-material" class="btn btn-primary w-100">
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
              <th>Unidad</th>
              <th style="width: 150px;">Cantidad</th>
              <th style="width: 50px;"></th>
            </tr>
          </thead>
          <tbody id="lista-materiales">
            @foreach ($viewData['version']->getTipoMaterialVersionCotizaciones() as $index => $item)
              <tr data-id="{{ $item->getTipoMaterial()->getId() }}">
                <td>
                  {{ $item->getTipoMaterial()->getMaterial()->getDescripcion() }} —
                  {{ $item->getTipoMaterial()->getTipo()->getEspecificacion() }}
                  <input type="hidden" name="materiales[{{ $index }}][tipoMaterialId]"
                    value="{{ $item->getTipoMaterial()->getId() }}">
                </td>
                <td>
                  {{ $item->getTipoMaterial()->getTipo()->getUnidadMedidaCantidades()->map(fn($umc) => $umc->getUnidadMedida()->getAbreviatura())->unique()->implode(' / ') }}
                </td>
                <td>
                  <input type="number" name="materiales[{{ $index }}][cantidad]" class="form-control"
                    value="{{ $item->getCantidad() }}" step="0.01" required>
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
    document.addEventListener('DOMContentLoaded', function() {
      const btnAdd = document.getElementById('btn-add-material');
      const selector = document.getElementById('material-selector');
      const tbody = document.getElementById('lista-materiales');
      let rowIdx = {{ $viewData['version']->getTipoMaterialVersionCotizaciones()->count() }};

      btnAdd.addEventListener('click', function() {
        const selected = selector.options[selector.selectedIndex];
        if (!selected.value) return;

        const id = selected.value;
        const label = selected.getAttribute('data-label');
        const unidades = selected.getAttribute('data-unidades');

        if (document.querySelector(`tr[data-id="${id}"]`)) {
          alert('Este material ya está en la lista.');
          return;
        }

        const tr = document.createElement('tr');
        tr.setAttribute('data-id', id);
        tr.innerHTML = `
            <td>
                ${label}
                <input type="hidden" name="materiales[${rowIdx}][tipoMaterialId]" value="${id}">
            </td>
            <td>${unidades}</td>
            <td>
                <input type="number" name="materiales[${rowIdx}][cantidad]" class="form-control" value="1" step="0.01" required>
            </td>
            <td>
                <button type="button" class="btn btn-link text-danger btn-remove"><i class="bi bi-trash"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
        rowIdx++;
        selector.value = '';
      });

      tbody.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove')) {
          e.target.closest('tr').remove();
        }
      });
    });
  </script>
@endsection
