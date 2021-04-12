<?php

namespace App\Http\Controllers;
use App\Escuela;
use App\Taller;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
        $aux = Escuela::all();
        return $aux;
    }
    public function get(){
        $aux = Taller::all();
        return $aux;
    }
}
