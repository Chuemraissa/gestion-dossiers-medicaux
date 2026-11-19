@extends('layouts.app')
      
@section('title')
    @lang('messages.ordonnance')
@endsection

@section('content')
<div class="container-fluid py-5">

  <ul class="nav nav-tabs" role="tablist">
    @if(auth()->user()?->aAcces('ordonnances'))
    <li class="nav-item"><a class="nav-link {{ request()->is('listesordonnances') ? 'active': null }}" href="{{ url('listesordonnances') }}" role="tab">@lang('messages.ordonnance')</a></li>
    @endif
    @if(auth()->user()?->aAcces('examens'))
    <li class="nav-item"><a class="nav-link {{ request()->is('listesexamens') ? 'active': null }}" href="{{ url('listesexamens') }}" role="tab">@lang('messages.examens')</a></li>
    @endif
    @if(auth()->user()?->aAcces('rendez_vous')) 
    <li class="nav-item"><a class="nav-link {{ request()->is('listesRDV') ? 'active': null }}" href="{{ url('listesRDV') }}" role="tab">@lang('messages.rendez-vous')</a></li>
    @endif
    </ul>

  <div class="tab-content">
    @if (request()->is('listesordonnances'))
    <div class="tab-pane {{ request()->is('listesordonnances') ? 'active': null }}" id="{{ url('listesordonnances') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-8">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" />
                    <label class="form-label ml-2" for="form1">{{ __('Rechercher') }}</label>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-4">
          @if(auth()->user()?->aAcces('prescription')) 
            <button type="button" data-toggle="modal" data-target="#myModal" class="bg-primary bordure">
                <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter une ordonnance') }}
            </button>
          @endif
        </div>
      </div>
      <!-- Modal pour ajouter une ordonnance -->
        <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Ajouter une ordonnance') }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                  <!-- Formulaire de remplissage -->
                  <form action="/ajouter/ordonnance" method="POST">
                    @csrf
                  

                  @foreach ($errors->all() as $error)
                      <h5 class="alert alert-danger"> {{ $error }} </h5>
                  @endforeach
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="patient">{{ __('Patient') }}</label>
                        <select class="form-control" id="patient" name="patient">
                          <option value="">{{ __('Sélectionnez un patient') }}</option>
                        @foreach($patients as $patient)
                          <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                        @endforeach
                        </select>
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="description">{{ __('Description') }}</label>
                          <textarea name="description" class="form-control" id=""></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="examen">{{ __('Examen') }}</label>
                        <select class="form-control" id="examen" name="examen">
                        <option value="">{{ __('Sélectionnez un examen') }}</option>
                        @foreach($examens as $examen)
                          <option value="{{ $examen->id }}">{{ \App\Models\ElementListe::libelle('types_examen', $examen->type) }}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="medicament">{{ __('Médicament') }}</label>
                        <select class="form-control" id="medicament" name="medicament">
                        <option value="">{{ __('Sélectionnez un médicament') }}</option>
                        @foreach($medicaments as $medicament)
                          <option value="{{ $medicament->id }}">{{ $medicament->nom }}</option>
                        @endforeach
                        </select>
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="dose">{{ __('Dose') }}</label>
                          <input type="number" min="1" class="form-control" name="dose">
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="frequence">{{ __('Fréquence') }}</label>
                          <input type="text" class="form-control" name="frequence">
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="dure">{{ __('Durée') }}</label>
                          <input type="number" min="1" class="form-control" name="duree">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Fermer') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                </div>
                    </form>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="bg-primary text-white sticky-top">
              <tr>
                <th scope="col">{{ __('Patient') }}</th>
                @if(auth()->user()?->aAcces('voir_medecin'))
                <th scope="col">{{ __('Médecin') }}</th>
                @endif
                <th scope="col">{{ __('Examen') }}</th>
                <th scope="col">{{ __('Médicament') }}</th>
                <th scope="col">{{ __('N° posologie') }}</th>
                <th scope="col">{{ __('Description') }}</th>
                @if(auth()->user()?->aAcces('prescription')) 
                <th scope="col">{{ __('Action') }}</th>
                @endif
                </tr>
            </thead>
            <tbody>
              @foreach($ordonnancesAll as $ordonnancesAl)
                <tr class="table-row">
                  <td>
                    @foreach($patients as $patient)
                      @if($ordonnancesAl->patient_id == $patient->id)
                        {{ $patient->nom_prenom }}
                      @endif
                    @endforeach
                  </td>
                  @if(auth()->user()?->aAcces('voir_medecin'))
                  <td>
                    @foreach($medecins as $medecin)
                      @if($ordonnancesAl->medecin_id == $medecin->id)
                        {{ $medecin->nom_prenom }}
                      @endif
                    @endforeach
                  </td>
                  @endif
                  <td>{{ \App\Models\ElementListe::libelle('types_examen', $ordonnancesAl->examen?->type) }}</td>
                  <td>{{ $ordonnancesAl->medicament_id == NULL?__('En attente'):$ordonnancesAl->medicament->nom }}</td>
                  <td>{{ $ordonnancesAl->posologie_id }}</td>
                  <td>{{ $ordonnancesAl->description }}</td>
                  @if(auth()->user()?->aAcces('prescription')) 
                  <td>
                      @if(auth()->user()?->aAcces('ordonnances')) 
                      <a href="/imprimer/{{ $ordonnancesAl->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-print"></i></a>
                        <a href="/update-ordonnances/{{ $ordonnancesAl->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                        <a href="/delete-ordonnances/{{ $ordonnancesAl->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
                        <a href="/certificat/{{ $ordonnancesAl->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;">{{ __('Certificat') }}</a>
                      @endif
                  </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
    @endif

    @if (request()->is('listesexamens'))
    <div class="tab-pane {{ request()->is('listesexamens') ? 'active': null }}" id="{{ url('listesexamens') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="@lang('messages.recherche')" />
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        @if(auth()->user()?->aAcces('examens_gestion')) 
        <div class="col-2 col-md-2 justify-content-end">
          <button type="button" data-toggle="modal" data-target="#myModal1" class="bg-primary bordure">
            <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter un examen') }}
          </button>
        </div>
        @endif
        </div>
        <!-- Modal pour ajouter un examen -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal1" tabindex="-1" aria-labelledby="exampleModalLabel1">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel1">{{ __('Ajouter un examen') }}</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                  </div>
                      <!-- Formulaire de remplissage -->
                      <form action="/ajouter/examen" method="POST">
                      @csrf
            
                      @foreach ($errors->all() as $error)
                        <h1 class="alert alert-danger"> {{ $error }} </h1>
                      @endforeach

                  <div class="modal-body">
                      <div class="mb-3">
                          <label class="form-label" for="type">{{ __('Type') }}</label>
                          <select class="form-control" id="type" name="type_examen">
                            <option value="">{{ __('Sélectionnez un type') }}</option>
                            <x-options-liste liste="types_examen" :selection="old('type_examen')" />
                          </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="description">{{ __('Description') }}</label>
                        <textarea class="form-control" name="description_examen" id="description"></textarea> 
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="cout">{{ __('Coût') }}</label>
                        <input type="number" class="form-control" name="cout" id="cout">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Fermer') }}</button>
                      <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                  </div>
                      </form>
              </div>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-primary text-white sticky-top">
            <tr>
              <th scope="col">{{ __('Type') }}</th>
              <th scope="col">{{ __('Description') }}</th>
              <th scope="col">{{ __('Coût') }}</th>
              @if(auth()->user()?->aAcces('examens_gestion')) 
              <th scope="col">{{ __('Action') }}</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($examens as $examen)
            <tr class="table-row">
              <td>{{ \App\Models\ElementListe::libelle('types_examen', $examen->type) }}</td>
              <td>{{ $examen->description }}</td>
              <td>{{ $examen->cout }}</td>
              @if(auth()->user()?->aAcces('examens_gestion')) 
              <td>
                <a href="/update-examens/{{ $examen->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-examens/{{ $examen->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listesRDV'))
    <div class="tab-pane {{ request()->is('listesRDV') ? 'active': null }}" id="{{ url('listesRDV') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="@lang('messages.recherche')" />
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2 justify-content-end">
          <button type="button" data-toggle="modal" data-target="#myModalRdv" class="bg-primary bordure">
            <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter un rendez-vous') }}
          </button>
        </div>
      </div>
      <!-- Modal pour ajouter une categorie -->
        <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalRdv" tabindex="-1" aria-labelledby="exampleModalLabelRdv">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelRdv">{{ __('Ajouter un rendez-vous') }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <!-- Formulaire de remplissage -->
                      <form action="/ajouter/RDV" method="POST">
                        @csrf
                      
                        @foreach ($errors->all() as $error)
                          <h5 class="alert alert-danger"> {{ $error }} </h5>
                        @endforeach
                    <div class="modal-body">
                      <div class="row">
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label class="form-label" for="patient">{{ __('Patient') }}</label>
                              <select class="form-control" id="patient" name="patient">
                              <option value="">{{ __('Sélectionnez un patient') }}</option>
                              @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                              @endforeach
                              </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="date">{{ __('Date') }}</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="heure">{{ __('Heure') }}</label>
                                <input type="time" class="form-control" name="heure">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="statut">{{ __('Statut') }}</label>
                                <select name="statut" id="statut" class="form-control">
                                  <option value="">{{ __('Sélectionnez un statut') }}</option>
                                  <x-options-liste liste="statuts_rdv" :selection="old('statut')" />
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="motif">{{ __('Motif') }}</label>
                                <input type="text" class="form-control" name="motif">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Fermer') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="bg-primary text-white sticky-top">
              <tr>
                <th scope="col">{{ __('Patient') }}</th>
                @if(auth()->user()?->aAcces('voir_medecin'))
                <th scope="col">{{ __('Médecin') }}</th>
                @endif
                <th scope="col">{{ __('Date') }}</th>
                <th scope="col">{{ __('Heure') }}</th>
                <th scope="col">{{ __('Statut') }}</th>
                <th scope="col">{{ __('Motif') }}</th>
                <th scope="col">{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rdvs as $rdv)
              <tr class="table-row">
                  <td>
                    @foreach($patients as $patient)
                      @if($rdv->patient_id == $patient->id)
                        {{ $patient->nom_prenom }}
                      @endif
                    @endforeach
                  </td>
                  @if(auth()->user()?->aAcces('voir_medecin'))
                  <td>
                    @foreach($medecins as $medecin)
                      @if($rdv->medecin_id == $medecin->id)
                        {{ $medecin->nom_prenom }}
                      @endif
                    @endforeach
                  </td>
                  @endif
                <td>{{ $rdv->date }}</td>
                <td>{{ $rdv->heure }}</td>
                <td>{{ \App\Models\ElementListe::libelle('statuts_rdv', $rdv->statut) }}</td>
                <td>{{ $rdv->motif }}</td>
                <td>
                  <a href="/update-RDV/{{ $rdv->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                  @if(auth()->user()?->aAcces('rendez_vous_suppression')) 
                  <a href="/delete-RDV/{{ $rdv->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
    @endif

  </div>
</div>
  @endsection