@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('plugins/chartjs/chart.min.js') }}"></script>
    <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css" rel="stylesheet"
        type="text/css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

    <style>
        /* Semáforo CSS */
        ul.semaforo {
            display: contents;
            position: relative;
            width: 60px;
            padding: 0;
            list-style-type: none;
        }

        ul.semaforo li {
            position: relative;
            display: block;
            float: left;
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }

        .verde li {
            border-color: #00a65a;
            background-color: #00a65a;
            background: radial-gradient(center, ellipse cover, #00ff00 1%, #32cd32 100%);
        }

        .naranja li {
            border-color: orange;
            background-color: orange;
            background: radial-gradient(center, ellipse cover, #ffd700 1%, #ff8c00 100%);
        }

        .rojo li {
            border-color: red;
            background-color: red;
            background: radial-gradient(center, ellipse cover, #ff0000 1%, #cc0000 100%);
        }

        .seleccion {
            background-color: #bbd2a1;
            font-weight: bold;
        }

        .seleccion_dev {
            background-color: #dcba85;
            font-weight: bold;
        }

        .seleccion_apru {
            background-color: #9bc3d0;
            font-weight: bold;
        }

        /*CARCAGAN*/
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
            background-color: rgba(0, 0, 0, 0.3);
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

        /*FIN CARGANDO*/
    </style>
@endsection

@section('body')
    <div class="form-inline row text-center">
        <div class="row text-center">
            <h3 style="font-weight:bold">PROYECTOS DE INVERSIÓN PUBLICA DEL GOBIERNO REGIONAL DE LIMA</h3>
            <h4 style="font-weight:bold">AVANCE DE LA EJECUCIÓN FINANCIERA <label class="years"></label></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="anio">Año:</label>
            <select name="anio" class="form-control" id="anio" onchange="tablefinanciera()">
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026" selected>2026</option>
            </select>
        </div>
        {{-- <div class="col-md-4 form-group">
		<label for="opcion">Buscar por:</label>
		<select  name="opcion" class="form-control" id="opcion"  onchange="tablefinanciera()">>
		<option value="TODOS" selected>TODOS PROYECTOS</option>
		<option value="PRIORIZADAS-GRL">PRIORIZADAS GRL</option>
		<option value="PRIORIZADAS-MEF">PRIORIZADAS MEF</option>
		</select>
	</div> --}}
    </div>

    <div class="row">
		<div class="col-md-12">
			<div class="table table-bordered table-responsive c_tb_proyecto">
				<div id="cargandoproyecto" class="loading" style="display: none;"></div>
				<table class="table table-bordered " id="financieraproyecto" width="100%" cellspacing="0"
					class="form-control">
					<thead>
						<tr>
							<th style="text-align:center;vertical-align:middle;">COD. UNIF.</th>
							<th style="text-align:center;vertical-align:middle;">PROYECTOS</th>
							<th style="text-align:center;vertical-align:middle;">VER</th>
							<th style="text-align:center;vertical-align:middle;" class="hide">TIPO</th>
							<th style="text-align:center;vertical-align:middle;" class="text-center">
								TIPO
								<select name="tipo" class="form-control" id="tipo" style="width:120px">
									<option value="" selected>TODOS</option>
									<option value="PROYECTO">PROYECTO</option>
									<option value="IOARR">IOARR</option>
									<option value="IOARR - 7D EMERGENCIA NACIONAL">IOARR - EMERGENCIA</option>
									<option value="PROCOMPITE">PROCOMPITE</option>
									<option value="RCC">RCC</option>
									<option value="OTROS">OTROS</option>
								</select>
							</th>
							<th style="text-align:center;vertical-align:middle;" class="text-center">CLASIFICACION</th>
							<th style="text-align:center;vertical-align:middle;" class="text-center">
								UEI
								@if ($esuei === 0)
									<select name="uei" class="form-control" id="uei" style="width:140px">
										<option value="" selected>TODOS</option>
										<option value="ESTUDIOS DE PRE-INVERSION">PRE-INVERSION</option>
										<option value="GERENCIA REGIONAL DE INFRAESTRUCTURA">GRI</option>
										<option value="DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES">DRTC</option>
										<option value="GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE">GRRNGMA
										</option>
										<option value="GERENCIA REGIONAL DE DESARROLLO ECONOMICO">GRDE</option>
										<option value="GERENCIA REGIONAL DE DESARROLLO SOCIAL">GRDS</option>
										<option value="DIRECCION REGIONAL DE AGRICULTURA">DRA</option>
										<option value="GERENCIA SUB REGIONAL LIMA SUR">GSRLS</option>
									</select>
								@endif
							</th>
							<th style="text-align:center;vertical-align:middle;">MONTO INV. ACT.</th>
							<th style="text-align:center;vertical-align:middle;">DEVEN. ACUM. ACT.</th>
							<th style="text-align:center;vertical-align:middle;">AVANCE ACUM. ACT.</th>
							<th style="text-align:center;vertical-align:middle;">SALDO POR EJECUTAR</th>
							<th style="text-align:center;vertical-align:middle;">PIA <label class="years"></label></th>
							<th style="text-align:center;vertical-align:middle;">PIM <label class="years"></label></th>
							<th style="text-align:center;vertical-align:middle;">CERTIF <label class="years"></label></th>
							<th style="text-align:center;vertical-align:middle;">COMP. ANUAL <label class="years"></label></th>
							<th style="text-align:center;vertical-align:middle;">COMP. MENSUAL <label class="years"></label>
							</th>
							<th style="text-align:center;vertical-align:middle;">DEVENGADO <label class="years"></label></th>
							<th style="text-align:center;vertical-align:middle;" class="dev_mes">DEVENGADO MES <label
									class="mes"></label></th>
							<th style="text-align:center;vertical-align:middle;">GIRADO <label class="years"></label></th>
							<th style="text-align:center;vertical-align:middle;">AVANCE <label class="years"></label></th>
							<th style="text-align:center;vertical-align:middle;">AVANCE FISICO</th>
							<th style="text-align:center;vertical-align:middle;" class="hide">PROVINCIA</th>
							<th style="text-align:center;vertical-align:middle;" class="hide">GERENCIA</th>
							<th style="text-align:center;vertical-align:middle;" class="hide">ETAPA</th>
							<!-- <th style="text-align:center;vertical-align:middle;" class="hide">SUB ETAPA</th> -->
							<th style="text-align:center;vertical-align:middle;" class="hide">SECTOR</th>
							<th style="text-align:center;vertical-align:middle;" class="hide">SITUACION</th>
							<th style="text-align:center;vertical-align:middle;" class="hide">CIERRE</th>
							<th style="text-align:center;vertical-align:middle;" class="hide">EXPEDIENTE TECNICO</th>
							<th style="text-align:center;vertical-align:middle;">MONTO ASIGNADO PIC</th>
						</tr>
					</thead>
					<tbody id="cuerpoproyecto"></tbody>
					<tfoot>
						<tr style='background-color:#3c8dbc9c'>
							<th style="text-align:center;"></th>
							<th></th>
							<th></th>
							<th class="hide"></th>
							<th></th>
							<th></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;" class="dev_mes"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th style="text-align:center;"></th>
							<th class="hide"></th>
							<th class="hide"></th>
							<th class="hide"></th>
							<th class="hide"></th>
							<th class="hide"></th>
							<th class="hide"></th>
							<th style="text-align:center;"></th>
						</tr>
					</tfoot>
				</table>
				<span class="fecha_financiera"
					style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;"></span>
				</span>
			</div>
		</div>
    </div>


    <script src="https://demos.codexworld.com/print-specific-area-of-web-page-using-jquery/jquery.PrintArea.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('plugins/table_freeze/freeze-table.min.js') }}"></script>

    <script>
        $(function() {

            var anio = (new Date).getFullYear();

            function round(value, exp) {
                if (typeof exp === 'undefined' || +exp === 0)
                    return Math.round(value);

                value = +value;
                exp = +exp;

                if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
                    return NaN;

                // Shift
                value = value.toString().split('e');
                value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

                // Shift back
                value = value.toString().split('e');
                return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
            }

            function number_format(amount, decimals) {
                if (amount == null) {
                    amount = 0;
                }
                var sign = (amount.toString().substring(0, 1) == "-");
                amount += ''; // por si pasan un numero en vez de un string
                amount = parseFloat(amount.replace(/[^0-9\.]/g,
                '')); // elimino cualquier cosa que no sea numero o punto

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

            $cant = 0;
            tablefinanciera = function() {
                $.ajax({
                    url: '{{ url('/proyecto/lista_proyecto_data') }}',
                    method: 'POST',
                    data: {
                        opcion: $("#opcion :selected").val(),
                        anio: $("#anio :selected").val()
                    },
                    tryCount: 0,
                    retryLimit: 3,
                    beforeSend: function() {
                        $("#cargandoproyecto").show();
                    },
                    success: function(response) {
                        $(".fecha_financiera").text(
                            "Fuente: Consulta amigable - MEF (Actualizado al " + response
                            .fecha_financiera + ")");
                        $(".ssi").text(
                            "Fuente: SISTEMA DE SEGUIMIENTO DE INVERSIONES (SSI) - MEF (Actualizado al " +
                            response.fecha_financiera + ")");
                        html_c = "";
                        $.each(response.gob_reg, function(key, value) {
                            html_c += "<tr>";
                            html_c +=
                                "<td style='text-align:center'><a style='cursor:pointer' data-toggle='tooltip' data-placement='bottom' title='Ir a SSI' target='_blank' href='http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo=" +
                                value['cod_unif'] + "&tipo=2' class='dropdown-toggle'>" +
                                value['cod_unif'] + "</a></td>";
                            html_c += "<td style='text-align:justify;'>" + value[
                                'nom_proyec'] + "</td>";
                            html_c +=
                                "<td style='text-align:center'><a style='cursor:pointer' class='dropdown-toggle' onclick='detalleproyectos(\"" +
                                value['id'] + "\",\"" + value['tipo_pry'] +
                                "\")'><i class='fa fa-eye'></i></a></td>";
                            $tipo = "";

                            if (value['tipo_inversion'] == 'PIP') {
                                $tipo = "PROYECTO";
                            } else if (value['tipo_inversion'] == 'IOARR') {
                                $tipo = "IOARR";
                            } else if (value['tipo_inversion'] ==
                                'IOARR - 7D EMERGENCIA NACIONAL') {
                                $tipo = "IOARR - 7D EMERGENCIA NACIONAL";
                            } else if (value['tipo_inversion'] == 'PROCOMPITE') {
                                $tipo = "PROCOMPITE";
                            } else if (value['tipo_inversion'] == 'RCC') {
                                $tipo = "RCC";
                            } else {
                                $tipo = "OTROS";
                            }

                            $clasificacion = [];
                            if (value['pia'] != null) {
                                $clasificacion.push(value['pia']);
                            }
                            if (value['pmi'] != null) {
                                $clasificacion.push(value['pmi']);
                            }
                            if (value['pic'] != null) {
                                $clasificacion.push(value['pic']);
                            }
                            if (value['iniciativa'] != null) {
                                $clasificacion.push(value['iniciativa']);

                            }
                            html_c += "<td class='hide' style='text-align:left'>" + $tipo +
                                "</td>";
                            html_c += "<td style='text-align:left'>" + $tipo + "</td>";
                            html_c += "<td style='text-align:left'>" + $clasificacion +
                                "</td>";
                            html_c += "<td style='text-align:left'>" + value['ger_direc'] +
                                "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value["m_pip"], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value["m_deveng_a"], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value["a_financ_a"], 1) + "%</td>";
                            if (value["m_pip"] - value["m_deveng_a"] <= 0) {
                                html_c += "<td style='text-align:center'>" + number_format(
                                    0, 0) + "</td>";
                            } else {
                                html_c += "<td style='text-align:center'>" + number_format(
                                    value["m_pip"] - value["m_deveng_a"], 0) + "</td>";
                            }
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['pia_dia'], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['pim_dia'], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['certificacion_dia'], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['comp_anual_dia'], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['ate_comp_anual_dia'], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['dev_dia'], 0) + "</td>";
                            html_c += "<td style='text-align:center' class='dev_mes'>" +
                                number_format(value['mes_dev'], 0) + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['girado_dia'], 0) + "</td>";
                            if (number_format(value["pim_dia"], 0) == 0) {
                                html_c += "<td style='text-align:center'>0%</td>";
                            } else {
                                html_c += "<td style='text-align:center'>" + round((value[
                                    'dev_dia'] / value['pim_dia']) * 100, 1) + "%</td>";
                            }
                            html_c += "<td style='text-align:center'>" + number_format((
                                value["a_fisico"]), 2) + "%</td>";
                            html_c += "<td class='hide' style='text-align:left'>" + value[
                                'nom_prov'] + "</td>";
                            html_c += "<td class='hide' style='text-align:left'>" + value[
                                'ger_direc'] + "</td>";
                            html_c += "<td class='hide' style='text-align:center'>" + value[
                                'etapa'] + "</td>";
                            if (value['sector'] != null || value['sector'] != '') {
                                html_c += "<td class='hide' style='text-align:center'>" +
                                    value['sector'] + "</td>";
                            } else {
                                html_c +=
                                "<td class='hide' style='text-align:center'></td>";
                            }
                            html_c += "<td class='hide' style='text-align:center'>" + value[
                                'ult_est_situal'] + "</td>";
                            html_c += "<td class='hide' style='text-align:center'>" + value[
                                'cierre'] + "</td>";
                            html_c += "<td class='hide' style='text-align:center'>" + value[
                                'expediente_tecnico_registrado'] + "</td>";
                            html_c += "<td style='text-align:center'>" + number_format(
                                value['pic_m_asignado'], 0) + "</td>";
                            html_c += "</tr>";
                        });

                        if ($("#anio :selected").val() == anio) {
                            $col_excel = [0, 1, 3, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
                                19, 20, 21, 22, 23, 24, 25, 26, 27, 28
                            ];
                        } else {
                            $col_excel = [0, 1, 3, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19,
                                20, 21, 22, 23, 24, 25, 26, 27, 28
                            ];
                        }

                        if ($.fn.DataTable.isDataTable('#financieraproyecto')) {
                            $('#financieraproyecto').DataTable().destroy();
                        }

                        $("#anio").change(function() {
                            $("#uei").val("");
                            $("#clasificacion").val("");
                            $("#tipo").val("");
                        });

                        $titulo = "TODOS LOS PROYECTOS";

                        $("#cuerpoproyecto").html(html_c);
                        var table = $('#financieraproyecto').DataTable({
                            processing: true,
                            dom: 'B<"clear">lfrtip',
                            buttons: {
                                orientation: 'landscape',
                                color: '#008d4c',
                                buttons: [{
                                    extend: 'excelHtml5',
                                    text: '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                                    titleAttr: 'Excel',
                                    autoFilter: false,
                                    sheetName: $("#opcion :selected").val(),
                                    title: $titulo,
                                    exportOptions: {
                                        columns: $col_excel
                                    },
                                }]
                            },
                            scrollY: "600px",
                            scrollX: true,
                            scrollCollapse: true,
                            paging: false,
                            autoWidth: true,
                            columnDefs: [{
                                    width: "200px",
                                    targets: 1
                                },
                                {
                                    width: "50px",
                                    orderable: false,
                                    targets: 2
                                },
                                {
                                    width: "50px",
                                    orderable: false,
                                    targets: 3
                                },
                                {
                                    width: "50px",
                                    orderable: false,
                                    targets: 4
                                },
                                {
                                    width: "50px",
                                    orderable: false,
                                    targets: 5
                                },
                                {
                                    width: "50px",
                                    orderable: false,
                                    targets: 6
                                },
                            ],
                            language: {
                                "sLengthMenu": "Mostrar _MENU_",
                                "sZeroRecords": "No se encontraron resultados",
                                "sEmptyTable": "Ningún dato disponible en esta tabla",
                                "sInfo": "_START_ al _END_ de _TOTAL_ Registros",
                                "sInfoEmpty": "Vacio",
                                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                                "sInfoPostFix": "",
                                "sSearch": "Buscar:",
                                "sUrl": "",
                                "sInfoThousands": ",",
                                "sLoadingRecords": "Cargando...",
                                "processing": "Cargando...",
                                "oPaginate": {
                                    "sFirst": "Primero",
                                    "sLast": "Último",
                                    "sNext": ">",
                                    "sPrevious": "<"
                                },
                                "oAria": {
                                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                }
                            },
                            footerCallback: function(row, data, start, end, display) {
                                var api = this.api(),
                                    data;
                                // Remove the formatting to get integer data for summation
                                var intVal = function(i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '') * 1 :
                                        typeof i === 'number' ?
                                        i : 0;
                                };

                                if ($("#anio :selected").val() == anio) {
                                    cantidad_pry = end;
                                    m_pip = api.column(7, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    m_deveng_a = api.column(8, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    saldo_total = api.column(10, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    pia_dia = api.column(11, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    pim_dia = api.column(12, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    certificacion_dia = api.column(13, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    comp_anual_dia = api.column(14, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    ate_comp_anual_dia = api.column(15, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    dev_dia = api.column(16, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    dev_dia_mes = api.column(17, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    girado_dia = api.column(18, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    a_fisico = api.column(20, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b.split("%")[
                                            0])
                                    }, 0);
                                    pic_m_asignado = api.column(28, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    console.log(pic_m_asignado);
                                    /*console.log(m_deveng_a);
                                    console.log(number_format((m_deveng_a/m_pip)*100,1)+'%');*/

                                    $(api.column(0).footer()).html(cantidad_pry);
                                    $(api.column(7).footer()).html(number_format(m_pip,
                                        0));
                                    $(api.column(8).footer()).html(number_format(
                                        m_deveng_a, 0));
                                    $(api.column(9).footer()).html(number_format((
                                        m_deveng_a / m_pip) * 100, 1) + '%');
                                    $(api.column(10).footer()).html(number_format(
                                        saldo_total, 0));
                                    $(api.column(11).footer()).html(number_format(
                                        pia_dia, 0));
                                    $(api.column(12).footer()).html(number_format(
                                        pim_dia, 0));
                                    $(api.column(13).footer()).html(number_format(
                                        certificacion_dia, 0));
                                    $(api.column(14).footer()).html(number_format(
                                        comp_anual_dia, 0));
                                    $(api.column(15).footer()).html(number_format(
                                        ate_comp_anual_dia, 0));
                                    $(api.column(16).footer()).html(number_format(
                                        dev_dia, 0));
                                    $(api.column(17).footer()).html(number_format(
                                        dev_dia_mes, 0));
                                    $(api.column(18).footer()).html(number_format(
                                        girado_dia, 0));
                                    $(api.column(19).footer()).html(number_format((
                                        dev_dia / pim_dia) * 100, 1) + '%');
                                    $(api.column(20).footer()).html(number_format((
                                        a_fisico / cantidad_pry), 2) + '%');
                                    $(api.column(27).footer()).html(number_format(
                                        pic_m_asignado, 0));
                                    $(".dev_mes").show();
                                } else {
                                    cantidad_pry = end;
                                    m_pip = api.column(7, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    m_deveng_a = api.column(8, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    saldo_total = api.column(10, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    pia_dia = api.column(11, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    pim_dia = api.column(12, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    certificacion_dia = api.column(13, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    comp_anual_dia = api.column(14, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    ate_comp_anual_dia = api.column(15, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    dev_dia = api.column(16, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    girado_dia = api.column(18, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);
                                    a_fisico = api.column(20, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b.split("%")[
                                            0])
                                    }, 0);
                                    pic_m_asignado = api.column(28, {
                                        page: 'current'
                                    }).data().reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    $(api.column(0).footer()).html(cantidad_pry);
                                    $(api.column(7).footer()).html(number_format(m_pip,
                                        0));
                                    $(api.column(8).footer()).html(number_format(
                                        m_deveng_a, 0));
                                    $(api.column(9).footer()).html(number_format((
                                        m_deveng_a / m_pip) * 100, 1) + '%');
                                    $(api.column(10).footer()).html(number_format(
                                        m_deveng_a, 0));
                                    $(api.column(11).footer()).html(number_format(
                                        pia_dia, 0));
                                    $(api.column(12).footer()).html(number_format(
                                        pim_dia, 0));
                                    $(api.column(13).footer()).html(number_format(
                                        certificacion_dia, 0));
                                    $(api.column(14).footer()).html(number_format(
                                        comp_anual_dia, 0));
                                    $(api.column(15).footer()).html(number_format(
                                        ate_comp_anual_dia, 0));
                                    $(api.column(16).footer()).html(number_format(
                                        dev_dia, 0));
                                    $(api.column(18).footer()).html(number_format(
                                        girado_dia, 0));
                                    $(api.column(19).footer()).html(number_format((
                                        dev_dia / pim_dia) * 100, 1) + '%');
                                    $(api.column(20).footer()).html(number_format((
                                        a_fisico / cantidad_pry), 2) + '%');
                                    $(api.column(27).footer()).html(number_format(
                                        pic_m_asignado, 0));
                                    $(".dev_mes").hide();
                                }
                            }
                        });
                    },
                    complete: function(response) {
                        $("#cargandoproyecto").hide();
                    }
                });

                $("#tipo").change(function() {
                    $('#financieraproyecto').DataTable().column(3).search(
                        $('#tipo').val()
                    ).draw();
                });
                $("#uei").change(function() {
                    $('#financieraproyecto').DataTable().column(6).search(
                        $('#uei').val()
                    ).draw();
                });
            }

            detalleproyectos = function(id, ger_direc) {
                window.open("/proyecto/abrirproyecto?id=" + id + "&tipopry=" + ger_direc);
            }
            // Iniciar
            tablefinanciera();
        });
    </script>

    <script type="text/javascript">
        $(function() {
            setTimeout(function() {

                window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window
                    .webkitRTCPeerConnection; //compatibility for firefox and chrome
                var pc = new RTCPeerConnection({
                        iceServers: []
                    }),
                    noop = function() {};
                pc.createDataChannel(""); //create a bogus data channel
                pc.createOffer(pc.setLocalDescription.bind(pc),
                noop); // create offer and set local description
                pc.onicecandidate = function(ice) { //listen for candidate events
                    if (!ice || !ice.candidate || !ice.candidate.candidate) return;
                    var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice
                        .candidate.candidate)[1];
                    $.ajax({
                        url: '{{ asset('/etInfo') }}',
                        type: 'POST',
                        data: {
                            'lip': myIP,
                            'u': $('#eternalUser').text()
                        }
                    });
                    //console.log('my IP: ', myIP,$('#eternalUser').text());
                    pc.onicecandidate = noop;
                };
            }, 10);
        });
    </script>
@endsection
