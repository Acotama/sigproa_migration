@extends('plantilla.container')
@include('plantilla.topbar')
@section('content')

<style>
    .jumbotron { 
        background: #428BCA;
        color: white;
    }
    .input-group-addon{
       background: #428BCA;
       color: white;
       padding: 6px 40px
    }

</style>

<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">Registro de Usuario</h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="well well-sm">
             <div class="row">
                <div class="col-md-6">
                    
                    <div class="form-group">
                        <label for="userName">
                            DNI ó Nombre de Usuario *</label>
                        <div class="input-group">
                            <span class="input-group-addon">NOMBRE DEL PROYECTO
                            </span>
                            {{ Form::text('userName', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su DNI / Usuario')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">
                            Contraseña *</label>
                        <div class="input-group">
                            <span class="input-group-addon">DEPARTAMENTO      
                            </span>
                            {{ Form::password('password', array('class' => 'form-control', 'placeholder'=>'Ingresar una Contraseña (6 caracteres minimo)')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">
                            Confirmar Contraseña *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span>
                            </span>
                            {{ Form::password('password_confirm', array('class' => 'form-control', 'placeholder'=>'Repetir la Contraseña (6 caracteres minimo)')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">
                            Apellidos </label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span>
                            </span>
                            {{ Form::text('apellidos', null, array('class' => 'form-control', 'placeholder'=>'Ingresar sus Apellidos')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombres">
                            Nombres </label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span>
                            </span>
                            {{ Form::text('nombres', null, array('class' => 'form-control', 'placeholder'=>'Ingresar sus Nombres')) }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="idRol">
                            Rol de Participación *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-wrench"></span>
                            </span>
                            {{ Form::select('idRol', array(), null, array('class' => 'form-control cboRol', 'placeholder'=>'Rol')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="idSector">
                            Sector / Unidad *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span>
                            </span>
                            {{ Form::select('idSector', array(), null, array('class' => 'form-control cboSector', 'placeholder'=>'Sector')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">
                            Correo Electrónico * (Ej. micorreo@mail.com)</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                            </span>
                            {{ Form::email('email', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su Email')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="orgnaizacion">
                            Organización  / Institución</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span>
                            </span>
                            {{ Form::text('organizacion', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su Organizacion / Institucion')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="celular">
                            Número de Celular</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span>
                            </span>
                            {{ Form::text('celular', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su Celular')) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @if(Session::has('mensaje_error'))
                    <div class="alert alert-danger">{{Session::get('mensaje_error')}}</div>
                    @endif
                    @if(Session::has('mensaje_exito'))
                    <div class="alert alert-success">{{Session::get('mensaje_exito')}}</div>
                    @endif
                    <a class="btn btn-success" href="{{URL::to('/')}}">
                        <span class="glyphicon glyphicon-arrow-left"></span> VOLVER AL INICIO
                    </a>
                    <button type="submit" class="btn btn-primary pull-right" id="btnRegistrarse">
                        <span class="glyphicon glyphicon-pencil"></span> REGISTRARSE AHORA!
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop