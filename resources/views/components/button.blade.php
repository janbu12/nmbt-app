@props([
    'variant' => 'primary',
    'as' => 'button'
    ])

@php
    $baseClass = 'font-medium px-10 py-2.5 rounded-lg transition-all duration-300';
    $variants = [
        'primary' => 'btn-primary-custom',
        'secondary' => 'btn-secondary-custom',
        'tertiery' => 'btn-tertiery-custom',
        'danger' => 'bg-red-500 text-white hover:bg-red-600',
        'success' => 'bg-green-500 text-white hover:bg-green-600',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

@if($as == "a")
    <a {{ $attributes->merge(['class' => "$baseClass $variantClass"]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => "$baseClass $variantClass"]) }}>
        {{ $slot }}
    </button>
@endif

