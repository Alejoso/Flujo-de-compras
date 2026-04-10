<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('email.notification_default_title') }}</title>
    <style>

        @media (prefers-color-scheme: dark) {
            body, .wrapper, .card, .card-header, .card-body, .data-row {
                background-color: unset !important;
                color: unset !important;
            }
        }

        :root {
            color-scheme: light dark;
            supported-color-schemes: light dark;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #0A0A0A 0%, #0F2A1F 50%, #0A0A0A 100%);
            font-family: 'Inter', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            color: #A0A0A0;
            padding: 40px 16px;
        }

        .wrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            border-left: 3px solid #F5C800;
            padding-left: 16px;
            margin-bottom: 32px;
        }

        .header .label {
            font-size: 11px;
            color: #F5C800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.3;
        }

        /* Card */
        .card {
            background-color: #161616;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-header {
            background-color: #0D0D0D;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #F5C800;
            flex-shrink: 0;
        }

        .card-header .card-title {
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #FFFFFF;
            font-weight: 500;
        }

        .card-body {
            padding: 20px;
        }

        /* Descripción */
        .action-description {
            font-size: 15px;
            color: #FFFFFF;
            line-height: 1.7;
            font-weight: 400;
        }

        /* Data rows */
        .data-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-row {
            display: table-row;
        }

        .data-row {
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .data-label {
            display: table-cell;
            padding: 12px 16px 12px 0;
            font-size: 11px;
            color: #FFFFFF;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
            vertical-align: middle;
            width: 120px;
            font-weight: 500;
            white-space: nowrap;
            padding: 12px 12px 12px 16px;
        }

        .data-value {
            display: table-cell;
            padding: 12px 0;
            font-size: 14px;
            color: #A0A0A0;
            vertical-align: middle;
            white-space: nowrap;
            padding: 12px 16px 12px 12px;
        }

        /* Variantes de valor */
        .badge {
            display: inline-block;
            background-color: rgba(245,200,0,0.10);
            color: #F5C800;
            border: 1px solid rgba(245,200,0,0.25);
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 999px;
            font-weight: 500;
        }

        .timestamp {
            font-size: 13px;
            color: #F5C800;
            font-weight: 700;
        }

        .employee {
            font-weight: 600;
            color: #FFFFFF;
        }

        .project {
            font-weight: 500;
            color: #FFFFFF;
        }

        .version {
            font-weight: 500;
            color: #FFFFFF;
        }

        /* Footer */
        .footer {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 20px;
            text-align: center;
        }

        .footer p {
            font-size: 12px;
            color: #5A5A5A;
        }

        .footer .app-name {
            color: #F5C800;
            font-weight: 600;
        }

        /* Botón primario */
        .btn-primary {
            display: inline-block;
            background-color: #F5C800;
            color: #000000;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            padding: 13px 36px;
            border-radius: 10px;
            letter-spacing: 0.2px;
        }

        .btn-wrapper {
            text-align: center;
            padding: 8px 0 16px 0;
        }

        /* Nota de enlace manual */
        .link-note {
            font-size: 12px;
            color: #5A5A5A;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            line-height: 1.6;
            word-break: break-all;
        }

        .link-note a {
            color: #F5C800;
            text-decoration: none;
        }
</style>
</head>
<body style="margin:0; padding:0; background-color: transparent;">
    <div class="wrapper" style="background: linear-gradient(135deg, #0A0A0A 0%, #0F2A1F 50%, #0A0A0A 100%); padding: 40px 16px; max-width: 600px; margin: 0 auto;">
        {{ $slot }}
    </div>
</body>
</html>