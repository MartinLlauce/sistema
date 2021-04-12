<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
<style>

@media screen and (max-width: 575px) {
    .form2{
       display:none!important;
    }
}

</style>
@extends('auth.inicioSesion')
@section('login')
<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card-group mb-0">
        <div class="card p-4">
        <form class="form-horizontal was-validated" method="POST" action="{{route('login')}}">
            {{ csrf_field() }}
            <div class="card-body">
                <h1>Acceder</h1>
                <p class="text-muted">Control de acceso al sistema</p>
                <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="feather icon-user-check" style="font-size: 20px; display:block; background:white;"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario', '<small class="text-danger">:message</small>')!!}
                </div>
                <div class="form-group mb-3{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="feather icon-unlock" style="font-size: 20px; display:block; background:white;"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="on">
                {!!$errors->first('password', '<small class="text-danger">:message</small>')!!}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block px-4">Iniciar Sesión</button>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center">
                <a href="#" data-toggle="modal" data-target="#register">Regístrate</a>
            </div>
        </form>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="register" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="text-align: justify;font-size: 17px;font-weight: 700;" id="exampleModalLongTitle">Registro de Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="" method="POST" action="{{route('register')}}">
                                {{ csrf_field() }}
                            <div class="row">   
                                <div class="col-md-6">
                                    <p class="mb-0"  style="font-size: 16px;font-weight: 600;" style="font-size: 16px;font-weight: 600;">Nombre</p>
                                    <input type="text" id="nombres" name="nombres" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0"  style="font-size: 16px;font-weight: 600;">Apellido</p>
                                    <input type="text" id="apellido" name="apellido" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0"  style="font-size: 16px;font-weight: 600;">Correo Institucional</p>
                                    <input type="text" id="correo" name="correo" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0"  style="font-size: 16px;font-weight: 600;">Contraseña</p>
                                    <input type="password" id="passRegister" name="passRegister" class="form-control">
                                </div>
                                <div class="col-md-12 d-flex mt-2">
                                    <button type="submit" class="ml-auto btn btn-primary">Registrar</button>
                                </div>
                                {!!$errors->first('message', '<small class="text-danger">:message</small>')!!}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="form2 card text-white py-5" style="width:44%;background-color:#043263;">
        <div class="card-body text-center d-flex justify-content-center align-items-center flex-column">
            <h1 style="font-weight: 900;color:white;font-family: 'Roboto Condensed', sans-serif;">Sistema Femec</h1>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
