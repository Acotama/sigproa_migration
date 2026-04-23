@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{asset('plugins/chartjs/chart.min.js')}}"></script>
    <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@7.1.0/dist/handsontable.full.min.css">

@endsection

@section('body')
<style type="text/css">

  .ht_master tr td {
    color: #000 !important;
    text-align: center;
  }
  /* All headers */
  .handsontable th {
    background-color: #94e094;
    font-weight:bold;
  }

  /* Row headers */
  .ht_clone_left th {
    background-color: #94e094;
  }

  /* Column headers */
  .ht_clone_top th {
    background-color: #94e094;
  }

   /* Row headers */
      .ht_clone_top_left_corner th {
        border-bottom: 1px solid ##000 !important;
      }

      /* Left and right */
      .ht_clone_left th {
        border-right: 1px solid ##000 !important;
        border-left: 1px solid ##000 !important;
      }

      /* Column headers */
      /* Top, bottom and right */
      .ht_clone_top th {
        border-top: 1px solid ##000 !important;
        border-right: 1px solid ##000 !important;
        border-bottom: 1px solid ##000 !important;
      }
      /* Left */
      .ht_clone_top_left_corner th {
        border-right: 1px solid ##000 !important;
      }
  /* Row headers */
  /* Specific cell (B2) */
  #resumen .ht_master td:nth-child(1) {
    text-align: left;
  }

  #wdr-component .ht_master td:nth-child(2) {
    text-align: left;
  }

  #proyecto .ht_master td:nth-child(2) {
    text-align: left;
  }

  #requerimiento .ht_master td:nth-child(2) {
    text-align: left;
  }

  #requerimientofiltro .ht_master td:nth-child(2) {
    text-align: left;
  }

  #resumen .ht_master td:nth-child(3) {
    /* background-color: #F025; */
    cursor:pointer;
  }

  #resumen .ht_master td:nth-child(2) {
    /* background-color: #F025; */
    cursor:pointer;
  }

  #proyecto .ht_master td:nth-child(3) {
    /* background-color: #F025; */
    cursor:pointer;
  }

</style>

<div class="well">
    <div class="text-center">
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">REGISTRO DE LOS PROCEDIMIENTO DE CONTRATACIONES
      </span>
    </div>
    <br>
    <div class="controls">
        <button name="save" id="save" class="btn btn-primary" data-toggle="Guardar" style="float: left;margin-right: 2px;"><i class="fa fa-save"></i></button>
        <form  class="was-validated" id="frm-exportar"  action="{{asset('/procedimiento/exportar')}}" type="GET">
          <button type="submit" class="btn btn-success" name="exportar" id="exportar"><i class="fa fa-file-excel-o"> Exportar Excel</i></button>
        </form>
    </div>
    <br>
    <div id="wdr-component"></div>
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

<script src="https://cdn.jsdelivr.net/npm/handsontable@7.1.0/dist/handsontable.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/handsontable@7.1.0/dist/languages/all.js"></script>

