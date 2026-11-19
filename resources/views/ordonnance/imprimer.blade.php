@extends('layouts.app')

@section('title')
    @lang('messages.imprimer')
@endsection

@section('content')
<div class="container-fluid py-5 p-5">
    <header class="header">
        <div>
            @include('partials.entete-clinique')

            <h5>{{ __('Médecin') }} : {{ $medecins?->nom_prenom }}</h5>
            <h5>{{ __($medecins?->roleModel?->libelle ?? '') }}</h5>
            <h5>{{ __('Patient') }} : {{ $patients->nom_prenom }}</h5>
    <hr>
        </div>
        <img src="{{ asset('images/logo.jpg') }}" alt="{{ \App\Models\Parametre::valeur('clinique_nom') }}" class="header-logo">
    </header>

    <div class="row">
        <div class="col-6 col-xl-4 mt-2 ml-2">
            <div class="card card-plain h-100">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{ __('Examens effectués') }}</h6>
                </div>
            </div>
            @foreach($effectuers as $effectuer)
            @foreach($examens as $examen)
            @if($effectuer->examen_id == $examen->id)
            <div class="card-body p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Date et heure') }} :</strong> &nbsp; {{ $effectuer->updated_at }}</li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Type d\'examen') }} :</strong> &nbsp; {{ \App\Models\ElementListe::libelle('types_examen', $examen->type) }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Description de l\'examen') }} :</strong> &nbsp; {{ $examen->description }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Résultat') }} :</strong> &nbsp; {{ $effectuer->resultat }}</li>
                </ul>
            </div>
            @endif
            @endforeach
            @endforeach
            <h5 class="text-center">{{ __('Prix total des examens') }} : {{ $totalCost }} </h5>
            </div>
        </div>

        <div class="col-6 col-xl-4 mt-2 ml-2">
            <div class="card card-plain h-100">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{ __('Ordonnances') }}</h6>
                </div>
            </div>
            <div class="card-body p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Description') }} :</strong> &nbsp; {{ $ordonnancesAll->description }}</li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Type d\'examen') }} :</strong> &nbsp; {{ \App\Models\ElementListe::libelle('types_examen', $ordonnancesAll->examen?->type) }}</li>
                    @if($ordonnancesAll->medicament_id)
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Médicament') }} :</strong> &nbsp; {{ $ordonnancesAll->medicament->nom }}</li>
                    @else
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Médicament') }} :</strong> {{ __('Aucun pour le moment') }}</li>
                    @endif
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Dose') }} :</strong> &nbsp; {{ $ordonnancesAll->posologie->dose }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Fréquence') }} :</strong> &nbsp; {{ $ordonnancesAll->posologie->frequence }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Durée') }} :</strong> &nbsp; {{ $ordonnancesAll->posologie->duree }}</li>
                </ul>
            </div>
            <h5 class="text-center">{{ __('Prix total des médicaments') }} : {{ $totalMedicament }} </h5>
            </div>
        </div>
    </div>

    
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