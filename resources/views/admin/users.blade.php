@extends('layouts.admin')

@section('content')
    <div class="pusher">
        <div class="main-content">
            <div class="ui placeholder  segment">
            <div class="ui one column padded grid">
                <div class="column">
                    <div class="ui form">
                        <h2 class="ui dividing header" style="margin-bottom: 30px">Chercher un utilisateur</h2>
                        <form action="#" method="get">
                            <div class="four fields">
                                <div class="field">
                                    <label>Nom de famille</label>
                                    <div class="ui left icon input">
                                        <input type="text" name="name" placeholder="Nom">
                                        <i class="search icon"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Prénom</label>
                                    <div class="ui left icon input">
                                        <input type="text" name="first_name" placeholder="Prénom">
                                        <i class="search icon"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Statut</label>
                                    <select class="ui fluid selection dropdown" id='select-statut' name='select-statut'>
                                        <option value=''>Tout</option>
                                        <option value='prof'>Professeur</option>
                                        <option value='etudiant'>Etudiant</option>
                                        <option value='admin'>Administrateur</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Licence</label>
                                    <select class="ui fluid selection dropdown" id='select-licence' name='select-licence'>
                                        <option value=''>Tout</option>
                                        <option value='cours'>Cours</option>
                                        <option value='td'>TD</option>
                                        <option value='tp'>TP</option>
                                        <option value='autre'>Autre</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="ui blue submit button">Chercher</button>
                        </form>
                    </div>
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
