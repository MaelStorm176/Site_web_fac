@extends('layouts.admin')

@section('content')
    <div class="pusher">
        <div class="main-content">

            <div class="ui one column very relaxed stackable grid">
                <div class="column">
                    <div class="ui form">
                        <form action="#" method="get">
                            <div class="two fields">
                                <div class="field">
                                    <label>Chercher un document</label>
                                    <div class="ui left icon input">
                                        <input type="text" name="search" placeholder="Titre du document">
                                        <i class="search icon"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Matière</label>
                                    <select class="ui fluid selection dropdown" id='select-matiere' name='select-matiere'>
                                        <option value=''>Tout</option>
                                        <option value='info_101'>INFO 101</option>
                                        <option value='info_102'>INFO 102</option>
                                        <option value='info_103'>INFO 103</option>
                                        <option value='info_104'>INFO 104</option>
                                        <option value='info_105'>INFO 105</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>Type de document</label>
                                <select class="ui fluid selection dropdown" id='select-type' name='select-type'>
                                    <option id='nul' name='nul' value=''>Choisissez le type de document</option>
                                    <option value='cours'>Cours</option>
                                    <option value='td'>TD</option>
                                    <option value='tp'>TP</option>
                                    <option value='autre'>Autre</option>
                                    <option value=''>Tout</option>
                                </select>
                            </div>
                            <button type="submit" class="ui blue submit button">Chercher</button>
                        </form>
                    </div>
                </div>
            </div>






























            <div class="ui grid stackable padded">
                <div class="column">
                    <table class="ui celled striped table">
                        <thead>
                        <tr>
                            <th colspan="8">
                                Listes des utilisateurs ({{$count}})
                            </th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Roles</th>
                            <th>Licence</th>
                            <th>Créé le</th>
                            <th>Mis à jour le</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr id="{{$user->id}}">
                                <td><i class="icon user"></i>{{ $user->email }}</a></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->getRoleNames() }}</td>
                                <td>{{ $user->licence }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td class="center aligned">
                                    <button class="ui button" onclick="supprimer({{$user->id}})"><i class="edit icon"></i>
                                    </button>

                                    <button class="ui button" onclick="voir({{$user->id}})"><i class="eye icon"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($users->hasPages())
                        <div id="pag_principale" class="ui pagination menu">
                            {{$users->links()}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="ui big modal" id="modal_user">
        <i class="close icon"></i>
        <div id="exampleModalLongTitle" class="header">
            Fichiers mis en ligne
        </div>
        <div class="content" id="body-users-table">

        </div>
        <div class="actions">
            <div class="ui button">Annuler</div>
            <button id="upload" type="submit" class="ui button">{{ __('Mettre en ligne') }}
        </div>
    </div>
    <!-- FIN DU MODAL -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            var id = 0;
            $(document).on('click', '#pag_secondaire a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                voir_page(page);
            });
        });

        /* voir fichier */
        function voir(id_user)
        {
            id = id_user;
            var dummy = Date.now();
            $.ajax({
                url : "{{ route('users_details') }}",
                type : 'get',
                dataType : 'html', // On désire recevoir du HTML
                data : {dummy:dummy, id:id}, // nombat(valeur récupéré dans maj_base : valeur)
                success : function(coderetour,statut){ // code_html contient le HTML renvoyé
                    $('#body-users-table').html(coderetour);
                    $('#modal_user').modal('show');
                }
                ,error : function(resultat, statut, erreur){
                    alert('erreur AJAX'+resultat+'_'+statut+'_'+erreur);
                }
            });
        }

        function voir_page(page)
        {
            var dummy = Date.now();
            $.ajax({
                url : "{{ route('users_details_page') }}"+page,
                type : 'get',
                dataType : 'html', // On désire recevoir du HTML
                data : {dummy:dummy, id:id}, // nombat(valeur récupéré dans maj_base : valeur)
                success : function(coderetour,statut){ // code_html contient le HTML renvoyé
                    $('#body-users-table').html(coderetour);
                }
                ,error : function(resultat, statut, erreur){
                    alert('erreur AJAX'+resultat+'_'+statut+'_'+erreur);
                }
            });
        }
    </script>

@endsection
