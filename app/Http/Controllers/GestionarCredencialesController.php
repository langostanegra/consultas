<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Credencial;
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
}