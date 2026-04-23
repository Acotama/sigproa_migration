@extends('starter')
@section('htmlhead')
  <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
  <!-- <link href="https://cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css"  rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap4.min.css"  rel="stylesheet" type="text/css">

  <link  href="vendor/datatables/responsive.dataTables.min.css" rel="stylesheet" type="text/css">
  <link  href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"> -->
@endsection
@section('body')
<style media="screen">
    table.dataTable thead tr {
      background-color: #94e094;
    }
</style>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
          {{ Form::label('regional', 'Ambito:') }}
          {{ Form::select('regional',$nivel, null, array('class' => 'form-control', 'id'=>'regional', 'onchange' => 'data()')) }}
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          {{ Form::label('provincial', 'Provincial:') }}
          {{ Form::select('provincial',$provincia, null, array('class' => 'form-control', 'id'=>'provincial', 'onchange' => 'cargardistrito();data();')) }}
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          {{ Form::label('distrital', 'Distrital:') }}
          {{ Form::select('distrital',array(''=>''), null, array('class' => 'form-control', 'id'=>'distrital', 'onchange' => 'data()')) }}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
          {{ Form::label('years', 'Año:') }}
          {{ Form::select('years',$years, null, array('class' => 'form-control', 'id'=>'years', 'onchange' => 'data()')) }}
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          {{ Form::label('tipo', 'Tipo:') }}
          {{ Form::select('tipo',$tipo, null, array('class' => 'form-control', 'id'=>'tipo', 'onchange' => 'data()')) }}
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          {{ Form::label('edad', 'Edad:') }}
          {{ Form::select('edad',$edad, null, array('class' => 'form-control', 'id'=>'edad', 'onchange' => 'data()')) }}
      </div>
    </div>
  </div>
  <br>
  <div class="box">
      <!-- <div class="box-header">
        <h3 class="box-title">Por Distrito</h3>
      </div> -->
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered " id="table_indi" width="100%" cellspacing="0" class="form-control">
          <thead>
            <tr>
              <th>Nombre</th>
              <th style="text-align:center">Tipo</th>
              <th style="text-align:center">Resultado</th>
              <th style="text-align:center">N° Prueba</th>
              <th style="text-align:center">Año</th>
              <th style="text-align:center">Indicador</th>
            </tr>
          <thead>
          <tbody id="cuerpo">
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
  </div>
   <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
   <br>
   <div id="container_years" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

   <footer>
        <div class='define'>
            <p>Fuente : {{$fuente->fuente}}</p>
        </div>
    </footer>
   <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
   <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

   <script src="https://code.highcharts.com/highcharts.js"></script>
   <script src="https://code.highcharts.com/modules/exporting.js"></script>
   <script src="https://code.highcharts.com/modules/export-data.js"></script>
<!--
   <script type="text/javascript" src="vendor/datatables/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="vendor/datatables/dataTables.responsive.min.js"></script>
   <script type="text/javascript" src="vendor/datatables/dataTables.bootstrap4.min.js"></script> -->


