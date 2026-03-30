@props(['label' => 'Notificación del sistema', 'title'])

<div style="background-color: #1a1a1a; padding: 0; margin-bottom: 32px;">
    <div style="border-left: 3px solid #F5C800; padding: 20px; padding-left: 16px;">
        <div style="font-size: 11px; color: #F5C800; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 6px; font-weight: 500;">
            {{ $label }}
        </div>
        <h1 style="font-size: 22px; font-weight: 700; line-height: 1.3; margin: 0; color: #fffffe;">
            {{ $title }}
        </h1>
    </div>
</div>