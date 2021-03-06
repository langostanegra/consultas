<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
//Para importar los usuarios por medio de excel
use App\Imports\ImportarCredenciales;
Use Validator;


class ImportarCredencialesController extends Controller
{
    public function index(){
        return view('importar_credenciales.index');
    }

    public function importar_credenciales(Request $request){
        $validador = Validator::make($request->all(),[
            'file' => 'required|max:15000|mimes:xlsx,xls,csv'
        ]);

        try {
            if($validador->passes()){
                $file = $request->file('file');
                Excel::import(new ImportarCredenciales, $file);
                return redirect()->back()->with(['succes'=>"Usuarios importados de forma correcta"]);
            }else{
                return redirect()->back()->with(['errors'=>$validador->errors()->all()]);
            }
        }catch(\Exception $e){
            // Validación para determinar si los registros ya se encuentran en la base de datos
            if ($e instanceof \Illuminate\Database\QueryException) {
                return redirect()->back()->with('errors', ['El archivo contiene registros que ya se encuentran en la base de datos o el archivo tiene datos duplicados']);
            }
            
            // Validación para determinar si la plantilla se encuentra vacía
            if ($e instanceof \PhpOffice\PhpSpreadsheet\Exception) {
                return redirect()->back()->with('errors', ['El archivo no puede estar vacío']);
            }
            
            //Validación para determinar si el archivo si contiene la cabezera adecuada
            if ($e instanceof \ErrorException) {
                return redirect()->back()->with('errors', ['El archivo contiene una cabecera y/o registros inválidos']);
            }
        }
    }
}
