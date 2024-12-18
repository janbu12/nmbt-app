@props(['id' => "", 'name' => "", 'placeholder' => '', 'value' => '', 'type' => 'text'])

<div class="relative">
    <input
        type="{{$type}}"
        id="{{ $id}}"
        name="{{ $name}}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'text-sm w-full px-4 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary3 focus:border-transparent transition duration-300']) }}
    />
</div>
