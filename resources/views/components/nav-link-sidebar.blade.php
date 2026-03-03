@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 bg-gray-800 text-white rounded-lg transition-colors duration-200'
            : 'flex items-center px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>