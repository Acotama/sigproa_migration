@extends('starter')
@section('htmlhead')
  <link href="https://cdn.webdatarocks.com/latest/webdatarocks.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <!-- <link rel="stylesheet" type="text/css" href="theme/original-theme/webdatarocks.css" /> -->


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
<button class="btn-customize" onclick="loadReport()">Customize cells</button>

<!-- <button onclick="saveReport()">Datos</button> -->
<!-- <button onclick="exportData('excel')">Datos</button> -->

<form action="/prueba/guardar" method="post" enctype="multipart/form-data">
    <input type="file" name="archivo">
    <input type="submit" value="Importar">
</form>
<h4>{{isset($msg)?$msg:'' }}</h4>

<div id="wdr-component"></div>
<div id="contenedor">

</div>
<div id="highchartsContainer"style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<div id="highchartslin"style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>


<script src="https://cdn.webdatarocks.com/latest/webdatarocks.toolbar.min.js"></script>
<script src="https://cdn.webdatarocks.com/latest/webdatarocks.js"></script>
<script src="https://cdn.webdatarocks.com/latest/webdatarocks.highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script type="text/javascript">
    var final=0;
    var pivot = new WebDataRocks({
          container: "#wdr-component",
          toolbar: true,
          width: "100%",
          height: 1000,
          customizeCell: customizeCellFunction,
          report: {
      		localization: "https://raw.githubusercontent.com/WebDataRocks/pivot-localizations/master/es.json",
            "slice": {
              "reportFilters": [
                  {
                      "uniqueName": "fase",
                      "filter": {
                          "members": [
                              "fase.DEVENGADO"
                          ]
                      }
                  }
              ],
              "rows": [
                  {
                      "uniqueName": "ejecutora",
                      "caption": "UNIDAD EJECUTORA"
                  },
                  {
                      "uniqueName": "gen_gastos",
                      "caption": "GENERICA DE GASTOS"
                  },
                  {
                      "uniqueName": "presupuestal",
                      "caption": "PIA"
                  },
                  {
                      "uniqueName": "producto",
                      "caption": "PRODUCTO"
                  },
                  {
                      "uniqueName": "actividad",
                      "caption": "ACTIVIDAD"
                  },
                  {
                      "uniqueName": "financiamiento",
                      "caption": "FINANCIAMIENTO"
                  },
                  {
                      "uniqueName": "funcion",
                      "caption": "FUNCIÓN/SECTOR"
                  },
                  {
                      "uniqueName": "provincia",
                      "caption": "PROVINCIA"
                  }

              ],
              "columns": [
                  {
                      "uniqueName": "Measures"
                  }
              ],
              "measures": [
                  {
                      "uniqueName": "PIA",
                      "formula": "sum(\"presupuesto\") ",
                      "caption": "PIA"
                  },
                  {
                      "uniqueName": "PIM",
                      "formula": "sum(\"pim\") ",
                      "caption": "PIM"
                  },
                  {
                      "uniqueName": "EJECUCION",
                      "formula": "sum(\"ejecucion\") ",
                      "caption": "EJECUCIÓN",
                      "format": "3jxouse1"
                  },
                  {
                      "uniqueName": "Avance %",
                      "formula": "if( sum(\"pim\") == 0,0 ,sum(\"ejecucion\") / sum(\"pim\") )",
                      "caption": "AVANCE %",
                      "format": "3jx51yjk"
                  },
                  {
                      "uniqueName": "Semaforo",
                      "formula": "sum(\"Avance %\") - ((100/12)*max(\"mes\"))",
                      "caption": "SEMAFORO",
                      "format": "3jx5aaa9"
                  }
              ],
            },
            "options": {
                "grid": {
                    "showTotals": "columns",
                    "showGrandTotals": "columns"
                }
            },
            "formats": [
                {
                    "name": "3jx4lk8s",
                    "thousandsSeparator": " ",
                    "decimalSeparator": ".",
                    "decimalPlaces": 2,
                    "currencySymbol": "",
                    "currencySymbolAlign": "left",
                    "nullValue": "",
                    "textAlign": "right",
                    "isPercent": false
                },
                {
                    "name": "3jx51yjk",
                    "thousandsSeparator": " ",
                    "decimalSeparator": ".",
                    "decimalPlaces": 2,
                    "currencySymbol": "",
                    "currencySymbolAlign": "left",
                    "nullValue": "0",
                    "textAlign": "right",
                    "isPercent": true
                },
                {
                    "name": "3jx5aaa9",
                    "thousandsSeparator": " ",
                    "decimalSeparator": ".",
                    "decimalPlaces": 2,
                    "currencySymbol": "",
                    "currencySymbolAlign": "left",
                    "nullValue": "",
                    "textAlign": "right",
                    "isPercent": false
                },
                {
                    "name": "3jxouse1",
                    "thousandsSeparator": " ",
                    "decimalSeparator": ".",
                    "decimalPlaces": 2,
                    "currencySymbol": "",
                    "currencySymbolAlign": "left",
                    "nullValue": "",
                    "textAlign": "right",
                    "isPercent": false
                }
            ],
            "tableSizes": {
                "columns": [
                    {
                        "idx": 0,
                        "width": 365
                    }
                ]
            },
          },
          reportcomplete: function() {
              pivot.off("reportcomplete");
              final=1;
              // createChart();
          }
    });

    webdatarocks.load("json/consulta_siaf.json");
    // pivot.customizeCell(customizeCellFunction);


    var id;
    function customizeCellFunction(cell, data) {
        if (data.type == "value"  && data.isGrandTotalColumn) {
          if(data.measure.uniqueName == "Semaforo")
          {
            id=data.columnIndex;
          }
        }

        if (data.type == "value" ) {
              if(data.columnIndex == id && data.label != "" ){
                if (data.value >= 0) {
                    cell.text = "<img src='{{ asset('icon/arriba.png') }}' class='centered'>";
                } else if (data.value < 0 && data.value >= -8.3) {
                    cell.text = "<img src='{{ asset('icon/medio.png') }}' class='centered'>";
                }
                else{
                   cell.text = "<img src='{{ asset('icon/abajo.png') }}' class='centered'>";
                 }
              }
        }
        // else if (data.type == "header" && !data.isGrandTotalColumn && !data.isGrandTotal) {
        //   if (true) {
        //
        //   }
        //   if (final==0) {
        //     console.log(final);
        //     final=2;
        //   }else if (final==1) {
        //     console.log(final);
        //     final=2;
        //   }
        //   webdatarocks.getData({}, function(data)
        //   {
        //     console.log(data)
        //   });
        //     // console.log(data);
        // }
    }

    Highcharts.theme= {
        colors: ['#f45b5b',
        '#8085e9',
        '#8d4654',
        '#7798BF',
        '#aaeeee',
        '#ff0066',
        '#eeaaee',
        '#55BF3B',
        '#DF5353',
        '#7798BF',
        '#aaeeee'],
        chart: {
            backgroundColor: null,
            style: {
                fontFamily: 'Open Sans', fontWeight: 'bold'
            }
        }
        ,
        title: {
            style: {
                color: 'black', fontSize: '16px', fontWeight: 'bold', fontFamily: 'Open Sans'
            }
        }
        ,
        subtitle: {
            style: {
                color: 'black', fontSize: '18px', fontWeight: 'bold', fontFamily: 'Open Sans'
            }
        }
        ,
        tooltip: {
            borderWidth: 0
        }
        ,
        legend: {
            itemStyle: {
                fontWeight: 'bold', fontSize: '13px'
            }
        }
        ,
        xAxis: {
            labels: {
                style: {
                    color: '#6e6e70'
                }
            }
        }
        ,
        yAxis: {
            labels: {
                style: {
                    color: '#6e6e70'
                }
            }
        }
        ,
        plotOptions: {
            series: {
                shadow: true
            }
            ,
            candlestick: {
                lineColor: '#404048'
            }
            ,
            map: {
                shadow: false
            }
        }
        , // Highstock specific
        navigator: {
            xAxis: {
                gridLineColor: '#D0D0D8'
            }
        }
        ,
        rangeSelector: {
            buttonTheme: {
                fill: 'white',
                stroke: '#C0C0C8',
                'stroke-width': 1,
                states: {
                    select: {
                        fill: '#D0D0D8'
                    }
                }
            }
        }
        ,
        scrollbar: {
            trackBorderColor: '#C0C0C8'
        }
        , // General
        background2: '#E0E0E8'
    };

    // apply the theme
    Highcharts.setOptions(Highcharts.theme);
    function createChart() {
        pivot.highcharts.getData({
            type: "column"
        }, function(data) {
            console.log(data);
            Highcharts.setOptions({
                subtitle: {
                    text: 'Sales by Countries'
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.y} $'
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                }
            });

            Highcharts.chart("highchartsContainer", data);

        });
    }

</script>

@stop
