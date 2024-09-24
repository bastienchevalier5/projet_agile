@extends('layouts.app')
@section('title','Motifs')
@section('content')
<h1 class="h1">Motifs</h1>
@can ('create-motifs')
    <a class="btn btn-primary" href="{{Route('motif.create')}}">Création de Motif</a>
@endcan
@foreach ($motifs as $motif)
    <table class="table">
        <tr>
            <td><a href="{{ route('motif.show',$motif->id)}}">{{$motif->Libelle}}</a></td>
        </tr>

    </table>
@endforeach
@endsection
