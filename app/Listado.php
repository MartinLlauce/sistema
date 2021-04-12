<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listado extends Model
{
    protected $table = 'listado';
    protected $primaryKey = 'idListado';
    protected $fillable = [
        'idPersona',
        'idTaller'
    ];
}
