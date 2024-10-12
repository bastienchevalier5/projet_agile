@extends('layouts.app')
@section('title', __((isset($users) ? 'Users' : (isset($motifs) ? 'Reasons' : 'Absences'))))
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<x-back-button url="{{route('accueil')}}"/>

<h2 class="h2">{{ __((isset($users) ? 'Users' : (isset($motifs) ? 'Reasons' : 'Absences')). ' List') }}</h2>

@php
$entity = isset($users) ? 'user' : (isset($motifs) ? 'motif' : 'absence')
@endphp


@can('create-'.$entity.'s')
    <a class="btn btn-primary mt-3" href="{{ route($entity.'.create') }}">
        {{ __('Add ' . ($entity === 'user' ? 'user' : ($entity === 'motif' ? 'reason' : 'absence'))) }}
    </a>
@endcan


@if (isset($users) && $users)

    <x-users-list :users="$users" />

@elseif (isset($motifs) && $motifs)
    <x-motifs-list :motifs="$motifs" />
@else
    <x-absences-list :absences="$absences" />
@endif






@endsection
