@extends('layouts.app')
@section('title', $motif->exists ? __('Edit reason') : __('Add reason'))
@section('content')
<h1 class="h1">{{ $motif->exists ? __('Edit reason') : __('Add reason') }}</h1>
<form method="post" action="{{ $motif->exists ? route('motif.update', $motif->id) : route('motif.store') }}" class="mb-3">
    @csrf
    @if($motif->exists)
        @method('PUT')
    @endif
    <div>
        <label for="Libelle">{{__('Reason name')}}</label>
        <input type="text" name="Libelle" id="Libelle" value="{{ old('Libelle', $motif->Libelle) }}">
        @error('Libelle')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <input class="btn btn-secondary" type="submit" value="{{ $motif->exists ? __('Update') : __('Send') }}">
</form>
@endsection
