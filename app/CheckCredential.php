<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckCredential extends Model
{
    protected $fillable = [
        'cedula', 'nombre', 'correo_institucional', 'usuario_medellin', 'password_medellin', 'estado', 'nota', 'fecha_inicio', 'fecha_fin',
    ];
}
