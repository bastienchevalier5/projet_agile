@extends('layouts.app')
@section('title','Création de Motif')
@section('content')
<h1>Création de motif</h1>
<a href="{{ Route('acceuil')}}">Acceuil</a>
<form method="post" action="{{ route('motif.store') }}" class="mb-3">
    @csrf
    <div>
        <label for="Libelle">Libellé du motif</label>
        <input type="text" name="Libelle" id="Libelle">
    </div>

    <div>
        <label>Accessible aux salariés</label>
        <div>
            <input type="radio" name="is_accessible_salarie" value="1" id="is_accessible_salarie_oui">
            <label for="is_accessible_salarie_oui">Oui</label>
        </div>
        <div>
            <input type="radio" name="is_accessible_salarie" value="0" id="is_accessible_salarie_non">
            <label for="is_accessible_salarie_non">Non</label>
        </div>
    </div>

    <input type="submit" value="Envoyer">
</form>
