@props(['label', 'value', 'type' => 'default'])

<tr class="data-row">
    <td class="data-label">{{ $label }}</td>
    <td class="data-value">
        @if ($type === 'badge')
            <span class="badge">{{ $value }}</span>
        @elseif ($type === 'timestamp')
            <span class="timestamp">{{ $value }}</span>
        @elseif ($type === 'technician')
            <span class="technician">{{ $value }}</span>
        @elseif ($type === 'project')
            <span class="project">{{ $value }}</span>
        @elseif ($type === 'version')
            <span class="project">{{ $value }}</span>
        @else
            {{ $value }}
        @endif
    </td>
</tr>