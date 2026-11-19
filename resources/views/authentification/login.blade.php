<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
    
    <title>{{ __('Connexion') }}</title>
  </head>

<body>  

        <div class="container">
            <div class="colone1">
                <div class="colone11">
            <form method="POST" action="/login">
                @csrf
                    <center class=""><h2><u>{{ __('Connexion') }}</u></h2></center>
                    @if (session('status'))
                        <p class="alert alert-success">{{ session('status') }}</p>
                    @endif
                    <div class="form-group">
                        <label for="email">{{ __('Adresse e-mail') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Mot de passe') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Se souvenir de moi') }}
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Connexion') }}</button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Mot de passe oublié ?') }}</a>
                    @endif
                </div>
            </form>
            </div>
            <div class="colone2">
                <img src="{{ asset('images/connexion.jpg') }}" class="" alt="">
            </div>
        </div>
    </form>
   
</body>

</html>