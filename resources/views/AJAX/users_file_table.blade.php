<table class="ui celled striped table">
    <thead>
    <tr>
        <th colspan="7">
            Tous les fichiers ajoutés par : {{$utilisateur}}
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
    <tbody >
    @foreach($files as $file)
        <tr id="{{$file->id}}">
            <td><i class="file outline icon"></i><a href="../licence/{{ $file->matiere }}/download/{{$file->filename}}">{{ $file->filename }}</a></td>
            <td>{{ $file->title }}</td>
            <td>{{ $file->type }}</td>
            <td>{{ $file->matiere }}</td>
            <td>{{ $file->created_at }}</td>
            <td>{{ $file->updated_at }}</td>
            <td class="center aligned" onclick="supprimer({{$file->id}})"><i class="trash icon"></i></td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($files->hasPages())
    <div id="pag_secondaire" class="ui pagination menu">
        {{ $files->links() }}
    </div>
@endif



