@props(['tipo'])

@php
    $tipos = [
        'new' => [
            'icon' => 'svg/circle-plus.svg',
            'style' =>
                'text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors p-1 rounded hover:bg-indigo-50 dark:hover:bg-gray-700',
        ],
        'edit' => [
            'icon' => 'svg/edit.svg',
            'style' =>
                'text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors p-1 rounded hover:bg-indigo-50 dark:hover:bg-gray-700',
        ],
        'delete' => [
            'icon' => 'svg/delete.svg',
            'style' =>
                'text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-gray-700',
        ],
        'view' => [
            'icon' => 'svg/view.svg',
            'style' =>
                'text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors p-1 rounded hover:bg-indigo-50 dark:hover:bg-gray-700',
        ],
        'active' => [
            'icon' => 'svg/edit.svg',
            'style' =>
                'flex text-lime-600 dark:text-lime-400 hover:text-lime-900 dark:hover:text-lime-300 transition-colors p-1 rounded hover:bg-lime-50 dark:hover:bg-gray-700',
        ],
        'inactive' => [
            'icon' => 'svg/edit.svg',
            'style' =>
                'flex text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-gray-700',
        ],
    ];

    $icon = $tipos[$tipo]['icon'] ?? 'svg/question-mark.svg';
    $style = $tipos[$tipo]['style'] ?? 'text-gray-400 p-1';
@endphp

<button type="button" {{ $attributes->merge(['class' => $style]) }}>
    {!! file_get_contents(public_path($icon)) !!}{{ $slot }}
</button>
