@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">
    <!-- <script type="text/javascript" language="javascript" src="{{asset('plugins/chartjs/chart.js')}}"></script> -->
      <!-- D3 JS -->
    <link href="{{asset('plugins/c3/c3.min.css')}}" rel="stylesheet" />
@endsection

@section('body')
<style type="text/css">
  .buttons-excel
  {
    background-image: none !important;
    background-color: #337ab7 !important;
    border-color: #2e6da4 !important;
    color: #fff !important;
  }

  .DTFC_LeftBodyLiner
  {
    padding-right: 14px !important;
  }

  .dataTables_info{
    padding-top : 30px !important;
  }

  .highcharts-figure, .highcharts-data-table table {
  min-width: 310px; 
  max-width: 800px;
  margin: 1em auto;
  }

  #container {
    height: 400px;
  }

  .highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
  }
  .highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
  }
  .highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
  }
  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
  }
  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
  }
  .highcharts-data-table tr:hover {
    background: #f1f7ff;
  }
</style>
<div  class="col-md-12" style="margin-top: 20px;">
  <div class="row text-center">
    <h3 style="font-weight:bold">REPORTE DE SEGUIMIENTO A LA EJECUCIÓN DE INVERSIONES DEL FORMATO N° 12-B</h3>
    <br>
  </div>


  <div class="col-md-4 form-group">
    <label for="anio">Año:</label>
    <select  name="anio" class="form-control" id="anio"  onchange="formato12b()">
        <!-- <option value="2020">2020</option>
        <option value="2021">2021</option> -->
        {{-- <option value="2022">2022</option> --}}
        {{-- <option value="2023">2023</option> --}}
        {{-- <option value="2024">2024</option> --}}
        <option value="2025">2025</option>
        <option value="2026" selected>2026</option>
    </select>
  </div>
  <div class="row">
    <div class="table  table-responsive" >
      <table id="formato12b" class="table table-striped table-bordered table-hover" st-sticky-header="">
        <thead>
            @php
              $year= date("Y");
            @endphp
            <tr>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                <th rowspan="2" style="vertical-align: middle;width:300px;" class="text-center">PROYECTO DE INVERSION</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">EXP. REG.</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">FECHA ACTUAL</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">Últ. Periodo Registrado (F12-B)</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">TIPO FORMATO</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">MODALIDAD EJECUCION</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">ESTADO SITUACIONAL</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">AVANCE EJECUCION</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">AVANCE FISICO</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">REGISTRO DE CIERRE</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">INICIO EJECUCION FISICA</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">CULMINACION EJECUCION FISICA</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">AVANCE ACUMULADO</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">UEI</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">PIM {{$year}}</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">CERT {{$year}}</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">DEV {{$year}}</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">GIRAD {{$year}}</th>
                <th style="vertical-align: middle;background-color:#f6f73f" colspan="12" class="text-center">PROGRAMADO {{$year}}</th>
                <th style="vertical-align: middle;background-color:#c54e18" colspan="12" class="text-center">ACTUALIZADO {{$year}}</th>
                <th style="vertical-align: middle;background-color:#15bb50" colspan="12" class="text-center">REAL {{$year}}</th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center hidden">FECHA DECLARACION ESTIMADA</th>
            </tr>
            <tr>
                <th style="vertical-align: middle;" class="text-center">ENERO</th>
                <th style="vertical-align: middle;" class="text-center">FEBRERO</th>
                <th style="vertical-align: middle;" class="text-center">MARZO</th>
                <th style="vertical-align: middle;" class="text-center">ABRIL</th>
                <th style="vertical-align: middle;" class="text-center">MAYO</th>
                <th style="vertical-align: middle;" class="text-center">JUNIO</th>
                <th style="vertical-align: middle;" class="text-center">JULIO</th>
                <th style="vertical-align: middle;" class="text-center">AGOSTO</th>
                <th style="vertical-align: middle;" class="text-center">SEPTIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">OCTUBRE</th>
                <th style="vertical-align: middle;" class="text-center">NOVIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">DICIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">ENERO</th>
                <th style="vertical-align: middle;" class="text-center">FEBRERO</th>
                <th style="vertical-align: middle;" class="text-center">MARZO</th>
                <th style="vertical-align: middle;" class="text-center">ABRIL</th>
                <th style="vertical-align: middle;" class="text-center">MAYO</th>
                <th style="vertical-align: middle;" class="text-center">JUNIO</th>
                <th style="vertical-align: middle;" class="text-center">JULIO</th>
                <th style="vertical-align: middle;" class="text-center">AGOSTO</th>
                <th style="vertical-align: middle;" class="text-center">SEPTIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">OCTUBRE</th>
                <th style="vertical-align: middle;" class="text-center">NOVIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">DICIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">ENERO</th>
                <th style="vertical-align: middle;" class="text-center">FEBRERO</th>
                <th style="vertical-align: middle;" class="text-center">MARZO</th>
                <th style="vertical-align: middle;" class="text-center">ABRIL</th>
                <th style="vertical-align: middle;" class="text-center">MAYO</th>
                <th style="vertical-align: middle;" class="text-center">JUNIO</th>
                <th style="vertical-align: middle;" class="text-center">JULIO</th>
                <th style="vertical-align: middle;" class="text-center">AGOSTO</th>
                <th style="vertical-align: middle;" class="text-center">SEPTIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">OCTUBRE</th>
                <th style="vertical-align: middle;" class="text-center">NOVIEMBRE</th>
                <th style="vertical-align: middle;" class="text-center">DICIEMBRE</th>
            </tr>
        </thead>
      </table>
      <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Fuente: Dirección General de Programación Multianual de Inversiones - MEF (Actualizado al {{ $fecha  }})
      </span>
    </div>
  </div>
  <div class="row" style="display:none;">
    <div class="col-md-12">
    <div class="box box-success">
    <figure class="highcharts-figure">
      <div id="container"></div>
    </figure>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION 2021</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <thead>
                <tr>
                  <th style="width: 15px;text-align:center;vertical-align: middle;">UNIDAD EJECUTORA DE INVERSIONES (UEI)</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">PIM 2021</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">CERTIFICADO 2021</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">DEVENGADO 2021</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">GIRADO 2020</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">AVANCE 2021</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">TOTAL DE PROYECTOS</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">F12-B REGISTRADO</th>
                  <th style="width: 10px;text-align:center;vertical-align: middle;">F12-B ACTUALIZADO</th>
                </tr>
            </thead>
            <tbody id="reporte_f12b">
            </tbody>
            <tfoot id="reporte_f12b_foot">
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</div>
<br>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment.min.js"></script>
  <!-- <script src="{{asset('plugins/c3/d3.min.js')}}"></script>
  <script src="{{asset('plugins/c3/c3.min.js')}}"></script> -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/locale/es.js"></script>
  <!-- <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script> -->

<script>
  $(function(){
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

      

      formato12b = function()
      {
  
        if ($.fn.DataTable.isDataTable('#formato12b') ) {
          $('#formato12b').DataTable().destroy();
        }
        moment.locale('es');
        // $.fn.dataTable.moment('DD/MM/YYYY');
        $('#formato12b').DataTable({
            dom: 'B<"clear">lfrtip',
            buttons: {
                orientation: 'landscape',
                color:'#008d4c',
                buttons: [ {
                    extend: 'excelHtml5',
                    text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                    titleAttr: 'Excel',
                    autoFilter: false,
                    sheetName: 'FORMATO 12-B',
                    title: 'FORMATO 12-B',
                    exportOptions: {
                      columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55]
                    },
                }]
            },
            processing: true,
            scrollY:        "500px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            ajax:
            {
              url: '{{ url("formato12b/datos") }}',
              type: 'POST',
              data: {anio :$("#anio :selected").val()},
              
            },
            fixedColumns:   {
              leftColumns: 2,
              leftColumns: 3
            },
            columnDefs:
            [
              {
                  targets:0,
                  render: function (data, type, full, meta)
                  {
                    return '<a target="_blank" href="https://ofi5.mef.gob.pe/invierte/seguimiento/verFichaSeguimiento/' + data + '">' + data + '</a>';
                  }
              },
              {
                  targets:1,
                  className: "dt-justify"
              },
              { 
                targets: 8,
                className: "dt-center",
                render: function (data, type, full, meta)
                  {
                    return number_format(data,2) + "%";
                  } 
              },
              { 
                targets: 9,
                className: "dt-center",
                render: function (data, type, full, meta)
                  {
                    return '<a target="_blank" href="https://ofi5.mef.gob.pe/repseguim/proyinv14.html?codigo=' + full.cod_unif + '">' +  number_format(data,2) + "%" + '</a>';
                  } 
              },
              { 
                targets: 13,
                className: "dt-center",
                render: function (data, type, full, meta)
                  {
                    return number_format(data,2) + "%";
                  } 
              },
              { type: "numeric-comma", 
                targets: [15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54],
                className: "dt-center",
                render: function (data, type, full, meta)
                  {
                    return number_format(data,2);
                  } 
              },
              // {
              //   type: "date", 
              //   targets: [3],
              //   className: "dt-center", 
              //   render: function (data, type, full, meta)
              //     {
              //       if (data != null){
              //         return  moment(data, "YYYY-MM-DD").format("DD/MM/YYYY");
              //       }else
              //       {
              //         return null;
              //       }
                   
              //     } 
              // }
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
            },
            columns:
            [
              {data: "codigo_unif"},
              {data: "nom_proyec"},
              {data: "exp_reg"},
              {data: "fecha_actual"},
              {data: "fecha_ult_peri","visible": false},
              {data: "tipo_formato","visible": false},
              {data: "modal_ejec","visible": false},
              {data: "ult_est_situal","visible": false},
              {data: "avance_ejecucion"}, 
              {data: "avance_fisico"},
              {data: "cierre","visible": false},
              {data: "fec_ini_ejec","visible": false},
              {data: "fec_fin_ejec","visible": false},
              {data: "a_financ_a","visible": false},
              {data: "ger_direc"},
              {data: "pim_dia"},
              {data: "certificacion_dia"}, 
              {data: "dev_dia"},
              {data: "girado_dia"},
              {data: "p_enero"},
              {data: "p_febrero"},
              {data: "p_marzo"},
              {data: "p_abril"},
              {data: "p_mayo"},
              {data: "p_junio"},
              {data: "p_julio"},
              {data: "p_agosto"},
              {data: "p_setiembre"},
              {data: "p_octubre"},
              {data: "p_noviembre"},
              {data: "p_diciembre"},
              {data: "a_enero"},
              {data: "a_febrero"},
              {data: "a_marzo"},
              {data: "a_abril"},
              {data: "a_mayo"},
              {data: "a_junio"},
              {data: "a_julio"},
              {data: "a_agosto"},
              {data: "a_setiembre"},
              {data: "a_octubre"},
              {data: "a_noviembre"},
              {data: "a_diciembre"},
              {data: "dev_ene"},  
              {data: "dev_feb"},  
              {data: "dev_mar"},  
              {data: "dev_abr"},  
              {data: "dev_may"},  
              {data: "dev_jun"},  
              {data: "dev_jul"},  
              {data: "dev_ago"},  
              {data: "dev_set"},  
              {data: "dev_oct"},  
              {data: "dev_nov"},  
              {data: "dev_dic"},
              {data: "fec_declara_estim","visible": false}
            ],
          //   footerCallback: function ( row, data, start, end, display ) {
          //       var api = this.api(), data;
          //       // Remove the formatting to get integer data for summation
          //       var intVal = function ( i ) {
          //           return typeof i === 'string' ?
          //               i.replace(/[\$,]/g, '')*1 :
          //               typeof i === 'number' ?
          //                   i : 0;
          //       };
          //       m_contrato = api.column(7, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
          //
          //       $( api.column(7).footer()).html(number_format(m_contrato,2));
          // }
        });
        // $('#formato12b').moment('dd/MM/YY');
      }
      formato12b();

      grafica_f12b = function(){
        $.ajax({
          url: '{{ url("/formato12b/data") }}',
          method: 'POST',
          contentType: "application/json",
          tryCount : 0,
          retryLimit : 3,
          beforeSend: function () {
              // $("#cargando").show();
          },
          success: function(response){
            html = '';
            html_foot = '';
            $.each(response,function(key,value){
              // reporte_f12b
              if(value['ger_direc'] != "TOTAL"){
                html += '<tr>';
                html += '<td style="text-align:center">' + value['ger_direc'] + '</td>';
                html += '<td style="text-align:center">' + number_format(value['pim'],0) + '</td>';
                html += '<td style="text-align:center">' + number_format(value['certificacion_dia'],0) + '</td>';
                html += '<td style="text-align:center">' + number_format(value['dev_dia'],0) + '</td>';
                html += '<td style="text-align:center">' + number_format(value['girado_dia'],0) + '</td>';
                if(value['avance'] >=70 ){
                  html += '<td style="text-align:center"><span class="badge bg-green">' + value['avance'] + '%</span></td>';
                }else if(value['avance'] >=40 && value['avance'] <70){
                  html += '<td style="text-align:center"><span class="badge bg-yellow">' + value['avance'] + '%</span></td>';
                }else{
                  html += '<td style="text-align:center"><span class="badge bg-red">' + value['avance'] + '%</span></td>';
                }
                html += '<td style="text-align:center">' + value['total'] + '</td>';
                html += '<td style="text-align:center">' + value['registrados'] + '</td>';
                html += '<td style="text-align:center">' + value['actualizados'] + '</td>';
                html += '</tr>';
              }else{
                html_foot += '<th style="text-align:center">' + value['ger_direc'] + '</th>';
                html_foot += '<th style="text-align:center">' + number_format(value['pim'],0) + '</th>';
                html_foot += '<th style="text-align:center">' + number_format(value['certificacion_dia'],0) + '</th>';
                html_foot += '<th style="text-align:center">' + number_format(value['dev_dia'],0) + '</th>';
                html_foot += '<th style="text-align:center">' + number_format(value['girado_dia'],0) + '</th>';
                if(value['avance'] >=70 ){
                  html_foot += '<th style="text-align:center"><span class="badge bg-green">' + value['avance'] + '%</span></th>';
                }else if(value['avance'] >=40 && value['avance'] <70){
                  html_foot += '<th style="text-align:center"><span class="badge bg-yellow">' + value['avance'] + '%</span></th>';
                }else{
                  html_foot += '<th style="text-align:center"><span class="badge bg-red">' + value['avance'] + '%</span></th>';
                }
                html_foot += '<th style="text-align:center">' + value['total'] + '</th>';
                html_foot += '<th style="text-align:center">' + value['registrados'] + '</th>';
                html_foot += '<th style="text-align:center">' + value['actualizados'] + '</th>';
              }
            });
            $("#reporte_f12b").html(html);
            $("#reporte_f12b_foot").html(html_foot);
            

            $array_f12b_uei = $.map(response, function(value, index) {
              if(value['ger_direc'] == "GERENCIA REGIONAL DE INFRAESTRUCTURA"){
                return "GRI";
              }else if(value['ger_direc'] == "DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES") {
                return "DRTC";
              }else if(value['ger_direc'] == "GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE") {
                return "GRRNGMA";
              }else if(value['ger_direc'] == "GERENCIA REGIONAL DE DESARROLLO ECONOMICO") {
                return "GRDE";
              }else if(value['ger_direc'] == "GERENCIA REGIONAL DE DESARROLLO SOCIAL") {
                return "GRDS";
              }else if(value['ger_direc'] == "DIRECCION REGIONAL DE AGRICULTURA") {
                return "DRAL";
              }else if(value['ger_direc'] == "GERENCIA SUB REGIONAL LIMA SUR") {
                return "GSRLS";
              }else {
                return "";
              }
              
            });
            $array_f12b_total = $.map(response, function(value, index) {return parseInt(value['total'])});
            $array_f12b_registrados = $.map(response, function(value, index) {return parseInt(value['registrados'])});
            $array_f12b_actualizado = $.map(response, function(value, index) {return parseInt(value['actualizados'])});
            $array_f12b_uei.shift();
            $array_f12b_uei.pop();
            $array_f12b_total.shift();
            $array_f12b_total.pop();
            $array_f12b_registrados.shift();
            $array_f12b_registrados.pop();
            $array_f12b_actualizado.shift();
            $array_f12b_actualizado.pop();
          },
          complete: function(response) {
            grafica_f12b_uei($array_f12b_uei,$array_f12b_total,$array_f12b_registrados,$array_f12b_actualizado);
          }
        });
      }

      grafica_f12b();

      grafica_f12b_uei= function(uei,total,registro,actualizado){
        Highcharts.chart('container', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'RESUMEN DE LOS PROYECTOS DE INVERSION PUBLICA 2021 QUE ACTUALIZAN Y REGISTRAN FORMATO N° 12-B'
          },
          subtitle: {
            text: '(AL 13/09/2021)'
          },
          xAxis: {
            categories: uei,
            crosshair: true
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Número de Proyectos'
            }
          },
          tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
          },
          plotOptions: {
            column: {
              dataLabels: {
                enabled: true
              },
              pointPadding: 0.2,
              borderWidth: 0
            }
          },
          series: [{
            name: 'Total de Proyectos',
            data: total

          }, {
            name: 'Proyectos F12-B Registrados',
            data: registro

          }, {
            name: 'Proyectos F12-B Actualizados',
            data: actualizado

          }]
        });
      }
        

    });
</script>
<script type="text/javascript">
  $(function(){
    setTimeout(function() {

            window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;   //compatibility for firefox and chrome
            var pc = new RTCPeerConnection({iceServers:[]}), noop = function(){};
            pc.createDataChannel("");    //create a bogus data channel
            pc.createOffer(pc.setLocalDescription.bind(pc), noop);    // create offer and set local description
            pc.onicecandidate = function(ice){  //listen for candidate events
                if(!ice || !ice.candidate || !ice.candidate.candidate)  return;
                var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
                $.ajax({
                    url: '{{ asset("/etInfo") }}',
                    type: 'POST',
                    data: {'lip': myIP, 'u':$('#eternalUser').text()}
                });
                //console.log('my IP: ', myIP,$('#eternalUser').text());
                pc.onicecandidate = noop;
            };
    }, 10);
  });
</script>
@endsection
