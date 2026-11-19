@extends('layouts.app')

@section('title')
    @lang('messages.planing')
@endsection

@section('content')
<div class="container-fluid py-5">
    <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendrier = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: @json(strtolower(str_replace('_', '-', app()->getLocale()))),
        // Les rendez-vous sont préparés par RdvController::calendar()
        events: @json($evenements),
        eventClick: function (info) {
            var p = info.event.extendedProps;
            alert(p.patient + '\n' + p.statut + '\n' + p.motif);
        }
    });

    calendrier.render();
});
</script>
@endsection
