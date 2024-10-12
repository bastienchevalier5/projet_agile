@extends('layouts.app')

@section('title', $absence->exists ? __('Edit absence') : __('Add absence'))

@section('content')
<x-back-button url="{{$absence->exists ? route('absence.show',$absence->id) : route('absence.index')}}"/>
<h1 class="h1">
    @if(Auth::user()->isAn('salarie'))
        {{ __('Absence request') }}
    @else
        {{ $absence->exists ? __('Edit absence') : __('Add absence') }}
    @endif
</h1>

<x-form method="{{ $absence->exists ? 'PUT' : 'POST' }}" action="{{ $absence->exists ? route('absence.update', $absence->id) : route('absence.store') }}" submitText="{{ $absence->exists ? __('Update') : __('Submit') }}">

    <x-input label="{!! __('Beginning of the Absence') !!} : " name="debut" type="date" :value="old('debut',$absence->debut)" />

    <x-input label="{!! __('End of the Absence') !!} : " name="fin" type="date" :value="old('fin',$absence->fin)" />

    <x-select label="{!! __('Reason of the Absence') !!} : " name="motif_id" :options="$motifs->pluck('Libelle', 'id')" :selected="$absence->motif_id" />

    @if (Auth::user()->isAn('admin'))
        <x-select label="{{ __('User concerned') }} : " name="user_id" :options="$users->pluck('name', 'id')" :selected="$absence->user_id" />
    @endif

    <div class="mt-3">
        <x-button type="submit" color="secondary" actionType="{{$absence->exists ? 'modify' : 'add'}}" entityType="absence">
            {{ __($absence->exists ? 'Update' : 'Submit') }}
        </x-primary-button>
    </div>

</x-form>
@endsection
