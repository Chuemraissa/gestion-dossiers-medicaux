@extends('layouts.app')
      
@section('title')
    @lang('messages.modif')
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">{{ __('Modifier les paramètres') }}</div>
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
                        <label class="form-label" for="patient">{{ __('Patient') }}</label>
                        <select class="form-control" id="patient" name="patient">
                            @foreach($resources as $resource)
                                @if($resource->id == $params->resource_id)
                                    <option value="{{ $resource->id }}" selected>{{ $resource->nom_prenom }}</option>
                                @else
                                    <option value="{{ $resource->id }}">{{ $resource->nom_prenom }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="poids">{{ __('Poids') }}</label>
                      <input type="text" class="form-control" value="{{ $params->poids }}" name="poids" id="poids">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="taille">{{ __('Taille') }}</label>
                      <input type="text" class="form-control" value="{{ $params->taille }}" name="taille" id="taille">
                    </div>
                  </div>
                
                  <!-- Colonne 1 : Ajout de patient -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="gs">{{ __('Groupe sanguin') }}</label>
                      <select class="form-control" name="groupe_sanguin" id="gs">
                        <x-options-liste liste="groupes_sanguins" :selection="$params->groupe_sanguin" />
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="temperature">{{ __('Température') }}</label>
                      <input type="text" class="form-control" value="{{ $params->temperature }}" name="temperature" id="temperature">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="pression">{{ __('Pression artérielle') }}</label>
                      <input type="text" class="form-control" value="{{ $params->pression_arterielle }}" name="pression_arterielle" id="pression">
                    </div>
                  </div>
                </div>
              <div class="modal-footer">
                    <a href="/listeparams" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Modifier') }}</button>
              </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection