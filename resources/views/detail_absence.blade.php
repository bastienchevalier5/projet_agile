@extends('layouts.app')
@section('title', 'Détail Absence de ' . $absence->user->prenom.' '.$absence->user->nom)
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<a href="{{ Route('acceuil')}}">Acceuil</a>
<h1>Absence de {{$absence->user->prenom}} {{$absence->user->nom}}</h1>
<h4>Motif : {{$absence->motif->Libelle}}</h4>
<p>Début : {{$absence->debut}}</p>
<p>Fin : {{$absence->fin}}</p>
<a href="{{ Route('absence.edit',$absence->id)}}">Modifier l'absence</a>
<form action="{{Route('absence.destroy',$absence->id)}}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return('Êtes-vous sûr de vouloir supprimer cette absence?')">Supprimer l'absence</button>
</form>
<a href="{{ Route('absence.index')}}">Retour à la liste des absences</a>

