@extends('layouts.app')
@section('title','Détail Motif')
@section('content')
<h1>{{$motif->Libelle}}</h1>
<p>{{$motif->created_at}}</p>
<a href="{{ Route('motif.index')}}">Retour à la liste des motifs</a>

