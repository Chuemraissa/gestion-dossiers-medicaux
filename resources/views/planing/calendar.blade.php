@extends('layouts.app')

@section('title')
Agenda
@endsection

@section('content')

<div class="container-fluid py-5"> <div id='calendar'></div> 
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, { initialView: 'dayGridMonth', locale: 'fr', events: [ 
        @foreach ($appointments as $appointment) { 
            title: '{{ $patients->where("id", $appointment->patient_id)->first()->nom_prenom }}', 
            start: '{{ $appointment->date }}T{{ $appointment->heure }}', 
            status: '{{ $appointment->statut }}', 
            nom_prenom: '{{ $patients->where("id", $appointment->patient_id)->first()->nom_prenom }}', 
            motif: '{{ $appointment->motif }}' 
            }, 
            @endforeach ], eventClick: function(info) { 
                alert('Nom & Prénom: ' + info.event.extendedProps.nom_prenom + '\nStatut: ' + info.event.extendedProps.status + '\nMotif: ' + info.event.extendedProps.motif);
                 } }); calendar.render(); 
    });
 </script>
@endsection