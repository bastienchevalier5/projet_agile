@extends('layouts.app')
@section('title', $absence->exists ? 'Modification de l\'absence' : 'Création d\'absence')
@section('content')
<h1 class="h1">
    @if(Auth::user()->isAn('salarie'))
        Demande d'absence
    @else
        {{ $absence->exists ? 'Modification de l\'absence' : 'Création d\'absence' }}
    @endif
</h1>
<form method="post" action="{{ $absence->exists ? route('absence.update', $absence->id) : route('absence.store') }}" class="mb-3">
    @csrf
    @if($absence->exists)
        @method('PUT')
    @endif
    <div>
        <label for="debut">Début de l'absence</label>
        <input type="date" name="debut" id="debut" value="{{ old('debut', $absence->debut) }}">
        @error('debut')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="fin">Fin de l'absence</label>
        <input type="date" name="fin" id="fin" value="{{ old('fin', $absence->fin) }}">
        @error('fin')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="motif_id">Motif de l'absence : </label>
        <select name="motif_id" id="motif_id">
            @foreach ($motifs as $motif)
                <option value="{{ $motif->id }}" {{ old('motif_id', $absence->motif_id) == $motif->id ? 'selected' : '' }}>
                    {{ $motif->Libelle }}
                </option>
            @endforeach
        </select>
        @error('motif_id')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>
    @if (Auth::user()->isAn('admin'))
        <div>
            <label for="user_id">Utilisateur concerné : </label>
            <select name="user_id" id="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $absence->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name}}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div>
                    <p class="text-warning">{{ $message }}</p>
                </div>
            @enderror
        </div>
    @endif


    <input class="btn btn-secondary" type="submit" value="{{ $absence->exists ? 'Mettre à jour' : 'Envoyer' }}">
</form>
@endsection
