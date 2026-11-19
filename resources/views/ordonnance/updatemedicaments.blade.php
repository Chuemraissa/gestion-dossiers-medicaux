@extends('layouts.app')
      
@section('title')
    @lang('messages.modif')
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">{{ __('Modifier une catégorie') }}</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">
        <form action="/update/medicaments" method="POST">
                @csrf
                
                @foreach ($errors->all() as $error)
                    <h5 class="alert alert-danger"> {{ $error }} </h5>
                @endforeach
            
            <input type="text" name="id" style="display: none;" value="{{ $medicaments->id }}">

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="categorie">{{ __('Catégorie') }}</label>
                    <select class="form-control" id="categorie" name="categorie">
                        <option value="{{ $medicaments->categorie->id }}">{{ $medicaments->categorie->nom }}</option>
                        @foreach($categories as $categorie)
                        @if($medicaments->categorie->nom != $categorie->nom)
                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                    <div class="mb-3">
                        <label class="form-label" for="nom">{{ __('Nom') }}</label>
                        <input type="text" class="form-control" value="{{ $medicaments->nom }}" name="nom" id="nom">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="quantite">{{ __('Quantité') }}</label>
                        <input type="number" min="1" class="form-control" value="{{ $medicaments->quantite }}" name="quantite" id="quantite">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cout">{{ __('Coût') }}</label>
                        <input type="number" min="1" class="form-control" value="{{ $medicaments->cout }}" name="cout" id="quantite">
                    </div>
            </div>
                <div class="modal-footer">
                    <a href="/listemedicaments" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Modifier') }}</button>
                </div>
        </form>
        </div>
    </div>
  </div>

</div>
  @endsection