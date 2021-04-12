<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'taller';
    protected $primaryKey = 'idTaller';
    protected $fillable = [
        'idTaller',
        'nombreTaller',
        'nombrePonente',
        'idEscuela',
        'descripcion',
        'fecha',
        'hora',
        'foto',
        'agroup',
        'vigencia'
    ];
    public $timestamps = false;
}
