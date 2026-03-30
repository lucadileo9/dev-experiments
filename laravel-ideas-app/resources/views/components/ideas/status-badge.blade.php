@props(['status'])

@php
    $badgeClasses = match($status->value) {
        'pending' => 'badge-warning',
        'in_progress' => 'badge-info',
        'completed' => 'badge-success',
        default => 'badge-neutral',
    };
@endphp

<div class="badge {{ $badgeClasses }} badge-outline font-semibold">
    {{ $status->label() }}
</div>
