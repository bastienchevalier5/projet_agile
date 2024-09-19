@extends('layouts.app')
@section('title','Détail Motif')
@section('content')
<a href="{{ Route('acceuil')}}">Acceuil</a>
<h3>Nom du motif : {{$motif->Libelle}}</h3>
<p>Accessible au salarié : {{$motif->is_accessible_salarie ? 'oui':'non'}}</p>
<p> Date : {{$motif->created_at}}</p>
<a href="{{ Route('motif.edit',$motif->id)}}">Modifier le motif</a>
@if ($motif->trashed())
<a href="{{route('motif.restore')}}">Restaurer</a>
<form action="{{Route('motif.destroy',$motif->id)}}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return('Êtes-vous sûr de vouloir supprimer ce motif?')">Supprimer le motif</button>
</form>
<a href="{{ Route('motif.index')}}">Retour à la liste des motifs</a>

