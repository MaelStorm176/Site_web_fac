<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Upload;
use App\Store;
use Illuminate\Validation\Rule;

class FileController extends Controller
{

    public static function get_size()
    {
        $size = Storage::size('/files/');
        return $size;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file'    => 'nullable|max:10000|mimes:pdf,htm,PDF,html',
            'lien_file' => 'nullable|url',
            'title'   => 'required|max:40',
            'select'  => ['required',Rule::in(['cours', 'td', 'tp', 'autre'])],
            'matiere'  => ['required',Rule::in(DB::table('categorie')->pluck('matiere'))]
        ]);

        //UPLOAD DOCUMENT
        if(!Empty($request['file']) && Empty($request['lien_file'])) {
            $uploadedFile = $request->file('file'); //on selectionne le fichier que l'user a envoyé
            $filename = $uploadedFile->getClientOriginalName(); //on chope le nom du fichier uploadé
            if (Storage::disk('local')->exists('files/' . $filename)) {
                $filename = time() . '_' . $filename;
            }
            /* On enregistre le fichier sur le serveur */
            Storage::disk('local')->putFileAs(
                'files/' . $filename,
                $uploadedFile,
                $filename
            );

            /* Insertion dans la table upload du nouveau fichier */
            $upload = new Upload;
            $upload->title = $request['title']; //titre
            $upload->filename = $filename; //nom du fichier
            $upload->user()->associate(auth()->user()); //ID USER
            $upload->document = 1; //CECI EST UN DOCUMENT
            $upload->matiere = $request['matiere']; //matiere
            $upload->type = request('select'); //type (cours, tp, td...)
            $upload->save();

            DB::table('download')->insertOrIgnore([
                'file' => $filename,
            ]);

            return back()->with('message', 'Votre fichier a été mis en ligne');
        }

        //UPLOAD LIEN
        elseif(!Empty($request['lien_file']) && Empty($request['file']))
        {

            /* Insertion dans la table upload du nouveau fichier */
            $upload = new Upload;
            $upload->title = $request['title']; //titre
            $upload->filename = $request['lien_file']; //lien url
            $upload->user()->associate(auth()->user()); //ID USER
            $upload->document = 0; //CECI EST UN LIEN URL
            $upload->matiere = $request['matiere']; //matiere
            $upload->type = request('select'); //type (cours, tp, td...)
            $upload->save();

            return back()->with('message', 'Votre fichier a été mis en ligne');
        }
        else{
            return back()->withErrors('Vous ne pouvez pas mettre en ligne un lien et un fichier simultanement');
        }
    }

    /* Affichage des fichiers dans un tableau */
    public function afficher(Request $request,$licence,$info){
        if(!in_array($info, (array)DB::table('categorie')->pluck('matiere')) && !in_array($licence, ['L1','L2','L3']))
        {
            abort(404);
        }

        if(empty( $request->except('_token')) || ($request['select-type'] == '' && $request['search'] == '' && $request['select-matiere'] == ''))
        {
            $files = Upload::where('matiere',$info)
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        elseif($request['search'] != '') {
            if ($request['select-type'] == '')
            {
                $files = Upload::where('matiere', $info)
                    ->where('title','like','%'.$request['search'].'%')
                    ->orWhere('filename','like','%'.$request['search'].'%')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
            else
            {
                $files = Upload::where('matiere',$info)
                    ->where([['title','like','%'.$request['search'].'%'],['type',$request['select-type']]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['type',$request['select-type']]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
        }
        elseif($request['select-type'] != '') {
            $files = Upload::where('matiere',$info)
                ->where('type',$request['select-type'])
                ->orderBy('id', 'desc')
                ->paginate(20);
        }
        else
        {
            abort(404);
        }

        $files->withPath($info.'?search='.$request["search"].'&select-type='.$request['select-type']);
        //return $files;
        return view('licences.cours')
            ->with(compact('files','licence'))
            ->with('matiere',$info);
    }


    /* Téléchargement d'un fichier */
    public function download($licence,$info,$fichier){
        if(Storage::disk('local')->exists('files/'.$fichier))
        {
            DB::table('download')->where('file','=',$fichier)->increment('number',1);
            $file_path = storage_path('app\files/'.$fichier.'/'.$fichier);
            return response()->download($file_path);
        }
        else{
            abort(404);
        }
    }

    /* Suppression d'un fichier */
    public function delete(Request $request){
      if($request->ajax()){
          $fichier = Upload::find($request['id']);
          if (auth()->user()->id == $fichier->user_id || auth()->user()->hasRole(['admin'])) {
              $folder = $fichier->filename;
              Storage::deleteDirectory('/files/' . $folder);
              $fichier->delete();
          }
          else
          {
              abort(404);
          }
      }
      else
      {
          abort(404);
      }
    }

    public function delete_all(){
        $d = '/files';
        Storage::deleteDirectory($d);
        Storage::makeDirectory($d);
        Artisan::call('migrate:refresh --path=/database/migrations/2020_01_11_193337_create_uploads_table.php');
        Artisan::call('migrate:refresh --path=/database/migrations/2020_06_16_093211_download.php');
        echo('Tous les fichiers ont bien été supprimé');
    }

    /* mise a jour d'un fichier en base */
    public function update(Request $request)
    {
        $request->validate([
            'title'   => 'required|max:40',
            'select'  => ['required',Rule::in(['cours', 'td', 'tp', 'autre'])],
            'matiere'  => ['required',Rule::in(DB::table('categorie')->pluck('matiere'))]
        ]);

        $fichier = Upload::find($request['id_fichier']);
        if (auth()->user()->id == $fichier->user_id)
        {
            $fichier->title = $request['title'];
            $fichier->type = $request['select'];
            $fichier->matiere = $request['matiere'];
            $fichier->save();
            return back()->with('message', 'Votre fichier a été modifié');
        }
        else
        {
            abort(404,"Vous n'êtes pas autorisé.");
        }
    }
    /* permet d'afficher dans le formulaire le bon fichier selectionné */
    public function afficherForm(Request $request)
    {
        if ($request->ajax()){
            $z = Upload::find($request['id']);
            echo $z->title."_|".$z->type."_|".$z->matiere."_|";
        }
        else
        {
            abort(404);
        }
    }

    public function afficher_details(Request $request)
    {
        if ($request->ajax()){
            $details = Upload::find($request['id']);
            $user = User::find($details->user_id);
            $download_number = DB::table('download')->where('file','=',$details->filename)->value('number');
            echo '<tr class="ui center aligned">';
            echo '<td>'.$user->first_name.' '.$user->name.'</td>';
            echo '<td>'.$details->created_at.'</td>';
            echo '<td>'.$details->updated_at.'</td>';
            echo '<td>'.$download_number.'</td>';
            echo '</tr>';
        }
        else
        {
            abort(404);
        }
    }
}
