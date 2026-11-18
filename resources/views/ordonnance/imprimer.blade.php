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
            <h5>Tél : +237695236548</h5>
            
            <h5>Nom Medecin: {{ session('nomuser') }}</h5>
            <h5>Medecin Generaliste</h5>
            <h5>Nom Patient: {{ $patients->nom_prenom }}</h5>
    <hr>
        </div>
        <img src="{{ asset('images/logo.jpg') }}" alt="Clinique Médicale" class="header-logo">
    </header>

    <div class="row">
        <div class="col-6 col-xl-4 mt-2 ml-2">
            <div class="card card-plain h-100">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Traitements effectués</h6>
                </div>
            </div>
            @foreach($effectuers as $effectuer)
            @foreach($examens as $examen)
            @if($effectuer->examen_id == $examen->id)
            <div class="card-body p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Date & heure:</strong> &nbsp; {{ $effectuer->updated_at }}</li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Type d'examen:</strong> &nbsp; {{ $examen->type }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Description de l'examen:</strong> &nbsp; {{ $examen->description }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Resultat:</strong> &nbsp; {{ $effectuer->resultat }}</li>
                </ul>
            </div>
            @endif
            @endforeach
            @endforeach
            <h5 class="text-center">Prix total des examens: {{ $totalCost }} </h5>
            </div>
        </div>

        <div class="col-6 col-xl-4 mt-2 ml-2">
            <div class="card card-plain h-100">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Ordonnances</h6>
                </div>
            </div>
            <div class="card-body p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Description:</strong> &nbsp; {{ $ordonnancesAll->description }}</li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Type d'examen:</strong> &nbsp; {{ $ordonnancesAll->examen->type }}</li>
                    @if($ordonnancesAll->medicament_id)
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Medicament:</strong> &nbsp; {{ $ordonnancesAll->medicament->nom }}</li>
                    @else
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Medicament:</strong> &nbsp; Aucun pour le moment</li>
                    @endif
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Dose:</strong> &nbsp; {{ $ordonnancesAll->posologie->dose }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Frequence:</strong> &nbsp; {{ $ordonnancesAll->posologie->frequence }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Durée:</strong> &nbsp; {{ $ordonnancesAll->posologie->duree }}</li>
                </ul>
            </div>
            <h5 class="text-center">Prix total des medicaments: {{ $totalMedicament }} </h5>
            </div>
        </div>
    </div>

    
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