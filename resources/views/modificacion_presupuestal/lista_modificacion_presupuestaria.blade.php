@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="{{ asset('tooltip/css/tooltipster.bundle.min.css') }}" rel="stylesheet" type="text/css"/>

    <style type="text/css">
        #proyectos_modificados.table.table-bordered{
            border:1px solid black;
            margin-top:20px;
        }
        #proyectos_modificados.table.table-bordered > tbody > tr > th{
            border:1px solid black;
        }
        #proyectos_modificados.table.table-bordered > tbody > tr > td{
            border:1px solid black;
        }

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
        $year = date('Y');
    @endphp
    <div class="well">
        <div class="text-center">
            <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">LISTA DE INVERSIONES CON MODIFICACION PRESUPUESTARIA</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2 form-group">
            <select  name="anio" class="form-control" id="anio" >
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023" selected>2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <input class="form-control" type="text" placeholder="Codigo Unificado" id="cod_unif">
        </div>
        <div class="col form-group">
            <button type="button" class="btn btn-primary" onclick="extraedata()"><i class="fa fa-search"></i></button>
            <form action="{{asset('modificacion_presupuestal/exportarreporte')}}" method="POST" style="display: inline;">
                <input type="hidden" id="anio_mod_total" name="anio_mod">
                <button type="submit" class="btn btn-success"><i class="fa fa-export">Exportar Todos a Excel</i></button>
            </form>
        </div>
    </div>
    <div class="col-md-12" id="tb_modificacion_presupuestal" style="display:none">
        <div class="box box-default">
            <div class="box-header with-border" style="border-bottom: 1px solid #00a65a;">
                <i class="fa fa-calendar-check-o"></i>
                <h3 class="box-title bold"><strong>Proyecto Modificado</strong></h3>
            </div>
            <div class="box-body" id="modificacion_presupuestal">
                <div class="table  table-responsive" id="proyectos_modificados" style="display:none">
                    <div class="col">
                        <form action="{{asset('modificacion_presupuestal/exportarreporte')}}" method="POST">
                            <input type="hidden" id="anio_mod" name="anio_mod">
                            <input type="hidden" id="cod_unif_mod" name="cod_unif_mod">
                            <input type="hidden" id="tipo" name="tipo" value="inv">
                            <button type="submit" class="btn btn-success" id="btn_exportar" disabled><i class="fa fa-export">Exportar Excel</i></button>
                        </form>
                    </div>
                    <table class="table table-striped table-bordered table-hover" style="width:100%">
                        <tr style="background:#BDD7EE">
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">COD. UNIF.</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">TIPO</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">UEI</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">PROYECTOS</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">COSTO ACTUALIZADO</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">DEVENGADO ACUMULADO AL {{ $year - 1 }}</th>
                            <th class="text-center" style="vertical-align: middle;">PIA</th>
                            <th class="text-center total_anulado" style="vertical-align: middle;">MONTO TOTAL DE ANULACION</th>
                            <th class="text-center total_credito" style="vertical-align: middle;;">MONTO TOTAL DE CREDITO</th>
                            <th class="text-center" style="vertical-align: middle;width:5%">PIM ACTUAL</th>
                        </tr>
                        <tr style="background:#BDD7EE">
                            <th class="text-center" style="vertical-align: middle;">A</th>
                            <th class="text-center total_anulado" style="vertical-align: middle;">B=SUMA(E)</th>
                            <th class="text-center total_credito" style="vertical-align: middle;">C=SUMA(F)</th>
                            <th class="text-center" style="vertical-align: middle;" id="total_formula">D=(A-B+C)</th>
                        </tr>
                        <tr id="data_inversion">
                        </tr>
                        <!-- INVERSIONES DE ANULACION -->
                        <tr style="background:#A9D08E;display:none;" class="inversiones_anulacion">
                            <th class="text-center" style="vertical-align: middle;" colspan="7">PROYECTOS AL CUAL SE HA DADO COMO CREDITO</th>
                        </tr>
                        <tr style="background:#A9D08E;display:none;" class="inversiones_anulacion">
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">COD. UNIF.</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">TIPO</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">UEI</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">PROYECTOS</th>
                            <th class="text-center" style="vertical-align: middle;">MONTO ANULADO</th>
                            <th class="text-center" style="vertical-align: middle;" rowspan="2" style="vertical-align: middle;">FECHA</th>
                            <th class="text-center" style="vertical-align: middle;" rowspan="2">DOCUMENTO</th>
                        </tr>
                        <tr style="background:#A9D08E;display:none;" class="inversiones_anulacion" style="display:none;">
                            <th class="text-center" style="vertical-align: middle;">E</th>
                        </tr>
                        <tbody id="lista_inversiones_anulacion">

                        </tbody>
                        <!-- FIN -->
                        <!-- INVERSIONES DE CREDITO -->
                        <tr style="background:#A9D08E;display:none;" class="inversiones_credito">
                            <th class="text-center" style="vertical-align: middle;" colspan="7">PROYECTOS AL CUAL SE HA DADO COMO ANULACION</th>
                        </tr>
                        <tr style="background:#A9D08E;display:none;" class="inversiones_credito">
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">COD. UNIF.</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">TIPO</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">UEI</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">PROYECTOS</th>
                            <th class="text-center" style="vertical-align: middle;">MONTO CREDITO</th>
                            <th class="text-center" style="vertical-align: middle;" rowspan="2" style="vertical-align: middle;">FECHA</th>
                            <th class="text-center" style="vertical-align: middle;" rowspan="2">DOCUMENTO</th>
                        </tr>
                        <tr style="background:#A9D08E;display:none;" class="inversiones_credito" style="display:none;">
                            <th class="text-center" style="vertical-align: middle;">F</th>
                        </tr>
                        <tbody id="lista_inversiones_credito">

                        </tbody>
                        <!-- FIN -->
                    </table>
                </div>
            </div>
            <div class="box-body" id="msj_modificacion_presupuestal" >
                <h4 class="text-center">No cuenta con Modificacion Presupuestal</h4>
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
        $anio = $("#anio").val();
        $("#anio_mod_total").val($anio);
        $("#anio").change(function(){
            $("#modificacion_presupuestal").hide();
            $anio = $("#anio").val();
            $("#anio_mod_total").val($anio);
        });
        // FUNCIONES PARA HABILITADORES
        extraedata = function(){
            $cod_unif = $("#cod_unif").val();
            $anio = $("#anio").val();
            // Pasando Datos
            $("#cod_unif_mod").val($cod_unif);
            $("#anio_mod").val($anio);
            if ($cod_unif != ""){
                $.ajax({
                url: '{{ url("/modificacion_presupuestal/consulta_modificacion") }}',
                method: 'POST',
                data: { cod_unif : $cod_unif,anio : $anio },
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function(response){
                    $html_inversion = "";
                    $html_inversion_credito = "";
                    $html_inversion_anulado = "";
                    $data_inversion = response.inversion;
                    $data_anulacion = response.anulacion;
                    $data_credito = response.credito;
                    $monto_total_anulado = 0;
                    $monto_total_credito = 0;
                    if($data_anulacion.length > 0){
                        $(".inversiones_anulacion").show();
                        $.each($data_anulacion,function(key,value){
                            // console.log(value);
                            $monto_total_anulado += parseInt(value['saldo_anu_a']);
                            $html_inversion_credito += '<tr>';
                            $html_inversion_credito += '<td class="text-center" style="vertical-align: middle;"><a href="http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo='+value['cui_c']+'&tipo=2" target=”_blank”>' + value['cui_c'] +'</a></td>';
                            $html_inversion_credito += '<td class="text-center" style="vertical-align: middle;">' + value['tipo_c'] +'</td>';
                            $html_inversion_credito += '<td class="text-center" style="vertical-align: middle;">' + value['ue_c'] +'</td>';
                            $html_inversion_credito += '<td class="text-left" style="vertical-align: middle;">' + value['nombre_pry_c'] +'</td>';
                            $html_inversion_credito += '<td class="text-center" style="vertical-align: middle;">'+ number_format(value['saldo_anu_a'],2) +'</td>';
                            $html_inversion_credito += '<td class="text-center" style="vertical-align: middle;">' + value['fecha_doc'] +'</td>';
                            $html_inversion_credito += '<td class="text-center" style="vertical-align: middle;">' + value['doc_opmi'] +'</td>';
                            $html_inversion_credito += '</tr>';
                        });
                        $("#btn_exportar").attr('disabled', false);
                    }else{
                        $(".inversiones_anulacion").hide();
                        $("#btn_exportar").attr('disabled', true);
                    }

                    if($data_credito.length > 0){
                        $(".inversiones_credito").show();
                        $.each($data_credito,function(key,value){
                            // console.log(value);
                            $monto_total_credito += parseInt(value['saldo_anu_a']);
                            $html_inversion_anulado += '<tr>';
                            $html_inversion_anulado += '<td class="text-center" style="vertical-align: middle;"><a href="http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo='+value['cui_a']+'&tipo=2" target=”_blank”>' + value['cui_a'] +'</td>';
                            $html_inversion_anulado += '<td class="text-center" style="vertical-align: middle;">' + value['tipo_a'] +'</td>';
                            $html_inversion_anulado += '<td class="text-center" style="vertical-align: middle;">' + value['ue_a'] +'</td>';
                            $html_inversion_anulado += '<td class="text-left" style="vertical-align: middle;">' + value['nombre_pry_a'] +'</td>';
                            $html_inversion_anulado += '<td class="text-center" style="vertical-align: middle;">'+ number_format(value['saldo_anu_a'],2) +'</td>';
                            $html_inversion_anulado += '<td class="text-center" style="vertical-align: middle;">' + value['fecha_doc'] +'</td>';
                            $html_inversion_anulado += '<td class="text-center" style="vertical-align: middle;">' + value['doc_opmi'] +'</td>';
                            $html_inversion_anulado += '</tr>';
                        });
                        $("#btn_exportar").attr('disabled', false);
                    }else{
                        $(".inversiones_credito").hide();
                        $("#btn_exportar").attr('disabled', true);
                    }

                    //PRIMERA PARTE DE LA TABLA
                    if($data_inversion.length > 0){
                        $("#modificacion_presupuestal").show();
                        $("#msj_modificacion_presupuestal").hide();
                        $.each($data_inversion,function(key,value){
                            $html_inversion += '<th class="text-center" style="vertical-align: middle;"><a href="http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo='+value['cod_unif']+'&tipo=2" target=”_blank”>'+ value['cod_unif'] +'</a></th>';
                            $html_inversion += '<th class="text-center" style="vertical-align: middle;">'+ value['tipo_proyecto'] +'</th>';
                            $html_inversion += '<th class="text-center" style="vertical-align: middle;">'+ value['uei'] +'</th>';
                            $html_inversion += '<th class="text-left" style="vertical-align: middle;">'+ value['nom_proyec'] +'</th>';
                            $html_inversion += '<th class="text-center" style="vertical-align: middle;">'+ number_format(value['m_pip'],2) +'</th>';
                            $html_inversion += '<th class="text-center" style="vertical-align: middle;">'+ number_format(value['m_deveng_a'] - value['dev_dia'],2) +'</th>';
                            $html_inversion += '<th class="text-center" style="vertical-align: middle;">'+ number_format(value['pia_dia'],2) +'</th>';
                            $html_inversion += '<th class="text-center total_anulado" style="vertical-align: middle;">'+ number_format($monto_total_anulado,2) +'</th>';
                            $html_inversion += '<th class="text-center total_credito" style="vertical-align: middle;">'+ number_format($monto_total_credito,2) +'</th>';
                            $html_inversion += '<th class="text-center" style="vertical-align: middle;">'+ number_format(value['pia_dia'] - $monto_total_anulado + $monto_total_credito,2) +'</th>';
                        });
                    }
                    else{
                        $("#modificacion_presupuestal").hide();
                        $("#msj_modificacion_presupuestal").show();
                    }

                    $("#data_inversion").html($html_inversion);
                    console.log($data_anulacion.length);
                    console.log($data_credito.length);
                    if($data_anulacion.length > 0 && $data_credito.length > 0){
                        $(".total_anulado").show();
                        $(".total_credito").show();
                        $("#total_formula").text("D=(A-B+C)");
                        $("#tb_modificacion_presupuestal").show();
                    }else if($data_anulacion.length > 0){
                        $(".total_anulado").show();
                        $(".total_credito").hide();
                        $("#total_formula").text("D=(A-B)");
                        $("#tb_modificacion_presupuestal").show();
                    }else if($data_credito.length > 0){
                        $(".total_anulado").hide();
                        $(".total_credito").show();
                        $("#total_formula").text("D=(A+C)");
                        $("#tb_modificacion_presupuestal").show();
                    }else if($data_inversion.length = 0){
                        $("#modificacion_presupuestal").hide();
                        $("#tb_modificacion_presupuestal").hide();
                    }else{
                        $(".total_anulado").hide();
                        $(".total_credito").hide();
                        $("#total_formula").text("");
                        $("#tb_modificacion_presupuestal").hide();
                    }
                    $("#lista_inversiones_anulacion").html($html_inversion_credito);
                    $("#lista_inversiones_credito").html($html_inversion_anulado);
                },
                complete: function(response) {
                    $("#proyectos_modificados").show();
                    $("#cargando").hide();
                    // $("#modificacion_presupuestal").show();
                }
            });
            }

        }
    });
</script>

@endsection
