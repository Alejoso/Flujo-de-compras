<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Notificación' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #0A0A0A 0%, #0F2A1F 50%, #0A0A0A 100%);
            font-family: 'Inter', sans-serif;
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
            color: #FFFFFF;
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
            color: #5A5A5A;
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
        }

        .data-row {
            display: table-row;
        }

        .data-row + .data-row .data-label,
        .data-row + .data-row .data-value {
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .data-label {
            display: table-cell;
            padding: 12px 16px 12px 0;
            font-size: 11px;
            color: #5A5A5A;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
            vertical-align: middle;
            width: 140px;
            font-weight: 500;
        }

        .data-value {
            display: table-cell;
            padding: 12px 0;
            font-size: 14px;
            color: #A0A0A0;
            vertical-align: middle;
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

        .technician {
            font-weight: 600;
            color: #FFFFFF;
        }

        .project {
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
    </style>
</head>
<body>
    <div class="wrapper">
        {{ $slot }}
    </div>
</body>
</html>