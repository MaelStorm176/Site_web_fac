@extends('layouts.user')

@section('content')
    <div class="pusher">
        <div class="main-content">
            <div class="container">
                <div class="ui placeholder segment">
                <div class="ui two column stackable grid">
                    <div class="column">
                        <div class="ui card">
                            <div class="image">
                                <div class="ui dimmer">
                                    <div class="content">
                                        <div class="center">
                                            <div class="ui inverted button">Add Friend</div>
                                        </div>
                                    </div>
                                </div>
                                <img src="{{asset('images/user-image.png')}}">
                            </div>
                            <div class="content">
                                <div class="header">{{$user->first_name}} {{$user->name}}</div>
                                <div class="meta">
                                    <a class="group">@foreach($roles as $role) {{$role}} @endforeach</a>
                                </div>
                                <div class="description">Ceci est votre compte utilisateur avec lequel sont postés vos fichiers. Il est associé avec l'adresse mail suivante : <strong> <em> {{$user->email}} </em> </strong> </div>
                            </div>
                            <div class="extra content">
                                <a class="right floated created">Arbitrary</a>
                                <a class="friends">
                                    Arbitrary</a>
                            </div>
                        </div>
                    </div>
                    <div class="column">

                        <div class="ui form">
                            <form action="#" method="get">
                                <div class="three fields">
                                    <div class="field">
                                        <label>Modifier votre nom</label>
                                        <div class="ui left icon input">
                                            <input type="text" name="name" placeholder="Nom de famille">
                                            <i class="search icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>Modifier votre prénom</label>
                                        <input type="text" name="first_name" placeholder="Prénom">
                                        <i class="search icon"></i>
                                    </div>
                                    <div class="field">
                                        <label>Modifier votre licence</label>
                                        <select class="ui fluid selection dropdown" id='select-licence' name='select-licence'>
                                            <option value=''>Choisissez votre licence</option>
                                            <option value='L1'>Licence 1</option>
                                            <option value='L2'>Licence 2</option>
                                            <option value='L3'>Licence 3</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="ui blue submit button">Valider</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document)
            .ready(function(){
                $('.demo .star.rating')
                    .rating()
                ;
                $('.demo .card .dimmer')
                    .dimmer({
                        on: 'hover'
                    })
                ;
            })
        ;
    </script>
@endsection
