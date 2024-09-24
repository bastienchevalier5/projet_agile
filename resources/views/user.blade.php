@extends('layouts.app')
@section('title','Users')
@section('content')
<h1 class="h1">Users</h1>
@can ('create-users')
    <a class="btn btn-primary" href="{{Route('user.create')}}">Création d'un Utilisateur</a>
@endcan
@foreach ($users as $user)
    <table class="table">
        <tr>
        <td><a href="{{route('user.show',$user->id)}}">{{$user->name}}</a></td>
        </tr>
    </table>
@endforeach
@endsection

