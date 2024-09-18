@extends('layouts.app')
@section('title','Création d\'absence')
@section('content')
<h1>Création d'absence</h1>
<a href="{{ Route('acceuil')}}">Acceuil</a>
<form method="post" action="{{Route('absence.store')}}" class="mb-3">
    @csrf
    <label for="debut">Début de l'absence</label>
    <input type="date" name="debut">
    <label for="fin">Fin de l'absence</label>
    <input type="date" name="fin">
    <label for="motif_id">Motif de l'absence : </label>
    <select name="motif_id">
        @foreach ($motifs as $motif)
            <option value="{{$motif->id}}">{{$motif->Libelle}}</option>
        @endforeach
    </select>
    <label for="user_id">Utilisateur concerné : </label>
    <select name="user_id">
        @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->prenom}} {{$user->nom}}</option>
        @endforeach
    </select>
    <input type="submit" value="Envoyer">
</form>
