@extends('starter')
@section('body')
<div class="col-sm-12 main">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title"><h2><center>CAMBIAR CONTRASEÑA</center></h2></div>
            </div> 
            <form action="{{ action('HomeController@passwordUpdate', Auth::user()->idusuario) }}" method='POST'>
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4"><label for="password">Anterior Password:</label></div>
                        <div class="col-sm-4"><input type="password" name="password" class="form-control"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><label for="password_new">Nuevo Password:</label></div>
                        <div class="col-sm-4"><input type="password" name="password_new" class="form-control"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><label for="password_confirm">Confirmar Password:</label></div>
                        <div class="col-sm-4"><input type="password" name="password_confirm" class="form-control"></div>
                    </div>
                </div>
                @if(Session::has('mensaje_error'))
                <div class="alert alert-danger">{!!Session::get('mensaje_error')!!}</div>
                @endif
                @if(Session::has('mensaje_exito'))
                <div class="alert alert-success">{!!Session::get('mensaje_exito')!!}</div>
                @endif
                <div class="modal-footer">
                    <a type="button" class="btn btn-success" href="{!!URL::to('/inicio')!!}"><span class="glyphicon glyphicon-home"></span> INICIO</a>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop