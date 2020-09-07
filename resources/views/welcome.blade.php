@extends('layouts.master2')
@section('content')
</div>

<div class="ui inverted vertical masthead center aligned segment">
    <div class="ui text container">
        <h1 class="ui inverted header">
            Partagez vos fichiers entre licences
        </h1>
        <h2>Une interface simple pour télécharger, mettre en ligne et gérer vos documents</h2>
        <div class="ui huge primary button">Commencer<i class="right arrow icon"></i></div>
    </div>
</div>

<div class="ui vertical stripe segment">
    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="eight wide column">
                <h3 class="ui header">Télécharger un fichier ?</h3>
                <p>Choisissez simplement votre licence, la matière souhaitée puis téléchargez n'importe quel document pdf ou lien externe.</p>
                <h3 class="ui header">Vous ne trouvez pas un document en particulier ?</h3>
                <p>Vous pouvez à tout moment rechercher par titre et/ou par type un document de la matière correspondante.</p>
            </div>
            <div class="six wide right floated column">
                <img src="assets/images/wireframe/white-image.png" class="ui large bordered rounded image">
            </div>
        </div>
        <div class="row">
            <div class="center aligned column">
                <a class="ui huge button">Check Them Out</a>
            </div>
        </div>
    </div>
</div>


<div class="ui vertical stripe segment">
    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="six wide right floated column">
                <img src="assets/images/wireframe/white-image.png" class="ui large bordered rounded image">
            </div>
            <div class="eight wide column">
                <h3 class="ui header">Mettre en ligne un fichier ?</h3>
                <p>Pour partager vos documents, vous devez obligatoirement être identifié sur le site. Deux méthodes s'offrent ensuite à vous pour mettre en ligne un document :
                <ul>
                    <li>
                        L'ajout par <a href="{{route('user-files')}}"> le panneau utilisateur </a>
                    </li>
                    <li>
                        L'ajout directement dans la licence et matière voulues.
                    </li>
                </ul>
                </p>
                <h3 class="ui header">Votre document n'est pas un pdf ou est beaucoup trop volumineux ?</h3>
                <p>Pas de problèmes, vous pouvez aussi partager des liens externes (git, mediafire, drive...).</p>
            </div>
        </div>
    </div>
</div>

<div class="ui vertical stripe segment">
    <div class="ui text container">
        <h3 class="ui header">Quelques conseils</h3>
        <p>Si vous mettez en ligne un document, essayez de lui donner un titre explicite et facile à retrouver.
            Si votre document a déja été publié sur le site un <strong>numéro aléatoire</strong> sera ajouté à votre fichier,
            vous pourrez ainsi savoir si il existe un doublon de votre fichier.</p>
        <a class="ui large button">Read More</a>
        <h4 class="ui horizontal header divider">
            <a href="#">Case Studies</a>
        </h4>
        <h3 class="ui header">Did We Tell You About Our Bananas?</h3>
        <p>Yes I know you probably disregarded the earlier boasts as non-sequitur filler content, but its really true. It took years of gene splicing and combinatory DNA research, but our bananas can really dance.</p>
        <a class="ui large button">I'm Still Quite Interested</a>
    </div>
</div>

@endsection

@section('scripts')
@endsection
