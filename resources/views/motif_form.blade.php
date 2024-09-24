@extends('layouts.app')
@section('title', $motif->exists ? 'Édition de Motif' : 'Création de Motif')
@section('content')
<h1 class="h1">{{ $motif->exists ? 'Édition de motif' : 'Création de motif' }}</h1>
<form method="post" action="{{ $motif->exists ? route('motif.update', $motif->id) : route('motif.store') }}" class="mb-3">
    @csrf
    @if($motif->exists)
        @method('PUT')
    @endif
    <div>
        <label for="Libelle">Libellé du motif</label>
        <input type="text" name="Libelle" id="Libelle" value="{{ old('Libelle', $motif->Libelle) }}">
        @error('Libelle')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label>Accessible aux salariés</label>
        <div>
            <input type="radio" name="is_accessible_salarie" value="1" id="is_accessible_salarie_oui" {{ old('is_accessible_salarie', $motif->is_accessible_salarie) == '1' ? 'checked' : '' }}>
            <label for="is_accessible_salarie_oui">Oui</label>
        </div>
        <div>
            <input type="radio" name="is_accessible_salarie" value="0" id="is_accessible_salarie_non" {{ old('is_accessible_salarie', $motif->is_accessible_salarie) == '0' ? 'checked' : '' }}>
            <label for="is_accessible_salarie_non">Non</label>
        </div>
        @error('is_accessible_salarie')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <input class="btn btn-secondary" type="submit" value="{{ $motif->exists ? 'Mettre à jour' : 'Envoyer' }}">
</form>
@endsection
