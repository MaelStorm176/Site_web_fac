@extends('layouts.user')

@section('content')
    <div class="pusher">
        <div class="main-content">
            <div class="container">
                <div class="ui placeholder segment">
                    <div class="ui two column stackable grid padded">
                        <div class="column">
                            <div class="ui form">

                                <!-- BANNER FORMULAIRE -->
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
                                                @foreach($matieres as $mat)
                                                    <option value='{{$mat->matiere}}'>{{$mat->matiere}}</option>
                                                @endforeach
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
            <!-- FIN BANNER -->







            <!-- TABLEAU DE FICHIER -->
            <div class="ui grid stackable padded">
                <div class="column">
                    <table class="ui celled striped table">
                        <thead>
                        <tr>
                            <th colspan="8">
                                Tous les fichiers ajoutés ({{$count}})
                            </th>
                        </tr>
                        <tr class="center aligned">
                            <th width="25%">Lien</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Matière</th>
                            <th>Date de mise en ligne</th>
                            <th>Date de mise à jour</th>
                            <th width="20%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @isset($files)
                            @foreach($files as $file)
                                <tr id="{{$file->id}}" class="center aligned">
                                    <td class="lien left aligned"><i class="file outline icon"></i>
                                        @if($file->document == 1)
                                            <a href="../licence/{{$file->matiere}}/download/{{$file->filename}}">{{$file->filename}}</a>
                                        @elseif($file->document == 0)
                                            <a href="{{$file->filename}}" target="_blank">{{$file->filename}}</a>
                                        @endif
                                    </td>
                                    <td>{{ $file->title }}</td>
                                    <td>{{ $file->type }}</td>
                                    <td>{{ $file->matiere }}</td>
                                    <td>{{ $file->created_at }}</td>
                                    <td>{{ $file->updated_at }}</td>
                                    <td>
                                        <button onclick="afficherForm({{$file->id}})" class="ui button"><i class="edit icon"></i>Modifier</button>
                                        <button onclick="supprimer({{$file->id}})" class="ui button"><i class="trash icon"></i>Supprimer</button>
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
                    @endisset
                </div>
            </div>
            <!-- FIN TABLEAU -->

        </div>
    </div>
@endsection

</button>

@section('modal')
    <div class="ui tiny modal" id="modal_doc">
        <i class="close icon"></i>
        <div id="exampleModalLongTitle" class="header">
            Modal Title
        </div>
        <div class="content">
            <form class="ui form" method="POST" id="formu" action="{{ route('upload') }}" aria-label="{{ __('Upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="inline fields" id="radio-field">
                    <label>Que souhaitez-vous mettre en ligne ?</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="frequency" checked="checked" value="fichier">
                            <label>Document</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="frequency" value="lien">
                            <label>Lien externe</label>
                        </div>
                    </div>
                </div>

                <div class="field z134" id="fichier">
                    <label id="document_label" for="FILE">{{ __('Votre documents (.pdf ou .PDF)') }}</label>
                    <input type="FILE" class="btn btn-secondary" name="file" id="file" accept=".pdf, .PDF" />
                </div>

                <div class="field z134" id="lien">
                    <label id="lien_label" for="FILE">{{ __('Votre lien') }}</label>
                    <input type="url" class="btn btn-secondary" name="lien_file" id="lien_file" placeholder="Ex: https://www.google.fr/"/>
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
        $('.ui.selection.dropdown')
            .dropdown({
                clearable: true
            })
        ;

        $(document).ready(function(){
            $('#lien').hide();
            $('input[type="radio"]').click(function(){
                var inputValue = $(this).attr("value");
                var targetBox = $("#" + inputValue);
                $(".z134").not(targetBox).hide();
                $(targetBox).show();
            });
        });


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
                    $('#radio-field').hide();
                    $('.z134').hide();
                    $('#document_label').hide();
                    //$('#file').prop('value',dataretour[1]);
                    $('#id_fichier').val(id);
                    $('#select').dropdown('set selected',dataretour[1]);
                    $('#matiere').dropdown('set selected',dataretour[2]);
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
            $('#radio-field').show();
            $('#title').prop('value','');
            $('#formu').prop('action','{{ route("upload") }}');
            $('#upload').html('Mettre en ligne');
            $('#file').show();
            $('#document_label').show();
            open_modal();
        }
    </script>


@endsection