<script type="text/javascript">
    $(function(){
      $("#provincial").prop('disabled', true);
      $("#distrital").prop('disabled', true);
      $("#regional").change(function()
      {
        $val=$("#regional").val();
        if ($val=='REGIONAL') {
          $("#provincial").prop('disabled', true);
          $("#distrital").prop('disabled', true);
        }
        else if ($val=='PROVINCIAL') {
          $("#provincial").prop('disabled', false);
          $("#distrital").prop('disabled', true);
          console.log($val);
        }
        else{
          $("#provincial").prop('disabled', false);
          $("#distrital").prop('disabled', false);
          console.log($val);
        }
      });
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
      Array.prototype.unique=function(a){
        return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
      });
      grafico=function($data){
        // console.log($data);
        $categoria=[];
        $valor=[];
        $years=[];
        $.each($data,function(key,value){
          $categoria.push(value['nombre']);
          $years.push(round(value['years'],1));
          if (round(value['resultado'],1)>=0 && round(value['resultado'],1)<=25) {
            $valor.push({"color":'#00a65a',"y":round(value['resultado'],1)});
          }
          else if (round(value['resultado'],1)>=26 && round(value['resultado'],1)<=50) {
            $valor.push({"color":'#f39c12',"y":round(value['resultado'],1)});
          }
          else {
            $valor.push({"color":'#dd4b39',"y":round(value['resultado'],1)});
          }

        });

        $titulo='PORCENTAJE DE PREVALENCIA DE '+ $("#tipo :selected").val() +' EN NIÑOS ' + $("#edad :selected").val() +' DE EDAD' + ' DEL AÑO ' +  $("#years :selected").val() + ' A NIVEL ' + $("#regional").val();

        Highcharts.theme = {

            colors: ['#dd4b39','#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            plotOptions: {
                map: {
                    nullColor: '#fcfefe'
                }
            },
            navigator: {
                maskFill: 'rgba(170, 205, 170, 0.5)',
                series: {
                    color: '#95C471',
                    lineColor: '#35729E'
                }
            }
        };
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: $titulo
            },
            xAxis: {
                categories: $categoria
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Porcentaje'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.setOptions(Highcharts.theme)  && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: $("#tipo :selected").val(),
                data: $valor
            }]
        });
      }
      data_grafico=function($data){
        $years=[];
        $valor;
        $datos=[];
        $datos_pro=[];
        $nombre=[];
        $nomb='';
        $data_val=[];
        $.each($data,function(key,value){
          $years.push(value['years']);
          $nombre.push(value['nombre']);
        });
        $nombre=$nombre.unique();
        $years=$years.unique();
        for (var e = 0; e < $nombre.length; e++) {
          for (var j = 0; j < $years.length; j++) {
              $.each($data,function(key,value){
                  if (value['years'] == $years[j]  && value['nombre'] == $nombre[e]) {
                    $valor=round(value['resultado'],1);
                    $nomb=value['nombre'];
                    $data_val.push($valor);
                    if ($data_val.length==$years.length) {
                        $datos.push({"name":$nomb,"data":$data_val});
                        $nomb=[];
                        $data_val=[];
                    }
                  }
              });
          }
        }

        $titulo_his='PORCENTAJE HISTORICO DE PREVALENCIA DE '+ $("#tipo :selected").val() +' EN NIÑOS ' + $("#edad :selected").val() +' DE EDAD' + ' DEL AÑO ' +  $("#years :selected").val() + ' A NIVEL ' + $("#regional").val();

        Highcharts.chart('container_years', {
            title: {
                text: $titulo_his
            },
            yAxis: {
                title: {
                    text: $("#tipo :selected").val(),
                }
            },
            xAxis: {
                categories: $years
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            tooltip: {
                headerFormat: '<b>AÑO {point.x}</b><br/>',
            },
            plotOptions: {
                 line: {
                     dataLabels: {
                         enabled: true
                     },
                     enableMouseTracking: false
                 }
             },
            series: $datos,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
      }
      cargardistrito=function () {
          $.ajax({
              url: '/indicadores/salud/distrito',
              method: 'POST',
              data: {provincial :$("#provincial :selected").val(),years :$("#years :selected").val(),opc :'hemoglobina'},
              tryCount : 0,
              retryLimit : 3,
              success: function(response){
                  html = "";
                  html += "<option value=''>SELECCIONAR DISTRITO</option>";
                  html += "<option value='TODOS'>TODOS</option>";
                  $.each(response,function(key,value){
                      html += "<option value="+key+">"+value+"</option>";
                  });
                  $("#distrital").html(html);
              }
          });
      }
      data=function(){
        $.ajax({
            url: '/indicadores/salud/hemoglobina_data',
            method: 'POST',
            data: {regional :$("#regional :selected").val(),provincial :$("#provincial :selected").val(),distrital :$("#distrital :selected").val(),tipo :$("#tipo :selected").val(),years :$("#years :selected").val(),edad :$("#edad :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            success: function(response){
              grafico(response);
              html = "";
              $.each(response,function(key,value){
                    html += "<tr>";
                    html += "<td>"+value['nombre']+"</td>";
                    html += "<td style='text-align:center'>"+ value['tipo'] +"</td>";
                    html += "<td style='text-align:center'>"+ round(value['resultado'],1)+"</td>";
                    html += "<td style='text-align:center'>"+ value['n_prueba'] +"</td>";
                    html += "<td style='text-align:center'>"+ value['years'] +"</td>";
                    if (round(value['resultado'],1)>=0 && round(value['resultado'],1)<=25) {
                      html += "<td style='width:10px;text-align:center'><span class='badge bg-green text-green'>0</span></td>";
                    }
                    else if (round(value['resultado'],1)>=26 && round(value['resultado'],1)<=51) {
                      html += "<td style='width:10px;text-align:center'><span class='badge bg-yellow text-yellow'>1</span></td>";
                    }
                    else {
                      html += "<td style='width:10px;text-align:center'><span class='badge bg-red text-red'>2</span></td>";
                    }
                    html += "</tr>";
              });

              if ( ! $.fn.DataTable.isDataTable( '#table_indi' ) ) {
                $("#cuerpo").html(html);
                $('#table_indi').DataTable({
                    processing: true,
                    bPaginate: true,
                    // bLengthChange: true,
                    bFilter: true,
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    responsive:true,
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
                    }
                });
                // console.log('creado');
              }else {
                $('#table_indi').DataTable().destroy();
                $("#cuerpo").html(html);
                $('#table_indi').DataTable({
                    processing: true,
                    bPaginate: true,
                    bLengthChange: true,
                    bFilter: true,
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    responsive:true,
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
                    }
                });
                // console.log('borado,creado');
              }

            }
        });
        $.ajax({
            url: '/indicadores/salud/hemoglobina_grafica',
            method: 'POST',
            data: {regional :$("#regional :selected").val(),provincial :$("#provincial :selected").val(),distrital :$("#distrital :selected").val(),tipo :$("#tipo :selected").val(),edad :$("#edad :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            success: function(response){
              data_grafico(response);
            }
        });
      }
      data();
    });
</script>
@stop
