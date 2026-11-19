@extends('layouts.app')

@section('title')
    @lang('messages.imprimer')
@endsection

@section('content')
<div class="container-fluid py-5 p-5">
    <header class="header">
        <div>
            @include('partials.entete-clinique')
        </div>
        <img src="{{ asset('images/logo.jpg') }}" alt="{{ \App\Models\Parametre::valeur('clinique_nom') }}" class="header-logo">
    </header>

    <h2 class="text-center">@lang('messages.listepatients')</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="bg-primary text-white sticky-top">
                <tr>
                    <th scope="col">@lang('messages.nom')</th>
                    <th scope="col">@lang('messages.date')</th>
                    <th scope="col">@lang('messages.email')</th>
                    <th scope="col">@lang('messages.sexe')</th>
                    <th scope="col">@lang('messages.tel')</th>
                    <th scope="col">@lang('messages.adresse')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                <tr class="table-row">
                    <td>{{ $patient->nom_prenom }}</td>
                    <td>{{ $patient->date_naissance }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ in_array($patient->sexe, ['masculin', 'feminin']) ? __('messages.'.$patient->sexe) : $patient->sexe }}</td>
                    <td>{{ $patient->telephone }}</td>
                    <td>{{ $patient->adresse }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <button id="print-btn" class="btn btn-primary mr-2">@lang('messages.imprimer')</button>
        <button class="btn btn-danger annuler"><a href="/listespatients" class="text-white">@lang('messages.annuler')</a></button>
    </div>
</div>
    <script>
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection