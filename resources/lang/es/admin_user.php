<?php

return [

    // Page titles
    'title'             => 'Usuarios',
    'title_create'      => 'Crear usuario',
    'title_edit'        => 'Editar usuario',
    'list_title'        => 'Lista de usuarios',
    'list_subtitle'     => 'Administra los usuarios del sistema',

    // Buttons
    'btn_create'        => 'Crear usuario',
    'btn_save'          => 'Guardar',
    'btn_save_changes'  => 'Guardar cambios',
    'btn_cancel'        => 'Cancelar',
    'btn_back'          => 'Volver',

    // Table headers
    'th_user'           => 'User',
    'th_name'           => 'Nombre',
    'th_email'          => 'Correo',
    'th_rol'            => 'Rol',
    'th_cedula'         => 'Cédula',
    'th_phone'          => 'Teléfono',
    'th_salary'         => 'Sueldo',
    'th_notifications'  => 'Notificaciones',
    'th_actions'        => 'Acciones',

    // Form labels
    'label_name'                  => 'Nombre',
    'label_email'                 => 'Correo',
    'label_password'              => 'Contraseña',
    'label_password_edit'         => 'Contraseña <small class="text-muted">(dejar vacío para no cambiar)</small>',
    'label_rol'                   => 'Rol',
    'label_cedula'                => 'Cédula',
    'label_salary'                => 'Sueldo',
    'label_phone'                 => 'Número de teléfono',
    'label_notifications'         => 'Recibe notificaciones',

    // Rol options
    'rol_admin'         => 'Admin',
    'rol_tecnico'       => 'Técnico',

    // Boolean labels
    'yes'               => 'Sí',
    'no'                => 'No',

    // Confirm / empty
    'confirm_delete'    => '¿Eliminar este usuario?',
    'empty'             => 'No hay usuarios registrados.',

    // Flash messages
    'flash_store_success'        => 'Usuario creado exitosamente.',
    'flash_store_error'          => 'No se pudo crear el usuario: :error',
    'flash_update_success'       => 'Usuario actualizado exitosamente.',
    'flash_update_error'         => 'No se pudo actualizar el usuario: :error',
    'flash_destroy_success'      => 'Usuario eliminado exitosamente.',
    'flash_destroy_error'        => 'No se pudo eliminar el usuario: :error',
    'cant_delete_has_projects'   => 'No se puede eliminar a :name porque tiene proyectos asociados.',

];
