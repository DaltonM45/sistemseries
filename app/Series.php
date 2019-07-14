<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'portada'
    ];

}
