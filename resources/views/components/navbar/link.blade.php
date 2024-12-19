<a {{ $attributes}} class = "{{request()->fullUrlIs(url($href)) ? 'text-lg text-secondary1 hover:text-tertiery1 font-semibold' : 'font-medium hover:text-lg hover:text-secondary1'}} transition-all duration-300">
    {{ $slot }}
</a>
