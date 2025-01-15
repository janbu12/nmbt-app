@props([
    'variant' => 'primary',
    'as' => 'button',
    'loading' => 'default'
    ])

@php
    $baseClass = 'font-medium px-10 py-2.5 rounded-lg transition-all duration-300';
    $variants = [
        'primary' => 'btn-primary-custom',
        'secondary' => 'btn-secondary-custom',
        'tertiery' => 'btn-tertiery-custom',
        'danger' => 'bg-red-500 text-white hover:bg-red-400',
        'success' => 'bg-green-500 text-white hover:bg-green-600',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

@if($as == "a")
    <a {{ $attributes->merge(['class' => "$baseClass $variantClass"]) }} @click="Alpine.store('loadingState').showLoading();">
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => "$baseClass $variantClass"]) }}
        @if ($loading !== 'none')
            @click="Alpine.store('loadingState').showLoading();"
        @endif
    >
        {{ $slot }}
    </button>
@endif

