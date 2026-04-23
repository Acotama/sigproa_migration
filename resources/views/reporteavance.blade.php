<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name = "csrf-token" content = "{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="icon" href="{{asset('ico.png')}}">
    <title>Reporte</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"-->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

    <!-- D3 JS -->
    <link href="{{asset('plugins/c3/c3.min.css')}}" rel="stylesheet" />
    <script src="{{asset('plugins/c3/d3.min.js')}}"></script>
    <script src="{{asset('plugins/c3/c3.min.js')}}"></script>

    <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">

    <!-- Print Area -->
    <!-- <link href="{{ asset('plugins/printArea/PrintArea.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" language="javascript" src="{{asset('plugins/chartjs/chart.min.js')}}"></script>
    <script type="text/javascript" language="javascript" src="{{asset('plugins/printArea/jquery.PrintArea.js')}}"></script> -->
    <style>
        .atajos{
            justify-content: center;
        }
        @media (min-width: 900px){
            .atajos{
                display: flex;
                justify-content: center;
            }
        }

        /*FIN CARGANDO*/
    </style>
    @php
        setlocale(LC_TIME, "spanish");
        $now = new DateTime();
        $now = $now->modify('-1 days');
        $year= $now->format('Y');
        $mes= $now->format('m');
        switch ($mes) {
            case 1:
                $mes = "Enero";
                break;
            case 2:
                $mes = "Febrero";
                break;
            case 3:
                $mes = "Marzo";
                break;
            case 4:
                $mes = "Abril";
                break;
            case 5:
                $mes = "Mayo";
                break;
            case 6:
                $mes = "Junio";
                break;
            case 7:
                $mes = "Julio";
                break;
            case 8:
                $mes = "Agosto";
                break;
            case 9:
                $mes = "octubre";
                break;
            case 10:
                $mes = "Octubre";
                break;
            case 11:
                $mes = "Noviembre";
                break;
            case 12:
                $mes = "Diciembre";
                break;
        }
        $dia= $now->format('d');
    @endphp
