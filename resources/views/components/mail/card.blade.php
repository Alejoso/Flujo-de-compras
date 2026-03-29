@props(['title'])

<div class="card">
    <div class="card-header">
        <div class="dot"></div>
        <span class="card-title">{{ $title }}</span>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>