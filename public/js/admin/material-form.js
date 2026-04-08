document.addEventListener('DOMContentLoaded', function () {
  const tiposContainer = document.getElementById('tiposContainer');
  const btnAddTipo = document.getElementById('btnAddTipo');
  const tipoTemplate = document.getElementById('tipoTemplate');
  const presTemplate = document.getElementById('presentacionTemplate');

  let tipoIndex = 0;

  // ── Toggle material mode ──
  const modeRadios = document.querySelectorAll('input[name="material_mode"]');
  const newField = document.getElementById('newMaterialField');
  const existField = document.getElementById('existingMaterialField');

  function toggleMode() {
    const mode = document.querySelector('input[name="material_mode"]:checked').value;
    newField.style.display = mode === 'new' ? '' : 'none';
    existField.style.display = mode === 'existing' ? '' : 'none';
  }

  modeRadios.forEach(function (r) {
    r.addEventListener('change', toggleMode);
  });
  toggleMode();

  // ── Agregar Tipo ──
  btnAddTipo.addEventListener('click', function () {
    addTipo();
  });

  function addTipo() {
    var clone = tipoTemplate.content.cloneNode(true);
    var block = clone.querySelector('.tipo-block');

    block.querySelector('.tipo-number').textContent = tipoIndex + 1;

    block.querySelectorAll('[data-name]').forEach(function (el) {
      el.setAttribute('name', el.getAttribute('data-name').replace('__INDEX__', tipoIndex));
    });

    block.querySelector('.btn-remove-tipo').addEventListener('click', function () {
      block.remove();
      renumberTipos();
      updateAllTypeIndices();
    });

    var presContainer = block.querySelector('.presentaciones-container');
    var btnAddPres = block.querySelector('.btn-add-presentacion');
    var presIndex = 0;

    btnAddPres.addEventListener('click', function () {
      addPresentacion(presContainer, tipoIndex, presIndex);
      presIndex++;
    });

    addPresentacion(presContainer, tipoIndex, presIndex);
    presIndex++;

    tiposContainer.appendChild(block);
    tipoIndex++;
  }

  function addPresentacion(container, tIdx, pIdx) {
    var clone = presTemplate.content.cloneNode(true);
    var row = clone.querySelector('.presentacion-row');

    row.querySelectorAll('[data-name]').forEach(function (el) {
      el.setAttribute('name',
        el.getAttribute('data-name')
          .replace('__TIPO_INDEX__', tIdx)
          .replace('__PRES_INDEX__', pIdx)
      );
    });

    row.querySelector('.btn-remove-presentacion').addEventListener('click', function () {
      row.remove();
    });

    container.appendChild(row);
  }

  function renumberTipos() {
    var blocks = tiposContainer.querySelectorAll('.tipo-block');
    blocks.forEach(function (block, i) {
      block.querySelector('.tipo-number').textContent = i + 1;
    });
  }

  function updateAllTypeIndices() {
    var blocks = tiposContainer.querySelectorAll('.tipo-block');
    blocks.forEach(function (block, newIdx) {
      block.querySelectorAll('[data-name]').forEach(function (el) {
        var originalName = el.getAttribute('data-name');
        if (originalName) {
          el.setAttribute('name', originalName.replace('__INDEX__', newIdx));
        }
      });

      var presRows = block.querySelectorAll('.presentacion-row');
      presRows.forEach(function (row, presIdx) {
        row.querySelectorAll('[data-name]').forEach(function (el) {
          var originalName = el.getAttribute('data-name');
          if (originalName) {
            el.setAttribute('name',
              originalName
                .replace('__TIPO_INDEX__', newIdx)
                .replace('__PRES_INDEX__', presIdx)
            );
          }
        });
      });
    });
    tipoIndex = blocks.length;
  }

  // Agregar un tipo por defecto al cargar
  addTipo();
});