<?php

return [

    // ─── General / Shared ─────────────────────────────────────────
    'projects' => 'Proyectos',
    'new_project' => 'Nuevo Proyecto',
    'edit_project' => 'Editar Proyecto',
    'edit_a_project' => 'Editar un proyecto',
    'back' => 'Volver',
    'cancel' => 'Cancelar',
    'save_project' => 'Guardar Proyecto',
    'view_details' => 'Ver Detalles',
    'edit' => 'Editar',
    'new' => 'Nueva',
    'delete' => 'Borrar proyecto',

    // ─── Form Labels ──────────────────────────────────────────────
    'name' => 'Nombre',
    'address' => 'Dirección',
    'city' => 'Ciudad',
    'total_cost' => 'Costo Total',
    'client' => 'Cliente',

    // ─── Placeholders ─────────────────────────────────────────────
    'placeholder_name' => 'Ej: Renovación de oficinas',
    'placeholder_address' => 'Ej: Calle 10 #45-20',
    'placeholder_city' => 'Ej: Medellín',
    'placeholder_cost' => '0.00',
    'select_client' => 'Selecciona un cliente',

    // ─── Card Headers / Subtitles ─────────────────────────────────
    'project_info' => 'Información del Proyecto',
    'fill_fields' => 'Completa los campos para registrar el proyecto',
    'edit_project_name' => 'Editar el proyecto :name',
    'update_info' => 'Actualiza la información',

    // ─── Search & Filters ─────────────────────────────────────────
    'search_projects' => 'Buscar proyectos...',
    'all' => 'Todos',
    'in_negotiation' => 'En negociación',
    'in_progress' => 'En ejecución',
    'finished' => 'Finalizado',

    // ─── Estado enum values (deben coincidir con la BD) ───────────
    'estado_negociacion' => 'Negotiation',
    'estado_ejecucion' => 'In Progress',
    'estado_finalizado' => 'Completed',

    // ─── Index Meta Labels ────────────────────────────────────────
    'total_cost_label' => 'Costo total:',
    'client_label' => 'Cliente:',
    'created_by' => 'Creado por:',
    'cc_label' => 'CC:',

    // ─── Empty State ──────────────────────────────────────────────
    'no_projects' => 'No hay proyectos registrados aún.',

    // ─── Show – KPIs ──────────────────────────────────────────────
    'quotations' => 'Cotizaciones',
    'invoices' => 'Facturas',
    'total_registered' => 'Total registradas',
    'total_processed' => 'Total procesadas',
    'cost_vs_executed' => 'Costo Total vs Ejecutado',
    'executed' => 'ejecutado',
    'budget_used' => '0% del presupuesto utilizado',

    // ─── Show – Action Cards ──────────────────────────────────────
    'view_charts' => 'Ver Gráficas',
    'charts_desc' => 'Visualiza el progreso, costos y estadísticas del proyecto',
    'view_quotations' => 'Ver Cotizaciones',
    'quotations_desc' => 'Revisa y gestiona todas las cotizaciones asociadas',
    'process_invoice_ocr' => 'Procesar Factura OCR',
    'ocr_desc' => 'Extrae y estructura datos de facturas automáticamente',
    'confirm_delete_title' => 'Borrar proyecto',
    'confirm_delete' => '¿Esta seguro que desea borrar el proyecto: :name?',

    // ─── Status labels ───────────────────────────────────────────
    'status_negotiation' => 'En negociación',
    'status_in_progress' => 'En ejecución',
    'status_completed' => 'Finalizado',

    // ─── Flash messasges ────────────────────────────────────────────
    'project_created' => 'Se ha creado con éxito el proyecto :name.',
    'project_updated' => 'Se ha actualizado el proyecto :name.',
    'flash_save_error' => 'No se pudo crear el proyecto: :error',
    'flash_update_error' => 'No se pudo actualizar el proyecto: :error',

    'flash_destroy_success' => 'El proyecto :name ha sido eliminado exitosamente.',
    'flash_destroy_error' => 'No se pudo eliminar el proyecto: :error',

    // ─── Técnico Index ────────────────────────────────────────────
    'view_quotations_short' => 'Ver cotizaciones',

    // ─── Quotations Validation ────────────────────────────────────
    'no_quotations_registered' => 'No se han registrado cotizaciones aún.',
    'quotations_found' => 'Se encontraron :count cotizaciones.',
    'quotation' => 'Cotización',
    'version_singular' => 'versión',
    'version_plural' => 'versiones',
    'view_versions' => 'Ver versiones',

];
