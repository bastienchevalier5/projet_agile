@extends('layouts.app')
@section('title', $user->exists ? 'Édition de user' : 'Création de user')
@section('content')
<h1 class="h1">{{ $user->exists ? 'Édition des informations de ' . $user->name : 'Création de user' }}</h1>
<form method="post" action="{{ $user->exists ? route('user.update', $user->id) : route('user.store') }}" class="mb-3">
    @csrf
    @if($user->exists)
        @method('PUT')
    @endif

    <div>
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
        @error('name')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" placeholder="{{ $user->exists ? 'Nouveau mot de passe' : '' }}">
    </div>

    <input class="btn btn-secondary" type="submit" value="{{ $user->exists ? 'Mettre à jour' : 'Envoyer' }}">
</form>
@endsection
