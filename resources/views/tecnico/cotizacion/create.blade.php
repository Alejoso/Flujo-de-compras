@extends('layouts.tecnico')
@section('page-title', 'Nueva Cotización')

@section('content')
<div class="pj-wrapper">

    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-clipboard-plus me-2"></i>Nueva Cotización</h1>
        <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="cot-header-card">
        <p class="cot-project-name">
            <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
        </p>
        <p class="cot-project-meta">
            <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCiudad() }} — {{ $viewData['project']->getDireccion() }}
        </p>
    </div>

    @if($errors->any())
    <div class="alert mb-3 cot-alert-error">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Revisa los campos marcados antes de enviar.
    </div>
    @endif

    <form action="{{ route('tecnico.cotizacion.store', $viewData['project']->getId()) }}" method="POST" id="cotizacionForm">
        @csrf

        <div class="d-flex align-items-center mb-2">
            <span class="cot-section-label">Materiales</span>
            <span class="cot-counter" id="rowCounter">0</span>
        </div>

        <div class="cot-table-wrap">
            <table class="cot-table" id="materialesTable">
                <thead>
                    <tr>
                        <th class="cot-col-material">Material</th>
                        <th class="cot-col-unidad">Unidad</th>
                        <th class="cot-col-cantidad">Cantidad</th>
                        <th class="cot-col-action"></th>
                    </tr>
                </thead>
                <tbody id="materialesBody">
                    <tr id="emptyRow">
                        <td colspan="4" class="cot-empty">
                            <i class="bi bi-box-seam cot-empty-icon d-block mb-1"></i>
                            Agrega materiales usando el botón de abajo
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button type="button" class="cot-btn-add" id="addRowBtn">
            <i class="bi bi-plus-circle-fill"></i> Agregar material
        </button>

        <div class="cot-footer">
            <a href="{{ route('tecnico.project.index') }}" class="um-btn-icon um-btn-icon--edit px-4 py-2">
                Cancelar
            </a>
            <button type="submit" class="um-btn-primary px-4 py-2" id="submitBtn">
                <i class="bi bi-send-fill me-1"></i> Enviar Cotización
            </button>
        </div>

    </form>
</div>

<script>
const TIPO_MATERIALES = @json($viewData['tipoMaterialesJson']);

const TM_MAP = Object.fromEntries(TIPO_MATERIALES.map(tm => [tm.id, tm]));

let rowIndex = 0;

function updateCounter() {
    const rows = document.querySelectorAll('.material-row');
    document.getElementById('rowCounter').textContent = rows.length;
    document.getElementById('emptyRow').style.display = rows.length === 0 ? '' : 'none';
}

function buildOptions(selectedId = '') {
    return TIPO_MATERIALES.map(tm =>
        `<option value="${tm.id}" ${tm.id == selectedId ? 'selected' : ''}>${tm.label}</option>`
    ).join('');
}

function getUnidadLabel(tmId) {
    const tm = TM_MAP[tmId];
    if (!tm || !tm.unidades.length) return '—';
    return tm.unidades.join(' / ');
}

function addRow(tmId = '', cantidad = '') {
    const idx = rowIndex++;
    const tr = document.createElement('tr');
    tr.className = 'material-row';
    tr.dataset.idx = idx;
    tr.innerHTML = `
        <td>
            <select name="materiales[${idx}][tipoMaterialId]" class="cot-select" required>
                <option value="">Selecciona un material</option>
                ${buildOptions(tmId)}
            </select>
        </td>
        <td>
            <span class="cot-unidad-label">${tmId ? getUnidadLabel(tmId) : '—'}</span>
        </td>
        <td>
            <input type="number"
                   name="materiales[${idx}][cantidad]"
                   class="cot-input"
                   value="${cantidad}"
                   placeholder="0"
                   min="0.01"
                   step="0.01"
                   required>
        </td>
        <td class="cot-td-actions">
            <button type="button" class="cot-btn-delete" title="Eliminar">
                <i class="bi bi-trash3-fill"></i>
            </button>
        </td>
    `;
    tr.querySelector('.cot-select').addEventListener('change', function() {
        tr.querySelector('.cot-unidad-label').textContent = getUnidadLabel(this.value);
    });
    tr.querySelector('.cot-btn-delete').addEventListener('click', () => {
        tr.remove();
        updateCounter();
    });
    document.getElementById('materialesBody').appendChild(tr);
    updateCounter();
    tr.querySelector('.cot-select').focus();
}

document.getElementById('addRowBtn').addEventListener('click', () => addRow());

document.getElementById('cotizacionForm').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('.material-row');
    if (rows.length === 0) {
        e.preventDefault();
        alert('Debes agregar al menos un material antes de enviar.');
        return;
    }
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Enviando...';
});

updateCounter();
</script>
@endsection
