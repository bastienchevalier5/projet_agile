@extends('layouts.app')
@section('title',__('Reasons detail'))
@section('content')
<h3 class="h3">{{__('Reason name').' : '.$motif->Libelle}}</h3>
<p>{{__('Date').' : '.\Carbon\Carbon::parse($motif->created_at)->translatedFormat('d F Y')}}</p>
@can ('edit-motifs')
    <a class="btn btn-primary" href="{{ Route('motif.edit',$motif->id)}}">{{__('Edit reason')}}</a>
@endcan
@can('delete-motifs')
    <form action="{{Route('motif.destroy',$motif->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to want todelete this reason?')">{{__('Delete reason')}}</button>
    </form>
@endcan



<a class="btn btn-secondary" href="{{ Route('motif.index')}}">{{__('Back to the reasons list')}}</a>
@endsection
