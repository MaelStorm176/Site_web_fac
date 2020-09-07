@extends('layouts.master2')
@section('content')
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




<div class="container">
    <table class='ui striped structured table celled' style="margin-bottom: 1%" id='tablefichiers' >
        <thead>
            <tr>
              <th scope="col" width="10%" class='text-left'>Type</th>
              <th scope="col" width='35%'>Titre</th>
              <th scope="col" width='35%'>Lien</th>
              <th scope="col" colspan="2" width='20%'>Actions</th>
            </tr>
        </thead>
        <tbody id="tableau">
            @foreach($files as $key)
                <tr class="text-left" id={{$key->id}}>
                    <td class="text-left" id=type_{{$key->id}}>{{ $key->type }} / {{ $matiere }}</td>
                    <td class="text-left" id=titre_{{$key->id}}>{{ $key->title }}</td>
                    <td class="lien" id=lien_{{$key->id}}>
                        @if($key->document == 1)
                            <a href="{{$matiere}}/download/{{$key->filename}}" id="link_{{$key->id}}">{{$key->filename}}</a>
                        @elseif($key->document == 0)
                            <a href="{{$key->filename}}" id="link_{{$key->id}}" target="_blank">{{$key->filename}}</a>
                        @endif
                    </td>
                    @auth
                    @if($key->user_id == Auth::user()->id)
                            <td class="text-left" id=modifier_{{$key->id}}><button type="button" class="ui secondary button" onclick="afficherForm({{$key->id}})">Modifier</button></td>
                            <td class="text-left" id=supprimer_{{$key->id}}><button type="button" class="ui button" onclick="supprimer({{$key->id}})">Supprimer</button></td>
                    @else
                        <td class="text-left" id=action_{{$key->id}}>
                            <button type="button" class="ui button" onclick="afficher_details({{$key->id}})">Détails...</button>
                        </td>
                        <td class="text-left" id=share_{{$key->id}}>
                            <button type="button" class="ui button" onclick="copyToClipboard('link_{{$key->id}}')">Partager</button>
                        </td>
                    @endif
                    @endauth

                    @guest
                        <td class="text-left" id=action_{{$key->id}}>
                            <button type="button" class="ui button" onclick="afficher_details({{$key->id}})">Détails...</button>
                        </td>
                        <td class="text-left" id=share_{{$key->id}}>
                            <button type="button" class="ui button" onclick="copyToClipboard('link_{{$key->id}}')">Partager</button>
                        </td>
                    @endguest
                </tr>
            @endforeach
        </tbody>
	</table>
    @if($files->hasPages())
        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5%">
            {{$files->links()}}
        </div>
    @endif
</div>

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
                    <input id="matiere" type="hidden" name="matiere" value=@isset($matiere) {{ $matiere }} @endisset>
            </div>
            <div class="actions">
                <div class="ui button">Annuler</div>
                <button id="upload" type="submit" class="ui button">{{ __('Mettre en ligne') }}</div>
            </div>
        </form>
    <!-- FIN DU MODAL -->
    @endauth

    <div class="ui modal" id="modal_detail">
        <i class="close icon"></i>
        <div id="detail_title" class="header">
            Détails du fichier
        </div>
        <div class="content">
            <table class="ui striped structured table celled">
                <thead class="center aligned">
                    <th> Utilisateur </th>
                    <th> Date de mise en ligne </th>
                    <th> Date de modification </th>
                    <th> Nombre de téléchargement </th>
                </thead>

                <tbody id="detail_body">

                </tbody>
            </table>
        </div>
    </div>


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

      function open_modal(modal) {
          $('#'+modal).modal('show');
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
          open_modal('modal_doc');
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
	   			$('#upload').text('Modifier');
               open_modal('modal_doc');
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
	       		success('Votre fichier a été supprimé');
	        }
	       ,error : function(resultat, statut, erreur){
	       }
	    });
	}


      function afficher_details(id)
      {
          var dummy = Date.now();
          $.ajax({
              url : "{{ route('afficher_details') }}",
              type : 'get',
              dataType : 'html', // On désire recevoir du HTML
              data : {dummy:dummy, id:id }, // nombat(valeur récupéré dans maj_base : valeur)
              success : function(coderetour,statut)
              { // code_html contient le HTML renvoyé*
                  $('#detail_body').html(coderetour);
                  open_modal('modal_detail');
              }
              ,error : function(resultat, statut, erreur){
              }
          });
      }

      function copyToClipboard(text) {
          lien = $('#'+text).attr('href');
          var input = document.body.appendChild(document.createElement("input"));
          input.value = lien;
          input.focus();
          input.select();
          document.execCommand('copy');
          input.parentNode.removeChild(input);
          success('Lien copié !')
      }

  </script>
@endsection

