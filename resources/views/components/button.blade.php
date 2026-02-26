@props([
    'variant' => 'primary',
    'icon' => '',
    'text' => null,
    'type' => 'submit',
    'size' => '',
    'disabled' => false,
    'href' => null
])

@php
    $variantClass = match($variant) {
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'light' => 'btn-light',
        'dark' => 'btn-dark',
        'link' => 'btn-link',
        'outline-primary' => 'btn-outline-primary',
        'outline-secondary' => 'btn-outline-secondary',
        'outline-success' => 'btn-outline-success',
        'outline-danger' => 'btn-outline-danger',
        'outline-warning' => 'btn-outline-warning',
        'outline-info' => 'btn-outline-info',
        'outline-light' => 'btn-outline-light',
        'outline-dark' => 'btn-outline-dark',
        default => 'btn-primary',
    };

    $sizeClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => '',
    };

    $iconClass = match($icon) {
        'show' => 'fas fa-eye',
        'save' => 'fas fa-save',
        'edit' => 'fas fa-edit',
        'delete' => 'fas fa-trash',
        'add' => 'fas fa-plus',
        'search' => 'fas fa-search',
        'refresh' => 'fas fa-sync-alt',
        'upload' => 'fas fa-upload',
        'download' => 'fas fa-download',
        'print' => 'fas fa-print',
        'back' => 'fas fa-arrow-left',
        'next' => 'fas fa-arrow-right',
        'cancel' => 'fas fa-times',
        'check' => 'fas fa-check',
        'user' => 'fas fa-user',
        'settings' => 'fas fa-cog',
        default => '',
    };

    $isLink = !is_null($href);
@endphp

@if($isLink)
    <a {{ $attributes->merge(['class' => "btn $variantClass $sizeClass me-2"]) }} href="{{ $href }}">
        @if($icon)
            <i class="{{ $iconClass }} @if($text) me-1 @endif"></i>
        @endif
        {{ $text }}
    </a>
@else
    <button 
        {{ $attributes->merge(['class' => "btn $variantClass $sizeClass me-2"]) }}
        type="{{ $type }}"
        @if($disabled) disabled @endif
    >
        @if($icon)
            <i class="{{ $iconClass }} @if($text) me-1 @endif"></i>
        @endif
        {{ $text }}
    </button>
@endif