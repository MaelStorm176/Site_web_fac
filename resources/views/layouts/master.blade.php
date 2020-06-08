<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Site fac</title>

        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
        integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
        crossorigin="anonymous"></script>

       	<!-- BOOTSTRAP CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- FONTAWESOME CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vertical.css') }}">

        <!-- BOOTSTRAP JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>

    </head>



<body>
    <div id="cssmenu" style="width: 100%;">
        <ul >
        <li style="text-align: center;"><a href='https://licenceinfo.fr/' target="_blank"><span >LICENCE INFO</span></a></li>
        </ul>
    </div>
<div style='float:left;margin: 0 auto;'>


    <div id='cssmenu'>
      <ul>
      <li><a href='/'><span>Accueil</span></a></li>

         <!-- LICENCE 1 -->
         <li class='active has-sub'><a href='#'><span>Licence 1</span></a>
            <ul>
               <li class='has-sub'><a href='#'><span>INFO 100</span></a>
                  <ul>
                     <li><a href='#'><span>info 101</span></a></li>
                     <li class='last'><a href='#'><span>...</span></a></li>
                  </ul>
               </li>
               <li class='has-sub'><a href='#'><span>INFO 200</span></a>
                  <ul>
                     <li><a href='#'><span>info 201</span></a></li>
                     <li class='last'><a href='#'><span>...</span></a></li>
                  </ul>
               </li>
            </ul>
         </li>

         <!-- LICENCE 2 -->
         <li class='active has-sub'><a href='#'><span>Licence 2</span></a>
            <ul>
               <li class='has-sub'><a href='#'><span>INFO 300</span></a>
                  <ul>
                     <li><a href='/licencel2/info_301'><span>INFO 301</span></a></li>
                     <li><a href='/licencel2/info_302'><span>INFO 302</span></a></li>
                     <li><a href='/licencel2/info_303'><span>INFO 303</span></a></li>
                     <li><a href='/licencel2/info_305'><span>INFO 305</span></a></li>
                     <li><a href='/licencel2/info_306'><span>INFO 306</span></a></li>
                     <li><a href='/licencel2/ppro_305'><span>PPRO 305</span></a></li>
                     <li><a href='/licencel2/an_301'><span>AN 301</span></a></li>
                  </ul>
               </li>
               <li class='has-sub'><a href='#'><span>INFO 400</span></a>
                  <ul>
                     <li><a href='/licencel2/info_401'><span>INFO 401</span></a></li>
                     <li><a href='/licencel2/info_402'><span>INFO 402</span></a></li>
                     <li><a href='/licencel2/info_403'><span>INFO 403</span></a></li>
                     <li><a href='/licencel2/info_404'><span>MINFO 401</span></a></li>
                     <li><a href='/licencel2/minfo_402'><span>MINFO 402</span></a></li>
                     <li><a href='/licencel2/ppro_404'><span>PPRO 404</span></a></li>
                     <li><a href='/licencel2/ppro_403'><span>PPRO 403</span></a></li>
                  </ul>
               </li>
            </ul>
         </li>

         <!-- LICENCE 3 -->
         <li class='active has-sub'><a href='/licencel3/cours'><span>Licence 3</span></a>
            <ul>
               <li class='has-sub'><a href='#'><span>INFO 500</span></a>
                  <ul>
                     <li><a href='/licencel3/info_501'><span>INFO 501</span></a></li>
                     <li class='last'><a href='#'><span>...</span></a></li>
                  </ul>
               </li>
               <li class='has-sub'><a href='#'><span>INFO 600</span></a>
                  <ul>
                     <li><a href='/licencel3/info_601'><span>INFO 601</span></a></li>
                     <li class='last'><a href='#'><span>...</span></a></li>
                  </ul>
               </li>
            </ul>
         </li>
         @guest
         <li style=""><a data-toggle="modal" data-target="#LoginModal"><span>Se connecter</span></a></li>

         <li style=""><a href="{{ route('register') }}"><span>S'enregistrer</span></a></li>
         @endguest

         <!-- <li class='last'><a href='#'><span>Contactez nous</span></a></li> -->

      @auth
      <li >
      <a class="" href="{{ route('logout') }}"
      onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
      {{ __('Logout') }}
      </a>


      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
      </form>
      </li>
      @endauth
  </ul>

</div>
</div>
    @yield('content')




<!-- Modal Login -->
  <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-secondary">
          <div class="modal-header alert-success">
            <h5 id="exampleModalLongTitle">Connectez-vous</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!-- FORMULAIRE REMPLISSAGE -->
          <div class="modal-body">
              <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input id="email" type="email" placeholder="Entrez votre email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" type="password" placeholder="Entrez votre mot de passe" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div>
                            <div class="col-md-6">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        <div class="input-group form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Se souvenir de moi') }}
                                    </label>
                                </div>
                            </div>

                        <div class="d-flex justify-content-center">
                                <div>
                                <button type="submit" class="btn btn-secondary bg-dark">
                                    {{ __('Login') }}
                                </button>
                                </div>
                                <div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-center"> <a class="btn btn-link" href="{{ route('register') }}"> {{ __('Enregistrez vous') }}</a>
                            </div>
                        </form>
          </div>
        </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
<!-- FIN DU MODAL -->




























</body>
</html>

@yield('scripts')
<script>
    ( function( $ ) {
    $( document ).ready(function() {
    $('#cssmenu li.has-sub>a').on('click', function(){
            $(this).removeAttr('href');
            var element = $(this).parent('li');
            if (element.hasClass('open')) {
                element.removeClass('open');
                element.find('li').removeClass('open');
                element.find('ul').slideUp();
            }
            else {
                element.addClass('open');
                element.children('ul').slideDown();
                element.siblings('li').children('ul').slideUp();
                element.siblings('li').removeClass('open');
                element.siblings('li').find('li').removeClass('open');
                element.siblings('li').find('ul').slideUp();
            }
        });
    });
    } )( jQuery );

</script>


