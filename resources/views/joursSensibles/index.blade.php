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
        <td class="w-25">Actions</td>
    </tr>
    <tr>
        @foreach ($sensibles as $sensible)
            <td>{{$sensible->debut}}</td>
            <td>{{$sensible->fin}}</td>
            <td>{{$sensible->equipe->nom}}</td>
            <td><a class="btn btn-primary" href="{{route('joursSensibles.edit',$sensible->id)}}">{{__('Edit')}}</a>
                <x-form action="{{Route('joursSensibles.destroy',$sensible->id)}}" method="DELETE">
                    <x-button class="btn btn-danger m-3" type="submit" onclick="return confirm('{{__('Are you sure to want to delete this sensible period?')}}')">{{__('Delete')}}</x-button>
                </x-form></td>
        @endforeach
    </tr>
</table>
@endsection
