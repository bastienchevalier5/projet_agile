@extends('layouts.app')
@section('title','Informations de '.$user->name)
@section('content')
<x-back-button url="{{route('user.index')}}"/>
    <h1 class="h1">{{__('Informations on').' '.$user->name}}</h1>
<p>{{__('Name').' : '.$user->name}}</p>
<p>{{__('Email').' : '.$user->email}}</p>
<p>{{ __('Administrator') . ' : ' . ($user->isAn('admin') ? __('Yes') : __('No')) }}</p>
@can ('edit-users')
    <a class="btn btn-primary m-3" href="{{ Route('user.edit',$user->id)}}">{{__('Edit user')}}</a>
@endcan
@can ('delete-users')
    <form action="{{Route('user.destroy',$user->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger m-3" type="submit" onclick=" return confirm('{{__('Are you sure to want to delete this user?')}}')">{{__('Delete user')}}</button>
    </form>
@endcan
@endsection
