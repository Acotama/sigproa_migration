@extends('starter')
@section('htmlhead')
  <!-- <link href="https://cdn.flexmonster.com/latest/flexmonster.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> -->
  <!-- <link rel="stylesheet" type="text/css" href="theme/original-theme/flexmonster.css" /> -->

  <script src="{{ asset('tabla_dinamica/flexmonster.js')}}"></script>
  <!-- <link href="{{ asset('tabla_dinamica/flexmonster.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('tabla_dinamica/flexmonster.toolbar.js')}}"></script> -->
@endsection
@section('body')
<style>
      img.centered {
        margin: auto !important;
        padding-bottom: 10px;
        color: transparent !important;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        font-size: 12px;
        position: relative;
        bottom: 4px;
        left: 6px;
    }

    button {
      border: 2px solid #0598df;
      background: #fff;
      color: #0598df;
      text-transform: uppercase;
      cursor: pointer;
      margin: 5px 0;
      display: inline-block;
      -webkit-transition: all .3s;
      transition: all .3s;
      font-weight: normal;
      padding: 10px 10px;
      font-size: 14px;
    }

    button:hover {
      background: #0598df;
      color: #fff;
    }

    button:focus {
      outline: none;
    }
</style>

<div id="wdr-component"></div>
<div id="contenedor"></div>
<br>
<span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Fuente: SIAF (Actualizado al  @foreach($fecha as $link)  {{$link->fecha}} @endforeach)</span>
<div class="row">
  <div class="col-md-12">
    <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Descripción del semaforo</span>
    <br>
    <img src="{{ asset('icon/arriba.png') }}" style="width:20px"> Cumplio la Meta Mensual Satisfactoriamente <br>
    <img src="{{ asset('icon/medio.png') }}" style="width:20px"> Retraso de la Meta por lo menos un Mes  <br>
    <img src="{{ asset('icon/abajo.png') }}" style="width:20px"> Retraso de la Meta por más de un Mes  <br>
  </div>
</div>
<br>
<div id="highchartsContainer"style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<br><br>
<div id="highchartslin"style="min-width: 300px; height: 400px; margin: 0 auto"></div>



<!-- <script src="https://cdn.flexmonster.com/latest/flexmonster.toolbar.min.js"></script>
<script src="https://cdn.flexmonster.com/latest/flexmonster.js"></script>
<script src="https://cdn.flexmonster.com/latest/flexmonster.highcharts.js"></script> -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>


