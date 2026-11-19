{{-- En-tête des documents imprimés : informations de l'établissement (table "parametres") --}}
@php($p = \App\Models\Parametre::class)
<h1>{{ $p::valeur('clinique_nom') }}</h1>
<h5>{{ $p::valeur('clinique_adresse') }},<br>{{ $p::valeur('clinique_region') }}</h5>
<h5>{{ __('Tél') }} : {{ $p::valeur('clinique_telephone') }}</h5>
