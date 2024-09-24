@extends('layouts.app')
@section('title',__('Absences'))
@section('content')
<h1 class="h1">{{__('Absences')}}</h1>
@can ('create-absences')
    <a class="btn btn-primary" href="{{Route('absence.create')}}">@if (Auth::user()->isAn('salarie')) {{__('Absence request')}} @else {{__('Add absence')}} @endif</a>
@endcan
@if (Auth::user()->isAn('admin'))
    @foreach ($absences as $absence)
        <table class="table">
            <tr>
                <td><a href="{{route('absence.show',$absence->id)}}">{{$absence->user->name}}</a></td>
            </tr>
        </table>
    @endforeach
@elseif (Auth::user()->isAn('salarie'))
    @foreach ($absences as $absence)
        <table class="table">
            <tr>
                <td><a href="{{route('absence.show',$absence->id)}}">{{\Carbon\Carbon::parse($absence->debut)->translatedFormat('d F Y')}}</a></td>
            </tr>
        </table>
    @endforeach

@endif

@endsection

