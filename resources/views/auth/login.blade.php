@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="css/login.css">

<div class="container" style="" >
    <div class="d-flex justify-content-center h-200">
            <div class="card bg-secondary">
                <div class="card-header bg-dark">Connexion</div>

                <div class="card-body ">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input id="email" type="email" placeholder="Entrez votre email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" type="password" placeholder="Entrez votre mot de passe" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div>
                            <div class="col-md-6">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        

                        <div class="input-group form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Se souvenir de moi') }}
                                    </label>
                                </div>
                            </div>

                        <div class="d-flex justify-content-center">
                                <div>
                                <button type="submit" class="btn btn-secondary bg-dark">
                                    {{ __('Login') }}
                                </button>
                                </div>
                                <div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-center"> <a class="btn btn-link" href="{{ route('register') }}"> {{ __('Enregistrez vous') }}</a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
