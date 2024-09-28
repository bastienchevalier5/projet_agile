@extends('layouts.app')

@section('title', $motif->exists ? __('Edit reason') : __('Add reason'))

@section('content')
<h1 class="h1">{{ $motif->exists ? __('Edit reason') : __('Add reason') }}</h1>

<x-form method="{{ $motif->exists ? 'PUT' : 'POST' }}" action="{{ $motif->exists ? route('motif.update', $motif->id) : route('motif.store') }}" submitText="{{ $motif->exists ? __('Update') : __('Submit') }}">
    <x-input label="{{ __('Reason name') }} : " name="Libelle" type="text" :value="old('Libelle', $motif->Libelle)" />
</x-form>
@endsection
