@extends('layouts.app')
@section('title',__('Profile'))
@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
    {{ session('error')}}
</div>
@endif
<x-back-button url="{{route('accueil')}}"/>
<h1 class="h1 text-center m-5">{{ __('Profile') }}</h1>
<div class="card bg-dark-subtle w-50 mx-auto">
    <x-form method="patch" action="{{ route('profile.update') }}" submitText="{{__('Update')}}">
        <h2 class="h3 m-5">Modifier mes informations</h2>
        <x-input label="{{ __('Name') }} : " name="name" type="text" :value="old('name',$user->name)" />
        <x-input label="{{ __('Email')}} : " name="email" type="email" :value="old('email',$user->email)" />

    </x-form>
</div>

@endsection
