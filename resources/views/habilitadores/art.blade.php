@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="{{ asset('tooltip/css/tooltipster.bundle.min.css') }}" rel="stylesheet" type="text/css"/>

    <style type="text/css">

        .vcenter {
            vertical-align: middle !important;
        }

        /*Si el valor que el usuario escribe es valido, obtendra un color verde*/
        tr td input[type="text"]:required:valid{
            border:2px solid green;
        /* otras propiedades */
        }
        /*caso contrario, el color sera rojo*/
        tr td input[type="text"]:focus:required:invalid{
            border:2px solid red;
        /* otras propiedades */
        }
    
        #documento input[type="text"]:required:valid{
            border:2px solid green;
        /* otras propiedades */
        }
        /*caso contrario, el color sera rojo*/
        #documento input[type="text"]:focus:required:invalid{
            border:2px solid red;
        /* otras propiedades */
        }

        button.dt-button, div.dt-button, a.dt-button{
            background: #008d4c !important;
            color: #fff;
        }
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {

            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.3);
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 1500ms infinite linear;
            -moz-animation: spinner 1500ms infinite linear;
            -ms-animation: spinner 1500ms infinite linear;
            -o-animation: spinner 1500ms infinite linear;
            animation: spinner 1500ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */
        @-webkit-keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }
        @-moz-keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }
        @-o-keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }
        @keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }

        .scrollbar
        {
            float: left;
            height: 300px;
            background: #F5F5F5;
            overflow-y: scroll;
            margin-bottom: 25px;
        }

        .force-overflow
        {
            min-height: 450px;
        }


        /*
        *  STYLE 3
        */

        #style-3::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar
        {
            width: 6px;
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar-thumb
        {
            background-color: #000000;
        }


            .nav-side-menu {
            overflow: auto;
            font-family: verdana;
            font-size: 12px;
            font-weight: 200;
            background-color: #2e353d;
            position: fixed;
            top: 0px;
            width: 300px;
            height: 100%;
            color: #e1ffff;
            }
            .nav-side-menu .brand {
            background-color: #23282e;
            line-height: 50px;
            display: block;
            text-align: center;
            font-size: 14px;
            }
            .nav-side-menu .toggle-btn {
            display: none;
            }
            .nav-side-menu ul,
            .nav-side-menu li {
            list-style: none;
            padding: 0px;
            margin: 0px;
            line-height: 35px;
            cursor: pointer;
            /*
                .collapsed{
                .arrow:before{
                            font-family: FontAwesome;
                            content: "\f053";
                            display: inline-block;
                            padding-left:10px;
                            padding-right: 10px;
                            vertical-align: middle;
                            float:right;
                        }
                }
            */
            }
            .nav-side-menu ul :not(collapsed) .arrow:before,
            .nav-side-menu li :not(collapsed) .arrow:before {
            font-family: FontAwesome;
            content: "\f078";
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;
            vertical-align: middle;
            float: right;
            }
            .nav-side-menu ul .active,
            .nav-side-menu li .active {
            border-left: 3px solid #d19b3d;
            background-color: #4f5b69;
            }
            .nav-side-menu ul .sub-menu li.active,
            .nav-side-menu li .sub-menu li.active {
            color: #d19b3d;
            }
            .nav-side-menu ul .sub-menu li.active a,
            .nav-side-menu li .sub-menu li.active a {
            color: #d19b3d;
            }
            .nav-side-menu ul .sub-menu li,
            .nav-side-menu li .sub-menu li {
            background-color: #181c20;
            border: none;
            line-height: 28px;
            border-bottom: 1px solid #23282e;
            margin-left: 0px;
            }
            .nav-side-menu ul .sub-menu li:hover,
            .nav-side-menu li .sub-menu li:hover {
            background-color: #020203;
            }
            .nav-side-menu ul .sub-menu li:before,
            .nav-side-menu li .sub-menu li:before {
            font-family: FontAwesome;
            content: "\f105";
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;
            vertical-align: middle;
            }
            .nav-side-menu li {
            padding-left: 0px;
            border-left: 3px solid #2e353d;
            border-bottom: 1px solid #23282e;
            }
            .nav-side-menu li a {
            text-decoration: none;
            color: #e1ffff;
            }
            .nav-side-menu li a i {
            padding-left: 10px;
            width: 20px;
            padding-right: 20px;
            }
            .nav-side-menu li:hover {
            border-left: 3px solid #d19b3d;
            background-color: #4f5b69;
            -webkit-transition: all 1s ease;
            -moz-transition: all 1s ease;
            -o-transition: all 1s ease;
            -ms-transition: all 1s ease;
            transition: all 1s ease;
            }
            @media (max-width: 767px) {
            .nav-side-menu {
                position: relative;
                width: 100%;
                margin-bottom: 10px;
            }
            .nav-side-menu .toggle-btn {
                display: block;
                cursor: pointer;
                position: absolute;
                right: 10px;
                top: 10px;
                z-index: 10 !important;
                padding: 3px;
                background-color: #ffffff;
                color: #000;
                width: 40px;
                text-align: center;
            }
            .brand {
                text-align: left !important;
                font-size: 22px;
                padding-left: 20px;
                line-height: 50px !important;
            }
            }
            @media (min-width: 767px) {
            .nav-side-menu .menu-list .menu-content {
                display: block;
            }
            }
    </style>
@endsection

@section('body')
    @php
        setlocale(LC_TIME, "spanish");
        $year= date("Y");
        $dia= date("d");
    @endphp
    <div class="well">
        <div class="text-center">
            <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">INVERSIONES NO PREVISTAS</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="input-group input-group">
                <input type="text" class="form-control" id="codigo" placeholder="Ingrese Codigo">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat" id="busqueda"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div id="cargando" class="loading" style="display: none;"></div>
    <div class="table-responsive" id="data1">
        <div class="box-body">
            <div class="box box-default">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="7" style="text-align: center;">HABILITADOR</th>
                            <th colspan="4" style="text-align: center;">PROGRAMACION MULTIANUAL - CARTERA GRL</th>
                        </tr>
                        <tr>                						
                            <th style="text-align: center;">UEI</th>
                            <th style="text-align: center;">CUI</th>
                            <th style="text-align: center;">NOMBRE DE LA INVERSION</th>
                            <th style="text-align: center;">COSTO DE INVERSION ACTUALIZADO {{ $year - 1}}</th>
                            <th style="text-align: center;">DEVENGADO ACUMULADO</th>
                            <th style="text-align: center;">DEVENGADO {{ $year }}</th>
                            <th style="text-align: center;">SALDO POR EJECUTAR {{ $year }}</th>
                            <th style="text-align: center;">PIM {{ $year }}</th>
                            <th style="text-align: center;">PMI {{ $year  + 1 }}</th>
                            <th style="text-align: center;">PMI {{ $year  + 2 }}</th>
                            <th style="text-align: center;">PMI {{ $year  + 3 }}</th>
                            <th style="text-align: center;">EXPEDIENTE TECNICO N°</th>
                            <th style="text-align: center;">COMPROMISOS A REALIZAR {{ $year }}</th>
                            <th style="text-align: center;">SALDO DEL PIM {{ $year }}</th>
                            <th style="text-align: center;">SOLICITUD DE ANULACION</th>
                            <th style="text-align: center;">NUEVO SALDO DE INVERSION</th>
                            <th style="text-align: center;">PIM {{ $year }} MODIFICADO</th>		  	
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="data1_body">
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive" id="data2">
        <div class="box-body">
            <div class="box box-default">
                <table class="table table-bordered">
                    <thead>
                    </thead>
                    <tbody id="data2_body">
                        <tr>
                            <th></th>
                            <th colspan="2">UEI</th>
                        </tr>
                        <tr>
                            <th >DATOS GENERALES</th>
                            <th colspan="2">INVERSION HABILITADOR (1)</th>
                        </tr>
                        <tr id="nombre">
                            <th>NOMBRE</th>
                        </tr>   
                        <tr id="cui">
                            <th>CUI</th>
                        </tr>
                        <tr id="tipo_inv">
                            <th>PIP / IOARR</th>
                        </tr>
                        <tr id="monto_act">
                            <th>MONTO ACTUALIZADO</th>
                        </tr>
                        <tr id="f_viable">
                            <th>¿ESTA VIABLE O APROBADA?</th>
                        </tr>
                        <tr id="activo">
                            <th>¿ESTA ACTIVO?</th>
                        </tr>
                        <tr id="por_ejec">
                            <th>¿ESTA EN ETAPA DE EJECUCION?</th>
                        </tr>
                        <tr id="situacion">
                            <th>EXISTE IMPEDIMENTO COMPROBABLE QUE RETRASE/INVIABLE O SE ENCUENTRE CULMINADA</th>
                        </tr>
                        <tr id="potencial_rd">
                            <th>POTENCIAL DE RECURSOS DISPONIBLES</th>
                        </tr>
                        <tr id="estado">
                            <th>ESTADO</th>
                        </tr>
                        <!--<tr id="situacion">
                            <th>SITUACION</th>
                        </tr>-->
                        <tr id="etapa">
                            <th>ETAPA / META</th>
                        </tr>
                        <tr id="pim">
                            <th>PIM 2021</th>
                        </tr>
                        <tr id="m_anulacion">
                            <th>MONTO ANULACION</th>
                        </tr>
                        <tr id="m_credito">
                            <th>MONTO CREDITO</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="noprevistas" class="col-md-12" style="display:none;" >
        <div class="box box-default">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <h3 class="profile-username text-center" id="nombre" style="text-align: center"></h3>
                            <p class="text-muted text-center" id="uei"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box-body">
                            <div class="box-body box-profile">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Se encuentra viables o aprobadas</b> <a class="pull-right" id="respuesta_1"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Estado activo en el Banco de Inversiones</b> <a class="pull-right" id="respuesta_2"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Cuenta con Expediente Tecnico o ET, vigente </b> <a class="pull-right" target="_blank" id="respuesta_3"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Cuenta con Formato 12B</b> <a class="pull-right" target="_blank" id="respuesta_4"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>UEI adscrita en GRL</b> <a class="pull-right" target="_blank" id="respuesta_5"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Costo Actualizado</b> <a class="pull-right" id="respuesta_6"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Saldo por Ejecutar</b> <a class="pull-right" id="respuesta_7"></a>
                                    </li>
                                    <li class="list-group-item" style="border-bottom: none;">
                                        <b>Brechas identificadas del PMI aprobado</b> <a class="pull-right" id="respuesta_11"></a>
                                        <div id="brecha" class="row col-md-12" ></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <div class="box-body">
                            <div class="box-body box-profile">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>No Prevista</b> <a class="pull-right" target="_blank" id="respuesta_8"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tipo de Proyecto</b> <a class="pull-right" target="_blank" id="respuesta_10"></a>
                                    </li>
                                    <li class="list-group-item" >
                                        <b>Se encuentra programado en el PMI</b> <a class="pull-right" id="respuesta_9"></a>
                                        <div id="brecha" class="row col-md-12" ></div>
                                    </li>
                                    <div class="table-responsive" id="pmi" style="display: none;">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th colspan="4" style="text-align: center;">Programación del monto de inversión (S/)</th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center;">{{ $year }}</th>
                                                    <th style="text-align: center;">{{ $year  + 1 }}</th>
                                                    <th style="text-align: center;">{{ $year  + 2 }}</th>
                                                    <th style="text-align: center;">{{ $year  + 3 }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="pmi_body">
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Prioridad</th>
                                                    <th style="text-align: center;">Orden prelación (*)</th>
                                                    <th style="text-align: center;">OPMI</th>
                                                    <th style="text-align: center;">Nivel Gobierno</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="pmi_body_descripcion">
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="{{ asset('tooltip/js/tooltipster.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mask/jquery.mask.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
         
        function number_format(amount, decimals) {
            if (amount==null) {
            amount=0;
            }
            var sign = (amount.toString().substring(0, 1) == "-");
            amount += ''; // por si pasan un numero en vez de un string
            amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

            decimals = decimals || 0; // por si la variable no fue fue pasada

            // si no es un numero o es igual a cero retorno el mismo cero
            if (isNaN(amount) || amount === 0)
                return parseFloat(0).toFixed(decimals);

            // si es mayor o menor que cero retorno el valor formateado como numero
            amount = '' + amount.toFixed(decimals);

            var amount_parts = amount.split(','),
                regexp = /(\d+)(\d{3})/;

            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

            return sign ? '-' + amount_parts.join('.') : amount_parts.join('.');
        }

        $("#busqueda").click(function() {
            cod_unif = $("#codigo").val();

            $.ajax({
                type:"POST",
                url: '{{ url("/habilitador/data_analisis") }}',
                data: {id :cod_unif},
                beforeSend: function() {
                   $("#cargando").show();
                }
            })
            .done(function(response) {
                html="";
                $total_actualizadof12 = 0;
                $monto_anulado = 362338;
                $devengado_acumulado =0;
                $.each(response.ssi,function(key,value){
                    html += '<td style="text-align: center;">'+ value.DES_UNIDAD_UEI +'</td>';
                    html += '<td style="text-align: center;">'+ value.CODIGO_UNICO +'</td>';
                    html += '<td style="text-align: center;">'+ value.NOMBRE_INVERSION +'</td>';
                    html += '<td style="text-align: center;">'+ number_format(value.COSTO_ACTUALIZADO,2) +'</td>';
                    if(Object.keys(response.pmi).length == 1){
                        $.each(response.pmi,function(key,value){
                            $devengado_acumulado = value.DEVENGADO_ACUMULADO;
                        });
                    }else{
                        $devengado_acumulado = value.DEV_ACUMULADO;                        
                    }
                    html += '<td style="text-align: center;">'+ number_format($devengado_acumulado,2) +'</td>'; 
                    html += '<td style="text-align: center;">'+ number_format(value.DEV_ANO_VIGENTE,2) +'</td>'; 
                    html += '<td style="text-align: center;">'+ number_format(value.COSTO_ACTUALIZADO - $devengado_acumulado - value.DEV_ANO_VIGENTE,2) +'</td>';
                    html += '<td style="text-align: center;">'+ number_format(value.PIM_ANO_VIGENTE,2) +'</td>'; 
                    if(Object.keys(response.pmi).length == 1){
                        $.each(response.pmi,function(key,value){
                            html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO1,2) +'</td>';
                            html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO2,2) +'</td>';
                            html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO3,2) +'</td>';
                        });
                    }else{
                         html += '<td style="text-align: center;" colspan="3">NO ESTA PROGRAMADO POR SER UNA INVERSION DE EMERGENCIA</td>';
                    }
                    html += '<td style="text-align: center;"><a  target="_blank" href="https://ofi5.mef.gob.pe/invierte/ejecucion/verFichaEjecucion/' + value.CODIGO_UNICO + '">' + value.ET_REGISTRADO + " | " + unixdate(value.FECHA_ET) +'</a></td>';
                    $.each(response.f12b,function(key,value){
                        $total_actualizadof12 = value.MONTO_ACTUALIZADO_1 + value.MONTO_ACTUALIZADO_2 + value.MONTO_ACTUALIZADO_3 + value.MONTO_ACTUALIZADO_4 + value.MONTO_ACTUALIZADO_5 + value.MONTO_ACTUALIZADO_6 + value.MONTO_ACTUALIZADO_7 + value.MONTO_ACTUALIZADO_8 + value.MONTO_ACTUALIZADO_9 + value.MONTO_ACTUALIZADO_10 + value.MONTO_ACTUALIZADO_11 + value.MONTO_ACTUALIZADO_12;
                        html += '<td style="text-align: center;">'+ number_format($total_actualizadof12,2) +'</td>'; 
                    })
                    html += '<td style="text-align: center;">'+ number_format(value.PIM_ANO_VIGENTE - $total_actualizadof12,2) +'</td>';
                    html += '<td style="text-align: center;color: red;">-'+ number_format($monto_anulado,2) +'</td>';
                    html += '<td style="text-align: center;">'+ number_format(value.COSTO_ACTUALIZADO - $devengado_acumulado - $total_actualizadof12,2) +'</td>'; 
                    html += '<td style="text-align: center;">'+ number_format(value.PIM_ANO_VIGENTE - $monto_anulado,2) +'</td>';
                });
                $("#data1_body").html(html);

                $.each(response.ssi,function(key,value){
                    $("#nombre").append("<td colspan='2'>" + value.NOMBRE_INVERSION + "</td>");
                    $("#cui").append("<td colspan='2'>" + value.CODIGO_UNICO + "</td>");
                    $("#tipo_inv").append("<td colspan='2'>" + value.TIPO_FORMATO + "</td>");
                    if(Object.keys(response.pmi).length == 1){
                        $.each(response.pmi,function(key,value){
                            $("#monto_act").append("<td colspan='2'>"+ number_format(value.COSTO,2) + "</td>");
                            $("#pim").append("<td colspan='2'>"+ number_format(value.PROGRAMACION_INVERSION_ANIO0,2) + "</td>");
                        });
                    }else{
                        $("#monto_act").append("<td colspan='2'>"+ number_format(value.COSTO_ACTUALIZADO,2) + "</td>");
                    }
                    $("#f_viable").append("<td colspan='2'>" + unixdate(value.FEC_VIABLE) + "</td>");
                    $("#activo").append("<td colspan='2'>" + value.ESTADO + "</td>");
                    $.each(response.f12b,function(key,value){
                         $("#por_ejec").append("<td colspan='2'>" + number_format((value.DEV_ACUMULADO/value.COSTO_ACTUALIZADO)*100,1)  + "</td>");
                         $("#situacion").append("<td colspan='2'>" + value.ULT_ESTADO_SITUACIONAL + "</td>");
                    })

                    
                })



                // $.each(response.ssi,function(key,value){
                //     $("#nombre").text(value.NOMBRE_INVERSION);
                //     if(response.DES_UNIDAD_UEI !== null){
                //         $("#uei").text(value.DES_UNIDAD_UEI);
                //     }else{
                //         $("#uei").text("SIN UEI");
                //     }
                //     $("#respuesta_1").text(value.SITUACION + " | " + unixdate(value.FEC_VIABLE));
                //     $("#respuesta_2").text(value.ESTADO);
                //     $("#respuesta_3").text(value.ET_REGISTRADO + " | " + unixdate(value.FECHA_ET));
                //     $("#respuesta_3").attr("href","https://ofi5.mef.gob.pe/invierte/ejecucion/verFichaEjecucion/" + value.CODIGO_UNICO );
                //     $("#respuesta_4").text(value.TIENE_F12B);
                //     $("#respuesta_5").text(value.DES_UNIDAD_UEI);
                //     $("#respuesta_6").text(number_format(value.COSTO_ACTUALIZADO,2));
                //     $("#respuesta_7").text(number_format(value.COSTO_ACTUALIZADO - value.DEV_ACUMULADO,2));
                //     $("#respuesta_9").text(value.IND_REG_PMI);
                //     $("#respuesta_10").text(value.TIPO_FORMATO);
                    
                //     if(value.IND_REG_PMI == "SI"){
                //         $("#pmi").show();
                //     }
                    
                // });

                // if (response.proyecto !== null){
                //     $pia =  response.proyecto.pia
                //     $pim =  response.proyecto.pim
                //     if($pia == 0 && $pim >0){
                //         $("#respuesta_8").text('SI');
                //     }else{
                //         $("#respuesta_8").text('NO');
                //     }
                // }else{
                //     $("#respuesta_8").text('No se encuentran programada en la cartera del PMI del año Fiscal');
                // }

                // html="";
                // $.each(response.pmi,function(key,value){
                //     html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO0,2) +'</td>';
                //     html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO1,2) +'</td>';
                //     html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO2,2) +'</td>';
                //     html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO3,2) +'</td>';
                // });
                // html_des="";
                // $.each(response.pmi,function(key,value){
                //     html_des += '<td style="text-align: center;">'+ value.PRIORIDAD +'</td>';
                //     html_des += '<td style="text-align: center;">'+ value.CONDICION_INVERSION +'</td>';
                //     html_des += '<td style="text-align: center;">'+ value.NOMBRE_ENTIDAD +'</td>';
                //     html_des += '<td style="text-align: center;">'+ value.NOMBRE_GOBIERNO +'</td>';
                // });

                // $brechas = response.brechas
                // if($brechas != ""){
                //     $html = $.parseHTML($brechas)
                //     $("#brecha").html($html[0]);
                // }else{
                //     $("#respuesta_11").text("Sin Brechas");
                // }
                

                // $("#pmi_body").html(html);
                // $("#pmi_body_descripcion").html(html_des);
            })
            .fail(function() {
                console.log( "error" );
            })
            .always(function(response) {
                $("#cargando").hide();
                // $("#noprevistas").show();
            });
        });

        unixdate = function(unix){
            if(unix == null){
                return "Sin Fecha";
            }else{
                var regex = /(\d+)/g;
                var unixTimeStamp = unix.match(regex)[0]/1000;
                var timestampInMilliSeconds = unixTimeStamp*1000;
                var date = new Date(timestampInMilliSeconds);

                var day = (date.getDate() < 10 ? '0' : '') + date.getDate();
                var month = (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1);
                var year = date.getFullYear();

                var hours = ((date.getHours() % 12 || 12) < 10 ? '0' : '') + (date.getHours() % 12 || 12);
                var minutes = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
                var meridiem = (date.getHours() >= 12) ? 'pm' : 'am';

                var formattedDate = day + '-' + month + '-' + year;
                return formattedDate;
            }
        }

    });
</script>

@endsection
