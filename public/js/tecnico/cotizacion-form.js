(function () {
    const app = document.getElementById('cotizacion-app');
    if (!app) return;

    const searchUrl = app.dataset.searchUrl;
    const hasEmptyRow = app.dataset.hasEmptyRow === '1';

    const buscadorMaterial = document.getElementById('buscador-material');
    const acList = document.getElementById('autocomplete-list');
    const selectorPres = document.getElementById('selector-presentacion');
    const displayUnidad = document.getElementById('display-unidad');
    const btnAdd = document.getElementById('btn-add-material');
    const tbody = document.getElementById('lista-materiales');
    const emptyRow = document.getElementById('emptyRow');
    const cotizacionForm = document.getElementById('cotizacionForm');

    let tmData = {};        // Cache de resultados de búsqueda { tmId: { label, presentaciones[] } }
    let selectedTmId = null;
    let rowIdx = parseInt(app.dataset.rowIdx, 10) || 0; // Índice para los nombres de los inputs

    // Muestra u oculta la fila vacía según si hay materiales en la tabla
    function updateEmpty() {
        if (!emptyRow) return;
        emptyRow.style.display = tbody.querySelectorAll('tr[data-id]').length > 0 ? 'none' : '';
    }

    // Deja el selector de presentaciones en su estado inicial deshabilitado
    function resetPresentacion() {
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = '— elige material primero —';
        selectorPres.replaceChildren(opt);
        selectorPres.disabled = true;
        displayUnidad.value = '';
        btnAdd.disabled = true;
        selectedTmId = null;
    }

    // Renderiza el dropdown de autocompletado con los resultados recibidos
    function showDropdown(data) {
        acList.replaceChildren();
        const keys = Object.keys(data);

        if (keys.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'ac-empty';
            empty.textContent = 'Sin resultados';
            acList.appendChild(empty);
        } else {
            keys.forEach(function (tmId) {
                const item = document.createElement('div');
                item.className = 'ac-item';
                item.textContent = data[tmId].label;
                // mousedown en lugar de click para que se dispare antes del blur del buscador
                item.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    selectMaterial(tmId, data[tmId].label);
                });
                acList.appendChild(item);
            });
        }
        acList.style.display = 'block';
    }

    // Oculta el dropdown de autocompletado
    function hideDropdown() {
        acList.style.display = 'none';
    }

    // Selecciona un material: rellena el buscador y popula las presentaciones
    function selectMaterial(tmId, label) {
        selectedTmId = tmId;
        buscadorMaterial.value = label;
        hideDropdown();

        // Poblar selector de presentaciones con las opciones del material elegido
        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.textContent = 'Seleccione presentación...';
        selectorPres.replaceChildren(defaultOpt);

        tmData[tmId].presentaciones.forEach(function (p) {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.nombre;
            opt.dataset.unidad = p.unidad;
            selectorPres.appendChild(opt);
        });
        selectorPres.disabled = false;
        displayUnidad.value = '';
        btnAdd.disabled = true; // Se habilita solo al elegir una presentación
    }

    // Consulta el servidor y actualiza el cache tmData con los resultados
    function fetchMateriales(query) {
        fetch(searchUrl + '?q=' + encodeURIComponent(query))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                tmData = data;
                showDropdown(data);
            })
            .catch(function (err) { console.error(err); });
    }

    // Construye y devuelve un <tr> listo para insertar en la tabla de materiales
    // Los inputs usan rowIdx en su name para que el servidor los reciba como array
    function buildFila(ptmId, label, ptmNombre, unidad) {
        const tr = document.createElement('tr');
        tr.setAttribute('data-id', ptmId);

        // Celda material + hidden con el ID de la presentación
        const tdMaterial = document.createElement('td');
        tdMaterial.textContent = label;
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'materials[' + rowIdx + '][presentation_material_type_id]';
        hiddenInput.value = ptmId;
        tdMaterial.appendChild(hiddenInput);

        // Celda presentación
        const tdPres = document.createElement('td');
        tdPres.textContent = ptmNombre;

        // Celda unidad
        const tdUnidad = document.createElement('td');
        tdUnidad.textContent = unidad;

        // Celda cantidad (input numérico, mínimo 1)
        const tdCantidad = document.createElement('td');
        const cantidadInput = document.createElement('input');
        cantidadInput.type = 'number';
        cantidadInput.name = 'materials[' + rowIdx + '][quantity]';
        cantidadInput.className = 'form-control';
        cantidadInput.value = '1';
        cantidadInput.min = '1';
        cantidadInput.step = '1';
        cantidadInput.required = true;
        tdCantidad.appendChild(cantidadInput);

        // Celda con botón de eliminar fila
        const tdAccion = document.createElement('td');
        const btnRemove = document.createElement('button');
        btnRemove.type = 'button';
        btnRemove.className = 'btn btn-link text-danger btn-remove';
        const icon = document.createElement('i');
        icon.className = 'bi bi-trash';
        btnRemove.appendChild(icon);
        tdAccion.appendChild(btnRemove);

        tr.append(tdMaterial, tdPres, tdUnidad, tdCantidad, tdAccion);
        return tr;
    }

    // Eventos
    let timeoutId;

    // Búsqueda con debounce de 300 ms al escribir en el buscador
    buscadorMaterial.addEventListener('input', function () {
        clearTimeout(timeoutId);
        resetPresentacion();
        const query = this.value.trim();
        timeoutId = setTimeout(function () { fetchMateriales(query); }, 300);
    });

    // Al enfocar: muestra resultados cacheados o hace búsqueda vacía
    buscadorMaterial.addEventListener('focus', function () {
        if (Object.keys(tmData).length > 0) {
            showDropdown(tmData);
        } else {
            fetchMateriales('');
        }
    });

    // Retardo de 150 ms para que el mousedown del ítem se procese antes de ocultar
    buscadorMaterial.addEventListener('blur', function () {
        setTimeout(hideDropdown, 150);
    });

    // Muestra la unidad y habilita el botón al elegir una presentación
    selectorPres.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (opt.value) {
            displayUnidad.value = opt.dataset.unidad || '';
            btnAdd.disabled = false;
        } else {
            displayUnidad.value = '';
            btnAdd.disabled = true;
        }
    });

    // Agrega la fila a la tabla; evita duplicados por data-id
    btnAdd.addEventListener('click', function () {
        const ptmId = selectorPres.value;
        const ptmNombre = selectorPres.options[selectorPres.selectedIndex].textContent;
        const unidad = displayUnidad.value;
        const label = tmData[selectedTmId].label;

        if (tbody.querySelector('tr[data-id="' + ptmId + '"]')) {
            alert('Esta combinación ya está en la lista.');
            return;
        }

        tbody.appendChild(buildFila(ptmId, label, ptmNombre, unidad));
        rowIdx++;

        // Limpiar formulario de búsqueda tras agregar
        buscadorMaterial.value = '';
        tmData = {};
        resetPresentacion();
        updateEmpty();
    });

    // Delegación de eventos: elimina la fila al pulsar cualquier .btn-remove
    tbody.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('tr').remove();
            updateEmpty();
        }
    });

    // Impide enviar el formulario si no hay materiales agregados
    if (cotizacionForm) {
        cotizacionForm.addEventListener('submit', function (e) {
            if (tbody.querySelectorAll('tr[data-id]').length === 0) {
                e.preventDefault();
                alert('Debes agregar al menos un material antes de enviar.');
            }
        });
    }

    if (hasEmptyRow) updateEmpty();
})();
