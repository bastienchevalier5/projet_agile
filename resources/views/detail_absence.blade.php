@extends('layouts.app')
@section('title', 'Détail Absence de ' . $absence->user->name)
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<h1 class="h1">Absence de {{$absence->user->name}}</h1>
<h4>Motif : {{$absence->motif->Libelle}}</h4>
<p>Début : {{\Carbon\Carbon::parse($absence->debut)->translatedFormat('d F Y')}}</p>
<p>Fin : {{\Carbon\Carbon::parse($absence->fin)->translatedFormat('d F Y')}}</p>
@if (Auth::user()->isAn('salarie'))
    <p>{{$absence->statut == true ? 'Votre absence a été validée' : 'Votre absence n\'a pas encore été validée'}}</p>
@endif
@can ('edit-absences')
    @if ($absence->statut == 0)
        <a class="btn btn-primary" href="{{ Route('absence.edit',$absence->id)}}">Modifier l'absence</a>
    @endif
@endcan
@if (Auth::user()->isAn('admin'))
    <form action="{{ route('absence.validate', $absence->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button class="btn btn-success" type="submit" onclick="return confirm('Êtes-vous sûr de vouloir {{ $absence->statut == 0 ? 'valider' : 'retirer' }} cette absence ?')">{{ $absence->statut == 0 ? 'Valider' : 'Retirer' }} l'absence
    </button>
        </form>
@endif

@can('delete-absences')
    <form action="{{Route('absence.destroy',$absence->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette absence?')">Supprimer l'absence</button>
    </form>
@endcan
<a class="btn btn-secondary" href="{{ Route('absence.index')}}">Retour à la liste des absences</a>
@endsection
