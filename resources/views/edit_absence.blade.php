@extends('layouts.app')
@section('title','Modification de l\absence')
@section('content')
<h1>Modification de l'absence</h1>
<a href="{{ Route('acceuil')}}">Acceuil</a>
<form method="POST" action="{{Route('absence.update',$absence)}}" class="mb-3">
    @csrf
    @method('PUT')
    <label for="debut">Début de l'absence</label>
    <input type="date" name="debut" value="{{$absence->debut}}">
    <label for="fin">Fin de l'absence</label>
    <input type="date" name="fin" value="{{$absence->fin}}">
    <label for="motif_id">Motif de l'absence : </label>
    <select name="motif_id" id="motif_id">
        @foreach ($motifs as $motif)
            <option value="{{ $motif->id }}" {{ $motif->id == $absence->motif_id ? 'selected' : '' }}>
                {{ $motif->Libelle }}
            </option>
        @endforeach
    </select>
    <label for="user_id">Utilisateur concerné : </label>
    <select name="user_id" id="user_id">
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ $user->id == $absence->user_id ? 'selected' : '' }}>
                {{ $user->prenom }} {{ $user->nom }}
            </option>
        @endforeach
    </select>
    <input type="submit" value="Envoyer">
</form>
