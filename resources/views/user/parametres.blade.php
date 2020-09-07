@extends('layouts.user')

@section('content')
    <div class="pusher">
        <div class="main-content">
            <div class="container">
                <div class="ui grid stackable padded">
                    <div class="column">

                        <div class="ui special cards">

                        <!-- CARD -->
                        <div class="ui special card">
                            <div class="content">
                                <div class="right floated meta">14h</div>
                                <img class="ui avatar image" src="/images/user-image.png"> {{ $user->first_name }} {{ $user->name }}
                            </div>
                            <div class="blurring dimmable image">
                                <div class="ui dimmer">
                                    <div class="content">
                                        <div class="center">
                                            <div class="ui inverted button">Changer votre photo</div>
                                        </div>
                                    </div>
                                </div>
                                <img src="/images/user-image.png">
                            </div>
                            <div class="content">
                                <span class="right floated">
                                    <i class="user icon"></i>
                                    @foreach($roles as $role)
                                        {{ $role }}
                                    @endforeach
                                </span>
                                <i class="comment icon"></i>
                                3 comments
                            </div>
                            <div class="extra content">
                                <div class="ui large transparent left icon input">
                                    <i class="heart outline icon"></i>
                                    <input type="text" placeholder="Add Comment...">
                                </div>
                            </div>
                        </div>
                        <!-- END CARD -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $('.special.cards .image').dimmer({
            on: 'hover'
        });

        $( document ).ready(function() {
            $('.dimmable .image').dimmer({
                on: 'hover'
            });
        });
    </script>
@endsection
