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
@php
  $year= date("Y");
@endphp
<style type="text/css">
  .buttons-excel
  {
    background-image: none !important;
    background-color: #337ab7 !important;
    border-color: #2e6da4 !important;
    color: #fff !important;
  }

  .atajos{
      justify-content: center;
  }
  @media (min-width: 900px){
      .atajos{
          display: flex;
          justify-content: center;
      }
  }
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
      background-color: #bbd2a1;
      font-weight: bold;
  }

  .seleccion_apru{
      background-color: #9bc3d0; 
      font-weight: bold;
  }

  .seleccion_dev{
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
</style>
<div  class="col-md-12" style="margin-top: 20px;">
  <div class="well text-center">
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        REPORTE DEL REGISTRO DEL F12B (Inversiones con PIM {{$year}})
      </span>
  </div>
  <div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form action="{{asset('formato12b/exportar')}}">
        <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"> Exportar Excel</i></button>
      </form>
    </div>
    <div class="col-md-2"></div>
  </div>
  <br>
  <div id="cargando" class="loading" style="display:none"></div> 
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 connectedSortable ui-sortable">
        <div class="nav-tabs-custom" style="cursor: default;">
            <ul class="nav nav-tabs pull-right ui-sortable-handle">
                <li class="pull-left header">
                    <i class="fa fa-line-chart"></i>Estado del registro del Formato N° 12-B
                </li>
            </ul>
            <div class="tab-content">
                <div class="chart tab-pane active" style="position: relative;">
                    <div class="table  table-responsive">
                        <table class="table table-bordered" style="width:100%;margin: 0px;">
                          <thead style="background-color: #88b9d6">
                            <tr>
                              <th style="vertical-align: middle;" class="text-center">Total de inversiones (a+b)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones pendiente de registro del F12B (a)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro del F12B (b)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro del F12B NO actualizado (c)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro del F12B actualizado (b-c)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{ $registro_formato12b->no_registro + $registro_formato12b->registrados}}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_registro")'>{{ $registro_formato12b->no_registro }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{$registro_formato12b->registrados}}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_actualizado")'>{{ $registro_formato12b->no_actualizado }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{$registro_formato12b->actualizados}}</td>
                            </tr>
                          </tbody>
                        </table>
                        <li>
                        <span style="font-weight:bold;color:red">{{ $registro_formato12b->no_registro + $registro_formato12b->registrados}}</span> inversiones deben registrar el F12B, de los cuales <span style="font-weight:bold;color:red">{{ $registro_formato12b->no_registro }}</span>
                        no cuenta con registro del Formato y <span style="font-weight:bold;color:red">{{ $registro_formato12b->no_actualizado }}</span> no se encuentran actualizados a la fecha <span style="font-weight: bold;">[1]</span>.
                        </li>
                        <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                          Fuente: SIGPROA-PROYECTOS al {{ $registro_formato12b->fecha_subida}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 connectedSortable ui-sortable">
        <div class="nav-tabs-custom" style="cursor: default;">
            <ul class="nav nav-tabs pull-right ui-sortable-handle">
                <li class="pull-left header">
                    <i class="fa fa-line-chart"></i>Estado del registro de la situación general en el Formato N° 12-B
                </li>
            </ul>
            <div class="tab-content">
                <div class="chart tab-pane active" style="position: relative;">
                    <div class="table  table-responsive">
                        <table class="table table-bordered" style="width:100%;margin: 0px;">
                          <thead style="background-color: #88b9d6">
                            <tr>
                              <th style="vertical-align: middle;" class="text-center">Total de inversiones con registro del F12B (d+e)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones pendientes de registro de situación (d)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro de situación (e)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro de situación NO actualizado en el mes (f)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro de situación actualizado en el mes (e-f)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{ $registro_situacion_formato12b->no_reg_situacion + $registro_situacion_formato12b->reg_situacion}}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_reg_situacion")'>{{ $registro_situacion_formato12b->no_reg_situacion }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{$registro_situacion_formato12b->reg_situacion}}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_actual_situacion")'>{{ $registro_situacion_formato12b->no_actual_situacion }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{$registro_situacion_formato12b->actual_situacion}}</td>
                            </tr>
                          </tbody>
                        </table>
                        <li>
                        De las inversiones con registro en el F12B, <span style="font-weight:bold;color:red">{{ $registro_situacion_formato12b->no_reg_situacion}}</span> inversiones no cuentan con registro de la situación y 
                        <span style="font-weight:bold;color:red">{{ $registro_situacion_formato12b->no_actual_situacion}}</span> no se encuentran actualizados a la fecha.
                        </li>
                        <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                          Fuente: SIGPROA-PROYECTOS al {{ $registro_situacion_formato12b->fecha_subida}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 connectedSortable ui-sortable">
        <div class="nav-tabs-custom" style="cursor: default;">
            <ul class="nav nav-tabs pull-right ui-sortable-handle">
                <li class="pull-left header">
                    <i class="fa fa-line-chart"></i>Estado del registro del Avance de ejecución de la inversión
                </li>
            </ul>
            <div class="tab-content">
                <div class="chart tab-pane active" style="position: relative;">
                    <div class="table  table-responsive">
                        <table class="table table-bordered" style="width:100%;margin: 0px;">
                          <thead style="background-color: #88b9d6">
                            <tr>
                              <th style="vertical-align: middle;" class="text-center">Total de inversiones factibles (d+e)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones pendientes de registro de avance de ejecución (d)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro de avance de ejecución (e)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro de avance de ejecución NO actualizado en el mes (f)</th>
                              <th style="vertical-align: middle;" class="text-center">N° inversiones con registro de avance de ejecución actualizado en el mes (e-f)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{ $registro_factible_formato12b->no_reg_ava_eje + $registro_factible_formato12b->reg_ava_eje }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_reg_ava_eje")'>{{ $registro_factible_formato12b->no_reg_ava_eje }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{$registro_factible_formato12b->reg_ava_eje}}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_act_ava_ejec")'>{{ $registro_factible_formato12b->no_act_ava_ejec }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{$registro_factible_formato12b->act_ava_ejec}}</td>
                            </tr>
                          </tbody>
                        </table>
                        <li>
                        <span style="font-weight:bold;color:red">{{ $registro_factible_formato12b->no_reg_ava_eje + $registro_factible_formato12b->reg_ava_eje }}</span> inversiones son factibles de registro del avance de ejecución de la inversión de los cuales 
                        <span style="font-weight:bold;color:red">{{ $registro_factible_formato12b->no_reg_ava_eje}}</span> se encuentran pendiente de registro y <span style="font-weight:bold;color:red">{{ $registro_factible_formato12b->no_act_ava_ejec}}</span> no se encuentran actualizados <span style="font-weight: bold;">[2]</span>.
                        </li>
                        <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                          Fuente: SIGPROA-PROYECTOS al {{ $registro_factible_formato12b->fecha_subida}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 connectedSortable ui-sortable">
        <div class="nav-tabs-custom" style="cursor: default;">
            <ul class="nav nav-tabs pull-right ui-sortable-handle">
                <li class="pull-left header">
                    <i class="fa fa-line-chart"></i>¿EXISTE DIFERENCIA MAYOR AL 60% ENTRE EL AVANCE FINANCIERO ACUMULADO Y EL AVANCE DE EJECUCIÓN DE LA INVERSIÓN?
                </li>
            </ul>
            <div class="tab-content">
                <div class="chart tab-pane active" style="position: relative;">
                    <div class="table  table-responsive">
                        <table class="table table-bordered" style="width:100%;margin: 0px;">
                          <thead style="background-color: #88b9d6">
                            <tr>
                              <th style="vertical-align: middle;" class="text-center">Total de inversiones factibles (d+e+f)</th>
                              <th style="vertical-align: middle;" class="text-center">Mayor al 60 % (d)</th>
                              <th style="vertical-align: middle;" class="text-center">Menores a 60 % (e)</th>
                              <th style="vertical-align: middle;" class="text-center">No Aplica (f)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{ $dif_a_fin_a_afis->no_dif_a_fin_a_afis + $dif_a_fin_a_afis->dif_a_fin_a_afis + $dif_a_fin_a_afis->no_aplica }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("dif_a_fin_a_afis")'>{{ $dif_a_fin_a_afis->dif_a_fin_a_afis }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_dif_a_fin_a_afis")'>{{ $dif_a_fin_a_afis->no_dif_a_fin_a_afis }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModal("no_aplica")'>{{ $dif_a_fin_a_afis->no_aplica }}</td>
                            </tr>
                          </tbody>
                        </table>
                        <li>
                        <span style="font-weight:bold;color:red">{{ $dif_a_fin_a_afis->no_dif_a_fin_a_afis + $dif_a_fin_a_afis->dif_a_fin_a_afis + $dif_a_fin_a_afis->no_aplica }}</span> inversiones son factibles de registro del avance de ejecución de la inversión de los cuales 
                        <span style="font-weight:bold;color:red">{{ $dif_a_fin_a_afis->dif_a_fin_a_afis}}</span> mayores al 60%, <span style="font-weight:bold;color:red">{{ $dif_a_fin_a_afis->no_dif_a_fin_a_afis}}</span> menores a 60% y <span style="font-weight:bold;color:red">{{ $dif_a_fin_a_afis->no_aplica}}</span> no aplican por ser menores del 10% de avance acumulado.
                        </li>
                        <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                          Fuente: SIGPROA-PROYECTOS al {{ $dif_a_fin_a_afis->fecha_subida}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 connectedSortable ui-sortable">
        <div class="nav-tabs-custom" style="cursor: default;">
            <ul class="nav nav-tabs pull-right ui-sortable-handle">
                <li class="pull-left header">
                    <i class="fa fa-line-chart"></i>EXPEDIENTE TECNICO / DOCUMENTO EQUIVALENTE ACTUALIZADOS
                </li>
            </ul>
            <div class="tab-content">
                <div class="chart tab-pane active" style="position: relative;">
                    <div class="table  table-responsive">
                        <table class="table table-bordered" style="width:100%;margin: 0px;">
                          <thead style="background-color: #88b9d6">
                          <tr>
                            <th colspan="3" class="text-center">ELABORACIÓN DEL ET - APROBACIÓN DEL ET</th>
                            <th colspan="3" class="text-center">ELABORACIÓN DE ET - APROBACIÓN</th>
                          </tr>
                            <tr>
                              <th style="vertical-align: middle;" class="text-center">TOTAL</th>
                              <th style="vertical-align: middle;" class="text-center">ACTUALIZADOS</th>
                              <th style="vertical-align: middle;" class="text-center">NO ACTUALIZADOS</th>
                              <th style="vertical-align: middle;" class="text-center">TOTAL</th>
                              <th style="vertical-align: middle;" class="text-center">ACTUALIZADOS</th>
                              <th style="vertical-align: middle;" class="text-center">NO ACTUALIZADOS</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{ $et_nvo->cumplido + $et_nvo->no_cumplido }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModalET("nvo","si")'>{{ $et_nvo->cumplido }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModalET("nvo","no")'>{{ $et_nvo->no_cumplido }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold">{{ $et_ant->cumplido + $et_ant->no_cumplido }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModalET("ant","si")'>{{ $et_ant->cumplido }}</td>
                              <td class="text-center" style="font-size:18px;font-weight:bold;color:red"><a style='cursor:pointer;color:red' class='dropdown-toggle' onclick='loadModalET("ant","no")'>{{ $et_ant->no_cumplido }}</td>
                            </tr>
                          </tbody>
                        </table>
                        <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                          Fuente: SIGPROA-PROYECTOS al {{ $dif_a_fin_a_afis->fecha_subida}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="nav-tabs-custom" style="cursor: default;margin: 0px;">
        <div class="tab-content">
          <ul>
            <li><span style="font-weight: bold;">[1]</span> Total de inversiones activas, viables o aprobadas y con PIM 2022. No se considera las inversiones con registro del Formato de Cierre (F9), inversiones IRI, programas de inversión ni inversiones exoneradas por Decreto Supremo.
            </li>
            <li>
            <span style="font-weight: bold;">[2]</span> Para identificar a las inversiones factibles se ha tomado los siguientes parámetros: inversiones activas, viables o aprobadas, con PIM 2022 y que cuenten con avance financiero acumulado mayor igual al 10%. No se considera las inversiones con registro del Formato de Cierre (F9), inversiones IRI, programas de inversión ni inversiones exoneradas por Decreto Supremo.
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>

  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>

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
        
      loadModal = function(filtro) {
            modaltype='full-width';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/formato12b/showpry") }}',
                type: 'POST',
                data:{filtro:filtro},
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

      loadModalET = function(filtro,cond) {
            modaltype='full-width';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/formato12b/showpryET") }}',
                type: 'POST',
                data:{filtro:filtro,cond:cond},
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
