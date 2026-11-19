{{-- Valeur déjà enregistrée qui n'est plus dans la liste : on la garde pour ne pas la perdre --}}
@if (filled($selection) && ! $options->contains('valeur', $selection))
    <option value="{{ $selection }}" selected>{{ $selection }}</option>
@endif
@foreach ($options as $option)
    <option value="{{ $option->valeur }}" @selected((string) $option->valeur === (string) $selection)>{{ __($option->libelle) }}</option>
@endforeach
