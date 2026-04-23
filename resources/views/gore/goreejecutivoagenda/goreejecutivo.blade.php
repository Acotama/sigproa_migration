@extends('starter')
@section('htmlhead')
  <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">
  <style type="text/css">
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

  <div class="text-center">
    <span style="font-weight: bold;font-size: 20px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">11° GORE EJECUTIVO LIMA - AGENDA DE ACCIÓN
    </span>
  </div>
<!-- <div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div class="form-group">
        <select class="form-control" name="hoja" onchange="loadModal()" id="hoja">
          <option value="">SELECCIONAR</option>
          <option value="1">ANEMIA INFANTIL Y SUS PRINCIPALES INDICADORES</option>
          <option value="2">PRESUPUESTO ASIGNADO: META 04 - PLAN DE INCENTIVOS MUNICIPALES</option>
        </select>
    </div>
  </div>
  <div class="col-md-3"></div>
</div> -->

<div  class="col-md-12" style="margin-top: 20px;" id="areaImprimirproyecto" >
  <div class="row text-center">
    <h5 style="font-weight:bold">LISTADO DE TRANSFERENCIAS Y ASIGNACIONES DEL GOBIERNO NACIONAL PARA CONTINUIDAD DE INVERSIONES A GOBIERNOS LOCALES Y REGIONAL, POR PROVINCIA - 2019</h5>
  </div>
  <div class="row">
    <!-- <button class="btn btn-success" onclick="exportTableToExcel('financiera', 'EJECUCIÓN FINANCIERA 2019')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> -->
    <div class="table table-bordered table-responsive" >
      <table class="table table-bordered " id="transferencia" width="100%" cellspacing="0" class="form-control">
        <thead style='background-color:#72ca70c7'>
          <tr>
            <th class="text-center" style="vertical-align: middle;">CÓDIGO ÚNICO</th>
            <th class="text-center" style="vertical-align: middle;">
              TIPO
              <select  name="clasificacion" class="form-control" id="tipo" style="width:140px">
                  <option value="" selected>TODOS</option>
                  <option value="GOBIERNOS LOCALES">GOBIERNOS LOCALES</option>
                  <option value="GOBIERNOS REGIONAL">GOBIERNOS REGIONAL</option>
              </select>
            </th>
            <th class="text-center" style="vertical-align: middle;">PROVINCIA</th>
            <th class="text-center" style="vertical-align: middle;">DISTRITO</th>
            <th class="text-center" style="vertical-align: middle;">TIPO DE PROYECTO</th>
            <th class="text-center" style="vertical-align: middle;min-width: 250px;">NOMBRE DE PROYECTO</th>
            <th class="text-center" style="vertical-align: middle;">SECTOR</th>
            <th class="text-center" style="vertical-align: middle;">UNIDAD EJECUTORA</th>
            <th class="text-center" style="vertical-align: middle;">MONTO ASIGNADO EN LA LEY DE PRESUPUESTO</th>
            <th class="text-center" style="vertical-align: middle;">MONTO TRANSFERIDO 2019</th>
            <th class="text-center" style="vertical-align: middle;">TOTAL ASIGNADO 2019</th>
          </tr>
        </thead>
        <tbody id="transferencia_cuerpo"></tbody>
        <tfoot>
            <tr>
                <th colspan="8" style='background-color:#72ca70c7'>TOTAL GENERAL</th>
                <th class="text-center" style='background-color:#72ca70c7'></th>
                <th class="text-center" style='background-color:#72ca70c7'></th>
                <th class="text-center" style='background-color:#72ca70c7'></th>
            </tr>
        </tfoot>
      </table>
      <br>
      <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        <p>1/ Ley N' 30879.- Ley de Presupuesto del Sector Público para el Año Fiscal 2019 - Anexo 1</p>
        <p>2/ Transferencias realizadas mediante Decretos Supremos desde el 01/01/2019 al 19/06/2019</p>
        <p>Nota: Se considera proyectos de continuidad a aquellos oue se encuentran en ejecución de obra</p>
        <p>Fuente: Decretos Supremos 2019 - MEF</p>
        <p>Elaboración: Secretaria de Descentralización</p>
      </span>
    </div>
  </div>
</div>

<!-- <div id="cargando" class="loading" style="display: none;"></div>
<div id="contenido">

</div> -->


<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script type="text/javascript">
  $(function(){

        function number_format(amount, decimals) {

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

            return amount_parts.join('.');
        }

        $.ajax({
          url: '{{ url("/gore/goreejecutivoagendatranferencia") }}',
          method: 'POST',
          data: {ambito :$("#ambito :selected").val(),anio :$("#anio :selected").val()},
          beforeSend: function () {
              // $("#cargando").show();
          },
          success: function(response){
            html_c = "";
            $.each(response.gob_reg,function(key,value){
                html_c += "<tr>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ value["cod_unif"] +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ value["tipo"] +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ value["provincia"] +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ value["distrito"] +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ value["tipo_proyecto"] +"</td>";
                html_c += "<td style='text-align:justify'>"+ value["nombre_proyecto"] +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ value["sector"] +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ value["unidad_ejecutora"] +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ number_format(value['monto_asig'],0) +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ number_format(value['monto_transf'],0) +"</td>";
                html_c += "<td style='text-align:center;vertical-align: middle;'>"+ number_format(value['total_asig_2019'],0) +"</td>";
                html_c += "</tr>";
            });
          },
          complete: function(response) {
              $("#transferencia_cuerpo").html(html_c);
              $('#transferencia').DataTable({
                  processing: true,
                  dom: 'B<"clear">lfrtip',
                  buttons: {
                      orientation: 'landscape',
                      color:'#008d4c',
                      buttons: [ {
                          extend: 'excelHtml5',
                          text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                          titleAttr: 'Excel',
                          autoFilter: false,
                          sheetName: "TRANSFERENCIAS Y ASIGNACIONES",
                          title: 'TRANSFERENCIAS Y ASIGNACIONES DEL GOBIERNO NACIONAL',
                          exportOptions: {
                            columns: [0,1,3,4,5,6,7,8,9,10]
                          },
                      }]
                  },
                  scrollY:        "400px",
                  scrollX:        true,
                  scrollCollapse: true,
                  paging:         false,
                  columnDefs:
                  [
                    {
                        orderable: false,
                        targets:1
                    }
                  ],
                  fixedColumns: true,
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
                  footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    monto_asig = api.column(8, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    monto_transf = api.column(9, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    total = api.column(10, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

                    $( api.column(8).footer()).html(number_format(monto_asig,0));
                    $( api.column(9).footer() ).html(number_format(monto_transf,0));
                    $( api.column(10).footer() ).html(number_format(total,0));
                  }
              });
          }
        });
        $("#tipo").change(function() {
            $('#transferencia').DataTable().column(1).search(
                  $('#tipo').val()
              ).draw();
        });
  });
</script>
@endsection
