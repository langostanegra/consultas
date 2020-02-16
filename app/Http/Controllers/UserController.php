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
                // $button = '<button type="button" name="editar" id="'.$data->id.'" class="btn btn-info"><i class="material-icons">create</i></button>';
                // $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="eliminar" id="'.$data->id.'" class="btn btn-danger"><i class="material-icons">delete</i></button>';
                $button = '<a class="btn_modal_editar_usuario" name="editar_usuario" id="'.$data->id.'" title="Editar usuario"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">create</i></a>';
                $button .= '&nbsp;&nbsp;&nbsp;<a class="btn_modal_eliminar_usuario" name="eliminar_usuario" id="'.$data->id.'" title="Eliminar usuario"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">delete</i></a>';
                $button .= '&nbsp;&nbsp;&nbsp;<a class="btn_modal_cambiar_password" name="cambiar_password" id="'.$data->id.'" title="Cambiar contraseña"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">lock_open</i></a>';
                return $button;
            })
            ->rawColumns(['acciones'])
            ->make(true);
        }
        return view('users.index');
    }

    public function editar_usuario(Request $request){
        $users_data = request()->except(['_token', '_method']);
        User::where('email', '=', $request->edit_email)->update($users_data);
    }
}