@extends('layouts.app')
      
@section('title')
    update
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">modifier une consultation</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">
            <!-- Formulaire de remplissage -->
            <form action="/update/consultations" method="POST">
            @csrf
            
            @foreach ($errors->all() as $error)
                <h5 class="alert alert-danger"> {{ $error }} </h5>
            @endforeach

            <input type="text" name="id" style="display: none;" value="{{ $consulters->id }}">

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="patient">Patient</label>
                <select class="form-control" id="patient" name="patient">
                    @foreach($patients as $patient)
                        @if($patient->id == $consulters->patient_id)
                            <option value="{{ $patient->id }}" selected>{{ $patient->nom_prenom }}</option>
                        @else
                            <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="motif">Motif</label>
                <textarea class="form-control" id="motif" name="motif">{{ $consulters->motif }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="cout">Coût</label>
                <select class="form-control"  id="cout" name="cout">
                    <option value="{{ $consulters->cout }}">{{ $consulters->cout }}</option>
                    @if ($consulters->cout == '1000')
                    <option value="1500">1500</option>
                    <option value="2000">2000</option>
                    <option value="2500">2500</option>
                    <option value="3000">3000</option>
                    <option value="3500">3500</option>
                    @endif
                    @if ($consulters->cout == '1500')
                    <option value="1000">1000</option>
                    <option value="2000">2000</option>
                    <option value="2500">2500</option>
                    <option value="3000">3000</option>
                    <option value="3500">3500</option>
                    @endif
                    @if ($consulters->cout == '2000')
                    <option value="1000">1000</option>
                    <option value="1500">Pédiatrique</option>
                    <option value="2500">2500</option>
                    <option value="3000">3000</option>
                    <option value="3500">3500</option>
                    @endif
                    @if ($consulters->cout == '2500')
                    <option value="1000">1000</option>
                    <option value="1500">1500</option>
                    <option value="2000">2000</option>
                    <option value="3000">3000</option>
                    <option value="3500">3500</option>
                    @endif
                    @if ($consulters->cout == '3000')
                    <option value="1000">1000</option>
                    <option value="1500">1500</option>
                    <option value="2000">2000</option>
                    <option value="2500">2500</option>
                    <option value="3500">3500</option>
                    @endif
                    @if ($consulters->cout == '3500')
                    <option value="1000">1000</option>
                    <option value="1500">1500</option>
                    <option value="2000">2000</option>
                    <option value="2500">2500</option>
                    <option value="3000">3000</option>
                    @endif
                </select>
            </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="type">type</label>
                <select class="form-control" id="type" name="type">
                <option value="{{ $consulters->type }}">{{ $consulters->type }}</option>
                @if ($consulters->type == 'pediatrique')
                <option value="gynecologue">gynécologique</option>
                <option value="anesthesie">anesthésie</option>
                <option value="psychiatrique">psychiatrique</option>
                <option value="autres">Autres...</option>
                @endif
                @if ($consulters->type == 'gynecologue')
                <option value="pediatrique">Pédiatrique</option>
                <option value="anesthesie">anesthésie</option>
                <option value="psychiatrique">psychiatrique</option>
                <option value="autres">Autres...</option>
                @endif
                @if ($consulters->type == 'anesthesie')
                <option value="pediatrique">Pédiatrique</option>
                <option value="gynecologue">gynécologique</option>
                <option value="psychiatrique">psychiatrique</option>
                <option value="autres">Autres...</option>
                @endif
                @if ($consulters->type == 'psychiatrique')
                <option value="pediatrique">Pédiatrique</option>
                <option value="gynecologue">gynécologique</option>
                <option value="anesthesie">anesthésie</option>
                <option value="autres">Autres...</option>
                @endif
                @if ($consulters->type == 'autres')
                <option value="pediatrique">Pédiatrique</option>
                <option value="gynecologue">gynécologique</option>
                <option value="anesthesie">anesthésie</option>
                <option value="psychiatrique">psychiatrique</option>
                @endif
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="symptome">Symptome</label>
                <textarea class="form-control" id="symptome" name="symptome">{{ $consulters->symptome }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="diagnostic">Diagnostic</label>
                <textarea class="form-control" id="diagnostic" name="diagnostic">{{ $consulters->diagnostic }}</textarea>
            </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="/listesconsultations" class="btn btn-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </div>
        </form>
        </div>
    </div>
  </div>

</div>
  @endsection