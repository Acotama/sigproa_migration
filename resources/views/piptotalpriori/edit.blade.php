@extends('starter')
@section('htmlhead')
    <!-- JqueryUI -->
    <link rel="stylesheet" href="{{ asset('librerias/jquery-ui/themes/redmond/jquery-ui.min.css') }}">
    <!-- DROPZONE -->
    <link rel="stylesheet" href="{{ asset('librerias/dropzone/dropzone.min.css') }}">



    <style>
        /*REWRITING TEXTBOX STYLES */
        /* TEXTBOX */

        .form-control,
        .input-group-addon {
            border-color: black !important;
        }

        /*******************************/
        .panel {
            background-color: rgb(209, 227, 243);
        }

        #map {
            width: 90%;
            height: 400px !important;
        }

        .nav>li {
            color: white;
        }

        .nav>li:hover {
            color: white;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        .prior {
            background-color: red !important;
        }

        .wrapColumnTextEtapa {
            white-space: normal !important;
            height: auto;
        }

        .wrapColumnText {
            white-space: normal !important;
            height: auto;
            padding: 4px !important;
        }

        #gview_tblObras .ui-jqgrid-title {
            color: black;
        }

        #gview_tblObras .ui-widget-header {
            background: white !important;
        }

        /* SCROLLBAR JQGRID */
        .gridWrapper {
            width: 100%;
            overflow: auto;
            /* <---set the overflow to auto*/
        }

        .ui-jqgrid-bdiv {
            max-height: 600px;
        }

        /* MULTILINE HEADER */
        th.ui-th-column div {
            white-space: normal !important;
            height: auto !important;
            padding: 2px !important;
        }

        .error {
            border: 2px solid !important;
            border-color: #c51919 !important;
        }

        .fixed {
            position: fixed;
            top: 0;
            z-index: 1040;
            background-color: rgb(209, 227, 243);
        }
    </style>
