@extends('layouts.app')

@section('title')
    @lang('messages.resources')
@endsection

@section('content')
<div class="container-fluid py-5">

  {{-- Un onglet par rôle du personnel (les rôles viennent de la table "roles") --}}
  <ul class="nav nav-tabs" role="tablist">
    @foreach($roles as $role)
    <li class="nav-item">
      <a class="nav-link {{ $roleActif && $roleActif->code === $role->code ? 'active' : null }}" href="{{ route('personnel', $role->code) }}" role="tab">{{ __($role->libelle) }}</a>
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
                    <input type="search" id="form1" class="form-control" placeholder="@lang('messages.recherche')"/>
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModalPersonnel" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter') }} : {{ __($roleActif->libelle) }}
          </button>
        </div>
      </div>

      <!-- Modal pour ajouter un membre du personnel -->
      <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalPersonnel" aria-labelledby="titreModalPersonnel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title" id="titreModalPersonnel">{{ __('Ajouter') }} : {{ __($roleActif->libelle) }}</h5>
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
                      <label class="form-label" for="nom_prenom">{{ __('Nom et prénom') }}</label>
                      <input type="text" class="form-control" id="nom_prenom" name="nom_prenom" value="{{ old('nom_prenom') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="date_naissance">{{ __('Date de naissance') }}</label>
                      <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="adresse">{{ __('Adresse') }}</label>
                      <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="telephone">{{ __('Numéro de téléphone') }}</label>
                      <input type="tel" class="form-control" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone" value="{{ old('telephone') }}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="sexe">{{ __('Sexe') }}</label>
                      <select class="form-control" id="sexe" name="sexe">
                        <option value="">{{ __('Sélectionnez le sexe') }}</option>
                        <option value="masculin">{{ __('Masculin') }}</option>
                        <option value="feminin">{{ __('Féminin') }}</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="email">{{ __('E-mail') }}</label>
                      <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">{{ __('Mot de passe') }}</label>
                      <input type="password" class="form-control" name="password" id="password" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password_confirmation">{{ __('Confirmer le mot de passe') }}</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                    </div>
                    <input type="hidden" name="role" value="{{ $roleActif->code }}">
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
              <th scope="col">{{ __('Nom et prénom') }}</th>
              <th scope="col">{{ __('Date de naissance') }}</th>
              <th scope="col">{{ __('E-mail') }}</th>
              <th scope="col">{{ __('Sexe') }}</th>
              <th scope="col">{{ __('Téléphone') }}</th>
              <th scope="col">{{ __('Adresse') }}</th>
              <th scope="col">{{ __('Action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resources as $resource)
            <tr class="table-row">
              <td>{{ $resource->nom_prenom }}</td>
              <td>{{ $resource->date_naissance }}</td>
              <td>{{ $resource->email }}</td>
              <td>{{ in_array($resource->sexe, ['masculin', 'feminin']) ? __('messages.'.$resource->sexe) : $resource->sexe }}</td>
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
      <p>{{ __('Aucun rôle du personnel n\'est enregistré. Lancez « php artisan db:seed ».') }}</p>
    @endif
  </div>
</div>
@endsection
