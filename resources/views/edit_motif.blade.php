@extends('layouts.app')

@section('title', 'Modification du Motif')

@section('content')
    <h1>Modification de motif</h1>
    <a href="{{ route('acceuil') }}">Acceuil</a>
    <form method="POST" action="{{ route('motif.update', $motif) }}" class="mb-3">
        @csrf
        @method('PUT')
        <div>
            <label for="Libelle">Libellé du motif</label>
            <input type="text" name="Libelle" id="Libelle" value="{{ $motif->Libelle }}" required>
        </div>

        <div>
            <label>Accessible aux salariés</label>
            <div>
                <input type="radio" name="is_accessible_salarie" value="1" id="is_accessible_salarie_oui" {{ $motif->is_accessible_salarie ? 'checked' : '' }}>
                <label for="is_accessible_salarie_oui">Oui</label>
            </div>
            <div>
                <input type="radio" name="is_accessible_salarie" value="0" id="is_accessible_salarie_non" {{ !$motif->is_accessible_salarie ? 'checked' : '' }}>
                <label for="is_accessible_salarie_non">Non</label>
            </div>
        </div>

        <input type="submit" value="Envoyer">
    </form>
@endsection
