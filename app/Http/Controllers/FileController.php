<?php

namespace App\Http\Controllers;
use DemeterChain\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'file'    => 'required|max:10000|mimes:pdf,htm,PDF,html',
            'title'   => 'required|max:40',
            'select'  => ['required',Rule::in(['cours', 'td', 'tp', 'autre'])],
            'matiere'  => ['required',Rule::in(DB::table('categorie')->pluck('matiere'))]
        ]);

        $uploadedFile = $request->file('file'); //on selectionne le fichier que l'user a envoyé
        $filename = $uploadedFile->getClientOriginalName(); //on chope le nom du fichier uploadé
        if(Storage::disk('local')->exists('files/'.$filename))
        {
            $filename = time().'_'.$filename;
        }
        /* On enregistre le fichier sur le serveur */
        Storage::disk('local')->putFileAs(
            'files/'.$filename,
            $uploadedFile,
            $filename
        );

        /* Insertion dans la table upload du nouveau fichier */
        $upload = new Upload;
        $upload->title = $request['title']; //titre
        $upload->filename = $filename; //nom du fichier
        $upload->user()->associate(auth()->user()); //ID USER
        $upload->matiere = $request['matiere']; //matiere
        $upload->type = request('select'); //type (cours, tp, td...)
        $upload->save();

        DB::table('download')->insertOrIgnore([
          'file' => $filename,
        ]);

        return back()->with('message','Votre fichier a été mis en ligne');
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
                ->paginate(20);
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
    public function afficherForm(Request $request){
        if ($request->ajax()){
            $z = Upload::find($request['id']);
            echo $z->title."_|".$z->type."_|".$z->matiere."_|";
        }
        else
        {
            abort(404);
        }
    }
}

































    // public function afficher(Request $request){
    //   if ($request->ajax()){
    //     $y = DB::table('files')
    //             ->join('uploads','files.id','=','uploads.file_id')
    //             ->where('uploads.type','=',$request['type'])
    //             ->where('uploads.matiere','=',$request['matiere'])
    //             ->orderBy('files.id', 'desc')
    //             ->paginate(5);
    //             //->get();
    //     $z = DB::table('uploads')
    //             ->select('*')
    //             ->where('type','=',$request['type'])
    //             ->where('matiere','=',$request['matiere'])
    //             ->orderBy('id', 'desc')
    //             ->paginate(5);
    //             //->get();

    //     $count = 0;

    //     $iduser = Auth::id();
    //   foreach($y as $key)
    //   {
    //     echo "<tr class='text-left' id='".$key->file_id."'>"; //chaque ligne à un id différent
    //     echo "<td class='text-left' id='titre_".$key->file_id."'>".$request['type']."</td>";
    //     echo "<td class='text-left' id='titre_".$key->file_id."'>".$key->title."</td>";
    //     echo "<td class='text-left' id='lien_".$key->file_id."'>"."<a href='download/".$z[$count]->filename."' value=".$z[$count]->filename.">".$z[$count]->filename."</a></td>";

    //     if($iduser == $key->user_id){
    //       echo "
    //       <td>
    //       <i onclick='afficherForm(".$key->file_id.")' class='fas fa-edit' style='margin-right: 20%'></i>
    //       <i onclick='supprimer(".$key->file_id.")'
    //       class='fas fa-trash-alt'></i>
    //       </td>";
    //       echo "</tr>";
    //     }
    //     else{
    //       echo "<td ></td>";
    //       echo "</tr>";
    //     }
    //     $count++;

    //   }
    //   $y->withPath('info_501');
    //   echo "<tr>";
    //   echo "<td> {{$y->links()}} </td>";
    //   echo "</tr>";

    //   }
    //   //echo "</tbody>";
    //   //echo "{{$y->links()}}";
    //   //return view("licences.licencel3.cours");
    // }
