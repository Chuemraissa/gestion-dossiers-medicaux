@extends('layouts.app')

@section('title')
    {{ __('Administration') }}
@endsection

@section('content')
<div class="container-fluid py-4">
    @include('administration._onglets')

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="list-group">
                @foreach ($listes as $code => $nom)
                    <a href="{{ route('admin.listes', $code) }}" class="list-group-item list-group-item-action {{ $listeActive === $code ? 'active' : '' }}">{{ __($nom) }}</a>
                @endforeach
            </div>
        </div>

        <div class="col-md-9">
            <div class="card p-3">
                <p class="text-sm">{{ __('La valeur est enregistrée dans les dossiers et ne peut plus être changée ; le libellé est le texte affiché.') }}</p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>{{ __('Valeur') }}</th>
                                <th>{{ __('Libellé') }}</th>
                                <th>{{ __('Ordre') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($elements as $element)
                                <tr>
                                    <td class="align-middle">{{ $element->valeur }}</td>
                                    <td><input type="text" class="form-control form-control-sm" name="libelle" value="{{ $element->libelle }}" form="choix-{{ $element->id }}" required></td>
                                    <td style="width:90px"><input type="number" class="form-control form-control-sm" name="ordre" value="{{ $element->ordre }}" min="0" form="choix-{{ $element->id }}"></td>
                                    <td class="text-nowrap">
                                        {{-- Un formulaire par ligne : les champs ci-dessus y sont rattachés par l'attribut form --}}
                                        <form method="POST" action="/administration/listes/modifier/{{ $element->id }}" id="choix-{{ $element->id }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="{{ __('Enregistrer') }}"><i class="fas fa-save"></i></button>
                                        </form>
                                        <a href="/administration/delete-element/{{ $element->id }}" class="btn btn-danger btn-sm" title="{{ __('Supprimer') }}"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h6 class="mt-3">{{ __('Ajouter un choix') }}</h6>
                <form method="POST" action="/administration/listes/ajouter" class="row g-2">
                    @csrf
                    <input type="hidden" name="liste" value="{{ $listeActive }}">
                    <div class="col-md-3">
                        <label class="form-label" for="valeur">{{ __('Valeur') }}</label>
                        <input type="text" class="form-control" id="valeur" name="valeur" value="{{ old('valeur') }}" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label" for="libelle">{{ __('Libellé') }}</label>
                        <input type="text" class="form-control" id="libelle" name="libelle" value="{{ old('libelle') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="ordre">{{ __('Ordre') }}</label>
                        <input type="number" class="form-control" id="ordre" name="ordre" value="{{ old('ordre', $elements->count()) }}" min="0">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100 px-1"><i class="fas fa-plus"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
