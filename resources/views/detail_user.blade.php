@extends('layouts.app')
@section('title','Informations de '.$user->name)
@section('content')
<h1 class="h1">Informations de {{$user->name}}</h1>
<p>Nom : {{$user->name}}</p>
<p>Email : {{$user->email}}</p>
<p>Administrateur : {{$user->admin ? 'Oui' : 'Non'}}</p>
@can ('edit-users')
    <a class="btn btn-primary" href="{{ Route('user.edit',$user->id)}}">Modifier le user</a>
@endcan
@can ('delete-users')
    <form action="{{Route('user.destroy',$user->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce user?')">Supprimer le user</button>
    </form>
@endcan

<a class="btn btn-secondary" href="{{ Route('user.index')}}">Retour à la liste des users</a>
@endsection
