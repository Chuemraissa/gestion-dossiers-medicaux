@extends('layouts.app')
      
@section('title')
    @lang('messages.patients')
@endsection

@section('content')
<div class="container-fluid py-5">
  <div class="row gx-4 mb-5">
    <div class="col-auto my-auto">
      <div class="h-100">
        <h5 class="mb-1">
          {{$resource->nom_prenom}}
        </h5>
      </div>
    </div>
    <div class="col-md-2 mt-3">
      <a href="/listespatients" class="btn btn-primary" style="font-size: 0.8rem;">Retour</a>
    </div>
  </div>
  <div class="row">
    <div class="row">
      <div class="col-12 col-xl-4 ">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">Patient</h6>
              </div>
          </div>
          <div class="card-body p-3">
            <ul class="list-group">
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nom & prenom:</strong> &nbsp; {{$resource->nom_prenom}} </li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp; {{$resource->telephone}}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; {{$resource->email}}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Adresse:</strong> &nbsp; {{$resource->adresse}}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Date de naissance:</strong> &nbsp; {{$resource->date_naissance}}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Sexe:</strong> &nbsp; {{$resource->sexe}}</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-xl-4">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">Parametre</h6>
              </div>
          </div>
          @foreach($params as $param)
          <div class="card-body p-3">
            <ul class="list-group">
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Poids:</strong> &nbsp; {{ $param->poids }} Kg</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Taille:</strong> &nbsp; {{ $param->taille }} m</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Temperature:</strong> &nbsp; {{ $param->temperature }} °c</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Pression arterielle:</strong> &nbsp; {{ $param->pression_arterielle }} mmHg</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Groupe sanguin:</strong> &nbsp; {{ \App\Models\ElementListe::libelle('groupes_sanguins', $param->groupe_sanguin) }}</li>
            </ul>
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-12 col-xl-4 ">
        <div class="card card-plain h-100">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-primary shadow-primary  border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">Antecedents</h6>
              </div>
          </div>
          @foreach($antecedents as $antecedent)
          <div class="card-body p-3">
            <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Type:</strong> &nbsp; {{ \App\Models\ElementListe::libelle('types_antecedent', $antecedent->type) }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Description:</strong> &nbsp; {{ $antecedent->description }}</li>
            </ul>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection