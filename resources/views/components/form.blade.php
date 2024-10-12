@props(['method' => 'POST', 'action' => '#', 'submitText' => __('Submit')])

<form method="{{ strtolower($method) === 'get' ? 'GET' : 'POST' }}" action="{{ $action }}">
    @csrf

    @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    {{ $slot }}
</form>
