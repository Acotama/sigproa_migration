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
          background: radial-gradient(center, ellipse cover, #ff0000 1%,#cc0000 100%);
        }

        .seleccion{
            background-color: #3c8dbc9c;
            font-weight: bold;
        }

        .seleccion_dev{
            background-color: #dcba85; 
            font-weight: bold;
        }

        .seleccion_apru{
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
        /*FIN CARGANDO*/
    </style>
@endsection

@section('body')
<div class="form-group row" style="display:none;">
  <label for="fecha" class="col-sm-2 col-form-label" style="text-align:right;">Fecha:</label>
  <div class="col-sm-4" >
    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ date('Y-m-d') }}">
  </div>
</div>
<div class="form-inline row text-center">
  <div class="col-md-2"></div>
  <div class="col-md-4 form-group">
    <label for="anio">Año:</label>
    <select  name="anio" class="form-control" id="anio"  onchange="tablefinanciera(),years()">
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
  <div class="col-md-4 form-group">
    <label for="ambito">Buscar por:</label>
    <select  name="ambito" class="form-control" id="ambito"  onchange="tablefinanciera()">>
        <option value="EJECUTORA" selected>EJECUTORA</option>
        <option value="PROVINCIA">PROVINCIA</option>
        <option value="ETAPA">ETAPA</option>
        <option value="SECTOR">SECTOR</option>
        <option value="PROYECTO">PROYECTO</option>
        <option value="FUENTE">FUENTE FINANCIAMIENTO</option>
    </select>
  </div>
  <div class="col-md-2"></div>
</div>

