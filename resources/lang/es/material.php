<?php

return [
    'title_index' => 'Materiales',
    'title_create' => 'Nuevo material',

    'btn_new' => 'Nuevo material',
    'btn_back' => 'Volver',
    'btn_cancel' => 'Cancelar',
    'btn_save' => 'Guardar material',
    'btn_add_type' => 'Agregar tipo',
    'btn_add_presentation' => 'Presentación',
    'btn_delete_type_title' => 'Eliminar tipo',
    'btn_delete' => 'Eliminar',

    'catalog_title' => 'Catálogo de materiales',
    'catalog_subtitle' => 'Materiales con sus tipos y presentaciones',
    'search_placeholder' => 'Buscar material...',
    'empty' => 'No hay materiales registrados.',
    'confirm_delete' => '¿Eliminar este material y todos sus tipos?',

    'th_material' => 'Material',
    'th_types' => 'Tipos',
    'th_actions' => 'Acciones',

    'errors_title' => 'Errores:',

    'section_material_title' => '1. Material',
    'section_material_subtitle' => 'Seleccione uno existente o cree uno nuevo',
    'section_types_title' => '2. Tipos y presentaciones',
    'section_types_subtitle' => 'Agregue los tipos (especificaciones) con sus presentaciones',

    'mode_new' => 'Crear nuevo',
    'mode_existing' => 'Seleccionar existente',

    'label_description' => 'Descripción del material',
    'placeholder_description' => 'Ej: Cable, Panel LED, Conector...',
    'label_existing_material' => 'Material existente',
    'option_select' => '— Seleccione —',

    'label_specification' => 'Especificación',
    'placeholder_specification' => 'Ej: # 12 NEGRO, 20 Amperios...',
    'label_unit' => 'Unidad de medida',
    'label_optional' => '(opcional)',
    'option_none' => '— Ninguna —',
    'placeholder_unit_name' => 'Ej: Metro, Kilogramo...',
    'placeholder_unit_abbreviation' => 'Ej: m, kg...',
    'validation_unit_name_required' => 'El nombre de la unidad de medida es obligatorio.',
    'validation_unit_abbreviation_required' => 'La abreviatura de la unidad de medida es obligatoria.',

    'label_presentations' => 'Presentaciones',
    'label_presentation' => 'Presentación',
    'label_quantity' => 'Cantidad',
    'placeholder_quantity' => 'Ej: 100',
    'dynamic_presentations_hint' => 'Las presentaciones se agregan aquí',

    'success_created' => 'Se creó el material ":name" correctamente.',
    'success_deleted' => 'Se eliminó el material ":name" correctamente.',
    'error_create' => 'No se pudo crear el material: :error',
    'error_delete' => 'No se pudo eliminar el material: :error',

    'validation_types_required' => 'Debe agregar al menos un tipo.',
    'validation_type_specification_required' => 'La especificación del tipo es obligatoria.',
    'validation_type_presentations_required' => 'Cada tipo debe tener al menos una presentación.',
    'validation_presentation_required' => 'Seleccione una presentación.',
    'validation_presentation_quantity_required' => 'La cantidad por presentación es obligatoria.',
    'validation_description_required' => 'La descripción del material es obligatoria.',
    'validation_material_required' => 'Seleccione un material existente.',
];
