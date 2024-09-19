@extends('layouts.app')
@section('title','Users')
@section('content')
<h1>Users</h1>
<a href="{{ Route('acceuil')}}">Acceuil</a>
<a href="{{Route('user.create')}}">Création d'un Utilisateur</a>
<ul>
    @foreach ($users as $user)
    <li>
        <a href="{{route('user.show',$user->id)}}">{{$user->prenom}} {{$user->nom}}</a>
    </li>
    @endforeach
</ul>

