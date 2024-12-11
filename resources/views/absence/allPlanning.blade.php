@extends('layouts.app')
@section('title',__('Reasons detail'))
@section('content')
@php
    $user = Auth::user();
@endphp
<a href="{{ route('absence.userplanning',$user) }}">
    {{__('View only your absences')}}
</a>
<div id="calendar" class="m-2 mx-auto w-50"></div>

<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [FullCalendar.dayGridPlugin, FullCalendar.interactionPlugin],
        initialView: 'dayGridMonth',

        // Limite de la plage de dates
        validRange: {
            start: new Date(new Date().setFullYear(new Date().getFullYear() - 1)), // 1 an en arrière
            end: new Date(new Date().setFullYear(new Date().getFullYear() + 2))    // 2 ans en avant
        },

        initialDate: new Date(), // Date initiale (aujourd'hui)

        events: @json($calendarEvents),
        selectable: true,
        dateClick: function (info) {
            alert('Date: ' + info.dateStr);
        },
        locale: '{{ app()->getLocale() }}' // Ajout de la localisation selon la langue du projet
    });
    calendar.render();
});
</script>

</script>

@endsection