<div style="page-break-after: always"></div>
<div  class="col-md-12" style="margin-top: 20px;" id="areaImprimir">
  <div class="row text-center">
    <h3 style="font-weight:bold">PROYECTOS DE INVERSIÓN PUBLICA DEL GOBIERNO REGIONAL DE LIMA</h3>
    <h4 style="font-weight:bold">AVANCE DE LA EJECUCIÓN FINANCIERA <label class="years"></label></h4>
  </div>
  <div class="row">
    {{-- <button class="btn btn-primary" onclick="exportTableToExcel('financiera', 'EJECUCIÓN FINANCIERA')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> --}}
    <form id="exportar" action="{{asset('/proyecto/table_financiera_exportar')}}" method="GET">
      <input type="hidden" id="e_anio" name="anio">
      <input type="hidden" id="e_ambito" name="ambito">
      <button class="btn btn-primary" style="margin-bottom: 5px"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> 
    </form>
    
    <div class="table table-bordered table-responsive" >
      <div id="cargando" class="loading" style="display: none;"></div>
      <table class="table" id="financiera">
        <thead>
          <tr>
            <th  style="text-align:center;vertical-align:middle;">N°</th>
            <th colspan="2" style="text-align:center;vertical-align:middle;">CATEGORIA</th>
            <th  style="text-align:center;vertical-align:middle;">MONTO INV. ACT.</th>
            <th  style="text-align:center;vertical-align:middle;">DEVEN. ACUM. ACT.</th>
            <th  style="text-align:center;vertical-align:middle;">AVANCE ACUM. ACT.</th>
            <th  style="text-align:center;vertical-align:middle;">PIA <label class="years"></label></th>
            <th  style="text-align:center;vertical-align:middle;">PIM <label class="years"></label></th>
            <!-- <th  style="text-align:center;vertical-align:middle;">PORCENTAJE</th> -->
            <th  style="text-align:center;vertical-align:middle;">CERTIF <label class="years"></label></th>
            <th  style="text-align:center;vertical-align:middle;">COMP. ANUAL <label class="years"></label></th>
            <th  style="text-align:center;vertical-align:middle;">COMP. MENSUAL <label class="years"></label></th>
            <th  style="text-align:center;vertical-align:middle;">DEVENGADO <label class="years"></label></th>
            <th  style="text-align:center;vertical-align:middle;">GIRADO <label class="years"></label></th>
            <th  style="text-align:center;vertical-align:middle;">AVANCE <label class="years"></label></th>
            <th  style="text-align:center;vertical-align:middle;">AVANCE FISICO</th>
          </tr>
        </thead>
        <tbody id="cuerpo">
        </tbody>
        <tr id="encabezado" style="background-color:#3c8dbc9c">
        </tr>
      </table>
      <span class="fecha_financiera" style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;"></span>
    </div>
  </div>
</div>
<div  class="col-md-12" style="margin-top: 20px;display: block;" id="areaImprimirproyecto" >
  <div class="row text-center">
    <h3 style="font-weight:bold">PROYECTOS DE INVERSIÓN PUBLICA DEL GOBIERNO REGIONAL DE LIMA</h3>
    <h4 style="font-weight:bold">AVANCE DE LA EJECUCIÓN FINANCIERA <label class="years"></label></h4>
  </div>
  <div class="row">
    <!-- <button class="btn btn-primary" onclick="exportTableToExcel('financiera', 'EJECUCIÓN FINANCIERA 2019')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button> -->
    <div class="table table-bordered table-responsive c_tb_proyecto" >  
      <div id="cargandoproyecto" class="loading" style="display: none;"></div>
      <table class="table table-bordered " id="financieraproyecto" width="100%" cellspacing="0" class="form-control">
        <thead>
          <tr>
            <th style="text-align:center;vertical-align:middle;">COD. UNIF.</th>
            <th style="text-align:center;vertical-align:middle;">PROYECTOS</th>
            <th style="text-align:center;vertical-align:middle;">VER</th>
            <th style="text-align:center;vertical-align:middle;" class="hide">TIPO</th>
            <th style="text-align:center;vertical-align:middle;" class="text-center">
              TIPO
              <select  name="tipo" class="form-control" id="tipo" style="width:120px">
                <option value="" selected>TODOS</option>
                <option value="PROYECTO" >PROYECTO</option>
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
              <select  name="uei" class="form-control" id="uei" style="width:140px">
                <option value="" selected>TODOS</option>
                <option value="ESTUDIOS DE PRE-INVERSION">PRE-INVERSION</option>
                <option value="GERENCIA REGIONAL DE INFRAESTRUCTURA">GRI</option>
                <option value="DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES">DRTC</option>
                <option value="GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE">GRRNGMA</option>
                <option value="GERENCIA REGIONAL DE DESARROLLO ECONOMICO">GRDE</option>
                <option value="GERENCIA REGIONAL DE DESARROLLO SOCIAL">GRDS</option>
                <option value="DIRECCION REGIONAL DE AGRICULTURA">DRA</option>
                <option value="GERENCIA SUB REGIONAL LIMA SUR">GSRLS</option>
              </select>
            </th>
            <th style="text-align:center;vertical-align:middle;">MONTO INV. ACT.</th>
            <th style="text-align:center;vertical-align:middle;">DEVEN. ACUM. ACT.</th>
            <th style="text-align:center;vertical-align:middle;">AVANCE ACUM. ACT.</th>
            <th style="text-align:center;vertical-align:middle;">SALDO POR EJECUTAR</th>
            <th style="text-align:center;vertical-align:middle;">PIA <label class="years"></label></th>
            <th style="text-align:center;vertical-align:middle;">PIM <label class="years"></label></th>
            <th style="text-align:center;vertical-align:middle;">CERTIF <label class="years"></label></th>
            <th style="text-align:center;vertical-align:middle;">COMP. ANUAL <label class="years"></label></th>
            <th style="text-align:center;vertical-align:middle;">COMP. MENSUAL <label class="years"></label></th>
            <th style="text-align:center;vertical-align:middle;">DEVENGADO <label class="years"></label></th>
            <th style="text-align:center;vertical-align:middle;" class="dev_mes">DEVENGADO MES <label class="mes"></label></th>
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
          </tr>
        </tfoot>
      </table>
      <span class="fecha_financiera" style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;"></span>
      </span>
    </div>
  </div>
</div>
<br>  
<div style="page-break-after: always"></div>
<div id="pry_ejecutados" style="display:none">
  <div  class="col-md-12" style="margin-top: 15px;">
    <div class="row text-center">
      <h3 style="font-weight:bold">AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION PUBLICA AÑO FISCAL {{ date("Y") }}</label></h3>
    </div>
    <div class="row">
      <button class="btn btn-primary" onclick="exportTableToExcel('tb_pry_ejecutados', 'EJECUCIÓN DE LA META MENSUAL')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button>
      <div class="table  table-responsive tb_pry_ejecutados">
        <table class="table table-bordered" style="width:100%;margin: 0px;" id="tb_pry_ejecutados">
          <thead style="background-color: rgb(255 255 255)">
            <tr>
              <th class="text-center" style="width:60px;vertical-align:middle;" rowspan="2">N° PRY</th>
              <th class="text-center" style="width:200px;vertical-align:middle;" rowspan="2">CATEGORIA</th>
              <th class="text-center" style="width:80px;vertical-align:middle;" rowspan="2">PIM {{ date("Y") }}</th>
              <th class="text-center" style="width:400px;vertical-align:middle;background-color: rgb(255 255 255);" colspan="4">EJECUCIÓN {{ date("Y") }}</th>
              <th class="text-center" style="width:200px;vertical-align:middle;" colspan="2">EJECUCIÓN <label class="mes"></b></th>
              <th class="text-center seleccion_dev hide" id="grl" style="width:400px;vertical-align:middle;" colspan="7">METAS ESTABLECIDOS POR EL GRL</th>
              <th class="text-center seleccion_apru hide" id="mef"  style="width:400px;vertical-align:middle;" colspan="7">METAS ESTABLECIDOS POR EL MEF</th>
              <!-- <th class="text-center" style="width:120px;vertical-align:middle;" rowspan="2">POR CERTIFICAR</th>-->
            </tr>
            <tr>
              <th class="text-center" style="width:100px;vertical-align:middle;">CERTIFICADO {{ date("Y") }}</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">COMPROMISO MENSUAL {{ date("Y") }}</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">DEVENGADO {{ date("Y") }}</th>
              <th class="text-center" style="width:50px;vertical-align:middle;background-color: rgb(255 255 255);">%</th>
              <th class="text-center subtotal_dev" style="width:130px;vertical-align:middle;">DEV ENE-<label class="mesabr"></th>
              <th class="text-center seleccion" style="width:130px;vertical-align:middle;">DEVENGADO</th>
              <!-- <th class="text-center hide" style="width:120px;vertical-align:middle;">INDICADOR</th>
              <th class="text-center mes_grl_8 hide" style="width:130px;vertical-align:middle;">AGO (S/)</th>
              <th class="text-center mes_grl_9 hide" style="width:130px;vertical-align:middle;">SEP (S/)</th>
              <th class="text-center mes_grl_10 hide" style="width:130px;vertical-align:middle;">OCT (S/)</th>
              <th class="text-center mes_grl_11 hide" style="width:130px;vertical-align:middle;">NOV (S/)</th>
              <th class="text-center mes_grl_12 hide" style="width:100px;vertical-align:middle;">DIC (S/)</th> -->
              <th class="text-center" style="width:120px;vertical-align:middle;">INDICADOR</th>
              <th class="text-center hide mes_1 seleccion_apru" style="width:130px;vertical-align:middle;">ENE (S/)</th>
              <th class="text-center hide mes_2" style="width:130px;vertical-align:middle;">FEB (S/)</th>
              <th class="text-center hide mes_3" style="width:130px;vertical-align:middle;">MAR (S/)</th>
              <th class="text-center hide mes_4" style="width:130px;vertical-align:middle;">ABR (S/)</th>
              <th class="text-center hide mes_5" style="width:130px;vertical-align:middle;">MAY (S/)</th>
              <th class="text-center hide mes_6" style="width:130px;vertical-align:middle;">JUN (S/)</th>
              <th class="text-center hide mes_7" style="width:130px;vertical-align:middle;">JUL (S/)</th>
              <th class="text-center hide mes_8" style="width:130px;vertical-align:middle;">AGO (S/)</th>
              <th class="text-center hide mes_9" style="width:130px;vertical-align:middle;">SEP (S/)</th>
              <th class="text-center hide mes_10" style="width:130px;vertical-align:middle;">OCT (S/)</th>
              <th class="text-center hide mes_11" style="width:130px;vertical-align:middle;">NOV (S/)</th>
              <th class="text-center hide mes_12" style="width:130px;vertical-align:middle;">DIC (S/)</th>
            </tr>
          </thead>
          <tbody id="cuerpo_tb_pry_ejecutados">
          </tbody>
          <tfoot>
            <tr id="pie_tb_pry_ejecutados" style="background-color:#3c8dbc9c">
            </tr>
          </tfoot>
        </table>
      </div>
      <div style="overflow: overlay;text-align:center">
        <!-- <img src="{{asset('/meta_t4.png')}}" class="img-fluid"> -->
      </div>
    </div>
  </div>
</div>
<br>
<div style="page-break-after: always"></div>
<div id="mensualisado">
  <div  class="col-md-12" style="margin-top: 15px;display: none;">
    <div class="row text-center">
      <h3 style="font-weight:bold">PROYECTOS DE INVERSIÓN PUBLICA DEL GOBIERNO REGIONAL DE LIMA</h3>
      <!-- <h4 style="font-weight:bold">EJECUCIÓN DE LA META MENSUAL AL MES DE <b id="met_men"></b> DEL <label class="years"></label> </h4> -->
    </div>
    <div class="row">
      <button class="btn btn-primary" onclick="exportTableToExcel('financiera_mes', 'EJECUCIÓN DE LA META MENSUAL')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button>
      <div class="table table-bordered table-responsive" >
        <table class="table" style="width:100%;table-layout:fixed" id="financiera_mes">
          <thead>
            <tr>
              <th class="text-center" style="width:50px;">N° PY</th>
              <th class="text-center" style="width:500px;">CATEGORIA</th>
              <th class="text-center" style="width:100px;">TOTAL (S/)</th>
              <th class="text-center" style="width:150px;text-align:center;">INDICADOR</th>
              <th class="text-center" style="width:100px;">ENE (S/)</th>
              <th class="text-center" style="width:100px;">FEB (S/)</th>
              <th class="text-center" style="width:100px;">MAR (S/)</th>
              <th class="text-center" style="width:100px;">ABR (S/)</th>
              <th class="text-center" style="width:100px;">MAY (S/)</th>
              <th class="text-center" style="width:100px;">JUN (S/)</th>
              <th class="text-center" style="width:100px;">JUL (S/)</th>
              <th class="text-center" style="width:100px;">AGO (S/)</th>
              <th class="text-center" style="width:100px;">SEP (S/)</th>
              <th class="text-center" style="width:100px;">OCT (S/)</th>
              <th class="text-center" style="width:100px;">NOV (S/)</th>
              <th class="text-center" style="width:100px;">DIC (S/)</th>
            </tr>
          </thead>
          <tbody id="cuerpo_mes">
          </tbody>
          <tfoot>
            <tr id="encabezado_mes" style="background-color:#3c8dbc9c">
            </tr>
          </tfoot>
        </table>
        <span class="ssi" style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;"></span>
      </div>
    </div>
  </div>
</div>
  <div id="grafica">
    <div class="form-group row">
      <label for="cboselect" class="col-sm-2 col-form-label" style="text-align:right;">Mostrar:</label>
      <div class="col-sm-4">
        <form id = "frmFinancParams">
          <select class="form-control" name="cboselect" id="cboselect" style="width:100%">
          </select>
          <input type="hidden" name="gambito" id="gambito">
          <input type="hidden" name="ganio" id="ganio">
        </form>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-primary" onclick="getFinanc()">Graficar</button>
      </div>
    </div>
    <br><br>
    <div class="row">
      <div style="width:100%;height:320px ;text-align:center" id="fe">
        <div id="cargando_grafico" class="loading" style="position:relative;"></div>
        <div id = "Financechart"></div>
      </div>
      <div class="row text-center">
        <button class="btn btn-primary" onclick="printDiv('fe')"><i class="fa fa-file-excel-o"> Imprimir Grafico</i></button>
      </div>
    </div>
    <br>
    <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Elaborado: Área de seguimiento, monitoreo y tecnologia de la información - GRPPAT
    </span>
  </div>

<!-- PROYECTOS FORMATO 12-B -->
<div style="page-break-after: always"></div>
<div id="pry_ejecutados_f12" style="display:none">
  <div  class="col-md-12" style="margin-top: 15px;">
    <div class="row text-center">
      <h3 style="font-weight:bold">PROYECTOS DE INVERSION PUBLICA 2020, QUE ACTUALIZAN FORMATO 12-B </h3>
      <h4 style="font-weight:bold">(CONTROL DE CALIDAD) AL ULTIMO PERIODO MES DE AGOSTO  DEL <label class="years"></label> </h4>
    </div>
    <div class="row">
      <button class="btn btn-primary" onclick="exportTableToExcel('tb_pry_ejecutados_f12', 'EJECUCIÓN DE LA META MENSUAL')"><i class="fa fa-file-excel-o"> Exportar Excel</i></button>
      <div class="table  table-responsive tb_pry_ejecutados_f12">
        <table class="table table-bordered" style="width:100%;table-layout:fixed;margin: 0px;" id="tb_pry_ejecutados_f12">
          <thead>
            <tr>
              <th class="text-center" style="width:200px;vertical-align:middle;">UEI</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">PIM <label class="years"></th>
              <th class="text-center" style="width:100px;vertical-align:middle;">DEV. <label class="years"></th>
              <th class="text-center" style="width:100px;vertical-align:middle;">AVANCE <label class="years"></th>
              <th class="text-center" style="width:100px;vertical-align:middle;">TOTAL PRY</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">F12-B REG.</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">F12-B NO REG.</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">F12-B ACT.</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">F12-B NO ACT.</th>
              <th class="text-center" style="width:130px;vertical-align:middle;">FASE</th>
              <th class="text-center" style="width:100px;vertical-align:middle;">TOTAL (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">ENE (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">FEB (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">MAR (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">ABR (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">MAY (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">JUN (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">JUL (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">AGO (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">SEP (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;background-color: #a2c779;">OCT (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">NOV (S/)</th>
              <th colspan="2" class="text-center" style="width:120px;vertical-align:middle;">DIC (S/)</th>
            </tr>
          </thead>
          <tbody id="cuerpo_tb_pry_ejecutados_f12">
          </tbody>
          <tfoot>
            <tr id="pie_tb_pry_ejecutados_f12" style="background-color:#3c8dbc9c">
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- <div class="text-center">
  <button class="btn btn-primary" onclick="imprimir()">IMPRIMIR</button>
</div> -->

<script  src="https://demos.codexworld.com/print-specific-area-of-web-page-using-jquery/jquery.PrintArea.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<!-- <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script> -->

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
<script src="{{asset('plugins/table_freeze/freeze-table.min.js')}}"></script>

<script>
  $(function(){

      var anio = (new Date).getFullYear();

      years = function () {
        $(".years").text($("#anio :selected").val());
        if($("#anio :selected").val() == 2015 || $("#anio :selected").val() == 2016 || $("#anio :selected").val() == 2017  ){
          $("#grafica").hide();
        }else{
          $("#grafica").show();
        }

        if($("#anio :selected").val() < anio){
          $("#mensualisado").hide();
        }else{
          $("#mensualisado").show();
        }
        
      }

      years();

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
      
      $cant=0;
      tablefinanciera=function () {  
        // Asignando valor a input hidden e_anio y e_ambito
        $('#e_anio').val($("#anio :selected").val());
        $('#e_ambito').val($("#ambito :selected").val());
        if ($("#ambito :selected").val() == "PROYECTO") {
          // $("#pry_ejecutados").hide();
          $("#mensualisado").hide();
          $("#areaImprimirproyecto").show();
          $("#areaImprimir").hide();
          $.ajax({
              url: '{{ url("/proyecto/table_financiera") }}',
              method: 'POST',
              data: {ambito :$("#ambito :selected").val(),anio :$("#anio :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              beforeSend: function () {
                $("#cargandoproyecto").show();
              },
              success: function(response){
                $(".fecha_financiera").text("Fuente: Consulta amigable - MEF (Actualizado al " + response.fecha_financiera  + ")");
                $(".ssi").text("Fuente: SISTEMA DE SEGUIMIENTO DE INVERSIONES (SSI) - MEF (Actualizado al " + response.fecha_financiera  + ")");
                html_c = "";
                $.each(response.gob_reg,function(key,value){
                  html_c += "<tr>";
                  html_c += "<td style='text-align:center'><a style='cursor:pointer' data-toggle='tooltip' data-placement='bottom' title='Ir a SSI' target='_blank' href='http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo=" + value['cod_unif'] + "&tipo=2' class='dropdown-toggle'>"+ value['cod_unif'] +"</a></td>";
                  html_c += "<td style='text-align:justify;'>"+ value['nom_proyec']+"</td>";
                  html_c += "<td style='text-align:center'><a style='cursor:pointer' class='dropdown-toggle' onclick='detalleproyectos(\""+ value['id'] +"\",\""+ value['tipo_pry'] + "\")'><i class='fa fa-eye'></i></a></td>";
                  $tipo = "";

                  if (value['tipo_inversion'] == 'PIP') {
                    $tipo = "PROYECTO";
                  }
                  else if (value['tipo_inversion'] == 'IOARR') {
                    $tipo = "IOARR";
                  }
                  else if (value['tipo_inversion'] == 'IOARR - 7D EMERGENCIA NACIONAL') {
                    $tipo = "IOARR - 7D EMERGENCIA NACIONAL";
                  }
                  else if (value['tipo_inversion'] == 'PROCOMPITE') {
                    $tipo = "PROCOMPITE";
                  }
                  else if (value['tipo_inversion'] == 'RCC') {
                    $tipo = "RCC";
                  }
                  else {
                    $tipo = "OTROS";
                  }

                  $clasificacion=[];
                  if (value['pia']!= null) {
                    $clasificacion.push(value['pia']);
                  }
                  if (value['pmi']!= null) {
                    $clasificacion.push(value['pmi']);
                  }
                  if (value['pic']!= null) {
                    $clasificacion.push(value['pic']);
                  }
                  if (value['iniciativa']!= null) {
                    $clasificacion.push(value['iniciativa']);
                  
                  }
                  html_c += "<td class='hide' style='text-align:left'>"+ $tipo +"</td>";
                  html_c += "<td style='text-align:left'>"+ $tipo +"</td>";
                  html_c += "<td style='text-align:left'>"+ $clasificacion +"</td>";
                  html_c += "<td style='text-align:left'>"+ value['ger_direc'] +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value["m_pip"],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value["m_deveng_a"],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value["a_financ_a"],1) +"%</td>";
                  if (value["m_pip"] - value["m_deveng_a"] <= 0) {
                    html_c += "<td style='text-align:center'>"+ number_format(0,0) +"</td>";
                  }else{
                    html_c += "<td style='text-align:center'>"+ number_format(value["m_pip"] - value["m_deveng_a"],0) +"</td>";
                  }
                  html_c += "<td style='text-align:center'>"+ number_format(value['pia_dia'],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value['pim_dia'],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value['certificacion_dia'],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value['comp_anual_dia'],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value['ate_comp_anual_dia'],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value['dev_dia'],0) +"</td>";
                  html_c += "<td style='text-align:center' class='dev_mes'>"+ number_format(value['mes_dev'],0) +"</td>";
                  html_c += "<td style='text-align:center'>"+ number_format(value['girado_dia'],0) +"</td>";
                  if (number_format(value["pim_dia"],0) == 0) {
                    html_c += "<td style='text-align:center'>0%</td>";
                  }
                  else {
                    html_c += "<td style='text-align:center'>"+ round((value['dev_dia']/value['pim_dia'])*100,1) +"%</td>";
                  }
                  html_c += "<td style='text-align:center'>"+ number_format((value["a_fisico"]),2) +"%</td>";
                  html_c += "<td class='hide' style='text-align:left'>"+ value['nom_prov'] +"</td>";
                  html_c += "<td class='hide' style='text-align:left'>"+ value['ger_direc'] +"</td>";
                  html_c += "<td class='hide' style='text-align:center'>"+ value['etapa'] +"</td>";
                  // html_c += "<td class='hide' style='text-align:center'>"+ value['sub_etapa'] +"</td>";
                  if (value['sector'] !=null || value['sector'] !='') {
                    html_c += "<td class='hide' style='text-align:center'>"+ value['sector'] +"</td>";
                  }else {
                    html_c += "<td class='hide' style='text-align:center'></td>";
                  }
                  html_c += "<td class='hide' style='text-align:center'>"+ value['ult_est_situal'] +"</td>";
                  html_c += "<td class='hide' style='text-align:center'>"+ value['cierre'] +"</td>";
                  html_c += "<td class='hide' style='text-align:center'>"+ value['expediente_tecnico_registrado'] +"</td>";
                  html_c += "</tr>";
                });

                if($("#anio :selected").val() == anio){
                  $col_excel = [0,1,3,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27];
                }else{
                  $col_excel = [0,1,3,5,7,8,9,10,11,12,13,14,15,16,18,19,20,21,22,23,24,25,26,27];
                }

                if ($.fn.DataTable.isDataTable('#financieraproyecto')) {
                  $('#financieraproyecto').DataTable().destroy();
                }

                $("#anio").change(function(){
                  $("#uei").val("");
                  $("#clasificacion").val("");
                  $("#tipo").val("");
                });

                $("#cuerpoproyecto").html(html_c);
                var table = $('#financieraproyecto').DataTable({
                  processing: true,
                  dom: 'B<"clear">lfrtip',
                  buttons: {
                    orientation: 'landscape',
                    color:'#008d4c',
                    buttons: [{
                      extend: 'excelHtml5',
                      text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                      titleAttr: 'Excel',
                      autoFilter: false,
                      sheetName: "PROYECTOS",
                      title: 'TODOS LOS PROYECTOS',
                      exportOptions: {
                        columns: $col_excel
                      },
                    }]
                  },
                  scrollY:        "600px",
                  scrollX:        true,
                  scrollCollapse: true,
                  paging:         false,
                  autoWidth:      true,
                  columnDefs:
                  [	
                    {
                      width: "200px",
                      targets:1
                    },
                    {
                      width: "50px",
                      orderable: false,
                      targets:2
                    },
                    {
                      width: "50px",
                      orderable: false,
                      targets:3
                    },
                    {
                      width: "50px",
                      orderable: false,
                      targets:4
                    },
                    {
                      width: "50px",
                      orderable: false,
                      targets:5
                    },
                    {
                      width: "50px",
                      orderable: false,
                      targets:6
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
                  footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                      return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                          i : 0;
                    };

                    if($("#anio :selected").val() == anio){
                      cantidad_pry = end;
                      m_pip = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      m_deveng_a = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      saldo_total = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      pia_dia = api.column( 11, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      pim_dia = api.column( 12, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      certificacion_dia = api.column( 13, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      comp_anual_dia = api.column( 14, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      ate_comp_anual_dia = api.column( 15, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      dev_dia = api.column( 16, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      dev_dia_mes = api.column( 17, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      girado_dia = api.column( 18, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      a_fisico = api.column( 20, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b.split("%")[0])}, 0 );
                      
                      /*console.log(m_pip);
                      console.log(m_deveng_a);
                      console.log(number_format((m_deveng_a/m_pip)*100,1)+'%');*/
                      
                      $( api.column(0).footer() ).html(cantidad_pry);
                      $( api.column(7).footer() ).html(number_format(m_pip,0));
                      $( api.column(8).footer() ).html(number_format(m_deveng_a,0));
                      $( api.column(9).footer() ).html(number_format((m_deveng_a/m_pip)*100,1)+'%');
                      $( api.column(10).footer() ).html(number_format(saldo_total,0));
                      $( api.column(11).footer() ).html(number_format(pia_dia,0));
                      $( api.column(12).footer() ).html(number_format(pim_dia,0));
                      $( api.column(13).footer() ).html(number_format(certificacion_dia,0));
                      $( api.column(14).footer() ).html(number_format(comp_anual_dia,0));
                      $( api.column(15).footer() ).html(number_format(ate_comp_anual_dia,0));
                      $( api.column(16).footer()).html(number_format(dev_dia,0));
                      $( api.column(17).footer()).html(number_format(dev_dia_mes,0));
                      $( api.column(18).footer() ).html(number_format(girado_dia,0));
                      $( api.column(19).footer() ).html(number_format((dev_dia/pim_dia)*100,1)+'%');
                      $( api.column(20).footer() ).html(number_format((a_fisico/cantidad_pry),2)+'%');
                      $(".dev_mes").show();
                    }else{
                      cantidad_pry = end;
                      m_pip = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      m_deveng_a = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      saldo_total = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      pia_dia = api.column( 11, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      pim_dia = api.column( 12, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      certificacion_dia = api.column( 13, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      comp_anual_dia = api.column( 14, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      ate_comp_anual_dia = api.column( 15, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      dev_dia = api.column( 16, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      girado_dia = api.column( 18, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                      a_fisico = api.column( 20, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b.split("%")[0])}, 0 );

                      $( api.column(0).footer() ).html(cantidad_pry);
                      $( api.column(7).footer() ).html(number_format(m_pip,0));
                      $( api.column(8).footer() ).html(number_format(m_deveng_a,0));
                      $( api.column(9).footer() ).html(number_format((m_deveng_a/m_pip)*100,1)+'%');
                      $( api.column(10).footer() ).html(number_format(m_deveng_a,0));
                      $( api.column(11).footer() ).html(number_format(pia_dia,0));
                      $( api.column(12).footer() ).html(number_format(pim_dia,0));
                      $( api.column(13).footer() ).html(number_format(certificacion_dia,0));
                      $( api.column(14).footer() ).html(number_format(comp_anual_dia,0));
                      $( api.column(15).footer() ).html(number_format(ate_comp_anual_dia,0));
                      $( api.column(16).footer()).html(number_format(dev_dia,0));
                      $( api.column(18).footer() ).html(number_format(girado_dia,0));
                      $( api.column(19).footer() ).html(number_format((dev_dia/pim_dia)*100,1)+'%');
                      $( api.column(20).footer() ).html(number_format((a_fisico/cantidad_pry),2)+'%');
                      $(".dev_mes").hide();
                    }
                }
                });
              },
              complete: function(response) {                
                $("#cargandoproyecto").hide();
              }
          });

          $("#clasificacion").change(function() {
            $('#financieraproyecto').DataTable().column(4).search(
                  $('#clasificacion').val()
              ).draw();
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
        else {
          if ($("#ambito :selected").val() == "FUENTE") {
            $("#mensualisado").hide();
            $("#areaImprimirproyecto").hide();
            $("#areaImprimir").show();
          }else{
            // $("#mensualisado").show();
            $("#areaImprimirproyecto").hide();
            $("#areaImprimir").show();
            $("#gambito").val($("#ambito :selected").val());
            $("#ganio").val($("#anio :selected").val());
          }
          m_pip=0;
          $.ajax({
              url: '{{ url("/proyecto/table_financiera") }}',
              method: 'POST',
              data: {ambito :$("#ambito :selected").val(),anio :$("#anio :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              beforeSend: function () {
                  $("#cargando").show();
              },
              success: function(response){
                $(".fecha_financiera").text("Fuente: Consulta amigable - MEF (Actualizado al " + response.fecha_financiera  + ")");
                $(".ssi").text("Fuente: SISTEMA DE SEGUIMIENTO DE INVERSIONES (SSI) - MEF (Actualizado al " + response.fecha_financiera  + ")");
                $headers=response.Headers;
                $pim=$headers.pim_dia;
                $cant=$headers.cant_proyectos;
                $avance=round(($headers.dev_dia/$pim)*100,1);
                html="";
                html += "<th>"+ $headers.cant_proyectos +"</th>";
                html += "<th style='text-align:center'>GOBIERNO REGIONAL DE LIMA</th>";
                html += "<th style='text-align:center'></th>";
                if ($headers.m_pip == 0) {
                  m_pip=(parseFloat($headers.m_deveng_a) - parseFloat($headers.dev_dia) + parseFloat($headers.pim_dia));
                  html += "<th style='text-align:center'>"+ number_format(m_pip,0) +"</th>";
                }
                else {
                  m_pip=$headers.m_pip;
                  html += "<th style='text-align:center'>"+ number_format(m_pip,0) +"</th>";
                }
                html += "<th style='text-align:center'>"+ number_format($headers.m_deveng_a,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format(($headers.m_deveng_a/m_pip)*100,1) +"%</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.pia_dia,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.pim_dia,0) +"</th>";
                // html += "<th style='text-align:center'>"+ 100 +"%</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.certificacion_dia,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.comp_anual_dia,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.ate_comp_anual_dia,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.dev_dia,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.girado_dia,0) +"</th>";
                if ($pim == 0) {
                  html += "<th style='text-align:center'>0,00%</th>";
                }
                else {
                  html += "<th style='text-align:center'>"+ round(($headers.dev_dia/$pim)*100,1) +"%</th>";
                }
                html += "<th style='text-align:center'>"+ number_format(($headers.a_fisico/$headers.cant_proyectos),1) +"%</th>";
                $("#encabezado").html(html);

                $valor=[];
                $avance_mes=[];
                $indicador=[];
                html_c = "";
                html_combo="";
                html_combo += "<option value=''>TODOS</option>";
                $date = new Date();
                $mes=$date.getMonth();
                $meses = [
                  "ENERO", "FEBRERO", "Marzo",
                  "ABRIL", "MAYO", "JUNIO", "JULIO",
                  "AGOSTO", "SEPTIEMBRE", "OCTUBRE",
                  "NOVIEMBRE", "DICIEMBRE"
                ]
                if ($("#anio :selected").val()==anio) {
                  $met_men=(100/12)*($mes+1);
                  $("#met_men").html($meses[$mes]+' '+round($met_men,1) + '%');
                }else{
                  $met_men=(100/12)*(12);
                  $("#met_men").html($meses[11]+' '+round($met_men,1) + '%');
                }
                $.each(response.gob_reg,function(key,value){
                    if ( value['orden'] == -1 || value['orden'] == 9 || value['orden'] == 10 || value['orden'] == 11 || value['orden'] == 12 ) {
                        html_c += "<tr style='background-color: darkgray;'>";
                        html_c += "<td>"+ value['cant_proyectos'] +"</td>";
                        html_c += "<td style='text-align:left'>"+ value['ger_direc']+"</td>";
                        html_c += "<td style='text-align:center'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModal(\""+ value['ger_direc'] +"\")'><i class='fa fa-eye'></i></a></td>";
                        if (number_format(value["m_pip"],0) == 0) {
                          m_pip=0;
                          html_c += "<td style='text-align:center'>"+ number_format(m_pip,0) +"</td>";
                        }
                        else {
                          m_pip=value["m_pip"];
                          html_c += "<td style='text-align:center'>"+ number_format(m_pip,0) +"</td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format(value["m_deveng_a"],0) +"</td>";
                        if (m_pip == 0) {
                            html_c += "<td style='text-align:center'>0.0%</td>";
                        }
                        else {
                            html_c += "<td style='text-align:center'>"+ number_format((value["m_deveng_a"]/ m_pip)*100,1) +"%</td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format(value['pia_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['pim_dia'],0) +"</td>";
                        // html_c += "<td style='text-align:center'>"+ round((value['pim_dia']/$pim)*100,1) +"%</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['certificacion_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['comp_anual_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['ate_comp_anual_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['dev_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['girado_dia'],0) +"</td>";
                        if (number_format(value["pim_dia"],0) == 0) {
                          html_c += "<td style='text-align:center'>0.0%</td>";
                        }
                        else {
                          html_c += "<td style='text-align:center'>"+ round((value['dev_dia']/value['pim_dia'])*100,1) +"%</td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format((value["a_fisico"]/value['cant_proyectos']),1) +"%</td>";
                        html_c += "</tr>";
                    }
                    else {
                        html_c += "<tr>";
                        html_c += "<td>"+ value['cant_proyectos'] +"</td>";
                        html_c += "<td style='text-align:left'>"+ value['ger_direc']+"</td>";
                        html_c += "<td style='text-align:center'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModal(\""+ value['ger_direc'] +"\")'><i class='fa fa-eye'></i></a></td>";
                        if (number_format(value["m_pip"],0) == 0) {
                          m_pip=0;
                          html_c += "<td style='text-align:center'>"+ number_format(m_pip,0) +"</td>";
                        }
                        else {
                          m_pip=value["m_pip"];
                          html_c += "<td style='text-align:center'>"+ number_format(m_pip,0) +"</td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format(value["m_deveng_a"],0) +"</td>";
                        if (m_pip == 0) {
                            html_c += "<td style='text-align:center'>0.0%</td>";
                        }
                        else {
                            html_c += "<td style='text-align:center'>"+ number_format((value["m_deveng_a"]/ m_pip)*100,1) +"%</td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format(value['pia_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['pim_dia'],0) +"</td>";
                        // html_c += "<td style='text-align:center'>"+ round((value['pim_dia']/$pim)*100,1) +"%</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['certificacion_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['comp_anual_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['ate_comp_anual_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['dev_dia'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['girado_dia'],0) +"</td>";
                        if (number_format(value["pim_dia"],0) == 0) {
                          html_c += "<td style='text-align:center'>0.0%</td>";
                        }
                        else {
                          html_c += "<td style='text-align:center'>"+ round((value['dev_dia']/value['pim_dia'])*100,1) +"%</td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format((value["a_fisico"]/ value['cant_proyectos']),1) +"%</td>";
                        html_c += "</tr>";
                    }
                    $valor.push(value['cant_proyectos']);
                    if (value['pim_dia'] == 0) {
                      $avance_mes.push(0);
                    }
                    else {
                      $avance_mes.push((value['dev_dia']/value['pim_dia'])*100);
                    }
                    html_combo += "<option value='"+(value['ger_direc'])+"'>"+value['ger_direc']+"</option>";

                });
                $("#cboselect").html(html_combo);
                $("#cuerpo").html(html_c);

              },
              complete: function(response) {
                $("#cargando").hide();
                $mes= 0;
                if($("#anio :selected").val() == anio && $("#ambito :selected").val() == "EJECUTORA"){
                  // $("#pry_ejecutados").show();
                  table_ejecucion_meta($mes);
                  // $mes_tri = $mes + 1;
                  // if($mes_tri>= 1 || $mes_tri < 4){
                  //   $(".mes_1").removeClass("hide");
                  //   $(".mes_2").removeClass("hide");
                  //   $(".mes_3").removeClass("hide");
                  // }
                  // else if($mes_tri>= 4 || $mes_tri < 7){
                  //   $(".mes_4").removeClass("hide");
                  //   $(".mes_5").removeClass("hide");
                  //   $(".mes_6").removeClass("hide");
                  // }
                  // else if($mes_tri>= 7 || $mes_tri < 10){
                  //   $(".mes_7").removeClass("hide");
                  //   $(".mes_8").removeClass("hide");
                  //   $(".mes_9").removeClass("hide");
                  // }
                  // else if($mes_tri>= 10){
                  //   $(".mes_10").removeClass("hide");
                  //   $(".mes_11").removeClass("hide");
                  //   $(".mes_12").removeClass("hide");
                  // }
                  
                }else{
                  // $("#pry_ejecutados").hide();
                }
                //ejecucion_pry();
                table_financiera_mes();
                getFinanc();
              }
          });
        }
      }

      table_financiera_mes=function(){
        $.ajax({
            url: '{{ url("/proyecto/table_mes_financiera") }}',
            method: 'POST',
            data: {ambito :$("#ambito :selected").val(),anio :$("#anio :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            beforeSend: function () {
                // $("#cargando").show();
            },
            success: function(response){
              $headers=response.Headers;
              if ($headers != null){
                $total=number_format((parseFloat($headers.enero) + parseFloat($headers.febrero) + parseFloat($headers.marzo) + parseFloat($headers.abril) + parseFloat($headers.mayo) + parseFloat($headers.junio) +
                        parseFloat($headers.julio) + parseFloat($headers.agosto) + parseFloat($headers.septiembre) + parseFloat($headers.octubre) + parseFloat($headers.noviembre) + parseFloat($headers.diciembre)),0);

                html="";
                html += "<th>"+ $cant +"</th>";
                html += "<th style='text-align:left;width:300px'>GOBIERNO REGIONAL DE LIMA</th>";
                html += "<th style='text-align:center'>"+ $total +"</th>";
                if (round(($avance-$met_men),1) >=0 ) {
                  html += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>"+ round(($avance-$met_men),1) +"%</b></td>";
                }
                else if (round(($avance-$met_men),1) <0 && round(($avance-$met_men),1) >=8.3 ) {
                  html += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>"+ round(($avance-$met_men),1) +"%</b></td>";
                }
                else {
                  html += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>"+ round(($avance-$met_men),1) +"%</b></td>";
                }
                html += "<th style='text-align:center'>"+ number_format($headers.enero,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.febrero,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.marzo,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.abril,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.mayo,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.junio,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.julio,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.agosto,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.septiembre,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.octubre,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.noviembre,0) +"</th>";
                html += "<th style='text-align:center'>"+ number_format($headers.diciembre,0) +"</th>";
                $("#encabezado_mes").html(html);
                $total_mes=0;
                html_c = "";
                $.each(response.gob_reg,function(key,value){
                    $total_mes=number_format((parseFloat(value['enero']) + parseFloat(value['febrero']) + parseFloat(value['marzo']) + parseFloat(value['abril']) + parseFloat(value['mayo']) + parseFloat(value['junio']) +
                                  parseFloat(value['julio']) + parseFloat(value['agosto']) + parseFloat(value['septiembre']) + parseFloat(value['octubre']) + parseFloat(value['noviembre']) + parseFloat(value['diciembre'])),0);

                    if ( value['orden'] == -1 || value['orden'] == 9 || value['orden'] == 10 || value['orden'] == 11 || value['orden'] == 12 ) {
                        html_c += "<tr style='background-color: darkgray;'>";
                        html_c += "<td>"+ $valor[key] +"</td>";
                        html_c += "<td style='text-align:left;width:300px'>"+ value['ger_direc'] +"</td>";
                        html_c += "<th style='text-align:center'>"+ $total_mes +"</th>";
                        if (round(($avance_mes[key]-$met_men),1) >=0 ) {
                          html_c += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>"+ round(($avance_mes[key]-$met_men),1) +"%</b></td>";
                        }
                        else if (round(($avance_mes[key]-$met_men),1) <0 && round(($avance_mes[key]-$met_men),1) >=8.3 ) {
                          html_c += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>"+ round(($avance_mes[key]-$met_men),1) +"%</b></td>";
                        }
                        else {
                          html_c += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>"+ round(($avance_mes[key]-$met_men),1) +"%</b></td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format(value['enero'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['febrero'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['marzo'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['abril'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['mayo'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['junio'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['julio'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['agosto'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['septiembre'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['octubre'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['noviembre'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['diciembre'],0) +"</td>";
                        html_c += "</tr>";
                    }
                    else {
                        html_c += "<tr>";
                        html_c += "<td>"+  $valor[key] +"</td>";
                        html_c += "<td style='text-align:left;width:300px'>"+ value['ger_direc'] +"</td>";
                        html_c += "<th style='text-align:center'>"+ $total_mes +"</th>";
                        if (round(($avance_mes[key]-$met_men),1) >=0 ) {
                          html_c += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>"+ round(($avance_mes[key]-$met_men),1) +"%</b></td>";
                        }
                        else if (round(($avance_mes[key]-$met_men),1) <0 && round(($avance_mes[key]-$met_men),1) >=8.3 ) {
                          html_c += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>"+ round(($avance_mes[key]-$met_men),1) +"%</b></td>";
                        }
                        else {
                          html_c += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>"+ round(($avance_mes[key]-$met_men),1) +"%</b></td>";
                        }
                        html_c += "<td style='text-align:center'>"+ number_format(value['enero'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['febrero'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['marzo'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['abril'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['mayo'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['junio'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['julio'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['agosto'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['septiembre'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['octubre'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['noviembre'],0) +"</td>";
                        html_c += "<td style='text-align:center'>"+ number_format(value['diciembre'],0) +"</td>";
                        html_c += "</tr>";
                    }
                });
                $("#cuerpo_mes").html(html_c);
              }
              else{
                $total=0;

                html="";
                html += "<th>"+ $cant +"</th>";
                html += "<th style='text-align:left;width:300px'>GOBIERNO REGIONAL DE LIMA</th>";
                html += "<th style='text-align:center'>"+ $total +"</th>";
                html += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>"+ 0 +"%</b></td>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                html += "<th style='text-align:center'>"+ 0 + "</th>";
                $("#encabezado_mes").html(html);
                $("#cuerpo_mes").html("");
              }
            },
            complete: function(response) {
              // $("#cargando").hide();
            }
        });
      }
      
      table_ejecucion_meta = function(m){
        $meses = m;
        $meses = [["ENERO","ENE"], ["FEBRERO","FEB"], ["MARZO","MAR"], ["ABRIL","ABR"], ["MAYO","MAY"], ["JUNIO","JUN"], ["JULIO","JUL"],["AGOSTO","AGO"], ["SEPTIEMBRE","SEP"], ["OCTUBRE","OCT"], ["NOVIEMBRE","NOV"], ["DICIEMBRE","DIC"]];
        //Cambiar Nombre de Columna
        $(".mes").text($meses[$mes][0]);
        if (m == 0 ){
          $(".mesabr").text($meses[0][1]);
        }else{
          $(".mesabr").text($meses[$mes-1][1]);
        }
        //Ajax
        $.ajax({
            url: '{{ url("/proyecto/ejecucionmeta") }}',
            method: 'POST',
            data:{mes : parseFloat($mes) + 4 },
            tryCount : 0,
            retryLimit : 3,
            beforeSend: function () {
              $("#cargando").show();
            },
            success: function(response){
              html="";
              html_pie="";
              $dev_suma_actual=0;
              $dev_mes=0;
              $dev_mes_meta=0;
              $dev_mes_meta_grl=0;
              $porcentaje = 0;
              $porcentaje_total = 0;
              $porcentaje_grl = 0;
              $porcentaje_grl_total = 0;
              //VARIABLES PARA TOTAL
              $t_cantidad = 0;
              $t_pim = 0;
              $t_certificado = 0;
              $t_devengado = 0;
              $t_compromiso_m = 0;
              $t_total_dev = 0;
              $t_dev_mes = 0;
              $t_mes_actual = 0;
              $t_mes_actual_grl = 0;
              $t_mes_meta = 0;
              $t_mes_meta_grl = 0;
              $t_por_cert = 0;
              $t_1 = 0;
              $t_1_grl = 0;
              $t_2 = 0;
              $t_2_grl = 0;
              $t_3 = 0;
              $t_3_grl = 0;
              $t_4 = 0;
              $t_4_grl = 0;
              $t_5 = 0;
              $t_5_grl = 0;
              $t_6 = 0;
              $t_6_grl = 0;
              $t_7 = 0;
              $t_7_grl = 0;
              $t_8 = 0;
              $t_8_grl = 0;
              $t_9 = 0;
              $t_9_grl = 0;
              $t_10 = 0;
              $t_10_grl = 0;
              $t_11 = 0;
              $t_11_grl = 0;
              $t_12 = 0;
              $t_12_grl = 0;
              $.each(response.data,function(key,value){
                switch($mes) {
                    case 0:
                        $dev_suma_actual = parseFloat(value['enero']);
                        $dev_mes_meta = parseFloat(value['m_enero']);
                        $dev_mes_meta_grl = parseFloat(value['grl_enero']);
                        $dev_mes = parseFloat(value['enero']);
                        break;
                    case 1:
                        $dev_suma_actual = parseFloat(value['enero']);
                        $dev_mes_meta = parseFloat(value['m_febrero']);
                        $dev_mes_meta_grl = parseFloat(value['grl_febrero']);
                        $dev_mes = parseFloat(value['febrero']);
                        break;
                    case 2:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']);
                        $dev_mes_meta = parseFloat(value['m_marzo']);
                        $dev_mes_meta_grl = parseFloat(value['grl_marzo']);
                        $dev_mes = parseFloat(value['marzo']);
                        break;
                    case 3:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']);
                        $dev_mes_meta = parseFloat(value['m_abril']);
                        $dev_mes_meta_grl = parseFloat(value['grl_abril']);
                        $dev_mes = parseFloat(value['abril']);
                        break;
                    case 4:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']);
                        $dev_mes_meta = parseFloat(value['m_mayo']);
                        $dev_mes_meta_grl = parseFloat(value['grl_mayo']);
                        $dev_mes = parseFloat(value['mayo']);
                        break;
                    case 5:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']);
                        $dev_mes_meta = parseFloat(value['m_junio']);
                        $dev_mes_meta_grl = parseFloat(value['grl_junio']);
                        $dev_mes = parseFloat(value['junio']);
                        break;
                    case 6:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']) + parseFloat(value['junio']);
                        $dev_mes_meta = parseFloat(value['m_julio']);
                        $dev_mes_meta_grl = parseFloat(value['grl_julio']);
                        $dev_mes = parseFloat(value['julio']);
                        break;
                    case 7:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']) + parseFloat(value['junio']) +	parseFloat(value['julio']);
                        $dev_mes_meta = parseFloat(value['m_agosto']);
                        $dev_mes_meta_grl = parseFloat(value['grl_agosto']);
                        $dev_mes = parseFloat(value['agosto']);
                        break;
                    case 8:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']) + parseFloat(value['junio']) +	parseFloat(value['julio']) +	parseFloat(value['agosto']);
                        $dev_mes_meta = parseFloat(value['m_setiembre']);
                        $dev_mes_meta_grl = parseFloat(value['grl_setiembre']);
                        $dev_mes = parseFloat(value['septiembre']);
                        break;
                    case 9:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']) + parseFloat(value['junio']) +	parseFloat(value['julio']) +	parseFloat(value['agosto']) +	parseFloat(value['septiembre']);
                        $dev_mes_meta = parseFloat(value['m_octubre']);
                        $dev_mes_meta_grl = parseFloat(value['grl_octubre']);
                        $dev_mes = parseFloat(value['octubre']);
                        break;
                    case 10:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']) + parseFloat(value['junio']) +	parseFloat(value['julio']) +	parseFloat(value['agosto']) +	parseFloat(value['septiembre']) +	parseFloat(value['octubre']);
                        $dev_mes_meta = parseFloat(value['m_noviembre']);
                        $dev_mes_meta_grl = parseFloat(value['grl_noviembre']);
                        $dev_mes = parseFloat(value['noviembre']);
                        break;
                    case 11:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']) + parseFloat(value['junio']) +	parseFloat(value['julio']) +	parseFloat(value['agosto']) +	parseFloat(value['septiembre']) +	parseFloat(value['octubre']) +	parseFloat(value['noviembre']);
                        $dev_mes_meta = parseFloat(value['m_diciembre']);
                        $dev_mes_meta_grl = parseFloat(value['grl_diciembre']);
                        $dev_mes = parseFloat(value['diciembre']);
                        break;
                    case 12:
                        $dev_suma_actual = parseFloat(value['enero']) +	parseFloat(value['febrero']) +	parseFloat(value['marzo']) +	parseFloat(value['abril']) +	parseFloat(value['mayo']) + parseFloat(value['junio']) +	parseFloat(value['julio']) +	parseFloat(value['agosto']) +	parseFloat(value['septiembre']) +	parseFloat(value['octubre']) +	parseFloat(value['noviembre']) +	parseFloat(value['diciembre']);
                        $dev_mes_meta = parseFloat(value['m_diciembre']);
                        $dev_mes_meta_grl = parseFloat(value['grl_diciembre']);
                        $dev_mes = parseFloat(value['diciembre']);
                        break;
                    default:
                        $dev_suma_actual = 0;
                        $dev_mes_meta = 0;
                        $dev_mes_meta_grl = 0;
                }

                $dev_suma_actual = Math.round($dev_suma_actual); //Cambiar cuanto se aregle la sincronizacion 2/
                // $dev_suma_actual = Math.round(parseFloat(value['dev_ant']));
                //Para comentar
                // $dev_mes = ((parseFloat(value['dev_dia']) - $dev_suma_actual) > 0 ? (parseFloat(value['dev_dia']) - $dev_suma_actual) : 0);
                $porcentaje = ($dev_mes/$dev_mes_meta)*100;
                $porcentaje_grl =  $dev_mes_meta_grl == 0 ? 0 : (($dev_mes)/$dev_mes_meta_grl)*100;
                html += "<tr>";
                   html += "<td class='text-center' style='vertical-align:middle;'>" + value['cantida'] +"</td>";
                   html += "<td class='text-left' style='vertical-align:middle;'>" + value['ger_direc'] +"</td>";
                   html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['pim_dia'],0) +"</td>";
                   html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['certificacion_dia'],0) +"</td>";
                   html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['ate_comp_anual_dia'],0) +"</td>";
                   html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['dev_dia'],0) +"</td>";
                   html += "<td class='text-center' style='vertical-align:middle;'>" + value['a_fisico'] +"%</td>";
                   html += "<td class='text-center subtotal_dev' style='vertical-align:middle;'>" +  number_format($dev_suma_actual,0) +"</td>";
                   html += "<td class='text-center seleccion' style='vertical-align:middle;'>" +  number_format($dev_mes,0) +"</td>";
                  //  //META POR GRL
                  //  if ($porcentaje_grl >=70) {
                  //   html += "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje_grl,1) + "%</b></td>"
                  //  }
                  //  else if ($porcentaje_grl >=40 && $porcentaje_grl <70) {
                  //   html += "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje_grl,1) + "%</b></td>"
                  //  }
                  //  else {
                  //   html += "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje_grl,1) + "%</b></td>"
                  //  }
                  //  html += "<td class='text-center mes_grl_8 hide' style='vertical-align:middle;'>" + number_format(value['grl_agosto'],0) +"</td>";
                  //  html += "<td class='text-center mes_grl_9 hide' style='vertical-align:middle;'>" + number_format(value['grl_setiembre'],0) +"</td>";
                  //  html += "<td class='text-center mes_grl_10 hide' style='vertical-align:middle;'>" + number_format(value['grl_octubre'],0) +"</td>";
                  //  html += "<td class='text-center mes_grl_11 hide' style='vertical-align:middle;'>" + number_format(value['grl_noviembre'],0) +"</td>";
                  //  html += "<td class='text-center mes_grl_12 hide' style='vertical-align:middle;'>" + number_format(value['grl_diciembre'],0) +"</td>";
                  //  //META POR EL MEF
                   if ($porcentaje >=70  ) {
                      html += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje,1) + "%</b></td>";
                  }
                  else if ($porcentaje >=40 && $porcentaje <70) {
                      html += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje,1) + "%</b></td>";
                  }else if ($dev_mes_meta == 0){
                      html += "<td class='text-center' style='vertical-align:middle;'>---</td>";
                  }
                  else {
                      html += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje,1) + "%</b></td>";
                  }
                  html += "<td class='text-center hide mes_1' style='vertical-align:middle;'>" + number_format(value['m_enero'],0) +"</td>";
                  html += "<td class='text-center hide mes_2' style='vertical-align:middle;'>" + number_format(value['m_febrero'],0) +"</td>";
                  html += "<td class='text-center hide mes_3' style='vertical-align:middle;'>" + number_format(value['m_marzo'],0) +"</td>";
                  html += "<td class='text-center hide mes_4' style='vertical-align:middle;'>" + number_format(value['m_abril'],0) +"</td>";
                  html += "<td class='text-center hide mes_5' style='vertical-align:middle;'>" + number_format(value['m_mayo'],0) +"</td>";
                  html += "<td class='text-center hide mes_6' style='vertical-align:middle;'>" + number_format(value['m_junio'],0) +"</td>";
                  html += "<td class='text-center hide mes_7' style='vertical-align:middle;'>" + number_format(value['m_julio'],0) +"</td>";
                  html += "<td class='text-center hide mes_8' style='vertical-align:middle;'>" + number_format(value['m_agosto'],0) +"</td>";
                  html += "<td class='text-center hide mes_9' style='vertical-align:middle;'>" + number_format(value['m_setiembre'],0) +"</td>";
                  html += "<td class='text-center hide mes_10' style='vertical-align:middle;'>" + number_format(value['m_octubre'],0) +"</td>";
                  html += "<td class='text-center hide mes_11' style='vertical-align:middle;'>" + number_format(value['m_noviembre'],0) +"</td>";
                  html += "<td class='text-center hide mes_12' style='vertical-align:middle;'>" + number_format(value['m_diciembre'],0) +"</td>";
                //  html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['por_certificar'],0) +"</td>";
                html += "</tr>";
                //Suma de Totales
                $t_cantidad += parseFloat(value['cantida']);
                $t_pim += parseFloat(value['pim_dia']);
                $t_certificado += parseFloat(value['certificacion_dia']);
                $t_devengado += parseFloat(value['dev_dia']);
                $t_compromiso_m += parseFloat(value['ate_comp_anual_dia']);
                $t_total_dev += $dev_suma_actual;
                $t_dev_mes += $dev_mes;
                $t_mes_actual += $dev_mes_meta;
                $t_mes_actual_grl += $dev_mes_meta_grl;
                $t_por_cert += parseFloat(value['por_certificar']);
                $t_1 += parseFloat(value['m_enero']);
                $t_1_grl += parseFloat(value['grl_enero']);
                $t_2 += parseFloat(value['m_febrero']);
                $t_2_grl += parseFloat(value['grl_febrero']);
                $t_3 += parseFloat(value['m_marzo']);
                $t_3_grl += parseFloat(value['grl_marzo']);
                $t_4 += parseFloat(value['m_abril']);
                $t_4_grl += parseFloat(value['grl_abril']);
                $t_5 += parseFloat(value['m_mayo']);
                $t_5_grl += parseFloat(value['grl_mayo']);
                $t_6 += parseFloat(value['m_junio']);
                $t_6_grl += parseFloat(value['grl_junio']);
                $t_7 += parseFloat(value['m_julio']);
                $t_7_grl += parseFloat(value['grl_julio']);
                $t_8 += parseFloat(value['m_agosto']);
                $t_8_grl += parseFloat(value['grl_agosto']);
                $t_9 += parseFloat(value['m_setiembre']);
                $t_9_grl += parseFloat(value['grl_setiembre']);
                $t_10 += parseFloat(value['m_octubre']);
                $t_10_grl += parseFloat(value['grl_octubre']);
                $t_11 += parseFloat(value['m_noviembre']);
                $t_11_grl += parseFloat(value['grl_noviembre']);
                $t_12 += parseFloat(value['m_diciembre']);
                $t_12_grl += parseFloat(value['grl_diciembre']);
              });

              $porcentaje_grl_total= $t_mes_actual_grl == 0 ? 0 : ($t_dev_mes/$t_mes_actual_grl)*100;
              $porcentaje_total= $t_mes_actual == 0 ? 0 : ($t_dev_mes/$t_mes_actual)*100;

              html_pie += "<th class='text-center' style='vertical-align:middle;'>" + $t_cantidad +"</th>";
              html_pie += "<th class='text-center' style='vertical-align:middle;'>TOTAL</th>";
              html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_pim,0) +"</th>";
              html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_certificado,0) +"</th>";
              html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_compromiso_m,0) +"</th>";
              html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_devengado,0) +"</th>";
              html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format(($t_devengado/$t_pim)*100,1) +"%</th>";
              html_pie += "<th class='text-center subtotal_dev ' style='vertical-align:middle;'>" + number_format($t_total_dev,0) +"</th>";
              html_pie += "<th class='text-center' style='font-weight:bold; vertical-align:middle;'>" + number_format($t_dev_mes,0) +"</th>";
              //META POR EL GRL
              // if ($porcentaje_grl_total >=70  ) {
              //   html_pie += "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje_grl_total,1) + "%</b></td>";
              // }
              // else if ($porcentaje_grl_total >=40 && $porcentaje_grl_total <70) {
              //   html_pie += "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje_grl_total,1) + "%</b></td>";
              // }
              // else {
              //   html_pie += "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje_grl_total,1) + "%</b></td>";
              // }
              // html_pie += "<th class='text-center mes_grl_8 hide' style='vertical-align:middle;'>" + number_format($t_1_grl,0) +"</th>";
              // html_pie += "<th class='text-center mes_grl_9 hide' style='vertical-align:middle;'>" + number_format($t_2_grl,0) +"</th>";
              // html_pie += "<th class='text-center mes_grl_10 hide' style='vertical-align:middle;'>" + number_format($t_3_grl,0) +"</th>";
              // html_pie += "<th class='text-center mes_grl_11 hide' style='vertical-align:middle;'>" + number_format($t_4_grl,0) +"</th>";
              // html_pie += "<th class='text-center mes_grl_12 hide' style='vertical-align:middle;'>" + number_format($t_5_grl,0) +"</th>";
              // //META POR EL MEF
              if ($porcentaje_total >=70  ) {
                html_pie += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje_total,1) + "%</b></td>";
              }
              else if ($porcentaje_total >=40 && $porcentaje_total <70) {
                html_pie += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje_total,1) + "%</b></td>";
              }
              else {
                html_pie += "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje_total,1) + "%</b></td>";
              }
              html_pie += "<th class='text-center hide mes_1' style='vertical-align:middle;'>" + number_format($t_1,0) +"</th>";
              html_pie += "<th class='text-center hide mes_2' style='vertical-align:middle;'>" + number_format($t_2,0) +"</th>";
              html_pie += "<th class='text-center hide mes_3' style='vertical-align:middle;'>" + number_format($t_3,0) +"</th>";
              html_pie += "<th class='text-center hide mes_4' style='vertical-align:middle;'>" + number_format($t_4,0) +"</th>";
              html_pie += "<th class='text-center hide mes_5' style='vertical-align:middle;'>" + number_format($t_5,0) +"</th>";
              html_pie += "<th class='text-center hide mes_6' style='vertical-align:middle;'>" + number_format($t_6,0) +"</th>";
              html_pie += "<th class='text-center hide mes_7' style='vertical-align:middle;'>" + number_format($t_7,0) +"</th>";
              html_pie += "<th class='text-center hide mes_8' style='vertical-align:middle;'>" + number_format($t_8,0) +"</th>";
              html_pie += "<th class='text-center hide mes_9' style='vertical-align:middle;'>" + number_format($t_9,0) +"</th>";
              html_pie += "<th class='text-center hide mes_10' style='vertical-align:middle;'>" + number_format($t_10,0) +"</th>";
              html_pie += "<th class='text-center hide mes_11' style='vertical-align:middle;'>" + number_format($t_11,0) +"</th>";
              html_pie += "<th class='text-center hide mes_12' style='vertical-align:middle;'>" + number_format($t_12,0) +"</th>";
              // html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_por_cert,0) +"</th>";
              
              $("#cuerpo_tb_pry_ejecutados").html(html);
              $("#pie_tb_pry_ejecutados").html(html_pie);
              
              if($mes == 0){
                  $(".subtotal_dev").hide();
                  
              }
            },
            complete: function(response) {
              for (var i=1; i<$mes+1; i++) {
                $(".mes_grl_" + i).hide();
                // $(".mes_" + i).hide();
              }

              // TRIMESTRES
              $mes_tri = $mes + 1;
              if($mes_tri>= 1 && $mes_tri < 4){
                $("#mef").removeClass("hide");
                $(".mes_1").removeClass("hide");
                $(".mes_2").removeClass("hide");
                $(".mes_3").removeClass("hide");
              }
              else if($mes_tri>= 4 && $mes_tri < 7){
                $("#mef").removeClass("hide");
                $(".mes_4").removeClass("hide");
                $(".mes_5").removeClass("hide");
                $(".mes_6").removeClass("hide");
              }
              else if($mes_tri>= 7 && $mes_tri < 10){
                $("#mef").removeClass("hide");
                $(".mes_7").removeClass("hide");
                $(".mes_8").removeClass("hide");
                $(".mes_9").removeClass("hide");
              }
              else if($mes_tri>= 10){
                $("#mef").removeClass("hide");
                $(".mes_10").removeClass("hide");
                $(".mes_11").removeClass("hide");
                $(".mes_12").removeClass("hide");
              }

              //AGREGANDO CLASE AL MES ACTUAL
              $(".mes_grl_" + ($mes + 1)).addClass("seleccion_dev");
              $(".mes_" + ($mes + 1)).addClass("seleccion_apru");
              $("#grl").attr('colspan',(12-($mes-1)));
              $("#mef").attr('colspan',(12-($mes-1)));
              $("#cargando").hide();
            }
        });
      }

      tablefinanciera();

      var MONTHS = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
      var chart;
      getFinanc =  function (){
            $.ajax({
                url: '{{ url("/proyecto/lineFinanciera") }}',
                method: "POST",
                data: $("#frmFinancParams").serialize(),
                beforeSend: function () {
                    $("#cargando_grafico").show();
                },
                success: function(response) {
                    var count = 0;
                    var devengado = $.map(response['devengado'], function(value, index) {
                        return [value];
                    });
                    devengado.unshift('Devengado');
                    count = 0;
                    var devengadoAcumulado = $.map(response['devengadoAcumulado'], function(value, index) {
                      return  [value];
                    });
                    devengadoAcumulado.unshift('Certificado');
                    var pim = $.map(response['pim'], function(value, index) {
                        return [value];
                    });
                    pim.unshift('PIM');
                    chart.load({
                      columns: [
                        devengado,
                        devengadoAcumulado,
                        pim
                      ]
                    });
                } ,
                complete: function(response) {
                  $("#cargando_grafico").hide();
                }// End Success
            });  // End Ajax
      }
      setTimeout(function(){
          chart = c3.generate({
                  bindto:"#Financechart",
                  data: {
                      columns: [
                      ],
                      labels: true,
                      labels: {
                        format: function (v, id, i, j) { return d3.format(",")(v).replace(/,/g, ','); }
                      }
                  },
                  axis: {
                      x: {
                          type: 'category',
                          categories: MONTHS
                      },
                      y: {
                          tick: {
                              format: function (x) {
                                    return 'S./ ' + d3.format(",")(x).replace(/,/g, ',');
                                }
                          },
                      }
                  },
                  point: {
                      show: true
                  },
                  zoom: {
                      enabled: true
                  },
                  grid: {
                      x: {
                          show: true
                      },
                      y: {
                          show: true
                      }
                  },
                  tooltip: {
                      format: {
                          value: function(value) {
                              return 'S./ ' + d3.format(",.2f")(value).replace(/,/g, ',');
                          }
                      }
                  }
          });
          getFinanc();
      },200);

      loadModal = function(filtro) {
        modaltype='full-width';
        $modal = $('#' + modaltype);
              $.ajax({
                  url: '{{ asset("/proyecto/show") }}',
                  type: 'POST',
                  data:{ambito :$("#ambito :selected").val(),filtro:filtro,anio:$("#anio :selected").val()},
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

      imprimir = function () {
        window.print();
        return false;
        // var mode = 'iframe'; //popup
        // var close = mode == "popup";
        // var options = { mode : mode, popClose : close};
        // $("#grf2").printArea( options );
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

      detalleproyectos=function (id,ger_direc)
      {
        window.open("/proyecto/abrirproyecto?id=" + id+"&tipopry="+ger_direc);
      }

      function ejecucion_pry(){
        $.ajax({
            url: '{{ url("/formato12b/data") }}',
            method: 'POST',
            contentType: "application/json",
            tryCount : 0,
            retryLimit : 3,
            beforeSend: function () {
              $("#cargando").show();
            },
            success: function(response){
              html="";
              $.each(response,function(key,value){
                if(value['ger_direc'] == "TOTAL"){
                  html +="<tr style='background-color: #91d68f;'>";
                    html += "<th class='text-center' style='vertical-align:middle;padding: 5px;'  rowspan='3'>" + value['ger_direc'] +"</th>";
                    html += "<th class='text-center' style='vertical-align:middle;'  rowspan='3'>" + number_format(value['pim'],0) + "</th>";
                    html += "<th class='text-center' style='vertical-align:middle;'  rowspan='3'>" + number_format(value['dev_dia'],0) + "</th>";
                    html += "<th class='text-center' style='vertical-align:middle;'  rowspan='3'>" + number_format(value['avance'],1) + " %</th>";
                    html += "<th class='text-center' style='vertical-align:middle;' rowspan='3'>" + (value['factibles'] <= 0 ?  '-' : value['factibles'])  +"</th>";
                    html += "<th class='text-center' style='vertical-align:middle;' rowspan='3'>" + (value['registrados'] <= 0 ?  '-' : value['registrados'])  +"</th>";
                    html += "<th class='text-center' style='vertical-align:middle;' rowspan='3'>0</th>";
                    html += "<th class='text-center' style='vertical-align:middle;' rowspan='3'>0</th>";
                    html += "<th class='text-center' style='vertical-align:middle;' rowspan='3'>0</th>";
                    html += "<th class='text-center' style='vertical-align:middle;'>PROGRAMACIÓN</th>";
                    html += "<th class='text-center' style='vertical-align:middle;'>0</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_enero'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_febrero'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_marzo'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_abril'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_mayo'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_junio'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_julio'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_agosto'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_setiembre'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_octubre'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_noviembre'],0) + "</th>";
                    html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_diciembre'],0) + "</th>";
                  html +="</tr>";
                  html +="<tr style='background-color: #91d68f;'>";
                    html += "<th class='text-center' style='vertical-align:middle;'>EJECUCIÓN REAL</th>";
                      html += "<th class='text-center' style='vertical-align:middle;'>0</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['enero'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['febrero'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['marzo'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['abril'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['mayo'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['junio'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['julio'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['agosto'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['septiembre'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['octubre'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['noviembre'],0) + "</th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['diciembre'],0) + "</th>";
                  html +="</tr>";
                  html +="<tr style='background-color: #91d68f;'>";
                      html += "<th class='text-center' style='vertical-align:middle;'>PORCENTAJE</th>";
                      html += "<th class='text-center' style='vertical-align:middle;'>0</th>";
                      //PORCENTAJE DE MESES
                      if((value['enero']/value['a_enero'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['enero']/value['a_enero'])*100,0) + " %</th>";
                      } else if ((value['enero']/value['a_enero'])*100 >=40 && (value['enero']/value['a_enero'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['enero']/value['a_enero'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['enero']/value['a_enero'])*100,0) + " %</th>";
                      }
                      if((value['febrero']/value['a_febrero'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['febrero']/value['a_febrero'])*100,0) + " %</th>";
                      } else if ((value['febrero']/value['a_febrero'])*100 >=40 && (value['febrero']/value['a_febrero'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['febrero']/value['a_febrero'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['febrero']/value['a_febrero'])*100,0) + " %</th>";
                      }
                      if((value['marzo']/value['a_marzo'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['marzo']/value['a_marzo'])*100,0) + " %</th>";
                      } else if ((value['marzo']/value['a_marzo'])*100 >=40 && (value['marzo']/value['a_marzo'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['marzo']/value['a_marzo'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['marzo']/value['a_marzo'])*100,0) + " %</th>";
                      }
                      if((value['abril']/value['a_abril'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['abril']/value['a_abril'])*100,0) + " %</th>";
                      } else if ((value['abril']/value['a_abril'])*100 >=40 && (value['abril']/value['a_abril'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['abril']/value['a_abril'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['abril']/value['a_abril'])*100,0) + " %</th>";
                      }
                      if((value['mayo']/value['a_mayo'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['mayo']/value['a_mayo'])*100,0) + " %</th>";
                      } else if ((value['mayo']/value['a_mayo'])*100 >=40 && (value['mayo']/value['a_mayo'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['mayo']/value['a_mayo'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['mayo']/value['a_mayo'])*100,0) + " %</th>";
                      }
                      if((value['junio']/value['a_junio'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['junio']/value['a_junio'])*100,0) + " %</th>";
                      } else if ((value['junio']/value['a_junio'])*100 >=40 && (value['junio']/value['a_junio'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['junio']/value['a_junio'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['junio']/value['a_junio'])*100,0) + " %</th>";
                      }
                      if((value['julio']/value['a_julio'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['julio']/value['a_julio'])*100,0) + " %</th>";
                      } else if ((value['julio']/value['a_julio'])*100 >=40 && (value['julio']/value['a_julio'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['julio']/value['a_julio'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['julio']/value['a_julio'])*100,0) + " %</th>";
                      }
                      if((value['agosto']/value['a_agosto'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['agosto']/value['a_agosto'])*100,0) + " %</th>";
                      } else if ((value['agosto']/value['a_agosto'])*100 >=40 && (value['agosto']/value['a_agosto'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['agosto']/value['a_agosto'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['agosto']/value['a_agosto'])*100,0) + " %</th>";
                      }
                      if((value['septiembre']/value['a_setiembre'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['septiembre']/value['a_setiembre'])*100,0) + " %</th>";
                      } else if ((value['septiembre']/value['a_setiembre'])*100 >=40 && (value['septiembre']/value['a_setiembre'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['septiembre']/value['a_setiembre'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['septiembre']/value['a_setiembre'])*100,0) + " %</th>";
                      }
                      if((value['octubre']/value['a_octubre'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['octubre']/value['a_octubre'])*100,0) + " %</th>";
                      } else if ((value['octubre']/value['a_octubre'])*100 >=40 && (value['octubre']/value['a_octubre'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['octubre']/value['a_octubre'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['octubre']/value['a_octubre'])*100,0) + " %</th>";
                      }
                      if((value['noviembre']/value['a_noviembre'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['noviembre']/value['a_noviembre'])*100,0) + " %</th>";
                      } else if ((value['noviembre']/value['a_noviembre'])*100 >=40 && (value['noviembre']/value['a_noviembre'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['noviembre']/value['a_noviembre'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['noviembre']/value['a_noviembre'])*100,0) + " %</th>";
                      }
                      if((value['diciembre']/value['a_diciembre'])*100 > 70){
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['diciembre']/value['a_diciembre'])*100,0) + " %</th>";
                      } else if ((value['diciembre']/value['a_diciembre'])*100 >=40 && (value['diciembre']/value['a_diciembre'])*100 <70) {
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['diciembre']/value['a_diciembre'])*100,0) + " %</th>";
                      }
                      else{
                        html += "<th class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></th>";
                        html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['diciembre']/value['a_diciembre'])*100,0) + " %</th>";
                      }
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'></th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'></th>";
                      html += "<th colspan='2' class='text-center' style='vertical-align:middle;'></th>";
                  html +="</tr>";
                }else{
                  html += "<tr>";
                      html += "<td class='text-center' style='vertical-align:middle;padding: 5px;'  rowspan='3'>" + value['ger_direc'] +"</td>";
                      html += "<td class='text-center' style='vertical-align:middle;'  rowspan='3'>" + number_format(value['pim'],0) + "</td>";
                      html += "<td class='text-center' style='vertical-align:middle;'  rowspan='3'>" + number_format(value['dev_dia'],0) + "</td>";
                      html += "<td class='text-center' style='vertical-align:middle;'  rowspan='3'>" + number_format(value['avance'],1) + " %</td>";
                      html += "<th class='text-center' style='vertical-align:middle;' rowspan='3'>" + (value['factibles'] <= 0 ?  '-' : value['factibles'])  +"</th>";
                      html += "<th class='text-center' style='vertical-align:middle;' rowspan='3'>" + (value['registrados'] <= 0 ?  '-' : value['registrados'])  +"</th>";
                      html += "<td class='text-center' style='vertical-align:middle;' rowspan='3'>0</td>";
                      html += "<td class='text-center' style='vertical-align:middle;' rowspan='3'>0</td>";
                      html += "<td class='text-center' style='vertical-align:middle;' rowspan='3'>0</td>";
                      html += "<th class='text-center' style='vertical-align:middle;'>PROGRAMACIÓN</th>";
                      html += "<td class='text-center' style='vertical-align:middle;'>0</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_enero'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_febrero'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_marzo'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_abril'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_mayo'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_junio'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_julio'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_agosto'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_setiembre'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_octubre'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_noviembre'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['a_diciembre'],0) + "</td>";
                  html +="</tr>";
                  html += "<tr>";
                      html += "<th class='text-center' style='vertical-align:middle;'>EJECUCIÓN REAL</th>";
                      html += "<td class='text-center' style='vertical-align:middle;'>0</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['enero'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['febrero'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['marzo'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['abril'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['mayo'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['junio'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['julio'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['agosto'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['septiembre'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['octubre'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['noviembre'],0) + "</td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'>" + number_format(value['diciembre'],0) + "</td>";
                  html +="</tr>";
                  html += "<tr>";
                      html += "<th class='text-center' style='vertical-align:middle;'>PORCENTAJE</th>";
                      html += "<td class='text-center' style='vertical-align:middle;'>0</td>";
                      //PORCENTAJE DE MESES
                        if((value['enero']/value['a_enero'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['enero']/value['a_enero'])*100,0) + " %</th>";
                        } else if ((value['enero']/value['a_enero'])*100 >=40 && (value['enero']/value['a_enero'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['enero']/value['a_enero'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['enero']/value['a_enero'])*100,0) + " %</th>";
                        }
                        if((value['febrero']/value['a_febrero'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['febrero']/value['a_febrero'])*100,0) + " %</th>";
                        } else if ((value['febrero']/value['a_febrero'])*100 >=40 && (value['febrero']/value['a_febrero'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['febrero']/value['a_febrero'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['febrero']/value['a_febrero'])*100,0) + " %</th>";
                        }
                        if((value['marzo']/value['a_marzo'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['marzo']/value['a_marzo'])*100,0) + " %</th>";
                        } else if ((value['marzo']/value['a_marzo'])*100 >=40 && (value['marzo']/value['a_marzo'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['marzo']/value['a_marzo'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['marzo']/value['a_marzo'])*100,0) + " %</th>";
                        }
                        if((value['abril']/value['a_abril'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['abril']/value['a_abril'])*100,0) + " %</th>";
                        } else if ((value['abril']/value['a_abril'])*100 >=40 && (value['abril']/value['a_abril'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['abril']/value['a_abril'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['abril']/value['a_abril'])*100,0) + " %</th>";
                        }
                        if((value['mayo']/value['a_mayo'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['mayo']/value['a_mayo'])*100,0) + " %</th>";
                        } else if ((value['mayo']/value['a_mayo'])*100 >=40 && (value['mayo']/value['a_mayo'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['mayo']/value['a_mayo'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['mayo']/value['a_mayo'])*100,0) + " %</th>";
                        }
                        if((value['junio']/value['a_junio'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['junio']/value['a_junio'])*100,0) + " %</th>";
                        } else if ((value['junio']/value['a_junio'])*100 >=40 && (value['junio']/value['a_junio'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['junio']/value['a_junio'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['junio']/value['a_junio'])*100,0) + " %</th>";
                        }
                        if((value['julio']/value['a_julio'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['julio']/value['a_julio'])*100,0) + " %</th>";
                        } else if ((value['julio']/value['a_julio'])*100 >=40 && (value['julio']/value['a_julio'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['julio']/value['a_julio'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['julio']/value['a_julio'])*100,0) + " %</th>";
                        }
                        if((value['agosto']/value['a_agosto'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['agosto']/value['a_agosto'])*100,0) + " %</th>";
                        } else if ((value['agosto']/value['a_agosto'])*100 >=40 && (value['agosto']/value['a_agosto'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['agosto']/value['a_agosto'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['agosto']/value['a_agosto'])*100,0) + " %</th>";
                        }
                        if((value['septiembre']/value['a_setiembre'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['septiembre']/value['a_setiembre'])*100,0) + " %</th>";
                        } else if ((value['septiembre']/value['a_setiembre'])*100 >=40 && (value['septiembre']/value['a_setiembre'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['septiembre']/value['a_setiembre'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['septiembre']/value['a_setiembre'])*100,0) + " %</th>";
                        }
                        if((value['octubre']/value['a_octubre'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['octubre']/value['a_octubre'])*100,0) + " %</th>";
                        } else if ((value['octubre']/value['a_octubre'])*100 >=40 && (value['octubre']/value['a_octubre'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['octubre']/value['a_octubre'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['octubre']/value['a_octubre'])*100,0) + " %</th>";
                        }
                        if((value['noviembre']/value['a_noviembre'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['noviembre']/value['a_noviembre'])*100,0) + " %</th>";
                        } else if ((value['noviembre']/value['a_noviembre'])*100 >=40 && (value['noviembre']/value['a_noviembre'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['noviembre']/value['a_noviembre'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['noviembre']/value['a_noviembre'])*100,0) + " %</th>";
                        }
                        if((value['diciembre']/value['a_diciembre'])*100 > 70){
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-green text-green'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['diciembre']/value['a_diciembre'])*100,0) + " %</th>";
                        } else if ((value['diciembre']/value['a_diciembre'])*100 >=40 && (value['diciembre']/value['a_diciembre'])*100 <70) {
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-yellow text-yellow'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['diciembre']/value['a_diciembre'])*100,0) + " %</th>";
                        }
                        else{
                          html += "<td class='text-right' style='width:8px;vertical-align:middle;border-right-style: hidden;'><span class='badge bg-red text-red'>2</span></td>";
                          html += "<th class='text-left' style='vertical-align:middle;'>" + number_format((value['diciembre']/value['a_diciembre'])*100,0) + " %</th>";
                        }
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'></td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'></td>";
                      html += "<td colspan='2' class='text-center' style='vertical-align:middle;'></td>";
                  html +="</tr>";
                }
              });
              $("#cuerpo_tb_pry_ejecutados_f12").html(html);
              $(".tb_pry_ejecutados_f12").freezeTable({
                'columnNum' : 11,
                'scrollBar': true,
                'shadow': true,
              });              
            },
            complete: function(response) {
              $("#cargando").hide();
            }
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
