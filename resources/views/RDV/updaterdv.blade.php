@extends('layouts.app')
      
@section('title')
    @lang('messages.modif')
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">{{ __('Modifier un rendez-vous') }}</div>
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
                        <label class="form-label" for="patient">{{ __('Patient') }}</label>
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
                        <label class="form-label" for="date">{{ __('Date') }}</label>
                        <input type="date" class="form-control" value="{{ $rdv->date }}" name="date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="heure">{{ __('Heure') }}</label>
                        <input type="time" class="form-control" value="{{ $rdv->heure }}" name="heure">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="statut">{{ __('Statut') }}</label>
                        <select name="statut" id="statut" class="form-control">
                            <x-options-liste liste="statuts_rdv" :selection="$rdv->statut" />
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="motif">{{ __('Motif') }}</label>
                        <input type="text" class="form-control" value="{{ $rdv->motif }}" name="motif">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="/listesRDV" class="btn btn-secondary">{{ __('Annuler') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('Modifier') }}</button>
        </div>
        </form>
        </div>
    </div>
  </div>

</div>
  @endsection