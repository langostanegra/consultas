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

    public function mostrar_usuarios(){
        return datatables()->eloquent(User::query())->toJson();
    }
}
