@extends('layouts.master2')

@section('content')
    <form class="ui form" method="POST" action="{{ route('register') }}" style="margin-bottom: 1%">
    @csrf
        <h4 class="ui dividing header">Formulaire d'enregistrement</h4>
        <div class="field">
            <label><i class="icon-user"></i>Nom de famille / prénom</label>
            <div class="two fields">
                <div class="field">
                    <input id="name" type="text"  maxlength="50" size="30" placeholder="Entrez votre nom" class="input-block-level @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                <div class="field">
                    <input id="first_name" type="text"  maxlength="50" size="30" placeholder="Entrez votre prénom" class="input-block-level @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus>
                </div>
            </div>
        </div>

        <div class="field">
            <label><i class="icon-envelope"></i>Adresse e-mail (si possible adresse e-mail étudiante)</label>
            <div class="three fields">
                <div class="field">
                    <input id="email" type="email" placeholder="Entrez votre E-Mail" class="input-block-level @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" required autocomplete="email">
                    <div class="col-md-6">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="field">
                    <select name="licence" class="ui fluid dropdown">
                        <option value="">Indiquez votre licence</option>
                        <option value="L1">Licence 1</option>
                        <option value="L2">Licence 2</option>
                        <option value="L3">Licence 3</option>
                    </select>
                </div>
                <div class="field">
                    <select name="statut" class="ui fluid dropdown">
                        <option value="">Indiquez votre statut</option>
                        <option value="1">Etudiant</option>
                        <option value="2">Professeur</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="field">
            <label><i class="icon-key"></i>Mot de passe</label>
            <div class="two fields">
                <div class="field">
                    <input id="password" type="password" placeholder="Entrez votre mot de passe" class="input-block-level @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                </div>
                <div class="field">
                    <input id="password-confirm" type="password" placeholder="Confirmer votre mot de passe" class="input-block-level" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <br/>
            <button type="submit" class="ui button" tabindex="0">
                {{ __("Je m'enregistre") }}
            </button>
            </div>
    </form>
@endsection

@section('scripts')
    <script>
        $('.ui.fluid.dropdown')
            .dropdown({
                clearable: true
            })
        ;
    </script>
@endsection
