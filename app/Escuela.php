<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    protected $table = 'escuelas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 
        'nombreEscuela' ,
        'siglas', 
        'descripcion', 
        'foto',
        'vigencia'
    ];
    public $timestamps = false;
}
