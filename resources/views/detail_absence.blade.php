@extends('layouts.app')
@section('title', __('Absence detail of') . $absence->user->name)
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<h1 class="h1">{{__('Absence of ')}} {{$absence->user->name}}</h1>
<h4>{{__('Reason').' : '.$absence->motif->Libelle}}</h4>
<p>{{__('Beginning').' : '.\Carbon\Carbon::parse($absence->debut)->translatedFormat('d F Y')}}</p>
<p>{{__('End').' : '.\Carbon\Carbon::parse($absence->fin)->translatedFormat('d F Y')}}</p>
@if (Auth::user()->isAn('salarie'))
    <p>{{$absence->statut == true ? __("Your absence has been validated") : __('Your absence has not yet been validated')}}</p>
@endif
@can ('edit-absences')
    @if ($absence->statut == 0)
        <a class="btn btn-primary" href="{{ Route('absence.edit',$absence->id)}}">{{__('Edit absence')}}</a>
    @endif
@endcan
@if (Auth::user()->isAn('admin'))
    <form action="{{ route('absence.validate', $absence->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button class="btn btn-success" type="submit"
        onclick="return confirm('{{ __('Are you sure to') . ($absence->statut == 0 ? __('validate') : __('remove')) . __('this absence ?') }}')">
        {{ $absence->statut == 0 ? __('Validate') : __('Remove') }} {{__('this absence')}}
    </button>
        </button>
        </form>
@endif

@can('delete-absences')
    <form action="{{Route('absence.destroy',$absence->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm({{__('Are you sure to want to delete this absence')}})">{{__('Delete absence')}}</button>
    </form>
@endcan
<a class="btn btn-secondary" href="{{ Route('absence.index')}}">{{__('Back to the absences list')}}</a>
@endsection
