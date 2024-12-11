@extends('layouts.app')
@section('title', __('Your absence was refused'))
@section('content')
<div class="panel">
<h1>{{__('Your absence was refused')}}</h1>

<table>
    <p>{{$user->name}} {{__('has refused your absence request.')}}</p>
    <p>{{__('Detail')}} :</p>
    <ul>
        <li>{{__('')}}</li>
        <li>{{__('Reason')}} : {{$motif->Libelle}}</li>
        <li>{{__('Beginning')}} : {{\Carbon\Carbon::parse($absence->debut)->translatedFormat('d F Y')}}</li>
        <li>{{__('End')}} : {{\Carbon\Carbon::parse($absence->fin)->translatedFormat('d F Y')}}</li>
    </ul>
</table>
</div>
@endsection