<script>
  $(function(){

    $("body").addClass('sidebar-collapse');

    function handsonTableLoad(url) {
        return new Promise(function(resolve, reject) {
          var request = new XMLHttpRequest();
          request.open('GET', url);
          request.responseType = 'json';
          request.onload = function() {
            if (request.status === 200) {
              resolve(request.response);
            } else {
              reject(Error('Data didn\'t load successfully; error code:' + request.statusText));
            }
          };
          request.onerror = function() {
              reject(Error('There was a network error.'));
          };
          request.send();
        });
    }

    var
    $$ = function(id) {
      return document.getElementById(id);
    },
    container = $$('wdr-component'),
    save = $$('save'),
    hot;

    handsonTableLoad('/procedimiento/datosjson').then(function(response) {
           var hot = new Handsontable(container, {
                  data: response.data,
                  stretchH: 'all',
                  language: 'es-MX',
                  className: "htMiddle",
                  autoWrapRow: false,
                  multiColumnSorting: true,
                  licenseKey: 'non-commercial-and-evaluation',
                  height: 600,
                  width:'100%',
                  hiddenColumns: {
                    columns: [27,28,29,30,31],
                    indicators: true
                  },
                  manualRowResize: true,
                  manualColumnResize: true,
                  colWidths: [500,150,200,220,220,220,220,220,300,300,300,300,300,300,300,200,300,350,300,200,200,200,300,300,300,200,200,300,300,300,100,200],
                  colrow: true,
                  rowHeaders: true,
                  rowHeights: [100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100,100,100,100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100,100,100,100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100,100,100,100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100,100,100],
                  colHeaders:[
                    "NOMENCLATURA DEL PROCEDIMIENTO DE SELECCIÓN",
                    "CÓDIGO UNIFICADO",
                    "NORMATIVIDAD APLICABLE",
                    "OBJETO DE LA CONTRATACIÓN",
                    "REQUERIMIENTO (DOCUMENTO)",
                    "REQUERIMIENTO (FECHA)",
                    "CERTIFICACIÓN (DOCUMENTO)",
                    "CERTIFICACION (FECHA)",
                    "APROBACION DE EXPEDIENTE (DOCUMENTO)",
                    "APROBACION DE EXPEDIENTE (FECHA)",
                    "COMITE DE SELECCION (DOCUMENTO)",
                    "COMITE DE SELECCION (FECHA)",
                    "COMITE DE SELECCION (MIEMBROS)",
                    "APROBACION DE BASES  (DOCUMENTO)",
                    "APROBACION DE BASES  (FECHA)",
                    "FECHA DE CONVOCATORIA",
                    "TIPO DE PROCEDIMIENTOS DE SELECCIÓN",
                    "NÚMERO DE PROCEDIMIENTOS DE SELECCIÓN",
                    "VALOR REFERENCIAL / ESTIMADO",
                    "ESTADO",
                    "ESTADO (FECHA)",
                    "ESTADO(OBSERVACIÓN)",
                    "BUENO PRO ESTIMADA FECHA",
                    "FECHA REAL DE LA BUENA PRO",
                    "OBSERVACION DE LA BUENA PRO",
                    "PROVEEDOR ADJUJICADO",
                    "VALOR ADJUDICADO",
                    "CONTRATO U ORDEN (DOCUMENTO)",
                    "CONTRATO U ORDEN (MONTO)",
                    "CONTRATO U ORDEN (FECHA)",
                    "AÑO",
                    "FECHA ACTUALIZACIÓN"
                  ],
                  columns: [
                    {data:"nom_pro_seleccion"},
                    {data:"cod_unif", type: 'numeric'},
                    {data:"norma_aplicable"},
                    {data:"objeto_contratacion"},
                    {data:"requerimiento_documento"},
                    {data:"requerimiento_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"certificacion_documento"},
                    {data:"certificacion_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"aprob_exp_documento"},
                    {data:"aprob_exp_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"com_sel_documento"},
                    {data:"com_sel_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"com_sel_miembros"},
                    {data:"aprob_bases_documento"},
                    {data:"aprob_bases_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"fecha_convocatoria",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"tipo_proc_selec"},
                    {data:"num_proc_selec"},
                    {data:"valor_ref_est",type:"numeric",className: "htCenter",numericFormat: {pattern:"0.0,00"}},
                    {data:"estado"},
                    {data:"estado_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"estado_obs"},
                    {data:"buena_pro_est_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"buena_pro_fecha_real",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"buena_pro_obs"},
                    {data:"prov_adjudicado"},
                    {data:"valor_adjudicado",type:"numeric",className: "htCenter",numericFormat: {pattern:"0.0,00"}},
                    {data:"cont_documento"},
                    {data:"cont_monto",type:"numeric",className: "htCenter",numericFormat: {pattern:"0.0,00"}},
                    {data:"cont_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                    {data:"ano",type: 'numeric'},
                    {data:"fech_act",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true}
                  ],
                  manualColumnMove: true,
                  contextMenu: true,
                  dropdownMenu: [
                    'filter_by_value',
                    'filter_action_bar'
                  ],
                  filters: true
          });
          
          Handsontable.dom.addEvent(save, 'click', function() {
            dato=JSON.stringify(hot.getData());
            // save all cell's data
            $.ajax({
                url: '{{ url("/procedimiento/guardar") }}',
                type: 'POST',
                data: {data: dato},
                beforeSend: function () {
                },
                success: function(response){
                  swal({
                      title: "Guardado",
                      text: response.messages + " Datos guardados.",
                      type: "success",
                      cancelButtonClass: 'btn btn-success',
                      cancelButtonText:'ok',
                    })
                },
                complete: function(response) {
                },
                error: function(response){
                  if(response.error){
                    swal({
                      title: "Verifique el tipo de dato de celda",
                      text: "Corregir celda con fondo color rojo",
                      type: "error",
                      cancelButtonClass: 'btn btn-danger',
                      cancelButtonText:'ok',
                    })
                  }
                }
            });
          }); 

          /*hot.addHook('afterChange', function(changes){
            var row = changes[0][0];
            var campo = changes[0][1];
            var dato_ant = changes[0][2];
            var dato_nuevo = changes[0][3];
            var id = hot.getDataAtCell(row,0);
            console.log(changes);
            if(dato_ant!=dato_nuevo){
              $.ajax({
                url: '{{ url("/procedimiento/guardar") }}',
                method: 'POST',
                data: {id:id,campo:campo,dato_nuevo:dato_nuevo},
                beforeSend: function () {
                },
                success: function(response){
                  console.log(response);
                },
                complete: function(response) {
                }
              });
            }
          })*/
          }, function(Error) {
            console.log(Error);
    });  

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
