@props(['label', 'value', 'type' => 'default'])

<div class="data-row">
    <span class="data-label">{{ $label }}</span>
    <span class="data-value">
        @if ($type === 'badge')
            <span class="badge">{{ $value }}</span>
        @elseif ($type === 'timestamp')
            <span class="timestamp">{{ $value }}</span>
        @elseif ($type === 'technician')
            <span class="technician">{{ $value }}</span>
        @elseif ($type === 'project')
            <span class="project">{{ $value }}</span>
        @else
            {{ $value }}
        @endif
    </span>
</div>