@extends('layouts.app')
@section('title','Motifs')
@section('content')
<a href="{{ Route('acceuil')}}">Acceuil</a>
<h1>Motifs</h1>
<a href="{{Route('motif.create')}}">Création de Motif</a>
<ul>
    @foreach ($motifs as $motif)
    <li>
        <a href="{{ route('motif.show',$motif->id)}}">{{$motif->Libelle}}</a>
    </li>
    @endforeach
</ul>

