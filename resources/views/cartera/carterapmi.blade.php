@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{asset('plugins/chartjs/chart.min.js')}}"></script>
    <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">

    <style>

        #jnav ul{height:700px; width:100%;}
        #jnav ul{overflow:hidden; overflow-y:scroll;}
        .sweetalert-lg{
            width: 900px !important;
        }
        .imgContainer {
            position: relative;
            width: 100%;
        }

        .imgContainer .image {
          opacity: 1;
          display: block;
          width: 100%;
          height: 400px;
          transition: .5s ease;
          backface-visibility: hidden;
        }

        .imgContainer .middle {
          transition: .5s ease;
          opacity: 0;
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          -ms-transform: translate(-50%, -50%)
        }

        .imgContainer:hover .image {
          opacity: 0.3;
        }

        .imgContainer:hover .middle {
          opacity: 1;
        }

        .imgContainer .text {
          background-color: #4CAF50;
          color: white;
          font-size: 16px;
          padding: 16px 32px;
        }
    </style>
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
<div  class="col-md-12" style="margin-top: 20px;" id="areaImprimirproyecto" >
  <div class="row text-center">
    <h3 style="font-weight:bold">PROGRAMACIÓN MULTIANUAL DE INVERSIONES</h3>
    <br>
  </div>
  <div class="row">
    <div class="table  table-responsive" >
      <table id="carterapmi" class="table table-striped table-bordered table-hover" st-sticky-header="">
        <thead>
            @php
              $year= date("Y");
            @endphp
            <tr>
                <th rowspan="2" class="hidden"></th>
                <th rowspan="2" style="width: 8%;vertical-align: middle;" class="text-center">Prioridad</th>
                <th rowspan="2" style="width: 8%;vertical-align: middle;" class="text-center">Orden prelación (*)</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">Sector</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">OPMI</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">UF</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">UEI</th>
                <!--<th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">Nivel Gobierno</th>-->
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">Provincia</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">Funcion</th>
                <th rowspan="2" style="width: 8%;vertical-align: middle;" class="text-center">Código único</th>
                <th rowspan="2" style="width: 8%;vertical-align: middle;" class="text-center">Código idea</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">Tipo de inversión</th>
                <th rowspan="2" style="width: 20%;vertical-align: middle;" class="text-center">Nombre inversión</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">Costo actualizado (S/)</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">Devengado acumulado (S/) (al 31 dic. {{$year - 1}})</th>
                <th rowspan="2" style="width: 10%;vertical-align: middle;" class="text-center">PIM {{$year}} (S/)</th>
                <th colspan="4" class="text-center">Programación del monto de inversión (S/)</th>
                <th rowspan="2"  class="hidden">Servicio identificada</th>
                <th rowspan="2"  class="hidden">Indicador de brechas</th>
                <th rowspan="2"  class="hidden">Unidad de medida</th>
                <th rowspan="2"  class="hidden">Espacio geográfico</th>
                <th rowspan="2"  class="hidden">Contribución cierre brechas</th>
            </tr>
            <tr>
                <th style="width: 10%" class="text-center">Monto año {{$year}} (S/)</th>
                <th style="width: 10%" class="text-center">Monto año {{$year + 1 }} (S/)</th>
                <th style="width: 10%" class="text-center">Monto año {{$year + 2 }} (S/)</th>
                <th style="width: 10%" class="text-center">Monto año {{$year + 3 }} (S/)</th>
            </tr>
        </thead>
      </table>
      </span>
    </div>
  </div>
</div>
<br>

<script  src="https://demos.codexworld.com/print-specific-area-of-web-page-using-jquery/jquery.PrintArea.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>

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

      var table = $('#carterapmi').DataTable({
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
                  sheetName: 'PMI',
                  title: 'PMI',
                  exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
                  },
              }]
          },
          scrollY:        "600px",
          scrollX:        true,
          scrollCollapse: true,
          paging:         false,
          autoWidth:      true,
          ajax:
          {
            url: '{{ url("carterapmi/datos") }}',
            type: 'get',
            contentType: "application/json",
          },
          columnDefs:
          [
            {
                targets:13,
                render: function (data, type, full, meta)
                {
                  return number_format(data,2);
                }
            },
            {
                targets:14,
                render: function (data, type, full, meta)
                {
                  return number_format(data,2);
                }
            },
            {
                targets:15,
                render: function (data, type, full, meta)
                {
                  return number_format(data,2);
                }
            },
            {
                targets:16,
                render: function (data, type, full, meta)
                {
                  return number_format(data,2);
                }
            },
            {
                targets:17,
                render: function (data, type, full, meta)
                {
                  return number_format(data,2);
                }
            },
            {
                targets:18,
                render: function (data, type, full, meta)
                {
                  return number_format(data,2);
                }
            },
            {
                targets:19,
                render: function (data, type, full, meta)
                {
                  return number_format(data,2);
                }
            },
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
            {data: "id_carterapmi","visible": false},
            {data: "prioridad"},
            {data: 'orden_prelacion'},
            {data: "sector"},
            {data: 'opmi'},
            {data: 'pliego'},
            {data: 'ger_direc'},
            // {data: 'nivel_gob'},
            {data: 'nom_prov'},
            {data: 'funcion'},
            {data: 'codigo_unico'},
            {data: "codigo_idea"},
            {data: 'tipo_inversion'},
            {data: "nombre_inversion"},
            {data: 'costo_actualizado'},
            {data: "devengado_acumulado"},
            {data: 'pim'},
            {data: "monto_1"},
            {data: "monto_2"},
            {data: 'monto_3'},
            {data: "monto_4"},
            {data: "brecha","visible": false},
            {data: "indicador","visible": false},
            {data: "unidad_medida","visible": false},
            {data: "espacio_geo","visible": false},
            {data: "cont_cierre","visible": false},
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

      // $(".dataTables_filter input").attr("placeholder", "Codigo Unificado");
      // $("#ue").change(function() {
      //   if ($('#ue').val()=='') {
      //     $value=$('#ue').val();
      //   }
      //   else {
      //     $value="^" + $('#ue').val() + "$";
      //   }
      //   table.column(2).search(
      //     $value, true, false, true
      //     ).draw();
      // });
      // $("#fecha").change(function() {
      //   table.column(3).search(
      //         $('#fecha').val()
      //     ).draw();
      // });
      // $('.dataTables_filter input').unbind().bind('keyup', function() {
      //   table.column(0).search( this.value ).draw();
      // });
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


