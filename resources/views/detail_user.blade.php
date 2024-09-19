@extends('layouts.app')
@section('title','Informations de {{$user->prenom}} {{$user->nom}}')
@section('content')
<a href="{{ Route('acceuil')}}">Acceuil</a>
<h3>Informations de {{$user->prenom}} {{$user->nom}}</h3>
<p>Nom : {{$user->nom}}</p>
<p>Prénom : {{$user->prenom}}</p>
<p>Email : {{$user->email}}</p>
<a href="{{ Route('user.edit',$user->id)}}">Modifier le user</a>
<form action="{{Route('user.destroy',$user->id)}}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return('Êtes-vous sûr de vouloir supprimer ce user?')">Supprimer le user</button>
</form>
<a href="{{ Route('user.index')}}">Retour à la liste des users</a>

