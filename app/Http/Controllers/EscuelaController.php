<?php

namespace App\Http\Controllers;

use App\Escuela;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EscuelaController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $escuelas = Escuela::select('id', 'nombreEscuela', 'siglas', 'foto', 'descripcion', 'vigencia')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $escuelas->total(),
                'current_page'      => $escuelas->currentPage(),
                'per_page'          => $escuelas->perPage(),
                'last_page'         => $escuelas->lastPage(),
                'from'              => $escuelas->firstItem(),
                'to'                => $escuelas->lastItem(),
            ], 'escuelas' => $escuelas
        ];
    }
    public function selectEscuela(Request $request){
        $escuela = Escuela::select('id', 'nombreEscuela')->where('vigencia', '=', 1)->get();
        return ['escuela' => $escuela];
    }    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $exploded = explode(',', $request->imagen);
            $decoded = base64_decode($exploded[1]);
            /* $extension = $exploded[0]; */
            if(str_contains($exploded[0], 'jpeg')){
                $extension = 'jpg';
            }else{
                $extension = 'png';
            }
            $fileName = str_random().'.'.$extension;
            $path = public_path().'/img/'.$fileName;
            file_put_contents($path, $decoded);

            $escuela = new Escuela();
            $escuela->nombreEscuela = $request->nombreEscuela;
            $escuela->siglas = $request->siglas;            
            $escuela->descripcion = $request->descripcion;
            $escuela->foto = $fileName;
            $escuela->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $escuela = Escuela::findOrFail($request->id);
            if($escuela->foto != $request->foto){
                $exploded = explode(',', $request->foto);
                $decoded = base64_decode($exploded[1]);
                /* $extension = $exploded[0]; */
                if(str_contains($exploded[0], 'jpeg')){
                    $extension = 'jpg';
                }else{
                    $extension = 'png';
                }
                $fileName = str_random().'.'.$extension;
                $path = public_path().'/img/'.$fileName;
                file_put_contents($path, $decoded);    
                $escuela->foto = $fileName;
                $escuela->save();
            }
            $escuela = Escuela::findOrFail($request->id);
            $escuela->nombreEscuela = $request->nombreEscuela;
            $escuela->siglas = $request->siglas;            
            $escuela->descripcion = $request->descripcion;            
            $escuela->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function disabled(Request $request){
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $escuela = Escuela::findOrFail($request->id);
            $escuela->vigencia = 0;
            $escuela->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function enabled(Request $request){
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $escuela = Escuela::findOrFail($request->id);
            $escuela->vigencia = 1;
            $escuela->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}
