@extends('layouts.app')
@section('title', __('Absence detail of') . $absence->user->name)
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<x-back-button url="{{route('absence.index')}}"/>
    <h1 class="h1">{{__('Absence of ')}} {{$absence->user->name}}</h1>
<h4>{{__('Reason').' : '.$absence->motif->Libelle}}</h4>
<p>{{__('Beginning').' : '.\Carbon\Carbon::parse($absence->debut)->translatedFormat('d F Y')}}</p>
<p>{{__('End').' : '.\Carbon\Carbon::parse($absence->fin)->translatedFormat('d F Y')}}</p>
@if (Auth::user()->isAn('salarie'))
<p>
    {{ $absence->statut == 3 ? __('Your absence has not yet been validated') :
       ($absence->statut == 1 ? __('Your absence has been validated') :
       ($absence->statut == 0 ? __('Your absence has been refused') : '')) }}
</p>

@endif
@can ('edit-absences')
    @if ($absence->statut == 0)
        <a class="btn btn-primary m-3" href="{{ Route('absence.edit',$absence->id)}}">{{__('Edit absence')}}</a>
    @endif
@endcan
@if (Auth::user()->isAn(roles: 'rh') && $absence->statut != 1)
    <form action="{{ route('absence.validate', $absence->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button class="btn btn-success m-3" type="submit"
        onclick="return confirm('{{ __('Are you sure to want to validate this absence ?') }}')">
        {{ __('Validate')}} {{__(' this absence')}}
        </button>
        </form>
@endif

@if (Auth::user()->isAn(roles: 'rh') && $absence->statut == 1)
    <form action="{{ route('absence.refuse', $absence->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-danger m-3" onclick="return confirm('{{ __('Are you sure to want to refuse this absence ?') }}')">
            {{__('Refuse absence') }}
        </button>
    </form>
@endif
@endsection
