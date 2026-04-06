(function () {
    const app = document.getElementById('cotizacion-app');
    if (!app) return;

    const searchUrl     = app.dataset.searchUrl;
    const hasEmptyRow   = app.dataset.hasEmptyRow === '1';

    const buscadorMaterial = document.getElementById('buscador-material');
    const acList           = document.getElementById('autocomplete-list');
    const selectorPres     = document.getElementById('selector-presentacion');
    const displayUnidad    = document.getElementById('display-unidad');
    const btnAdd           = document.getElementById('btn-add-material');
    const tbody            = document.getElementById('lista-materiales');
    const emptyRow         = document.getElementById('emptyRow');
    const cotizacionForm   = document.getElementById('cotizacionForm');

    let tmData       = {};
    let selectedTmId = null;
    let rowIdx       = parseInt(app.dataset.rowIdx, 10) || 0;

    // Muestra u oculta la fila de estado vacío (solo en la vista de crear)

    function updateEmpty() {
        if (!emptyRow) return;
        emptyRow.style.display = tbody.querySelectorAll('tr[data-id]').length > 0 ? 'none' : '';
    }

    // Reinicia el selector de presentación a su estado inicial

    function resetPresentacion() {
        selectorPres.innerHTML = '<option value="">— elige material primero —</option>';
        selectorPres.disabled  = true;
        displayUnidad.value    = '';
        btnAdd.disabled        = true;
        selectedTmId           = null;
    }

    // Renderiza el dropdown de autocompletado con los resultados recibidos

    function showDropdown(data) {
        acList.innerHTML = '';
        const keys = Object.keys(data);

        if (keys.length === 0) {
            acList.innerHTML = '<div class="ac-empty">Sin resultados</div>';
        } else {
            keys.forEach(function (tmId) {
                const item = document.createElement('div');
                item.className = 'ac-item';
                item.textContent = data[tmId].label;
                item.addEventListener('mousedown', function (e) {
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
        selectedTmId           = tmId;
        buscadorMaterial.value = label;
        hideDropdown();

        selectorPres.innerHTML = '<option value="">Seleccione presentación...</option>';
        tmData[tmId].presentaciones.forEach(function (p) {
            const opt = document.createElement('option');
            opt.value          = p.id;
            opt.textContent    = p.nombre;
            opt.dataset.unidad = p.unidad;
            selectorPres.appendChild(opt);
        });
        selectorPres.disabled = false;
        displayUnidad.value   = '';
        btnAdd.disabled       = true;
    }

    function fetchMateriales(query) {
        fetch(searchUrl + '?q=' + encodeURIComponent(query))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                tmData = data;
                showDropdown(data);
            })
            .catch(function (err) { console.error(err); });
    }

    // Eventos del formulario

    let timeoutId;

    buscadorMaterial.addEventListener('input', function () {
        clearTimeout(timeoutId);
        resetPresentacion();
        const query = this.value.trim();
        timeoutId = setTimeout(function () { fetchMateriales(query); }, 300);
    });

    buscadorMaterial.addEventListener('focus', function () {
        if (Object.keys(tmData).length > 0) {
            showDropdown(tmData);
        } else {
            fetchMateriales('');
        }
    });

    buscadorMaterial.addEventListener('blur', function () {
        setTimeout(hideDropdown, 150);
    });

    selectorPres.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (opt.value) {
            displayUnidad.value = opt.dataset.unidad || '';
            btnAdd.disabled     = false;
        } else {
            displayUnidad.value = '';
            btnAdd.disabled     = true;
        }
    });

    btnAdd.addEventListener('click', function () {
        const ptmId    = selectorPres.value;
        const ptmNombre = selectorPres.options[selectorPres.selectedIndex].textContent;
        const unidad   = displayUnidad.value;
        const label    = tmData[selectedTmId].label;

        if (tbody.querySelector('tr[data-id="' + ptmId + '"]')) {
            alert('Esta combinación ya está en la lista.');
            return;
        }

        const tr = document.createElement('tr');
        tr.setAttribute('data-id', ptmId);
        tr.innerHTML =
            '<td>' +
                label +
                '<input type="hidden" name="materiales[' + rowIdx + '][presentacionTipoMaterialId]" value="' + ptmId + '">' +
            '</td>' +
            '<td>' + ptmNombre + '</td>' +
            '<td>' + unidad + '</td>' +
            '<td>' +
                '<input type="number" name="materiales[' + rowIdx + '][cantidad]" class="form-control" value="1" min="0.01" step="0.01" required>' +
            '</td>' +
            '<td>' +
                '<button type="button" class="btn btn-link text-danger btn-remove"><i class="bi bi-trash"></i></button>' +
            '</td>';

        tbody.appendChild(tr);
        rowIdx++;

        buscadorMaterial.value = '';
        tmData = {};
        resetPresentacion();
        updateEmpty();
    });

    tbody.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('tr').remove();
            updateEmpty();
        }
    });

    // Validación al enviar el formulario (solo en la vista de crear)

    if (cotizacionForm) {
        cotizacionForm.addEventListener('submit', function (e) {
            if (tbody.querySelectorAll('tr[data-id]').length === 0) {
                e.preventDefault();
                alert('Debes agregar al menos un material antes de enviar.');
            }
        });
    }

    // Inicialización
    if (hasEmptyRow) updateEmpty();
})();
