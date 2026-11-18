@extends('layouts.app')
      
@section('title')
    Listes Resources
@endsection

@section('content')
<div class="container-fluid py-5">

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item"><a class="nav-link {{ request()->is('listesCAs') ? 'active': null }}" href="{{ url('listesCAs') }}" role="tab">Chargé d'accueil</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('listeinfirmieres') ? 'active': null }}" href="{{ url('listeinfirmieres') }}" role="tab">Infirmiere</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('listepharmaciens') ? 'active': null }}" href="{{ url('listepharmaciens') }}" role="tab">Pharmacien</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('listelabos') ? 'active': null }}" href="{{ url('listelabos') }}" role="tab">Laborantin</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('listemedecins') ? 'active': null }}" href="{{ url('listemedecins') }}" role="tab">Medecin</a></li>
  </ul>
  
  <div class="tab-content">

    @if (request()->is('listesCAs'))
    <div class="tab-pane {{ request()->is('listesCAs') ? 'active': null }}" id="{{ url('listesCAs') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalca" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>Ajouter un chargé d'acceuil
          </button>
        </div>
      </div>
          <h5 style="color:blue;">
            @if (session('status'))
              {{ session('status') }}
            @endif
          </h5>
      <!-- Modal pour ajouter un chargé d'acceuil -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalca" tabindex="-1" aria-labelledby="exampleModalLabelca">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelca">Ajouter un chargé d'acceuil</h5>
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
                      <label class="form-label" for="nom_prenom">Nom et prénom</label>
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">Date de naissance</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">Numéro de téléphone</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                  </div>
                
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="sexe">Sexe</label>
                      <select class="form-control" id="sexe" name="sexe">
                        <option value="">Sélectionnez le sexe</option>
                        <option value="masculin">Masculin</option>
                        <option value="feminin">Féminin</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Confirmer Password</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password">
                    </div>
                    <div class="mb-3" style ="display: none;">
                      <label class="form-label" for="role">Role</label>
                      <select class="form-control" id="role" name="role">
                        <option value="charge_acceuil">Chargé d'acceuil</option>
                      </select>
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
              <th scope="col">Nom & Prénom</th>
              <th scope="col">Date de naissance</th>
              <th scope="col">Email</th>
              <th scope="col">Sexe</th>
              <th scope="col">N°-Telephone</th>
              <th scope="col">Adresse</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resources as $resource)
            @if ($resource->role == 'charge_acceuil')
            <tr class="table-row">
              <td>{{ $resource->nom_prenom }}</td>
              <td>{{ $resource->date_naissance }}</td>
              <td>{{ $resource->email }}</td>
              <td>{{ $resource->sexe }}</td>
              <td>{{ $resource->telephone }}</td>
              <td>{{ $resource->adresse }}</td>
              <td>
                <a href="/update-resources/{{ $resource->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-resources/{{ $resource->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listeinfirmieres'))
    <div class="tab-pane {{ request()->is('listeinfirmieres') ? 'active': null }}" id="{{ url('listeinfirmieres') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">                
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalinf" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>Ajouter une infirmiere
          </button>
        </div>
      </div>
      <!-- Modal pour ajouter une infirmiere -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalinf" tabindex="-1" aria-labelledby="exampleModalLabelinf">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelinf">Ajouter une infirmiere</h5>
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
                      <label class="form-label" for="nom_prenom">Nom et prénom</label>
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">Date de naissance</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">Numéro de téléphone</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                  </div>
                
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="sexe">Sexe</label>
                      <select class="form-control" id="sexe" name="sexe">
                        <option value="">Sélectionnez le sexe</option>
                        <option value="masculin">Masculin</option>
                        <option value="feminin">Féminin</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Confirmer Password</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password">
                    </div>
                    <div class="mb-3" style ="display: none;">
                      <label class="form-label" for="role">Role</label>
                      <select class="form-control" id="role" name="role">
                        <option value="infirmiere">Infirmiere</option>
                      </select>
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
              <th scope="col">Nom & Prénom</th>
              <th scope="col">Date de naissance</th>
              <th scope="col">Email</th>
              <th scope="col">Sexe</th>
              <th scope="col">N°-Telephone</th>
              <th scope="col">Adresse</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resources as $resource)
            @if ($resource->role == 'infirmiere')
            <tr class="table-row">
              <td>{{ $resource->nom_prenom }}</td>
              <td>{{ $resource->date_naissance }}</td>
              <td>{{ $resource->email }}</td>
              <td>{{ $resource->sexe }}</td>
              <td>{{ $resource->telephone }}</td>
              <td>{{ $resource->adresse }}</td>
              <td>
                <a href="/update-resources/{{ $resource->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-resources/{{ $resource->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listepharmaciens'))
    <div class="tab-pane {{ request()->is('listepharmaciens') ? 'active': null }}" id="{{ url('listepharmaciens') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">                
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalphar" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>Ajouter un pharmacien
          </button>
        </div>
      </div>
      <!-- Modal pour ajouter un pharmacien -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalphar" tabindex="-1" aria-labelledby="exampleModalLabelphar">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelphar">Ajouter un pharmacien</h5>
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
                      <label class="form-label" for="nom_prenom">Nom et prénom</label>
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">Date de naissance</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">Numéro de téléphone</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                  </div>
                
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="sexe">Sexe</label>
                      <select class="form-control" id="sexe" name="sexe">
                        <option value="">Sélectionnez le sexe</option>
                        <option value="masculin">Masculin</option>
                        <option value="feminin">Féminin</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Confirmer Password</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password">
                    </div>
                    <div class="mb-3" style ="display: none;">
                      <label class="form-label" for="role">Role</label>
                      <select class="form-control" id="role" name="role">
                        <option value="pharmacien">Pharmacien</option>
                      </select>
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
              <th scope="col">Nom & Prénom</th>
              <th scope="col">Date de naissance</th>
              <th scope="col">Email</th>
              <th scope="col">Sexe</th>
              <th scope="col">N°-Telephone</th>
              <th scope="col">Adresse</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resources as $resource)
            @if ($resource->role == 'pharmacien')
            <tr class="table-row">
              <td>{{ $resource->nom_prenom }}</td>
              <td>{{ $resource->date_naissance }}</td>
              <td>{{ $resource->email }}</td>
              <td>{{ $resource->sexe }}</td>
              <td>{{ $resource->telephone }}</td>
              <td>{{ $resource->adresse }}</td>
              <td>
                <a href="/update-resources/{{ $resource->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-resources/{{ $resource->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listelabos'))
    <div class="tab-pane {{ request()->is('listelabos') ? 'active': null }}" id="{{ url('listelabos') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">                    
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalLab" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>Ajouter un laborantin
          </button>
        </div>
      </div>
      <!-- Modal pour ajouter un laborantin -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalLab" tabindex="-1" aria-labelledby="exampleModalLabelLab">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLab">Ajouter un laborantin</h5>
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
                      <label class="form-label" for="nom_prenom">Nom et prénom</label>
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">Date de naissance</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">Numéro de téléphone</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                  </div>
                
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="sexe">Sexe</label>
                      <select class="form-control" id="sexe" name="sexe">
                        <option value="">Sélectionnez le sexe</option>
                        <option value="masculin">Masculin</option>
                        <option value="feminin">Féminin</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Confirmer Password</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password">
                    </div>
                    <div class="mb-3" style ="display: none;">
                      <label class="form-label" for="role">Role</label>
                      <select class="form-control" id="role" name="role">
                        <option value="laborantin">Laborantin</option>
                      </select>
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
              <th scope="col">Nom & Prénom</th>
              <th scope="col">Date de naissance</th>
              <th scope="col">Email</th>
              <th scope="col">Sexe</th>
              <th scope="col">N°-Telephone</th>
              <th scope="col">Adresse</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resources as $resource)
            @if ($resource->role == 'laborantin')
            <tr class="table-row">
              <td>{{ $resource->nom_prenom }}</td>
              <td>{{ $resource->date_naissance }}</td>
              <td>{{ $resource->email }}</td>
              <td>{{ $resource->sexe }}</td>
              <td>{{ $resource->telephone }}</td>
              <td>{{ $resource->adresse }}</td>
              <td>
                <a href="/update-resources/{{ $resource->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-resources/{{ $resource->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if (request()->is('listemedecins'))
    <div class="tab-pane {{ request()->is('listemedecins') ? 'active': null }}" id="{{ url('listemedecins') }}" role="tabpanel">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">                   
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="search"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalMed" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>Ajouter un Medecin
          </button>
        </div>
      </div>
      <!-- Modal pour ajouter un Medecin -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalMed" tabindex="-1" aria-labelledby="exampleModalLabelMed">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelMed">Ajouter un Medecin</h5>
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
                      <label class="form-label" for="nom_prenom">Nom et prénom</label>
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">Date de naissance</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">Numéro de téléphone</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                  </div>
                
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="sexe">Sexe</label>
                      <select class="form-control" id="sexe" name="sexe">
                        <option value="">Sélectionnez le sexe</option>
                        <option value="masculin">Masculin</option>
                        <option value="feminin">Féminin</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Confirmer Password</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password">
                    </div>
                    <div class="mb-3" style ="display: none;">
                      <label class="form-label" for="role">Role</label>
                      <select class="form-control" id="role" name="role">
                        <option value="medecin">Medecin</option>
                      </select>
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
              <th scope="col">Nom & Prénom</th>
              <th scope="col">Date de naissance</th>
              <th scope="col">Email</th>
              <th scope="col">Sexe</th>
              <th scope="col">N°-Telephone</th>
              <th scope="col">Adresse</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resources as $resource)
            @if ($resource->role == 'medecin')
            <tr class="table-row">
              <td>{{ $resource->nom_prenom }}</td>
              <td>{{ $resource->date_naissance }}</td>
              <td>{{ $resource->email }}</td>
              <td>{{ $resource->sexe }}</td>
              <td>{{ $resource->telephone }}</td>
              <td>{{ $resource->adresse }}</td>
              <td>
                <a href="/update-resources/{{ $resource->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                <a href="/delete-resources/{{ $resource->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

  </div>

</div>
  @endsection