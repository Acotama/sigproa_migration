@extends('plantilla.container')
@section('content')

    <style>
        body, html {
            background-image: linear-gradient(rgb(70, 130, 180), rgb(255, 255, 255));
            background-repeat: no-repeat;
            height: 100%;
        }
    </style>
    <br>
    <div class="row">
        <div class="">
            <img width="25%" height="25%" src="dist/img/user2-160x160.jpg">
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default" style="background-color: rgba(255, 255, 255, 0.6)">
                <div class="panel-heading" style="background-color: rgba(255, 255, 255, 0.6)">
                    <h4 style="opacity: 1"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;
                        Enviar Contraseña</h4>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('action' => 'HomeController@emailEnviar')) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">
                                    Correo Electronico *</label>
                                <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                            </span>
                                    {{ Form::email('email', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su Email')) }}
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
                            <button type="submit" class="btn btn-primary pull-right" id="btnRegistrarse">
                                Enviar Ahora
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop
