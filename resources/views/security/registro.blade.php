@extends('plantilla.container')
@include('plantilla.topbar')
@section('content')
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
    <div class="col-md-8">
        <div class="well well-sm">
            {{ Form::open(array('action' => 'HomeController@registroCreate')) }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="userName">
                            DNI ó Nombre de Usuario *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                            </span>
                            {{ Form::text('userName', null, array('class' => 'form-control', 'placeholder'=>'Ingresar su DNI / Usuario')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">
                            Contraseña *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span>
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
                            {{ Form::select('idRol', $rolCombo, null, array('class' => 'form-control cboRol', 'placeholder'=>'Rol')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="idSector">
                            Sector / Unidad *</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span>
                            </span>
                            {{ Form::select('idSector', $sectorCombo, null, array('class' => 'form-control cboSector', 'placeholder'=>'Sector')) }}
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
                    <div class="form-group">
                        <label for="obligatorio">
                            * Obligatorio</label>
                        {{ Form::hidden('fecha', date("Y-m-d H:i:s"), null) }}
                        {{ Form::hidden('activo', 1, null) }}
                        {{ Form::hidden('estado', 1, null) }}
                    </div>
                    <div class="form-group">
                        Las <label>INSTITUCIONES</label> dentro de la jurisdicción del 
                        <label>GOBIERNO REGIONAL DE LIMA</label>
                        que desean participar en el proceso de 
                        PLANEAMIENTO ESTRATÉGICO deberán hacerlo mediante el ROL 
                        de <label>ORGANIZACIÓN</label>.
                        <br>
                        Los <label>CIUDADANOS</label> dentro de la jurisdicción del 
                        <label>GOBIERNO REGIONAL DE LIMA</label>
                        que desean participar en el proceso de 
                        PLANEAMIENTO ESTRATÉGICO deberán hacerlo mediante el ROL 
                        de <label>SOCIEDAD CIVIL</label>.
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
                <strong>Consultas al E-mail</strong><br>
                <a href="mailto:#">cesarmv0604@gmail.com</a>
            </address>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        comboUno();
        $(".cboRol").change(function () {
            var id = $(".cboRol option:selected").val();
            if (id == 3) {
                $(".cboEjecutora").val(1);
                $(".cboEjecutora").prop('disabled', true);
                $(".cboOrganica").prop('disabled', true);
            }
            else {
                $(".cboEjecutora").prop('disabled', false);
                $(".cboOrganica").prop('disabled', false);
            }
        });
        $(".cboSector").change(function () {
            var id = $(".cboSector option:selected").val();
            if (id == 0)
                comboUno();
            else {
                var sector = $(".cboSector option:selected").text();
                var idOrganica = parseInt(id) + 71;
                $(".cboOrganica").html('<option value="' + idOrganica + '">PARTICIPANTES - SECTOR ' + sector + '</option>');
            }
        });
        $(".cboEjecutora").change(function () {
            comboUno();
        });
    });
    ///////////////////////////////////////////////

    function comboUno() {
        var id1 = $(".cboSector option:selected").val();
        var id2 = $(".cboEjecutora option:selected").val();
        $.ajax({
            url: "{{URL::to('/combo/" + id1 + "/" + id2 + "')}}",
            success: function (data)
            {
                $(".cboOrganica").html(data);
            }
        });
    }

</script>
@stop