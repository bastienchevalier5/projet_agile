@extends('layouts.app')
@section('title','Acceuil')
@section('content')
@if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
@endif
<div class="position-absolute top-50 start-50 translate-middle">
    <h1 class="h1 mb-5">{{__('Welcome')}}</h1>
    @can('view-users')
        <a class="btn btn-secondary" href="{{ Route('user.index')}}">{{__('Users list')}}</a>
    @endcan
    @can('view-motifs')
        <a class="btn btn-secondary" href="{{ Route('motif.index')}}">{{__('Reasons list')}}</a>
    @endcan
    <a class="btn btn-secondary" href="{{ Route('absence.index')}}">{{__('Absences list')}}</a>

    @if (Auth::user()->isAn('rh'))
        <a class="btn btn-secondary" href="{{ Route('joursSensibles.index')}}">{{__('Sensible Period List')}}</a>
    @endif
</div>
@endsection
