@extends('layouts.app')
@section('title', $user->exists ? 'Édition de user' : 'Création de user')
@section('content')
<h1>{{ $user->exists ? 'Édition des informations de ' . $user->prenom . ' ' . $user->nom : 'Création de user' }}</h1>
<a href="{{ route('acceuil') }}">Acceuil</a>
<form method="post" action="{{ $user->exists ? route('user.update', $user->id) : route('user.store') }}" class="mb-3">
    @csrf
    @if($user->exists)
        @method('PUT')
    @endif
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}">
        @error('nom')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="nom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}">
        @error('prenom')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="nom">Email :</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}">
        @error('email')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>


    <input type="submit" value="{{ $user->exists ? 'Mettre à jour' : 'Envoyer' }}">
</form>
@endsection
