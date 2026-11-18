@extends('layouts.app')
      
@section('title')
    update
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">modifier un Rendez_vous</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">            
            <!-- Formulaire de remplissage -->
            <form action="/update/RDV" method="POST">
            @csrf
            
            @foreach ($errors->all() as $error)
                <h5 class="alert alert-danger"> {{ $error }} </h5>
            @endforeach

            <input type="text" name="id" style="display: none;" value="{{ $rdv->id }}">

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="patient">Patient</label>
                        <select class="form-control" id="patient" name="patient">
                            @foreach($patients as $patient)
                                @if($patient->id == $rdv->patient_id)
                                    <option value="{{ $patient->id }}" selected>{{ $patient->nom_prenom }}</option>
                                @else
                                    <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="date">Date</label>
                        <input type="date" class="form-control" value="{{ $rdv->date }}" name="date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="heure">Heure</label>
                        <input type="time" class="form-control" value="{{ $rdv->heure }}" name="heure">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="statut">Statut</label>
                        <select name="statut" id="statut" class="form-control">
                            <option value="{{ $rdv->statut }}">{{ $rdv->statut }}</option>
                            @if ($rdv->statut == 'confirme')
                            <option value="annule">Annulé</option>
                            <option value="en_attente">En attente</option>
                            <option value="traite">Traité</option>
                            @endif
                            @if ($rdv->statut == 'annule')
                            <option value="confirme">Confirmé</option>
                            <option value="en_attente">En attente</option>
                            <option value="traite">Traité</option>
                            @endif
                            @if ($rdv->statut == 'en_attente')
                            <option value="confirme">Confirmé</option>
                            <option value="annule">Annulé</option>
                            <option value="traite">Traité</option>
                            @endif
                            @if ($rdv->statut == 'traite')
                            <option value="confirme">Confirmé</option>
                            <option value="annule">Annulé</option>
                            <option value="en_attente">En attente</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="motif">Motif</label>
                        <input type="text" class="form-control" value="{{ $rdv->motif }}" name="motif">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="/listesRDV" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
        </form>
        </div>
    </div>
  </div>

</div>
  @endsection