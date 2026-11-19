@extends('layouts.app')

@section('title')
    {{ __('Administration') }}
@endsection

@section('content')
<div class="container-fluid py-4">
    @include('administration._onglets')

    <div class="card mt-3 p-3">
        <p class="text-sm">{{ __('Ces informations apparaissent sur les documents imprimés et sur la page Aide.') }}</p>
        <form method="POST" action="/administration/parametres">
            @csrf
            @foreach ($champs as $cle => $nom)
                <div class="mb-3">
                    <label class="form-label" for="{{ $cle }}">{{ __($nom) }}</label>
                    <input type="text" class="form-control" id="{{ $cle }}" name="{{ $cle }}" value="{{ old($cle, $valeurs[$cle] ?? '') }}">
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
        </form>
    </div>
</div>
@endsection
