<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Fac - ADMINISTRATION</title>

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


    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>

<body>
<!-- sidebar -->
<div class="ui sidebar inverted vertical menu sidebar-menu" id="sidebar">
    <div class="item">
        <div class="header">General</div>
        <div class="menu">
            <a class="item">
                <div>
                    <i class="icon tachometer alternate"></i>
                    Dashboard
                </div>
            </a>
        </div>
    </div>
    <div class="item">
        <div class="header">
            Administration
        </div>
        <div class="menu">
            <a class="item">
                <div><i class="cogs icon"></i>Paramètres</div>
            </a>
            <a href="{{route('users')}}" class="item">
                <div><i class="users icon"></i>Utilisateurs</div>
            </a>
            <a class="item" href="{{route('files')}}">
                <div><i class="icon file"></i>Fichiers</div>
            </a>
        </div>
    </div>

    <a href="#" class="item">
        <div>
            <i class="icon chart line"></i>
            Statistiques
        </div>
    </a>

    <a class="item">
        <div>
            <i class="icon lightbulb"></i>
            Apps
        </div>
    </a>
    <div class="item">
        <div class="header">Autres</div>
        <div class="menu">
            <a href="#" class="item">
                <div>
                    <i class="icon envelope"></i>
                    Messages
                </div>
            </a>

            <a href="#" class="item">
                <div>
                    <i class="icon calendar alternate"></i>
                    Calendrier
                </div>
            </a>
        </div>
    </div>

    <div class="item">
        <form action="#">
            <div class="ui mini action input">
                <input type="text" placeholder="Search..." />
                <button class="ui mini icon button">
                    <i class=" search icon"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="ui segment inverted">
        <div class="ui tiny olive inverted progress">
            <div class="bar" style="width: 54%"></div>
            <div class="label">Monthly Bandwidth</div>
        </div>

        <div class="ui tiny teal inverted progress">
            <div class="bar" style="width:78%"></div>
            <div class="label">Disk Usage</div>
            coucou : {{\App\Http\Controllers\FileController::get_size()}}
        </div>
    </div>
</div>

<!-- sidebar -->
<!-- top nav -->

<nav class="ui top fixed inverted menu">
    <div class="left menu">
        <a href="#" class="sidebar-menu-toggler item" data-target="#sidebar">
            <i class="sidebar icon"></i>
        </a>
        <a href="{{route('admin-panel')}}" class="header item">
            Panel administrateur
        </a>
    </div>

    <div class="right menu">
        <a href="#" class="item">
            <i class="bell icon"></i>
        </a>
        <div class="ui dropdown item">
            <i class="user cirlce icon"></i>
            <div class="menu">
                <a href="#" class="item">
                    <i class="info circle icon"></i>Mon compte</a
                >
                <a href="#" class="item">
                    <i class="wrench icon"></i>
                    Parametres</a
                >
                <a href="#" class="item">
                    <i class="icon sign-out"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- top nav -->


<!--CONTENT -->
@yield('content')
<!------------>

<!-- MODAL -->
@yield('modal')
<!----------->

<!-- SCRIPTS -->
<script src="{{asset('js/script.js')}}"></script>
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

<!------------->

</body>
</html>
