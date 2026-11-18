@extends('layouts.app')

@section('title')
    Listes Resources
@endsection

@section('content')
<div class="container-fluid py-5">

  {{-- Un onglet par rôle du personnel (les rôles viennent de la table "roles") --}}
  <ul class="nav nav-tabs" role="tablist">
    @foreach($roles as $role)
    <li class="nav-item">
      <a class="nav-link {{ $roleActif && $roleActif->code === $role->code ? 'active' : null }}" href="{{ route('personnel', $role->code) }}" role="tab">{{ $role->libelle }}</a>
    </li>
    @endforeach
  </ul>

  <div class="tab-content">
    @if ($roleActif)
    <div class="tab-pane active" role="tabpanel">
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
          <button type="button" data-toggle="modal" data-target="#myModalPersonnel" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>Ajouter : {{ $roleActif->libelle }}
          </button>
        </div>
      </div>
          <h5 style="color:blue;">
            @if (session('status'))
              {{ session('status') }}
            @endif
          </h5>

      <!-- Modal pour ajouter un membre du personnel -->
      <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalPersonnel" aria-labelledby="titreModalPersonnel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title" id="titreModalPersonnel">Ajouter : {{ $roleActif->libelle }}</h5>
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
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom" value="{{ old('nom_prenom') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">Date de naissance</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">Numéro de téléphone</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone" value="{{ old('telephone') }}">
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
                      <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password_confirmation">Confirmer Password</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                    </div>
                    <input type="hidden" name="role" value="{{ $roleActif->code }}">
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
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @else
      <p>Aucun rôle du personnel n'est enregistré. Lancez « php artisan db:seed ».</p>
    @endif
  </div>
</div>
@endsection
