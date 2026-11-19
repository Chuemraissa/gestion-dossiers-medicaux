<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
    <title>{{ __('Nouveau mot de passe') }}</title>
  </head>
<body>
    <div class="container">
        <div class="colone1">
            <div class="colone11">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <center><h2><u>{{ __('Nouveau mot de passe') }}</u></h2></center>

                <div class="form-group">
                    <label for="email">{{ __('Adresse e-mail') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $email) }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{ __('Mot de passe') }}</label>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirmer le mot de passe') }}</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
            </form>
            </div>
        </div>
        <div class="colone2">
            <img src="{{ asset('images/connexion.jpg') }}" alt="">
        </div>
    </div>
</body>
</html>
