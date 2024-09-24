@extends('layouts.app')
@section('title',__('Reasons'))
@section('content')
<h1 class="h1">{{__('Reasons')}}</h1>
@can ('create-motifs')
    <a class="btn btn-primary" href="{{Route('motif.create')}}">{{__('Add reason')}}</a>
@endcan
@foreach ($motifs as $motif)
    <table class="table">
        <tr>
            <td><a href="{{ route('motif.show',$motif->id)}}">{{$motif->Libelle}}</a></td>
        </tr>

    </table>
@endforeach
@endsection
