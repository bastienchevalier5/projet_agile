@extends('layouts.app')
@section('title','Acceuil')
@section('content')
<div class="text-center mx-auto p-2 align-middle">
    <h1>Acceuil</h1>
    <a href="{{ Route('motif.index')}}">Liste des motifs</a>
    <a href="{{ Route('absence.index')}}">Liste des absences</a>
</div>
