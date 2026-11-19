@extends('layouts.app')
      
@section('title')
    @lang('messages.modif')
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">{{ __('Modifier un antécédent') }}</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">
            <form action="/update/antecedent" method="POST">
              @csrf
             
              @foreach ($errors->all() as $error)
                <h1 class="alert alert-danger"> {{ $error }} </h1>
              @endforeach

            <input type="text" name="id" style="display: none;" value="{{ $antecedents->id }}">

              <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label" for="patient">{{ __('Patient') }}</label>
                        <select class="form-control" id="patient" name="patient">
                            @foreach($resources as $resource)
                                @if($resource->id == $antecedents->resource_id)
                                    <option value="{{ $resource->id }}" selected>{{ $resource->nom_prenom }}</option>
                                @else
                                    <option value="{{ $resource->id }}">{{ $resource->nom_prenom }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="type">{{ __('Type') }}</label>
                      <select class="form-control" name="type_antecedent" id="type">
                        <x-options-liste liste="types_antecedent" :selection="$antecedents->type" />
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="description">{{ __('Description') }}</label>
                      <textarea class="form-control" name="description_antecedent" id="description">{{ $antecedents->description }}</textarea>
                    </div>
                </div>
              <div class="modal-footer">
                    <a href="/listeantecedents" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Modifier') }}</button>
              </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection