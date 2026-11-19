@extends('layouts.app')
      
@section('title')
    @lang('messages.consultation')
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">{{ __('Consultations') }}</div>
  </div>
  
  <div class="tab-content">
    <div class="tab-pane active">
      <div class="row align-items-center">
        <div class="col-10 col-md-10">
            <div class="input-group p-1">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="form1" class="form-control" placeholder="@lang('messages.recherche')" />
                </div>
                <button type="button" class="bg-primary bordure" data-mdb-ripple-init>
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-2 col-md-2">
          <button type="button" data-toggle="modal" data-target="#myModal" class="bg-primary bordure">
              <i class="fas fa-user-plus mr-2"></i>{{ __('Ajouter une consultation') }}
          </button>
        </div>
      </div>
        <!-- Modal pour ajouter un patient -->
      <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Ajouter une consultation') }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                        <!-- Formulaire de remplissage -->
                      <form action="/ajouter/consultation" method="POST">
                        @csrf
                      
                        @foreach ($errors->all() as $error)
                          <h5 class="alert alert-danger"> {{ $error }} </h5>
                        @endforeach
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="patient">{{ __('Patient') }}</label>
                          <select class="form-control" id="patient" name="patient">
                            <option value="">{{ __('Sélectionnez un patient') }}</option>
                      @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->nom_prenom }}</option>
                      @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="motif">{{ __('Motif') }}</label>
                            <textarea class="form-control" id="motif" name="motif"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="cout">{{ __('Coût') }}</label>
                            <select id="cout" name="cout" class="form-control">
                              <x-options-liste liste="tarifs_consultation" :selection="old('cout')" />
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="type">{{ __('Type') }}</label>
                          <select class="form-control" id="type" name="type">
                            <option value="">{{ __('Sélectionnez un type de consultation') }}</option>
                            <x-options-liste liste="types_consultation" :selection="old('type')" />
                          </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="symptome">{{ __('Symptômes') }}</label>
                            <textarea class="form-control" id="symptome" name="symptome"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="diagnostic">{{ __('Diagnostic') }}</label>
                            <textarea class="form-control" id="diagnostic" name="diagnostic"></textarea>
                        </div>
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
          <thead class="bg-primary text-white">
            <tr>
              <th scope="col">{{ __('Patient') }}</th>
              @if(auth()->user()?->aAcces('voir_medecin'))
              <th scope="col">{{ __('Médecin') }}</th>
              @endif
              <th scope="col">{{ __('Motif') }}</th>
              <th scope="col">{{ __('Coût') }}</th>
              <th scope="col">{{ __('Type') }}</th>
              <th scope="col">{{ __('Symptômes') }}</th>
              <th scope="col">{{ __('Diagnostic') }}</th>
              <th scope="col">{{ __('Action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($consulters as $consulter)
              <tr class="table-row" onclick="window.location.href='/vue-consultations/{{ $consulter->patient_id }}'">
                <td>
                  @foreach($patients as $patient)
                    @if($consulter->patient_id == $patient->id)
                      {{ $patient->nom_prenom }}
                    @endif
                  @endforeach
                </td>
                @if(auth()->user()?->aAcces('voir_medecin'))
                <td>
                  @foreach($medecins as $medecin)
                    @if($consulter->medecin_id == $medecin->id)
                      {{ $medecin->nom_prenom }}
                    @endif
                  @endforeach
                </td>
                @endif
                <td>{{ $consulter->motif}}</td>
                <td>{{ $consulter->cout}}</td>
                <td>{{ \App\Models\ElementListe::libelle('types_consultation', $consulter->type) }}</td>
                <td>{{ $consulter->symptome}}</td>
                <td>{{ $consulter->diagnostic}}</td>
                <td>
                      <a href="/update-consultations/{{ $consulter->id }}" class="btn btn-success btn-sm mr-2" style="line-height: 1;"><i class="fas fa-edit"></i></a>
                      @if(auth()->user()?->aAcces('consultations_suppression')) 
                      <a href="/delete-consultations/{{ $consulter->id }}" class="btn btn-danger btn-sm" style="line-height: 1;"><i class="fas fa-trash"></i></a>
                      @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  @endsection