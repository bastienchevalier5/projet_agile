@extends('layouts.app')
@section('title', __('Sensible Period List'))
@section('content')
<h1 class="h1"> {{__('Sensible Period List')}}</h1>
<a class="btn btn-primary m-5" href="{{route('joursSensibles.create')}}">{{ __('Add a Sensible Period')}}</a>
<table class="table table-light table-bordered table-responsive w-50 mx-auto">
    <tr>
        <td class="w-25">{{__('Beginning')}}</td>
        <td class="w-25">{{__('End')}}</td>
        <td class="w-25">{{__('Team')}}</td>
    </tr>
    <tr>
        @foreach ($sensibles as $sensible)
            <td>{{$sensible->debut}}</td>
            <td>{{$sensible->fin}}</td>
            <td>{{$sensible->equipe->nom}}</td>
        @endforeach
    </tr>
</table>
@endsection
