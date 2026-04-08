document.addEventListener('DOMContentLoaded', function () {

    /* ── Referencias ── */
    const app             = document.getElementById('material-app');
    const tiposContainer  = document.getElementById('tiposContainer');
    const btnAddTipo      = document.getElementById('btnAddTipo');
    const newField        = document.getElementById('newMaterialField');
    const existField      = document.getElementById('existingMaterialField');
    const modeRadios      = document.querySelectorAll('input[name="material_mode"]');

    /* ── Data del servidor (inyectada via data-attributes) ── */
    const unidades       = JSON.parse(app.dataset.unidades);
    const presentaciones = JSON.parse(app.dataset.presentaciones);

    let tipoIndex = 0;

    /* ══════════════════════════════════
       Toggle modo material (nuevo / existente)
       ══════════════════════════════════ */
    function toggleMode() {
        var mode = document.querySelector('input[name="material_mode"]:checked').value;
        newField.style.display   = mode === 'new' ? '' : 'none';
        existField.style.display = mode === 'existing' ? '' : 'none';
    }

    modeRadios.forEach(function (r) {
        r.addEventListener('change', toggleMode);
    });
    toggleMode();

    /* ══════════════════════════════════
       Builders — crean HTML dinámicamente
       ══════════════════════════════════ */

    function buildUnidadSelect(name) {
        var select = document.createElement('select');
        select.className = 'form-select';
        select.name = name;

        var optNone = document.createElement('option');
        optNone.value = '';
        optNone.textContent = '— Ninguna —';
        select.appendChild(optNone);

        unidades.forEach(function (u) {
            var opt = document.createElement('option');
            opt.value = u.id;
            opt.textContent = u.nombre + ' (' + u.abreviatura + ')';
            select.appendChild(opt);
        });

        return select;
    }

    function buildPresentacionSelect(name) {
        var select = document.createElement('select');
        select.className = 'form-select form-select-sm';
        select.name = name;

        var optNone = document.createElement('option');
        optNone.value = '';
        optNone.textContent = '— Seleccione —';
        select.appendChild(optNone);

        presentaciones.forEach(function (p) {
            var opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.nombre;
            select.appendChild(opt);
        });

        return select;
    }

    /* ══════════════════════════════════
       Agregar presentación a un tipo
       ══════════════════════════════════ */
    function addPresentacion(container, tIdx, pIdx) {
        var row = document.createElement('div');
        row.className = 'presentacion-row d-flex gap-2 align-items-end mb-2';

        // Select presentación
        var divSelect = document.createElement('div');
        divSelect.className = 'flex-grow-1';

        var lblSelect = document.createElement('label');
        lblSelect.className = 'form-label';
        lblSelect.style.fontSize = '0.78rem';
        lblSelect.textContent = 'Presentación';
        divSelect.appendChild(lblSelect);

        var selectPres = buildPresentacionSelect(
            'tipos[' + tIdx + '][presentaciones][' + pIdx + '][presentacionId]'
        );
        divSelect.appendChild(selectPres);
        row.appendChild(divSelect);

        // Input cantidad
        var divCant = document.createElement('div');
        divCant.style.width = '140px';

        var lblCant = document.createElement('label');
        lblCant.className = 'form-label';
        lblCant.style.fontSize = '0.78rem';
        lblCant.textContent = 'Cantidad';
        divCant.appendChild(lblCant);

        var inputCant = document.createElement('input');
        inputCant.type = 'text';
        inputCant.className = 'form-control form-control-sm';
        inputCant.name = 'tipos[' + tIdx + '][presentaciones][' + pIdx + '][cantidadPresentacion]';
        inputCant.placeholder = 'Ej: 100';
        divCant.appendChild(inputCant);
        row.appendChild(divCant);

        // Botón eliminar
        var btnRemove = document.createElement('button');
        btnRemove.type = 'button';
        btnRemove.className = 'um-btn-icon um-btn-icon--delete btn-remove-presentacion';
        btnRemove.style.marginBottom = '2px';
        btnRemove.title = 'Eliminar';
        btnRemove.innerHTML = '<i class="bi bi-dash-circle"></i>';
        btnRemove.addEventListener('click', function () {
            row.remove();
        });
        row.appendChild(btnRemove);

        container.appendChild(row);
    }

    /* ══════════════════════════════════
       Agregar bloque Tipo
       ══════════════════════════════════ */
    function addTipo() {
        var currentIdx = tipoIndex;
        var presIndex  = 0;

        // Block
        var block = document.createElement('div');
        block.className = 'tipo-block mb-3';
        block.style.cssText = 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:1.25rem;';

        // Header
        var header = document.createElement('div');
        header.className = 'd-flex justify-content-between align-items-center mb-3';

        var title = document.createElement('strong');
        title.style.cssText = 'color:#F5C800;font-size:0.9rem;';
        title.innerHTML = '<i class="bi bi-tag"></i> Tipo #<span class="tipo-number">' + (currentIdx + 1) + '</span>';

        var btnRemoveTipo = document.createElement('button');
        btnRemoveTipo.type = 'button';
        btnRemoveTipo.className = 'um-btn-icon um-btn-icon--delete';
        btnRemoveTipo.title = 'Eliminar tipo';
        btnRemoveTipo.innerHTML = '<i class="bi bi-x-lg"></i>';
        btnRemoveTipo.addEventListener('click', function () {
            block.remove();
            renumberTipos();
        });

        header.appendChild(title);
        header.appendChild(btnRemoveTipo);
        block.appendChild(header);

        // Row: especificación + unidad
        var row = document.createElement('div');
        row.className = 'row g-3 mb-3';

        // Especificación
        var colEsp = document.createElement('div');
        colEsp.className = 'col-md-7';

        var lblEsp = document.createElement('label');
        lblEsp.className = 'form-label';
        lblEsp.textContent = 'Especificación';
        colEsp.appendChild(lblEsp);

        var inputEsp = document.createElement('input');
        inputEsp.type = 'text';
        inputEsp.className = 'form-control';
        inputEsp.name = 'tipos[' + currentIdx + '][especificacion]';
        inputEsp.placeholder = 'Ej: # 12 NEGRO, 20 Amperios, REDONDA 18 WATTS...';
        colEsp.appendChild(inputEsp);
        row.appendChild(colEsp);

        // Unidad de medida
        var colUni = document.createElement('div');
        colUni.className = 'col-md-5';

        var lblUni = document.createElement('label');
        lblUni.className = 'form-label';
        lblUni.innerHTML = 'Unidad de medida <small style="color:#5A5A5A">(opcional)</small>';
        colUni.appendChild(lblUni);

        var selectUni = buildUnidadSelect('tipos[' + currentIdx + '][unidadMedidaId]');
        colUni.appendChild(selectUni);
        row.appendChild(colUni);

        block.appendChild(row);

        // Presentaciones section
        var presSection = document.createElement('div');
        presSection.style.cssText = 'margin-left:1rem;border-left:2px solid rgba(245,200,0,0.2);padding-left:1rem;';

        var presHeader = document.createElement('div');
        presHeader.className = 'd-flex justify-content-between align-items-center mb-2';

        var presLabel = document.createElement('span');
        presLabel.style.cssText = 'color:#A0A0A0;font-size:0.8rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;';
        presLabel.textContent = 'Presentaciones';

        var btnAddPres = document.createElement('button');
        btnAddPres.type = 'button';
        btnAddPres.style.cssText = 'background:none;border:1px solid rgba(245,200,0,0.3);color:#F5C800;font-size:0.78rem;padding:3px 10px;border-radius:6px;cursor:pointer;';
        btnAddPres.innerHTML = '<i class="bi bi-plus"></i> Presentación';

        presHeader.appendChild(presLabel);
        presHeader.appendChild(btnAddPres);
        presSection.appendChild(presHeader);

        var presContainer = document.createElement('div');
        presContainer.className = 'presentaciones-container';
        presSection.appendChild(presContainer);
        block.appendChild(presSection);

        // Evento: agregar presentación
        btnAddPres.addEventListener('click', function () {
            addPresentacion(presContainer, currentIdx, presIndex);
            presIndex++;
        });

        // Agregar una presentación por defecto
        addPresentacion(presContainer, currentIdx, presIndex);
        presIndex++;

        tiposContainer.appendChild(block);
        tipoIndex++;
    }

    /* ══════════════════════════════════
       Renumerar tipos visualmente
       ══════════════════════════════════ */
    function renumberTipos() {
        var blocks = tiposContainer.querySelectorAll('.tipo-block');
        blocks.forEach(function (block, i) {
            block.querySelector('.tipo-number').textContent = i + 1;
        });
    }

    /* ══════════════════════════════════
       Init — agregar un tipo por defecto
       ══════════════════════════════════ */
    btnAddTipo.addEventListener('click', addTipo);
    addTipo();

});