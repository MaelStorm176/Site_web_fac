@extends('layouts.master2')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" class="ui form" action="{{ route('password.email') }}">
        @csrf
        <h4 class="ui dividing header">Récupération de mot de passe</h4>
        <div class="field">
            <label>Veuillez saisir votre adresse Email associée à votre compte</label>
            <input id="email" type="email" placeholder="Entrez votre Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-flex justify-content-center h-200">
                <button type="submit" class="ui button">
                    {{ __('Envoyer un mail de réinitialisation de mot de passe') }}
                </button>
            </div>
        </div>
    </form>
@endsection
