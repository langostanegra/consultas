<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Credencial;
use App\CheckCredential;
use DataTables;
use Validator;
use Response;

class GestionarCredencialesController extends Controller
{
    public function index(){
        return view('gestionar_credenciales.index');
    }

    public function mostrar_credenciales(Request $request){
        // return datatables()->eloquent(User::query())->toJson();
        if($request->ajax()){
            $data = Credencial::latest()->get();
            return Datatables::of($data)
            ->addColumn('acciones', function($data){                
                $button = '<a class="btn_modal_editar_credencial" name="btn_modal_editar_credencial" id="'.$data->id.'" title="Editar credenciales"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">create</i></a>';
                // $button .= '&nbsp;&nbsp;&nbsp;<a class="btn_modal_eliminar_credencial" name="btn_modal_editar_credencial" id="'.$data->id.'" title="Eliminar credencial"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">delete</i></a>';
                $button .= '&nbsp;&nbsp;&nbsp;<a class="btn_modal_revisar_credencial" name="btn_modal_revisar_credencial" id="'.$data->id.'" title="Enviar a revisión"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">call_made</i></a>';
                return $button;
            })
            ->rawColumns(['acciones'])
            ->make(true);
        }
        return view('gestionar_credenciales.index');
    }

    public function insertar_credenciales_usuario () {
        Credencial::create([
            'cedula' => request()->cedula,
            'nombre' =>  request()->nombre,
            'correo_institucional' => request()->correo_institucional,
            'usuario_medellin' => request()->usuario_medellin,
            'password_medellin' => request()->password_medellin,
            'estado' => request()->estado,
        ]);
    }

    public function insertar_credenciales_revisar(Request $req){                
        CheckCredential::create([
            'cedula' => request()->cedula,
            'nombre' =>  request()->nombre,
            'correo_institucional' =>  request()->correo_institucional,
            'usuario_medellin' =>  request()->usuario_medellin,
            'password_medellin' =>  request()->password_medellin,
            'estado' =>  request()->estado,
        ]);
    }

    public function mostrar_credenciales_revision(Request $request){
        // $estado = "";  
        if($request->ajax()){
            $data = CheckCredential::latest()->get();
            return Datatables::of($data)
            ->addColumn('estado', function($data){     
                if($data->estado == 0){
                    $estado = "";
                }else{
                    $estado = "checked";
                }           
                $button2 = '<label class="switch"><input '.$estado.' type="checkbox" id="'.$data->id.'" name="checkbox_comprobar" class="checkbox_comprobar" value="'.$data->estado.'"><span class="slider round"></span></label>';
                // <label class="switch"><input type="checkbox" id="'.$data->id.'" name="cambiar_estado_credencial"><span class="slider round"></span></label>
                // $button .= '&nbsp;&nbsp;&nbsp;<a class="btn_modal_eliminar_credencial" name="btn_modal_editar_credencial" id="'.$data->id.'" title="Eliminar credencial"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">delete</i></a>';
                return $button2;
            })
            ->rawColumns(['estado'])
            ->make(true);
        }
        return view('gestionar_credenciales.index');
    }

    public function cambiar_estado_credencial(Request $request, $id){
        $credencial = CheckCredential::find($id);
        $credencial->fill($request->all());
        $credencial->save();
    }
}