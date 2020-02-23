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
            'fecha_inicio' =>  date(request()->fecha_inicio),
        ]);
    }

    public function mostrar_credenciales_revision(Request $request){        
        if($request->ajax()){
            $data = CheckCredential::latest()->get();
            return Datatables::of($data)
            ->addColumn('estado', function($data){     
                if($data->estado == 0){
                    $estado = "";
                    $title = "En proceso";
                }else{
                    $estado = "checked";
                    $title = "Proceso finalizado";
                }           
                $boton_estado = '<label title="'.$title.'" class="switch"><input '.$estado.' type="checkbox" id="'.$data->id.'" name="checkbox_comprobar" class="checkbox_comprobar" value="'.$data->estado.'"><span class="slider round"></span></label>';                
                return $boton_estado;
            })            
            ->addColumn('acciones', function($data){
                if($data->anotaciones == null || $data->anotaciones == ""){
                    $color = "#9e9e9e";
                    $estado_nota = "Agregar nota";
                }else{
                    $color = "#006cc6";
                    $estado_nota = "Ver nota";
                }
                $botones_acciones = '<a class="btn_modal_editar_credencial_revision" name="btn_modal_editar_credencial_revision" id="'.$data->id.'" title="Editar credenciales"><i class="material-icons" style="color:#9e9e9e;;cursor:pointer;">create</i></a>';
                $botones_acciones .= '&nbsp;<a class="btn_modal_nota_credencial_revision" name="btn_modal_anotacion_credencial_revision" id="'.$data->id.'" title="'.$estado_nota.'"><i class="material-icons" style="color:'.$color.';;cursor:pointer;">note_add</i></a>';
                return $botones_acciones;
            })
            ->rawColumns(['estado','acciones'])
            ->make(true);
        }
    }

    public function cambiar_estado_credencial(Request $request, $id){
        // $credencial = CheckCredential::find($id);
        // $credencial->fill($request->all());
        // $credencial->save();
        $credencial = CheckCredential::find($id);
        $credencial->update(['estado' => $request->estado]);
        $credencial->update(['fecha_fin' => $request->fecha_fin]);
    }

    public function editar_credencial_usuario(Request $request, $id){        
        $credencial_usuario = Credencial::find($id);        
        $credencial_usuario->update(['cedula' => $request->cedula]);
        $credencial_usuario->update(['nombre' => $request->nombre]);
        $credencial_usuario->update(['correo_institucional' => $request->correo_institucional]);
    }
}