(function () {
    const app = document.getElementById('quotation-app');
    if (!app) return;

    const searchUrl = app.dataset.searchUrl;
    const hasEmptyRow = app.dataset.hasEmptyRow === '1';
    const msgSelectMaterial = app.dataset.msgSelectMaterial;
    const msgNoResults = app.dataset.msgNoResults;
    const msgSelectPresentation = app.dataset.msgSelectPresentation;
    const msgDuplicate = app.dataset.msgDuplicate;
    const msgNoMaterials = app.dataset.msgNoMaterials;

    const materialSearch = document.getElementById('material-search');
    const acList = document.getElementById('autocomplete-list');
    const presentationSelect = document.getElementById('presentation-select');
    const displayUnit = document.getElementById('display-unit');
    const btnAdd = document.getElementById('btn-add-material');
    const tbody = document.getElementById('materials-list');
    const emptyRow = document.getElementById('emptyRow');
    const quotationForm = document.getElementById('quotationForm');

    let tmData = {};        // Search results cache { tmId: { label, presentations[] } }
    let selectedTmId = null;
    let rowIdx = parseInt(app.dataset.rowIdx, 10) || 0; // Index for input names

    // Shows or hides the empty row based on whether the table has materials
    function updateEmpty() {
        if (!emptyRow) return;
        emptyRow.style.display = tbody.querySelectorAll('tr[data-id]').length > 0 ? 'none' : '';
    }

    // Resets the presentation selector to its initial disabled state
    function resetPresentation() {
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = msgSelectMaterial;
        presentationSelect.replaceChildren(opt);
        presentationSelect.disabled = true;
        displayUnit.value = '';
        btnAdd.disabled = true;
        selectedTmId = null;
    }

    // Renders the autocomplete dropdown with the received results
    function showDropdown(data) {
        acList.replaceChildren();
        const keys = Object.keys(data);

        if (keys.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'ac-empty';
            empty.textContent = msgNoResults;
            acList.appendChild(empty);
        } else {
            keys.forEach(function (tmId) {
                const item = document.createElement('div');
                item.className = 'ac-item';
                item.textContent = data[tmId].label;
                // mousedown instead of click so it fires before the search blur
                item.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    selectMaterial(tmId, data[tmId].label);
                });
                acList.appendChild(item);
            });
        }
        acList.style.display = 'block';
    }

    // Hides the autocomplete dropdown
    function hideDropdown() {
        acList.style.display = 'none';
    }

    // Selects a material: fills the search input and populates presentations
    function selectMaterial(tmId, label) {
        selectedTmId = tmId;
        materialSearch.value = label;
        hideDropdown();

        // Populate presentation selector with options for the chosen material
        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.textContent = msgSelectPresentation;
        presentationSelect.replaceChildren(defaultOpt);

        tmData[tmId].presentations.forEach(function (p) {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.name;
            opt.dataset.unit = p.unit;
            presentationSelect.appendChild(opt);
        });
        presentationSelect.disabled = false;
        displayUnit.value = '';
        btnAdd.disabled = true; // Enabled only when a presentation is chosen
    }

    // Fetches from server and updates the tmData cache with results
    function fetchMaterials(query) {
        fetch(searchUrl + '?q=' + encodeURIComponent(query))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                tmData = data;
                showDropdown(data);
            })
            .catch(function (err) { console.error(err); });
    }

    // Builds and returns a <tr> ready to insert into the materials table
    // Inputs use rowIdx in their name so the server receives them as an array
    function buildRow(ptmId, label, ptmName, unit) {
        const tr = document.createElement('tr');
        tr.setAttribute('data-id', ptmId);

        // Material cell + hidden input with presentation ID
        const tdMaterial = document.createElement('td');
        tdMaterial.textContent = label;
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'materials[' + rowIdx + '][presentation_material_type_id]';
        hiddenInput.value = ptmId;
        tdMaterial.appendChild(hiddenInput);

        // Presentation cell
        const tdPresentation = document.createElement('td');
        tdPresentation.textContent = ptmName;

        // Unit cell
        const tdUnit = document.createElement('td');
        tdUnit.textContent = unit;

        // Quantity cell (numeric input, minimum 1)
        const tdQuantity = document.createElement('td');
        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'materials[' + rowIdx + '][quantity]';
        quantityInput.className = 'form-control';
        quantityInput.value = '1';
        quantityInput.min = '1';
        quantityInput.step = '1';
        quantityInput.required = true;
        tdQuantity.appendChild(quantityInput);

        // Delete row button cell
        const tdAction = document.createElement('td');
        const btnRemove = document.createElement('button');
        btnRemove.type = 'button';
        btnRemove.className = 'btn btn-link text-danger btn-remove';
        const icon = document.createElement('i');
        icon.className = 'bi bi-trash';
        btnRemove.appendChild(icon);
        tdAction.appendChild(btnRemove);

        tr.append(tdMaterial, tdPresentation, tdUnit, tdQuantity, tdAction);
        return tr;
    }

    // Events
    let timeoutId;

    // Debounced search (300ms) when typing in the material search input
    materialSearch.addEventListener('input', function () {
        clearTimeout(timeoutId);
        resetPresentation();
        const query = this.value.trim();
        timeoutId = setTimeout(function () { fetchMaterials(query); }, 300);
    });

    // On focus: show cached results or run an empty search
    materialSearch.addEventListener('focus', function () {
        if (Object.keys(tmData).length > 0) {
            showDropdown(tmData);
        } else {
            fetchMaterials('');
        }
    });

    // 150ms delay so the item mousedown fires before hiding the dropdown
    materialSearch.addEventListener('blur', function () {
        setTimeout(hideDropdown, 150);
    });

    // Show unit and enable add button when a presentation is selected
    presentationSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (opt.value) {
            displayUnit.value = opt.dataset.unit || '';
            btnAdd.disabled = false;
        } else {
            displayUnit.value = '';
            btnAdd.disabled = true;
        }
    });

    // Add row to table; prevent duplicates by data-id
    btnAdd.addEventListener('click', function () {
        const ptmId = presentationSelect.value;
        const ptmName = presentationSelect.options[presentationSelect.selectedIndex].textContent;
        const unit = displayUnit.value;
        const label = tmData[selectedTmId].label;

        if (tbody.querySelector('tr[data-id="' + ptmId + '"]')) {
            alert(msgDuplicate);
            return;
        }

        tbody.appendChild(buildRow(ptmId, label, ptmName, unit));
        rowIdx++;

        // Clear search form after adding
        materialSearch.value = '';
        tmData = {};
        resetPresentation();
        updateEmpty();
    });

    // Event delegation: remove row when clicking any .btn-remove
    tbody.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('tr').remove();
            updateEmpty();
        }
    });

    // Prevent form submission if no materials have been added
    if (quotationForm) {
        quotationForm.addEventListener('submit', function (e) {
            if (tbody.querySelectorAll('tr[data-id]').length === 0) {
                e.preventDefault();
                alert(msgNoMaterials);
            }
        });
    }

    if (hasEmptyRow) updateEmpty();
})();
