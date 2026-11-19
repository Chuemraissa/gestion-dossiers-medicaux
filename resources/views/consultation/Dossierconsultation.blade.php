@extends('layouts.app')
      
@section('title')
    @lang('messages.consultation')
@endsection

@section('content')
<div class="container-fluid py-5 p-5">

<header class="header">
    <div>
        @include('partials.entete-clinique')
    </div>
        <img src="{{ asset('images/logo.jpg') }}" alt="{{ \App\Models\Parametre::valeur('clinique_nom') }}" class="header-logo">
</header>


    <div class="d-flex justify-content-end mb-3 mt-2">
      <button id="print-btn" class="btn btn-primary mr-2"><i class="fas fa-print mr-2"></i>{{ __('Imprimer') }}</button>
    </div>
    <div class="row gx-4 mb-5">
    @if(auth()->user()?->aAcces('consultations'))
      <div class="col-md-2 mt-3 mr-5">
        <a href="/vue-consultations/{{ $resource->id }}"  id="print-btn" class="btn btn-primary" style="font-size: 0.8rem;">{{ __('Retour') }}</a>
      </div>
      @endif
      <div class="col-md-3 mt-3" style="margin-left: 150px;">
        <h2><center><u>{{ __('Dossier médical') }}</u></center></h2><br>
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-12 col-xl-4 ">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">{{ __('Patient') }}</h6>
              </div>
          </div>
          <div class="card-body p-3">
            <ul class="list-group">
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Nom et prénom') }} :</strong> &nbsp; {{ $resource->nom_prenom }} </li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Téléphone') }} :</strong> &nbsp; {{ $resource->telephone }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('E-mail') }} :</strong> &nbsp; {{ $resource->email }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Adresse') }} :</strong> &nbsp; {{ $resource->adresse }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Date de naissance') }} :</strong> &nbsp; {{ $resource->date_naissance }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Sexe') }} :</strong> &nbsp; {{ in_array($resource->sexe, ['masculin', 'feminin']) ? __('messages.'.$resource->sexe) : $resource->sexe }}</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-xl-4">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">{{ __('Paramètres') }}</h6>
              </div>
          </div>
          @foreach($params as $param)
          <div class="card-body p-3">
            <ul class="list-group">
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Poids') }} :</strong> &nbsp; {{ $param->poids }} Kg</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Taille') }} :</strong> &nbsp; {{ $param->taille }} m</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Température') }} :</strong> &nbsp; {{ $param->temperature }} °C</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Pression artérielle') }} :</strong> &nbsp; {{ $param->pression_arterielle }} mmHg</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Groupe sanguin') }} :</strong> &nbsp; {{ \App\Models\ElementListe::libelle('groupes_sanguins', $param->groupe_sanguin) }}</li>
            </ul>
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-12 col-xl-4 ">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">{{ __('Antécédents') }}</h6>
              </div>
          </div>
          @foreach($antecedents as $antecedent)
          <div class="card-body p-3">
            <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Type') }} :</strong> &nbsp; {{ \App\Models\ElementListe::libelle('types_antecedent', $antecedent->type) }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Description') }} :</strong> &nbsp; {{ $antecedent->description }}</li>
            </ul>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-xl-4 ">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">{{ __('Consultations') }}</h6>
              </div>
          </div>
          @foreach($consultations as $consultation)
          <div class="card-body p-3">
            <ul class="list-group">
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Date et heure') }} :</strong> &nbsp; {{ $consultation->updated_at }} </li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Motif') }} :</strong> &nbsp; {{ $consultation->motif }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Type') }} :</strong> &nbsp; {{ \App\Models\ElementListe::libelle('types_consultation', $consultation->type) }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Symptômes') }} :</strong> &nbsp; {{ $consultation->symptome }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Diagnostic') }} :</strong> &nbsp; {{ $consultation->diagnostic }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Prix') }} :</strong> &nbsp; {{ $consultation->cout }}</li>
            </ul>
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-12 col-xl-4">
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
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Prix de l\'examen') }} :</strong> &nbsp; {{ $examen->cout }}</li>
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
      <div class="col-12 col-xl-4 ">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">{{ __('Ordonnances') }}</h6>
              </div>
          </div>
          @foreach($ordonnances as $ordonnance) 
          <div class="card-body p-3">
            <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{ __('Description') }} :</strong> &nbsp; {{ $ordonnance->description }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Médicament') }} :</strong> &nbsp; {{ $ordonnance->medicament_id == NULL?__('En attente'):$ordonnance->medicament->nom }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Prix du médicament') }} :</strong> &nbsp; {{ $ordonnance->medicament_id == NULL?__('En attente'):$ordonnance->medicament->cout }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Dose') }} :</strong> &nbsp; {{ $ordonnance->posologie->dose }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Fréquence') }} :</strong> &nbsp; {{ $ordonnance->posologie->frequence }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">{{ __('Durée') }} :</strong> &nbsp; {{ $ordonnance->posologie->duree }}</li>
            </ul>
          </div>
          @endforeach
          <h5 class="text-center">{{ __('Prix total des médicaments') }} : {{ $totalMedicament }} </h5>
        </div>
      </div>
    </div>
    
</div>
    <script>
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection