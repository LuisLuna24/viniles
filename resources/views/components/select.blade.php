@props([
    'disabled' => false,
    'active' => false,
])

@php
    $attributes = $attributes->class([
        'dark:bg-gray-900 dark:text-gray-300',
        'focus:border-indigo-500  dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600',
        'rounded-md shadow-sm',
        // clases condicionales
        'opacity-70 cursor-not-allowed' => $disabled,
        'border-gray-300 dark:border-gray-700' => !$active,
        'border border-blue-500' => $active,
    ]);
@endphp

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes !!}>
    {{ $slot }}
</select>
