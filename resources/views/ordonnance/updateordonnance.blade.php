@extends('layouts.app')
      
@section('title')
    update
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">modifier une ordonnance</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">

            <!-- Formulaire de remplissage -->
            <form action="/update/ordonnances" method="POST">
            @csrf
            

            @foreach ($errors->all() as $error)
                <h5 class="alert alert-danger"> {{ $error }} </h5>
            @endforeach

            <input type="text" name="id" style="display: none;" value="{{ $ordonnancesAll->id }}">


        <div class="modal-body">
        <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label class="form-label" for="patient">Patient</label>
                <select class="form-control" id="patient" name="patient">
                    @foreach($patients as $patient)
                        @if($patient->id == $ordonnancesAll->patient_id)
                            <option value="{{ $patient->id }}" selected>{{ $patient->nom_prenom }}</option>
                        @else
                            <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea value="{{ $ordonnancesAll->description }}" name="description" class="form-control" id="">{{ $ordonnancesAll->description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="examen">Examen</label>
                <select class="form-control" id="examen" name="examen">
                <option value="{{ $ordonnancesAll->examen->id }}">{{ $ordonnancesAll->examen->type }}</option>
                @foreach($examens as $examen)
                @if ($ordonnancesAll->examen->type != $examen->type)
                <option value="{{ $examen->id }}">{{ $examen->type }}</option>
                @endif
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label class="form-label" for="medicament">Medicament</label>
                    @if($ordonnancesAll->medicament_id)
                <select class="form-control" id="medicament" name="medicament">
                <option value="{{ $ordonnancesAll->medicament->id }}">{{ $ordonnancesAll->medicament->nom }}</option>
                @foreach($medicaments as $medicament)
                @if ($ordonnancesAll->medicament->nom != $medicament->nom)
                <option value="{{ $medicament->id }}">{{ $medicament->nom }}</option>
                @endif
                @endforeach
                </select>
                    @else
                <select class="form-control" id="medicament" name="medicament">
                <option value="{{ $ordonnancesAll->medicament_id }}">Aucun</option>
                @foreach($medicaments as $medicament)
                <option value="{{ $medicament->id }}">{{ $medicament->nom }}</option>
                @endforeach
                </select>
                    @endif
            </div>
            <div class="mb-3">
                <label class="form-label" for="dose">Dose</label>
                <input type="number" min="1" class="form-control" value="{{ $posologiess->dose }}" name="dose">
            </div>
            <div class="mb-3">
                <label class="form-label" for="frequence">Fréquence</label>
                <input type="text" class="form-control" value="{{ $posologiess->frequence }}" name="frequence">
            </div>
            <div class="mb-3">
                <label class="form-label" for="dure">Durée</label>
                <input type="number" min="1" class="form-control" value="{{ $posologiess->duree }}" name="duree">
            </div>
        </div>
        </div>
        </div>
        <div class="modal-footer">
            <a href="/listesordonnances" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection