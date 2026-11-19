@extends('layouts.app')
      
@section('title')
    @lang('messages.modif')
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">{{ __('Modifier un utilisateur') }}</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">
            <form action="/update/resources" method="POST">
                @csrf

                @foreach ($errors->all() as $error)
                    <h1 class="alert alert-danger"> {{ $error }} </h1>
                @endforeach

                <input type="text" name="id" style="display: none;" value="{{ $resources->id }}">

                <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="nom_prenom">{{ __('Nom et prénom') }}</label>
                        <input type="text" class="form-control" id="nom_prenom" value="{{ $resources->nom_prenom }}" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="date_naissance">{{ __('Date de naissance') }}</label>
                        <input type="date" class="form-control" id="date_naissance" value="{{ $resources->date_naissance }}" name="date_naissance">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="adresse">{{ __('Adresse') }}</label>
                        <input type="text" class="form-control" id="adresse" value="{{ $resources->adresse }}" name="adresse">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="telephone">{{ __('Numéro de téléphone') }}</label>
                        <input type="tel" class="form-control" value="{{ $resources->telephone }}" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="sexe">{{ __('Sexe') }}</label>
                        <select class="form-control" id="sexe" name="sexe">
                            <option value="masculin" @selected($resources->sexe === 'masculin')>{{ __('Masculin') }}</option>
                            <option value="feminin" @selected($resources->sexe === 'feminin')>{{ __('Féminin') }}</option>
                        </select>
                    </div>
                    </div>
                
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="email">{{ __('E-mail') }}</label>
                        <input type="email" class="form-control" value="{{ $resources->email }}" name="email" id="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">{{ __('Mot de passe') }}</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('Laisser vide pour garder le mot de passe actuel') }}" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">{{ __('Confirmer le mot de passe') }}</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="role">{{ __('Rôle') }}</label>
                        <select class="form-control" id="role" name="role">
                        @foreach($roles as $role)
                            <option value="{{ $role->code }}" @selected($role->code === $resources->role)>{{ __($role->libelle) }}</option>
                        @endforeach
                        </select>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    @if ($resources->estPatient())
                        <a href="/listespatients" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    @else
                        <a href="/personnel/{{ $resources->role }}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    @endif

                    <button type="submit" class="btn btn-primary">{{ __('Modifier') }}</button>
                </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection