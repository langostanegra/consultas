<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MakeEmailTemplate extends Model
{
    protected $fillable = [
        'nombre', 'plantilla'
    ];
}