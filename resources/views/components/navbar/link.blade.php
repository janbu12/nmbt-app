@props(['href', 'variant' => 'default','loading' => 'default'])

@php
    $isActive = request()->is(trim($href, '/')) || request()->is(trim($href, '/') . '/*' ) || (request()->fullUrl() === url($href));
@endphp

<a
    href="{{ $href }}"
    {{ $attributes }}
    class="{{
        $isActive
            ? ($variant === 'transparent'
                ? 'text-lg text-white font-semibold hover:text-gray-300'
                : 'text-lg text-secondary1 font-semibold hover:text-tertiery1')
            : ($variant === 'transparent'
                ? 'text-white hover:text-gray-300'
                : 'text-tertiery1 hover:text-secondary1')
    }} hover:scale-110  transition-all duration-300 nav-link"
    @if ($loading !== 'none')
        @click="Alpine.store('loadingState').showLoading();"
    @endif
>
    {{ $slot }}
</a>
