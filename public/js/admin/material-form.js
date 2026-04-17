document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('materialForm');
  var typesContainer = document.getElementById('typesContainer');
  var btnAddType = document.getElementById('btnAddType');
  var typeTemplate = document.getElementById('typeTemplate');
  var presentationTemplate = document.getElementById('presentationTemplate');
  var existingTypes = JSON.parse(form.dataset.existingTypes || '[]');
  var typeIndex = 0;

  // ── Tom Select defaults ──
  var tomSelectConfig = {
    allowEmptyOption: true,
    sortField: { field: 'text', direction: 'asc' },
    maxOptions: null,
    openOnFocus: true,
    dropdownParent: 'body',
    placeholder: '— Seleccione —',
  };

  function initTomSelect(selectElement) {
    if (selectElement.tomselect) return;

    // Remove the empty "Seleccione" option — Tom Select handles it via placeholder
    var emptyOption = selectElement.querySelector('option[value=""]');
    if (emptyOption) {
      emptyOption.remove();
    }

    return new TomSelect(selectElement, tomSelectConfig);
  }

  function destroyTomSelect(selectElement) {
    if (selectElement.tomselect) {
      selectElement.tomselect.destroy();
    }
  }

  // ── Toggle material mode ──
  var modeRadios = document.querySelectorAll('input[name="material_mode"]');
  var newField = document.getElementById('newMaterialField');
  var existField = document.getElementById('existingMaterialField');
  var materialSelect = document.getElementById('materialSelect');
  var materialTomSelect = null;

  function toggleMode() {
    var mode = document.querySelector('input[name="material_mode"]:checked').value;
    newField.classList.toggle('d-none', mode !== 'new');
    existField.classList.toggle('d-none', mode !== 'existing');

    // Initialize Tom Select only when the existing field becomes visible
    if (mode === 'existing' && !materialTomSelect) {
      materialTomSelect = initTomSelect(materialSelect);
    }
  }

  modeRadios.forEach(function (r) {
    r.addEventListener('change', toggleMode);
  });
  toggleMode();

  // ── Add Type ──
  btnAddType.addEventListener('click', function () {
    addType();
  });

  function addType() {
    var clone = typeTemplate.content.cloneNode(true);
    var block = clone.querySelector('.type-block');
    var currentIndex = typeIndex;

    block.querySelector('.type-number').textContent = typeIndex + 1;

    // Set names for all data-name elements
    block.querySelectorAll('[data-name]').forEach(function (el) {
      el.setAttribute('name', el.getAttribute('data-name').replace(/__INDEX__/g, typeIndex));
    });

    // Populate existing types dropdown
    var existingSelect = block.querySelector('.type-existing-select');
    existingTypes.forEach(function (type) {
      var option = document.createElement('option');
      option.value = type.id;
      option.textContent = type.specification + (type.unit ? ' — ' + type.unit : '');
      existingSelect.appendChild(option);
    });

    // Type mode toggle
    var typeModeRadios = block.querySelectorAll('.type-mode-radio');
    var typeNewFields = block.querySelector('.type-new-fields');
    var typeExistingFields = block.querySelector('.type-existing-fields');
    var typeTomSelect = null;

    typeModeRadios.forEach(function (radio) {
      radio.addEventListener('change', function () {
        var isNew = this.value === 'new';
        typeNewFields.classList.toggle('d-none', !isNew);
        typeExistingFields.classList.toggle('d-none', isNew);

        // Initialize Tom Select when existing field becomes visible
        if (!isNew && !typeTomSelect) {
          typeTomSelect = initTomSelect(existingSelect);
        }
      });
    });

    // Unit mode toggle
    var unitModeRadios = block.querySelectorAll('.unit-mode-radio');
    var unitExistingField = block.querySelector('.unit-existing-field');
    var unitNewField = block.querySelector('.unit-new-field');
    var unitSelect = block.querySelector('.unit-existing-select');
    var unitTomSelect = null;

    unitModeRadios.forEach(function (radio) {
      radio.addEventListener('change', function () {
        var isExisting = this.value === 'existing';
        unitExistingField.classList.toggle('d-none', !isExisting);
        unitNewField.classList.toggle('d-none', isExisting);

        if (isExisting && !unitTomSelect) {
          unitTomSelect = initTomSelect(unitSelect);
        }
      });
    });

    // Remove type
    block.querySelector('.btn-remove-type').addEventListener('click', function () {
      // Destroy Tom Select instances before removing the block
      destroyTomSelect(existingSelect);
      if (unitTomSelect) destroyTomSelect(unitSelect);
      block.querySelectorAll('.pres-existing-select').forEach(function (sel) {
        destroyTomSelect(sel);
      });
      block.remove();
      renumberTypes();
      updateAllTypeIndices();
    });

    // Presentations
    var presContainer = block.querySelector('.presentations-container');
    var btnAddPres = block.querySelector('.btn-add-presentation');
    var presIndex = 0;

    btnAddPres.addEventListener('click', function () {
      addPresentation(presContainer, currentIndex, presIndex);
      presIndex++;
    });

    // Add one default presentation
    addPresentation(presContainer, currentIndex, presIndex);
    presIndex++;

    typesContainer.appendChild(block);
    unitTomSelect = initTomSelect(unitSelect);
    typeIndex++;
  }

  function addPresentation(container, tIdx, pIdx) {
    var clone = presentationTemplate.content.cloneNode(true);
    var row = clone.querySelector('.presentation-row');

    // Set names
    row.querySelectorAll('[data-name]').forEach(function (el) {
      el.setAttribute('name',
        el.getAttribute('data-name')
          .replace(/__TIPO_INDEX__/g, tIdx)
          .replace(/__PRES_INDEX__/g, pIdx)
      );
    });

    // Presentation mode toggle
    var presModeRadios = row.querySelectorAll('.pres-mode-radio');
    var presExistingField = row.querySelector('.pres-existing-field');
    var presNewField = row.querySelector('.pres-new-field');
    var presSelect = row.querySelector('.pres-existing-select');
    var presTomSelect = null;

    presModeRadios.forEach(function (radio) {
      radio.addEventListener('change', function () {
        var isExisting = this.value === 'existing';
        presExistingField.classList.toggle('d-none', !isExisting);
        presNewField.classList.toggle('d-none', isExisting);

        // Initialize Tom Select when existing field becomes visible
        if (isExisting && !presTomSelect) {
          presTomSelect = initTomSelect(presSelect);
        }
      });
    });

    // Initialize Tom Select immediately since "existing" is the default
    container.appendChild(row);
    presTomSelect = initTomSelect(presSelect);

    // Remove presentation
    row.querySelector('.btn-remove-presentation').addEventListener('click', function () {
      destroyTomSelect(presSelect);
      row.remove();
    });
  }

  function renumberTypes() {
    var blocks = typesContainer.querySelectorAll('.type-block');
    blocks.forEach(function (block, i) {
      block.querySelector('.type-number').textContent = i + 1;
    });
  }

  function updateAllTypeIndices() {
    var blocks = typesContainer.querySelectorAll('.type-block');
    blocks.forEach(function (block, newIdx) {
      // Update all data-name elements at the type level
      block.querySelectorAll('[data-name]').forEach(function (el) {
        var originalName = el.getAttribute('data-name');
        if (!originalName) return;

        // Skip presentation-level elements — handled below
        if (originalName.indexOf('__TIPO_INDEX__') !== -1 || originalName.indexOf('presentations') !== -1) {
          return;
        }

        el.setAttribute('name', originalName.replace(/__INDEX__/g, newIdx));
      });

      // Update presentation rows
      var presRows = block.querySelectorAll('.presentation-row');
      presRows.forEach(function (row, presIdx) {
        row.querySelectorAll('[data-name]').forEach(function (el) {
          var originalName = el.getAttribute('data-name');
          if (originalName) {
            el.setAttribute('name',
              originalName
                .replace(/__TIPO_INDEX__/g, newIdx)
                .replace(/__PRES_INDEX__/g, presIdx)
            );
          }
        });
      });
    });

    typeIndex = blocks.length;
  }

  // Add a default type on load
  addType();
});