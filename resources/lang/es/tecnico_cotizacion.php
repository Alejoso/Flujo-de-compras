<?php

return [

    // Page titles
    'title_index'    => 'Cotizaciones',
    'title_create'   => 'Nueva Cotización',
    'title_edit'     => 'Editar Cotización',
    'title_versions' => 'Versiones — Cotización :number',
    'title_show'     => 'Detalle Cotización',

    // Actions / buttons
    'btn_back'              => 'Volver',
    'btn_cancel'            => 'Cancelar',
    'btn_new_quote'         => 'Nueva Cotización',
    'btn_new_version'       => 'Nueva Versión',
    'btn_send_quote'        => 'Enviar Cotización',
    'btn_save_version'      => 'Guardar Nueva Versión',
    'btn_view_versions'     => 'Ver versiones',
    'btn_view_detail'       => 'Ver detalle',
    'btn_view_pdf'          => 'Ver PDF',
    'btn_edit_materials'    => 'Editar materiales',
    'btn_download_pdf'      => 'Descargar PDF',
    'btn_add_material'      => 'Agregar a la lista',

    // Form labels
    'label_material'        => 'Material',
    'label_presentation'    => 'Presentación',
    'label_unit'            => 'Unidad',
    'label_quantity'        => 'Cantidad',
    'label_version'         => 'Versión',
    'label_date'            => 'Fecha',
    'label_current'         => 'Actual',
    'label_estado'          => 'Estado',

    // Table headers
    'th_material_spec'      => 'Material / Especificación',
    'th_material'           => 'Material',
    'th_type_spec'          => 'Tipo / Especificación',

    // Messages
    'msg_validation_error'  => 'Revisa los campos marcados antes de enviar.',
    'msg_empty_cotizaciones'=> 'Este proyecto no tiene cotizaciones aún.',
    'msg_empty_versiones'   => 'Esta cotización no tiene versiones aún.',
    'msg_empty_materials'   => 'Sin materiales registrados.',
    'msg_add_materials_hint'=> 'Agrega materiales usando los selectores de arriba',
    'msg_search_placeholder'=> 'Escriba para buscar...',

    // PDF view
    'pdf_intro'             => 'A continuación se presenta una tabla con los materiales a cotizar:',
    'pdf_th_quantity'       => 'Cantidad',
    'pdf_th_description'    => 'Descripción',
    'pdf_th_specification'  => 'Especificación',

    // Flash messages — success
    'flash_store_success'       => 'Cotización creada correctamente para el proyecto ":project".',
    'flash_update_success'      => 'Nueva versión de la cotización creada correctamente.',

    // Flash messages — error
    'flash_store_error'         => 'No se pudo crear la cotización: :error',
    'flash_store_pdf_error'     => 'Cotización creada, pero no se pudo generar el PDF: :error',
    'flash_update_error'        => 'No se pudo actualizar la cotización: :error',
    'flash_update_pdf_error'    => 'Cotización actualizada, pero no se pudo generar el PDF: :error',

    // Heading with version number (used in edit)
    'new_version_from'      => 'Nueva Versión desde v.:version',

    // Singular/plural versions count
    'version_singular'      => 'versión',
    'version_plural'        => 'versiones',

];
