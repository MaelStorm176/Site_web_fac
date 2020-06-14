@extends('layouts.master2')
@section('content')
    <div class="container">
        <div class="ui placeholder segment">
            <div class="ui two column very relaxed stackable grid">
                <div class="column">
                    <div class="ui form">
                        <form action="#" method="get">
                        <div class="field">
                            <label>Chercher un document</label>
                            <div class="ui left icon input">
                                <input type="text" name="search" placeholder="Titre du document">
                                <i class="search icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>Type de document</label>
                            <select class="ui fluid selection dropdown" id='select-type' name='select-type' onchange='this.form.submit()'>
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





    <table class='ui striped structured table celled ' id='tablefichiers' >
        <thead>
            <tr>
              <th scope="col" class='text-left'>Type<br />

              </th>

              <th scope="col" width='30%'>Titre</th>
              <th scope="col" width='20%'>Lien</th>
              <th scope="col" colspan="2" width='20%'>Actions</th>
            </tr>
        </thead>
        <tbody id="tableau">
            @foreach($files as $key)
                <tr class="text-left" id={{$key->id}}>
                    <td class="text-left" id=type_{{$key->id}}>{{ $key->type }} / {{ $matiere }}</td>
                    <td class="text-left" id=titre_{{$key->id}}>{{ $key->title }}</td>
                    <td class="text-left" id=lien_{{$key->id}}><a href="{{$matiere}}/download/{{$key->filename}}">{{$key->filename}}</a></td>
                    @auth
                    @if($key->user_id == Auth::user()->id)
                            <td class="text-left" id=modifier_{{$key->id}}><button type="button" class="ui secondary button" onclick="afficherForm({{$key->id}})">Modifier</button></td>
                            <td class="text-left" id=supprimer_{{$key->id}}><button type="button" class="ui button" onclick="supprimer({{$key->id}})">Supprimer</button></td>
                    @endauth
                    @else
                        <td class="text-left" id=action_{{$key->id}}></td>
                    @endif

                </tr>
            @endforeach
        </tbody>
	</table>
    @if($files->hasPages())
        <div class="ui pagination menu">
            {{$files->links()}}
        </div>
    @endif
@endsection

@section('modal')
    @auth

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
                    <input id="matiere" type="hidden" name="matiere" value=<?php echo $matiere; ?>>
            </div>
            <div class="actions">
                <div class="ui button">Annuler</div>
                <button id="upload" type="submit" class="ui button">{{ __('Mettre en ligne') }}</div>
            </div>
        </form>
    <!-- FIN DU MODAL -->
    @endauth
@endsection

@section('scripts')
  <script>
      $('.ui.selection.dropdown')
          .dropdown({
              clearable: true
          })
      ;

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
	       		$('#exampleModalLongTitle').html('Modifier votre document : '+dataretour[1]);
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
	        }
	       ,error : function(resultat, statut, erreur){
	       }
	    });
	}
  </script>
@endsection

