@extends('layouts.app')
@section('title','Motifs')
@section('content')
<h1>Motifs</h1>
<ul>
    @foreach ($motifs as $motif)
    <li>
        <a href="{{ route('motif.show',$motif->id)}}">{{$motif->Libelle}}</a>
    </li>
    @endforeach
</ul>

