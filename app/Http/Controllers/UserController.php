<?php

namespace App\Http\Controllers;

use App\Upload;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class UserController extends Controller
{
    use HasRoles;
    private $id_user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->id_user = Auth::user()->id;
            return $next($request);
        });
    }

    public function index()
    {
        $count = Upload::where('user_id',$this->id_user)->count();
        $files_last = Upload::where('user_id',$this->id_user)->orderBy('id', 'desc')->take(10)->get();
        $download = DB::table('download')
            ->join('uploads','uploads.filename','=','download.file')
            ->where('user_id',$this->id_user)
            ->sum('number');
        $file_best = DB::table('download')
            ->join('uploads','uploads.filename','=','download.file')
            ->where('user_id',$this->id_user)
            ->orderByDesc('number')
            ->first();
        return view('user.index', compact('count', 'files_last','download','file_best'));
    }

    public function files_afficher(Request $request)
    {
        if(empty( $request->except('_token')) || ($request['select-type'] == '' && $request['search'] == '' && $request['select-matiere'] == ''))
        {
            $files = Upload::where('user_id',$this->id_user)->orderBy('id', 'desc')->paginate(20);
        }
        elseif($request['search'] != '') {
            if ($request['select-type'] == '' && $request['select-matiere'] == '')
            {
                $files = Upload::where([['title','like','%'.$request['search'].'%'],['user_id',$this->id_user]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['user_id',$this->id_user]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
            elseif($request['select-type'] != '' && $request['select-matiere'] == '')
            {
                $files = Upload::where([['title','like','%'.$request['search'].'%'],['type',$request['select-type']],['user_id',$this->id_user]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['type',$request['select-type']],['user_id',$this->id_user]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }

            elseif($request['select-type'] == '' && $request['select-matiere'] != '')
            {
                $files = Upload::where([['title','like','%'.$request['search'].'%'],['type',$request['select-matiere']],['user_id',$this->id_user]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['type',$request['select-matiere']],['user_id',$this->id_user]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
            elseif ($request['select-type'] != '' && $request['select-matiere'] != '')
            {
                $files = Upload::where([['title','like','%'.$request['search'].'%'],['matiere',$request['select-matiere']],['type',$request['select-type']],['user_id',$this->id_user]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['matiere',$request['select-matiere']],['type',$request['select-type']],['user_id',$this->id_user]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
        }
        elseif($request['select-type'] != '') {
            if($request['select-matiere'] == '' && $request['search'] == '') {
                $files = Upload::where([['type', $request['select-type']],['user_id',$this->id_user]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
        }
        elseif ($request['select-matiere'] != '')
        {
            $files = Upload::where([['matiere', $request['select-matiere']],['user_id',$this->id_user]])
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        else
        {
            abort(404);
        }
        if (Empty($files)){$count = 0;}
        else{$count = $files->count();$files->withPath('files?search='.$request["search"].'&select-type='.$request['select-type']);}
        $matieres = DB::table('categorie')->select('matiere')->get();
        return view('user.files')->with(compact('files','count','matieres'));
    }

    public function parametres()
    {
        $user = Auth::user();
        $roles =  $user->roles->pluck('name');
        return view('user.parametres',compact('user','roles'));
    }
}
