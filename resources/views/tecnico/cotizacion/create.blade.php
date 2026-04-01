@extends('layouts.tecnico')
@section('page-title', 'Nueva Cotización')

@section('content')
<div class="pj-wrapper" id="cotizacion-app">

    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-clipboard-plus me-2"></i>Nueva Cotización</h1>
        <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    @if($errors->any())
    <div class="alert mb-3 cot-alert-error">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Revisa los campos marcados antes de enviar.
    </div>
    @endif

    <form action="{{ route('tecnico.cotizacion.store', $viewData['project']->getId()) }}" method="POST" id="cotizacionForm">
        @csrf

        <div class="cot-header-card mb-4">
            <p class="cot-project-name">
                <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
            </p>
            <p class="cot-project-meta">
                <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCiudad() }} — {{ $viewData['project']->getDireccion() }}
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
            <table class="cot-table" id="tabla-materiales">
                <thead>
                    <tr>
                        <th>Material / Especificación</th>
                        <th>Unidad</th>
                        <th style="width: 150px;">Cantidad</th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody id="lista-materiales">
                    <tr id="emptyRow">
                        <td colspan="4" class="cot-empty">
                            <i class="bi bi-box-seam cot-empty-icon d-block mb-1"></i>
                            Agrega materiales usando el selector de arriba
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="cot-footer">
            <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}" class="um-btn-icon um-btn-icon--edit px-4 py-2">
                Cancelar
            </a>
            <button type="submit" class="um-btn-primary px-4 py-2" id="submitBtn">
                <i class="bi bi-send-fill me-1"></i> Enviar Cotización
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnAdd = document.getElementById('btn-add-material');
    const selector = document.getElementById('material-selector');
    const tbody = document.getElementById('lista-materiales');
    const emptyRow = document.getElementById('emptyRow');
    let rowIdx = 0;

    function updateEmpty() {
        const hasRows = tbody.querySelectorAll('tr[data-id]').length > 0;
        emptyRow.style.display = hasRows ? 'none' : '';
    }

    btnAdd.addEventListener('click', function () {
        const selected = selector.options[selector.selectedIndex];
        if (!selected.value) return;

        const id = selected.value;
        const label = selected.getAttribute('data-label');
        const unidades = selected.getAttribute('data-unidades');

        if (tbody.querySelector(`tr[data-id="${id}"]`)) {
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
                <input type="number" name="materiales[${rowIdx}][cantidad]" class="form-control" value="1" min="0.01" step="0.01" required>
            </td>
            <td>
                <button type="button" class="btn btn-link text-danger btn-remove"><i class="bi bi-trash"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
        rowIdx++;
        selector.value = '';
        updateEmpty();
    });

    tbody.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('tr').remove();
            updateEmpty();
        }
    });

    document.getElementById('cotizacionForm').addEventListener('submit', function (e) {
        const rows = tbody.querySelectorAll('tr[data-id]');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Debes agregar al menos un material antes de enviar.');
        }
    });

    updateEmpty();
});
</script>
@endsection
