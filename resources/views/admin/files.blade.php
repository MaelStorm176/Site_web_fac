@extends('layouts.admin')

@section('content')
    <div class="pusher">
        <div class="main-content">

            <div class="container">
                <div class="ui placeholder segment">
                    <div class="ui two column very relaxed stackable grid">
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
                                                @foreach($matieres as $mat)
                                                    <option value='{{$mat->matiere}}'>{{$mat->matiere}}</option>
                                                @endforeach
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
                        <div class="middle aligned column">
                            @auth
                                <button class="ui big button" id="bouton_ajout_modif" type="button" onclick="ResetModal()">
                                    <i class="signup icon"></i>
                                    Ajouter un document
                                </button>
                            @endauth

                            @guest
                                <button class="ui big button" id="bouton_ajout_modif" type="button" onclick="open_login()">
                                    <i class="signup icon"></i>
                                    Connectez vous pour ajouter un document
                                </button>
                            @endguest
                        </div>
                    </div>
                    <div class="ui vertical divider">
                        Ou
                    </div>
                </div>
            </div>













            <div class="ui grid stackable padded">
                <div class="column">
                    <table class="ui celled striped table">
                        <thead>
                        <tr>
                            <th colspan="8">
                                Tous les fichiers ajoutés ({{$count}})
                            </th>
                        </tr>
                        <tr>
                            <th width="25%">Lien</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Matière</th>
                            <th>Date d'upload</th>
                            <th>Date de mise à jour</th>
                            <th>Utilisateur</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($files as $file)
                            <tr id="{{$file->id}}">
                                <td class="lien"><i class="file outline icon"></i><a href="licence/{{ $file->matiere }}/download/{{$file->filename}}">{{ $file->filename }}</a></td>
                                <td>{{ $file->title }}</td>
                                <td>{{ $file->type }}</td>
                                <td>{{ $file->matiere }}</td>
                                <td>{{ $file->created_at }}</td>
                                <td>{{ $file->updated_at }}</td>
                                <td>{{ $file->user_id }}</td>
                                <td class="center aligned">
                                    <button class="ui button" onclick="supprimer({{$file->id}})"><i class="trash icon"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($files->hasPages())
                        <div class="ui pagination menu">
                            {{$files->links()}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="ui tiny modal" id="modal_doc">
        <i class="close icon"></i>
        <div id="exampleModalLongTitle" class="header">
            Modal Title
        </div>
        <div class="content">
            <form class="ui form" method="POST" id="formu" action="{{ route('upload') }}" aria-label="{{ __('Upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="field">
                    <label id="document_label" for="FILE">{{ __('Votre documents (.pdf ou .html)') }}</label>
                    <input type="FILE" class="btn btn-secondary" name="file" id="file" accept=".pdf, .PDF, .html, .htm," />
                </div>

                <div class="field">
                    <label for="select">{{ __('Nature de votre document (cours ,TD, TP...)') }}</label>
                    <select id="select" class="ui fluid selection dropdown" name="select" required>
                        <option id='nul' name='nul' value="">Choisissez le type de document</option>
                        <option id='cours' name='cours' value="cours">Cours</option>
                        <option id='td' name='td' value="td">TD</option>
                        <option id='tp' name='tp' value="tp">TP</option>
                        <option id='autre' name='autre' value="autre">autre</option>
                    </select>
                </div>

                <div class="field">
                    <label for="title">{{ __('Titre associé à votre document (ex: INFO301_cours4_fonctions)') }}</label>
                    <input id="title" type="text" placeholder="Titre" maxlength="40" name="title" required/>
                </div>
                <input id="id_fichier" type="hidden" name="id_fichier" value="">

                <div class="field">
                    <label for="matiere">Matiere</label>
                    <select class="ui fluid selection dropdown" id='matiere' name='matiere'>
                        <option value=''>Tout</option>
                        @foreach($matieres as $mat)
                            <option value='{{$mat->matiere}}'>{{$mat->matiere}}</option>
                        @endforeach
                    </select>
                </div>
            <div>
        <div class="actions">
            <div class="ui button">Annuler</div>
            <button id="upload" type="submit" class="ui button">{{ __('Mettre en ligne') }}
        </div>
    </div>
    </form>


    <!-- FIN DU MODAL -->
@endsection


@section('scripts')
    <script>
        function open_modal() {
            $('#modal_doc').modal('show');
        }

        function ResetModal()
        {
            $('#select').val("");
            $('#exampleModalLongTitle').text('Ajouter un document');
            $('#title').prop('value','');
            $('#formu').prop('action','{{ route("upload") }}');
            $('#upload').html('Mettre en ligne');
            $('#file').show();
            $('#document_label').show();
            open_modal();
        }


        /* Supprimer fichier */
        function supprimer(id)
        {
            var dummy = Date.now();
            $.ajax({
                url : "{{ route('delete') }}",
                type : 'get',
                dataType : 'html', // On désire recevoir du HTML
                data : {dummy:dummy, id:id}, // nombat(valeur récupéré dans maj_base : valeur)
                success : function(coderetour,statut){ // code_html contient le HTML renvoyé
                    $('tr[id="'+id+'"]').remove();
                    success('Le fichier a été supprimé');
                }
                ,error : function(resultat, statut, erreur){
                    error("Le fichier n'a pas pu être supprimé");
                }
            });
        }
</script>


@endsection
