<?php

namespace App\Imports;

use App\Credencial;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ImportarUsuarios implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Credencial([
            'cedula' => $row['cedula'],
            'nombre' => $row['nombre'],
            'correo_institucional' => $row['correo_institucional'],
            'usuario_medellin' => $row['usuario_medellin'],
            'password_medellin' => $row['password_medellin'],
            'estado' => $row['estado'],
        ]);
    }
}
