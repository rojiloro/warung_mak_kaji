@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white'
])

@php

$alignmentClasses = match ($align) {
    'left' => 'origin-top-left left-0',
    'top' => 'origin-top',
    default => 'origin-top-right right-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};

@endphp

<div class="relative" x-data="{ open: false }">

<div @click="open = ! open">

{{ $trigger }}

</div>

<div
x-show="open"
@click.outside="open=false"
x-transition
class="absolute z-50 mt-2 {{ $width }} rounded-xl shadow-lg {{ $alignmentClasses }}"
style="display:none;"
>

<div class="rounded-xl ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">

{{ $content }}

</div>

</div>

</div>