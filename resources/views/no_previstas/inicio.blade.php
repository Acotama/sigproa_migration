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
            <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">VERIFICACION DE LOS LINEAMIENTOS PARA LAS MODIFICACIONES DE LA CARTERA DE INVERSIONES COMO INCORPORACIÓN DE INVERSIONES NO PREVISTAS</span>
        </div>
    </div>
    <div id="cargando" class="loading" style="display: none;"></div>
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
    </br>
    <div id="noprevistas" class="col-md-12" style="display:none" >
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
                                        <b>Tipo de Proyecto</b> <a class="pull-right" target="_blank" id="respuesta_10"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Se encuentra viables o aprobadas</b> <i style="font-size: 18px;float: right;" class="icono_1 fa fa-fw"></i> <a class="pull-right" id="respuesta_1"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Estado activo en el Banco de Inversiones</b> <i style="font-size: 18px;float: right;" class="icono_2 fa fa-fw"></i> <a class="pull-right" id="respuesta_2"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Cuenta con Expediente Tecnico o ET, vigente </b> <i style="font-size: 18px;float: right;" class="icono_3 fa fa-fw"></i> <a class="pull-right" target="_blank" id="respuesta_3"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Cuenta con Formato 12B</b> <i style="font-size: 18px;float: right;" class="icono_4 fa fa-fw"></i> <a class="pull-right" target="_blank" id="respuesta_4"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>UEI adscrita en GRL</b> <i style="font-size: 18px;float: right;color:green" class="icono_5 fa fa-fw fa-check"></i> <a class="pull-right" target="_blank" id="respuesta_5"></a>
                                    </li>
                                    <li class="list-group-item" style="border-bottom: none;">
                                        <b>Brechas identificadas del PMI aprobado</b>  <i style="font-size: 18px;float: right;" class="icono_11 fa fa-fw"></i> <a class="pull-right" id="respuesta_11"></a>
                                        <div id="brecha" class="table-responsive" style="display:none">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;" width="25%">Servicio Público con Brecha identificada y priorizada</th>
                                                        <th style="text-align: center;" width="25%">Indicador de brechas de acceso a servicios</th>
                                                        <th style="text-align: center;" width="10%">Unidad de medida</th>
                                                        <th style="text-align: center;" width="10%">Espacio geográfico</th>
                                                        <th style="text-align: center;" width="20%">Función</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="brecha_cuerpo">
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                    <!--<li class="list-group-item">
                                        <b>No Prevista</b> <a class="pull-right" target="_blank" id="respuesta_8"></a>
                                    </li>-->
                                    <li class="list-group-item" >
                                        <b>Se encuentra programado en el PMI</b> <i style="font-size: 18px;float: right;" class="icono_9 fa fa-fw"></i> <a class="pull-right" id="respuesta_9"></a>
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
                    <div  class="col-md-6">
                        <div class="box-body">
                            <div class="box-body box-profile">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b> INFORMACIÓN FINANCIERA (S/)</b>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td width="35%" style="vertical-align: middle;font-weight: bold;">COSTO DE INVERSIÓN TOTAL (a)</td>
                                                    <td width="15%" id="td_mtototal" style="vertical-align: middle;"></td>
                                                    <td width="35%" style="vertical-align: middle;font-weight: bold;">PIM 2021 (c)</td>
                                                    <td width="15%" id="val_pim" style="vertical-align: middle;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: middle;font-weight: bold;">DEVENGADO ACUMULADO AL 2021 (b) </td>
                                                    <td id="val_devacu" style="vertical-align: middle;"></td>
                                                    <td style="vertical-align: middle;font-weight: bold;">DEVENGADO 2021 (d)</td>
                                                    <td id="val_avan" style="vertical-align: middle;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: middle;font-weight: bold;"> AVANCE FINANCIERO ACUMULADO (b/a)</td>
                                                    <td id="por_avanacum" style="vertical-align: middle;"></td>
                                                    <td style="vertical-align: middle;font-weight: bold;">AVANCE FINANCIERO 2021 (d/c) </td>
                                                    <td id="por_avananio" style="vertical-align: middle;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: middle;font-weight: bold;">SALDO POR EJECUTAR (a-b)</td>
                                                    <td id="sdo_ejecacum" style="vertical-align: middle;"></td>
                                                    <td style="vertical-align: middle;font-weight: bold;">SALDO POR DEVENGAR 2021 (c-d)</td>
                                                    <td id="sdo_ejecanio" style="vertical-align: middle;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: middle;font-weight: bold;">FECHA DEL PRIMER DEVENGADO</td>
                                                    <td id="pridev" style="vertical-align: middle;"></td>
                                                    <td style="vertical-align: middle;font-weight: bold;"> FECHA DEL ÚLTIMO DEVENGADO</td>
                                                    <td id="ultdev"  style="vertical-align: middle;"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
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
    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
         
        $('#tooltip_nombrepry').tooltipster({
            animation: 'fade',
            delay: 200,
            theme: 'tooltipster-punk',
            trigger: 'click'
        });

        $('#tooltip_accion').tooltipster({
            animation: 'fade',
            delay: 200,
            theme: 'tooltipster-punk',
            trigger: 'click'
        });

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
            // Fechas hoy
            var date = moment().format('YYYY-MM-DD');
            // date = moment(date);
            $.ajax({
                type:"POST",
                url: '{{ url("/noprevistas/data") }}',
                data: {id :cod_unif},
                beforeSend: function() {
                   $("#cargando").show();
                }
            })
            .done(function(response) {
                $.each(response.ssi,function(key,value){
                    $("#nombre").text(value.NOMBRE_INVERSION);
                    if(response.DES_UNIDAD_UEI !== null){
                        $("#uei").text(value.DES_UNIDAD_UEI);
                    }else{
                        $("#uei").text("SIN UEI");
                    }
                    $anio = 1;
                    if(value.TIPO_FORMATO == 'PROYECTO DE INVERSION'){
                        $anio = 3;
                    }
                    if(value.FEC_VIABLE !== null){
                        $("#respuesta_1").text(value.SITUACION + " | " + unixdate(value.FEC_VIABLE)); 	
                        fecha_viable = moment(value.FEC_VIABLE).format('YYYY-MM-DD');
                        fecha_viable = moment(fecha_viable);
                        fecha_viable = fecha_viable.add($anio, 'year').format('YYYY-MM-DD'); 
                        if(date > fecha_viable){
                            $(".icono_1").addClass("fa-close");
                            $(".icono_1").removeClass("fa-check");
                            $(".icono_1").css("color", "red");
                        }else{
                            $(".icono_1").addClass("fa-check");
                            $(".icono_1").removeClass("fa-close");
                            $(".icono_1").css("color", "green");
                        }
                    }else{
                        $("#respuesta_1").text("NO VIABLE"); 
                        $(".icono_1").addClass("fa-close");
                        $(".icono_1").removeClass("fa-check");
                        $(".icono_1").css("color", "red");
                    }
                    $("#respuesta_2").text(value.ESTADO);
                    if(value.ESTADO = "ACTIVO"){
                        $(".icono_2").addClass("fa-check");
                        $(".icono_2").removeClass("fa-close");
                        $(".icono_2").css("color", "green");
                    }else{
                        $(".icono_2").addClass("fa-close");
                        $(".icono_2").removeClass("fa-check");
                        $(".icono_2").css("color", "red");
                    }
                    if(response.et.et !== 'SIN ET'){
                        $("#respuesta_3").text(response.et.nombre + " | " + response.et.fecha);
                        $("#respuesta_3").attr("href","https://ofi5.mef.gob.pe/invierte/ejecucion/verFichaEjecucion/" + value.CODIGO_UNICO);
                        fecha_et = moment(response.et.fecha).format('YYYY-MM-DD');
                        fecha_et = moment(fecha_et);
                        fecha_et = fecha_et.add($anio, 'year').format('YYYY-MM-DD'); 
                        if(date > fecha_et){
                            $(".icono_3").addClass("fa-close");
                            $(".icono_3").removeClass("fa-check");
                            $(".icono_3").css("color", "red");
                        }else{
                            $(".icono_3").addClass("fa-check");
                            $(".icono_3").removeClass("fa-close");
                            $(".icono_3").css("color", "green");
                        }
                    }else{
                        $("#respuesta_3").text(response.et.et);
                        $(".icono_3").addClass("fa-close");
                        $(".icono_3").removeClass("fa-check");
                        $(".icono_3").css("color", "red");
                    }
                    $("#respuesta_4").text(value.TIENE_F12B);
                    if(value.TIENE_F12B = "SI"){
                        $(".icono_4").addClass("fa-check");
                        $(".icono_4").removeClass("fa-close");
                        $(".icono_4").css("color", "green");
                    }else{
                        $(".icono_4").addClass("fa-close");
                        $(".icono_4").removeClass("fa-check");
                        $(".icono_4").css("color", "red");
                    }
                    $("#respuesta_5").text(value.DES_UNIDAD_UEI);
                    $("#respuesta_9").text(value.IND_REG_PMI);
                    $("#respuesta_10").text(value.TIPO_FORMATO);
                    funcion = value.TIPO_FORMATO.FUNCION;   
                    if(value.IND_REG_PMI == "SI"){
                        $("#pmi").show();
                        $(".icono_9").addClass("fa-check");
                        $(".icono_9").removeClass("fa-close");
                        $(".icono_9").css("color", "green");

                    }else{
                        $(".icono_9").addClass("fa-close");
                        $(".icono_9").removeClass("fa-check");
                        $(".icono_9").css("color", "red");
                    }
                    $("#td_mtototal").text(number_format(value.COSTO_ACTUALIZADO,2));
                    $("#val_pim").text(number_format(value.PIM_ANO_VIGENTE,2));
                    $("#val_devacu").text(number_format(value.DEV_ACUMULADO,2));
                    $("#val_avan").text(number_format(value.DEV_ANO_VIGENTE,2));
                    $("#por_avanacum").text(number_format(value.DEV_ACUMULADO/value.COSTO_ACTUALIZADO,2) + "%");
                    $("#por_avananio").text(number_format(value.DEV_ANO_VIGENTE/value.PIM_ANO_VIGENTE,2) + "%");
                    $("#sdo_ejecacum").text(number_format(value.COSTO_ACTUALIZADO - value.DEV_ACUMULADO,2));
                    $("#sdo_ejecanio").text(number_format(value.PIM_ANO_VIGENTE - value.DEV_ANO_VIGENTE,2));
                    $("#pridev").text(value.MES_ANO_PRI_DEV);
                    $("#ultdev").text(value.MES_ANO_ULT_DEV);
                });

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

                html="";
                $.each(response.pmi,function(key,value){
                    html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO0,2) +'</td>';
                    html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO1,2) +'</td>';
                    html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO2,2) +'</td>';
                    html += '<td style="text-align: center;">'+ number_format(value.PROGRAMACION_INVERSION_ANIO3,2) +'</td>';
                });
                $("#pmi_body").html(html);
                html_des="";
                $.each(response.pmi,function(key,value){
                    html_des += '<td style="text-align: center;">'+ value.PRIORIDAD +'</td>';
                    html_des += '<td style="text-align: center;">'+ value.CONDICION_INVERSION +'</td>';
                    html_des += '<td style="text-align: center;">'+ value.NOMBRE_ENTIDAD +'</td>';
                    html_des += '<td style="text-align: center;">'+ value.NOMBRE_GOBIERNO +'</td>';
                });
                $("#pmi_body_descripcion").html(html_des);

                html_brecha = "";
                $brechas = response.brechas[0];
                if($brechas.length > 0){
                    $("#brecha").show();
                    $("#respuesta_11").empty();
                    $("#brecha_cuerpo").empty();
                    if($brechas[0]){
                        $(".icono_11").addClass("fa-check");
                        $(".icono_11").removeClass("fa-close");
                        $(".icono_11").css("color", "green");
                    }else{
                        $(".icono_11").addClass("fa-close");
                        $(".icono_11").removeClass("fa-check");
                        $(".icono_11").css("color", "red");
                    }
                    html_brecha += '<td style="text-align: center;">'+ $brechas[1] +'</td>';
                    html_brecha += '<td style="text-align: center;">'+ $brechas[2] +'</td>';
                    html_brecha += '<td style="text-align: center;">'+ $brechas[3] +'</td>';
                    html_brecha += '<td style="text-align: center;">'+ $brechas[4] +'</td>';
                    html_brecha += '<td style="text-align: center;">'+ $brechas[6] +'</td>';
                    $("#brecha_cuerpo").html(html_brecha);
                    
                }else{
                    $("#brecha").hide();
                    $("#respuesta_11").text("Sin Brechas");
                    $(".icono_11").addClass("fa-close");
                    $(".icono_11").removeClass("fa-check");
                    $(".icono_11").css("color", "red");
                }
            })
            .fail(function() {
                console.log( "error" );
            })
            .always(function(response) {
                $("#cargando").hide();
                $("#noprevistas").show();
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

        var table;
        tableNoPrevistas = function(){
            $.ajax({
                url: '{{ url("/noprevistas/data") }}',
                data: {anio :$("#anio :selected").val()},
                method: 'POST',
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function(response){
                    $('#noprevistas').DataTable().destroy();
                    html = "";
                    $.each(response.data,function(key,value){
                        html += "<tr>";
                        html += "<td style='text-align:center;cursor:pointer;' width='10%'>" + value['cod_unif'] + "</td>";
                        html += "<td style='text-align:left;cursor:pointer;' width='50%'>" + value['nombre_inversion'] + "</td>";
                        html += "<td style='text-align:center;cursor:pointer;' width='15%'>" + number_format(value['monto_ejecucion'],0) + "</td>";
                        html += "<td style='text-align:center;cursor:pointer;' width='15%'>" + number_format(value['pim'],0) + "</td>";
                        html += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['monto_anio_0'],0) + "</td>";
                        html += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['monto_anio_1'],0) + "</td>";
                        html += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['monto_anio_2'],0) + "</td>";
                        html += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['monto_anio_3'],0) + "</td>";
                        @permission('pir-habilitador-mant')
                            html += "<td style='text-align:center;vertical-align: middle'><button type='button' class='btn btn-primary btn-sm tooltip_accion' title='Editar' onclick='modaleditar(" + value['id'] +")'><i class='fa fa-edit'></i></button></td>";
                        @endpermission
                        html += "</tr>";
                    });
                    $("#noprevistas_cuerpo").html(html);
                    table = $("#noprevistas").DataTable({
                        processing: true,
                        bSort: true,
                        bInfo: true,
                        bAutoWidth: true,
                        responsive:true,
                        scrollY:        '350px',
                        scrollCollapse: true,
                        paging:         false,
                        columnDefs: [
                            { orderable: false, targets: 8 }
                        ],
                        language:
                        {
                                "senu":     "Mostrar _MENU_",
                                "sZeroRecords":    "No se encontraron resultados",
                                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                                "sInfo":           "_START_ al _END_ de _TOTAL_ Registros",
                                "sInfoEmpty":      "Vacio",
                                "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                                "sInfoPostFix":    "",
                                "sSearch":         "Buscar:",
                                "sUrl":            "",
                                "sInfoThousands":  ",",
                                "sLoadingRecords": "Cargando...",
                                "processing": "Cargando...",
                                "oPaginate":
                                {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     ">",
                                    "sPrevious": "<"
                                },
                                "oAria":
                                {
                                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                }
                        }
                    });         
                },
                complete: function(response) {
                    $("#cargando").hide();
                }
            });
        }

        //Cargando Tabla
        // tableNoPrevistas();

        cargardocumento = function(id_documento,cod_uni){
            $.ajax({
                url: '{{ url("/habilitador/credito") }}',
                method: 'POST',
                data: {id_documento : id_documento,cod_uni: cod_uni,anio :$("#anio :selected").val() },
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function(response){
                    $("#documento").text(response.documento);
                    html_anulacion="";
                    html_anulacion_total="";
                    total_anulacion=0;
                    html_credito="";
                    html_credito_total="";
                    total_credito=0;
                    $.each(response.dataanulacion,function(key,value){
                        total_anulacion += parseInt(value["saldo_anulado"]);
                        if(value["cod_uni"] == response.cod_uni){
                            html_anulacion += "<tr style='background-color: #3c8dbc;font-weight: bold;'>";
                        }else{
                            html_anulacion += "<tr>";
                        }
                        html_anulacion += "<td style='text-align:center;cursor:pointer;' width='20%' class='tooltip_nombrepry' title='"+  value['nom_proyec'] + "'>" + value['cod_uni'] + "</td>";
                        html_anulacion += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['m_pip'],0) + "</td>";
                        html_anulacion += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['m_deveng_a'],0) + "</td>";
                        html_anulacion += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['saldo_ejecutar'],0) + "</td>";
                        html_anulacion += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['pia_dia'],0) + "</td>";
                        html_anulacion += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['pim_dia'],0) + "</td>";
                        html_anulacion += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['saldo_anulado'],0) + "</td>";
                        html_anulacion += "</tr>";
                    });
                    $("#habilitadores_cuerpo").html(html_anulacion);
                    $("#total_anulacion").text(number_format(total_anulacion,0));

                    $.each(response.datacredito,function(key,value){
                        total_credito += parseInt(value["credito"]);
                        html_credito += "<tr>";
                        html_credito += "<td style='text-align:center;cursor:pointer;' width='20%' class='tooltip_nombrepry' title='"+  value['nom_proyec'] + "'>" + value['cod_uni'] + "</td>";
                        html_credito += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['m_pip'],0) + "</td>";
                        html_credito += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['m_deveng_a'],0) + "</td>";
                        html_credito += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['saldo_ejecutar'],0) + "</td>";
                        html_credito += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['pia_dia'],0) + "</td>";
                        html_credito += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['pim_dia'],0) + "</td>";
                        html_credito += "<td style='text-align:center;cursor:pointer;' width='20%'>" + number_format(value['credito'],0) + "</td>";
                        html_credito += "</tr>";
                    });
                    $("#habilitados_cuerpo").html(html_credito);
                    $("#total_credito").text(number_format(total_credito,0));
                },
                complete: function(response) {
                    $("#cargando").hide();
                }
            });
        }

        modalagregar = function(){
            modaltype='full-width';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/noprevistas/agregar") }}',
                type: 'POST',
                data: {anio :$("#anio :selected").val()},
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function (response) {
                    $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                    $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                    $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                    $('#' + modaltype).modal('show');
                },
                complete: function(response) {
                    $("#cargando").hide();
                },
            });
        }

        modaleditar = function(id){
            modaltype='full-width';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/noprevistas/agregar") }}',
                data: {id : id,anio :$("#anio :selected").val() },
                type: 'POST',
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function (response) {
                    $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                    $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                    $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                    $('#' + modaltype).modal('show', {backdrop: 'true'});
                },
                complete: function(response) {
                    $("#cargando").hide();
                },
            });
        }

        //INICIO MODAL
        agregar =function(opc,id){
            $codigo = $("#codigo").val();
            $monto = $("#monto").val();
            $estado = $("#estado").val();
            $modalidad = $("#modalidad").val();

            $.ajax({
                url: '{{ url("/noprevistas/insertardata") }}',
                method: 'POST',
                data: {codigo : $codigo,anio :$("#anio :selected").val(),opc:opc,monto:$monto,modalidad : $modalidad,estado:$estado,id:id},
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function () {
                    $("#cargando_modal").show();
                },
                success: function(response){
                    if(opc == 1){
                        swal({
                            title: "Actualizado",
                            text: "Datos actualizados correctamente",
                            type: "success",
                            confirmButtonClass: 'btn btn-success',
                            confirmButtonText:'ok',
                        });
                    }else{
                        swal({
                            title: "Guardado",
                            text: "Datos guardados correctamente",
                            type: "success",
                            confirmButtonClass: 'btn btn-success',
                            confirmButtonText:'ok',
                        });
                    }
                },
                complete: function(response) {
                    $("#cargando_modal").hide();
                    $('#full-width').modal('hide');
                    tableNoPrevistas();
                }
            });
        }

        eliminar =function(opc,id){
            swal({
                title: '¿Desea Eliminar?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function(result){
                    $.ajax({
                        url: '{{ url("/noprevistas/eliminardata") }}',
                        method: 'POST',
                        data: {opc:opc,id:id},
                        tryCount : 0,
                        retryLimit : 3,
                        beforeSend: function () {
                        },
                        success: function(response){
                            swal({
                                title: "Eliminado Correctamente",
                                text: "Datos eliminados correctamente",
                                type: "success",
                                confirmButtonClass: 'btn btn-success',
                                confirmButtonText:'ok',
                            });
                            tableNoPrevistas();

                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            if(XMLHttpRequest.status == 400){
                                console.log("Error de Transaccion");
                            }
                            swal({
                                title: "Error al Eliminar",
                                text: "No se pudo eliminar",
                                type: "error",
                                confirmButtonClass: 'btn btn-error',
                                confirmButtonText:'ok',
                            });
                        },complete: function(response) {
                            $('#full-width').modal('hide');
                        }
                    });
            },function (dismiss) {}).catch(swal.noop);
        }
        //FIN MODAL
    });
</script>

@endsection
