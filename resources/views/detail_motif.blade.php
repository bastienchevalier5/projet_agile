@extends('layouts.app')
@section('title',__('Reasons detail'))
@section('content')
<x-back-button url="{{route('motif.index')}}"/>
    <h3 class="h3">{{__('Reason name').' : '.$motif->Libelle}}</h3>
<p>{{__('Date').' : '.\Carbon\Carbon::parse($motif->created_at)->translatedFormat('d F Y')}}</p>
@can ('edit-motifs')
    <a class="btn btn-primary m-3" href="{{ Route('motif.edit',$motif->id)}}">{{__('Edit reason')}}</a>
@endcan
@can('delete-motifs')
    <form action="{{Route('motif.destroy',$motif->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger m-3" type="submit" onclick="return confirm('{{__('Are you sure to want to delete this reason?')}}')">{{__('Delete reason')}}</button>
    </form>
@endcan
@endsection
