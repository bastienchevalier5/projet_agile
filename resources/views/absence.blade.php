@extends('layouts.app')
@section('title','Absences')
@section('content')
<h1>Absences</h1>
<a href="{{ Route('acceuil')}}">Acceuil</a>
<a href="{{Route('absence.create')}}">Création d'une absence</a>
<ul>
    @foreach ($absences as $absence)
    <li>
        <a href="{{route('absence.show',$absence->id)}}">{{$absence->user->prenom}} {{$absence->user->nom}}</a>
    </li>
    @endforeach
</ul>