</head>
<body>
    <div class="row">
        <div class="col-md-2 col-sm-6 col-md-offset-1">
            <button id="crearimagen" class="form-control">Enviar Imagen</button>
        </div>
    </div>
    <div id="figuras" class="col-md-10 col-md-offset-1">
        </br>
        <div class="row" style="text-align: center;">
            <img src="{{asset('/titulo.png')}}">
        </div>
        </br>
        <!--CUADROS INFORMACION-->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green" style="min-height: 125px;border-radius: 20px;background-color: #173859c2!important;">
                <div class="inner text-center">
                <h3><span id="presupuesto">0</span><sup style="font-size: 20px"> M</sup></h3>
                <p><strong style="font-size: 19px">PRESUPUESTO {{ $year }}</strong></p>
                </div>
            </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green" style="min-height: 125px;border-radius: 20px;">
                <div class="inner text-center">
                <h3><span id="ejecucion">0</span><sup style="font-size: 20px">M</sup></h3>
                <h4><strong id="por_ejecucion">(0.0 %)</strong></h4>
                <p><strong style="font-size: 19px">EJECUCIÓN {{ $year }}</strong></p>
                </div>
            </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green" style="min-height: 125px;border-radius: 20px;background-color: #737373!important;">
                <div class="inner text-center">
                <h3><span id="ejecucion_mes">0</span><sup style="font-size: 20px"> M</sup></h3>
                <h4><strong id="por_ejecucion_mes">(0.0 %)</strong></h4>
                <p><strong style="font-size: 19px">EJECUCIÓN AL {{ $dia }} DE {{ strtoupper($mes) }}</strong></p>
                </div>
            </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green" style="min-height: 125px;border-radius: 20px;background-color: #ce3742!important;"> 
                <div class="inner text-center">
                <h3><span id="meta">0</span><sup style="font-size: 20px"> M</sup></h3>
                <p><strong style="font-size: 19px">META {{ strtoupper($mes) }}</strong></p>
                </div>
            </div>
            </div>
            <!-- <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="small-box bg-green" style="min-height: 125px;border-radius: 20px;background-color: #098ddc!important;"> 
                        <div class="inner text-center">
                            <h3><span id="variacion">0</span></h3>
                            <p><strong style="font-size: 19px">VARIACIÓN {{ $year - 1 }} / {{ $year }}</strong></p>
                        </div>
                </div>
            </div> -->
        </div>

        <div class="row">
            <section class="col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                    <li class="box-title" style="font-weight: bold;font-size: 20px;"><i class="fa fa-line-chart"></i>   Ejecución al {{ $dia }} de {{$mes}} (2019 - {{ $year }})</li>
                    </br>
                    <li class="box-title" style="/* font-weight: bold; */font-size: 18px;margin-top: 5px;"> (millones de soles y porcentaje respecto al PIM)</li>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="chart tab-pane active" style="position: relative;">   
                            <div id="chart_ejecucion"></div>
                        </div>
                    </div>
                </div>    
            </section>
            <section class="col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                    <li class="box-title" style="font-weight: bold;font-size: 20px;"><i class="fa fa-line-chart"></i>   Ejecución y Metas al {{ $dia }} de {{$mes}} de {{ $year }}</li>
                    </br>
                    <li class="box-title" style="/* font-weight: bold; */font-size: 18px;margin-top: 5px;"> (millones de soles)</li>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="meta_gerencia">
                        <!--<div class="chart tab-pane active" style="position: relative;">   
                            <div id="chart_ejecucion_torta"></div>
                        </div>-->
                    </div>
                </div>  
            </section>
        </div>

        <div class="row">
            <div  class="col-md-12" style="margin-bottom: 15px;">
                <div style="overflow: overlay;text-align:center">
                    <img src="{{asset('/meta_t4.png')}}" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="row" style="display: None;">
            <section class="col-lg-12 connectedSortable ui-sortable">
                <div class="nav-tabs-custom" style="cursor: default;">
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header" style="font-weight: bold;"><i class="fa fa-line-chart"></i> Ejecución de la Inversión Pública del mes de julio (2019 - 2023)</li>
                    </ul>
                    <div class="tab-content">
                        <div class="chart tab-pane active" style="position: relative;">   
                            <div id="chart_ejecucion_mes"></div>
                        </div>
                    </div>
                </div>      
            </section>
        </div>
        </br>
        <div class="row" style="text-align: center;">
            <img src="{{asset('/pie.png')}}">
        </div>
    </div>

    <div id="contenedorCanvas"></div>

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
    <script src="{{asset('plugins/imprimir/jQuery.print.min.js')}}"></script>
    <script src="{{asset('plugins/canvas/html2canvas.min.js')}}"></script>
    <script src="{{asset('plugins/filesaver/filesaver.js')}}"></script>
    <script type="text/javascript">
    $(function(){

        function svgMod(){
            // htmls =  $("#chart_ejecucion").html();
            htmls =  $("#chart_ejecucion svg g .c3-axis .domain");
            htmls.attr("d", "M 0 1 V 0 H 694.5 V 1");
        }

        var MONTHS = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul","Ago", "Sep", "Oct", "Nov", "Dic"];
        var chart;
        var chart_ejecucion;

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

            // si es junior o menor que cero retorno el valor formateado como numero
            amount = '' + amount.toFixed(decimals);

            var amount_parts = amount.split(','),
                regexp = /(\d+)(\d{3})/;

            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

            return sign ? '-' + amount_parts.join('.') : amount_parts.join('.');
        }

        table_ejecucion = function(){
            $array_devmes = [];
            $array_pim = [];
            $array_avance = [];
            $array_anio = [];

            //Ajax
            $.ajax({
                url: '{{ url("/proyecto/reporte_inversiones") }}',
                method: 'POST',
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function () {
                    // $("#cargando").show();
                },
                success: function(response){
                    $.each(response.reporte_ejec_1,function(key,value){
                        $("#presupuesto").text(number_format(value["pim"],3));
                        $("#ejecucion").text(number_format(value["ejec_general"],3));
                        $("#por_ejecucion").text("(" + number_format((value["ejec_general"]/value["pim"])*100,1) + " %)");
                        $("#ejecucion_mes").text(number_format(value["ejec_mes"],3));
                    });

                    $val_2020 = 0;
                    $val_2021 = 0;
                    $meta_mes = 0;
                    $dev_mes = 0;
                    $.each(response.reporte_ejec_2,function(key,value){
                        if(value['anio'] == '2020') {
                            $val_2020 = value['dev_dia'];
                        }

                        if(value['anio'] == '2021') {
                            $val_2021 = value['dev_dia'];
                        }                        
                    });

                    $variacion = (($val_2021 - $val_2020)/$val_2020)*100
                    $("#variacion").text(number_format($variacion,1) + " %");

                    $array_devmes = $.map(response.reporte_ejec_2, function(value, index) {return parseFloat(value['dev_dia'])});
                    $array_devmes.unshift("data1");
                    $array_pim = $.map(response.reporte_ejec_2, function(value, index) {return parseFloat(value['pim'])});
                    $array_avance = $.map(response.reporte_ejec_2, function(value, index) {return parseFloat(value['avance'])});
                    $array_anio = $.map(response.reporte_ejec_2, function(value, index) {return parseFloat(value['anio'])});
                    $array_anio.unshift("x");

                    html = '<div class="progress-group">';
                    $.each(response.reporte_ejec_3,function(key,value){
                        $dev = parseFloat(value['octubre']);
                        $meta =  parseFloat(value['m_octubre']);
                        $porcentaje = number_format(($dev/$meta)*100,1);
                        $porcentaje_gr = number_format(($dev/$meta)*100,1);
                        if($porcentaje_gr > 100){
                            $porcentaje_gr = 100;
                        }

                        html += '<span class="progress-text" style="font-size: 16px;">' + value['ger_direc'] + '</span>';
                        html += '<span class="progress-number" style="font-size: 16px;"><b>' + number_format($dev/1000000,3) + '</b>/' + number_format(parseFloat($meta/1000000),3) + '</span>';
                        html += '<div class="progress">';
                        if($porcentaje_gr >= 10){
                            html += '<div class="progress-bar progress-bar-green" style="color: white;font-size: 16px;background-color: #25ad6e; width: ' + $porcentaje_gr + '%"><b>' + $porcentaje + '%</b></div>';
                        }else{
                            html += '<div class="progress-bar progress-bar-green" style="color: #304242;font-size: 16px;background-color: #25ad6e; width: ' + $porcentaje_gr + '%"><b>' + $porcentaje + '%</b></div>';
                        }
                        
                        html += '</div>';

                        $meta_mes += parseFloat(value['m_octubre']/1000000);
                        $dev_mes += parseFloat(value['octubre']/1000000);
                        
                    });
                    html += '</div>';
                    $("#meta_gerencia").html(html);
                    $("#meta").text(number_format($meta_mes,3));
                    $("#por_ejecucion_mes").text("(" + number_format(($dev_mes/$meta_mes)*100,1) + " %)");

                    // $array_gerdirec = $.map(response.reporte_ejec_3, function(value, index) {return value['abreviatura']});
                    // $array_ejec_mes = $.map(response.reporte_ejec_3, function(value, index) {return number_format(parseFloat(value['junio']/1000000),3)});
                    // $array_ejec_mes.unshift("data1");
                    // $array_meta_mes = $.map(response.reporte_ejec_3, function(value, index) {return number_format(parseFloat(value['m_junio']/1000000),3)});
                    // $array_meta_mes.unshift("data2");
                },
                complete: function(response) {
                    // $("#cargando").hide();
                    grafico_ejecucion($array_devmes,$array_anio,$array_avance);
                    // grafico_ejecucion_torta($array_ger_dev,$array_gerdirec);
                    // grafico_ejecucion_torta(items);
                    // grafico_ejecucion_mes();
                    // chart_ranking($array_ejec_mes,$array_meta_mes,$array_gerdirec);
                    svgMod();
                }
            });
        }

        grafico_ejecucion = function(array_dev,array_anio,array_avance){
            var chart = c3.generate({
                bindto: '#chart_ejecucion',
                size: {
                    height: 400,
                },
                data: {
                    x : 'x',
                    columns: [
                        array_anio,
                        array_dev
                    ],
                    type: 'bar',
                    colors: {
                        data1: "#757575",
                    },
                    color: function (color, d) {
                        anio = d.x;
                        return anio === 2021 ? "#337ab7" : color;
                    },
                    labels: {
                        format: {
                            data1: function(v, id, i, j) {
                                return number_format(v,3) + " (" + number_format(array_avance[i],1) + "%)";
                            }
                        }
                    },
                },
                bar: {
                    width: {
                        ratio: 0.3 // this makes bar width 50% of length between ticks
                    }
                    // or
                    //width: 100 // this makes bar width 100px
                },
                legend: {
                    show: false
                },
                tooltip: {
                    show: false
                },
                axis: {
                    y:{
                        show:false
                    }
                },
                onresized: function() {
                    resize()
                },
                stanford: {
                    texts: [
                        {x: 1, y: 4, content: 'my custom text here', class: 'text-1-4'}
                    ]
                }
            });
            resize()
        }

        grafico_ejecucion_torta = function(array_ger_dev){
            var torta = c3.generate({
                bindto: '#chart_ejecucion_torta',
                data: {
                    columns: 
                        array_ger_dev
                    ,
                    type : 'donut',
                },
                legend: {
                    position: 'right'
                },
                tooltip: {
                    show: false
                },
                donut: {
                    label: {
                        format: function (value, ratio, id) {
                            return number_format(value/1000000,3);
                        }
                    }
                }
            });
        }

        grafico_ejecucion_mes = function(){
            var chart_mes = c3.generate({
                bindto: '#chart_ejecucion_mes',
                data: {
                    columns: [
                        ['data1', 30, 200, 200, 400, 150, 250],
                        ['data2', 130, 100, 100, 200, 150, 50]
                    ],
                    type: 'bar',
                    groups: [
                        ['data1', 'data2']
                    ]
                },
                grid: {
                    y: {
                        lines: [{value:0}]
                    }
                }
            });
            //resize()
        }

        //Grafico Ranking
        chart_ranking = function(array_ejec_mes,array_meta_mes,array_gerdirec){
            chart_ranking = c3.generate({
                bindto: '#chart_ejecucion_torta',
                size: {
                    height: 400,
                },
                data: {
                    columns: [
                        array_meta_mes,
                        array_ejec_mes
                    ],
                    names: {
                        data2: 'Meta',
                        data1: 'Ejecución',
                    },
                    colors: {
                        data1: "#4a91ceb3",
                        data2: "#bbd2a1"
                    },
                    type: 'bar',
                    labels: {
                        // format: {
                        //     data1: function(v, id, i, j) {
                        //         return region[array_coduei[i]] + " " + v + "%" ;
                        //     }
                        // }
                        show:true
                    },
                },
                bar: {
                    width: 18
                },
                tooltip: {
                    show: false
                },
                legend: {
                    show: true
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        categories: array_gerdirec
                    },
                    y:{
                        show:false
                    }
                },
                onresized: function() {
                    rezice_ejec_metas()
                },
            });
            rezice_ejec_metas()
        }

        function rezice_ejec_metas() {
            d3.selectAll("#chart_ejecucion_torta .c3-text").each(function(d,x) {
                var self = d3.select(this);
                // self.attr('x', '5');
                self.style({"fill":"rgb(0, 0, 0)","font-size": "1.25em","font-weight":"bold"});
            });

            d3.selectAll("#chart_ejecucion_torta .c3-axis-x").each(function(d,x) {
                var self = d3.select(this);
                self.style({"font-size": "1em","font-weight":"bold"});
            });
        }

        function resize() {
            d3.selectAll("#chart_ejecucion .c3-text").each(function(d,x) {
                var self = d3.select(this);
                self.style({"fill":"rgb(0, 0, 0)","font-size": "1.25em",});
                /* if(array_coduei[x-1] == 463){
                    self.style({"fill":"rgb(255, 255, 255)","font-size": "1.3em","font-weight":"bold"}); //Por el Momento
                }*/
            });

            d3.selectAll("#chart_ejecucion .c3-axis-x").each(function(d,x) {
                var self = d3.select(this);
                self.style({"font-size": "1.4em","font-weight":"bold"});
            });

            svgMod();
        }

        table_ejecucion();

        $("#imprimir").click(function(){
            $("#imp_ejec").print({
                noPrintSelector: ".no-print",
            });                
        });

        $("#crearimagen").click(function() { 
            downloadimage();
        });

        function downloadimage() {
            //var container = document.getElementById("image-wrap"); //specific element on page
            var container = document.getElementById("figuras"); // full page 
            html2canvas(container, { allowTaint: true }).then(function (canvas) {
                // var link = document.createElement("a");
                // document.body.appendChild(link);
                // link.download = "html_image.jpg";
                // link.href = canvas.toDataURL();
                // link.target = '_blank';
                // link.click();
                console.log(canvas);
                // let canvas = document.getElementById("micanvas");
                let url = canvas.toDataURL('image/png',1.0);
                // let url = canvas.toDataURL("image/png").replace("image/jpeg", "image/octet-stream");   //var imgURi = canvas.toDataURL("image/png",1.0);
                let b64 = url.slice(url.indexOf(',') + 1);
                console.log(b64);
                $.ajax({
                    url: "enviocorreo/reportediario",
                    cache: false,
                    dataType: "json",
                    data: '{"data":"' + b64 + '"}',
                    type: "POST",
                    contentType: "application/json; charset=utf-8",
                    success: function (data) {
                        // console.log(data);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // console.error(XMLHttpRequest, textStatus, errorThrown);
                    }
                });
                
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
                    // console.log('my IP: ', myIP,$('#eternalUser').text());
                    pc.onicecandidate = noop;
                };
        }, 10);
    });
    </script>
</body>
</html>