<script type="text/javascript">

  var final=0;
  var pivot = new Flexmonster({
        container: "wdr-component",
        componentFolder: "https://cdn.flexmonster.com/",
        localization: "https://raw.githubusercontent.com/WebDataRocks/pivot-localizations/master/es.json",
        toolbar: true,
        width: "100%",
        height: 1000,
        licenseKey: "Z7OB-XCII5O-411A4Q-5N4B49",
        customizeCell: customizeCellFunction,
        sorting:"on",
        reportcomplete: function() {
          // pivot.off("reportcomplete");
        }
  });

  flexmonster.load("json/consulta_siaf.json");

    var categorias=[];
    var pim=[];
    var ejecucion=[];
    var avance=[];
    var level;
    var level_a=[];
    var nombrecolum;
    var a1=0;
    var r=0;
    var titulo="";
    var titulo_a="";
    // flexmonster.on('update', function() {
    //   if (r==0) {
    //     flexmonster.getData({}, function(data)
    //     {
    //       for (var i = 1; i < data.data.length; i++) {
    //         categorias.push(data.data[i].r0);
    //         pim.push(data.data[i].v1);
    //         ejecucion.push(data.data[i].v2);
    //         avance.push(data.data[i].v3*100);
    //       }
    //       console.log(flexmonster.getFilter('TIPO').members[0]['tipo']);
    //       if (flexmonster.getFilter('TIPO').members[0]=='tipo.[actividad]'=='ACTIVIDAD'){
    //         titulo='EJECUCIÓN FINANCIERA DE LAS ACTIVIDADES DEL GOBIERNO REGIONAL DE LIMA';
    //         titulo_a='AVANCE FINANCIERA DE LAS ACTIVIDADES DEL GOBIERNO REGIONAL DE LIMA';
    //       }else {
    //         titulo='EJECUCIÓN FINANCIERO DE LOS PROYECTOS DEL GOBIERNO REGIONAL DE LIMA';
    //         titulo_a='AVANCE FINANCIERO DE LOS PROYECTOS DEL GOBIERNO REGIONAL DE LIMA';
    //       }
    //       createChart(flexmonster.getFilter('FASE').members[0],categorias,pim,ejecucion,titulo);
    //       avancechart(flexmonster.getFilter('FASE').members[0],categorias,avance,titulo);
    //       categorias=[];
    //       pim=[];
    //       ejecucion=[];
    //       avance=[];
    //     });
    //     r=1;
    //   }
    // });
    //
    // flexmonster.on('cellclick', function(click) {
    //   // console.log(click);
    //   // console.log(nombrecolum);
    //   // console.log(level);
    //   if (click.columnIndex == 0 && click.type == "header") {
    //     nombrecolum=click.label;
    //     level=click.level;
    //     flexmonster.getData({}, function(data)
    //     {
    //       level_a.push(data.data.length);
    //       if (level_a.length==2) {
    //         if (level_a[1] > level_a[0]) {
    //           a1=1; //expandido
    //         }else {
    //           a1=0; //sin expandir
    //         }
    //         level_a.shift();
    //       }
    //       else {
    //           a1=1;
    //       }
    //
    //       // desg.push(data);
    //
    //       // console.log(data);
    //       // console.log("level : " + level);
    //       // console.log("expandir 1: " + a1);
    //       // console.log(nombrecolum);
    //       // console.log(data);
    //       for (var i = 1; i < data.data.length; i++) {
    //         if (a1==1) {
    //            if (data.data[i].r0 == nombrecolum) {
    //              if (data.data[i].r1 != null) {
    //                categorias.push(data.data[i].r1);
    //                pim.push(data.data[i].v1);
    //                ejecucion.push(data.data[i].v2);
    //                avance.push(data.data[i].v3*100);
    //              }
    //           }else if (data.data[i].r1 == nombrecolum) {
    //                 if (data.data[i].r2 != null) {
    //                   categorias.push(data.data[i].r2);
    //                   pim.push(data.data[i].v1);
    //                   ejecucion.push(data.data[i].v2);
    //                   avance.push(data.data[i].v3*100);
    //                 }
    //           }else if (data.data[i].r2 == nombrecolum) {
    //                if (data.data[i].r3 != null) {
    //                  categorias.push(data.data[i].r3);
    //                  pim.push(data.data[i].v1);
    //                  ejecucion.push(data.data[i].v2);
    //                  avance.push(data.data[i].v3*100);
    //                }
    //           }else if (data.data[i].r3 == nombrecolum) {
    //               if (data.data[i].r4 != null) {
    //                 categorias.push(data.data[i].r4);
    //                 pim.push(data.data[i].v1);
    //                 ejecucion.push(data.data[i].v2);
    //                 avance.push(data.data[i].v3*100);
    //               }
    //           }else if (data.data[i].r4 == nombrecolum) {
    //              if (data.data[i].r5 != null) {
    //                categorias.push(data.data[i].r5);
    //                pim.push(data.data[i].v1);
    //                ejecucion.push(data.data[i].v2);
    //                avance.push(data.data[i].v3*100);
    //              }
    //           }else if (data.data[i].r5 == nombrecolum) {
    //              if (data.data[i].r6 != null) {
    //                categorias.push(data.data[i].r6);
    //                pim.push(data.data[i].v1);
    //                ejecucion.push(data.data[i].v2);
    //                avance.push(data.data[i].v3*100);
    //              }
    //           }else if (data.data[i].r6 == nombrecolum) {
    //              if (data.data[i].r7 != null) {
    //                categorias.push(data.data[i].r7);
    //                pim.push(data.data[i].v1);
    //                ejecucion.push(data.data[i].v2);
    //                avance.push(data.data[i].v3*100);
    //              }
    //           }else if (data.data[i].r7 == nombrecolum) {
    //              if (data.data[i].r8 != null) {
    //                categorias.push(data.data[i].r8);
    //                pim.push(data.data[i].v1);
    //                ejecucion.push(data.data[i].v2);
    //                avance.push(data.data[i].v3*100);
    //              }
    //           }else if (data.data[i].r8 == nombrecolum) {
    //              if (data.data[i].r9 != null) {
    //                categorias.push(data.data[i].r9);
    //                pim.push(data.data[i].v1);
    //                ejecucion.push(data.data[i].v2);
    //                avance.push(data.data[i].v3*100);
    //              }
    //           }
    //         }else if (a1==0) {
    //           if (level==0 && data.data[i].r0 != null) {
    //             categorias.push(data.data[i].r0);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==1 && data.data[i].r1 != null) {
    //             categorias.push(data.data[i].r1);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==2 && data.data[i].r2 != null) {
    //             categorias.push(data.data[i].r2);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==3 && data.data[i].r3 != null) {
    //             categorias.push(data.data[i].r3);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==4 && data.data[i].r4 != null) {
    //             categorias.push(data.data[i].r4);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==5 && data.data[i].r5 != null) {
    //             categorias.push(data.data[i].r5);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==6 && data.data[i].r6 != null) {
    //             categorias.push(data.data[i].r6);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==7 && data.data[i].r7 != null) {
    //             categorias.push(data.data[i].r7);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==8 && data.data[i].r8 != null) {
    //             categorias.push(data.data[i].r8);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }else if (level==9 && data.data[i].r9 != null) {
    //             categorias.push(data.data[i].r9);
    //             pim.push(data.data[i].v1);
    //             ejecucion.push(data.data[i].v2);
    //             avance.push(data.data[i].v3*100);
    //           }
    //
    //         }
    //       }
    //       // console.log(categorias);
    //       // categorias.clean(null);
    //       // console.log(categorias);
    //       // console.log(pim);
    //       // console.log(ejecucion);
    //       if (flexmonster.getFilter('TIPO').members[0]=='ACTIVIDAD') {
    //         titulo='EJECUCIÓN FINANCIERA DE LAS ACTIVIDADES DEL GOBIERNO REGIONAL DE LIMA';
    //         titulo_a='AVANCE FINANCIERA DE LAS ACTIVIDADES DEL GOBIERNO REGIONAL DE LIMA';
    //       }else {
    //         titulo='EJECUCIÓN FINANCIERO DE LOS PROYECTOS DEL GOBIERNO REGIONAL DE LIMA';
    //         titulo_a='AVANCE FINANCIERO DE LOS PROYECTOS DEL GOBIERNO REGIONAL DE LIMA';
    //       }
    //       createChart(flexmonster.getFilter('FASE').members[0],categorias,pim,ejecucion,titulo);
    //       avancechart(flexmonster.getFilter('FASE').members[0],categorias,avance,titulo);
    //       // console.log(categorias);
    //       categorias=[];
    //       pim=[];
    //       ejecucion=[];
    //       avance=[];
    //       nombrecolum="";
    //     });
    //   }
    // });

    function createChart(namec, categoria,pim,ejecucion,titulo) {
      Highcharts.chart('highchartsContainer', {
        chart: {
          type: 'column'
        },
        title: {
          text: titulo
        },
        xAxis: {
          categories:categoria,
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Soles'
          }
        },
        tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: [{
          name: 'PIM',
          data: pim

        }, {
          name: namec,
          data: ejecucion

        }]
      });
    }
    function avancechart(namec, categoria,avance,titulo) {
      Highcharts.chart('highchartslin', {
        chart: {
          type: 'column'
        },
        title: {
          text: titulo
        },
        xAxis: {
          categories:categoria,
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Porcentaje'
          }
        },
        tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f}%</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: [{
          name: 'AVANCE',
          data: avance
        }]
      });
    }

    pivot.customizeCell(customizeCellFunction);
    var id;
    var columrow;
    var row=[];
    var level;
    function customizeCellFunction(cell, celldata) {

        if (celldata.type == "value"  && celldata.isGrandTotalColumn) {
          if(celldata.measure.uniqueName == "Semaforo")
          {
            id=celldata.columnIndex;
          }
        }
        if (celldata.type == "value" ) {
              if(celldata.columnIndex == id && celldata.label != "" ){
                if (celldata.value >= 0) {
                    cell.text = "<img src='{{ asset('icon/arriba.png') }}' class='centered'>";
                } else if (celldata.value < 0 && celldata.value >= -8.3) {
                    cell.text = "<img src='{{ asset('icon/medio.png') }}' class='centered'>";
                }
                else{
                   cell.text = "<img src='{{ asset('icon/abajo.png') }}' class='centered'>";
                 }
              }
        }
    }


</script>

@stop
