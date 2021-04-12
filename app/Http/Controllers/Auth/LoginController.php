<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Persona;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        
        return view('auth.login');
    } 
    public function login(Request $request){
        $this->validateLogin($request);
        if(Auth::attempt(['usuario' => $request->usuario, 'password' => $request->password, 'vigencia'=>1])){
            return redirect()->route('main');
        } 
        return back()
        ->withErrors(['usuario' => trans('auth.failed')])
        ->withInput(request(['usuario'])); //Recibe un paráetro y el error que vamos a mostrar
    }
    protected function validateLogin(Request $request){
        $this->validate($request,[
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
    protected function validateRegister(Request $request){
        $this->validate($request,[
            'nombres' => 'required|string',
            'passRegister' => 'required|string',
            'correo' => 'required|email|unique:entidad,email'
        ]);
    }
    public function register(Request $request){
        try {
            $persona = new Persona;
            $persona->nombre = $request->nombres . ' ' . $request->apellido;
            $persona->email = $request->correo;
            $persona->save();
            $user = new User;
            $user->usuario = $request->correo;
            $user->password = bcrypt($request->passRegister);
            $user->vigencia = '1';
            $user->idRoles = '3';
            $user->id = $persona->id;
            $user->save();
            return redirect('/login');
        } catch (Exception $ex) {
            return $ex;
        }
    }
}