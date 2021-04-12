<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['guest']], function () {
    Route::get('/escuelas/public', 'PublicController@index');
    Route::get('/talleres/public', 'PublicController@get');
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::post('/register', 'Auth\LoginController@register')->name('register');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/main', function () {
        $contents = view('contenido/contenido');
        $response = Response::make($contents, 200);
        $response->header('Expires', 'Tue, 1 Jan 1980 00:00:00 GMT');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->header('Pragma', 'no-cache');
        return $response;
        //return view('contenido/contenido');
    })->name('main');
    Route::group(['middleware' => ['Promotor']], function () {
        Route::get('/Proveedor', 'ProveedorController@index');
        Route::post('/Proveedor/registrar', 'ProveedorController@store');
        Route::put('/Proveedor/actualizar', 'ProveedorController@update');
        Route::get('/Proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/Proveedor/getProveedor', 'ProveedorController@getProveedor');
        Route::get('/Categoria', 'CategoriaController@index');
        Route::post('/Categoria/registrar', 'CategoriaController@store');
        Route::put('/Categoria/actualizar', 'CategoriaController@update');
        Route::put('/Categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/Categoria/activar', 'CategoriaController@activar');
        Route::get('/Categoria/selectCategoria', 'CategoriaController@selectCategoria');
        
        //diego
        Route::get('/Escuela/selectEscuela', 'EscuelaController@selectEscuela');
        Route::get('/Escuela', 'EscuelaController@index');


        Route::post('/Escuela/store', 'EscuelaController@store');        
        Route::put('/Escuela/update', 'EscuelaController@update');
        Route::put('/Escuela/disabled', 'EscuelaController@disabled');
        Route::put('/Escuela/enabled', 'EscuelaController@enabled');   
        
        Route::get('/Taller', 'TallerController@index');
        Route::put('/Taller/update', 'TallerController@update');
        Route::post('/Taller/store', 'TallerController@store');        
        Route::put('/Taller/disabled', 'TallerController@disabled');
        Route::put('/Taller/enabled', 'TallerController@enabled');

        Route::get('/Categoria', 'CategoriaController@index');
        Route::post('/Categoria/store', 'CategoriaController@store');
        Route::put('/Categoria/update', 'CategoriaController@update');
        Route::put('/Categoria/disabled', 'CategoriaController@disabled');
        Route::put('/Categoria/enabled', 'CategoriaController@enabled');
        /* fin de Diego */
    });
    Route::group(['middleware' => ['Estudiante']], function () {    
        
    });
    Route::group(['middleware' => ['Administrador']], function () {
        /* Promotor */
        Route::get('/Proveedor', 'ProveedorController@index');
        Route::post('/Proveedor/registrar', 'ProveedorController@store');
        Route::put('/Proveedor/actualizar', 'ProveedorController@update');
        Route::get('/Proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/Proveedor/getProveedor', 'ProveedorController@getProveedor');
        Route::get('/Categoria', 'CategoriaController@index');
        Route::post('/Categoria/registrar', 'CategoriaController@store');
        Route::put('/Categoria/actualizar', 'CategoriaController@update');
        Route::put('/Categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/Categoria/activar', 'CategoriaController@activar');
        Route::get('/Categoria/selectCategoria', 'CategoriaController@selectCategoria');
        
        //diego
        Route::get('/Escuela/selectEscuela', 'EscuelaController@selectEscuela');
        Route::get('/Escuela', 'EscuelaController@index');


        Route::post('/Escuela/store', 'EscuelaController@store');        
        Route::put('/Escuela/update', 'EscuelaController@update');
        Route::put('/Escuela/disabled', 'EscuelaController@disabled');
        Route::put('/Escuela/enabled', 'EscuelaController@enabled');   
        
        Route::get('/Taller', 'TallerController@index');
        Route::put('/Taller/update', 'TallerController@update');
        Route::post('/Taller/store', 'TallerController@store');        
        Route::put('/Taller/disabled', 'TallerController@disabled');
        Route::put('/Taller/enabled', 'TallerController@enabled');
        /*Nuevo*/
        Route::get('/Taller/getTaller', 'TallerController@get');
        Route::get('/Taller/getMatricula', 'TallerController@Matriculados');
        Route::post('/Taller/incripcion', 'TallerController@inscribir');
        /*Fin de Nuevo*/

        Route::get('/Categoria', 'CategoriaController@index');
        Route::post('/Categoria/store', 'CategoriaController@store');
        Route::put('/Categoria/update', 'CategoriaController@update');
        Route::put('/Categoria/disabled', 'CategoriaController@disabled');
        Route::put('/Categoria/enabled', 'CategoriaController@enabled');
        
        /* Fin de los Promotores */
        /* Proveedores */
        Route::get('/Proveedor', 'ProveedorController@index');
        Route::post('/Proveedor/store', 'ProveedorController@store');
        Route::put('/Proveedor/actualizar', 'ProveedorController@update');
        Route::put('/Proveedor/disabled', 'ProveedorController@disabled');
        Route::put('/Proveedor/enabled', 'ProveedorController@enabled');
        Route::get('/Proveedor/selectProveedor', 'ProveedorController@selectPro');

        //el pos xd
        Route::get('/Rol', 'RolController@index');
        Route::get('/Rol/selectRol', 'RolController@selectRol');
        //LOGIN OJO :3
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        

    });
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});


Route::get('/home', 'HomeController@index')->name('home');
//Usuarios
