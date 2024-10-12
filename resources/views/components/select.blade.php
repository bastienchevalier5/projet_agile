@props(['label', 'name', 'options', 'selected' => null])

<div class="m-5">
    <label for="{{ $name }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}">
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ old($name, $selected) == $key ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div>
            <p class="text-warning">{{ $message }}</p>
        </div>
    @enderror
</div>
