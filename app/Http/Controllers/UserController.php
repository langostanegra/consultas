<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Response;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    
    public function anadir_usuario(Request $req){  
              
        $rules = array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        );

        $validator = Validator::make ($req->all(), $rules);

        if ($validator->fails()){
            return response::json(array('errors'=> $validator->getMessageBag()->toarray()));
        }else{
            User::create([
                'name' => request()->name, 
                'email' =>  request()->email,
                'password' => bcrypt(request()->password),
            ]);
        }
    }

    public function mostrar_usuarios(Request $request){
        // return datatables()->eloquent(User::query())->toJson();
        if($request->ajax()){
            $data = User::latest()->get();
            return Datatables::of($data)
            ->addColumn('acciones', function($data){
                $button = '<button type="button" name="editar" id="'.$data->id.'" class="btn btn-info"><i class="material-icons">create</i></button>';
                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="eliminar" id="'.$data->id.'" class="btn btn-danger"><i class="material-icons">delete</i></button>';
                return $button;
            })
            ->rawColumns(['acciones'])
            ->make(true);
        }
        return view('users.index');
    }
}
