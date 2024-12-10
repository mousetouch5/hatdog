@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center  py-2 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out z-50 relative'
            : 'inline-flex items-center  py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out z-50 relative';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
