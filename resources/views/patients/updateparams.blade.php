@extends('layouts.app')
      
@section('title')
    update
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">modifier param</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">
            <form action="/update/param" method="POST">
              @csrf
             
              @foreach ($errors->all() as $error)
                <h1 class="alert alert-danger"> {{ $error }} </h1>
              @endforeach

            <input type="text" name="id" style="display: none;" value="{{ $params->id }}">

              <div class="modal-body">
                <div class="row">
                
                  <!-- Colonne 1 : Ajout de params -->
                  <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="patient">Patient</label>
                        <select class="form-control" id="patient" name="patient">
                            @foreach($resources as $resource)
                                @if($resource->id == $params->patient_id)
                                    <option value="{{ $resource->id }}" selected>{{ $resource->nom_prenom }}</option>
                                @elseif ($resource->role == 'patient')
                                    <option value="{{ $resource->id }}">{{ $resource->nom_prenom }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="poids">Poids</label>
                      <input type="text" class="form-control" value="{{ $params->poids }}" name="poids" id="poids">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="taille">Taille</label>
                      <input type="text" class="form-control" value="{{ $params->taille }}" name="taille" id="taille">
                    </div>
                  </div>
                
                  <!-- Colonne 1 : Ajout de patient -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="gs">GS</label>
                      <select class="form-control" name="groupe_sanguin" id="gs">
                        <option value="{{ $params->groupe_sanguin }}">{{ $params->groupe_sanguin }}</option>
                        @if ($params->groupe_sanguin == 'O')
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        @endif
                        @if ($params->groupe_sanguin == 'A')
                        <option value="O">O</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        @endif
                        @if ($params->groupe_sanguin == 'B')
                        <option value="O">O</option>
                        <option value="A">A</option>
                        <option value="AB">AB</option>
                        @endif
                        @if ($params->groupe_sanguin == 'AB')
                        <option value="O">O</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        @endif
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="temperature">Temperature</label>
                      <input type="text" class="form-control" value="{{ $params->temperature }}" name="temperature" id="temperature">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="pression">Pression arterielle</label>
                      <input type="text" class="form-control" value="{{ $params->pression_arterielle }}" name="pression_arterielle" id="pression">
                    </div>
                  </div>
                </div>
              <div class="modal-footer">
                    <a href="/listeparams" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Modifier</button>
              </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection