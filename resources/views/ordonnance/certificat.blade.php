@extends('layouts.app')

@section('title')
    @lang('messages.imprimer')
@endsection

@section('content')
<div class="container-fluid py-5 p-5">
    <header class="header">
        <div>
            @include('partials.entete-clinique')

            <h5>{{ __('Médecin') }} : {{ $medecin?->nom_prenom }}</h5>
            <h5>{{ __($medecin?->roleModel?->libelle ?? '') }}</h5>
            <h5>{{ __('Patient') }} : {{ $patient->nom_prenom }}</h5>
    <hr>
        </div>
        <img src="{{ asset('images/logo.jpg') }}" alt="{{ \App\Models\Parametre::valeur('clinique_nom') }}" class="header-logo">
    </header>

    <h2 class="text-center mb-3"><u>{{ __('Certificat médical') }}</u></h2>

    <p>
        {{ __('Je soussigné(e), Dr :medecin, certifie que l\'état de santé de :civilite :patient nécessite un arrêt de travail de', [
            'medecin' => $medecin?->nom_prenom,
            'civilite' => $patient->sexe === 'feminin' ? __('Mme') : __('M.'),
            'patient' => $patient->nom_prenom,
        ]) }}
        <input type="number" style="width:50px;" min="1">
        {{ __('jours, sauf complication, à compter du') }} <input type="date">.
    </p>

    <p><h6 class="text-center mt-5">{{ __('Signature') }} :</h6></p>

<hr>
    <div class="d-flex justify-content-end mb-3 mt-2">
        <button id="print-btn" class="btn btn-primary mr-2"><i class="fas fa-print mr-2"></i>{{ __('Imprimer') }}</button>
        <button class="btn btn-danger annuler"><a href="/listesordonnances" class="text-white">{{ __('Annuler') }}</a></button>
    </div>
</div>
    <script>
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection