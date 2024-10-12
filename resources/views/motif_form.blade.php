@extends('layouts.app')

@section('title', $motif->exists ? __('Edit reason') : __('Add reason'))

@section('content')
<x-back-button url="{{$motif->exists ? route('motif.show',$motif->id) : route('motif.index')}}"/>

<h1 class="h1">{{ $motif->exists ? __('Edit reason') : __('Add reason') }}</h1>

<x-form method="{{ $motif->exists ? 'PUT' : 'POST' }}" action="{{ $motif->exists ? route('motif.update', $motif->id) : route('motif.store') }}" submitText="{{ $motif->exists ? __('Update') : __('Submit') }}">
    <x-input label="{{ __('Reason name') }} : " name="Libelle" type="text" :value="old('Libelle', $motif->Libelle)" />
    <div class="mt-3">
        <x-button type="submit" color="secondary" actionType="{{$motif->exists ? 'modify' : 'add'}}" entityType="motif">
            {{ __($motif->exists ? 'Update' : 'Submit') }}
        </x-primary-button>
    </div>
</x-form>
@endsection
