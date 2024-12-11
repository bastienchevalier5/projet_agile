@extends('layouts.app')
@section('title', __('Add a Sensible Period'))
@section('content')
<h1 class="h1">{{__('Add a Sensible Period')}}</h1>
<x-form action="{{route('joursSensibles.store')}}" method="POST">
    <x-input label="{{__('Beginning')}} :" type="date" name="debut" :value="$sensible->debut" />
    <x-input label="{{__('End')}} :" type="date" name="fin" :value="$sensible->fin" />
    <x-select label="{{__('Team')}} :" name="equipe" :options="$equipe->pluck('nom', 'id')" :selected="$sensible->equipe_id" />
    <x-button>
        {{__('Submit')}}
    </x-button>
</x-form>
@endsection
