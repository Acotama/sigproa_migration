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
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">LISTADO DE CONTRATACIONES
      </span>
    </div>
</div>


<div style="page-break-after: always"></div>

<div class="well">
    <div class="text-center">
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">RESUMEN POR UNIDAD EJECUTORA
      </span>
    </div>
    <br>
    {{-- <button class="btn btn-success" onclick="exportTableToExcel('resumen', 'RESUMEN POR UNIDAD EJECUTORA')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> --}}
    <div id="resumen"></div>
    <br>
    <h4 id="tituloproyecto" style="font-weight: bold;display:none"></h4>
    {{-- <button class="btn btn-success"  style="display:none" id="exproyecto" onclick="exportTableToExcel('proyecto', 'PROYECTOS CON CONTRATACIONES')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> --}}
    <div id="proyecto"></div>
    <br>
    <h4 id="titulorequerimiento" style="font-weight: bold;display:none"></h4>
    {{-- <button class="btn btn-success" style="display:none"  id="exrequerimiento" onclick="exportTableToExcel('proyecto', 'REQUERIMIENTOS')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> --}}
    <div id="requerimiento"></div>
    <br>
    <h4 id="titulorequerimientofiltro" style="font-weight: bold;display:none"></h4>
    {{-- <button class="btn btn-success" style="display:none"  id="exrequerimientofiltro"  onclick="exportTableToExcel('requerimientofiltro', 'LISTADO DE REQUERIMIENTOS')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> --}}
    <div id="requerimientofiltro"></div>
    <br>
</div>
<div class="well">
    <div class="text-center">
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">LISTADO GENERAL DE CONTRATACIONES
      </span>
    </div>
    <br>
    <div class="controls">
      <form  class="was-validated" id="frm-exportar"  action="{{asset('/procedimiento/exportar')}}" type="GET">
        <button type="submit" class="btn btn-success" name="exportar" id="exportar"><i class="fa fa-file-excel-o"> Exportar Excel</i></button>
      </form>
    </div>
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

         function handsonTableLoad_filtro(url,filtro) {
              return new Promise(function(resolve, reject) {
                var request = new XMLHttpRequest();
                const params = {
                    gerencia: filtro
                }
                request.open('POST', url);
                request.responseType = 'json';
                request.setRequestHeader('Content-type', 'application/json')
                request.send(JSON.stringify(params))
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
              });
         }

         var container = document.getElementById('wdr-component');
         var container2 = document.getElementById('resumen');
         var container3 = document.getElementById('proyecto');
         var container4 = document.getElementById('requerimiento');
         var container5 = document.getElementById('requerimientofiltro');
         var i=0;
         var proyecto;

         function commentsRenderer(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            // td.innerHTML = '<div title="Información detallada, doble clic aqui.">' + td.innerHTML + '</div>';
            td.title="Información detallada, doble clic aqui.";
         }

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
                      {data:"valor_ref_est",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                      {data:"estado"},
                      {data:"estado_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                      {data:"estado_obs"},
                      {data:"buena_pro_est_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                      {data:"buena_pro_fecha_real",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                      {data:"buena_pro_obs"},
                      {data:"prov_adjudicado"},
                      {data:"valor_adjudicado",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                      {data:"cont_documento"},
                      {data:"cont_monto",type:"numeric",numericFormat: {pattern:"0.0,00"}},
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
                    filters: true,
                    readOnly: true,
          });
          var hot2 = new Handsontable(container2, {
                 data: response.resumen,
                 stretchH: 'all',
                 language: 'es-MX',
                 autoWrapRow: true,
                 licenseKey: 'non-commercial-and-evaluation',
                 height: 150,
                 manualRowResize: true,
                 manualColumnResize: true,
                 colWidths: [
                   280,80,120,100,200,150,150,80,150,100],
                 nestedHeaders: [
                   [
                     "GERENCIA",
                     "PROYECTO <div class='fa fa-exclamation-circle'></div>",
                     "REQUERIMIENTO <div class='fa fa-exclamation-circle'></div>",
                     "CERTIFICACIÓN",
                     "APROBACION DE EXPEDIENTE",
                     "COMITE DE SELECCION",
                     "APROBACION DE BASES",
                     "CONTRATO",
                     "VALOR REFERENCIAL",
                     "VALOR ADJUDICADO"
                   ]
                 ],
                 columns: [
                   {data:"ger_direc"},
                   {data:"proyecto"},
                   {data:"requerimiento"},
                   {data:"certificacion"},
                   {data:"aprob_expediente"},
                   {data:"comite_seleccion"},
                   {data:"aprob_bases"},
                   {data:"contrato"},
                   {data:"valor_ref_est",type:"numeric",numericFormat: {pattern:"0,0.00"}},
                   {data:"valor_adjudicado",type:"numeric",numericFormat: {pattern:"0,0.00"}}
                 ],
                 manualColumnMove: true,
                 contextMenu: true,
                 dropdownMenu: false,
                 readOnly: true,
                 cells: function(row, col) {
                   var cellProperties = {};
                   if (col === 1) {
                     cellProperties.renderer = commentsRenderer
                   }
                   if (col === 2) {
                     cellProperties.renderer = commentsRenderer
                   }
                   return cellProperties;
                 }
           });
            // $('#hot-display-license-info').hide();
            $("#resumen").dblclick(function() {
              $cell=[];
              $cell=hot2.getSelected();
              if($cell[0][1]==1) {

                // console.log($cell);
                // console.log(($cell[0][0]) + "-" + ($cell[0][1] -1));
                // alert(hot2.getData($cell[0][0],($cell[0][1] -1),$cell[0][0],($cell[0][1] -1)));
                $gerencia=hot2.getData($cell[0][0],($cell[0][1] -1),$cell[0][0],($cell[0][1] -1));
                // console.log($gerencia[0][0]);
                handsonTableLoad_filtro('/procedimiento/datosproyecto',$gerencia[0][0]).then(function(response) {
                  $("#tituloproyecto").show();
                  $("#exproyecto").show();
                  $("#proyecto").show();
                  $("#requerimientofiltro").hide();
                  $("#exrequerimientofiltro").hide();
                  $("#titulorequerimientofiltro").hide();
                  $("#titulorequerimiento").hide();
                  $("#requerimiento").hide();
                  $("#exrequerimiento").hide();
                  $("#tituloproyecto").show();
                  $("#tituloproyecto").html("PROYECTOS CON CONTRATACIONES - " + $gerencia[0][0]);

                       proyecto = new Handsontable(container3, {
                         data: response.proyecto,
                         stretchH: 'all',
                         language: 'es-MX',
                         autoWrapRow: true,
                         licenseKey: 'non-commercial-and-evaluation',
                         height: 200,
                         manualRowResize: true,
                         manualColumnResize: true,
                         colWidths: [
                           100,300,120,100,200,150,150,100,150,100],
                         nestedHeaders:[
                           [
                             "COD. UNIF.",
                             "PROYECTO",
                             "REQUERIMIENTO <div class='fa fa-exclamation-circle'></div>",
                             "CERTIFICACIÓN",
                             "APROBACION DE EXPEDIENTE",
                             "COMITE DE SELECCION",
                             "APROBACION DE BASES",
                             "CONTRATO",
                             "VALOR REFERENCIAL",
                             "VALOR ADJUDICADO"
                           ]
                         ],
                         columns: [
                           {data:"cod_unif"},
                           {data:"nom_proyec"},
                           {data:"requerimiento"},
                           {data:"certificacion"},
                           {data:"aprob_expediente"},
                           {data:"comite_seleccion"},
                           {data:"aprob_bases"},
                           {data:"contrato"},
                           {data:"valor_ref_est",type:"numeric",numericFormat: {pattern:"0,0.00"}},
                           {data:"valor_adjudicado",type:"numeric",numericFormat: {pattern:"0,0.00"}}
                         ],
                         manualColumnMove: true,
                         contextMenu: true,
                         dropdownMenu: false,
                         readOnly: true,
                         cells: function(row, col) {
                           var cellProperties = {};
                           if (col === 2) {
                             cellProperties.renderer = commentsRenderer
                           }
                           return cellProperties;
                         }
                   });
                   $("#proyecto").dblclick(function() {
                     $cell_proyecto=[];
                     $cell_proyecto=proyecto.getSelected();
                     // console.log(proyecto.getSelected());
                     if($cell_proyecto[0][1]==2) {
                       $gerencia_proyecto=proyecto.getData($cell_proyecto[0][0],($cell_proyecto[0][1] -2),$cell_proyecto[0][0],($cell_proyecto[0][1] -2));
                        // console.log($gerencia_proyecto);
                       handsonTableLoad_filtro('/procedimiento/datosrequerimientosfiltro',$gerencia_proyecto[0][0]).then(function(response) {
                         $("#requerimientofiltro").show();
                         $("#exrequerimientofiltro").show();
                         $("#titulorequerimientofiltro").show();
                         $("#titulorequerimiento").hide();
                         $("#requerimiento").hide();
                         $("#exrequerimiento").hide();
                         $("#titulorequerimientofiltro").html("LISTADO DE REQUERIMIENTOS DEL PROYECTO CON CODIGO UNIFICADO - " + $gerencia_proyecto[0][0]);
                          var  requerimientofiltro = new Handsontable(container5, {
                              data: response.requerimiento,
                              stretchH: 'all',
                              language: 'es-MX',
                              className: "htMiddle",
                              autoWrapRow: false,
                              multiColumnSorting: true,
                              licenseKey: 'non-commercial-and-evaluation',
                              height: 300,
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
                                {data:"valor_ref_est",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                                {data:"estado"},
                                {data:"estado_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                                {data:"estado_obs"},
                                {data:"buena_pro_est_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                                {data:"buena_pro_fecha_real",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                                {data:"buena_pro_obs"},
                                {data:"prov_adjudicado"},
                                {data:"valor_adjudicado",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                                {data:"cont_documento"},
                                {data:"cont_monto",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                                {data:"cont_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                                {data:"ano",type: 'numeric'},
                                {data:"fech_act",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true}
                              ],
                              manualColumnMove: true,
                              contextMenu: true,
                              readOnly: true
                         });

                       }, function(Error) {
                         console.log(Error);
                       });
                     }
                   })
                }, function(Error) {
                  console.log(Error);
                });
              }
              if($cell[0][1]==2) {
                $gerencia=hot2.getData($cell[0][0],($cell[0][1] -2),$cell[0][0],($cell[0][1] -2));
                handsonTableLoad_filtro('/procedimiento/datosrequerimientos',$gerencia[0][0]).then(function(response) {
                  $("#tituloproyecto").hide();
                  $("#proyecto").hide();
                  $("#exproyecto").hide();
                  $("#requerimientofiltro").hide();
                  $("#exrequerimientofiltro").hide();
                  $("#titulorequerimientofiltro").hide();
                  $("#titulorequerimiento").show();
                  $("#requerimiento").show();
                  $("#exrequerimiento").show();
                  $("#titulorequerimiento").show();
                  $("#titulorequerimiento").html("REQUERIMIENTOS  - " + $gerencia[0][0]);
                  var requerimiento = new Handsontable(container4, {
                        data: response.requerimiento,
                        stretchH: 'all',
                        language: 'es-MX',
                        className: "htMiddle",
                        autoWrapRow: false,
                        multiColumnSorting: true,
                        licenseKey: 'non-commercial-and-evaluation',
                        height: 300,
                        hiddenColumns: {
                          columns: [27,28,29,30,31],
                          indicators: true
                        },
                        width:'100%',
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
                          {data:"valor_ref_est",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                          {data:"estado"},
                          {data:"estado_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                          {data:"estado_obs"},
                          {data:"buena_pro_est_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                          {data:"buena_pro_fecha_real",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                          {data:"buena_pro_obs"},
                          {data:"prov_adjudicado"},
                          {data:"valor_adjudicado",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                          {data:"cont_documento"},
                          {data:"cont_monto",type:"numeric",numericFormat: {pattern:"0.0,00"}},
                          {data:"cont_fecha",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true},
                          {data:"ano",type: 'numeric'},
                          {data:"fech_act",type:'date',dateFormat: 'YYYY-MM-DD',correctFormat: true}
                        ],
                        manualColumnMove: true,
                        contextMenu: true,
                        readOnly: true
                  });
                }, function(Error) {
                  console.log(Error);
                });
              }
            })
            Handsontable.hooks.add('modifyColWidth', function(width) {
              if (this === hot.getPlugin('dropdownMenu').menu.hotMenu) {
                return 300;
              }
              return width;
            });
          }, function(Error) {
            console.log(Error);
          });

         imprimir = function () {
            window.print();
            return false;
         }

         printDiv = function (nombreDiv) {
             var contenido= document.getElementById(nombreDiv).innerHTML;
             var contenidoOriginal= document.body.innerHTML;
             document.body.innerHTML = contenido;
             window.print();
             document.body.innerHTML = contenidoOriginal;
         }

         exportTableToExcel = function (tableID, filename = ''){
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            filename = filename?filename+'.xls':'excel_data.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if(navigator.msSaveOrOpenBlob){
                var blob = new Blob(['ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob( blob, filename);
            }else{
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }
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
