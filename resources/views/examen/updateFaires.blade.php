@extends('layouts.app')
      
      @section('title')
          update
      @endsection
      
      @section('content')
      <div class="container-fluid py-5">
      
        <div class="tabs">
          <div class="tab-item active">modifier un traitement</div>
        </div>
        <div class="tab-content">
          <div class="tab-pane active">
              <div class="modal-content">
                        <!-- Formulaire de remplissage -->
                        <form action="/update/traitement" method="POST">
                        @csrf
                      
                        @foreach ($errors->all() as $error)
                          <h5 class="alert alert-danger"> {{ $error }} </h5>
                        @endforeach

                <input type="text" name="id" style="display: none;" value="{{ $effectuers->id }}">

                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-3">
                              <label class="form-label" for="patient">NomPatient</label>
                              <select class="form-control" id="patient" name="patient">
                                @foreach($patients as $patient)
                                    @if($patient->id == $effectuers->patient_id)
                                        <option value="{{ $patient->id }}" selected>{{ $patient->nom_prenom }}</option>
                                    @else
                                        <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                                    @endif
                                @endforeach
                              </select>
                          </div>
                          <div class="mb-3">
                              <label class="form-label" for="examen">TypeExamen</label>
                              <select class="form-control" id="examen" name="type">
                              @foreach($examens as $examen)
                              @if($effectuers->examen_id == $examen->id)
                              <option value="{{ $examen->id }}">{{ $examen->type }}</option>
                              @endif
                              @if($effectuers->examen_id != $examen->id)
                              <option value="{{ $examen->id }}">{{ $examen->type }}</option>
                              @endif
                              @endforeach
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label" for="resultat">Resultat</label>
                            <input type="text" class="form-control" value="{{ $effectuers->resultat }}" id="resultat" name="resultat">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <a href="/listestraitements" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                        </form>
              </div>
          </div>
        </div>
      
      </div>
        @endsection