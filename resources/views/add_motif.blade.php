@extends('layouts.app')
@section('title','Création de Motif')
@section('content')
<h1>Création de motif</h1>
<a href="{{ Route('acceuil')}}">Acceuil</a>
<form method="post" action="{{Route('motif.store')}}" class="mb-3">
    @csrf
    <label for="Libelle">Libellé du motif</label>
    <input type="text" name="Libelle" value="{{ old('Libelle') }}">
    <input type="submit" value="Envoyer">
</form>
