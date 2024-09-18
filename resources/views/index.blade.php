@extends('layouts.app')
@section('title','Acceuil')
@section('content')
<div class="title">
    <h1>Acceuil</h1>
    <a href="{{ Route('motif.index')}}">Liste des motifs</a>
    <a href="{{ Route('absence.index')}}">Liste des absences</a>
</div>



