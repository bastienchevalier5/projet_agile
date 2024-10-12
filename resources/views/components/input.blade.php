@props(['label', 'name', 'type' => 'text', 'value' => ''])

<div class="m-5">

    <label for="{{ $name }}">{{ $label }}</label>

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}">

    @error($name)
        <div>
            <p class="text-warning">{{ $message }}</p>
        </div>
    @enderror
</div>
