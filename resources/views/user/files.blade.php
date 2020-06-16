@extends('layouts.user')

@section('content')
    <div class="pusher">
        <div class="main-content">

            <div class="container">
                <div class="ui placeholder segment">
                    <div class="ui two column very relaxed stackable grid">
                        <div class="column">
                            <div class="ui form">
                                <form action="#" method="get">
                                    <div class="three fields">
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
                                    </div>
                                    <button type="submit" class="ui blue submit button">Chercher</button>
                                </form>
                            </div>
                        </div>
                        <div class="middle aligned column">
                            <button class="ui big button" id="bouton_ajout_modif" type="button" onclick="ResetModal()">
                                <i class="signup icon"></i>
                                Ajouter un document
                            </button>
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
                            <th>Lien</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Matière</th>
                            <th>Date d'upload</th>
                            <th>Date de mise à jour</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($files as $file)
                            <tr id="{{$file->id}}">
                                <td><i class="file outline icon"></i><a href="licence/{{ $file->matiere }}/download/{{$file->filename}}">{{ $file->filename }}</a></td>
                                <td>{{ $file->title }}</td>
                                <td>{{ $file->type }}</td>
                                <td>{{ $file->matiere }}</td>
                                <td>{{ $file->created_at }}</td>
                                <td>{{ $file->updated_at }}</td>
                                <td class="center aligned">
                                    <button onclick="afficherForm({{$file->id}})" class="ui button"><i class="edit icon"></i></button>
                                    <button onclick="supprimer({{$file->id}})" class="ui button"><i class="trash icon"></i></button>
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
                    <input id="matiere" type="text" name="matiere" value="">
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

        /* Affichage du modal pour modifier un fichier */
        function afficherForm(id)
        {
            var dummy = Date.now();
            $.ajax({
                url : "{{ route('afficherForm') }}",
                type : 'get',
                dataType : 'text', // On désire recevoir du HTML
                data : {table:"files",dummy:dummy, id:id }, // nombat(valeur récupéré dans maj_base : valeur)
                success : function(coderetour,statut)
                { // code_html contient le HTML renvoyé*

                    var dataretour = coderetour.split('_|');
                    $('#exampleModalLongTitle').html('Modifier votre document : '+dataretour[0]);
                    $('#formu').prop('action','{{ route('update') }}');
                    $('#title').prop('value',dataretour[0]);
                    $('#file').hide();
                    $('#document_label').hide();
                    //$('#file').prop('value',dataretour[1]);
                    $('#id_fichier').val(id);
                    $('#select').dropdown('set selected',dataretour[1]);
                    $('#upload').text('Modifier');
                    open_modal();
                }
                ,error : function(resultat, statut, erreur){
                }
            });
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
    </script>


@endsection
