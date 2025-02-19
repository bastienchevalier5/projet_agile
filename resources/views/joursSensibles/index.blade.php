@extends('layouts.app')
@section('title', __('Sensible Period List'))
@section('content')
<h1 class="h1">{{ __('Sensible Period List') }}</h1>
<a class="btn btn-primary m-5" href="{{ route('joursSensibles.create') }}">{{ __('Add a Sensible Period') }}</a>

<table class="table table-light table-bordered table-responsive w-50 mx-auto">
    <thead>
        <tr>
            <th class="w-25">{{ __('Beginning') }}</th>
            <th class="w-25">{{ __('End') }}</th>
            <th class="w-25">{{ __('Team') }}</th>
            <th class="w-25">{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sensibles as $sensible)
        <tr>
            <td>{{ $sensible->debut }}</td>
            <td>{{ $sensible->fin }}</td>
            <td>{{ $sensible->equipe->nom }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('joursSensibles.edit', $sensible->id) }}">{{ __('Edit') }}</a>
                <x-form action="{{ route('joursSensibles.destroy', $sensible->id) }}" method="DELETE">
                    <x-button class="btn btn-danger m-3" type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this sensible period?') }}')">
                        {{ __('Delete') }}
                    </x-button>
                </x-form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">{{ __('No sensible periods found.') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
