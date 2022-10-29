@props(['active'=> false])

@php
    $clases = 'block text-left text-sm px-3 leading-5 hover:bg-blue-500
                focus:bg-gray-300 hover:text-white focus:text-white';

    if($active) {
        $clases .= " bg-blue-500 text-white";
    }
@endphp

<a {{ $attributes(['class'=> $clases]) }}>
                {{ $slot }}</a>
