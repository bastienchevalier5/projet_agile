@extends('layouts.app')
@section('title', __('Absence request'))
@section('content')
<div class="panel">
<h1>{{__('Absence request from')}} {{$user->name}}</h1>

<table>
    <p>{{$user->name}} {{__('has made an absence request')}}</p>
    <p>{{__('Detail')}} :</p>
    <ul>
        <li>{{__('Reason')}} : {{$motif->Libelle}}</li>
        <li>{{__('Beginning')}} : {{\Carbon\Carbon::parse($absence->debut)->translatedFormat('d F Y')}}</li>
        <li>{{__('End')}} : {{\Carbon\Carbon::parse($absence->fin)->translatedFormat('d F Y')}}</li>
    </ul>
</table>
</div>
@endsection
