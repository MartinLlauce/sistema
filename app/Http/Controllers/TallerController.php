<?php

namespace App\Http\Controllers;
use App\Taller;
use App\Listado;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function get(Request $request){
        if(!$request->ajax()) return redirect('/');
        $taller = Taller::leftJoin('listado', 'listado.idTaller', '=', 'taller.idTaller')
        ->join('entidad', 'entidad.id', '=', 'listado.idPersona')
        ->select('taller.idTaller', 
        'taller.nombreTaller', 
        'taller.nombrePonente', 
        'taller.idEscuela', 
        'taller.descripcion', 
        'taller.fecha', 
        'taller.hora', 
        'taller.foto', 
        'taller.agroup',
        'taller.vigencia as vigencia_taller',
        'listado.idListado')
        ->orderBy('taller.idTaller', 'asc')
        ->where('listado.idPersona', '!=', \Auth::user()->id)
        ->where('entidad.id', '!=', \Auth::user()->id)
        ->where('taller.vigencia','=','1')->get();
        return $taller;
    }
    public function Matriculados(Request $request){
        if(!$request->ajax()) return redirect('/');
        $taller = Taller::leftJoin('listado', 'listado.idTaller', '=', 'taller.idTaller')
        ->select('taller.idTaller', 
        'taller.nombreTaller', 
        'taller.nombrePonente', 
        'taller.idEscuela', 
        'taller.descripcion', 
        'taller.fecha', 
        'taller.hora', 
        'taller.foto', 
        'taller.agroup',
        'taller.vigencia as vigencia_taller' ,)
        ->orderBy('taller.idTaller', 'asc')
        ->where('listado.idPersona', '=', \Auth::user()->id)
        ->where('taller.vigencia','=','1')->get();
        return $taller;
    }
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $taller = Taller::join('escuelas', 'escuelas.id', '=', 'taller.idEscuela')->select('idTaller', 
        'taller.nombreTaller', 
        'taller.nombrePonente', 
        'taller.idEscuela', 
        'taller.descripcion', 
        'taller.fecha', 
        'taller.hora', 
        'taller.foto', 
        'taller.agroup',
        'taller.vigencia as vigencia_taller' ,
        'escuelas.siglas',
        'escuelas.nombreEscuela',
        'escuelas.id as idEscuela')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $taller->total(),
                'current_page'      => $taller->currentPage(),
                'per_page'          => $taller->perPage(),
                'last_page'         => $taller->lastPage(),
                'from'              => $taller->firstItem(),
                'to'                => $taller->lastItem(),
            ], 'taller' => $taller
        ];
    }
    public function inscribir(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $listado = new Listado();
            $listado->idPersona = \Auth::user()->id;
            $listado->idTaller = $request->idTaller;
            $listado->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
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
            
            $taller = new Taller();
            $taller->nombreTaller = $request->nombreTaller;
            $taller->nombrePonente = $request->nombrePonente;
            $taller->idEscuela = $request->idEscuela;
            $taller->agroup = $request->idEscuela;
            $taller->descripcion = $request->descripcion;
            $taller->fecha = $request->fecha;            
            $taller->hora = $request->hora;
            $taller->foto = $fileName;
            $taller->save();
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
            $taller = Taller::findOrFail($request->idTaller);
            if($taller->foto != $request->foto){
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
                $taller->foto = $fileName;
                $taller->save();
            }
            $taller = Taller::findOrFail($request->idTaller);
            $taller->nombreTaller = $request->nombreTaller;
            $taller->nombrePonente = $request->nombrePonente;
            $taller->idEscuela = $request->idEscuela;
            $taller->agroup = $request->idEscuela;
            $taller->descripcion = $request->descripcion;
            $taller->fecha = $request->fecha;            
            $taller->hora = $request->hora; 
            $taller->save();
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
            $taller = Taller::findOrFail($request->id);
            $taller->vigencia = 0;
            $taller->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function enabled(Request $request){
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $taller = Taller::findOrFail($request->id);
            $taller->vigencia = 1;
            $taller->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}