@props(['title'])

<div class="card">
    <div class="card-header">
        <span class="card-title">{{ $title }}</span>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>