<?php

return [

    // ─── Reset Password ──────────────────────────────────────────
    'reset_password_label' => 'Seguridad de cuenta',
    'reset_password_title' => 'Restablecer contraseña',
    'reset_password_card_request' => 'Solicitud recibida',
    'reset_password_body' => 'Hola :name, recibimos una solicitud para restablecer la contraseña de tu cuenta. Si fuiste tú, haz clic en el botón de abajo. El enlace expirará en :minutes minutos.',
    'reset_password_btn' => 'Restablecer mi contraseña',
    'reset_password_link_note' => 'Si el botón no funciona, copia y pega este enlace en tu navegador:',
    'reset_password_card_no_request' => '¿No solicitaste esto?',
    'reset_password_no_request' => 'Si no solicitaste restablecer tu contraseña, puedes ignorar este correo con seguridad. Tu contraseña no cambiará hasta que accedas al enlace de arriba.',

    // ─── Notification layout ──────────────────────────────────────
    'notification_default_title' => 'Notificación',
    'notification_footer' => 'Este mensaje fue generado automáticamente por :app. No respondas este correo.',
    'notification_system_label' => 'Notificación del sistema',
    'notification_system_title' => 'Actividad registrada en el sistema',

    // ─── Cotización Created ───────────────────────────────────────
    'quote_created_subject' => 'Se ha creado una nueva cotización para :project',
    'quote_created_body' => 'Se ha creado la cotización :id para el proyecto :project',
    'quote_created_error' => 'Cotización creada, pero no se pudo enviar el correo de notificación.',

    // ─── Cotización Edited ────────────────────────────────────────
    'quote_edited_subject' => 'Se ha editado una cotización de el proyecto :project',
    'quote_edited_body' => 'Se ha editado la cotización :id del proyecto :project',
    'quote_edited_error' => 'Cotización actualizada, pero no se pudo enviar el correo de notificación.',

    // ─── Cotización Submitted (versión final técnico) ─────────────
    'quote_submitted_subject' => 'El técnico ha enviado la versión final de la cotización :id del proyecto :project',
    'quote_submitted_body' => 'El técnico ha marcado la cotización :id del proyecto :project como versión final y está lista para revisión.',
    'quote_submitted_error' => 'Cotización enviada, pero no se pudo enviar el correo de notificación.',

    // ─── Cotización Rejected (devuelta al técnico) ────────────────
    'quote_rejected_subject' => 'La cotización :id del proyecto :project ha sido devuelta para revisión',
    'quote_rejected_body' => 'El administrador ha devuelto la cotización :id del proyecto :project al técnico para que realice los ajustes necesarios.',
    'quote_rejected_error' => 'Cotización devuelta, pero no se pudo enviar el correo de notificación.',

];
