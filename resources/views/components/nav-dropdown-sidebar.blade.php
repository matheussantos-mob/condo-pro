@props(['active', 'title'])

@php
$classes = ($active ?? false)
            ? 'flex items-center justify-between w-full px-4 py-3 bg-gray-800 text-white rounded-lg transition-colors duration-200'
            : 'flex items-center justify-between w-full px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200';
@endphp

<div x-data="{ open: @js($active) }" class="space-y-1">
    {{-- Botão do Menu Pai --}}
    <button @click="open = !open" {{ $attributes->merge(['class' => $classes]) }}>
        <div class="flex items-center">
            {{ $icon }} {{-- Slot para o ícone --}}
            <span class="ml-3">{{ $title }}</span>
        </div>
        
        {{-- Seta indicadora --}}
        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Submenus --}}
    <div x-show="open" x-cloak class="pl-4 space-y-1 mt-1 border-l-2 border-gray-700 ml-6">
        {{ $slot }}
    </div>
</div>