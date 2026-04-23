@extends('plantilla.container')
@section('content')
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
                    <h4 style="opacity: 1;font-size: 20px;"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;
                        Inicio de Sesión</h4>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url'=>'/login', 'method'=>'POST','class'=>'form-horizontal'))}}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <label class="sr-only">Usuario</label>
                        {{Form::text('username',null,array('class'=>'form-control', 'placeholder'=>'Usuario','style'=> 'text-transform: lowercase'))}}
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                        <label class="sr-only">Contraseña</label>
                        {{Form::password('password',array('class'=>'form-control', 'placeholder'=>'Contraseña', 'required'=>'true'))}}
                    </div>

                    @if(Session::has('mensaje_error'))
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <span id="mensaje" class="label label-danger">{{Session::get('mensaje_error')}}</span>
                            </div>
                        </div>
                    @endif
                    <br>


                    <div class="form-group last">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary center">
                                <span class="glyphicon glyphicon-ok"></span> Iniciar</button>
                            <!--button type="reset" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span> CANCELAR</button-->
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop
