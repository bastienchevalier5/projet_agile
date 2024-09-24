@extends('layouts.app')
@section('title','Acceuil')
@section('content')
@if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
@endif
<div class="position-absolute top-50 start-50 translate-middle">
    <h1 class="h1 mb-5">Accueil</h1>
    @can('view-users')
        <a class="btn btn-secondary" href="{{ Route('user.index')}}">Liste des users</a>
    @endcan
    <a class="btn btn-secondary" href="{{ Route('motif.index')}}">Liste des motifs</a>
    <a class="btn btn-secondary" href="{{ Route('absence.index')}}">Liste des absences</a>
</div>
@endsection
