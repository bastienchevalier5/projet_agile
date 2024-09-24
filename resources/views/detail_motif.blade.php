@extends('layouts.app')
@section('title','Détail Motif')
@section('content')
<h3 class="h3">Nom du motif : {{$motif->Libelle}}</h3>
<p> Date : {{\Carbon\Carbon::parse($motif->created_at)->translatedFormat('d F Y')}}</p>
@can ('edit-motifs')
    <a class="btn btn-primary" href="{{ Route('motif.edit',$motif->id)}}">Modifier le motif</a>
@endcan
@can('delete-motifs')
    <form action="{{Route('motif.destroy',$motif->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce motif?')">Supprimer le motif</button>
    </form>
@endcan



<a class="btn btn-secondary" href="{{ Route('motif.index')}}">Retour à la liste des motifs</a>
@endsection
