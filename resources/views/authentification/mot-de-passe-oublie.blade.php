<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
    <title>{{ __('Mot de passe oublié ?') }}</title>
  </head>
<body>
    <div class="container">
        <div class="colone1">
            <div class="colone11">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <center><h2><u>{{ __('Mot de passe oublié ?') }}</u></h2></center>
                <p>{{ __('Saisissez votre adresse e-mail : vous recevrez un lien pour choisir un nouveau mot de passe.') }}</p>

                @if (session('status'))
                    <p class="alert alert-success">{{ session('status') }}</p>
                @endif

                <div class="form-group">
                    <label for="email">{{ __('Adresse e-mail') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Envoyer le lien') }}</button>
                <a class="btn btn-link" href="{{ route('login') }}">{{ __('Retour') }}</a>
            </form>
            </div>
        </div>
        <div class="colone2">
            <img src="{{ asset('images/connexion.jpg') }}" alt="">
        </div>
    </div>
</body>
</html>
