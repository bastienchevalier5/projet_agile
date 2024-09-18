@extends('layouts.app')
@section('title','Modification du Motif')
@section('content')
<h1>Modification de motif</h1>
<a href="{{ Route('acceuil')}}">Acceuil</a>
<form method="POST" action="{{Route('motif.update',$motif)}}" class="mb-3">
    @csrf
    @method('PUT')
    <label for="Libelle">Libellé du motif</label>
    <input type="text" name="Libelle" value="{{$motif->Libelle}}">
    <input type="submit" value="Envoyer">
</form>
