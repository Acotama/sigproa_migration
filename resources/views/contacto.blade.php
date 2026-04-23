@extends('plantilla.container')
@include('plantilla.topbar')
@section('content')
<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">Contáctanos</h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="well well-sm">
            {{ Form::open(array('action' => 'HomeController@contactoCreate')) }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">
                            Apellidos y Nombres *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                            </span>
                            {{ Form::text('apellidosNombres', null, array('class' => 'form-control', 'placeholder'=>'Ingresar Apellidos y Nombres')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">
                            Correo Electronico *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                            </span>
                            {{ Form::email('email', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su Correo Electronico')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">
                            Asunto *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-exclamation-sign"></span>
                            </span>
                            {{ Form::text('asunto', null, array('class' => 'form-control', 'placeholder'=>'Ingresar el Asunto')) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="message">
                            Mensaje *</label>
                        {{ Form::textarea('mensaje', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su Mensaje', 'rows'=>8)) }}
                    </div>
                </div>

                <div class="col-md-12">
                    @if(Session::has('mensaje_error'))
                    <div class="alert alert-danger">{{Session::get('mensaje_error')}}</div>
                    @endif
                    @if(Session::has('mensaje_exito'))
                    <div class="alert alert-success">{{Session::get('mensaje_exito')}}</div>
                    @endif
                    <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                        Enviar mensaje
                    </button>
                </div>              
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="col-md-4">
        <form>
            <legend><span class="glyphicon glyphicon-globe"></span> GERENCIA REGIONAL DE PLANEAMIENTO, PRESUPUESTO Y ACONDICIONAMIENTO TERRITORIAL</legend>
            <address>
                <strong>Av. Tupac Amaru 405 - Huacho</strong><br>
                N° de RUC: 20530688390<br>
                Telefono: 232-3197 / 232-5999<br>
            </address>
            <address>
                <strong>E-mail</strong><br>
                <a href="mailto:#">cesarmv0604@gmail.com</a>
            </address>
        </form>
    </div>
</div>
@stop