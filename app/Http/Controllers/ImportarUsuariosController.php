<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
//Para importar los usuarios por medio de excel
use App\Imports\ImportarUsuarios;
Use Validator;

class ImportarUsuariosController extends Controller
{
    public function index(){
        return view('importar_usuarios.index');
    }

    public function importar_usuarios(Request $request){          
        $validador = Validator::make($request->all(),[
            'file' => 'required|max:15000|mimes:xlsx,xls,csv'
        ]);

        try {
            if($validador->passes()){
                $file = $request->file('file');
                Excel::import(new ImportarUsuarios, $file);
                return redirect()->back()->with(['succes'=>"Usuarios importados de forma correcta"]);
            }else{
                return redirect()->back()->with(['errors'=>$validador->errors()->all()]);
            }
        }catch(\Exception $e){
            // return redirect()->back()->with(['errors'=>$e]);
            if ($e instanceof \Illuminate\Database\QueryException) {
                return redirect()->back()->with('errors', ['La plantilla contiene registros que ya se encuentran en la base de datos']);
            }

            if ($e instanceof \PhpOffice\PhpSpreadsheet\Exception) {
                return redirect()->back()->with('errors', ['La plantilla no puede estar vacía']);
            }
            
            if ($e instanceof \ErrorException) {
                return redirect()->back()->with('errors', ['El archivo contiene una cabecera y/o registros inválidos']);
            }
        }
    }
}