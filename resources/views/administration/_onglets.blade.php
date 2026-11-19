{{-- Onglets communs aux écrans d'administration --}}
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item"><a class="nav-link {{ request()->is('administration/roles') ? 'active' : '' }}" href="{{ route('admin.roles') }}">{{ __('Rôles et accès') }}</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('administration/listes*') ? 'active' : '' }}" href="{{ route('admin.listes') }}">{{ __('Listes de choix') }}</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('administration/parametres') ? 'active' : '' }}" href="{{ route('admin.parametres') }}">{{ __('Informations de la clinique') }}</a></li>
</ul>
