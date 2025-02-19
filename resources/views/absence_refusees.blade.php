@extends('layouts.app')
@section('title', __('Refused Absences History'))

@section('content')
    <div class="container">
        <h1 class="h1 m-5">{{ __('Your Refused Absences') }}</h1>

        @if($absencesRefusees->isEmpty())
            <p>{{ __('No refused absences yet.') }}</p>
        @else
            <table class="m-5 table table-light table-bordered table-responsive w-50 mx-auto">
                <thead>
                    <tr>
                        <th>{{ __('Request Date') }}</th>
                        <th>{{ __('Reason') }}</th>
                        <th>{{ __('Refusal Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absencesRefusees as $absence)
                        <tr>
                            <td>{{ $absence->created_at->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $motif = json_decode($absence->motif, true);
                                @endphp
                                {{ $motif['Libelle'] ?? __('No reason provided') }}
                            </td>
                                                        <td>{{ $absence->updated_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
