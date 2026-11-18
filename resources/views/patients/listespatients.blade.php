@extends('layouts.app')

@section('title')
    Listes Patients
@endsection

@section('content')
<div class="container-fluid py-5">

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item"><a class="nav-link {{ request()->is('listespatients') ? 'active': null }}" href="{{ url('listespatients') }}" role="tab">@lang('messages.patients')</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('listeparams') ? 'active': null }}" href="{{ url('listeparams') }}" role="tab">@lang('messages.parametre')</a></li>
    @if(auth()->user()?->aAcces('consultations')) 
    <li class="nav-item"><a class="nav-link {{ request()->is('listeantecedents') ? 'active': null }}" href="{{ url('listeantecedents') }}" role="tab">@lang('messages.antecedent')</a></li>
    @endif
  </ul>
  
  <div class="tab-content">
    @if (request()->is('listespatients'))
    <div class="tab-pane {{ request()->is('listespatients') ? 'active': null }}" id="{{ url('listespatients') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-md-8">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
          <button type="button" data-toggle="modal" data-target="#myModalca" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>@lang('messages.ajoutpatient')
          </button>
          <button type="button" class="bg-primary bordure">
              <a href="/imprimer" class="text-white"><i class="fas fa-print mr-2"></i>@lang('messages.imprimer')</a>
          </button>
        </div>
      </div>
          <h5 style="color:blue;">
            @if (session('status'))
              {{ session('status') }}
            @endif
          </h5>
      <!-- Modal pour ajouter un patient -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalca" tabindex="-1" aria-labelledby="exampleModalLabelca">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelca">@lang('messages.ajoutpatient')</h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
              </div>
            <form action="/ajouter/resources" method="POST">
              @csrf
             
              @foreach ($errors->all() as $error)
                <h1 class="alert alert-danger"> {{ $error }} </h1>
              @endforeach

              <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="nom_prenom">@lang('messages.nom')</label>
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">@lang('messages.datenaissance')</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">@lang('messages.adresse')</label>
                      <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">@lang('messages.tel')</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                  </div>
                
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="sexe">@lang('messages.sexe')</label>
                      <select class="form-control" id="sexe" name="sexe">
                        <option value="">@lang('messages.selectsexe')</option>
                        <option value="masculin">@lang('messages.masculin')</option>
                        <option value="feminin">@lang('messages.feminin')</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="email">@lang('messages.email')</label>
                      <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">@lang('messages.pswd')</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">@lang('messages.cp')</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password">
                    </div>
                    <div class="mb-3" style ="display: none;">
                      <label class="form-label" for="role">@lang('messages.role')</label>
                      <select class="form-control" id="role" name="role">
                        <option value="{{ \App\Models\Role::codePatient() }}">@lang('messages.patients')</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.fermer')</button>
                  <button type="submit" class="btn btn-primary">@lang('messages.enregistrer')</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-primary text-white sticky-top">
            <tr>
              <th scope="col">@lang('messages.nom')</th>
              <th scope="col">@lang('messages.datenaissance')</th>
              <th scope="col">@lang('messages.email')</th>
              <th scope="col">@lang('messages.sexe')</th>
              <th scope="col">@lang('messages.tel')</th>
              <th scope="col">@lang('messages.adresse')</th>
              <th scope="col">@lang('messages.action')</th>
            </tr>
          </thead>
          <tbody>
            @foreach($patients as $patient)
            <tr class="table-row">
              <td>{{ $patient->nom_prenom }}</td>
              <td>{{ $patient->date_naissance }}</td>
              <td>{{ $patient->email }}</td>
              <td>{{ $patient->sexe }}</td>
              <td>{{ $patient->telephone }}</td>
              <td>{{ $patient->adresse }}</td>
              <td>
                <a href="/show-patients/{{ $patient->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-eye"></i></a>
                <a href="/update-resources/{{ $patient->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-resources/{{ $patient->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listeparams'))
    <div class="tab-pane {{ request()->is('listeparams') ? 'active': null }}" id="{{ url('listeparams') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search" />
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalpa" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>@lang('messages.ajoutparam')
          </button>
        </div>
      </div>
          <h5 style="color:blue;">
            @if (session('status'))
              {{ session('status') }}
            @endif
          </h5>
      <!-- Modal pour ajouter un patient -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalpa" tabindex="-1" aria-labelledby="exampleModalLabelpa">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelpa">@lang('messages.ajoutparam')</h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
              </div>
            <form action="/ajouter/param" method="POST">
              @csrf
             
              @foreach ($errors->all() as $error)
                <h1 class="alert alert-danger"> {{ $error }} </h1>
              @endforeach

              <div class="modal-body">
                <div class="row">
                  <!-- Colonne 1 : Ajout de patient -->
                  <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="patient">@lang('messages.patients')</label>
                          <select class="form-control" id="patient" name="patient">
                          <option value="">@lang('messages.selectpatient')</option>
                          @foreach($resources as $resource)
                            <option value="{{ $resource->id }}">{{ $resource->nom_prenom }}</option>
                          @endforeach
                          </select>
                        </div>
                    <div class="mb-3">
                      <label class="form-label" for="poids">@lang('messages.poids')</label>
                      <input type="text" class="form-control" name="poids" id="poids">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="taille">@lang('messages.taille')</label>
                      <input type="text" class="form-control" name="taille" id="taille">
                    </div>
                  </div>
                
                  <!-- Colonne 1 : Ajout de patient -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="gs">GS</label>
                      <select class="form-control" name="groupe_sanguin" id="gs">
                        <option value="">@lang('messages.selectgs')</option>
                        <option value="O">O</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="temperature">@lang('messages.temp')</label>
                      <input type="text" class="form-control" name="temperature" id="temperature">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="pression">@lang('messages.pression')</label>
                      <input type="text" class="form-control" name="pression_arterielle" id="pression">
                    </div>
                    <div class="mb-3" style ="display: none;">
                      <label class="form-label" for="role">@lang('messages.role')</label>
                      <select class="form-control" id="role" name="role">
                        <option value="{{ \App\Models\Role::codePatient() }}">@lang('messages.patients')</option>
                      </select>
                    </div>
                  </div>
                </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.fermer')</button>
                  <button type="submit" class="btn btn-primary">@lang('messages.enregistrer')</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-primary text-white sticky-top">
            <tr>
              <th scope="col">@lang('messages.nom')</th>
              <th scope="col">@lang('messages.poids')</th>
              <th scope="col">@lang('messages.taille')</th>
              <th scope="col">@lang('messages.temp')</th>
              <th scope="col">@lang('messages.pression')</th>
              <th scope="col">@lang('messages.action')</th>
            </tr>
          </thead>
          <tbody>
            @foreach($params as $param)
            <tr class="table-row">
              <td>
                @foreach($resources as $resource)
                  @if($param->resource_id == $resource->id)
                    {{ $resource->nom_prenom }}
                  @endif
                @endforeach
              </td>
              <td>{{ $param->poids }}</td>
              <td>{{ $param->taille }}</td>
              <td>{{ $param->temperature }}</td>
              <td>{{ $param->pression_arterielle }}</td>
              <td>
                <a href="/update-params/{{ $param->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-params/{{ $param->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listeantecedents'))
    <div class="tab-pane {{ request()->is('listeantecedents') ? 'active': null }}" id="{{ url('listeantecedents') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search" />
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalant" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>@lang('messages.ajoutantecedent')
          </button>
        </div>
      </div>
          <h5 style="color:blue;">
            @if (session('status'))
              {{ session('status') }}
            @endif
          </h5>
      <!-- Modal pour ajouter un patient -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalant" tabindex="-1" aria-labelledby="exampleModalLabelant">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelant">@lang('messages.ajoutantecedent')</h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
              </div>
            <form action="/ajouter/antecedent" method="POST">
              @csrf
             
              @foreach ($errors->all() as $error)
                <h1 class="alert alert-danger"> {{ $error }} </h1>
              @endforeach

              <div class="modal-body">
                <div class="row">
                  <!-- Colonne 1 : Ajout de patient -->
                    <div class="mb-3">
                      <label class="form-label" for="patient">@lang('messages.patients')</label>
                      <select class="form-control" id="patient" name="patient">
                      <option value="">@lang('messages.selectpatient')</option>
                      @foreach($resources as $resource)
                        <option value="{{ $resource->id }}">{{ $resource->nom_prenom }}</option>
                      @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="type">@lang('messages.type')</label>
                      <select class="form-control" name="type_antecedent" id="type">
                        <option value="">@lang('messages.selectantecedent')</option>
                        <option value="medicaux">@lang('messages.medicaux')</option>
                        <option value="chirurgicaux">@lang('messages.chirurgie')</option>
                        <option value="familiaux">@lang('messages.familiaux')</option>
                        <option value="autres">@lang('messages.autres')</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="description">@lang('messages.description')</label>
                      <textarea class="form-control" name="description_antecedent" id="description"></textarea>
                    </div>
                </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.fermer')</button>
                  <button type="submit" class="btn btn-primary">@lang('messages.enregistrer')</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-primary text-white sticky-top">
            <tr>
              <th scope="col">@lang('messages.nom')</th>
              <th scope="col">@lang('messages.type')</th>
              <th scope="col">@lang('messages.description')</th>
              <th scope="col">@lang('messages.action')</th>
            </tr>
          </thead>
          <tbody>
            @foreach($antecedents as $antecedent)
            <tr class="table-row">
              <td>
                @foreach($resources as $resource)
                  @if($antecedent->resource_id == $resource->id)
                    {{ $resource->nom_prenom }}
                  @endif
                @endforeach
              </td>
              <td>{{ $antecedent->type }}</td>
              <td>{{ $antecedent->description }}</td>
              <td>
                <a href="/update-antecedents/{{ $antecedent->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-antecedents/{{ $antecedent->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
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