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
    <div class="well">
        <div class="text-center">
            <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">INVERSIONES NO PREVISTAS</span>
        </div>
    </div>
    <div class="col-md-12 row">
        <div class="col-md-4 form-group">
            <label for="anio">Año:</label>
            <select  name="anio" class="form-control" id="anio"  onchange="tableHablitadores()">
                <option value="2020">2020</option>
                <option value="2021" selected>2021</option>
            </select>
        </div>
    </div>
    @permission('pir-habilitador-mant')
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" onclick="modalagregar()"><i class="fa fa-plus"> AGREGAR</i></button>
    </div>
    @endpermission
    <div  class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border" style="border-bottom: 1px solid #00a65a;">
                <i class="fa fa-calendar-check-o"></i>
                <h3 class="box-title bold"><strong>Proyectos</strong></h3>
            </div>
            <div class="box-body">
                <div class="table  table-responsive" >
                    <table id="noprevistas" class="table table-striped table-bordered table-hover" style="width:100%">
                        <thead>
                        <?php 
                            $year= date("Y");
                        ?>
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                                <th rowspan="2" style="vertical-align: middle;" class="text-center">NOMBRE DELPROYECTO</th>
                                <th rowspan="2" style="vertical-align: middle;" class="text-center">EJECUCIÓN (S/)</th>
                                <th rowspan="2" style="vertical-align: middle;" class="text-center">PIM <?php echo e($year); ?> (S/)</th>
                                <th colspan="4" cstyle="vertical-align: middle;" class="text-center">Programación del monto de inversión Año (S/)</th>
                                @permission('pir-habilitador-mant')
                                    <th rowspan="2" style="vertical-align: middle;" class="text-center" width="10px"><i class="fa fa-edit"></i></th>
                                @endpermission
                            </tr>
                            <tr>
                                <th style="vertical-align: middle;" class="text-center"><?php echo e($year); ?></th>
                                <th style="vertical-align: middle;" class="text-center"><?php echo e($year + 1); ?></th>
                                <th style="vertical-align: middle;" class="text-center"><?php echo e($year + 2); ?></th>
                                <th style="vertical-align: middle;" class="text-center"><?php echo e($year + 3); ?></th>
                            </tr>
                        </thead>
                        <tbody id="noprevistas_cuerpo">
                        </tbody>
                    </table>
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
                                "sLengthMenu":     "Mostrar _MENU_",
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
        tableNoPrevistas();

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
