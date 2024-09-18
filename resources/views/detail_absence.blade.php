@extends('layouts.app')
@section('title', 'Détail Absence de ' . $absence->user->prenom.' '.$absence->user->nom)
@section('content')
<h1>Absence de {{$absence->user->prenom}} {{$absence->user->nom}}</h1>
<h3>{{$absence->motif->Libelle}}</h3>
<a href="{{ Route('absence.index')}}">Retour à la liste des absences</a>

