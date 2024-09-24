@extends('layouts.app')
@section('title', 'Demande d\'absence')
@section('content')
<div class="panel">
<h1>Demande d'absence de {{$user->name ?? 'Utilisateur inconnu'}}</h1>

<table>
    <p>{{$user->name ?? 'Un utilisateur'}} a effectué une demande d'absence</p>
    <p>Détail :</p>
    <ul>
        <li>Motif : {{$motif->Libelle ?? 'Motif non spécifié'}}</li>
        <li>Début : {{\Carbon\Carbon::parse($absence->debut)->translatedFormat('d F Y')}}</li>
        <li>Fin : {{\Carbon\Carbon::parse($absence->fin)->translatedFormat('d F Y')}}</li>
    </ul>
</table>
</div>
@endsection
