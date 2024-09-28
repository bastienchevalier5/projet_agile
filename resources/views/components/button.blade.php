@props(['type' => 'submit', 'color' => 'secondary'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-$color"]) }}>
    {{ $slot }}
</button>
