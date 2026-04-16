document.addEventListener('DOMContentLoaded', function () {
  const typesContainer = document.getElementById('typesContainer');
  const btnAddType = document.getElementById('btnAddType');
  const typeTemplate = document.getElementById('typeTemplate');
  const presentationTemplate = document.getElementById('presentationTemplate');

  let typeIndex = 0;

  // ── Toggle material mode ──
  const modeRadios = document.querySelectorAll('input[name="material_mode"]');
  const newField = document.getElementById('newMaterialField');
  const existField = document.getElementById('existingMaterialField');

  function toggleMode() {
    const mode = document.querySelector('input[name="material_mode"]:checked').value;
    newField.classList.toggle('d-none', mode !== 'new');
    existField.classList.toggle('d-none', mode !== 'existing');
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

    block.querySelector('.type-number').textContent = typeIndex + 1;

    block.querySelectorAll('[data-name]').forEach(function (el) {
      el.setAttribute('name', el.getAttribute('data-name').replace('__INDEX__', typeIndex));
    });

    block.querySelector('.btn-remove-type').addEventListener('click', function () {
      block.remove();
      renumberTypes();
      updateAllTypeIndices();
    });

    var presContainer = block.querySelector('.presentations-container');
    var btnAddPres = block.querySelector('.btn-add-presentation');
    var presIndex = 0;

    btnAddPres.addEventListener('click', function () {
      addPresentation(presContainer, typeIndex, presIndex);
      presIndex++;
    });

    addPresentation(presContainer, typeIndex, presIndex);
    presIndex++;

    typesContainer.appendChild(block);
    typeIndex++;
  }

  function addPresentation(container, tIdx, pIdx) {
    var clone = presentationTemplate.content.cloneNode(true);
    var row = clone.querySelector('.presentation-row');

    row.querySelectorAll('[data-name]').forEach(function (el) {
      el.setAttribute('name',
        el.getAttribute('data-name')
          .replace('__TIPO_INDEX__', tIdx)
          .replace('__PRES_INDEX__', pIdx)
      );
    });

    row.querySelector('.btn-remove-presentation').addEventListener('click', function () {
      row.remove();
    });

    container.appendChild(row);
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
      block.querySelectorAll('[data-name]').forEach(function (el) {
        var originalName = el.getAttribute('data-name');
        if (originalName) {
          el.setAttribute('name', originalName.replace('__INDEX__', newIdx));
        }
      });

      var presRows = block.querySelectorAll('.presentation-row');
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
    typeIndex = blocks.length;
  }

  // Add a default type on load
  addType();
});
