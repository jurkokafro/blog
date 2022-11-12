@props(['name', 'showlabel'=>'true'])

<label class="block mb-2 uppercase font-bold text-xs text-gray-700"
    for="{{ $name }}"
    >
    @if ($showlabel=='true')
        {{ ucwords($name) }}
    @endif
</label>
