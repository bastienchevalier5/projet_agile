@extends('layouts.app')
@section('title', $user->exists ? __('Edit user') : __('Add user'))
@section('content')
<x-back-button url="{{$user->exists ? route('user.show',$user->id) : route('user.index')}}"/>
    <h1 class="h1">{{ $user->exists ? __('Edit informations on ') . $user->name : __('Add user') }}</h1>
<x-form method="{{ $user->exists ? 'PUT' : 'POST' }}" action="{{ $user->exists ? route('user.update', $user->id) : route('user.store') }}" submitText="{{ $user->exists ? __('Update') : __('Submit') }}">

    <x-input label="{{ __('Name') }} : " name="name" type="text" :value="old('name', $user->name)" />

    <x-input label="{{ __('Email') }} : " name="email" type="email" :value="old('email', $user->email)" />

    <x-input label="{{__('Age')}} : " name="age" type="number" :value="old('age', $user->age)" />

    <x-input label="{{__('Job')}} : " name="poste" type="text" :value="old('poste', $user->poste)" />

    <x-input label="{{__('Service')}} : " name="service" type="text" :value="old('service', $user->service)" />

    <div class="mt-4">
        <label>{{ __('Is the user an administrator?') }}</label>
        <div>
            <input type="radio" id="admin_yes" name="is_admin" value="yes"
                {{ old('is_admin', $user->exists && $user->isAn('admin') ? 'yes' : 'no') === 'yes' ? 'checked' : '' }}>
            <label for="admin_yes">{{ __('Yes') }}</label>

            <input type="radio" id="admin_no" name="is_admin" value="no"
                {{ old('is_admin', $user->exists && $user->isAn('admin') ? 'yes' : 'no') === 'no' ? 'checked' : '' }}>
            <label for="admin_no">{{ __('No') }}</label>
        </div>
    </div>

    <div class="mt-3">
        <x-button type="submit" color="secondary" actionType="{{$user->exists ? 'modify' : 'add'}}" entityType="user">
            {{ __($user->exists ? 'Update' : 'Submit') }}
        </x-button>
    </div>

</x-form>
@endsection