@endsection
@section('body')
    <?php
    set_time_limit(600000);
    ?>
    <div class="col-md-12 main">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h2>
                            <center>ACTUALIZACIÓN PROYECTO DE INVERSIÓN</center>
                        </h2>
                    </div>
                </div>

                <div class="modal-body">
                    @if (Session::has('mensaje_error'))
                        <div class="alert alert-danger">{!! Session::get('mensaje_error') !!}</div>
                        <script>
                            swal(
                                'Error al guardar la información',
                                'Revise los errores en la parte superior del formulario!',
                                'error'
                            );
                        </script>
                    @endif
                    @if (Session::has('mensaje_exito'))
                        <div class="alert alert-success">{!! Session::get('mensaje_exito') !!}</div>
                        <script>
                            swal(
                                'Actualizado',
                                'Los cambios se guardaron exitosamente!',
                                'success'
                            );
                        </script>
                    @endif
                    <br>
                    <div class="row" style="margin: 10px;">
                        <a type="button" class="btn btn-danger pull-right" href="{{ URL::to('/piptotalpriori') }}"><span
                                class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                    </div>
                    <div id="fixedOnScroll">
                        <br>
                        <div class="row">
                            <div class="col-md-offset-1 col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="cod_sni">Codigo Snip:</label>
                                    </span>
                                    <label for="cod_snip" class="form-control" readonly>{{ $data['cod_snip'] }}</label>
                                </div>
                            </div>
                            <div class="col-md-offset-3 col-md-3">
                                <div class="input-group">
                                    <span
                                        class="input-group-addon">{{ Form::label('cod_unif', 'Codigo Unificado:') }}</span>
                                    {{ Form::label('', $data['cod_unif'], ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <center>
                                <div style="width: 90%;">
                                    <div class="input-group">
                                        <span
                                            class="input-group-addon">{{ Form::label('nom_proyec', 'Nombre del Proyecto:') }}</span>
                                        {{ Form::textarea('', $data['nom_proyec'], ['class' => 'form-control', 'readonly' => 'readonly', 'cols' => 3, 'rows' => 3]) }}
                                    </div>
                                </div>
                            </center>
                        </div>
                        <br>
                    </div>
                    <script type="text/javascript">
                        $(window).scroll(function() {
                            if ($(this).scrollTop() > 300) {
                                var container_width = $(".main .row").width();
                                $('#fixedOnScroll').addClass('fixed').css('width', container_width - 17);
                            } else {
                                $('#fixedOnScroll').removeClass('fixed');
                            }
                        });
                    </script>

                    <br>
                    <div>
                        <ul class="nav nav-pills" role="tablist" style="color:white;">
                            <li role="presentation" class="active" style="background-color:#337ab7"><a href="#tecnico"
                                    aria-controls="tecnico" role="tab" data-toggle="tab">Datos Tecnicos PIP</a></li>
                            <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#galeria"
                                    id="tabGaleria" aria-controls="galeria" role="tab" data-toggle="tab">Galeria de
                                    Fotos PIP</a></li>
                            <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#ubicacion"
                                    id="tabUbicacion" aria-controls="ubicacion" role="tab" data-toggle="tab">Ubicacion
                                    del PIP</a></li>

                        </ul>
                        <?php //if(Auth::user()->ability('xcxcv',array('image-upload'),$options = array('validate_all' => true))){ echo("disabled");}
                        ?>

                        <div class="tab-content">
                            @permission('pi-list')
                                <div role="tabpanel" class="tab-pane active" id="tecnico">
                                    {{ Form::model($data, ['method' => 'POST', 'action' => ['PipTotalPrioriController@update', $data->id]]) }}
                                    <br>
                                    <input type=hidden id="id" name="id" value="{{ $data['id'] }}" />
                                    {{ Form::hidden('idusuario', Auth::user()->idusuario) }}
                                    <br>
                                    <h3><b>DATOS GENERALES</b></h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">{{ Form::label('sector', 'Sector:') }}</span>
                                                {{ Form::text('sector', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">{{ Form::label('progr', 'Programa:') }}</span>
                                                {{ Form::text('progr', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('sub_progr', 'Sub Programa:') }}</span>
                                                {{ Form::text('sub_progr', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('u_formul', 'Unidad Formuladora:') }}</span>
                                                {{ Form::textarea('u_formul', null, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '2']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('u_ejec', 'Unidad Ejecutora:') }}</span>
                                                {{ Form::text('u_ejec', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('ger_direc', 'Gerencia/Dirección:') }}</span>
                                                {{ Form::select(
                                                    'ger_direc',
                                                    [
                                                        '' => 'Seleccione una opción',
                                                        'GERENCIA REGIONAL DE INFRAESTRUCTURA' => 'GERENCIA REGIONAL DE INFRAESTRUCTURA',
                                                        'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES' => 'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES',
                                                        'DIRECCION REGIONAL DE AGRICULTURA' => 'DIRECCION REGIONAL DE AGRICULTURA',
                                                        'GERENCIA SUB REGIONAL LIMA SUR' => 'GERENCIA SUB REGIONAL LIMA SUR',
                                                        'GERENCIA REGIONAL DE DESARROLLO SOCIAL' => 'GERENCIA REGIONAL DE DESARROLLO SOCIAL',
                                                        'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' => 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                                                        'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE' =>
                                                            'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE',
                                                    ],
                                                    null,
                                                    ['class' => 'form-control'],
                                                ) }}
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        {{ Form::hidden('nom_dpto', null, null) }}
                                        {{ Form::hidden('cod_dpto', null, null) }}

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('cod_dpto', 'Nombre Departamento:') }}</span>
                                                {{ Form::label('', 'LIMA', ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                            </div>
                                        </div>
                                        {{ Form::hidden('nom_prov', null, null) }}
                                        {{ Form::hidden('cod_prov', null, null) }}

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('cod_prov', 'Nombre Provincia:') }}</span>
                                                {{ Form::select('cod_prov', $provCombo, null, ['class' => 'form-control', 'id' => 'combo2']) }}
                                            </div>
                                        </div>

                                        {{ Form::hidden('nom_dist', null, null) }}
                                        {{ Form::hidden('cod_dist', null, null) }}

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('cod_dist', 'Nombre Distrito:') }}</span>
                                                {{ Form::select('cod_dist', $disCombo, null, ['class' => 'form-control', 'id' => 'combo3']) }}
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('nom_cp', 'Nombre Centro Poblado:') }}</span>
                                                {{ Form::text('nom_cp', null, ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12" style="height: 350px;overflow: scroll;">
                                            <!-- style="height: 350px;overflow: scroll;" -->
                                            @if (!empty($Alcance))
                                                <h4><b>ALCANCE</b></h4>

                                                <table
                                                    style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 14px;white-space:nowrap"
                                                    border="1">
                                                    <thead style="background-color:#337ab7;color:white">
                                                        <tr>
                                                            <th style="width: 1%;text-align:center;font-size: 15px">
                                                                Departamento</th>
                                                            <th style="width: 1%;text-align:center;font-size: 15px">Provincia
                                                            </th>
                                                            <th style="width: 1%;text-align:center;font-size: 15px">Distrito
                                                            </th>
                                                            <th style="width: 1%;text-align:center;font-size: 15px">Localidad
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="font-size:18px;">
                                                        @foreach ($Alcance as $row)
                                                            <tr>
                                                                <td style="white-space: nowrap;text-align:center;">
                                                                    {{ $row->departamento }}</td>
                                                                <td style="white-space: nowrap;text-align:center;">
                                                                    {{ $row->provincia }}</td>
                                                                <td style="white-space: nowrap;text-align:center;">
                                                                    {{ $row->distrito }}</td>
                                                                <td style="white-space: nowrap;text-align:center;">
                                                                    {{ $row->localidad }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>

                                    <br>
                                    <h3><b>DATOS FINANCIEROS</b></h3>
                                    <h5><b>Actualizado al: {{ $data['f_deveng_a'] }}</b></h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('m_pip', 'Monto de Inversión Total:') }}</span>
                                                <label class="form-control">{{ number_format($data['m_pip'], 2) }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('m_viab', 'Monto Viable:') }}</span>
                                                <label class="form-control">{{ number_format($data['m_viab'], 2) }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('m_exptec', 'Monto Exp. Tec.:') }}</span>
                                                <label class="form-control">{{ number_format($data['m_exptec'], 2) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8 table table-responsive">
                                            <table id="strip"
                                                style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 14px;white-space:nowrap"
                                                border="1">
                                                <thead style="background-color:#337ab7;color:white">
                                                    <tr>
                                                        <th style="width: 1%;text-align:center;font-size: 15px">AÑO</th>
                                                        <th style="width: 1%;text-align:center;font-size: 15px">PIM</th>
                                                        <th style="width: 1%;text-align:center;font-size: 15px">PIM ACUMULADO
                                                        </th>
                                                        <th style="width: 1%;text-align:center;font-size: 15px">DEVENGADO</th>
                                                        <th style="width: 1%;text-align:center;font-size: 15px">DEV. ACUMULADO
                                                        </th>
                                                        <th style="width: 1%;text-align:center;font-size: 15px">% AVANCE
                                                            FINANCIERO DE LA OBRA</th>
                                                        <th style="width: 1%;text-align:center;font-size: 15px">% AVANCE
                                                            FINANCIERO DEL PROYECTO</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='str' style="font-size:18px;">
                                                    <tr>
                                                        <td style="white-space: nowrap;text-align:right;">
                                                            {{ $data['ult_anio_ejec_pry_financ'] }}</td>
                                                        <td style="white-space: nowrap;text-align:right;">
                                                            {{ number_format($data['m_pim'], 2) }}</td>
                                                        <td style="white-space: nowrap;text-align:right;">
                                                            {{ number_format($data['m_pim_acu'], 2) }}</td>
                                                        <td style="white-space: nowrap;text-align:right;">
                                                            {{ number_format($data['m_deveng'], 2) }}</td>
                                                        <td style="white-space: nowrap;text-align:right;">
                                                            {{ number_format($data['m_deveng_a'], 2) }}</td>
                                                        <td style="white-space: nowrap;text-align:right;">
                                                            {{ number_format($data['a_financ'], 2) }}</td>
                                                        <td style="white-space: nowrap;text-align:right;">
                                                            {{ number_format($data['a_financ_a'], 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4"><br>
                                            <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                                data-target="#m_infFin"><i class="fa fa-files-o"></i> Detalle</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if (!empty($Transferencia))
                                            <div class="col-md-4"><br>
                                                <button type="button" class="btn btn-success btn-md" data-toggle="modal"
                                                    data-target="#m_Transferencias"><i class="fa fa-money"
                                                        aria-hidden="true"></i> Transferencias</button>
                                            </div>
                                        @endif
                                    </div>
                                    <!--div class="row">
                                      <div class="col-md-12">
                                      @if (!empty($PMultianual))
        <h4><b>El Proyecto Está Incluido en Programación Multianual 2018 - 2020</b></h4>
                                        <table style="width: 100%; font-size:12px;border-color: black;text-align: left;font-size: 14px" border="1">
                                            <thead style="background-color:#337ab7;color:white">
                                                <th style="width: 20%;text-align:center;font-size: 15px">Costo De Inversión (S/.)</th>
                                                <th style="width: 20%;text-align:center;font-size: 15px">2018 (S/.)</th>
                                                <th style="width: 20%;text-align:center;font-size: 15px">2019 (S/.)</th>
                                                <th style="width: 20%;text-align:center;font-size: 15px">2020 (S/.)</th>
                                              </tr>
                                            </thead>
                                            <tbody style="font-size:18px;">
                                              <tr>
                                                  <td style="text-align: right">{{ number_format($data['m_pip'], 2) }}</td>
                                        @foreach ($PMultianual as $pm)
        @if ($pm->year == 2018)
        <td style="text-align: right">{{ number_format($pm->monto, 2) }}</td>
        @endif
        @endforeach
                                        @foreach ($PMultianual as $pm)
        @if ($pm->year == 2019)
        <td style="text-align: right">{{ number_format($pm->monto, 2) }}</td>
        @endif
        @endforeach
                                        @foreach ($PMultianual as $pm)
        @if ($pm->year == 2020)
        <td style="text-align: right">{{ number_format($pm->monto, 2) }}</td>
        @endif
        @endforeach
                                              </tr>
                                            </tbody>
                                        </table>
        @endif
                                      </div>
                                    </div-->

                                    <!-- Modal -->

                                    <!-- INFORMACION FINANCIERA/ Large modal -->
                                    <div id="m_infFin" class="modal fade" tabindex="-1" data-width="760"
                                        style="top:45%;outline: none;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">×</button>
                                            <h3>Información Financiera</h3>
                                        </div>
                                        <div class="modal-body">
                                            <table id="strip"
                                                style="width: 100%; font-size:12px;border-color: black;text-align: left;font-size: 14px"
                                                border="1">
                                                <thead style="background-color:grey;color:white">
                                                    <tr>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">EJECUTORA
                                                        </th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">AÑO</th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">PIA</th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">PIM</th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">CERTIFICACIÓN
                                                        </th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">DEVENGADO
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id='str'>
                                                    @if (!empty($InfFinanciera))
                                                        @foreach ($InfFinanciera as $if)
                                                            <tr>
                                                                <td>{{ $if['uni_ejec'] }}</td>
                                                                <td>{{ $if['anio_financ'] }}</td>
                                                                <td style="text-align: right">
                                                                    {{ number_format($if['pia'], 2) }}</td>
                                                                <td style="text-align: right">
                                                                    {{ number_format($if['pim'], 2) }}</td>
                                                                <td style="text-align: right">
                                                                    {{ number_format($if['certif'], 2) }}</td>
                                                                <td style="text-align: right">
                                                                    {{ number_format($if['dev'], 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="6" style="text-align: center;"><b>No Se Encontró
                                                                    Información Financiera</b></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <p class="pull-left"><b>Fuente:</b><span>Aplicativo Informático SOSEM</span></p>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    <!-- TRANSFERENCIAS/ Large modal -->
                                    <div id="m_Transferencias" class="modal fade" tabindex="-1" data-width="760"
                                        style="top:45%;outline: none;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">×</button>
                                            <h3>Información Financiera</h3>
                                        </div>
                                        <div class="modal-body">
                                            <table id="strip"
                                                style="width: 100%; font-size:12px;border-color: black;text-align: left;font-size: 14px"
                                                border="1">
                                                <thead style="background-color:grey;color:white">
                                                    <tr>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">Decreto</th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">Fecha de
                                                            Aprobación</th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">Monto de
                                                            Transferencia - 2017</th>
                                                        <th style="width: 30px;text-align:center;font-size: 15px">Descripción
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id='str'>
                                                    @if (!empty($Transferencia))
                                                        @foreach ($Transferencia as $t)
                                                            <tr>
                                                                <td>{{ $t->nombre }}</td>
                                                                <td style="text-align: right">{{ $t->fecha }}</td>
                                                                <td style="text-align: right">S/. {{ $t->monto }}</td>
                                                                <td>{{ $t->definicion }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <!--p class="pull-left"><b>Fuente:</b><span>Aplicativo Informático SOSEM</span></p-->
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>

                                    <br>
                                    <h3><b>ESTADO SITUACIONAL DEL PROYECTO</b></h3>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('est_pry', 'Estado Proyecto:') }}</span>
                                                {{ Form::text('est_pry', null, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('anio_ini_pry', ' Año de inicio de la ejecución del Proyecto:') }}</span>
                                                {{ Form::text('anio_ini_pry', null, ['class' => 'form-control']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('tipo_pry', 'Tipo de Proyecto:') }}</span>
                                                    {{ Form::select('tipo_pry', ['' => '', 'PIC' => 'PIC', 'PIP' => 'PIP'], $data['tipo_pry'], ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('estado_antiguedad_pry', 'Estado Antiguedad Proyecto:') }}</span>
                                                {{ Form::select('estado_antiguedad_pry', $estAntigCombo, null, ['class' => 'form-control', 'id' => 'ddlestado_antiguedad_pry']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">{{ Form::label('etapa', 'Estado:') }}</span>
                                                {{ Form::select('etapa', ['' => '--Seleccionar--', 'PERFIL' => 'PERFIL/FICHA', 'EXPEDIENTE TÉCNICO' => 'EXPEDIENTE TÉCNICO (INTEGRAL)', 'CIERRE' => 'CIERRE DE PROYECTO'], isset($EtaSubProyecto->etapa) ? $EtaSubProyecto->etapa : '', ['class' => 'form-control', 'id' => 'cboEtapaPry', 'onchange' => 'loadSubEtapaPry()']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('sub_etapa', 'Sub Estado:') }}</span>
                                                <select id = "cboSubEtapaPry" name="sub_etapa" class="form-control">
                                                    @foreach ($Sub_Etapa as $key => $E)
                                                        <option value="{{ $key }}" {{ $E['state'] }}>
                                                            {{ $E['nombre'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('situa_pro', 'Situacion Actual (Público):') }}</span>
                                                <textarea rows="4" name="situa_pro" class="form-control">{{ $EtaSubProyecto->est_situ or '' }}</textarea>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('obs', 'Observación:') }}</span>
                                                ytgvgvhgv
                                                <textarea rows="4" name="obs" class="form-control">{{ $EtaSubProyecto->obs or '' }}</textarea>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-addon">{{ Form::label('f_etapsub', 'Fecha actualización de estado situacional:') }}</span>

                                                {{ Form::text('f_etapsub', isset($EtaSubProyecto->fecha_act) ? date('d-m-Y', strtotime($EtaSubProyecto->fecha_act)) : '', ['class' => 'form-control datepicker', 'id' => 'f_etapsub']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <h4><b>HISTORIAL PROYECTO</b></h4>
                                    <div class="row" style="height: 200px;overflow: scroll;">
                                        <div class="col-md-12 table-responsive">
                                            <table id="proyecto-table" class="table table-hover table-stripped"
                                                cellspacing="0">
                                                <thead style="background: #3c8dbc;color: white;">
                                                    <tr>
                                                        <th style="text-align: center;vertical-align: middle">Eliminar</th>
                                                        <th style="text-align: center;vertical-align: middle">Fecha</th>
                                                        <th style="text-align: center;vertical-align: middle">Etapa</th>
                                                        <th style="text-align: center;vertical-align: middle">Sub Etapa</th>
                                                        <th style="text-align: center;vertical-align: middle">Descripción</th>
                                                        <th style="text-align: center;vertical-align: middle">Observación</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <br>
                                    <h3><b>DATOS DE OBRA EN EJECUCIÓN</b></h3>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success"
                                                onclick="loadModal('/piptotalpriori/ejecucion/obra/create','full-width','1', {{ $data['id'] }})"><i
                                                    class="fa fa-plus"></i> Agregar Ejecución</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row  table-responsive">
                                                <table id="obra-table" class="table table-hover table-stripped"
                                                    cellspacing="0">
                                                    <thead style="background: #3c8dbc;color: white;">
                                                        <tr>
                                                            <th style="text-align: center;vertical-align: middle">Acciones</th>
                                                            <th style="text-align: center;vertical-align: middle">Orden de
                                                                Ejecución / N° Meta</th>
                                                            <th style="text-align: center;vertical-align: middle">Nombre de
                                                                Meta</th>
                                                            <th style="text-align: center;vertical-align: middle">Tipo de
                                                                Ejecución</th>
                                                            <th style="text-align: center;vertical-align: middle">Año de
                                                                Ejecución</th>
                                                            <th style="text-align: center;vertical-align: middle">Etapa</th>
                                                            <th style="text-align: center;vertical-align: middle">Sub - Etapa
                                                            </th>

                                                            <th style="text-align: center;vertical-align: middle">Avance Fisico
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <script>
                                        var table;
                                        $(document).ready(function() {

                                            table = $('#obra-table').DataTable({
                                                lengthMenu: [
                                                    [10, 25, 50, 100],
                                                    [10, 25, 50, 100]
                                                ],
                                                processing: true,
                                                serverSide: true,
                                                orderCellsTop: true,
                                                autoWidth: false,
                                                stateSave: false,
                                                order: [
                                                    [2, "desc"]
                                                ],
                                                dom: 'rt',
                                                responsive: {
                                                    details: {
                                                        type: 'column'
                                                    }
                                                },
                                                ajax: {
                                                    url: '{{ url('/piptotalpriori/ejecucion/obra/filter') }}',
                                                    type: 'POST',
                                                    data: function(d) {
                                                        d.idproyecto = {{ $data['id'] }}
                                                    },
                                                },
                                                columnDefs: [{
                                                        className: "dt-center",
                                                        targets: "_all"
                                                    },
                                                    {
                                                        orderable: false,
                                                        targets: 0,
                                                        render: function(data, type, full, meta) {

                                                            bEdit =
                                                                "<button type='button' class='btn btn-primary' onclick='loadModal(\"/piptotalpriori/ejecucion/obra/edit\",\"full-width\",\"1\",\"" +
                                                                data +
                                                                "\")'\"><i id='E' class='fa fa-file-text' aria-hidden='true'></i></button> ";

                                                            bList =
                                                                "<button type='button' class='btn btn-info' onclick='loadModal(\"/piptotalpriori/ejecucion/estado/list\",\"modal_wide\",\"1\",\"" +
                                                                data + "\");loadTableEstadoList(\"" + data +
                                                                "\")'><i id='S' class='fa fa-list' aria-hidden='true'></i></button> ";

                                                            bAsignar =
                                                                "<button type='button' class='btn btn-warning' onclick='loadModal(\"/piptotalpriori/ejecucion/obra/inspector/asignar\",\"full-width\",\"1\",\"" +
                                                                data +
                                                                "\")'\"><i id='S' class='fa fa-address-book' aria-hidden='true'></i></button> ";

                                                            bDelete =
                                                                "<button type='button' class='btn btn-danger' onclick='deleteEjecucion(" +
                                                                data +
                                                                ")'><i id='S' class='fa fa-trash' aria-hidden='true'></i></button>";

                                                            return bEdit + bList + bAsignar + bDelete;
                                                        }
                                                    },
                                                    {
                                                        orderable: false,
                                                        targets: 3,
                                                        render: function(data, type, full, meta) {

                                                            var str = '';
                                                            switch (data) {
                                                                case 'E':
                                                                    str =
                                                                        '<label class="label label-success">EJECUCIÓN INTEGRAL</label>';
                                                                    break;
                                                                case 'M':
                                                                    str = '<label class="label label-primary">META</label>';
                                                                    break;
                                                                case 'S':
                                                                    str =
                                                                    '<label class="label label-warning">SALDO DE OBRA</label>';
                                                                    break;
                                                                default:

                                                            }

                                                            return str;
                                                        }
                                                    }

                                                ],
                                                language: {
                                                    "sProcessing": "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                                                    "sLengthMenu": "Mostrar _MENU_",
                                                    "sZeroRecords": "No se encontraron resultados",
                                                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                                                    "sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
                                                    "sInfoEmpty": "Vacio",
                                                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                                                    "sInfoPostFix": "",
                                                    "sSearch": "Buscar:",
                                                    "sUrl": "",
                                                    "sInfoThousands": ",",
                                                    "sLoadingRecords": "Cargando...",
                                                    "oPaginate": {
                                                        "sFirst": "Primero",
                                                        "sLast": "Último",
                                                        "sNext": "Siguiente",
                                                        "sPrevious": "Anterior"
                                                    },
                                                    "oAria": {
                                                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                                    }
                                                },
                                                columns: [{
                                                        data: 'id',
                                                        name: 'accion',
                                                        orderable: false,
                                                        searchable: false,
                                                        width: '10%'
                                                    },
                                                    {
                                                        data: 'nro_meta',
                                                        name: '',
                                                        width: '8%'
                                                    },
                                                    {
                                                        data: 'nom_meta',
                                                        name: 'fecha',
                                                        width: '7%',
                                                        orderable: true
                                                    },
                                                    {
                                                        data: 'tipo',
                                                        name: 'tipo',
                                                        width: '7%',
                                                        orderable: true
                                                    },
                                                    {
                                                        data: 'anio_ejec',
                                                        name: 'anio_ejec',
                                                        width: '5%'
                                                    },
                                                    {
                                                        data: 'etapa',
                                                        name: 'etapa',
                                                        width: '8%'
                                                    },
                                                    {
                                                        data: 'sub_etapa',
                                                        name: 'sub_etapa',
                                                        width: '8%'
                                                    },
                                                    {
                                                        data: 'a_fisico',
                                                        name: 'a_fisico',
                                                        width: '10%'
                                                    },
                                                ],
                                                initComplete: function(data) {

                                                }
                                            });

                                            deleteEjecucion = function($id) {
                                                var id = $id;
                                                swal({
                                                    title: '¿Estas seguro?',
                                                    text: "Se eliminara la ejecucion registrada",
                                                    type: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Si',
                                                    cancelButtonText: 'No, cancelar!',
                                                    confirmButtonClass: 'btn btn-success',
                                                    cancelButtonClass: 'btn btn-danger',
                                                    buttonsStyling: true
                                                }).then(function() {
                                                    $.ajax({
                                                        url: "/piptotalpriori/ejecucion/obra/delete",
                                                        type: 'POST',
                                                        data: {
                                                            id: id
                                                        },
                                                        success: function(data) {
                                                            swal(
                                                                'Listo',
                                                                'Se ha eliminado la imagen',
                                                                'success'
                                                            )

                                                            updateTables();
                                                        },
                                                        error: function(e) {
                                                            swal(
                                                                'Error',
                                                                'Error al eliminar la imagen',
                                                                'error'
                                                            )
                                                        }
                                                    });

                                                }, function(dismiss) {

                                                    swal(
                                                        'Cancelado',
                                                        'Operación cancelada',
                                                        'error'
                                                    )

                                                }).catch(swal.noop);
                                            }

                                            $(".dateSearch").change(function() {
                                                reloadTable();
                                            });

                                            $("#cboEstado").change(function() {
                                                reloadTable();
                                            });

                                            $.fn.dataTable.ext.errMode = 'none';

                                            //GERENCIA TEXT FORMATTER
                                            function gerenciaTextFormatter(cellvalue, options, rowObject) {
                                                var arrUE = {
                                                    'DIRECCION REGIONAL DE AGRICULTURA': 'DRA',
                                                    'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE': 'GRRNGMA',
                                                    'GERENCIA SUB REGIONAL LIMA SUR': 'GSRLS',
                                                    'GERENCIA REGIONAL DE DESARROLLO ECONOMICO': 'GRDE',
                                                    'GERENCIA REGIONAL DE DESARROLLO SOCIAL': 'GRDS',
                                                    'GERENCIA REGIONAL DE INFRAESTRUCTURA': 'GRI',
                                                    'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES': 'DRTC',
                                                    'DIRECCION REGIONAL DE SALUD': 'DIRESA',
                                                    '': ''
                                                };
                                                return arrUE[cellvalue];
                                            }

                                            var Inspector;
                                            var IDObra;
                                            searchUsuario = function(frm) {
                                                event.preventDefault();

                                                $.ajax({
                                                    url: '/getInspectorbyNomOrDNI',
                                                    type: 'POST',
                                                    data: $(frm).serialize(),
                                                    beforeSend: function() {
                                                        $("#loader").show();
                                                        $('.modal-scrollable .btn').prop('disabled', true);

                                                    },
                                                    success: function(response) {

                                                        var usuario = response.data;

                                                        var found = response.found;

                                                        if (found) {
                                                            $(".modal-scrollable #lblNombre").text(usuario['apellidos'] + ", " +
                                                                usuario['nombres']);
                                                            $(".modal-scrollable #lblDependencia").text('GRL');
                                                            $(".modal-scrollable #lblDNI").text(usuario['dni']);
                                                            $(".modal-scrollable #lblCelular").text(usuario['celular']);

                                                            $(".modal-scrollable #frmSearchUsuario #message").text("");

                                                            Inspector = usuario

                                                        } else {
                                                            $(".modal-scrollable #lblNombre").text("");
                                                            $(".modal-scrollable #lblDependencia").text("");
                                                            $(".modal-scrollable #lblDNI").text("");
                                                            $(".modal-scrollable #lblCelular").text("");

                                                            $(".modal-scrollable #frmSearchUsuario #message").text(
                                                                "No se encontró resultado");

                                                            Inspector = undefined;
                                                        }

                                                    },
                                                    complete: function(response) {
                                                        $("#loader").hide();
                                                        $('.modal-scrollable .btn').prop('disabled', false);
                                                    }
                                                });
                                            }

                                            asignarInspector = function() {
                                                if (Inspector) {
                                                    $.ajax({
                                                        url: '/piptotalpriori/ejecucion/obra/inspector/vincular',
                                                        type: 'POST',
                                                        data: {
                                                            idusuario: Inspector['idusuario'],
                                                            idobra: $(".modal-scrollable #idobra").val()
                                                        },
                                                        beforeSend: function() {
                                                            $("#loader").show();
                                                            $('.modal-scrollable .btn').prop('disabled', true);
                                                        },
                                                        success: function(response) {

                                                            $(".modal-scrollable #listResponsables").append('<a id = "' + Inspector[
                                                                    'idusuario'] + '" class="list-group-item"> ' + Inspector[
                                                                    'apellidos'] + ', ' + Inspector['nombres'] +
                                                                ' <i class="fa fa-user-times pull-right" aria-hidden="true" onclick="quitarInspector(this);"></i></a>'
                                                                );

                                                        },
                                                        complete: function(response) {
                                                            $("#loader").hide();
                                                            $('.modal-scrollable .btn').prop('disabled', false);
                                                        }
                                                    });

                                                }
                                            }

                                            quitarInspector = function(ele) {
                                                $.ajax({
                                                    url: '/piptotalpriori/ejecucion/obra/inspector/desvincular',
                                                    type: 'POST',
                                                    data: {
                                                        idusuario: $(ele).parent().attr("id"),
                                                        idobra: $(".modal-scrollable #idobra").val()
                                                    },
                                                    beforeSend: function() {
                                                        $("#loader").show();
                                                        $('.modal-scrollable .btn').prop('disabled', true);
                                                    },
                                                    success: function(response) {
                                                        $(ele).parent().remove();
                                                    },
                                                    complete: function(response) {
                                                        $("#loader").hide();
                                                        $('.modal-scrollable .btn').prop('disabled', false);
                                                    }
                                                });
                                            }
                                        });
                                    </script>

                                    <br>
                                    @if ($data['tipo_pry'] == 'PIC')
                                        <h3><b>DATOS ADICIONALES PRESUPUESTO PARTICIPATIVO</b></h3>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('anio_pic', 'Año del PIC:') }}</span>
                                                    {{ Form::text('anio_pic', null, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('mpp_pic', 'Monto Pres. Partic.:') }}</span>
                                                    {{ Form::text('mpp_pic', null, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('macr_pic', 'Monto Acuerdo:') }}</span>
                                                    {{ Form::text('macr_pic', null, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('nacuerdo_pic', 'Numero Acuerdo:') }}</span>
                                                    {{ Form::text('nacuerdo_pic', null, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('mpia_pic', 'Monto PIA:') }}</span>
                                                    {{ Form::text('mpia_pic', null, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        </div><br>
                                    @endif
                                    <br>
                                    <br>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <a type="button" class="btn btn-danger"
                                                href="{{ URL::to('/piptotalpriori') }}"><span
                                                    class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                                            <button type="submit" class="btn btn-primary"><span
                                                    class="glyphicon glyphicon-save"></span> GUARDAR</button>
                                        </div>
                                        <br>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endpermission
                            <div role="tabpanel" class="tab-pane" id="ubicacion">
                                <form id="frm_location" class="ubicacion" method="POST">
                                    <br>

                                    <br>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-1">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('cod_prov', 'Ubigeo') }}</span>
                                                    <div>
                                                        {{ Form::text('cod_prov', null, ['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'ubigeo']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-1">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                            class="glyphicon glyphicon-search"></i></span>
                                                    <input type="text" class="form-control col-md-12" id="pac-input"
                                                        placeholder="Busqueda en mapa" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('latitud', 'Latitud') }}</span>
                                                    <div>
                                                        {{ Form::text('latitud', null, ['class' => 'form-control', 'id' => 'lat']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-addon">{{ Form::label('longitud', 'Longitud') }}</span>
                                                    <div>
                                                        {{ Form::text('longitud', null, ['class' => 'form-control', 'id' => 'lon']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="mapContainer col-md-offset-1 col-md-10">
                                            <div class="row">
                                                <div id="map"></div>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <a type="button" class="btn btn-danger"
                                                href="{{ URL::to('/piptotalpriori') }}"><span
                                                    class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                                            <input type=hidden id="uid" name="uid"
                                                value="{{ $data['cod_unif'] }}" />
                                            <button type="submit" class="btn btn-primary"><span
                                                    class="glyphicon glyphicon-save"></span> GUARDAR</button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="galeria">
                                <input type=hidden id="uid" name="uid" value="{{ $data['cod_unif'] }}" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="jumbotron how-to-create" style="background-color: rgb(209,227,243)">
                                            <div id = 'message'></div>
                                            <div class='row col-md-12'>
                                                <label style="font-size: 16px">Tiempo de toma de imagenes</label><br>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-2 col-lg-2"><label>Antes <input
                                                            type="radio" name="tipo" value="antes"></label></div>
                                                <div class="col-xs-12 col-md-2 col-lg-2"><label>Durante <input
                                                            type="radio" name="tipo" value="durante"></label></div>
                                                <div class="col-xs-12 col-md-2 col-lg-2"><label>Despues <input
                                                            type="radio" name="tipo" value="despues"></label></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if (count($Obras) > 1)
                                                        <label style="font-size: 16px">
                                                            Meta a la que pertecen</label><br>
                                                        <input type="radio" name="optObra" value=""
                                                            style="visibility:hidden;" checked>
                                                        @foreach ($Obras as $o)
                                                            <div class="col-xs-12 col-md-3 col-lg-3"><label>
                                                                    {{ $o->nom_meta }} <input type="radio"
                                                                        name="optObra"
                                                                        value="{{ $o->id }}"></label></div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label style="font-size: 16px">Descripción (Opcional)</label><br>
                                                    <textarea id = "txtDescripcion" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="row col-md-12">
                                                <label style="font-size: 16px">Fecha de toma de las imagenes
                                                    anexadas</label><br>
                                                <input type=text id="fecha" name="fecha"
                                                    class="datepicker" /><br><br>
                                            </div>
                                            <br />
                                            <br />
                                            <br />
                                            <h3><span id="counter"></span></h3>

                                            {!! Form::open([
                                                'action' => 'PipTotalPrioriController@imgUpload',
                                                'class' => 'dropzone',
                                                'files' => true,
                                                'id' => 'dzone',
                                            ]) !!}

                                            <div class="dz-message">

                                            </div>

                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>

                                            <div class="dropzone-previews" id="dropzonePreviewAntes"></div>

                                            <h4 style="text-align: center;color:#428bca;">Arrastra las imagenes a esta área
                                                <span class="glyphicon glyphicon-open-file"></span></h4>

                                            <button id="submit-all">Guardar</button>
                                            {!! Form::close() !!}

                                        </div>

                                    </div>
                                </div>

                                <!-- Dropzone Preview Template -->
                                <div id="preview-template" style="display: none;">

                                    <div class="dz-preview dz-file-preview">
                                        <div class="dz-image"><img data-dz-thumbnail=""></div>
                                        <input type="hidden" class="serverfilename" />

                                        <div class="dz-details">
                                            <div class="dz-size"><span data-dz-size=""></span></div>
                                            <div class="dz-filename"><span data-dz-name=""></span></div>
                                        </div>
                                        <div class="dz-progress"><span class="dz-upload"
                                                data-dz-uploadprogress=""></span></div>
                                        <div class="dz-error-message"><span data-dz-errormessage=""></span></div>

                                        <div class="dz-success-mark">

                                        </div>

                                        <div class="dz-error-mark">

                                        </div>

                                    </div>
                                </div>
                                <!-- End Dropzone Preview Template -->

                                <!-- BOXES -->

                                <div id="imgPorEjecucion">

                                </div>
                                <h3>ANTES</h3><span id="foto_antes"></span>

                                <div id="antes"></div>
                                <h3>DURANTE</h3><span id="foto_durante"></span>

                                <div id="durante"></div>

                                <h3>DESPUES</h3><span id="foto_despues"></span>

                                <div id="despues"></div>
                                <div id="despues"></div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <i>
                                        <h6>{{ Form::label('fuente', 'Fuente:') }}
                                            {{ Form::label('fuente', $data['fuente']) }}</h6>
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MAIN SCRIPT -->
                    <script>
                        //INIT
                        $(function() {
                            //=========== TAB FICHA ===================

                            var tableProyecto = $('#proyecto-table').DataTable({
                                processing: true,
                                serverSide: true,
                                orderCellsTop: true,
                                autoWidth: false,
                                stateSave: false,
                                dom: 'rt',
                                responsive: {
                                    details: {
                                        type: 'column'
                                    }
                                },
                                ajax: {
                                    url: '{{ url('/piptotalpriori/proyecto/estado/filter') }}',
                                    type: 'GET',
                                    data: function(d) {
                                        d.idproyecto = {{ $data['id'] }};
                                    },
                                },
                                columnDefs: [{
                                        className: "dt-center",
                                        targets: "_all"
                                    },
                                    {
                                        orderable: false,
                                        targets: 0,
                                        render: function(data, type, full, meta) {
                                            bDelete =
                                                "<button type='button' class='btn btn-danger' onclick='deleteEstadoProyecto(" +
                                                data +
                                                ")'><i id='S' class='fa fa-trash' aria-hidden='true'></i></button> ";
                                            return bDelete;
                                        }
                                    }
                                ],
                                language: {
                                    "sProcessing": "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                                    "sLengthMenu": "Mostrar _MENU_",
                                    "sZeroRecords": "No se encontraron resultados",
                                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                                    "sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
                                    "sInfoEmpty": "Vacio",
                                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                                    "sInfoPostFix": "",
                                    "sSearch": "Buscar:",
                                    "sUrl": "",
                                    "sInfoThousands": ",",
                                    "sLoadingRecords": "Cargando...",
                                    "oPaginate": {
                                        "sFirst": "Primero",
                                        "sLast": "Último",
                                        "sNext": "Siguiente",
                                        "sPrevious": "Anterior"
                                    },
                                    "oAria": {
                                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                    }
                                },
                                columns: [{
                                        data: 'id',
                                        name: 'accion',
                                        orderable: false,
                                        searchable: false,
                                        width: '4%'
                                    },
                                    {
                                        data: 'fecha_act',
                                        name: 'fecha_act',
                                        width: '8%',
                                        searchable: false,
                                        orderable: false
                                    },
                                    {
                                        data: 'etapa',
                                        name: 'etapa',
                                        width: '8%',
                                        searchable: false,
                                        orderable: false
                                    },
                                    {
                                        data: 'sub_etapa',
                                        name: 'sub_etapa',
                                        width: '8%',
                                        searchable: false,
                                        orderable: false
                                    },
                                    {
                                        data: 'est_situ',
                                        name: 'est_situ',
                                        width: '42%',
                                        orderable: false
                                    },
                                    {
                                        data: 'obs',
                                        name: 'obs',
                                        width: '30%',
                                        orderable: false
                                    }
                                ]
                            });

                            deleteEstadoProyecto = function($id) {
                                var id = $id;
                                swal({
                                    title: '¿Estas seguro?',
                                    text: "Se eliminara el estado registrado",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Si',
                                    cancelButtonText: 'No, cancelar!',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: true
                                }).then(function() {
                                    $.ajax({
                                        url: "/piptotalpriori/proyecto/estado/delete",
                                        type: 'POST',
                                        data: {
                                            id: id
                                        },
                                        success: function(data) {
                                            swal(
                                                'Listo',
                                                'Se ha eliminado el estado',
                                                'success'
                                            )

                                            tableProyecto.ajax.reload(null, false);
                                        },
                                        error: function(e) {
                                            swal(
                                                'Error',
                                                'Error al eliminar el Estado',
                                                'error'
                                            )
                                        }
                                    });

                                }, function(dismiss) {

                                    swal(
                                        'Cancelado',
                                        'Operación cancelada',
                                        'error'
                                    )

                                }).catch(swal.noop);
                            }

                            $("#a_fisico").bind("change keyup", function() {
                                var currentDate = new Date();
                                var day = currentDate.getDate();
                                var month = currentDate.getMonth() + 1;
                                var year = currentDate.getFullYear();
                                if (day < 10) {
                                    day = '0' + day;
                                }
                                if (month < 10) {
                                    month = '0' + month;
                                }
                                var today = day + "-" + month + "-" + year;

                                $("#f_fisico").val(today).prop('required', true);
                            });

                            $("#situa_pro, #combo5, #combo4").bind("change keyup", function() {
                                var currentDate = new Date();
                                var day = currentDate.getDate();
                                var month = currentDate.getMonth() + 1;
                                var year = currentDate.getFullYear();
                                if (day < 10) {
                                    day = '0' + day;
                                }
                                if (month < 10) {
                                    month = '0' + month;
                                }
                                var today = day + "-" + month + "-" + year;

                                $("#f_etapsub").val(today).prop('required', true);
                            });

                            //POPULATING DDLS
                            selectDistrito();
                            //comboUno();
                            $("#combo2").change(function() {
                                comboUno();
                            });
                            selectSubetapa();
                            $("#combo4").change(function() {
                                comboDos();
                            });
                            AdmOCont($("#m_ejec"));
                            //============== TAB UBICACION =============
                            getLocationInfo();
                            $('#tabUbicacion').click(function(e) {
                                //getLocationInfo();
                                setTimeout(initMap, 500);
                            });

                        });
                    </script>

                    <script>
                        //============================ FICHA TECNICA ==============================
                        function comboUno() {
                            $("#combo2 option:selected").each(function() {
                                var id = $(this).val();
                                if (id == "")
                                    id = 0;
                                $.ajax({
                                    url: "{{ URL::to('/piptotalpriori/combodistrito') }}/" + id,
                                    success: function(data) {
                                        $("#combo3").html(data);
                                    }
                                });
                            });
                        }

                        function selectDistrito() {
                            $("#combo3 option:selected").each(function() {
                                var distrito = $(this).val();
                                console.log(distrito);
                                comboUno();
                                setTimeout(function() {
                                    $("#combo3 option").each(function() {
                                        //console.log($(this).val(),distrito);
                                        if ($(this).val() === distrito) { // EDITED THIS LINE
                                            //console.log($(this).val());
                                            $(this).attr("selected", "selected");
                                        }
                                    });
                                }, 1500);
                            });
                        }

                        function comboDos() {
                            $("#combo4 option:selected").each(function() {
                                var id = $(this).val();
                                //console.log(id);
                                if (id == "") {
                                    id = 0;
                                }
                                $.ajax({
                                    url: "{{ URL::to('/piptotalpriori/combosubetapa') }}/" + id,
                                    success: function(data) {
                                        $("#combo5").html(data);
                                        //console.log(data);
                                    }
                                });
                            });
                        }

                        function selectSubetapa() {
                            $("#combo5 option:selected").each(function() {
                                var subetapa = $(this).val();
                                comboDos();
                                setTimeout(function() {
                                    $("#combo5 option").each(function() {
                                        if ($(this).val().toString('utf8') === subetapa.toString(
                                            'utf8')) { // EDITED THIS LINE
                                            console.log($(this).val());
                                            $(this).attr("selected", "selected");
                                        }
                                    });
                                }, 2500);
                            });
                        }

                        function AdmOCont(e) {
                            var x = $(e).val();
                            if (x === 'CONTRATA') {
                                $("#dvNro_Contrato").show();
                            } else {
                                $("#dvNro_Contrato").hide();
                            }
                        }

                        //============================== UBICACIÓN ================================
                        //ON CLICK UBICACION TAB
                        $('#myTabs a').click(function(e) {
                            e.preventDefault()
                            $(this).tab('show')
                        });
                        // GET LOCATION SAVED OR SET DEFAULT
                        var lat = -11.127036;
                        var lon = -77.596699;

                        function getLocationInfo() {
                            uid = document.getElementById('uid').value;
                            $.ajax({
                                url: "/getLocationInfo",
                                type: 'POST',
                                data: {
                                    uid: uid
                                },
                                success: function(data) {
                                    $('#lat').val(data.data['latitud']);
                                    $('#lon').val(data.data['longitud']);
                                    $('#ubigeo').val(data.data['cod_dist']);
                                    //console.log(!isNaN(data.data['latitud']));
                                    //console.log(!isNaN(data.data['longitud']));
                                    //console.log(!isNaN(data.data['latitud'])==true && !isNaN(data.data['latitud'])==true);
                                    //console.log(isNaN(data.data['latitud'])==true && !isNaN(data.data['latitud'])==true);
                                    if ((data.data['latitud'].length === 0 || !data.data['latitud']) && (data.data['longitud']
                                            .length === 0 || !data.data['longitud'])) {
                                        lat = -11.127036;
                                        lon = -77.596699;
                                    } else {
                                        lat = parseFloat(data.data['latitud']);
                                        lon = parseFloat(data.data['longitud']);
                                    }
                                }
                            });
                        }

                        //LOAD GOOGLE MAPS API
                        var map;

                        function initMap() {
                            map = new google.maps.Map(document.getElementById('map'), {
                                center: {
                                    lat: lat,
                                    lng: lon
                                },
                                zoom: 100,
                                mapTypeId: google.maps.MapTypeId.HYBRID
                            });

                            var marker = new google.maps.Marker({
                                position: {
                                    lat: lat,
                                    lng: lon
                                },
                                map: map
                            });
                            console.log(lat, lon);
                            google.maps.event.addListener(map, 'click', function(event) {
                                $('#lat').val(event.latLng.lat());
                                $('#lon').val(event.latLng.lng());

                            });
                            google.maps.event.trigger(map, 'resize');
                            google.maps.event.addListenerOnce(map, 'idle', function() {
                                google.maps.event.trigger(map, 'resize');
                            });
                            // Create the search box and link it to the UI element.
                            var input = /** @type {HTMLInputElement} */ (
                                document.getElementById('pac-input'));


                            var searchBox = new google.maps.places.SearchBox(
                                /** @type {HTMLInputElement} */
                                (input));
                            // Listen for the event fired when the user selects an item from the
                            // pick list. Retrieve the matching places for that item.
                            var markers = [];
                            google.maps.event.addListener(searchBox, 'places_changed', function() {
                                var places = searchBox.getPlaces();
                                if (places.length == 0) {
                                    return;
                                }

                                // Clear out the old markers.
                                markers.forEach(function(marker) {
                                    marker.setMap(null);
                                });
                                markers = [];

                                // For each place, get the icon, name and location.
                                var bounds = new google.maps.LatLngBounds();
                                places.forEach(function(place) {
                                    var icon = {
                                        url: place.icon,
                                        size: new google.maps.Size(71, 71),
                                        origin: new google.maps.Point(0, 0),
                                        anchor: new google.maps.Point(17, 34),
                                        scaledSize: new google.maps.Size(25, 25)
                                    };

                                    // Create a marker for each place.
                                    markers.push(new google.maps.Marker({
                                        map: map,
                                        icon: icon,
                                        title: place.name,
                                        position: place.geometry.location
                                    }));

                                    if (place.geometry.viewport) {
                                        // Only geocodes have viewport.
                                        bounds.union(place.geometry.viewport);
                                    } else {
                                        bounds.extend(place.geometry.location);
                                    }
                                });
                                map.fitBounds(bounds);
                            });
                        }
                        //SAVE LOCATION PARAMS
                        $("#frm_location").submit(function(e) {
                            e.preventDefault();
                            var formData = new FormData($(this)[0]);
                            $.ajax({
                                url: '/updateLocationInfo',
                                type: 'POST',
                                data: formData,
                                async: false,
                                cache: false,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                    $('button').attr('disabled', 'disabled');
                                },
                                success: function(response) {
                                    $('button').removeAttr('disabled');
                                    swal(
                                        'Correcto',
                                        'Datos actualizados correctamente!',
                                        'success'
                                    );
                                    getLocationInfo();
                                },
                                error: function(response) {
                                    $('button').removeAttr('disabled');
                                    response = $.parseJSON(response.responseText);
                                    swal(
                                        'Error',
                                        'Error al guardar los cambios',
                                        'error'
                                    );
                                }
                            });
                            return false;
                        });

                        function setDatepicker() {
                            $(".datepicker").datepicker({
                                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre",
                                    "Octubre", "Noviembre", "Diciembre"
                                ],
                                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov",
                                    "Dic"],
                                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                                dateFormat: "dd-mm-yy",
                                yearRange: '2000:2020',
                                //defaultDate: +15,
                                changeMonth: true,
                                changeYear: true,
                                maxDate: '+30Y',
                                beforeShow: function() {
                                    setTimeout(function() {
                                        $('.ui-datepicker').css('z-index', 99999999999999);
                                    }, 0);
                                }
                            });
                        }

                        //DATEPICKER INICIALIZATION
                        $(function() {
                            setDatepicker();
                        });

                        //INPUT COLOR CHANGE ON TEXT MODIFICATION
                        $(".form-control").focus(function() {
                            var that = this;
                            var a_val = $(this).val();
                            $(this).keyup(function() {
                                if (a_val === $(that).val()) {
                                    $(that).css({
                                        "background-color": "white",
                                        "color": "black"
                                    });
                                } else {
                                    $(this).css({
                                        "background-color": "rgb(0,114,200)",
                                        "color": "white"
                                    });
                                }
                            });
                            $(this).change(function() {
                                if (a_val === $(that).val()) {
                                    $(that).css({
                                        "background-color": "white",
                                        "color": "black"
                                    });
                                } else {
                                    $(this).css({
                                        "background-color": "rgb(0,114,200)",
                                        "color": "white"
                                    });
                                }
                            });

                        });

                        //PREVENT FORM SUBMITTING ON KEY ENTER PRESS
                        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
                            if (e.which == 13) {
                                e.preventDefault();
                                return false;
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>


    <!-- JQUERY UI -->
    <script src="{{ asset('librerias/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- DROPZONE -->
    <script src="{{ asset('/librerias/dropzone/dropzone.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <!--script type="text/javascript" src= "https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script-->
    <script>
        loadSubEtapaPry = function() {
            var etapa = $('#cboEtapaPry :selected').val();

            $.ajax({
                url: "{{ URL::to('/piptotalpriori/combosubetapa') }}/" + etapa,
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(response) {
                    $("#cboSubEtapaPry").html(response);
                },
                complete: function(response) {
                    $("#loader").hide();
                }
            });
        }

        function AdmOContM(e) {
            var x = $(e).val();
            if (x === 'CONTRATA') {
                $("#dvNro_ContratoM").show();
            } else {
                $("#dvNro_ContratoM").hide();
            }
        }

        function loadModal(url, modaltype, CRUD, opc) {
            $modal = $('#' + modaltype);
            //clean errors
            $(".m-message").html('<div></div>');
            switch (CRUD) {
                case '1':
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            'id': opc
                        },
                        beforeSend: function() {
                            // $("#error").fadeOut();
                        },
                        success: function(response) {
                            $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                            $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                            $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                            $('#' + modaltype).modal('show', {
                                backdrop: 'true'
                            });
                        },
                        error: function(response) {

                        }
                    }).done(function() {
                        setDatepicker();
                        AdmOContM($("#mod_ejec"));

                        $("#situa_obra, #cboEtapa, #cboSubEtapa, #a_fisico_obra").bind("change keyup", function() {
                            var currentDate = new Date();
                            var day = currentDate.getDate();
                            var month = currentDate.getMonth() + 1;
                            var year = currentDate.getFullYear();
                            if (day < 10) {
                                day = '0' + day;
                            }
                            if (month < 10) {
                                month = '0' + month;
                            }
                            var today = day + "-" + month + "-" + year;

                            $("#fecha_act").val(today).prop('required', true);
                        });



                        if ($("#a_fisico_obra").val() === '') {
                            $("#a_fisico_obra").val('0.00');
                        }

                        $("#a_fisico_obra").bind("change keyup", function() {

                            var valor = $(this).val();
                            if (valor === '') {
                                $(this).val('0.00');
                            }
                        });


                        //var spinner = $( ".spinner" ).spinner();
                        /*
                         * OBRA
                         */

                        $("#frmObra").submit(function(e) {

                            e.preventDefault();

                            $.ajax({
                                method: "POST",
                                url: $("#frmObra").attr('action'),
                                data: $("#frmObra").serialize(),
                                beforeSend: function() {

                                },
                                error: function(response) {
                                    try {
                                        var data = $.parseJSON(response.responseText);
                                    } catch (Exception) {
                                        console.log('Error');
                                    }

                                    var li = "";
                                    $.each(data, function(key, val) {
                                        li += "<li>" + val + "</li>";
                                    });
                                    $('.validation-message').remove();
                                    $("#frmObra").prepend(
                                        '<div id = "frm_message" class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                        li + '</div>');
                                    $(".modal-scrollable").animate({
                                        scrollTop: 0
                                    }, 'slow');

                                    $("#frm_message").focus();
                                },
                                success: function(response) {
                                    $('.validation-message').remove();
                                    swal(
                                        'Guardado',
                                        'Los cambios se guardaron exitosamente!',
                                        'success'
                                    );
                                    updateTables();
                                }
                            });

                        });
                    });
                    break;
            }
        }

        loadSubEtapa = function() {

            var etapa = $('.modal-scrollable #cboEtapa :selected').val();

            $.ajax({
                url: "{{ URL::to('/piptotalpriori/combosubetapa') }}/" + etapa,
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(response) {
                    $(".modal-scrollable #cboSubEtapa").html(response);
                },
                complete: function(response) {
                    $("#loader").hide();
                }
            });
        }

        loadfrmEdit = function(id) {
            $.ajax({
                url: '/piptotalpriori/ejecucion/estado/edit',
                type: 'POST',
                data: {
                    'id': id
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(response) {
                    $('#full-width .modal-title').html($(response).filter('.cabecera'));
                    $('#full-width .modal-body').html($(response).filter('#container'));
                    $('#full-width .modal-footer').append($(response).filter('.pie'));
                    $('#full-width').modal('show', {
                        backdrop: 'true'
                    });
                },
                complete: function(response) {
                    $("#loader").hide();
                    fireDZ(id);
                    cargarImg(id);
                    //FANCYBOX INIT
                    $(".fancybox").fancybox();
                },
                error: function(response) {
                    $("#loader").hide();
                }
            });
        }
        cargarImg = function(id) {
            var imguid = id;
            $.get('/piptotalpriori/ejecucion/estado/img/get/' + imguid.toString(), function(data) {
                $('#full-width #obras').html('');
                //console.log(data.taller_img.length);
                if (data.taller_img.length != 0) {
                    $.each(data.taller_img, function(key, value) {

                        url = '/images' + value.url + "/" + value.nombre;
                        $('#full-width #obras')
                            .append('<div class="container col-lg-3 col-sm-6 col-md-4 col-xs-12">' +
                                '<div style="border:1px solid;border-radius:2%;margin-right:8px;margin-top:12px;">' +
                                '<a class="fancybox" rel="group" href="' + url + '">' +
                                '<img width=100% height=150px src="' + url + '" alt="" />' +
                                '</a>' +
                                '<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">' +
                                '<span style="font-weight:bold">&nbsp&nbspFecha: ' + value.created_at +
                                '</span>' +
                                '</div>' +
                                '<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">' +
                                '<button style="float:right" onclick = "deleteImg(' + value.id + ',' +
                                imguid +
                                ')" class="btn btn-danger"><i class="fa fa-trash"></i></button> '
                                <?php
                                        if( Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){
                                    ?> +
                                '<button style="float:right" onclick = "showImgData(' + value.id +
                                ')" class="btn btn-info"><i class="fa fa-eye"></i></button>'
                                <?php
                                        }
                                    ?> +
                                '</div>' +
                                '</div>' +
                                '</div>');
                    });

                } else {
                    $('#full-width #obras').append('<h4>No hay imágenes disponibles</h4>');
                }

            });
        };
        fireDZ = function(id) {
            var id = id;
            var counter = 0;
            var actual = 0;
            var cleanUp = true;;
            $("#full-width #dzone").dropzone({
                uploadMultiple: true,
                autoProcessQueue: false,
                maxFiles: 1,
                parallelUploads: 1,
                maxFilesize: 250,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.mp4,.mkv,.avi",
                previewsContainer: '#dropzonePreviewAntes',
                previewTemplate: document.querySelector('#preview-template').innerHTML,
                addRemoveLinks: true,
                dictRemoveFile: 'Quitar',
                //dictFileTooBig: 'La imagen es mayor a 8MB',
                dictRemoveFileConfirmation: "¿Estas seguro que deseas quitar esta imagen?",
                // The setting up of the dropzone
                createImageThumbnails: true,
                maxThumbnailFilesize: 100,

                init: function() {
                    var dzuid = id;

                    var submitButton = document.querySelector("#submit-all");
                    myDropzone = this; // closure

                    submitButton.addEventListener("click", function(event) {
                        event.preventDefault();
                        if ($('#fecha').val() !== '') {
                            myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                        } else {
                            $('#submit-all').attr('disabled', 'disabled').addClass('btn btn-alert');
                        }

                    });

                    $('input[type=radio][name=tipo]').change(function() {
                        cleanUp = false;
                        btnState(actual);
                    });
                    this.on("addedfile", function(file) {
                        actual++;
                        console.log(file);
                        btnState(actual);
                    });
                    this.on("maxfilesexceeded", function() {
                        swal(
                            'Error',
                            'Solo Puede subir una imagen!',
                            'error'
                        );
                    });
                    indx = 0;
                    this.on("sendingmultiple", function(file, xhr, formData) {
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        var uid = id;
                        var nDate = new Date(file[0].lastModified)



                        var datestring = nDate.getFullYear() + "-" +
                            ("0" + (nDate.getMonth() + 1)).slice(-2) + "-" +
                            ("0" + nDate.getDate()).slice(-2) + " " +
                            ("0" + nDate.getHours()).slice(-2) + ":" +
                            ("0" + nDate.getMinutes()).slice(-2) + ":" +
                            ("0" + nDate.getSeconds()).slice(-2);

                        console.log(JSON.stringify(file[0]));
                        formData.append('uid', id);
                        formData.append('fecha', datestring);
                        formData.append('cdata', file[0].lastModifiedDate + ";" + file[0].name +
                            ";" + file[0].lastModified);
                        formData.append('_token', csrf_token);
                    });
                    this.on("error", function(file) {
                        if (!file.accepted) this.removeFile(file);
                    });
                    this.on("removedfile", function(file) {
                        actual--;
                        btnState(actual);
                    });
                },
                error: function(file, response) {
                    $('.validation-message').remove();
                    if (response.error) {

                        if (response.messages) {
                            var li = "";
                            $.each(response.messages, function(index, value) {
                                li += "<li>" + value + "</li>";
                            });

                            $('#message').prepend(
                                '<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                li + '</div>');

                            swal(
                                'Error',
                                'Error al subir la imagen, intentelo nuevamente!',
                                'error'
                            );
                        } else if (response.message) {
                            $('.validation-message').remove();
                            var li = "";

                            $('#message').prepend(
                                '<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                response.message + '</div>');

                            swal(
                                'Error',
                                response.message,
                                'error'
                            );
                        }
                    }




                },
                success: function(file, response) {
                    $('.validation-message').remove();
                    var myDropzone = this;
                    $('.serverfilename', file.previewElement).val(response.filename);
                    counter++;
                    $("#photoCounterAntes").text("(" + counter + ")");

                    //$('#message').html('<div class=\'alert alert-success fade in\'>La imagen se Guardó Exitosamente</div>');
                    cargarImg(id);
                    cleanUp = false;
                    myDropzone.removeAllFiles();
                    swal(
                        'Correcto',
                        'La imágen se guardó correctamente',
                        'success'
                    );
                    //$("#poitaller-table").ajax.reload();
                }
            });
        };

        var tableObras;
        loadTableEstadoList = function($id) {
            setTimeout(function() {
                tableObras = $('.modal-scrollable #listestado-table').DataTable({
                    processing: true,
                    serverSide: true,
                    orderCellsTop: true,
                    autoWidth: false,
                    stateSave: false,
                    dom: 'rt',
                    responsive: {
                        details: {
                            type: 'column'
                        }
                    },
                    ajax: {
                        url: '{{ url('/piptotalpriori/ejecucion/estado/filter') }}',
                        type: 'POST',
                        data: function(d) {
                            d.id = $id;
                        },
                    },
                    columnDefs: [{
                            className: "dt-center",
                            targets: "_all"
                        },
                        {
                            orderable: false,
                            targets: 0,
                            render: function(data, type, full, meta) {

                                bEdit =
                                    "<button type='button' class='btn btn-primary' onclick='loadfrmEdit(" +
                                    data +
                                    ")'><i id='E' class='fa fa-pencil' aria-hidden='true'></i></button> ";
                                bDelete =
                                    "<button type='button' class='btn btn-danger' onclick='deleteEstado(" +
                                    data +
                                    ")'><i id='S' class='fa fa-trash' aria-hidden='true'></i></button> ";

                                return bEdit + bDelete;
                            }
                        }


                    ],
                    language: {
                        "sProcessing": "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                        "sLengthMenu": "Mostrar _MENU_",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Vacio",
                        "sInfoFiltered": "(filtrado de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'accion',
                            orderable: false,
                            searchable: false,
                            width: '10%'
                        },
                        {
                            data: 'fecha_act',
                            name: 'fecha_act',
                            width: '8%'
                        },
                        {
                            data: 'etapa',
                            name: 'etapa',
                            width: '8%'
                        },
                        {
                            data: 'sub_etapa',
                            name: 'sub_etapa',
                            width: '7%',
                            orderable: false
                        },
                        {
                            data: 'est_situ',
                            name: 'est_situ',
                            width: '7%',
                            orderable: false
                        },
                        {
                            data: 'a_fisico',
                            name: 'a_fisico',
                            width: '5%'
                        }
                    ]
                });

                $.fn.dataTable.ext.errMode = 'none';
            }, 2000);
        }

        deleteEstado = function($id) {
            var id = $id;
            swal({
                title: '¿Estas seguro?',
                text: "Se eliminara la ejecucion registrada",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No, cancelar!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true
            }).then(function() {
                $.ajax({
                    url: "/piptotalpriori/ejecucion/estado/delete",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        swal(
                            'Listo',
                            'Se ha eliminado el estado',
                            'success'
                        )

                        tableObras.ajax.reload(null, false);
                    },
                    error: function(e) {
                        swal(
                            'Error',
                            'Error al eliminar estado',
                            'error'
                        )
                    }
                });

            }, function(dismiss) {

                swal(
                    'Cancelado',
                    'Operación cancelada',
                    'error'
                )

            }).catch(swal.noop);
        }

        deleteImg = function($id, $idtaller) {
            var id = $id;
            swal({
                title: '¿Estas seguro?',
                text: "Se eliminara esta imagen",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No, cancelar!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true
            }).then(function() {
                $.ajax({
                    url: "/piptotalpriori/ejecucion/estado/img/delete",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        cargarImg($idtaller);

                        swal(
                            'Listo',
                            'Se ha eliminado la imagen',
                            'success'
                        )

                        tableObras.ajax.reload(null, false);
                    },
                    error: function(e) {
                        swal(
                            'Error',
                            'Error al eliminar la imagen',
                            'error'
                        )
                    }
                });

            }, function(dismiss) {

                swal(
                    'Cancelado',
                    'Operación cancelada',
                    'Error'
                )

            }).catch(swal.noop);
        };

        showImgData = function($id) {
            $.ajax({
                url: '/piptotalpriori/ejecucion/estado/img/meta',
                type: 'POST',
                data: {
                    'id': $id
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(response) {
                    $('#modal_simple .modal-title').html($(response).filter('.cabecera'));
                    $('#modal_simple .modal-body').html($(response).filter('#container'));
                    $('#modal_simple .modal-footer').append($(response).filter('.pie'));
                    $('#modal_simple').modal('show', {
                        backdrop: 'true'
                    });
                },
                complete: function(response) {
                    $("#loader").hide();
                }
            });
        };

        valorizacionSubmit = function(frm) {
            event.preventDefault();


            $.ajax({
                url: '/piptotalpriori/ejecucion/estado/add',
                type: 'POST',
                data: $(frm).serialize(),
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(response) {
                    swal(
                        'Listo',
                        response,
                        'success'
                    )
                },
                complete: function(response) {
                    $("#loader").hide();
                    updateTables();
                }
            });
        };

        updateTables = function() {
            table.ajax.reload(null, false);
            tableObras.ajax.reload(null, false);
        }

        function btnState(actual) {
            if (actual > 0) {
                $('.modal-scrollable #submit-allObraEstado').show();
                $('.modal-scrollable #btnAddPhotoObraEstado').css('display', 'none');
            } else {
                $('.modal-scrollable #submit-allObraEstado').css('display', 'none');
                $('.modal-scrollable #btnAddPhotoObraEstado').show();
            }
        }

        dzoneclick = function() {
            $('.modal-scrollable #dzoneObraEstado').trigger('click');
        };

        fireDZ = function(id) {
            var id = id;
            var counter = 0;
            var actual = 0;
            var cleanUp = true;
            $("#full-width #dzoneObraEstado").dropzone({
                uploadMultiple: true,
                autoProcessQueue: false,
                maxFiles: 1,
                parallelUploads: 1,
                maxFilesize: 250,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.mp4,.mkv,.avi",
                previewsContainer: '#dropzonePreviewAntesObraEstado',
                previewTemplate: document.querySelector('.modal-scrollable #preview-template-ObraEstado')
                    .innerHTML,
                addRemoveLinks: true,
                dictRemoveFile: 'Quitar',
                //dictFileTooBig: 'La imagen es mayor a 8MB',
                dictRemoveFileConfirmation: "¿Estas seguro que deseas quitar esta imagen?",
                // The setting up of the dropzone
                createImageThumbnails: true,
                maxThumbnailFilesize: 100,

                init: function() {
                    var dzuid = id;

                    var submitButton = document.querySelector(".modal-scrollable #submit-allObraEstado");
                    myDropzone = this; // closure

                    submitButton.addEventListener("click", function(event) {
                        event.preventDefault();

                        myDropzone.processQueue(); // Tell Dropzone to process all queued files.


                    });

                    $('input[type=radio][name=tipo]').change(function() {
                        cleanUp = false;
                        btnState(actual);
                    });
                    this.on("addedfile", function(file) {
                        actual++;
                        console.log(file);
                        btnState(actual);
                    });
                    this.on("maxfilesexceeded", function() {
                        swal(
                            'Error',
                            'Solo Puede subir una imagen!',
                            'error'
                        );
                    });
                    indx = 0;
                    this.on("sendingmultiple", function(file, xhr, formData) {
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        var uid = id;
                        var nDate = new Date(file[0].lastModified)



                        var datestring = nDate.getFullYear() + "-" +
                            ("0" + (nDate.getMonth() + 1)).slice(-2) + "-" +
                            ("0" + nDate.getDate()).slice(-2) + " " +
                            ("0" + nDate.getHours()).slice(-2) + ":" +
                            ("0" + nDate.getMinutes()).slice(-2) + ":" +
                            ("0" + nDate.getSeconds()).slice(-2);

                        console.log(JSON.stringify(file[0]));
                        formData.append('uid', id);
                        formData.append('fecha', datestring);
                        formData.append('cdata', file[0].lastModifiedDate + ";" + file[0].name +
                            ";" + file[0].lastModified);
                        formData.append('_token', csrf_token);
                    });
                    this.on("error", function(file) {
                        if (!file.accepted) this.removeFile(file);
                    });
                    this.on("removedfile", function(file) {
                        actual--;
                        btnState(actual);
                    });
                },
                error: function(file, response) {
                    $('.modal-scrollable .validation-message').remove();
                    if (response.error) {

                        if (response.messages) {
                            var li = "";
                            $.each(response.messages, function(index, value) {
                                li += "<li>" + value + "</li>";
                            });

                            $('#message').prepend(
                                '<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                li + '</div>');

                            swal(
                                'Error',
                                'Error al subir la imagen, intentelo nuevamente!',
                                'error'
                            );
                        } else if (response.message) {
                            $('modal-scrollable .validation-message').remove();
                            var li = "";

                            $('#message').prepend(
                                '<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                response.message + '</div>');

                            swal(
                                'Error',
                                response.message,
                                'error'
                            );
                        }
                    }

                },
                success: function(file, response) {
                    $('modal-scrollable .validation-message').remove();
                    var myDropzone = this;
                    $('.serverfilename', file.previewElement).val(response.filename);
                    counter++;
                    $("#photoCounterAntes").text("(" + counter + ")");

                    //$('#message').html('<div class=\'alert alert-success fade in\'>La imagen se Guardó Exitosamente</div>');
                    cargarImg(id);
                    cleanUp = false;
                    myDropzone.removeAllFiles();
                    swal(
                        'Correcto',
                        'La imágen se guardó correctamente',
                        'success'
                    );
                    //$("#poitaller-table").ajax.reload();
                }
            });
        };

        //============= TAB GALERIA ================
        //CARGA DE IMAGENES DE SERVIDOR
        //cargarImg();
        $("#tabGaleria").click(function() {
            cargarImg();
        });
        //OLD GALERY
        $(function() {
            $('#submit-all').attr('disabled', 'disabled').addClass('btn btn-alert');
            var counter = 0;
            var actual = 0;
            var cleanUp = true;


            $('#fecha').change(function() {
                obtnState();
            });
            $('#fecha').keyup(function() {
                console.log(actual + counter);
                obtnState();
            });

            Dropzone.options.dzone = {

                uploadMultiple: true,
                autoProcessQueue: false,
                maxFiles: 8,
                parallelUploads: 8,
                maxFilesize: 250,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",

                previewsContainer: '#dropzonePreviewAntes',
                previewTemplate: document.querySelector('#preview-template').innerHTML,
                addRemoveLinks: true,
                dictRemoveFile: 'Quitar',
                //dictFileTooBig: 'La imagen es mayor a 8MB',
                dictRemoveFileConfirmation: "¿Estas seguro que deseas borrar esta imagen?",
                //enqueueForUpload: false,
                // The setting up of the dropzone
                /*createImageThumbnails: true,
                 maxThumbnailFilesize: 100,*/

                init: function() {
                    // Add server images
                    //var myDropzone = this;

                    //console.log(actual);
                    uid = document.getElementById('uid').value;

                    var submitButton = document.querySelector("#submit-all");
                    myDropzone = this; // closure

                    submitButton.addEventListener("click", function(event) {
                        event.preventDefault();
                        if ($('#fecha').val() !== '') {
                            myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                        } else {
                            $('#submit-all').attr('disabled', 'disabled').addClass('btn btn-alert');
                        }

                    });

                    $('input[type=radio][name=tipo]').change(function() {
                        cleanUp = false;
                        //$('#fecha').val('');
                        //$('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
                        //counter = 0;
                        //actual  = 0;
                        //myDropzone.removeAllFiles();
                        obtnState();
                        cleanUp = true;
                    });
                    this.on("addedfile", function() {
                        actual++;
                        console.log(actual);
                        obtnState();
                    });
                    this.on("maxfilesexceeded", function() {
                        alert("Limite de Imagenes Excedido");
                    });
                    indx = 0;
                    this.on("sendingmultiple", function(file, xhr, formData) {
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        uid = document.getElementById('uid').value;
                        console.log(uid);

                        @if (count($Obras) > 1)
                            formData.append('idObra', $('input[name=optObra]:checked').val());
                        @endif

                        formData.append('descripcion', $('#txtDescripcion').val());
                        formData.append('tipo', $('input[name=tipo]:checked').val());
                        formData.append('uid', uid);
                        formData.append('fecha', $('#fecha').val());
                        formData.append('_token', csrf_token);
                        formData.append('cantidad', counter);
                    });
                    this.on("error", function(file) {
                        if (!file.accepted) this.removeFile(file);
                    });
                    this.on("removedfile", function(file) {
                        if (cleanUp) {
                            $.ajax({
                                type: 'POST',
                                url: 'upload/delete',
                                data: {
                                    id: $('.serverfilename', file.previewElement).val(),
                                    uid: document.getElementById('uid').value,
                                    _token: $('#csrf-token').val()
                                },
                                dataType: 'html',
                                success: function(data) {
                                    var rep = JSON.parse(data);
                                    if (rep.code === 200) {
                                        counter--;
                                        $("#photoCounterAntes").text("(" + counter +
                                            ")");
                                    }

                                }
                            });
                        }
                        counter--;
                        obtnState();

                    });

                },
                error: function(file, response) {
                    $('#message').html(
                        '<div class=\'alert alert-danger fade in\'>Error al guardar las imagenes, intentelo nuevamente</div>'
                        );
                    cleanUp = false;
                    myDropzone.removeAllFiles();
                    swal(
                        'Error',
                        'Error al subir las imagenes, intentelo nuevamente!',
                        'error'
                    );
                },
                success: function(file, response) {
                    var myDropzone = this;
                    $('.serverfilename', file.previewElement).val(response.filename);
                    counter++;
                    $("#photoCounterAntes").text("(" + counter + ")");

                    $('#message').html(
                        '<div class=\'alert alert-success fade in\'>Las imagenes se Guardaron Exitosamente</div>'
                        );
                    cargarImg();
                    cleanUp = false;
                    myDropzone.removeAllFiles();
                    swal(
                        'Correcto',
                        'Las imagenes se guardaron correctamente',
                        'success'
                    );

                }
            };

            function obtnState() {
                if ($('#fecha').val() !== '' && actual + counter >= 3 && $('input[name=tipo]').is(':checked') ===
                    true) {
                    $('#submit-all').removeAttr('disabled').addClass('btn btn-success');
                } else {
                    $('#submit-all').attr('disabled', 'disabled').addClass('btn btn-alert');
                }
                console.log($('input[name=tipo]').is(':checked'));
                console.log($('#fecha').val());

            }

        });
        //AJAX REQUEST ON IMAGE UPLOAD ->
        cargarImg = function() {
            uid = document.getElementById('uid').value;
            $.get('/getServer-images/' + uid.toString(), function(data) {
                $('#antes').html('');
                $('#durante').html('');
                $('#despues').html('');


                if (data.antes.length != 0) {
                    $.each(data.antes, function(key, value) {

                        url = value.url;
                        $('#antes').append(
                            '<a style="margin-right:8px" class="fancybox" rel="group" href="' +
                            url + '"><img width=150px height=150px src="' + url + '" alt="" /></a>');

                        //$('#antes').append('<img class=\'fancybox\' src=\''+ url +'\'  data-big=\' '+ url +' \' style=\'border-width:0px;width:280px; height:280px;\'>');
                        $('#foto_antes').text(' Fecha: ' + value.fecha);
                    });

                } else {
                    $('#antes').append('<h4>No hay imagenes disponibles</h4>');
                }

                if (data.durante.length != 0) {

                    $.each(data.durante, function(key, value) {
                        url = value.url;
                        $('#durante').append(
                            '<a style="margin-right:8px" class="fancybox" rel="group" href="' +
                            url + '"><img width=150px height=150px src="' + url + '" alt="" /></a>');
                        $('#foto_durante').text(' Fecha: ' + value.fecha);
                    });
                } else {
                    $('#durante').append('<h4>No hay imagenes disponibles</h4>');
                }

                if (data.despues != '') {
                    $.each(data.despues, function(key, value) {

                        url = value.url;
                        $('#despues').append(
                            '<a style="margin-right:8px" class="fancybox" rel="group" href="' +
                            url + '"><img width=150px height=150px src="' + url +
                            '" alt="" /></a>&nbsp;&nbsp');
                        $('#foto_despues').text(' Fecha: ' + value.fecha);
                    });
                } else {
                    $('#despues').append('<h4>No hay imagenes disponibles</h4>');
                }
            }).fail(function() {
                console.log("herror");
            });
        };
    </script>


    <!-- ========================================= LIBS ======================================= -->
    <script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBea_vgTFolz7EGBG32BaUeR0FvFJbpdrQ&libraries=places&callback=initMap">
    </script>

@endsection
