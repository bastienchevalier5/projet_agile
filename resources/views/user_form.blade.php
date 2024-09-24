@extends('layouts.app')
@section('title', $user->exists ? __('Edit user') : __('Add user'))
@section('content')
<h1 class="h1">{{ $user->exists ? __('Edit informations on ') . $user->name : __('Add user') }}</h1>
<form method="post" action="{{ $user->exists ? route('user.update', $user->id) : route('user.store') }}" class="mb-3">
    @csrf
    @if($user->exists)
        @method('PUT')
    @endif

    <div>
        <label for="name">{{('Name')}} :</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
        @error('name')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="email">{{('Email')}} :</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <div>
                <p class="text-warning">{{ $message }}</p>
            </div>
        @enderror
    </div>

    <div>
        <label for="password">{{__('Password')}} :</label>
        <input type="password" name="password" id="password" placeholder="{{ $user->exists ? __('New password') : '' }}">
    </div>

    <input class="btn btn-secondary" type="submit" value="{{ $user->exists ? __('Update') : __('Send') }}">
</form>
@endsection
