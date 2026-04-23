<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-88030392-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
    
          gtag('config', 'UA-88030392-2');
        </script>
        <meta charset="utf-8">
        <meta name = "csrf-token" content = "{{ csrf_token() }}">
    
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="icon" href="{{asset('ico.png')}}">
        <title>SIGPROA</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
        <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"-->
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('dist/css/skins/skin-blue.min.css') }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    
        <!-- jQuery 2.2.3 -->
        <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    
        <!-- SELECT2 -->
        <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}"/>
        <!-- SWEET ALERT -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}">
    
        <!-- BootStrap Modal Addon -->
        <link href="{{ asset('plugins/bootstrap-addon/css/bootstrap-modal-bs3patch.min.css')}}" rel="stylesheet" />
        <link href="{{ asset('plugins/bootstrap-addon/css/bootstrap-modal.min.css')}}" rel="stylesheet" />
        <!-- FancyBox -->
        <link rel="stylesheet" href="{{asset('plugins/fancybox/source/jquery.fancybox.min.css')}}" type="text/css" media="screen" />
        <!-- jqGRID >
        <link rel="stylesheet" href="{{asset('plugins/jqgrid/css/ui.jqgrid.css')}}"/>
        <link rel="stylesheet" href="{{asset('plugins/jqgrid/plugins/css/ui.multiselect.min.css')}}"/-->
        <!-- Intro JS -->
        <link rel="stylesheet" href="{{asset('plugins/introjs/introjs.min.css')}}"/>
    
        <!-- Pickadate -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/pickadate/compressed/themes/default.date.css') }}">
        <link href="{{ asset('css/cargadores/loading.css') }}" rel="stylesheet" />
        <!-- CHART JS >
        <script type="text/javascript" language="javascript" src="{{asset('plugins/chartjs/chart.min.js')}}"></script-->
        <!--  -->
        <script>
             $.ajaxSetup({
                 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
              });
        </script>
    
        <style>
            /*#map{
                display: none;
            }*/
            .swal2-container{
                z-index: 2000;
            }
    
            #dvLoading
            {
               background:#000 url(http://media.riffsy.com/images/a6a6686cbddb3e99a5f0b60a829effb3/tenor.gif) no-repeat center center;
               height: 100px;
               width: 100px;
               position: fixed;
               z-index: 1000;
               left: 50%;
               top: 50%;
               margin: -25px 0 0 -25px;
            }
    
            /* for custom scrollbar for webkit browser*/
    
          ::-webkit-scrollbar {
              width: 6px;
          }
          ::-webkit-scrollbar-track {
              -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
          }
          ::-webkit-scrollbar-thumb {
              -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
          }
    
    
    
            /*.tour-backdrop,
            .tour-step-background {
                position: fixed;
            }*/
        </style>
    
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    

    <!-- D3 JS -->
    <link href="{{ asset('plugins/c3/c3.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('plugins/c3/d3.min.js') }}"></script>
    <script src="{{ asset('plugins/c3/c3.min.js') }}"></script>
    <script src="{{ asset('plugins/imprimir/jQuery.print.min.js') }}"></script>

    <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css" rel="stylesheet"
        type="text/css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

    <!-- Print Area -->
    {{-- <link href="{{ asset('plugins/printArea/PrintArea.css') }}" rel="stylesheet" type="text/css"/> --}}
    {{-- <script type="text/javascript" language="javascript" src="{{ asset('plugins/chartjs/chart.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" language="javascript" src="{{ asset('plugins/printArea/jquery.PrintArea.js') }}"></script> --}}
    <style>
        .atajos {
            justify-content: center;
        }

        @media (min-width: 900px) {
            .atajos {
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
            background: radial-gradient(center, ellipse cover, #ff0000 1%, #cc0000 100%);
        }

        .seleccion {
            background-color: #bbd2a1;
            font-weight: bold;
        }

        .seleccion_apru {
            background-color: #9bc3d0;
            font-weight: bold;
        }

        .seleccion_dev {
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
</head>
<body style="background-color: #f3f3f3;">
    <div class="container-fluid" style="padding-top: 5px;">
        @php
            setlocale(LC_TIME, "spanish");
        @endphp
        <div id="print">
            <div class="well text-center" style="background-color: #337ab7">
                <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;color: white">GOBIERNO REGIONAL DE LIMA</span>
            </div>
            {{-- <a href="javascript:void(0);" id="printButton">Print</a>  --}}
            {{-- CUADROS INFORMACION --}}
            <div class="row">
                <div style="text-align: center">
                    <div class="btn-group" data-toggle="btn-toggle">
                        <a href="#" id="historia_2015" onclick="historia('2015')" class="his_anio btn btn-default btn-sm">2015</a>
                        <a href="#" id="historia_2016" onclick="historia('2016')" class="his_anio btn btn-default btn-sm">2016</a>
                        <a href="#" id="historia_2017" onclick="historia('2017')" class="his_anio btn btn-default btn-sm">2017</a>
                        <a href="#" id="historia_2018" onclick="historia('2018')" class="his_anio btn btn-default btn-sm">2018</a>
                        <a href="#" id="historia_2019" onclick="historia('2019')" class="his_anio btn btn-default btn-sm">2019</a>
                        <a href="#" id="historia_2020" onclick="historia('2020')" class="his_anio btn btn-default btn-sm">2020</a>
                        <a href="#" id="historia_2021" onclick="historia('2021')" class="his_anio btn btn-default btn-sm">2021</a>
                        <a href="#" id="historia_2022" onclick="historia('2022')" style="font-weight: bold" class="his_anio btn btn-success btn-sm  active">2022</a>
                    </div>
                </div>
                <div style="margin-top: 10px">
                    <div class="contenedor_loading" id="cargando_historia" style="display: none">
                        <img src="{{ asset('css/cargadores/loading.gif') }}" style="width: 50px;height: 50px;">
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-university"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" id="text_anio" style="font-weight: bold;">INVERSIÓN CON PIM</span>
                                <span class="info-box-number" style="font-size: 2em;text-align: center" id="n_proyectos">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" id="text_pia" style="font-weight: bold;">PIA {{ date('Y') }}</span>
                                <span class="info-box-number" style="font-size: 1.73em;text-align: center" id="pia">0</span>
                                <span class="info-box-number" style="font-size: 1.3em;text-align: center" id="avance_pia">( 0.0% )</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"  id="text_pim" style="font-weight: bold;">PIM {{ date('Y') }}</span>
                                <span class="info-box-number" style="font-size: 1.73em;text-align: center" id="pim">0</span>
                                <span class="info-box-number" style="font-size: 1.3em;text-align: center" id="avance">( 0.0% )</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"  id="text_dev" style="font-weight: bold;">DEVENGADO {{ date('Y') }}</span>
                                <span class="info-box-number" style="font-size: 2em;text-align: center" id="devengado">0</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-bar-chart-o"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-weight: bold;">AVANCE {{ date('Y') }}</span>
                                <span class="info-box-number" style="font-size: 2em;" id="avance">0 %</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            {{-- GRAFICO RANKING Y PROYECTOS --}}
            <div class="row" id="data">
                <section class="col-lg-3 connectedSortable ui-sortable">
                    <div class="nav-tabs-custom" style="cursor: default;">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs pull-right ui-sortable-handle">
                            <li class="pull-left header"><i class="fa fa-line-chart"></i>RANKING</li>
                        </ul>
                        <div class="tab-content">
                            <div class="chart tab-pane active" style="position: relative;">   
                                <div id="chart_ranking"></div>
                            </div>
                        </div>
                    </div>      
                </section>
                <section class="col-lg-9 connectedSortable ui-sortable" id="imp_ejec">
                    <div class="nav-tabs-custom" style="cursor: default;">
                        <ul class="nav nav-tabs pull-right ui-sortable-handle">
                            <li class="pull-left header">
                                <i class="fa fa-line-chart"></i>AVANCE DE LA EJECUCION DE LOS PROYECTOS DE INVERSION {{ date("Y") }}
                            </li>
                            <li class="pull-right header">
                                <div class="row">
                                    <div class="col-md-3 no-print">
                                        <button class="btn btn-default" id="imprimir"><i class="fa fa-print"></i></button>
                                    </div>
                                    <div class="col-md-9">
                                        <select  name="mes_avance" class="form-control" id="mes_avance"  onchange="mes()">
                                            <option value="0">ENE</option>
                                            <option value="1">FEB</option>
                                            <option value="2">MAR</option>
                                            <option value="3">ABR</option>
                                            <option value="4">MAY</option>
                                            <option value="5">JUN</option>
                                            <option value="6">JUL</option>
                                            <option value="7">AGO</option>
                                            <option value="8">SEP</option>
                                            <option value="9">OCT</option>
                                            <option value="10">NOV</option>
                                            <option value="11">DIC</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                        </ul> 
                        <div class="tab-content">
                            <div class="chart tab-pane active" style="position: relative;">                                     
                                <div class="table  table-responsive tb_pry_ejecutados">
                                    <table class="table table-bordered" style="width:100%;margin: 0px;" id="tb_pry_ejecutados">
                                        <thead style="background-color: rgba(146, 208, 80, 1)">
                                            <tr>
                                                <th class="text-center" style="width:60px;vertical-align:middle;" rowspan="2">N° PRY</th>
                                                <th class="text-center" style="width:200px;vertical-align:middle;" rowspan="2">UEI</th>
                                                <th class="text-center" style="width:80px;vertical-align:middle;" rowspan="2">PIM {{ date("Y") }}</th>
                                                <th class="text-center" style="width:400px;vertical-align:middle;" colspan="4">EJECUCIÓN {{ date("Y") }}</th>
                                                <th class="text-center subtotal_dev" style="width:130px;vertical-align:middle;" rowspan="2">DEV ENE<label class="mesabr"></th>
                                                <th class="text-center text-uppercase seleccion" style="width:130px;vertical-align:middle;" rowspan="2">DEVENGADO <label class="mes"></th>
                                                <!-- <th colspan="2" class="text-center hide" style="width:130px;vertical-align:middle;">META <label class="mes"></label> POR GRL</th>
                                                <th colspan="2" class="text-center" style="width:130px;vertical-align:middle;">META <label class="mes"></label> POR MEF</th> -->
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="width:100px;vertical-align:middle;">CERTIFICADO {{ date("Y") }}</th>
                                                <th class="text-center" style="width:100px;vertical-align:middle;">COMPROMISO MENSUAL {{ date("Y") }}</th>
                                                <th class="text-center" style="width:100px;vertical-align:middle;">DEVENGADO {{ date("Y") }}</th>
                                                <th class="text-center" style="width:50px;vertical-align:middle;">%</th>
                                                <!-- <th class="text-center hide" style="width:130px;vertical-align:middle;">INDICADOR</th> -->
                                                <!-- <th class="text-center hide seleccion_dev" id="mes_9" style="width:130px;vertical-align:middle">S/ META</th> -->
                                                <!-- <th class="text-center" style="width:130px;vertical-align:middle;">INDICADOR </th> -->
                                                <!-- <th class="text-center seleccion_apru" id="mes_9_apru" style="width:130px;vertical-align:middle;">S/ META</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpo_tb_pry_ejecutados">
                                        </tbody>
                                        <tfoot>
                                            <tr id="pie_tb_pry_ejecutados" style="background-color:#72ca70c7">
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="row col-md-12 no-print">
                                    <p><b>Nota</b></p>
                                    <li>
                                        (+) Aumento del devengado
                                    </li>
                                    <li>
                                        (-) Disminución del devengado
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
                <div  class="col-md-12" style="margin-bottom: 15px;">
                    <div style="overflow: overlay;text-align:center">
                        <!-- <img src="{{asset('/meta_t4.png')}}" class="img-fluid"> -->
                    </div>
                </div>
            </div>
        </div>
        <div id="cargando" class="loading" style="display: none;"></div>                                 
        {{-- GRAFICO RANKING SECTOR Y FORMATO 12-B --}}
        <div class="row" style="display:none">
            <section class="col-lg-4 connectedSortable ui-sortable">
                <div class="nav-tabs-custom" style="cursor: default;">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header"><i class="fa fa-line-chart"></i>RANKING SECTOR REGIONAL</li>
                    </ul>
                    <div class="tab-content">
                        <div class="chart tab-pane active" style="position: relative;">   
                            <div id="chart_ranking_sector"></div>
                        </div>
                    </div>
                </div>      
            </section>
            <section class="col-lg-4 connectedSortable ui-sortable">
                <div class="nav-tabs-custom" style="cursor: default;">
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="pull-left header"><i class="fa fa-line-chart"></i>RANKING SECTOR REGION LIMA</li>
                    </ul> 
                    <div class="tab-content">
                        <div class="chart tab-pane active" style="position: relative;">       
                            <div id="chart_ranking_sector_lima"></div>                              
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-4 connectedSortable ui-sortable">
                <div class="nav-tabs-custom" style="cursor: default;">
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="pull-left header"><i class="fa fa-line-chart"></i>FORMATO 12-B {{ date("Y") }}</li>
                    </ul> 
                    <div class="tab-content">
                        <div class="chart tab-pane active" style="position: relative;">                                     
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- FORMATO 12-B --}}
        <div class="box" style="display:none">>
            <div class="box-header text-center">
                <h3 class="box-title"><strong>REPORTE DEL FORMATO N° 12-B</strong></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary" style="border-left: 3px solid #3c8dbc;border-right: 3px solid #3c8dbc;">
                            <div class="box-header">
                                <h3 class="box-title"><strong>REGISTRO Y ACTUALIZACIÓN DEL F12-B</strong></h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box" style="color: white;background-color: #16385c;">
                                            <div class="inner">
                                                <h3 class="text-center" id="factible">0</h3>
                                                <p class="text-center">Factibles de registro</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box" style="color: white;background-color: #16385c;">
                                            <div class="inner">
                                                <h3 class="text-center" id="registrados">0</h3>
                                                <p class="text-center">Registrados</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box" style="color: white;background-color: #16385c;">
                                            <div class="inner">
                                                <h3 class="text-center" id="actualizados">0</h3>
                                                <p class="text-center">Actualizados</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box" style="color: white;background-color: #16385c;">
                                            <div class="inner">
                                                <h3 class="text-center" id="avance_12b">0 %</h3>
                                                <p class="text-center">Avance</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary" style="border-left: 3px solid #3c8dbc;border-right: 3px solid #3c8dbc;">
                            <div class="box-header">
                                <h3 class="box-title"><strong>REGISTRO DEL AVANCE DE EJECUCIÓN</strong></h3>
                            </div>
                            <div class="box-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFICO FINANCIERA --}}
        <div class="row" style="display:none">
            <section class="col-lg-12 connectedSortable ui-sortable">
                <div class="nav-tabs-custom" style="cursor: default;">
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header"><i class="fa fa-line-chart"></i> EJECUCIÓN FINANCIERA</li>
                    </ul>
                    <div class="tab-content">
                        <div class="chart tab-pane active" style="position: relative; height: 350px;">                 
                            <div id = "Financechart"></div> 
                        </div>
                    </div>
                </div>      
            </section>
        </div>
        {{-- GRAFICO ACCESOS DIRECTOS --}}
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body atajos">
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <a class="btn btn-block btn-primary btn-lg" href="{{URL::to('proyecto/inicio')}}" target="_blank">PROYECTOS DE INVERSIÓN</a>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <a class="btn btn-block btn-primary btn-lg" href="{{URL::to('carterapmi/')}}" target="_blank">PMI-GRL</a>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <a class="btn btn-block btn-primary btn-lg" href="{{URL::to('consultamigable')}}" target="_blank">CONSULTA AMIGABLE</a>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <a class="btn btn-block btn-primary btn-lg" href="{{URL::to('formato12b')}}" target="_blank">FORMATO 12-B</a>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <a class="btn btn-block btn-primary btn-lg" href="{{URL::to('habilitador/inicio')}}" target="_blank">HABILITADORES</a>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <a class="btn btn-block btn-primary btn-lg" href="{{URL::to('piptotalpriori')}}" target="_blank">BANCO DE PROYECTOS</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="full-width" class="modal container fade" tabindex="-1" style="display: none;" data-backdrop="static">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</body>

<script  src="https://demos.codexworld.com/print-specific-area-of-web-page-using-jquery/jquery.PrintArea.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>


<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
<script src="{{asset('plugins/table_freeze/freeze-table.min.js')}}"></script>
<!-- BootStrap MODAL PLUGIN -->
<script src="{{ asset('plugins/bootstrap-addon/js/bootstrap-modal.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-addon/js/bootstrap-modalmanager.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
        var MONTHS = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul","Ago", "Sep", "Oct", "Nov", "Dic"];
        var chart;
        var chart_ranking;
        var chart_ranking_sector;

        $("#printButton").click(function(){
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("#print").printArea( options );
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

        function getFinanc(){
            $.ajax({
                url: "{{ url('resumen/financiera')}}",
                method: "POST",
                data: {cboYear:2020 },
                success: function(response) {
                    /*if (config.data.datasets.length > 0) {
                        var month = MONTHS[config.data.labels.length % MONTHS.length];
                        config.data.labels.push(month);

                        config.data.datasets.forEach(function(dataset) {
                            dataset.data.push(randomScalingFactor());
                        });

                        window.myLine.update();
                    }
                    */
                    //config.data.datasets[0].data.push(response['devengado']);
                    //config.data.datasets[1].data.push(response['devengadoAcumulado']);
                    //config.data.datasets[2].data.push(response['Pim']);
                    var count = 0;
                    var devengado = $.map(response['devengado'], function(value, index) {
                        count++;
                        if (count == 1){
                            return [value];
                        }else{
                            if(value!=0){
                                return [value];
                            }
                        }
                    });
                    devengado.unshift('Devengado Mensual');
                    count = 0;
                    var devengadoAcumulado = $.map(response['devengadoAcumulado'], function(value, index) {
                        count++;
                        if (count == 1){
                            return [value];
                        }else{
                            if(value!=0){
                                return [value];
                            }
                        }
                    });
                    devengadoAcumulado.unshift('Devengado Acumulado');
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

                } // End Success
            });  // End Ajax
        }

        /*function formato12b(){
            $.ajax({
                url: "{{ url('/formato12b/actualizacion')}}",
                method: "POST",
                success: function(response) {
                    $.each(response, function( index, value ) {
                        $("#factible").text(value.factibles);
                        $("#registrados").text(value.registrados);
                        $("#actualizados").text(value.actualizados);
                        $("#avance_12b").text(number_format((value.actualizados/value.factibles)*100,2) + " %");
                    });
                },
                complete: function(response) {    
                }
            });
        }*/

        function getRanking(categoria){
            $array_avance=[];
            $array_coduei=[];
            $array_sector=[];
            $array_pim=[];
            $array_dev=[];
            $array_avance_lima=[];
            $.ajax({
                url: "{{ url('resumen/ranking')}}",
                data:{categoria:categoria},
                method: "POST",
                success: function(response) {
                    if (categoria=="PLIEGO"){
                        $array_avance = $.map(response, function(value, index) {return parseFloat(value['avance'])});
                        $array_coduei = $.map(response, function(value, index) {return value['cod']});
                        $array_sector = $.map(response, function(value, index) {return {[value["cod"]]:value['gore']} });
                        $array_pim = $.map(response, function(value, index) {return value['pim'] });
                        $array_dev = $.map(response, function(value, index) {return value['girado'] });
                    }else{
                        $array_avance = $.map(response, function(value, index) {return parseFloat(value['avance_regional'])});
                        $array_avance_lima = $.map(response, function(value, index) {return parseFloat(value['avance_lima'])});
                        $array_coduei = $.map(response, function(value, index) {return value['cod']});
                        $array_sector = $.map(response, function(value, index) {return {[value["cod"]]:value['gore']} });
                        $array_avance_lima.unshift("data1");
                    }
                    $array_avance.unshift("data1");
                },
                complete: function(response) {
                    if (categoria=="PLIEGO"){
                        chart_ranking($array_avance,$array_coduei,$array_pim,$array_dev);
                    }else if (categoria=="SECTOR-REGIONAL"){
                        chart_ranking_sector($array_avance,$array_coduei,$array_sector);
                        chart_ranking_sector_lima($array_avance_lima,$array_coduei,$array_sector);
                    }     
                }
            });
        }

        setTimeout(function(){
            chart = c3.generate({
                bindto:"#Financechart",
                data: {
                    columns: [],
                    labels: true,
                    labels: {
                        format: function (v, id, i, j) { return d3.format(",")(v).replace(/,/g, ','); }
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: MONTHS
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
                stanford: {
                    scaleWidth: 20
                },
                tooltip: {
                    format: {
                        value: function(value) {
                            return d3.format(",.2f")(value).replace(/,/g, ',');
                        }
                    }
                }
            });
            //formato12b();
            getRanking("PLIEGO");
            // getRanking("SECTOR-REGIONAL");
            // getFinanc();
        },500);

        //Grafico Ranking
        chart_ranking = function(array_avance,array_coduei,array_pim,array_dev){
            $data=[]
            $data.push(array_avance);
            region = {452:"LAMBAYEQUE",442:"APURIMAC",459:"SAN MARTIN",460:"TACNA",462:"UCAYALI",454:"MADRE DE DIOS",465:"LIMA METROPOLITANA",455:"MOQUEGUA",448:"HUANUCO",463:"LIMA",440:"AMAZONAS",456:"PASCO",446:"CUSCO",458:"PUNO",453:"LORETO",457:"PIURA",447:"HUANCAVELICA",444:"AYACUCHO",441:"ANCASH",443:"AREQUIPA",450:"JUNIN",451:"LA LIBERTAD",445:"CAJAMARCA",461:"TUMBES",449:"ICA",464:"CALLAO"}
            chart_ranking = c3.generate({
                bindto: '#chart_ranking',
                size: {
                    height: 700,
                },
                data: {
                    columns: $data,
                    colors: {
                        data1: "#4a91ceb3",
                    },
                    color: function (color, d) {
                        // d will be 'id' when called for legends
                         
                        codigo = array_coduei[d.index];
                        return codigo === 463 ? "#337ab7" : color;
                    },
                    type: 'bar',
                    labels: {
                        format: {
                            data1: function(v, id, i, j) {
                                return region[array_coduei[i]] + " " + v + "%" ;
                            }
                        }
                    }
                },
                bar: {
                    width: 24
                },
                tooltip: {
                    show: false
                },
                legend: {
                    show: false
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        tick: {
                            format: function (d) { return d+1 + " °" ; }
                        }
                    },
                    y:{
                        show:false
                    }
                },
                onresized: function() {
                    resize(array_coduei)
                },
                tooltip: {
                    contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
                        i = d[0].index;
                        var $$ = this, config = $$.config,
                        titleFormat = config.tooltip_format_title || defaultTitleFormat,
                        nameFormat = config.tooltip_format_name || function (name) { return name; },
                        valueFormat = config.tooltip_format_value || defaultValueFormat,
                        text, i, title, value, name, bgcolor;
                        
                        title = region[array_coduei[i]];
                        text = "<table class='" + $$.CLASS.tooltip + "'>" + (title || title === 0 ? "<tr><th colspan='2' style='background-color:#3c8dbc;color:black'>" + title + "</th></tr>" : "");
                        
                        text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[0].index + "'>";
                        text += "<td class='name'><span style='background-color:#f39c12'></span><b>PIM</b></td>";
                        text += "<td class='value'><b>" + number_format(array_pim[i],0).substring(0,number_format(array_pim[i],0).length-4) + "</b></td>";
                        text += "</tr>";
                        text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[0].index + "'>";
                        text += "<td class='name'><span style='background-color:#00a65a'></span><b>DEV.</b></td>";
                        text += "<td class='value'><b>" + number_format(array_dev[i],0).substring(0,number_format(array_dev[i],0).length-4) + "</b></td>";
                        text += "</tr>";                        
                        return text + "</table>";
                    }
                }
                /*tooltip: {
                    format: {
                        title: function (d) { 
                            return region[array_coduei[d]]; 
                        },
                        value: function (value, ratio, id,d) {
                            console.log(d3.format(','));
                            var format = d3.format(',');
                            return format(value);
                        }
                    }
                }*/
            });
            resize(array_coduei)
        }

        //Resize Grafico Ranking
        function resize(array_coduei) {
            d3.selectAll("#chart_ranking .c3-text").each(function(d,x) {
                var self = d3.select(this);
                self.attr('x', '5');
                self.style({"fill":"rgb(0, 0, 0)","font-size": "1.2em","font-weight":"bold"});
                if(array_coduei[x-1] == 463){
                    self.style({"fill":"rgb(255, 255, 255)","font-size": "1.3em","font-weight":"bold"}); //Por el Momento
                }
            });

            d3.selectAll("#chart_ranking .c3-axis-x").each(function(d,x) {
                var self = d3.select(this);
                self.style({"font-size": "1.4em","font-weight":"bold"});
            });
        }

        //Grafico Ranking Sector
        chart_ranking_sector = function(array_avance,array_coduei,array_sector){
            $data=[];
            $data.push(array_avance);
            chart_ranking_sector = c3.generate({
                bindto: '#chart_ranking_sector',
                size: {
                    height: 700,
                },
                data: {
                    columns: $data,
                    colors: {
                        data1: "#4a91ceeb",
                    },
                    color: function (color, d) {
                        // d will be 'id' when called for legends
                         
                        codigo = array_coduei[d.index];
                        return codigo === 463 ? "#337ab7" : color;
                    },
                    type: 'bar',
                    labels: {
                        format: {
                            data1: function(v, id, i, j) {
                                return array_sector[i][array_coduei[i]] + " " + v + "%" ;
                            }
                        }
                    }
                },
                bar: {
                    width: 24
                },
                tooltip: {
                    show: false
                },
                legend: {
                    show: false
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        tick: {
                            format: function (d) { return d+1 + " °" ; }
                        }
                    },
                    y:{
                        show:false
                    }
                },
                onresized: function() {
                    resizesector(array_coduei,"#chart_ranking_sector")
                }
            });
            resizesector(array_coduei,"#chart_ranking_sector")
        }
        chart_ranking_sector_lima = function(array_avance,array_coduei,array_sector){
            $data=[];
            $data.push(array_avance);
            chart_ranking_sector = c3.generate({
                bindto: '#chart_ranking_sector_lima',
                size: {
                    height: 700,
                },
                data: {
                    columns: $data,
                    colors: {
                        data1: "#e26b5d",
                    },
                    color: function (color, d) {
                        // d will be 'id' when called for legends
                         
                        codigo = array_coduei[d.index];
                        return codigo === 463 ? "#337ab7" : color;
                    },
                    type: 'bar',
                    labels: {
                        format: {
                            data1: function(v, id, i, j) {
                                return array_sector[i][array_coduei[i]] + " " + v + "%" ;
                            }
                        }
                    }
                },
                bar: {
                    width: 24
                },
                tooltip: {
                    show: false
                },
                legend: {
                    show: false
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        tick: {
                            format: function (d) { return d+1 + " °" ; }
                        }
                    },
                    y:{
                        show:false
                    }
                },
                onresized: function() {
                    resizesector(array_coduei,"#chart_ranking_sector_lima")
                }
            });
            resizesector(array_coduei,"#chart_ranking_sector_lima")
        }
        //Resize Grafico Ranking Sector
        function resizesector(array_coduei,id) {
            d3.selectAll(id + " .c3-text").each(function(d,x) {
                var self = d3.select(this);
                self.attr('x', '5');
                self.style({"fill":"rgb(0, 0, 0)","font-size": "1.2em","font-weight":"bold"});
            });

            d3.selectAll(id + " .c3-axis-x").each(function(d,x) {
                var self = d3.select(this);
                self.style({"font-size": "1.4em","font-weight":"bold"});
            });
        }

        table_ejecucion_meta = function(m) {
                $mes_actual = String($fecha.getMonth());
                $meses = m;
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
                //Cambiar Nombre de Columna
                $(".mes").text($meses[$mes][0]);
                if (m == 0) {
                    $(".mesabr").text("-" + $meses[0][1]);
                } else if (m == 1) {
                    $(".mesabr").text("");
                } else {
                    $(".mesabr").text("-" + $meses[$mes - 1][1]);
                }
                //Ajax
                $.ajax({
                    url: "{{ url('/resumen/ejecucionmeta') }}",
                    method: 'POST',
                    data: {
                        mes: parseFloat($mes) + 1
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
                        $.each(response.data, function(key, value) {

                            switch ($mes) {
                                case "0":
                                    $dev_suma_actual = parseFloat(value['enero']);
                                    $dev_mes_meta = parseFloat(value['m_enero']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_enero']);
                                    $dev_mes = parseFloat(value['enero']);
                                    break;
                                case "1":
                                    $dev_suma_actual = parseFloat(value['enero']);
                                    $dev_mes_meta = parseFloat(value['m_febrero']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_febrero']);
                                    $dev_mes = parseFloat(value['febrero']);
                                    break;
                                case "2":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']);
                                    $dev_mes_meta = parseFloat(value['m_marzo']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_marzo']);
                                    $dev_mes = parseFloat(value['marzo']);
                                    break;
                                case "3":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']);
                                    $dev_mes_meta = parseFloat(value['m_abril']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_abril']);
                                    $dev_mes = parseFloat(value['abril']);
                                    break;
                                case "4":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']);
                                    $dev_mes_meta = parseFloat(value['m_mayo']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_mayo']);
                                    $dev_mes = parseFloat(value['mayo']);
                                    break;
                                case "5":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']);
                                    $dev_mes_meta = parseFloat(value['m_junio']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_junio']);
                                    $dev_mes = parseFloat(value['junio']);
                                    break;
                                case "6":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']) + parseFloat(value[
                                            'junio']);
                                    $dev_mes_meta = parseFloat(value['m_julio']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_julio']);
                                    $dev_mes = parseFloat(value['julio']);
                                    break;
                                case "7":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']) + parseFloat(value[
                                            'junio']) + parseFloat(value['julio']);
                                    $dev_mes_meta = parseFloat(value['m_agosto']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_agosto']);
                                    $dev_mes = parseFloat(value['agosto']);
                                    break;
                                case "8":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']) + parseFloat(value[
                                            'junio']) + parseFloat(value['julio']) +
                                        parseFloat(value['agosto']);
                                    $dev_mes_meta = parseFloat(value['m_setiembre']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_setiembre']);
                                    $dev_mes = parseFloat(value['septiembre']);
                                    break;
                                case "9":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']) + parseFloat(value[
                                            'junio']) + parseFloat(value['julio']) +
                                        parseFloat(value['agosto']) + parseFloat(value[
                                            'septiembre']);
                                    $dev_mes_meta = parseFloat(value['m_octubre']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_octubre']);
                                    $dev_mes = parseFloat(value['octubre']);
                                    break;
                                case "10":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']) + parseFloat(value[
                                            'junio']) + parseFloat(value['julio']) +
                                        parseFloat(value['agosto']) + parseFloat(value[
                                            'septiembre']) + parseFloat(value['octubre']);
                                    $dev_mes_meta = parseFloat(value['m_noviembre']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_noviembre']);
                                    $dev_mes = parseFloat(value['noviembre']);
                                    break;
                                case "11":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']) + parseFloat(value[
                                            'junio']) + parseFloat(value['julio']) +
                                        parseFloat(value['agosto']) + parseFloat(value[
                                            'septiembre']) + parseFloat(value['octubre']) +
                                        parseFloat(value['noviembre']);
                                    $dev_mes_meta = parseFloat(value['m_diciembre']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_diciembre']);
                                    $dev_mes = parseFloat(value['diciembre']);
                                    break;
                                case "12":
                                    $dev_suma_actual = parseFloat(value['enero']) +
                                        parseFloat(value['febrero']) + parseFloat(value[
                                            'marzo']) + parseFloat(value['abril']) +
                                        parseFloat(value['mayo']) + parseFloat(value[
                                            'junio']) + parseFloat(value['julio']) +
                                        parseFloat(value['agosto']) + parseFloat(value[
                                            'septiembre']) + parseFloat(value['octubre']) +
                                        parseFloat(value['noviembre']) + parseFloat(value[
                                            'diciembre']);
                                    $dev_mes_meta = parseFloat(value['m_diciembre']);
                                    $dev_mes_meta_grl = parseFloat(value['grl_diciembre']);
                                    $dev_mes = parseFloat(value['diciembre']);
                                    break;
                                default:
                                    $dev_suma_actual = 0;
                                    $dev_mes_meta = 0;
                                    $dev_mes_meta_grl = 0;
                                    break;
                            }

                            $dev_suma_actual = Math.round(
                                $dev_suma_actual
                                ); //Cambiar cuanto se aregle la sincronizacion 
                            // $dev_suma_actual = Math.round(parseFloat(value['dev_ant']));

                            // Para comentar 
                            // $dev_mes = ((parseFloat(value['dev_dia']) - $dev_suma_actual) > 0 ? (parseFloat(value['dev_dia']) - $dev_suma_actual) : 0);
                            $porcentaje = (($dev_mes) / $dev_mes_meta) * 100;
                            $porcentaje_grl = (($dev_mes) / $dev_mes_meta_grl) * 100;
                            $dif_real = parseFloat(value['mes_actual'] == null ? 0 : value[
                                'mes_actual']) - $dev_mes;
                            html += "<tr>";
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>" +
                                value['cantida'] + "</td>";
                            html +=
                                "<td class='text-left'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModal(\"" +
                                value['ger_direc'] + "\")'>" + value['ger_direc'] +
                                "</a></td>";
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>" +
                                number_format(value['pim_dia'], 0) + "</td>";
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>" +
                                number_format(value['certificacion_dia'], 0) + "</td>";
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>" +
                                number_format(value['ate_comp_anual_dia'], 0) + "</td>";
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>" +
                                number_format(value['dev_dia'], 0) + "</td>";
                            html +=
                                "<td class='text-center' style='vertical-align:middle;'>" +
                                value['a_fisico'] + "%</td>";
                            html +=
                                "<td class='text-center subtotal_dev' style='vertical-align:middle;'>" +
                                number_format($dev_suma_actual, 0) + "</td>";

                            //DEVENGADO
                            if (parseFloat(value['dif_dev_dia']) > 0 && $mes ==
                                $mes_actual) {
                                html +=
                                    "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " +
                                    number_format(parseFloat(value['dif_dev_dia']), 0) +
                                    "</span><br>" + number_format($dev_mes, 0) + "</td>";
                            } else if (parseFloat(value['dif_dev_dia']) < 0 && $mes ==
                                $mes_actual) {
                                html +=
                                    "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " +
                                    number_format(Math.abs(parseFloat(value[
                                        'dif_dev_dia'])), 0) + "</span><br>" +
                                    number_format($dev_mes, 0) + "</td>";
                            } else {
                                html +=
                                    "<td class='text-center seleccion' style='vertical-align:middle;'>" +
                                    number_format($dev_mes, 0) + "</td>";
                            }

                            //META POR GRL
                            // if ($porcentaje_grl >= 70) {
                            //     html +=
                            //         "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                            //         number_format($porcentaje_grl, 1) + "%</b></td>"
                            // } else if ($porcentaje_grl >= 40 && $porcentaje_grl < 70) {
                            //     html +=
                            //         "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                            //         number_format($porcentaje_grl, 1) + "%</b></td>"
                            // } else {
                            //     html +=
                            //         "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                            //         number_format($porcentaje_grl, 1) + "%</b></td>"
                            // }
                            // html +=
                            //     "<td class='text-center seleccion_dev hide' style='vertical-align:middle;'>" +
                            //     number_format($dev_mes_meta_grl, 0) + "</td>";

                            //cambiar en caso la diferencias son erroneas
                            //html += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($dev_mes,0) + "</td>";

                            //META POR MEF
                            // if ($porcentaje >= 70) {
                            //     html +=
                            //         "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                            //         number_format($porcentaje, 1) + "%</b></td>";
                            // } else if ($porcentaje >= 40 && $porcentaje < 70) {
                            //     html +=
                            //         "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                            //         number_format($porcentaje, 1) + "%</b></td>";
                            // } else if ($dev_mes_meta == 0) {
                            //     html +=
                            //         "<td class='text-center' style='vertical-align:middle;'>---</td>";
                            // } else {
                            //     html +=
                            //         "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                            //         number_format($porcentaje, 1) + "%</b></td>";
                            // }
                            // html +=
                            //     "<td class='text-center seleccion_apru' style='vertical-align:middle;'>" +
                            //     number_format($dev_mes_meta, 0) + "</td>";

                            html += "</tr>";
                            //Suma de Totales

                            $t_cantidad += parseFloat(value['cantida']);
                            $t_pim += parseFloat(value['pim_dia']);
                            $t_certificado += parseFloat(value['certificacion_dia']);
                            $t_devengado += parseFloat(value['dev_dia']);
                            $t_compromiso_m += parseFloat(value['ate_comp_anual_dia']);
                            $t_total_dev += $dev_suma_actual;
                            $t_dev_mes += ($dev_mes);
                            $t_total_dev_real += parseFloat(value['mes_actual'] == null ?
                                0 : value['mes_actual']);
                            $t_mes_actual += $dev_mes_meta;
                            $t_mes_actual_grl += $dev_mes_meta_grl;
                            $t_mes_meta += parseFloat($dev_mes_meta);
                            $t_mes_meta_grl += parseFloat($dev_mes_meta_grl);
                            $t_total_dif += parseFloat(value['dif_dev_dia']);
                            $t_total_dif_real += $dif_real;
                        });

                        $.each(response.pia, function(key, value) {
                            $t_pia += parseFloat(value['pia_dia']);
                        });
                        

                        //Ingresando a box
                        $("#n_proyectos").text($t_cantidad);
                        $("#pim").text(number_format($t_pim, 0));
                        $("#pia").text(number_format($t_pia, 0));
                        $("#devengado").text(number_format($t_devengado, 0));
                        $("#avance").text("( " + number_format(($t_devengado / $t_pim) * 100, 1) + "% )");
                        $("#avance_pia").text("( " + number_format(($t_devengado / $t_pia) * 100, 1) + "% )");
                        $porcentaje_grl_total = $t_mes_actual_grl == 0 ? 0 : ($t_dev_mes /
                            $t_mes_actual_grl) * 100;
                        $("#fechadevengado").text(response.fecha);
                        $porcentaje_total = $t_mes_actual == 0 ? 0 : ($t_dev_mes / $t_mes_actual) *
                            100;
                        html_pie += "<th class='text-center' style='vertical-align:middle;'>" +
                            $t_cantidad + "</th>";
                        html_pie +=
                            "<th class='text-center' style='vertical-align:middle;'>TOTAL</th>";
                        html_pie += "<th class='text-center' style='vertical-align:middle;'>" +
                            number_format($t_pim, 0) + "</th>";
                        html_pie += "<th class='text-center' style='vertical-align:middle;'>" +
                            number_format($t_certificado, 0) + "</th>";
                        html_pie += "<th class='text-center' style='vertical-align:middle;'>" +
                            number_format($t_compromiso_m, 0) + "</th>";
                        html_pie += "<th class='text-center' style='vertical-align:middle;'>" +
                            number_format($t_devengado, 0) + "</th>";
                        html_pie += "<th class='text-center' style='vertical-align:middle;'>" +
                            number_format(($t_devengado / $t_pim) * 100, 1) + "%</th>";
                        html_pie +=
                            "<th class='text-center subtotal_dev' style='vertical-align:middle;'>" +
                            number_format($t_total_dev, 0) + "</th>";

                        //TOTAL DEVENGADO
                        if ($t_total_dif > 0 && $mes == $mes_actual) {
                            html_pie +=
                                "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:green;font-weight:bold;'>+ " +
                                number_format($t_total_dif, 0) + "</span><br>" + number_format(
                                    $t_dev_mes, 0) + "</td>";
                        } else if ($t_total_dif < 0 && $mes == $mes_actual) {
                            html_pie +=
                                "<td class='text-center seleccion' style='vertical-align:middle;'><span style='color:red;font-weight:bold;'>- " +
                                number_format(Math.abs($t_total_dif), 0) + "</span><br>" +
                                number_format($t_dev_mes, 0) + "</td>";
                        } else {
                            html_pie +=
                                "<td class='text-center seleccion' style='vertical-align:middle;'>" +
                                number_format($t_dev_mes, 0) + "</td>";
                        }

                        //TOTAL META POR GRL
                        // if ($porcentaje_grl_total >= 70) {
                        //     html_pie +=
                        //         "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                        //         number_format($porcentaje_grl_total, 1) + "%</b></td>";
                        // } else if ($porcentaje_grl_total >= 40 && $porcentaje_grl_total < 70) {
                        //     html_pie +=
                        //         "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                        //         number_format($porcentaje_grl_total, 1) + "%</b></td>";
                        // } else {
                        //     html_pie +=
                        //         "<td class='text-center hide' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                        //         number_format($porcentaje_grl_total, 1) + "%</b></td>";
                        // }
                        // html_pie +=
                        //     "<th class='text-center hide seleccion_dev' style='vertical-align:middle;'>" +
                        //     number_format($t_mes_meta_grl, 0) + "</th>";

                        // TOTAL META POR MEF
                        //cambiar en caso la diferencias son erroneas
                        //html_pie += "<td class='text-center seleccion' style='vertical-align:middle;'>" + number_format($t_dev_mes,0) + "</td>";
                        // if ($porcentaje_total >= 70) {
                        //     html_pie +=
                        //         "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo verde'><li></li></ul><b>" +
                        //         number_format($porcentaje_total, 1) + "%</b></td>";
                        // } else if ($porcentaje_total >= 40 && $porcentaje_total < 70) {
                        //     html_pie +=
                        //         "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo naranja'><li></li></ul><b>" +
                        //         number_format($porcentaje_total, 1) + "%</b></td>";
                        // } else {
                        //     html_pie +=
                        //         "<td class='text-center' style='vertical-align:middle;'><ul class='semaforo rojo'><li></li></ul><b>" +
                        //         number_format($porcentaje_total, 1) + "%</b></td>";
                        // }
                        // html_pie +=
                        //     "<th class='text-center seleccion_apru' style='vertical-align:middle;'>" +
                        //     number_format($t_mes_meta, 0) + "</th>";


                        $("#cuerpo_tb_pry_ejecutados").html(html);
                        $("#pie_tb_pry_ejecutados").html(html_pie);

                        if ($mes == 0) {
                            $(".subtotal_dev").hide();
                        } else {
                            $(".subtotal_dev").show();
                        }
                    },
                    complete: function(response) {
                        $("#cargando").hide();
                    }
                });
            }

        //Llamadas
        var $fecha = new Date();
        var primerDia = new Date($fecha.getFullYear(), $fecha.getMonth(), 1);
        $mes = "0";
        if(primerDia.getMonth() == 0){
            $mes = "0";
        }else{
            if($fecha.getDate() < 5){
                if(primerDia.getDay()==6){ //sabado 
                    if ($fecha.getDate() <= 3){
                        $mes = String($fecha.getMonth()-1);
                    }else{
                        $mes = String($fecha.getMonth());
                    }
                }else if(primerDia.getDay()==0){ //domingo
                    if ($fecha.getDate() <= 2){
                        $mes = String($fecha.getMonth()-1);
                    }else{
                        $mes = String($fecha.getMonth());
                    }   
                }else if(primerDia.getDay()==5){ //domingo
                    if ($fecha.getDate() <= 4){
                        $mes = String($fecha.getMonth()-1);
                    }else{
                        $mes = String($fecha.getMonth());
                    }   
                }
                else {
                    if($fecha.getDate() == primerDia.getDate()){
                        $mes = String($fecha.getMonth()-1);
                    }else{
                        $mes = String($fecha.getMonth());
                    }     
                }
            }else{
                $mes = String($fecha.getMonth());
            }
        }

        /*if(primerDia.getDay()==6 || primerDia.getDay()==0) //sabado y domingo
        {   if(primerDia.getMonth() == 0){
                $mes = "0";
            }else{
                $mes = String(primerDia.getMonth()-1);
            }
            
        }else {
            $mes = String(primerDia.getMonth());
        }
        console.log($mes);*/
        $mes= "0"; //En caso no funcione
        $("#mes_avance > option[value="+$mes+"]").attr("selected",true);
        
        table_ejecucion_meta($mes);

        mes = function(){
            $mes= $("#mes_avance :selected").val();
            table_ejecucion_meta($mes);
        }

        $("#imprimir").click(function(){
            $("#imp_ejec").print({
                noPrintSelector: ".no-print",
            });                
        });

        loadModal = function(filtro) {
        modaltype='full-width';
        $modal = $('#' + modaltype);
              $.ajax({
                  url: '{{ asset("/resumen/showprydev") }}',
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

        setTimeout(function() {
                window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;   //compatibility for firefox and chrome
                var pc = new RTCPeerConnection({iceServers:[]}), noop = function(){};
                pc.createDataChannel("");    //create a bogus data channel
                pc.createOffer(pc.setLocalDescription.bind(pc), noop);    // create offer and set local description
                pc.onicecandidate = function(ice){  //listen for candidate events
                    if(!ice || !ice.candidate || !ice.candidate.candidate)  return;
                    var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
                    $.ajax({
                        url: '/etInfo',
                        type: 'POST',
                        data: {'lip': myIP, 'u':$('#eternalUser').text()}
                    });
                    //console.log('my IP: ', myIP,$('#eternalUser').text());
                    pc.onicecandidate = noop;
                };
        }, 10);

        historia = function($anio){
            $(".his_anio").removeClass("btn-success");
            $(".his_anio").removeClass("active");
            $(".his_anio").addClass("btn-default");
            $(".his_anio").css("font-weight","normal");
            $("#historia_"+$anio).addClass("btn-success active");
            $("#historia_"+$anio).css("font-weight","bold");
            $("#text_pia").html("PIA " + $anio);
            $("#text_pim").html("PIM " + $anio);
            $("#text_dev").html("DEVENGADO " + $anio);
            if($anio == (new Date).getFullYear()){
                $("#text_anio").html("INVERSIÓN CON PIM");
                $("#data").show();
                
            }else{
                $("#text_anio").html("TOTAL DE INVERSIONES");
                $("#data").hide();
            }
            $.ajax({
                url: "{{ url('/resumen/historia_anio') }}",
                method: 'GET',
                data: {anio:$anio},
                tryCount: 0,
                retryLimit: 3,
                beforeSend: function() {
                    $("#cargando_historia").show();
                },success: function(response) {
                    $data = response.data;
                    console.log($data['proyecto']);
                    $("#n_proyectos").text($data['proyecto']);
                    $("#pim").text(number_format($data['pim_dia'], 0));
                    $("#pia").text(number_format($data['pia_dia'], 0));
                    $("#devengado").text(number_format($data['dev_dia'], 0));
                    $("#avance").text("( " + number_format(($data['dev_dia'] / $data['pim_dia']) * 100, 1) + "% )");
                    $("#avance_pia").text("( " + number_format(($data['dev_dia'] / $data['pia_dia']) * 100, 1) + "% )");
                },
                complete: function(response) {
                    $("#cargando_historia").hide();
                }
            });
        }
    });
</script>