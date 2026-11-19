@extends('layouts.app')

@section('title')
    {{ __('Administration') }}
@endsection

@section('content')
<div class="container-fluid py-4">
    @include('administration._onglets')

    <div class="card mt-3 p-3">
        <p class="text-sm mb-2">{{ __('Cochez ce que chaque rôle a le droit de faire, puis enregistrez.') }}</p>

        <form method="POST" action="/administration/roles">
            @csrf
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>{{ __('Accès') }}</th>
                            @foreach ($roles as $role)
                                <th class="text-center">
                                    {{ __($role->libelle) }}
                                    @unless ($role->est_patient)
                                        <a href="/administration/delete-role/{{ $role->id }}" class="text-white ms-1" title="{{ __('Supprimer') }}"><i class="fas fa-trash"></i></a>
                                    @endunless
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acces as $code => $description)
                            <tr>
                                <td>{{ __($description) }}</td>
                                @foreach ($roles as $role)
                                    <td class="text-center">
                                        <input type="checkbox" name="acces[{{ $role->id }}][]" value="{{ $code }}"
                                            @checked($role->acces->contains('acces', $code))
                                            @disabled($role->est_patient)>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-muted">{{ __('Le rôle patient donne seulement accès à son propre dossier médical.') }}</p>
            <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
        </form>
    </div>

    <div class="card mt-3 p-3">
        <h6>{{ __('Ajouter un rôle') }}</h6>
        <form method="POST" action="/administration/roles/ajouter" class="row g-2">
            @csrf
            <div class="col-md-4">
                <label class="form-label" for="code">{{ __('Code (sans espace, ex. : secretaire)') }}</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
            </div>
            <div class="col-md-5">
                <label class="form-label" for="libelle">{{ __('Nom affiché') }}</label>
                <input type="text" class="form-control" id="libelle" name="libelle" value="{{ old('libelle') }}" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100 px-1">{{ __('Ajouter') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
