@extends('starter')
@section('body')
<div class="col-sm-12 main">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title"><h2><center>DATOS PERSONALES</center></h2></div>
            </div> 
            {{ Form::model($data, array('method' => 'POST', 'action' => array('HomeController@perfilUpdate', $data->idusuario))) }}
            <div class="modal-body">                
                <div class="row form-group">
                    <div class="col-md-4">{{ Form::label('username', 'Usuario:') }}</div>
                    <div class="col-md-4">{{ Form::text('username', null, array('class' => 'form-control', 'disabled' => 'disabled')) }}</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">{{ Form::label('email', 'Email:') }}</div>
                    <div class="col-md-4">{{ Form::text('email', null, array('class' => 'form-control')) }}</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">{{ Form::label('dni', 'DNI:') }}</div>
                    <div class="col-md-4">{{ Form::text('dni', null, array('class' => 'form-control')) }}</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">{{ Form::label('apellidos', 'Apellidos:') }}</div>
                    <div class="col-md-4">{{ Form::text('apellidos', null, array('class' => 'form-control')) }}</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">{{ Form::label('nombres', 'Nombres:') }}</div>
                    <div class="col-md-4">{{ Form::text('nombres', null, array('class' => 'form-control')) }}</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">{{ Form::label('cargo', 'Cargo:') }}</div>
                    <div class="col-md-4">{{ Form::text('cargo', null, array('class' => 'form-control')) }}</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">{{ Form::label('celular', 'Celular:') }}</div>
                    <div class="col-md-4">{{ Form::text('celular', null, array('class' => 'form-control')) }}</div>
                </div>
            </div>
            @if(Session::has('mensaje_error'))
            <div class="alert alert-danger">{!!Session::get('mensaje_error')!!}</div>
            @endif
            @if(Session::has('mensaje_exito'))
            <div class="alert alert-success">{!!Session::get('mensaje_exito')!!}</div>
            @endif
            <div class="modal-footer">
                <a type="button" class="btn btn-success" href="{{URL::to('/inicio')}}"><span class="glyphicon glyphicon-home"></span> INICIO</a>
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#combo1").change(function () {
            comboUno();
        });
        $("#combo2").change(function () {
            comboDos();
        });
    });

    function comboUno() {
        $("#combo1 option:selected").each(function () {
            var id = $(this).val();
            $.ajax({
                url: "{{URL::to('/perfil/comboProvincia/" + id + "')}}",
                success: function (data)
                {
                    $("#combo2").html(data);
                }
            });
        });
    }
    function comboDos() {
        $("#combo2 option:selected").each(function () {
            var id = $(this).val();
            $.ajax({
                url: "{{URL::to('/perfil/comboDistrito/" + id + "')}}",
                success: function (data)
                {
                    $("#combo3").html(data);
                }
            });
        });
    }
</script>
@stop

