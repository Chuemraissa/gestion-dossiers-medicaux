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
                    <label class="form-label ml-2" for="form1">Search</label>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-4">
          @if(auth()->user()?->aAcces('prescription')) 
            <button type="button" data-toggle="modal" data-target="#myModal" class="bg-primary bordure">
                <i class="fas fa-user-plus mr-2"></i>Ajouter une ordonnances
            </button>
          @endif
        </div>
      </div>
      <!-- Modal pour ajouter une ordonnance -->
        <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une ordonnance</h5>
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
                        <label class="form-label" for="patient">Patient</label>
                        <select class="form-control" id="patient" name="patient">
                          <option value="">Selectionnez un patient</option>
                        @foreach($patients as $patient)
                          <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                        @endforeach
                        </select>
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="description">Description</label>
                          <textarea name="description" class="form-control" id=""></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="examen">Examen</label>
                        <select class="form-control" id="examen" name="examen">
                        <option value="">Selectionnez un examen</option>
                        @foreach($examens as $examen)
                          <option value="{{ $examen->id }}">{{ \App\Models\ElementListe::libelle('types_examen', $examen->type) }}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="medicament">Medicament</label>
                        <select class="form-control" id="medicament" name="medicament">
                        <option value="">Selectionnez un medicament</option>
                        @foreach($medicaments as $medicament)
                          <option value="{{ $medicament->id }}">{{ $medicament->nom }}</option>
                        @endforeach
                        </select>
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="dose">Dose</label>
                          <input type="number" min="1" class="form-control" name="dose">
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="frequence">Fréquence</label>
                          <input type="text" class="form-control" name="frequence">
                      </div>
                      <div class="mb-3">
                          <label class="form-label" for="dure">Durée</label>
                          <input type="number" min="1" class="form-control" name="duree">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
                    </form>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="bg-primary text-white sticky-top">
              <tr>
                <th scope="col">NomPatient</th>
                @if(auth()->user()?->aAcces('voir_medecin'))
                <th scope="col">NomMedecin</th>
                @endif
                <th scope="col">Examen</th>
                <th scope="col">NomMedicament</th>
                <th scope="col">IdPosologie</th>
                <th scope="col">Description</th>
                @if(auth()->user()?->aAcces('prescription')) 
                <th scope="col">Action</th>
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
                  <td>{{ $ordonnancesAl->examen->type }}</td>
                  <td>{{ $ordonnancesAl->medicament_id == NULL?'En_attente':$ordonnancesAl->medicament->nom }}</td>
                  <td>{{ $ordonnancesAl->posologie_id }}</td>
                  <td>{{ $ordonnancesAl->description }}</td>
                  @if(auth()->user()?->aAcces('prescription')) 
                  <td>
                      @if(auth()->user()?->aAcces('ordonnances')) 
                      <a href="/imprimer/{{ $ordonnancesAl->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-print"></i></a>
                        <a href="/update-ordonnances/{{ $ordonnancesAl->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                        <a href="/delete-ordonnances/{{ $ordonnancesAl->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
                        <a href="/certificat/{{ $ordonnancesAl->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;">certificat</a>
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
            <i class="fas fa-user-plus mr-2"></i>Ajouter un examen
          </button>
        </div>
        @endif
        </div>
        <!-- Modal pour ajouter un examen -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal1" tabindex="-1" aria-labelledby="exampleModalLabel1">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel1">Ajouter un examen</h5>
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
                          <label class="form-label" for="type">Type</label>
                          <select class="form-control" id="type" name="type_examen">
                            <option value="">Sélectionnez le type</option>
                            <x-options-liste liste="types_examen" :selection="old('type_examen')" />
                          </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" name="description_examen" id="description"></textarea> 
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="cout">Coût</label>
                        <input type="number" class="form-control" name="cout" id="cout">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                      <button type="submit" class="btn btn-primary">Enregistrer</button>
                  </div>
                      </form>
              </div>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-primary text-white sticky-top">
            <tr>
              <th scope="col">Type</th>
              <th scope="col">Description</th>
              <th scope="col">Cout</th>
              @if(auth()->user()?->aAcces('examens_gestion')) 
              <th scope="col">Action</th>
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
            <i class="fas fa-user-plus mr-2"></i>Ajouter un Rendez-vous
          </button>
        </div>
      </div>
      <!-- Modal pour ajouter une categorie -->
        <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalRdv" tabindex="-1" aria-labelledby="exampleModalLabelRdv">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelRdv">Ajouter un Rendez-vous</h5>
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
                              <label class="form-label" for="patient">Patient</label>
                              <select class="form-control" id="patient" name="patient">
                              <option value="">Selectionner un patient</option>
                              @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                              @endforeach
                              </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="date">Date</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="heure">Heure</label>
                                <input type="time" class="form-control" name="heure">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="statut">Statut</label>
                                <select name="statut" id="statut" class="form-control">
                                  <option value="">Selectionner un statut</option>
                                  <x-options-liste liste="statuts_rdv" :selection="old('statut')" />
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="motif">Motif</label>
                                <input type="text" class="form-control" name="motif">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="bg-primary text-white sticky-top">
              <tr>
                <th scope="col">NomPatient</th>
                @if(auth()->user()?->aAcces('voir_medecin'))
                <th scope="col">NomMedecin</th>
                @endif
                <th scope="col">Date</th>
                <th scope="col">Heure</th>
                <th scope="col">Statut</th>
                <th scope="col">Motif</th>
                <th scope="col">Action</th>
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