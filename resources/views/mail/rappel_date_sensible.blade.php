@extends('layouts.app')
@section('title', __('Absence request'))
@section('content')
<div class="panel">
<h1>{{__('Next sensible period')}}</h1>

<table>
    <p>{{__('Detail')}} :</p>
    <ul>
        <li>{{__('Reason')}}</li>
        <li>{{__('Beginning')}} : {{\Carbon\Carbon::parse($sensible->debut)->translatedFormat('d F Y')}}</li>
        <li>{{__('End')}} : {{\Carbon\Carbon::parse($sensible->fin)->translatedFormat('d F Y')}}</li>
    </ul>
</table>
</div>
@endsection
