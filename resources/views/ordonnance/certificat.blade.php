@extends('layouts.app')

@section('title')
    Imprimer
@endsection

@section('content')
<div class="container-fluid py-5 p-5">
    <header class="header">
        <div>
            <h1>Electronical Folder</h1>
            <h5>Entrée de Bafoussam, BP 1234, <br>Région de l'Ouest, Cameroun</h5>
            <h5>Tél : +237699060031</h5>
            
            <h5>Nom Medecin: {{ session('nomuser') }}</h5>
            <h5>Medecin Generaliste</h5>
            <h5>Nom Patient: {{ $patient->nom_prenom }}</h5>
    <hr>
        </div>
        <img src="{{ asset('images/logo.jpg') }}" alt="Clinique Médicale" class="header-logo">
    </header>

    <h2 class="text-center mb-3"><u>Certificat</u></h2>

    <p>
        Je sousigne Dr.
        {{ session('nomuser') }}
        , Medecin generaliste certifie que l'état de santé de
        @if( $patient->sexe == "masculin")
        Mr.
        @else
        Mme.
        @endif
        {{ $patient->nom_prenom }}, necessite un
        arret de travail de <input type="number" style="width:50px;" min="1"> jours, sauf complication à dater du <input type="date">.
    </p>

    <p><h6 class="text-center mt-5">Signature:</h6></p>

<hr>
    <div class="d-flex justify-content-end mb-3 mt-2">
        <button id="print-btn" class="btn btn-primary mr-2"><i class="fas fa-print mr-2"></i>Imprimer</button>
        <button class="btn btn-danger annuler"><a href="/listesordonnances" class="text-white">Annuler</a></button>
    </div>
</div>
    <script>
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection