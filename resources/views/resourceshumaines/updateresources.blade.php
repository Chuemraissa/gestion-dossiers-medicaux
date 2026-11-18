@extends('layouts.app')
      
@section('title')
    update
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
                        <input type="password" class="form-control" value="{{ $resources->password }}" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Confirmer Password</label>
                        <input type="password" class="form-control" value="{{ $resources->password }}" name="password_confirmation" id="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                        <option value="{{ $resources->role }}">{{ $resources->role }}</option>
                        @if(session('role') == 'admin')
                        @if ($resources->role == 'medecin')
                        <option value="charge_acceuil">Chargé d'acceuil</option>
                        <option value="infirmiere">Infirmiere</option>
                        <option value="laborantin">Laborantin</option>
                        <option value="pharmacien">Pharmacien</option>
                        <option value="patient">Patient</option>
                            @endif
                            @if ($resources->role == 'charge_acceuil')
                        <option value="patient">Patient</option>
                        <option value="medecin">Medecin</option>
                        <option value="infirmiere">Infirmiere</option>
                        <option value="laborantin">Laborantin</option>
                        <option value="pharmacien">Pharmacien</option>
                            @endif
                            @if ($resources->role == 'infirmiere')
                        <option value="patient">Patient</option>
                        <option value="medecin">Medecin</option>
                        <option value="charge_acceuil">Chargé d'acceuil</option>
                        <option value="laborantin">Laborantin</option>
                        <option value="pharmacien">Pharmacien</option>
                            @endif
                            @if ($resources->role == 'laborantin')
                        <option value="patient">Patient</option>
                        <option value="medecin">Medecin</option>
                        <option value="pharmacien">Pharmacien</option>
                        <option value="charge_acceuil">Chargé d'acceuil</option>
                        <option value="infirmiere">Infirmiere</option>
                            @endif
                            @if ($resources->role == 'pharmacien')
                        <option value="patient">Patient</option>
                        <option value="medecin">Medecin</option>
                        <option value="laborantin">Laborantin</option>
                        <option value="charge_acceuil">Chargé d'acceuil</option>
                        <option value="infirmiere">Infirmiere</option>
                            @endif
                            @if ($resources->role == 'patient')
                        <option value="laborantin">Laborantin</option>
                        <option value="medecin">Medecin</option>
                        <option value="pharmacien">Pharmacien</option>
                        <option value="charge_acceuil">Chargé d'acceuil</option>
                        <option value="infirmiere">Infirmiere</option>
                            @endif
                            @endif
                        </select>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    @if ($resources->role === 'patient')
                        <a href="/listespatients" class="btn btn-secondary">Annuler</a>
                    @endif
                    @if ($resources->role === 'infirmiere')
                        <a href="/listeinfirmieres" class="btn btn-secondary">Annuler</a>
                    @endif
                    @if ($resources->role === 'medecin')
                        <a href="/listemedecins" class="btn btn-secondary">Annuler</a>
                    @endif
                    @if ($resources->role === 'charge_acceuil')
                        <a href="/listesCAs" class="btn btn-secondary">Annuler</a>
                    @endif
                    @if ($resources->role === 'laborantin')
                        <a href="/listelabos" class="btn btn-secondary">Annuler</a>
                    @endif
                    
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection