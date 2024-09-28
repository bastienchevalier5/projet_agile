@extends('layouts.app')
@section('title','Users')
@section('content')
<h1 class="h1">{{__('Users')}}</h1>
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
    {{ session('error')}}
</div>
@endif
@can ('create-users')
    <a class="btn btn-primary" href="{{Route('user.create')}}">{{__('Add user')}}</a>
@endcan
@foreach ($users as $user)
    <table class="table">
        <tr>
        <td><a href="{{route('user.show',$user->id)}}">{{$user->name}}</a></td>
        </tr>
    </table>
@endforeach
@endsection

