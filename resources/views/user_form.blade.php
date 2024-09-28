@extends('layouts.app')
@section('title', $user->exists ? __('Edit user') : __('Add user'))
@section('content')
<h1 class="h1">{{ $user->exists ? __('Edit informations on ') . $user->name : __('Add user') }}</h1>
<x-form method="{{ $user->exists ? 'PUT' : 'POST' }}" action="{{ $user->exists ? route('user.update', $user->id) : route('user.store') }}" submitText="{{ $user->exists ? __('Update') : __('Submit') }}">
    <x-input label="{{ __('Name') }} : " name="name" type="text" :value="old('name',$user->name)" />
    <x-input label="{{__('Email') }} : " name="email" type="email" :value="old('email',$user->email)" />
</x-form>
@endsection
