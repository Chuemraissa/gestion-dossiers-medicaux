@extends('layouts.app')
      
@section('title')
    update
@endsection

@section('content')
<div class="container-fluid py-5">

  <div class="tabs">
    <div class="tab-item active">modifier un categorie</div>
  </div>
  <div class="tab-content">
    <div class="tab-pane active">
        <div class="modal-content">
            <form action="/update/categories" method="POST">
                @csrf

                @foreach ($errors->all() as $error)
                    <h5 class="alert alert-danger"> {{ $error }} </h5>
                @endforeach

                <input type="text" name="id" style="display: none;" value="{{ $categories->id }}">

                <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label" for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" value="{{ $categories->nom }}" name="nom">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/listecategories" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
  </div>

</div>
  @endsection