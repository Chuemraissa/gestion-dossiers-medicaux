@extends('layouts.app')
      
@section('title')
    @lang('messages.examens')
@endsection

@section('content')
<div class="container-fluid py-5">

  <ul class="nav nav-tabs" role="tablist">
    @if(auth()->user()?->aAcces('examens')) 
    <li class="nav-item"><a class="nav-link {{ request()->is('listestraitements') ? 'active': null }}" href="{{ url('listestraitements') }}" role="tab">@lang('messages.traitements')</a></li>
    @endif
    <li class="nav-item"><a class="nav-link {{ request()->is('listemedicaments') ? 'active': null }}" href="{{ url('listemedicaments') }}" role="tab">@lang('messages.medicaments')</a></li>
    @if(auth()->user()?->aAcces('medicaments')) 
    <li class="nav-item"><a class="nav-link {{ request()->is('listecategories') ? 'active': null }}" href="{{ url('listecategories') }}" role="tab">@lang('messages.categories')</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('listeposologies') ? 'active': null }}" href="{{ url('listeposologies') }}" role="tab">@lang('messages.posologies')</a></li>
    @endif
  </ul>
  
  <div class="tab-content">

    @if (request()->is('listestraitements'))
    <div class="tab-pane {{ request()->is('listestraitements') ? 'active': null }}" id="{{ url('listestraitements') }}" role="tabpanel">
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
          @if(auth()->user()?->aAcces('examens_gestion')) 
          <button type="button" data-toggle="modal" data-target="#myModal3" class="bg-primary bordure">
            <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter un résultat d\'examen') }}
          </button>
          @endif
          </div>
      </div>
      <!-- Modal pour ajouter un traitement -->
        <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal3" tabindex="-1" aria-labelledby="exampleModalLabel3">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">{{ __('Ajouter un résultat d\'examen') }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <!-- Formulaire de remplissage -->
                        <form action="/ajouter/traitement" method="POST">
                        @csrf
                      
                        @foreach ($errors->all() as $error)
                          <h5 class="alert alert-danger"> {{ $error }} </h5>
                        @endforeach

                    <div class="modal-body">
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
                            <label class="form-label" for="examen">{{ __('Type d\'examen') }}</label>
                            <select class="form-control" id="examen" name="type">
                            <option value="">{{ __('Sélectionnez un type') }}</option>
                            @foreach($examens as $examen)
                              <option value="{{ $examen->id }}">{{ \App\Models\ElementListe::libelle('types_examen', $examen->type) }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="resultat">{{ __('Résultat') }}</label>
                            <input type="text" class="form-control" id="resultat" name="resultat">
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
              @if(auth()->user()?->aAcces('voir_laborantin'))
              <th scope="col">{{ __('Laborantin') }}</th>
              @endif
              <th scope="col">{{ __('Type d\'examen') }}</th>
              <th scope="col">{{ __('Résultat') }}</th>
              <th scope="col">{{ __('Date') }}</th>
              @if(auth()->user()?->aAcces('examens_gestion')) 
              <th scope="col">{{ __('Action') }}</th>
              @endif
            </tr>
          </thead>
          <tbody>
          @foreach($effectuers as $effectuer)
          <tr class="table-row">
              <td>
                @foreach($patients as $patient)
                  @if($effectuer->patient_id == $patient->id)
                  {{ $patient->nom_prenom }}
                  @endif
                @endforeach
              </td>
              @if(auth()->user()?->aAcces('voir_laborantin'))
              <td>
                @foreach($laborantins as $laborantin)
                  @if($effectuer->laborantin_id == $laborantin->id)
                    {{ $laborantin->nom_prenom }}
                  @endif
                @endforeach
              </td>
              @endif
              <td>
                @foreach($examens as $examen)
                @if($effectuer->examen_id == $examen->id)
                  {{ \App\Models\ElementListe::libelle('types_examen', $examen->type) }}
                @endif
                @endforeach
              </td>
              <td>{{ $effectuer->resultat }}</td>
              <td>{{ $effectuer->created_at }}</td>
              @if(auth()->user()?->aAcces('examens_gestion')) 
              <td>
                <a href="/update-traitement/{{ $effectuer->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-traitement/{{ $effectuer->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
              @endif
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listemedicaments'))
    <div class="tab-pane {{ request()->is('listemedicaments') ? 'active': null }}" id="{{ url('listemedicaments') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="@lang('messages.recherche')"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2 justify-content-end">
          @if(auth()->user()?->aAcces('medicaments_gestion')) 
          <button type="button" data-toggle="modal" data-target="#myModal4" class="bg-primary bordure">
            <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter un médicament') }}
          </button>
          @endif
        </div>
      </div>
      <!-- Modal pour ajouter un medicament -->
        <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal4" tabindex="-1" aria-labelledby="exampleModalLabel4">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel4">{{ __('Ajouter un médicament') }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/ajouter/medicament" method="POST">
                      @csrf

                      @foreach ($errors->all() as $error)
                          <h5 class="alert alert-danger"> {{ $error }} </h5>
                      @endforeach

                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label" for="categorie">{{ __('Catégorie') }}</label>
                          <select class="form-control" id="categorie" name="categorie">
                          <option value="">{{ __('Sélectionnez une catégorie') }}</option>
                      @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                      @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="nom">{{ __('Nom') }}</label>
                          <input type="text" class="form-control" name="nom" id="nom">
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="quantite">{{ __('Quantité') }}</label>
                          <input type="number" min="1" class="form-control" name="quantite" id="quantite">
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="cout">{{ __('Coût') }}</label>
                          <input type="number" min="1" class="form-control" name="cout" id="cout">
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
              <th scope="col">{{ __('Catégorie') }}</th>
              <th scope="col">{{ __('Nom') }}</th>
              <th scope="col">{{ __('Quantité') }}</th>
              <th scope="col">{{ __('Coût') }}</th>
              @if(auth()->user()?->aAcces('medicaments_gestion')) 
              <th scope="col">{{ __('Action') }}</th>
              @endif
            </tr>
          </thead>   
          <tbody>
            @foreach ($medicaments as $medicament)
            <tr class="table-row">
              <td>{{ $medicament->categorie->nom }}</td>
              <td>{{ $medicament->nom }}</td>
              <td>{{ $medicament->quantite }}</td>
              <td>{{ $medicament->cout }}</td>
              @if(auth()->user()?->aAcces('medicaments_gestion')) 
              <td>
                <a href="/update-medicaments/{{ $medicament->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-medicaments/{{ $medicament->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
       </div>
    </div>
    @endif

    @if (request()->is('listecategories'))
    <div class="tab-pane {{ request()->is('listecategories') ? 'active': null }}" id="{{ url('listecategories') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="@lang('messages.recherche')"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2 justify-content-end">
          @if(auth()->user()?->aAcces('categories_gestion')) 
          <button type="button" data-toggle="modal" data-target="#myModal5" class="bg-primary bordure">
            <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter une catégorie') }}
          </button>
          @endif
        </div>
      </div>
      <!-- Modal pour ajouter une categorie -->
        <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal5" tabindex="-1" aria-labelledby="exampleModalLabel5">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel5">{{ __('Ajouter une catégorie') }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <!-- Formulaire de remplissage -->
                      <form action="/ajouter/categorie" method="POST">
                        @csrf
                      
                        @foreach ($errors->all() as $error)
                          <h5 class="alert alert-danger"> {{ $error }} </h5>
                        @endforeach
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="nom">{{ __('Nom') }}</label>
                            <input type="text" class="form-control" name="nom">
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
              <th scope="col">{{ __('Nom') }}</th>
              @if(auth()->user()?->aAcces('categories_gestion')) 
              <th scope="col">{{ __('Action') }}</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $categorie)
            <tr class="table-row">
              <td>{{ $categorie->nom }}</td>
              @if(auth()->user()?->aAcces('categories_gestion')) 
              <td>
                <a href="/update-categories/{{ $categorie->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-categories/{{ $categorie->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listeposologies'))
    <div class="tab-pane {{ request()->is('listeposologies') ? 'active': null }}" id="{{ url('listeposologies') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="@lang('messages.recherche')"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="bg-primary text-white sticky-top">
            <tr>
              <th scope="col">{{ __('Dose') }}</th>
              <th scope="col">{{ __('Fréquence') }}</th>
              <th scope="col">{{ __('Durée') }}</th>
              @if(auth()->user()?->aAcces('categories_gestion')) 
              <th scope="col">{{ __('Action') }}</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach ($posologies as $posologie)
            <tr>
              <td>{{ $posologie->dose }}</td>
              <td>{{ $posologie->frequence }}</td>
              <td>{{ $posologie->duree }}</td>
              @if(auth()->user()?->aAcces('categories_gestion')) 
              <td>
                <a href="/delete-posologies/{{ $posologie->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
              @endif
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