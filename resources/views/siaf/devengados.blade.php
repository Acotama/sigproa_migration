@extends('starter')
@section('htmlhead')

<link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">
<link href="{{ asset('switch/toggle-switchy.css')}}"  rel="stylesheet" type="text/css">

<!-- <link href="{{ asset('switch/docs/assets/css/custom.css')}}"  rel="stylesheet" type="text/css"> -->
    <style>
        .buttons-excel
        {
            background-image: none !important;
            background-color: #00a65a !important;
            border-color: #008d4c !important;
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
        /*FIN CARGANDO*/
    </style>
@endsection
@section('body')
    <div class="well text-center">
        <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION {{ date('Y') }} DEL GOBIERNO REGIONAL DE LIMA</span>
        <div style="margin-top:5px;text-align:center">
            <!-- <button type="button" class="btn btn-sm btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off" id="bonline">
                <div class="handle"></div>
            </button> -->
            <!-- <input type="checkbox" id="on-off-switch" name="switch1" checked> -->
            <label class="toggle-switchy" for="btn_online" data-size="" data-style="rounded">
                <input type="checkbox" id="btn_online">
                <span class="toggle">
                    <span class="switch"></span>	
                </span>
            </label>
            
        </div>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-2" style="margin-top:5px">
                <select  name="tipo" class="form-control" id="tipo"
                style="text-align:center">
                    <option value="uei" select>UEI</option>
                    <option value="proyectos">PROYECTOS</option>
                </select>
            </div>
            <div class="col-md-5"></div>
        </div>
    </div>
    <div id="cargando" class="loading" style="display: none;"></div> 
    <!-- UEI -->
    <div class="row" id="uei_offline">
        <section class="col-lg-12 connectedSortable ui-sortable">
            <div class="nav-tabs-custom" style="cursor: default;">
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header">
                        <i class="fa fa-line-chart"></i>AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION {{ date('Y') }} POR UEI
                    </li>
                    <li class="pull-right header">
                        <div class="row">
                            <div class="col-md-12">
                                <select  name="pliego_avance_uei" class="form-control" id="pliego_avance_uei"  onchange="filtro_uei()">
                                    <option value="1027" select>REGION LIMA</option>
                                    <option value="TODOS" select>TODOS</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li class="pull-right header">
                        <div class="row">
                            <div class="col-md-12">
                                <select  name="mes_avance_uei" class="form-control" id="mes_avance_uei"  onchange="filtro_uei()">
                                    <option value="1" select>ENE</option>
                                    <option value="2">FEB</option>
                                    <option value="3">MAR</option>
                                    <option value="4">ABR</option>
                                    <option value="5">MAY</option>
                                    <option value="6">JUN</option>
                                    <option value="7">JUL</option>
                                    <option value="8">AGO</option>
                                    <option value="9">SEP</option>
                                    <option value="10">OCT</option>
                                    <option value="11">NOV</option>
                                    <option value="12">DIC</option>
                                </select>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="chart tab-pane active" style="position: relative;">
                        <div class="table  table-responsive">
                            <table class="table table-bordered" style="width:100%;margin: 0px;" id="tb_pry_ejecutados_uei">
                                <thead style="background-color: rgba(146, 208, 80, 1)">
                                    <tr>
                                        <th class="text-center" style="width:60px;vertical-align:middle;"
                                            rowspan="2">N°.</th>
                                        <th class="text-center" style="width:500px;vertical-align:middle;" rowspan="2">UEI</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            rowspan="2">PIM {{ date('Y') }}</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            colspan="4">EJECUCIÓN {{ date('Y') }}</th>
                                        <th class="text-center subtotal_dev" style="width:130px;vertical-align:middle;"
                                            rowspan="2">DEV ENE<label class="mesabr"></th>
                                        <th class="text-center text-uppercase seleccion hidden"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th class="text-center text-uppercase seleccion"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th colspan="4" class="text-center"
                                            style="width:130px;vertical-align:middle;">META <label
                                                class="mes"></label> POR MEF</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">CERTIFICADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">COMPROMISO MENSUAL {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">DEVENGADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:50px;vertical-align:middle;">%</th>
                                        <th class="text-center" style="width:130px;vertical-align:middle;">INDICADOR</th>
                                        <!-- <th class="text-center seleccion" id="mes_9_apru"
                                            style="width:130px;vertical-align:middle;">S/ MONTO NO EJECUTADO</th>
                                        <th class="text-center seleccion"
                                            style="width:130px;vertical-align:middle;">S/ MONTO PROGRAMADO</th> -->
                                        <th class="text-center seleccion_apru" style="width:130px;vertical-align:middle;">S/ META</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpo_tb_pry_ejecutados_uei">
                                </tbody>
                                <tfoot>
                                    <tr id="pie_tb_pry_ejecutados_uei" style="background-color:#72ca70c7">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row col-md-12 no-print">
                            <p><b>Nota</b></p>
                            @if (Auth::user()->can('pir-proyectos-devengadoreal'))
                                {{-- <li>
                                Devengado diciembre SIAF actualizado al <span id="fechadevengado_uei" style="font-size: 13px;font-weight:bold;"></span>
                            </li> --}}
                            @endif
                            <li>
                                (+) Aumento del devengado
                            </li>
                            <li>
                                (-) Disminución del devengado
                            </li>
                            <br/>
                            <span class="fecha_ssi" style="font-weight: bold;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="row" id="uei_online" style="display: none;">
        <section class="col-lg-12 connectedSortable ui-sortable">
            <div class="nav-tabs-custom" style="cursor: default;">
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header">
                        <i class="fa fa-line-chart"></i>AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION {{ date('Y') }} POR UEI - SIAF
                    </li>
                    <li class="pull-right header">
                        <div class="row">
                            <div class="col-md-12">
                                <select  name="mes_avance_uei" class="form-control" id="mes_avance_uei_siaf"  onchange="filtro_mes_uei_siaf()">
                                    <option value="1" select>ENE</option>
                                    <option value="2">FEB</option>
                                    <option value="3">MAR</option>
                                    <option value="4">ABR</option>
                                    <option value="5">MAY</option>
                                    <option value="6">JUN</option>
                                    <option value="7">JUL</option>
                                    <option value="8">AGO</option>
                                    <option value="9">SEP</option>
                                    <option value="10">OCT</option>
                                    <option value="11">NOV</option>
                                    <option value="12">DIC</option>
                                </select>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="chart tab-pane active" style="position: relative;">
                        <div class="table  table-responsive">
                            <table class="table table-bordered" style="width:100%;margin: 0px;" id="tb_pry_ejecutados_uei_siaf">
                                <thead style="background-color: rgba(146, 208, 80, 1)">
                                    <tr>
                                        <th class="text-center" style="width:60px;vertical-align:middle;"
                                            rowspan="2">N°.</th>
                                        <th class="text-center" style="width:500px;vertical-align:middle;" rowspan="2">UEI</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            rowspan="2">PIM {{ date('Y') }}</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            colspan="4">EJECUCIÓN {{ date('Y') }}</th>
                                        <th class="text-center subtotal_dev" style="width:130px;vertical-align:middle;"
                                            rowspan="2">DEV ENE<label class="mesabr"></th>
                                        <th class="text-center text-uppercase seleccion hidden"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th class="text-center text-uppercase seleccion"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th colspan="4" class="text-center"
                                            style="width:130px;vertical-align:middle;">META <label
                                                class="mes"></label> POR MEF</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">CERTIFICADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">COMPROMISO MENSUAL {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">DEVENGADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:50px;vertical-align:middle;">%</th>
                                        <th class="text-center" style="width:130px;vertical-align:middle;">INDICADOR</th>
                                        <!-- <th class="text-center seleccion" id="mes_9_apru"
                                            style="width:130px;vertical-align:middle;">S/ MONTO NO EJECUTADO</th>
                                        <th class="text-center seleccion"
                                            style="width:130px;vertical-align:middle;">S/ MONTO PROGRAMADO</th> -->
                                        <th class="text-center seleccion_apru" style="width:130px;vertical-align:middle;">S/ META</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpo_tb_pry_ejecutados_uei_siaf">
                                </tbody>
                                <tfoot>
                                    <tr id="pie_tb_pry_ejecutados_uei_siaf" style="background-color:#72ca70c7">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row col-md-12 no-print">
                            <p><b>Nota</b></p>
                            @if (Auth::user()->can('pir-proyectos-devengadoreal'))
                                {{-- <li>
                                Devengado diciembre SIAF actualizado al <span id="fechadevengado_uei_siaf" style="font-size: 13px;font-weight:bold;"></span>
                            </li> --}}
                            @endif
                            <li>
                                (+) Aumento del devengado
                            </li>
                            <li>
                                (-) Disminución del devengado
                            </li>
                            <br/>
                            <span class="fecha_siaf" style="font-weight: bold;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- PROYECTOS -->
    <div class="row" id="pry_offline" style="display: none;">
        <section class="col-lg-12 connectedSortable ui-sortable">
            <div class="nav-tabs-custom" style="cursor: default;">
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header">
                        <i class="fa fa-line-chart"></i>AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION {{ date('Y') }}
                    </li>
                    <li class="pull-right header">
                        <div class="row">
                            <div class="col-md-12">
                                <select  name="pliego_avance" class="form-control" id="pliego_avance"  onchange="filtro()">
                                    <option value="1027" select>REGION LIMA</option>
                                    <option value="TODOS" select>TODOS</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li class="pull-right header">
                        <div class="row">
                            <div class="col-md-12">
                                <select  name="mes_avance" class="form-control" id="mes_avance"  onchange="filtro()">
                                    <option value="1" select>ENE</option>
                                    <option value="2">FEB</option>
                                    <option value="3">MAR</option>
                                    <option value="4">ABR</option>
                                    <option value="5">MAY</option>
                                    <option value="6">JUN</option>
                                    <option value="7">JUL</option>
                                    <option value="8">AGO</option>
                                    <option value="9">SEP</option>
                                    <option value="10">OCT</option>
                                    <option value="11">NOV</option>
                                    <option value="12">DIC</option>
                                </select>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="chart tab-pane active" style="position: relative;">
                        <div class="table  table-responsive">
                            <table class="table table-bordered" style="width:100%;margin: 0px;" id="tb_pry_ejecutados_proyecto">
                                <thead style="background-color: rgba(146, 208, 80, 1)">
                                    <tr>
                                        <th class="text-center" style="width:60px;vertical-align:middle;"
                                            rowspan="2">COD. UNIF.</th>
                                        <th class="text-center" style="width:500px;vertical-align:middle;" rowspan="2">NOMBRE PROYECTO</th>
                                        <th class="text-center hidden" style="width:500px;vertical-align:middle;" rowspan="2">UEI</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            rowspan="2">PIM {{ date('Y') }}</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            colspan="4">EJECUCIÓN {{ date('Y') }}</th>
                                        <th class="text-center subtotal_dev" style="width:130px;vertical-align:middle;"
                                            rowspan="2">DEV ENE<label class="mesabr"></th>
                                        <th class="text-center text-uppercase seleccion hidden"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th class="text-center text-uppercase seleccion"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th colspan="4" class="text-center"
                                            style="width:130px;vertical-align:middle;">META <label
                                                class="mes"></label> POR MEF</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">CERTIFICADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">COMPROMISO MENSUAL {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">DEVENGADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:50px;vertical-align:middle;">%</th>
                                        <th class="text-center" style="width:130px;vertical-align:middle;">INDICADOR</th>
                                        <!-- <th class="text-center seleccion" id="mes_9_apru"
                                            style="width:130px;vertical-align:middle;">S/ MONTO NO EJECUTADO</th>
                                        <th class="text-center seleccion"
                                            style="width:130px;vertical-align:middle;">S/ MONTO PROGRAMADO</th> -->
                                        <th class="text-center seleccion_apru" style="width:130px;vertical-align:middle;">S/ META</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpo_tb_pry_ejecutados_proyecto">
                                </tbody>
                                <tfoot>
                                    <tr id="pie_tb_pry_ejecutados_proyecto" style="background-color:#72ca70c7">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row col-md-12 no-print">
                            <p><b>Nota</b></p>
                            @if (Auth::user()->can('pir-proyectos-devengadoreal'))
                                {{-- <li>
                                Devengado diciembre SIAF actualizado al <span id="fechadevengado" style="font-size: 13px;font-weight:bold;"></span>
                            </li> --}}
                            @endif
                            <li>
                                (+) Aumento del devengado
                            </li>
                            <li>
                                (-) Disminución del devengado
                            </li>
                            <br/>
                            <span class="fecha_ssi" style="font-weight: bold;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="row" id="pry_online" style="display:none">
        <section class="col-lg-12 connectedSortable ui-sortable">
            <div class="nav-tabs-custom" style="cursor: default;">
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header">
                        <i class="fa fa-line-chart"></i>AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION {{ date('Y') }} - SIAF
                    </li>
                    <li class="pull-right header">
                        <div class="row">
                            <div class="col-md-12">
                                <select  name="mes_avance_siaf" class="form-control" id="mes_avance_siaf"  onchange="filtro_mes_pry_siaf()">
                                    <option value="1" select>ENE</option>
                                    <option value="2">FEB</option>
                                    <option value="3">MAR</option>
                                    <option value="4">ABR</option>
                                    <option value="5">MAY</option>
                                    <option value="6">JUN</option>
                                    <option value="7">JUL</option>
                                    <option value="8">AGO</option>
                                    <option value="9">SEP</option>
                                    <option value="10">OCT</option>
                                    <option value="11">NOV</option>
                                    <option value="12">DIC</option>
                                </select>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="chart tab-pane active" style="position: relative;">
                        <div class="table  table-responsive">
                            <table class="table table-bordered" style="width:100%;margin: 0px;" id="tb_pry_ejecutados_proyecto_siaf">
                                <thead style="background-color: rgba(146, 208, 80, 1)">
                                    <tr>
                                        <th class="text-center" style="width:60px;vertical-align:middle;"
                                            rowspan="2">COD. UNIF.</th>
                                        <th class="text-center" style="width:500px;vertical-align:middle;" rowspan="2">NOMBRE PROYECTO</th>
                                        <th class="text-center hidden" style="width:500px;vertical-align:middle;" rowspan="2">UEI</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            rowspan="2">PIM {{ date('Y') }}</th>
                                        <th class="text-center" style="width:80px;vertical-align:middle;"
                                            colspan="4">EJECUCIÓN {{ date('Y') }}</th>
                                        <th class="text-center subtotal_dev" style="width:130px;vertical-align:middle;"
                                            rowspan="2">DEV ENE<label class="mesabr"></th>
                                        <th class="text-center text-uppercase seleccion hidden"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th class="text-center text-uppercase seleccion"
                                            style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label
                                                class="mes"></th>
                                        <th colspan="4" class="text-center"
                                            style="width:130px;vertical-align:middle;">META <label
                                                class="mes"></label> POR MEF</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">CERTIFICADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">COMPROMISO MENSUAL {{ date('Y') }}</th>
                                        <th class="text-center" style="width:100px;vertical-align:middle;">DEVENGADO {{ date('Y') }}</th>
                                        <th class="text-center" style="width:50px;vertical-align:middle;">%</th>
                                        <th class="text-center" style="width:130px;vertical-align:middle;">INDICADOR</th>
                                        <!-- <th class="text-center seleccion" id="mes_9_apru"
                                            style="width:130px;vertical-align:middle;">S/ MONTO NO EJECUTADO</th>
                                        <th class="text-center seleccion"
                                            style="width:130px;vertical-align:middle;">S/ MONTO PROGRAMADO</th> -->
                                        <th class="text-center seleccion_apru" style="width:130px;vertical-align:middle;">S/ META</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpo_tb_pry_ejecutados_proyecto_siaf">
                                </tbody>
                                <tfoot>
                                    <tr id="pie_tb_pry_ejecutados_proyecto_siaf" style="background-color:#72ca70c7">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row col-md-12 no-print">
                            <p><b>Nota</b></p>
                            @if (Auth::user()->can('pir-proyectos-devengadoreal'))
                                {{-- <li>
                                Devengado diciembre SIAF actualizado al <span id="fechadevengado_siaf" style="font-size: 13px;font-weight:bold;"></span>
                            </li> --}}
                            @endif
                            <li>
                                (+) Aumento del devengado
                            </li>
                            <li>
                                (-) Disminución del devengado
                            </li>
                            <br/>
                            <span class="fecha_siaf" style="font-weight: bold;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div> 
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
<!-- <script src="switch/jquery.btnswitch.min.js"></script> -->

<script type="text/javascript">
    $(function(){
        // variables globales
        var $fecha = new Date();
        var $i = 0; //Para la funcion online
        //Offline UEI
        table_ejecucion_meta_uei = function(m,pliego) {
            m = parseInt(m);
            $mes_actual = $fecha.getMonth() +  1;
            $meses = [
                ["ENERO", "ENE"],
                ["FEBRERO", "FEB"],
                ["MARZO", "MAR"],
                ["ABRIL", "ABR"],
                ["MAYO", "MAY"],
                ["JUNIO", "JUN"],
                ["JULIO", "JUL"],
                ["AGOSTO", "AGO"],
                ["SEPTIEMBRE", "SEP"],
                ["OCTUBRE", "OCT"],
                ["NOVIEMBRE", "NOV"],
                ["DICIEMBRE", "DIC"]
            ];
            //Ajax
            $.ajax({
                url: "{{ url('/siaf/ejecucionmeta_uei') }}",
                method: 'POST',
                data: {
                    mes: m,pliego: pliego
                },
                tryCount: 0,
                retryLimit: 3,
                beforeSend: function() {
                    $("#cargando").show();
                },
                success: function(response) {
                    html = "";
                    html_pie = "";
                    $dev_suma_actual = 0;
                    $dev_mes = 0;
                    $dev_mes_meta = 0;
                    $dev_mes_meta_grl = 0;
                    $porcentaje = 0;
                    $porcentaje_total = 0;
                    $porcentaje_grl = 0;
                    $porcentaje_grl_total = 0;
                    $dif_real = 0;
                    //MODIFICADO
                    $por_modif = 0;
                    $monto_p_total = 0;
                    $monto_p = 0;
                    //VARIABLES PARA TOTAL
                    $t_cantidad = 0;
                    $t_pim = 0;
                    $t_pia = 0;
                    $t_certificado = 0;
                    $t_devengado = 0;
                    $t_compromiso_m = 0;
                    $t_total_dev = 0;
                    $t_total_dev_real = 0;
                    $t_dev_mes = 0;
                    $t_mes_actual = 0;
                    $t_mes_actual_grl = 0;
                    $t_mes_meta = 0;
                    $t_mes_meta_grl = 0;
                    $t_total_dif = 0;
                    $t_total_dif_real = 0;
                    //Actualizar Fecha
                    $.each(response.fecha, function(key, value) {
                        $(".fecha_ssi").text("Actualizado al " + value);
                    });
                    $.each(response.data, function(key, value) {
                        switch (m) {
                            case 1:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_enero']);
                                $dev_mes = parseFloat(value['enero']);
                                break;
                            case 2:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_febrero']);
                                $dev_mes = parseFloat(value['febrero']);
                                break;
                            case 3:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']);
                                $dev_mes_meta = parseFloat(value['m_marzo']);
                                $dev_mes = parseFloat(value['marzo']);
                                break;
                            case 4:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']);
                                $dev_mes_meta = parseFloat(value['m_abril']);
                                $dev_mes = parseFloat(value['abril']);
                                break;
                            case 5:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']);
                                $dev_mes_meta = parseFloat(value['m_mayo']);
                                $dev_mes = parseFloat(value['mayo']);
                                break;
                            case 6:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']);
                                $dev_mes_meta = parseFloat(value['m_junio']);
                                $dev_mes = parseFloat(value['junio']);
                                break;
                            case 7:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']);
                                $dev_mes_meta = parseFloat(value['m_julio']);
                                $dev_mes = parseFloat(value['julio']);
                                break;
                            case 8:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']);
                                $dev_mes_meta = parseFloat(value['m_agosto']);
                                $dev_mes = parseFloat(value['agosto']);
                                break;
                            case 9:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']);
                                $dev_mes_meta = parseFloat(value['m_setiembre']);
                                $dev_mes = parseFloat(value['septiembre']);
                                break;
                            case 10:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']);
                                $dev_mes_meta = parseFloat(value['m_octubre']);
                                $dev_mes = parseFloat(value['octubre']);
                                break;
                            case 11:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']);
                                $dev_mes_meta = parseFloat(value['m_noviembre']);
                                $dev_mes = parseFloat(value['noviembre']);
                                break;
                            case 12:
                                $dev_suma_actual = parseFloat(value['enero']) + 
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']) +
                                    parseFloat(value['noviembre']);
                                $dev_mes_meta = parseFloat(value['m_diciembre']);
                                $dev_mes = parseFloat(value['diciembre']);
                                break;
                            // case "12":
                            //     $dev_suma_actual = parseFloat(value['enero']) +
                            //         parseFloat(value['febrero']) + parseFloat(value[
                            //             'marzo']) + parseFloat(value['abril']) +
                            //         parseFloat(value['mayo']) + parseFloat(value[
                            //             'junio']) + parseFloat(value['julio']) +
                            //         parseFloat(value['agosto']) + parseFloat(value[
                            //             'septiembre']) + parseFloat(value['octubre']) +
                            //         parseFloat(value['noviembre']) + parseFloat(value[
                            //             'diciembre']);
                            //     $dev_mes_meta = parseFloat(value['m_diciembre']);
                            //     $dev_mes = parseFloat(value['diciembre']);
                            //     break;
                            default:
                                $dev_suma_actual = 0;
                                $dev_mes_meta = 0;
                                break;
                        }
                        $dev_suma_actual = Math.round($dev_suma_actual); //Cambiar cuanto se aregle la sincronizacion 
                        // $dev_suma_actual = Math.round(parseFloat(value['dev_ant']));
                        // console.log($dev_mes);
                        // Para comentar 
                        // $dev_mes = ((parseFloat(value['dev_dia']) - $dev_suma_actual) > 0 ? (parseFloat(value['dev_dia']) - $dev_suma_actual) : 0);
                        $porcentaje = (($dev_mes) / $dev_mes_meta) * 100;
                        $porcentaje_grl = (($dev_mes) / $dev_mes_meta_grl) * 100;
                        $dif_real = parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']) - $dev_mes;
                        html += "<tr>";
                        html += "<td class='text-center' style='vertical-align:middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModalUEI(\"" + value['ger_direc'] + "\")'>" + value['n_proy'] + "</td>";
                        html += "<td class='text-left'>" +  value['ger_direc'] + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['pim_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['certificacion_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['ate_comp_anual_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['dev_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + value['a_fisico'] + "%</td>";
                        
                        html += "<td class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($dev_suma_actual, 0) + "</td>";
                        // DEVENGADO EXCEL
                        html += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        //DEVENGADO
                        if (parseFloat(value['dif_dev_dia']) > 0 && m == $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format(parseFloat(value['dif_dev_dia']), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else if (parseFloat(value['dif_dev_dia']) < 0 && m ==  $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs(parseFloat(value['dif_dev_dia'])), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        }

                        //cambiar en caso la diferencias son erroneas
                        //html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes,0) + "</td>";

                        //META POR MEF
                        if ($porcentaje >= 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($porcentaje >= 40 && $porcentaje < 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($dev_mes_meta == 0) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>---</td>";
                        } else {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        }
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format($dev_mes_meta, 0) + "</td>";
                        //Suma de Totales
                        
                        $t_cantidad += parseFloat(value['n_proy']);
                        $t_pim += parseFloat(value['pim_dia']);
                        $t_certificado += parseFloat(value['certificacion_dia']);
                        $t_devengado += parseFloat(value['dev_dia']);
                        $t_compromiso_m += parseFloat(value['ate_comp_anual_dia']);
                        $t_total_dev += $dev_suma_actual;
                        $t_dev_mes += ($dev_mes);
                        $t_total_dev_real += parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']);
                        $t_mes_actual += $dev_mes_meta;
                        $t_mes_meta += parseFloat($dev_mes_meta);
                        $t_total_dif += parseFloat(value['dif_dev_dia']);
                        $t_total_dif_real += $dif_real;
                    });


                    $porcentaje_grl_total = $t_mes_actual_grl == 0 ? 0 : ($t_dev_mes / $t_mes_actual_grl) * 100;
                    // console.log($t_mes_actual);
                    // console.log($t_dev_mes)
                    $porcentaje_total = $t_mes_actual == 0 ? 0 : ($t_dev_mes / $t_mes_actual) *
                        100;
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + $t_cantidad + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>TOTAL</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_pim, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_certificado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_compromiso_m, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_devengado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format(($t_devengado / $t_pim) * 100, 1) + "%</th>";
                    html_pie += "<th class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($t_total_dev, 0) + "</th>";
                    //TOTAL DEVENGADO EXCEL
                    html_pie += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    //TOTAL DEVENGADO
                    if ($t_total_dif > 0 && m == $mes_actual ) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format($t_total_dif, 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else if ($t_total_dif < 0 && m == $mes_actual) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs($t_total_dif), 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    }

                    // TOTAL META POR MEF
                    //cambiar en caso la diferencias son erroneas
                    //html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes,0) + "</td>";
                    if ($porcentaje_total >= 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else if ($porcentaje_total >= 40 && $porcentaje_total < 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    }
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_mes_meta, 0) + "</th>";
                    // html_pie +=
                    //     "<th class='text-center' style='vertical-align:middle;'>6,959,130</th>";
                    // html_pie +=
                    //     "<th class='text-center seleccion_apru' style='vertical-align:middle;'>19,772,782</th>";
                
                    // Eliminar Tabla si existe
                },
                complete: function(response) {
                    // resize();
                    $("#cargando").hide();
                    if ($.fn.DataTable.isDataTable('#tb_pry_ejecutados_uei') ) {
                        $('#tb_pry_ejecutados_uei').DataTable().destroy();
                    }
                    $("#cuerpo_tb_pry_ejecutados_uei").html(html);
                    $("#pie_tb_pry_ejecutados_uei").html(html_pie);
                    $(".mes").text($meses[m-1][0]);
                    if (m == 1) {
                        // $(".mesabr").text("-" + $meses[0][1]);
                        $(".subtotal_dev").hide();
                    } else if (m == 2) {
                        $(".mesabr").text("");
                        $(".subtotal_dev").show();
                    } else {
                        $(".mesabr").text("-" + $meses[m - 2][1]); //POR EL ARRAY Q EMPIEZA EN 0
                        $(".subtotal_dev").show();
                    }
                    var table = $('#tb_pry_ejecutados_uei').DataTable({
                        // processing: true,
                        dom: 'B<"clear">lfrtip',
                        buttons: {
                            orientation: 'landscape',
                            color:'#008d4c',
                            buttons: [{
                                extend: 'excelHtml5',
                                text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                                titleAttr: 'Excel',
                                autoFilter: false,
                                sheetName: "AVANCE DE LA EJECUCION DE LOS PROYECTOS POR UEI ",
                                title: 'AVANCE DE LA EJECUCION DE LOS PROYECTOS POR UEI',
                                exportOptions: {
                                columns:[0,1,2,3,4,5,6,7,8,10,11]
                                },
                            }]
                        },
                        pageLength : 5,
                        // processing: true,
                        paginate: false,
                        lengthChange: true,
                        filter: true,
                        sort: true,
                        info: true,
                        autoWidth: true,
                        // responsive:true,
                        order:false,
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
                    });
                }
            });
        }
         //Online UEI
         table_ejecucion_meta_uei_siaf = function(m,pliego) {
            m = parseInt(m);
            $mes_actual = $fecha.getMonth() +  1;
            $meses = [
                ["ENERO", "ENE"],
                ["FEBRERO", "FEB"],
                ["MARZO", "MAR"],
                ["ABRIL", "ABR"],
                ["MAYO", "MAY"],
                ["JUNIO", "JUN"],
                ["JULIO", "JUL"],
                ["AGOSTO", "AGO"],
                ["SEPTIEMBRE", "SEP"],
                ["OCTUBRE", "OCT"],
                ["NOVIEMBRE", "NOV"],
                ["DICIEMBRE", "DIC"]
            ];
            //Ajax
            $.ajax({
                url: "{{ url('/siaf/ejecucionmeta_uei_siaf') }}",
                method: 'POST',
                data: {
                    mes: m,pliego: pliego
                },
                tryCount: 0,
                retryLimit: 3,
                beforeSend: function() {
                    $("#cargando").show();
                },
                success: function(response) {
                    html = "";
                    html_pie = "";
                    $dev_suma_actual = 0;
                    $dev_mes = 0;
                    $dev_mes_meta = 0;
                    $dev_mes_meta_grl = 0;
                    $porcentaje = 0;
                    $porcentaje_total = 0;
                    $porcentaje_grl = 0;
                    $porcentaje_grl_total = 0;
                    $dif_real = 0;
                    //MODIFICADO
                    $por_modif = 0;
                    $monto_p_total = 0;
                    $monto_p = 0;
                    //VARIABLES PARA TOTAL
                    $t_cantidad = 0;
                    $t_pim = 0;
                    $t_pia = 0;
                    $t_certificado = 0;
                    $t_devengado = 0;
                    $t_compromiso_m = 0;
                    $t_total_dev = 0;
                    $t_total_dev_real = 0;
                    $t_dev_mes = 0;
                    $t_mes_actual = 0;
                    $t_mes_actual_grl = 0;
                    $t_mes_meta = 0;
                    $t_mes_meta_grl = 0;
                    $t_total_dif = 0;
                    $t_total_dif_real = 0;
                    //Actualizar Fecha
                    $(".fecha_siaf").text("Actualizado al " + response.fecha);
                    
                    $.each(response.data, function(key, value) {
                        switch (m) {
                            case 1:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_enero']);
                                $dev_mes = parseFloat(value['enero']);
                                break;
                            case 2:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_febrero']);
                                $dev_mes = parseFloat(value['febrero']);
                                break;
                            case 3:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']);
                                $dev_mes_meta = parseFloat(value['m_marzo']);
                                $dev_mes = parseFloat(value['marzo']);
                                break;
                            case 4:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']);
                                $dev_mes_meta = parseFloat(value['m_abril']);
                                $dev_mes = parseFloat(value['abril']);
                                break;
                            case 5:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']);
                                $dev_mes_meta = parseFloat(value['m_mayo']);
                                $dev_mes = parseFloat(value['mayo']);
                                break;
                            case 6:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']);
                                $dev_mes_meta = parseFloat(value['m_junio']);
                                $dev_mes = parseFloat(value['junio']);
                                break;
                            case 7:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']);
                                $dev_mes_meta = parseFloat(value['m_julio']);
                                $dev_mes = parseFloat(value['julio']);
                                break;
                            case 8:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']);
                                $dev_mes_meta = parseFloat(value['m_agosto']);
                                $dev_mes = parseFloat(value['agosto']);
                                break;
                            case 9:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']);
                                $dev_mes_meta = parseFloat(value['m_setiembre']);
                                $dev_mes = parseFloat(value['septiembre']);
                                break;
                            case 10:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']);
                                $dev_mes_meta = parseFloat(value['m_octubre']);
                                $dev_mes = parseFloat(value['octubre']);
                                break;
                            case 11:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']);
                                $dev_mes_meta = parseFloat(value['m_noviembre']);
                                $dev_mes = parseFloat(value['noviembre']);
                                break;
                            case 12:
                                $dev_suma_actual = parseFloat(value['enero']) + 
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']) +
                                    parseFloat(value['noviembre']);
                                $dev_mes_meta = parseFloat(value['m_diciembre']);
                                $dev_mes = parseFloat(value['diciembre']);
                                break;
                            // case "12":
                            //     $dev_suma_actual = parseFloat(value['enero']) +
                            //         parseFloat(value['febrero']) + parseFloat(value[
                            //             'marzo']) + parseFloat(value['abril']) +
                            //         parseFloat(value['mayo']) + parseFloat(value[
                            //             'junio']) + parseFloat(value['julio']) +
                            //         parseFloat(value['agosto']) + parseFloat(value[
                            //             'septiembre']) + parseFloat(value['octubre']) +
                            //         parseFloat(value['noviembre']) + parseFloat(value[
                            //             'diciembre']);
                            //     $dev_mes_meta = parseFloat(value['m_diciembre']);
                            //     $dev_mes = parseFloat(value['diciembre']);
                            //     break;
                            default:
                                $dev_suma_actual = 0;
                                $dev_mes_meta = 0;
                                break;
                        }
                        $dev_suma_actual = Math.round($dev_suma_actual); //Cambiar cuanto se aregle la sincronizacion 
                        // $dev_suma_actual = Math.round(parseFloat(value['dev_ant']));
                        // console.log($dev_mes);
                        // Para comentar 
                        // $dev_mes = ((parseFloat(value['dev_dia']) - $dev_suma_actual) > 0 ? (parseFloat(value['dev_dia']) - $dev_suma_actual) : 0);
                        $porcentaje = (($dev_mes) / $dev_mes_meta) * 100;
                        $porcentaje_grl = (($dev_mes) / $dev_mes_meta_grl) * 100;
                        $dif_real = parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']) - $dev_mes;
                        html += "<tr>";
                        html += "<td class='text-center' style='vertical-align:middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModalUEI(\"" + value['ger_direc'] + "\")'>" + value['n_proy'] + "</td>";
                        html += "<td class='text-left'>" +  value['ger_direc'] + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['pim_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['certificacion_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['ate_comp_anual_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['dev_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + value['a_fisico'] + "%</td>";
                        
                        html += "<td class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($dev_suma_actual, 0) + "</td>";
                        html += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        //DEVENGADO
                        if (parseFloat(value['dif_dev_dia']) > 0 && m == $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format(parseFloat(value['dif_dev_dia']), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else if (parseFloat(value['dif_dev_dia']) < 0 && m ==  $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs(parseFloat(value['dif_dev_dia'])), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        }

                        //cambiar en caso la diferencias son erroneas
                        //html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes,0) + "</td>";

                        //META POR MEF
                        if ($porcentaje >= 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($porcentaje >= 40 && $porcentaje < 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($dev_mes_meta == 0) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>---</td>";
                        } else {
                            html +="<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        }
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format($dev_mes_meta, 0) + "</td>";
                        //Suma de Totales
                        
                        $t_cantidad += parseFloat(value['n_proy']);
                        $t_pim += parseFloat(value['pim_dia']);
                        $t_certificado += parseFloat(value['certificacion_dia']);
                        $t_devengado += parseFloat(value['dev_dia']);
                        $t_compromiso_m += parseFloat(value['ate_comp_anual_dia']);
                        $t_total_dev += $dev_suma_actual;
                        $t_dev_mes += ($dev_mes);
                        $t_total_dev_real += parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']);
                        $t_mes_actual += $dev_mes_meta;
                        $t_mes_meta += parseFloat($dev_mes_meta);
                        $t_total_dif += parseFloat(value['dif_dev_dia']);
                        $t_total_dif_real += $dif_real;
                    });


                    $porcentaje_grl_total = $t_mes_actual_grl == 0 ? 0 : ($t_dev_mes / $t_mes_actual_grl) * 100;
                    // console.log($t_mes_actual);
                    // console.log($t_dev_mes)
                    $porcentaje_total = $t_mes_actual == 0 ? 0 : ($t_dev_mes / $t_mes_actual) *
                        100;
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + $t_cantidad + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>TOTAL</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_pim, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_certificado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_compromiso_m, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_devengado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format(($t_devengado / $t_pim) * 100, 1) + "%</th>";
                    html_pie += "<th class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($t_total_dev, 0) + "</th>";
                    html_pie += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    //TOTAL DEVENGADO
                    if ($t_total_dif > 0 && m == $mes_actual ) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format($t_total_dif, 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else if ($t_total_dif < 0 && m == $mes_actual) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs($t_total_dif), 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    }

                    // TOTAL META POR MEF
                    //cambiar en caso la diferencias son erroneas
                    //html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes,0) + "</td>";
                    if ($porcentaje_total >= 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else if ($porcentaje_total >= 40 && $porcentaje_total < 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    }
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_mes_meta, 0) + "</th>";
                    // html_pie +=
                    //     "<th class='text-center' style='vertical-align:middle;'>6,959,130</th>";
                    // html_pie +=
                    //     "<th class='text-center seleccion_apru' style='vertical-align:middle;'>19,772,782</th>";
                
                    // Eliminar Tabla si existe
                },
                complete: function(response) {
                    // resize();
                    $("#cargando").hide();
                    if ($.fn.DataTable.isDataTable('#tb_pry_ejecutados_uei_siaf') ) {
                        $('#tb_pry_ejecutados_uei_siaf').DataTable().destroy();
                    }
                    $("#cuerpo_tb_pry_ejecutados_uei_siaf").html(html);
                    $("#pie_tb_pry_ejecutados_uei_siaf").html(html_pie);
                    $(".mes").text($meses[m-1][0]);
                    if (m == 1) {
                        // $(".mesabr").text("-" + $meses[0][1]);
                        $(".subtotal_dev").hide();
                    } else if (m == 2) {
                        $(".mesabr").text("");
                        $(".subtotal_dev").show();
                    } else {
                        $(".mesabr").text("-" + $meses[m - 2][1]); //POR EL ARRAY Q EMPIEZA EN 0
                        $(".subtotal_dev").show();
                    }
                    var table = $('#tb_pry_ejecutados_uei_siaf').DataTable({
                        // processing: true,
                        dom: 'B<"clear">lfrtip',
                        buttons: {
                            orientation: 'landscape',
                            color:'#008d4c',
                            buttons: [{
                                extend: 'excelHtml5',
                                text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                                titleAttr: 'Excel',
                                autoFilter: false,
                                sheetName: "AVANCE DE LA EJECUCION DE LOS PROYECTOS POR UEI - SIAF ",
                                title: 'AVANCE DE LA EJECUCION DE LOS PROYECTOS POR UEI - SIAF',
                                exportOptions: {
                                columns:[0,1,2,3,4,5,6,7,8,10,11]
                                },
                            }]
                        },
                        pageLength : 5,
                        // processing: true,
                        paginate: false,
                        lengthChange: true,
                        filter: true,
                        sort: true,
                        info: true,
                        autoWidth: true,
                        // responsive:true,
                        order:false,
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
                    });
                }
            });
        }
        //Offline Proyectos
        table_ejecucion_meta_pry = function(m,pliego) {
            m = parseInt(m);
            $mes_actual = $fecha.getMonth() +  1;
            $meses = [
                ["ENERO", "ENE"],
                ["FEBRERO", "FEB"],
                ["MARZO", "MAR"],
                ["ABRIL", "ABR"],
                ["MAYO", "MAY"],
                ["JUNIO", "JUN"],
                ["JULIO", "JUL"],
                ["AGOSTO", "AGO"],
                ["SEPTIEMBRE", "SEP"],
                ["OCTUBRE", "OCT"],
                ["NOVIEMBRE", "NOV"],
                ["DICIEMBRE", "DIC"]
            ];
            //Ajax
            $.ajax({
                url: "{{ url('/siaf/ejecucionmeta_proyecto') }}",
                method: 'POST',
                data: {
                    mes: m,pliego: pliego
                },
                tryCount: 0,
                retryLimit: 3,
                beforeSend: function() {
                    $("#cargando").show();
                },
                success: function(response) {
                    html = "";
                    html_pie = "";
                    $dev_suma_actual = 0;
                    $dev_mes = 0;
                    $dev_mes_meta = 0;
                    $dev_mes_meta_grl = 0;
                    $porcentaje = 0;
                    $porcentaje_total = 0;
                    $porcentaje_grl = 0;
                    $porcentaje_grl_total = 0;
                    $dif_real = 0;
                    //MODIFICADO
                    $por_modif = 0;
                    $monto_p_total = 0;
                    $monto_p = 0;
                    //VARIABLES PARA TOTAL
                    $t_cantidad = 0;
                    $t_pim = 0;
                    $t_pia = 0;
                    $t_certificado = 0;
                    $t_devengado = 0;
                    $t_compromiso_m = 0;
                    $t_total_dev = 0;
                    $t_total_dev_real = 0;
                    $t_dev_mes = 0;
                    $t_mes_actual = 0;
                    $t_mes_actual_grl = 0;
                    $t_mes_meta = 0;
                    $t_mes_meta_grl = 0;
                    $t_total_dif = 0;
                    $t_total_dif_real = 0;
                    //Fecha
                    $.each(response.fecha, function(key, value) {
                        $(".fecha_ssi").text("Actualizado al " + value);
                    });
                    
                    $.each(response.data, function(key, value) {
                        switch (m) {
                            case 1:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_enero']);
                                $dev_mes = parseFloat(value['enero']);
                                break;
                            case 2:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_febrero']);
                                $dev_mes = parseFloat(value['febrero']);
                                break;
                            case 3:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']);
                                $dev_mes_meta = parseFloat(value['m_marzo']);
                                $dev_mes = parseFloat(value['marzo']);
                                break;
                            case 4:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']);
                                $dev_mes_meta = parseFloat(value['m_abril']);
                                $dev_mes = parseFloat(value['abril']);
                                break;
                            case 5:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']);
                                $dev_mes_meta = parseFloat(value['m_mayo']);
                                $dev_mes = parseFloat(value['mayo']);
                                break;
                            case 6:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']);
                                $dev_mes_meta = parseFloat(value['m_junio']);
                                $dev_mes = parseFloat(value['junio']);
                                break;
                            case 7:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']);
                                $dev_mes_meta = parseFloat(value['m_julio']);
                                $dev_mes = parseFloat(value['julio']);
                                break;
                            case 8:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']);
                                $dev_mes_meta = parseFloat(value['m_agosto']);
                                $dev_mes = parseFloat(value['agosto']);
                                break;
                            case 9:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']);
                                $dev_mes_meta = parseFloat(value['m_setiembre']);
                                $dev_mes = parseFloat(value['septiembre']);
                                break;
                            case 10:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']);
                                $dev_mes_meta = parseFloat(value['m_octubre']);
                                $dev_mes = parseFloat(value['octubre']);
                                break;
                            case 11:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']);
                                $dev_mes_meta = parseFloat(value['m_noviembre']);
                                $dev_mes = parseFloat(value['noviembre']);
                                break;
                            case 12:
                                $dev_suma_actual = parseFloat(value['enero']) + 
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']) +
                                    parseFloat(value['noviembre']);
                                $dev_mes_meta = parseFloat(value['m_diciembre']);
                                $dev_mes = parseFloat(value['diciembre']);
                                break;
                            // case "12":
                            //     $dev_suma_actual = parseFloat(value['enero']) +
                            //         parseFloat(value['febrero']) + parseFloat(value[
                            //             'marzo']) + parseFloat(value['abril']) +
                            //         parseFloat(value['mayo']) + parseFloat(value[
                            //             'junio']) + parseFloat(value['julio']) +
                            //         parseFloat(value['agosto']) + parseFloat(value[
                            //             'septiembre']) + parseFloat(value['octubre']) +
                            //         parseFloat(value['noviembre']) + parseFloat(value[
                            //             'diciembre']);
                            //     $dev_mes_meta = parseFloat(value['m_diciembre']);
                            //     $dev_mes = parseFloat(value['diciembre']);
                            //     break;
                            default:
                                $dev_suma_actual = 0;
                                $dev_mes_meta = 0;
                                break;
                        }
                        $dev_suma_actual = Math.round($dev_suma_actual); //Cambiar cuanto se aregle la sincronizacion 
                        // $dev_suma_actual = Math.round(parseFloat(value['dev_ant']));
                        // console.log($dev_mes);
                        // Para comentar 
                        // $dev_mes = ((parseFloat(value['dev_dia']) - $dev_suma_actual) > 0 ? (parseFloat(value['dev_dia']) - $dev_suma_actual) : 0);
                        $porcentaje = (($dev_mes) / $dev_mes_meta) * 100;
                        $porcentaje_grl = (($dev_mes) / $dev_mes_meta_grl) * 100;
                        $dif_real = parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']) - $dev_mes;
                        html += "<tr>";
                        html += "<td class='text-center' style='vertical-align:middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModal(\"" + value['cod_unif'] + "\")'>" + value['cod_unif'] + "</td>";
                        html += "<td class='text-left'>" +  value['nom_proyec'] + "</td>";
                        html += "<td class='text-left hidden'>" +  value['ger_direc'] + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['pim_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['certificacion_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['ate_comp_anual_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['dev_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + value['a_fisico'] + "%</td>";
                        
                        html += "<td class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($dev_suma_actual, 0) + "</td>";
                        html += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        //DEVENGADO
                        if (parseFloat(value['dif_dev_dia']) > 0 && m == $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format(parseFloat(value['dif_dev_dia']), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else if (parseFloat(value['dif_dev_dia']) < 0 && m ==  $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs(parseFloat(value['dif_dev_dia'])), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        }

                        //cambiar en caso la diferencias son erroneas
                        //html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes,0) + "</td>";

                        //META POR MEF
                        if ($porcentaje >= 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($porcentaje >= 40 && $porcentaje < 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($dev_mes_meta == 0) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>---</td>";
                        } else {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        }
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format($dev_mes_meta, 0) + "</td>";
                        //Suma de Totales
                        
                        $t_cantidad += 1;
                        $t_pim += parseFloat(value['pim_dia']);
                        $t_certificado += parseFloat(value['certificacion_dia']);
                        $t_devengado += parseFloat(value['dev_dia']);
                        $t_compromiso_m += parseFloat(value['ate_comp_anual_dia']);
                        $t_total_dev += $dev_suma_actual;
                        $t_dev_mes += ($dev_mes);
                        $t_total_dev_real += parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']);
                        $t_mes_actual += $dev_mes_meta;
                        $t_mes_meta += parseFloat($dev_mes_meta);
                        $t_total_dif += parseFloat(value['dif_dev_dia']);
                        $t_total_dif_real += $dif_real;
                    });


                    $porcentaje_grl_total = $t_mes_actual_grl == 0 ? 0 : ($t_dev_mes / $t_mes_actual_grl) * 100;
                    // console.log($t_mes_actual);
                    // console.log($t_dev_mes)
                    $porcentaje_total = $t_mes_actual == 0 ? 0 : ($t_dev_mes / $t_mes_actual) *
                        100;
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + $t_cantidad + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>TOTAL</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_pim, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_certificado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_compromiso_m, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_devengado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format(($t_devengado / $t_pim) * 100, 1) + "%</th>";
                    html_pie += "<th class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($t_total_dev, 0) + "</th>";
                    html_pie += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    //TOTAL DEVENGADO
                    if ($t_total_dif > 0 && m == $mes_actual ) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format($t_total_dif, 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else if ($t_total_dif < 0 && m == $mes_actual) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs($t_total_dif), 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    }

                    // TOTAL META POR MEF
                    //cambiar en caso la diferencias son erroneas
                    //html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes,0) + "</td>";
                    if ($porcentaje_total >= 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else if ($porcentaje_total >= 40 && $porcentaje_total < 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    }
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_mes_meta, 0) + "</th>";
                    // html_pie +=
                    //     "<th class='text-center' style='vertical-align:middle;'>6,959,130</th>";
                    // html_pie +=
                    //     "<th class='text-center seleccion_apru' style='vertical-align:middle;'>19,772,782</th>";
                
                    // Eliminar Tabla si existe
                },
                complete: function(response) {
                    // resize();
                    $("#cargando").hide();
                    if ($.fn.DataTable.isDataTable('#tb_pry_ejecutados_proyecto') ) {
                        $('#tb_pry_ejecutados_proyecto').DataTable().destroy();
                    }
                    $("#cuerpo_tb_pry_ejecutados_proyecto").html(html);
                    $("#pie_tb_pry_ejecutados_proyecto").html(html_pie);
                    $(".mes").text($meses[m-1][0]);
                    if (m == 1) {
                        // $(".mesabr").text("-" + $meses[0][1]);
                        $(".subtotal_dev").hide();
                    } else if (m == 2) {
                        $(".mesabr").text("");
                        $(".subtotal_dev").show();
                    } else {
                        $(".mesabr").text("-" + $meses[m - 2][1]); //POR EL ARRAY Q EMPIEZA EN 0
                        $(".subtotal_dev").show();
                    }
                    var table = $('#tb_pry_ejecutados_proyecto').DataTable({
                        // processing: true,
                        dom: 'B<"clear">lfrtip',
                        buttons: {
                            orientation: 'landscape',
                            color:'#008d4c',
                            buttons: [{
                                extend: 'excelHtml5',
                                text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                                titleAttr: 'Excel',
                                autoFilter: false,
                                sheetName: "AVANCE DE LA EJECUCION DE LOS PROYECTOS ",
                                title: 'AVANCE DE LA EJECUCION DE LOS PROYECTOS',
                                exportOptions: {
                                columns:[0,1,2,3,4,5,6,7,8,9,11,12]
                                },
                            }]
                        },
                        pageLength : 5,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                        // processing: true,
                        paginate: true,
                        lengthChange: true,
                        filter: true,
                        sort: true,
                        info: true,
                        autoWidth: true,
                        // responsive:true,
                        order:false,
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
                    });
                }
            });
        }
        //Online Proyectos
        table_ejecucion_meta_pry_siaf = function(m) {
            m = parseInt(m);
            $mes_actual = $fecha.getMonth() +  1;
            $meses = [
                ["ENERO", "ENE"],
                ["FEBRERO", "FEB"],
                ["MARZO", "MAR"],
                ["ABRIL", "ABR"],
                ["MAYO", "MAY"],
                ["JUNIO", "JUN"],
                ["JULIO", "JUL"],
                ["AGOSTO", "AGO"],
                ["SEPTIEMBRE", "SEP"],
                ["OCTUBRE", "OCT"],
                ["NOVIEMBRE", "NOV"],
                ["DICIEMBRE", "DIC"]
            ];
            //Ajax
            $.ajax({
                url: "{{ url('/siaf/ejecucionmeta_proyecto_siaf') }}",
                method: 'POST',
                data: {
                    mes: m
                },
                tryCount: 0,
                retryLimit: 3,
                beforeSend: function() {
                    $("#cargando").show();
                },
                success: function(response) {
                    html = "";
                    html_pie = "";
                    $dev_suma_actual = 0;
                    $dev_mes = 0;
                    $dev_mes_meta = 0;
                    $dev_mes_meta_grl = 0;
                    $porcentaje = 0;
                    $porcentaje_total = 0;
                    $porcentaje_grl = 0;
                    $porcentaje_grl_total = 0;
                    $dif_real = 0;
                    //MODIFICADO
                    $por_modif = 0;
                    $monto_p_total = 0;
                    $monto_p = 0;
                    //VARIABLES PARA TOTAL
                    $t_cantidad = 0;
                    $t_pim = 0;
                    $t_pia = 0;
                    $t_certificado = 0;
                    $t_devengado = 0;
                    $t_compromiso_m = 0;
                    $t_total_dev = 0;
                    $t_total_dev_real = 0;
                    $t_dev_mes = 0;
                    $t_mes_actual = 0;
                    $t_mes_actual_grl = 0;
                    $t_mes_meta = 0;
                    $t_mes_meta_grl = 0;
                    $t_total_dif = 0;
                    $t_total_dif_real = 0;
                    //Actualizar Fecha
                    $(".fecha_siaf").text("Actualizado al " + response.fecha);
                    $.each(response.data, function(key, value) {
                        switch (m) {
                            case 1:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_enero']);
                                $dev_mes = parseFloat(value['enero']);
                                break;
                            case 2:
                                $dev_suma_actual = parseFloat(value['enero']);
                                $dev_mes_meta = parseFloat(value['m_febrero']);
                                $dev_mes = parseFloat(value['febrero']);
                                break;
                            case 3:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']);
                                $dev_mes_meta = parseFloat(value['m_marzo']);
                                $dev_mes = parseFloat(value['marzo']);
                                break;
                            case 4:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']);
                                $dev_mes_meta = parseFloat(value['m_abril']);
                                $dev_mes = parseFloat(value['abril']);
                                break;
                            case 5:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']);
                                $dev_mes_meta = parseFloat(value['m_mayo']);
                                $dev_mes = parseFloat(value['mayo']);
                                break;
                            case 6:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']);
                                $dev_mes_meta = parseFloat(value['m_junio']);
                                $dev_mes = parseFloat(value['junio']);
                                break;
                            case 7:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']);
                                $dev_mes_meta = parseFloat(value['m_julio']);
                                $dev_mes = parseFloat(value['julio']);
                                break;
                            case 8:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']);
                                $dev_mes_meta = parseFloat(value['m_agosto']);
                                $dev_mes = parseFloat(value['agosto']);
                                break;
                            case 9:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']);
                                $dev_mes_meta = parseFloat(value['m_setiembre']);
                                $dev_mes = parseFloat(value['septiembre']);
                                break;
                            case 10:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']);
                                $dev_mes_meta = parseFloat(value['m_octubre']);
                                $dev_mes = parseFloat(value['octubre']);
                                break;
                            case 11:
                                $dev_suma_actual = parseFloat(value['enero']) +
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']);
                                $dev_mes_meta = parseFloat(value['m_noviembre']);
                                $dev_mes = parseFloat(value['noviembre']);
                                break;
                            case 12:
                                $dev_suma_actual = parseFloat(value['enero']) + 
                                    parseFloat(value['febrero']) + parseFloat(value[
                                        'marzo']) + parseFloat(value['abril']) +
                                    parseFloat(value['mayo']) + parseFloat(value[
                                        'junio']) + parseFloat(value['julio']) +
                                    parseFloat(value['agosto']) + parseFloat(value[
                                        'septiembre']) + parseFloat(value['octubre']) +
                                    parseFloat(value['noviembre']);
                                $dev_mes_meta = parseFloat(value['m_diciembre']);
                                $dev_mes = parseFloat(value['diciembre']);
                                break;
                            // case "12":
                            //     $dev_suma_actual = parseFloat(value['enero']) +
                            //         parseFloat(value['febrero']) + parseFloat(value[
                            //             'marzo']) + parseFloat(value['abril']) +
                            //         parseFloat(value['mayo']) + parseFloat(value[
                            //             'junio']) + parseFloat(value['julio']) +
                            //         parseFloat(value['agosto']) + parseFloat(value[
                            //             'septiembre']) + parseFloat(value['octubre']) +
                            //         parseFloat(value['noviembre']) + parseFloat(value[
                            //             'diciembre']);
                            //     $dev_mes_meta = parseFloat(value['m_diciembre']);
                            //     $dev_mes = parseFloat(value['diciembre']);
                            //     break;
                            default:
                                $dev_suma_actual = 0;
                                $dev_mes_meta = 0;
                                break;
                        }
                        $dev_suma_actual = Math.round($dev_suma_actual); //Cambiar cuanto se aregle la sincronizacion 
                        // $dev_suma_actual = Math.round(parseFloat(value['dev_ant']));
                        // console.log($dev_mes);
                        // Para comentar 
                        // $dev_mes = ((parseFloat(value['dev_dia']) - $dev_suma_actual) > 0 ? (parseFloat(value['dev_dia']) - $dev_suma_actual) : 0);
                        $porcentaje = (($dev_mes) / $dev_mes_meta) * 100;
                        $porcentaje_grl = (($dev_mes) / $dev_mes_meta_grl) * 100;
                        $dif_real = parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']) - $dev_mes;
                        html += "<tr>";
                        html += "<td class='text-center' style='vertical-align:middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModal(\"" + value['cod_unif'] + "\")'>" + value['cod_unif'] + "</td>";
                        html += "<td class='text-left'>" +  value['nom_proyec'] + "</td>";
                        html += "<td class='text-left hidden'>" +  value['ger_direc'] + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['pim_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['certificacion_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['ate_comp_anual_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format(value['dev_dia'], 0) + "</td>";
                        html += "<td class='text-center' style='vertical-align:middle;'>" + value['a_fisico'] + "%</td>";
                        
                        html += "<td class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($dev_suma_actual, 0) + "</td>";
                        html += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        //DEVENGADO
                        if (parseFloat(value['dif_dev_dia']) > 0 && m == $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format(parseFloat(value['dif_dev_dia']), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else if (parseFloat(value['dif_dev_dia']) < 0 && m ==  $mes_actual) {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs(parseFloat(value['dif_dev_dia'])), 0) + "</span><br>" + number_format($dev_mes, 0) + "</td>";
                        } else {
                            html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes, 0) + "</td>";
                        }

                        //cambiar en caso la diferencias son erroneas
                        //html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes,0) + "</td>";

                        //META POR MEF
                        if ($porcentaje >= 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($porcentaje >= 40 && $porcentaje < 70) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        } else if ($dev_mes_meta == 0) {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>---</td>";
                        } else {
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" + number_format($porcentaje, 1) + "%</b></td>";
                        }
                        html += "<td class='text-center' style='vertical-align:middle;'>" + number_format($dev_mes_meta, 0) + "</td>";
                        //Suma de Totales
                        
                        $t_cantidad += 1;
                        $t_pim += parseFloat(value['pim_dia']);
                        $t_certificado += parseFloat(value['certificacion_dia']);
                        $t_devengado += parseFloat(value['dev_dia']);
                        $t_compromiso_m += parseFloat(value['ate_comp_anual_dia']);
                        $t_total_dev += $dev_suma_actual;
                        $t_dev_mes += ($dev_mes);
                        $t_total_dev_real += parseFloat(value['mes_actual'] == null ? 0 : value['mes_actual']);
                        $t_mes_actual += $dev_mes_meta;
                        $t_mes_meta += parseFloat($dev_mes_meta);
                        $t_total_dif += parseFloat(value['dif_dev_dia']);
                        $t_total_dif_real += $dif_real;
                    });


                    $porcentaje_grl_total = $t_mes_actual_grl == 0 ? 0 : ($t_dev_mes / $t_mes_actual_grl) * 100;
                    // console.log($t_mes_actual);
                    // console.log($t_dev_mes)
                    $porcentaje_total = $t_mes_actual == 0 ? 0 : ($t_dev_mes / $t_mes_actual) *
                        100;
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + $t_cantidad + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>TOTAL</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_pim, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_certificado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_compromiso_m, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_devengado, 0) + "</th>";
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format(($t_devengado / $t_pim) * 100, 1) + "%</th>";
                    html_pie += "<th class='text-center subtotal_dev' style='vertical-align:middle;'>" + number_format($t_total_dev, 0) + "</th>";
                    html_pie += "<td class='text-center seleccion hidden' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    //TOTAL DEVENGADO
                    if ($t_total_dif > 0 && m == $mes_actual ) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " + number_format($t_total_dif, 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else if ($t_total_dif < 0 && m == $mes_actual) {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " + number_format(Math.abs($t_total_dif), 0) + "</span><br>" + number_format($t_dev_mes, 0) + "</td>";
                    } else {
                        html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes, 0) + "</td>";
                    }

                    // TOTAL META POR MEF
                    //cambiar en caso la diferencias son erroneas
                    //html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes,0) + "</td>";
                    if ($porcentaje_total >= 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else if ($porcentaje_total >= 40 && $porcentaje_total < 70) {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    } else {
                        html_pie +=
                            "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                            number_format($porcentaje_total, 1) + "%</b></td>";
                    }
                    html_pie += "<th class='text-center' style='vertical-align:middle;'>" + number_format($t_mes_meta, 0) + "</th>";
                    // html_pie +=
                    //     "<th class='text-center' style='vertical-align:middle;'>6,959,130</th>";
                    // html_pie +=
                    //     "<th class='text-center seleccion_apru' style='vertical-align:middle;'>19,772,782</th>";
                
                    // Eliminar Tabla si existe
                },
                complete: function(response) {
                    // resize();
                    $("#cargando").hide();
                    if ($.fn.DataTable.isDataTable('#tb_pry_ejecutados_proyecto_siaf') ) {
                        $('#tb_pry_ejecutados_proyecto_siaf').DataTable().destroy();
                    }
                    $("#cuerpo_tb_pry_ejecutados_proyecto_siaf").html(html);
                    $("#pie_tb_pry_ejecutados_proyecto_siaf").html(html_pie);
                    $(".mes").text($meses[m-1][0]);
                    if (m == 1) {
                        // $(".mesabr").text("-" + $meses[0][1]);
                        $(".subtotal_dev").hide();
                    } else if (m == 2) {
                        $(".mesabr").text("");
                        $(".subtotal_dev").show();
                    } else {
                        $(".mesabr").text("-" + $meses[m - 2][1]); //POR EL ARRAY Q EMPIEZA EN 0
                        $(".subtotal_dev").show();
                    }
                    var table = $('#tb_pry_ejecutados_proyecto_siaf').DataTable({
                        // processing: true,
                        dom: 'B<"clear">lfrtip',
                        buttons: {
                            orientation: 'landscape',
                            color:'#008d4c',
                            buttons: [{
                                extend: 'excelHtml5',
                                text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                                titleAttr: 'Excel',
                                autoFilter: false,
                                sheetName: "AVANCE DE LA EJECUCION DE LOS PROYECTOS - SIAF ",
                                title: 'AVANCE DE LA EJECUCION DE LOS PROYECTOS - SIAF',
                                exportOptions: {
                                columns:[0,1,2,3,4,5,6,7,8,10,11]
                                },
                            }]
                        },
                        pageLength : 5,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                        // processing: true,
                        paginate: true,
                        lengthChange: true,
                        filter: true,
                        sort: true,
                        info: true,
                        autoWidth: true,
                        // responsive:true,
                        order:false,
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
                    });
                }
            });
        }
        // Ejecutar
        resize = function(){
            setTimeout(function () {
                $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
            },0);
        }

        obtener_mes= function(){
            var fecha_pro = $fecha.getMonth();
            var primerDia = new Date($fecha.getFullYear(), $fecha.getMonth() , 1);
            $mes = 0;
            
            if(primerDia.getMonth() == 0){
                $mes = 0;
            }else{
                if($fecha.getDate() < 5){
                    if(primerDia.getDay()==6){ //sabado 
                        if ($fecha.getDate() <= 3){
                            $mes = fecha_pro-1;
                        }else{
                            $mes = fecha_pro;
                        }
                    }else if(primerDia.getDay()==0){ //domingo
                        if ($fecha.getDate() <= 2){
                            $mes = fecha_pro-1;
                        }else{
                            $mes = fecha_pro;
                        }   
                    }else if(primerDia.getDay()==5){ //viernes
                        if ($fecha.getDate() <= 4){
                            $mes = fecha_pro-1;
                        }else{
                            $mes = fecha_pro;
                        }   
                    }else {
                        if($fecha.getDate() == primerDia.getDate()){
                            $mes = fecha_pro-1;
                        }else{
                            $mes = fecha_pro;
                        }     
                    }
                }else{
                    $mes = fecha_pro;
                }
            }

            return $mes + 1;
        }
                
        filtro_uei = function(){
            $mes= $("#mes_avance_uei :selected").val();
            $pliego= $("#pliego_avance_uei :selected").val();
            table_ejecucion_meta_uei($mes,$pliego);
        }

        filtro = function(){
            $mes= $("#mes_avance :selected").val();
            $pliego= $("#pliego_avance :selected").val();
            table_ejecucion_meta_pry($mes,$pliego);
        }

        filtro_mes_pry_siaf = function(){
            $mes= $("#mes_avance_siaf :selected").val();
            table_ejecucion_meta_pry_siaf($mes);
        }

        filtro_mes_uei_siaf = function(){
            $mes= $("#mes_avance_uei_siaf :selected").val();
            table_ejecucion_meta_uei_siaf($mes);
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

        loadModal = function(filtro) {
            modaltype='full-width';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/siaf/show") }}',
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

        loadModalUEI = function(filtro) {
            modaltype='full-width';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/siaf/show_uei") }}',
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
        // MOSTRAR ONLINE
        $("#tipo").change(function() {
            $('#btn_online').prop('checked', false);
            
            $tipo= $("#tipo :selected").val();
            $mes = obtener_mes();
            if ($tipo == 'uei'){
                $("#uei_offline").show();
                $("#uei_online").hide();
                $("#pry_offline").hide();
                $("#pry_online").hide();
                $("#mes_avance_uei > option[value="+$mes+"]").attr("selected",true);
                table_ejecucion_meta_uei($mes,"1027");
            }else{
                $("#uei_offline").hide();
                $("#uei_online").hide();
                $("#pry_offline").show();
                $("#pry_online").hide();
                $("#mes_avance > option[value="+$mes+"]").attr("selected",true);
                table_ejecucion_meta_pry($mes,"1027");
            }
        });

        // Ejecutar por de defecto en pry_offline
        $mes = obtener_mes();
        $("#mes_avance_uei > option[value="+$mes+"]").attr("selected",true);
        table_ejecucion_meta_uei($mes,"1027");

        $("#btn_online").change(function() {
            $mes = obtener_mes();
            $tipo= $("#tipo :selected").val();
            if ($tipo == 'uei'){
                if(this.checked) {
                    $("#uei_offline").hide()
                    $("#uei_online").show();
                    // $("#mes_avance_uei_siaf > option[value="+$mes+"]").attr("selected",true);
                    $("#mes_avance_uei_siaf").val($mes);
                    table_ejecucion_meta_uei_siaf($mes);
                }else{ 
                    $("#uei_online").hide();
                    $("#uei_offline").show();
                    // $("#mes_avance_uei > option[value="+$mes+"]").attr("selected",true);
                    $("#mes_avance_uei").val($mes);
                    table_ejecucion_meta_uei($mes,"1027");
                }
            }else{            
                if(this.checked) {
                    $("#pry_offline").hide();
                    $("#pry_online").show();
                    // $("#mes_avance_siaf > option[value="+$mes+"]").attr("selected",true);
                    $("#mes_avance_siaf").val($mes);
                    // $("#mes_avance_siaf").selectmenu("refresh");
                    // $('#select1').selectmenu('refresh');
                    table_ejecucion_meta_pry_siaf($mes);
                }else{ 
                    $("#pry_online").hide();
                    $("#pry_offline").show();
                    // $("#mes_avance > option[value="+$mes+"]").attr("selected",true);
                    $("#mes_avance").val($mes);
                    // $("#mes_avance").selectmenu("refresh");
                    table_ejecucion_meta_pry($mes,"1027");
                }
            }
        });
        
    });
</script>
@endsection