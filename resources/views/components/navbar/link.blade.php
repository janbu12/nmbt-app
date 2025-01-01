@props(['href', 'variant' => 'default'])

<a
    {{ $attributes }}
    class="{{
        request()->fullUrlIs(url($href))
            ? ($variant === 'transparent'
                ? 'text-lg text-white font-semibold hover:text-gray-300'
                : 'text-lg text-secondary1 font-semibold hover:text-tertiery1')
            : ($variant === 'transparent'
                ? 'text-white hover:text-gray-300'
                : 'text-tertiery1 hover:text-secondary1')
    }} transition-all duration-300"
>
    {{ $slot }}
</a>
