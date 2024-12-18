@props(['id', 'name', 'value' => ''])

<div class="relative">
    <input
        type="date"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary1 focus:border-transparent transition duration-300']) }}
    />
</div>
