<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- You MUST include jQuery before Fomantic -->
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('semantic/dist/semantic.min.css')}}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <!-- Fonts -->

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

</head>
<body>

    <div class="ui inverted menu">
        <div class="ui container">
            <a href="#" class="header item">
                <img class="logo" src="{{asset('images/logo-urca.png')}}">
                Entrepôt de fichiers
            </a>
            <a href="/" class="item">Accueil</a>
            <div class="ui simple dropdown item">
                Licence 1 <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="item">
                        <i class="dropdown icon"></i>
                        INFO 100
                        <div class="menu">
                            <a class="item" href="/L1/info_101">INFO 101</a>
                            <a class="item" href="/L1/info_102">INFO 102</a>
                            <a class="item" href="/L1/info_103">INFO 103</a>
                            <a class="item" href="/L1/info_104">INFO 104</a>
                            <a class="item" href="/L1/info_105">INFO 105</a>
                        </div>
                    </div>
                    <div class="item">
                        <i class="dropdown icon"></i>
                        INFO 200
                        <div class="menu">
                            <a class="item" href="/L1/info_201">INFO 201</a>
                            <a class="item" href="/L1/info_202">INFO 202</a>
                            <a class="item" href="/L1/info_203">INFO 203</a>
                            <a class="item" href="/L1/info_204">INFO 204</a>
                            <a class="item" href="/L1/info_205">INFO 205</a>
                        </div>
                    </div>
                    <a class="item" href="#">Link Item</a>
                </div>
            </div>

            <!-- LICENCE 2 -->

            <div class="ui simple dropdown item">
                Licence 2 <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="item">
                        <i class="dropdown icon"></i>
                        INFO 300
                        <div class="menu">
                            <a class="item" href="/L2/info_301">INFO 301</a>
                            <a class="item" href="/L2/info_302">INFO 302</a>
                            <a class="item" href="/L2/info_303">INFO 303</a>
                            <a class="item" href="/L2/info_304">INFO 304</a>
                            <a class="item" href="/L2/info_305">INFO 305</a>
                        </div>
                    </div>
                    <div class="item">
                        <i class="dropdown icon"></i>
                        INFO 400
                        <div class="menu">
                            <a class="item" href="/L2/info_401">INFO 401</a>
                            <a class="item" href="/L2/info_402">INFO 402</a>
                            <a class="item" href="/L2/info_403">INFO 403</a>
                            <a class="item" href="/L2/info_404">INFO 404</a>
                            <a class="item" href="/L2/info_405">INFO 405</a>
                        </div>
                    </div>
                    <a class="item" href="#">Link Item</a>
                </div>
            </div>

            <!-- LICENCE 3 -->

            <div class="ui simple dropdown item">
                Licence 3 <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="item">
                        <i class="dropdown icon"></i>
                        INFO 500
                        <div class="menu">
                            <a class="item" href="#">INFO 501</a>
                            <a class="item" href="#">INFO 502</a>
                            <a class="item" href="#">INFO 503</a>
                            <a class="item" href="#">INFO 504</a>
                            <a class="item" href="#">INFO 505</a>
                        </div>
                    </div>
                    <div class="item">
                        <i class="dropdown icon"></i>
                        INFO 600
                        <div class="menu">
                            <a class="item" href="#">INFO 601</a>
                            <a class="item" href="#">INFO 602</a>
                            <a class="item" href="#">INFO 603</a>
                            <a class="item" href="#">INFO 604</a>
                            <a class="item" href="#">INFO 605</a>
                        </div>
                    </div>
                    <a class="item" href="#">Link Item</a>
                </div>
            </div>

            @guest
                <a class="item right" onclick="open_login()"><span>Se connecter</span></a>
                <a class="item right" href="{{ route('register') }}"><span>S'enregistrer</span></a>
            @endguest
            @auth
            <div class="ui simple dropdown item">
                <i class="user circle icon"></i>
                <div class="menu">
                    <a href="{{route('user-panel')}}" class="item">
                        <i class="info circle icon"></i>Mon compte
                    </a>
                    @hasrole('admin')
                    <a href="{{route('admin-panel')}}" class="item">
                        <i class="info circle icon"></i>Panel administrateur
                    </a>
                    @endhasrole

                    <a href="#" class="item">
                        <i class="wrench icon"></i>
                        Parametres
                    </a>
                    <a class="item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="arrow alternate circle right icon"></i>
                        {{ __('Se deconnecter') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>

    <div class="ui main text container d-block">


        @yield('content')
    </div>

    <!-- FOOTER -->

    <div class="ui inverted vertical footer segment">
        <div class="ui center aligned container">
            <div class="ui stackable inverted divided grid">
                <div class="three wide column">
                    <h4 class="ui inverted header">Licence</h4>
                    <div class="ui inverted link list">
                        <a href="https://licenceinfo.fr/" class="item">Licence Informatique</a>
                        <a href="https://www.univ-reims.fr/" class="item">Université</a>
                        <a href="https://thor.univ-reims.fr/" class="item">THoR</a>
                        <a href="#" class="item">Link Four</a>
                    </div>
                </div>
                <div class="three wide column">
                    <h4 class="ui inverted header">Réseaux sociaux</h4>
                    <div class="ui inverted link list">
                        <a href="https://www.facebook.com/groups/213445229493092" class="item">Groupe Facebook</a>
                        <a href="https://discord.gg/T2vM2Tu" class="item">Serveur Discord</a>
                        <a href="#" class="item">Link Three</a>
                        <a href="#" class="item">Link Four</a>
                    </div>
                </div>
                <div class="three wide column">
                    <h4 class="ui inverted header">Sites annexes</h4>
                    <div class="ui inverted link list">
                        <!--
                        <a href="#" class="item">Link One</a>
                        <a href="#" class="item">Link Two</a>
                        <a href="#" class="item">Link Three</a>
                        <a href="#" class="item">Link Four</a>
                        -->
                    </div>
                </div>
                <div class="seven wide column">
                    <h4 class="ui inverted header">Le site</h4>
                    <p>Ce site a été créé afin de simplifier un maximum le partage de fichiers entre élèves et entre licences. Vous pouvez donc partager PDF et liens HTML simplement et de manière intuitive. </p>
                </div>
            </div>
            <div class="ui inverted section divider"></div>
            <img src="" class="ui centered mini image">
            <div class="ui horizontal inverted small divided link list">
                <a class="item" href="#">Site Map</a>
                <a class="item" href="#">Contact Us</a>
                <a class="item" href="#">Terms and Conditions</a>
                <a class="item" href="#">Privacy Policy</a>
            </div>
        </div>
    </div>



</body>

@guest
    <!-- modal login -->
    <div class="ui tiny modal" id="modal_login">
        <i class="close icon"></i>
        <div class="header">
            Formulaire de connexion
        </div>
        <div class="content">
            <form class="ui form" method="POST" action="{{ route('login') }}">
                @csrf

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" placeholder="Entrez votre email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <script>$(function (){erreur('{{$message}}')});</script>
                        @enderror
                    </div>


                    <div class="field">
                        <label for="email">Mot de passe</label>
                        <input id="password" type="password" placeholder="Entrez votre mot de passe" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <div class="col-md-6">
                            @error('password')
                            <script>$(function (){erreur('{{$message}}')});</script>
                            @enderror
                        </div>
                    </div>


                <div class="field">
                    <div class="ui slider checkbox">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Se souvenir de moi') }}
                        </label>
                    </div>
                </div>

                <div class="field">
                    <div>
                        @if (Route::has('password.request'))
                            <a class="alert-link" href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-center"> <a class="btn btn-link" href="{{ route('register') }}"> {{ __('Enregistrez vous') }}</a>
                </div>

        </div>
        <div class="actions">
            <div class="ui button">
                Annuler
            </div>
            <button id="upload" type="submit" class="ui button">{{ __('Se connecter') }}
        </div>
        </form>
    </div>
    <!-- FIN MODAL -->
@endguest


@yield('modal')

@yield('scripts')
<script src="{{asset('js/Notifier.min.js')}}" type="text/javascript"></script>
<script>
    function success(message) {
        var notifier = new Notifier();
        notifier.notify("success", message);
    }

    function erreur(message) {
        var notifier = new Notifier();
        notifier.notify("error", message);
    }
</script>
@if(session()->has('message'))
    <script>$(function (){ success('{{session()->get('message')}}')});</script>
@endif
@if(session()->has('erreur'))
    <script>$(function (){ erreur('{{session()->get('erreur')}}')});</script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>$(function (){ erreur('{{$error}}')});</script>
    @endforeach
@endif

@guest
    <script>
        function open_login() {
            $('#modal_login').modal('show');
        }
    </script>
@endguest

</html>
