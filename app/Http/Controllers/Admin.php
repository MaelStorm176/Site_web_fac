<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Upload;

class Admin extends Controller
{
    public function index()
    {
        $count = Upload::count();
        $users_count = User::count();
        $files_last = Upload::orderBy('id','desc')->take(10)->get();
        return view('admin.index',compact('count','users_count','files_last'));
    }

    public function files_afficher(Request $request)
    {
        if(empty( $request->except('_token')) || ($request['select-type'] == '' && $request['search'] == '' && $request['select-matiere'] == ''))
        {
            $files = Upload::orderBy('id', 'desc')->paginate(20);
        }
        elseif($request['search'] != '') {
            if ($request['select-type'] == '' && $request['select-matiere'] == '')
            {
                $files = Upload::where('title','like','%'.$request['search'].'%')
                    ->orWhere('filename','like','%'.$request['search'].'%')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
            elseif($request['select-type'] != '' && $request['select-matiere'] == '')
            {
                $files = Upload::where([['title','like','%'.$request['search'].'%'],['type',$request['select-type']]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['type',$request['select-type']]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }

            elseif($request['select-type'] == '' && $request['select-matiere'] != '')
            {
                $files = Upload::where([['title','like','%'.$request['search'].'%'],['type',$request['select-matiere']]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['type',$request['select-matiere']]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
            elseif ($request['select-type'] != '' && $request['select-matiere'] != '')
            {
                $files = Upload::where([['title','like','%'.$request['search'].'%'],['matiere',$request['select-matiere']],['type',$request['select-type']]])
                    ->orWhere([['filename','like','%'.$request['search'].'%'],['matiere',$request['select-matiere']],['type',$request['select-type']]])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
        }
        elseif($request['select-type'] != '') {
            if($request['select-matiere'] == '' && $request['search'] == '') {
                $files = Upload::where('type', $request['select-type'])
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
        }
        elseif ($request['select-matiere'] != '')
        {
            $files = Upload::where('matiere', $request['select-matiere'])
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        else
        {
            abort(404);
        }
        $count = $files->count();
        $files->withPath('files?search='.$request["search"].'&select-type='.$request['select-type']);

        return view('admin.files')->with(compact('files','count'));
    }


    public function users_afficher()
    {
        $count = User::count();
        $users = User::paginate(20);
        return view('admin.users',compact('count','users'));
    }

    public function users_details(Request $request)
    {
        $files = Upload::where('user_id',$request['id'])->paginate(10);
        $utilisateur = User::find($request['id'])->email;
        return view('AJAX.users_file_table',compact('files','utilisateur'));
    }
}
