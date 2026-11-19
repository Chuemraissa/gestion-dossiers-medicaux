@extends('layouts.app')
      
@section('title')
    @lang('messages.modif')
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">modifier un utilisateur</div>
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
                        <label class="form-label" for="nom_prenom">Nom et prénom</label>
                        <input type="text" class="form-control" id="nom_prenom" value="{{ $resources->nom_prenom }}" name="nom_prenom">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="date_naissance">Date de naissance</label>
                        <input type="date" class="form-control" id="date_naissance" value="{{ $resources->date_naissance }}" name="date_naissance">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="adresse">Adresse</label>
                        <input type="text" class="form-control" id="adresse" value="{{ $resources->adresse }}" name="adresse">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="telephone">Numéro de téléphone</label>
                        <input type="tel" class="form-control" value="{{ $resources->telephone }}" name="telephone" pattern="[0-9]*" inputmode="numeric" id="telephone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="sexe">Sexe</label>
                        <select class="form-control" id="sexe" name="sexe">
                            <option value="{{ $resources->sexe }}">{{ $resources->sexe }}</option>
                            @if ($resources->sexe == 'feminin')
                            <option value="masculin">Masculin</option>
                            @else
                            <option value="feminin">Féminin</option>
                            @endif
                        </select>
                    </div>
                    </div>
                
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" value="{{ $resources->email }}" name="email" id="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Laisser vide pour garder le mot de passe actuel" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Confirmer Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                        @foreach($roles as $role)
                            <option value="{{ $role->code }}" @selected($role->code === $resources->role)>{{ $role->libelle }}</option>
                        @endforeach
                        </select>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    @if ($resources->estPatient())
                        <a href="/listespatients" class="btn btn-secondary">Annuler</a>
                    @else
                        <a href="/personnel/{{ $resources->role }}" class="btn btn-secondary">Annuler</a>
                    @endif

                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection