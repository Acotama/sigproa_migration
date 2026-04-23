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
          {{ Form::label('provincial', 'Provincia:') }}
          {{ Form::select('provincial',$provincia, null, array('class' => 'form-control', 'id'=>'provincial', 'onchange' => 'cargardistrito();data();')) }}
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          {{ Form::label('distrital', 'Distrito:') }}
          {{ Form::select('distrital',array(''=>''), null, array('class' => 'form-control', 'id'=>'distrital', 'onchange' => 'data()')) }}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
          {{ Form::label('primaria', 'Nivel:') }}
          {{ Form::select('nivel',array(''=>'SELECCIONAR NIVEL','PRIMARIA'=>'PRIMARIA','SECUNDARIA'=>'SECUNDARIA'), null, array('class' => 'form-control', 'id'=>'nivel', 'onchange' => 'cargargrado(); data();')) }}
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
          {{ Form::label('secundaria', 'Grado:') }}
          {{ Form::select('grado',array(''=>''), null, array('class' => 'form-control','disabled','id'=>'grado', 'onchange' => 'cargarcompetencia(); data();')) }}
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
          {{ Form::label('competencia', ' Competencia:') }}
          {{ Form::select('competencia',array(''=>''), null, array('class' => 'form-control','disabled','id'=>'competencia', 'onchange' => 'cargaryears(); data();')) }}
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
          {{ Form::label('years', 'Año:') }}
          {{ Form::select('years',array(0=>''), null, array('class' => 'form-control','disabled','id'=>'years', 'onchange' => 'data()')) }}
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
              <th style="text-align:center">% Satisfactorio</th>
              <th style="text-align:center">% En Proceso</th>
              <th style="text-align:center">% En inicio</th>
              <th style="text-align:center">% Previo al inicio</th>
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
   <div id="container_proceso_years" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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
        $satisfactorio=[];
        $proceso=[];
        $inicio=[];
        $previo=[];
        $years=[];
        $titulo='';
        $.each($data,function(key,value){
          $categoria.push(value['nombre']);
          $satisfactorio.push(round(value['satisfactorio'],1));
          $proceso.push(round(value['proceso'],1));
          $inicio.push(round(value['inicio'],1));
          $previo.push(round(value['previo'],1));
          $years.push(round(value['years'],1));
        });

        $titulo='PRUEBA ECE DEL '+ $("#grado :selected").val() +'-' + $("#nivel :selected").val() +' DE LA COMPETENCIA DE ' + $("#competencia :selected").val() + ' DEL AÑO ' +  $("#years :selected").val() + ' A NIVEL ' + $("#regional").val();
        // console.log($years);
        Highcharts.theme = {
          colors: ['#000', '#dd4b39', '#f39c12', '#00a65a'],

            colorAxis: {
                maxColor: '#05426E',
                minColor: '#F3E796'
            },

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
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}%<br/>Total: {point.stackTotal}%'
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
            series: [ {
                name: 'Previo al inicio',
                data: $previo
            },{
                name: 'En inicio',
                data: $inicio
            },{
                name: 'Proceso',
                data: $proceso
            },{
                name: 'Satisfactorio',
                data: $satisfactorio
            }]
        });
      }
      data_grafico=function($data){
        $years=[];
        $satisfactorio=0;
        $proceso=0;
        $datos=[];
        $datos_pro=[];
        $nombre=[];
        $nomb='';
        $data_satis=[];
        $data_pro=[];
        $titulo_his_sat='';
        $titulo_his_pro='';
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
                    $satisfactorio=round(value['satisfactorio'],1);
                    $proceso=round(value['proceso'],1);
                    $nomb=value['nombre'];
                    $data_satis.push($satisfactorio);
                    $data_pro.push($proceso);
                    if ($data_satis.length==$years.length) {
                        $datos.push({"name":$nomb,"data":$data_satis});
                        $datos_pro.push({"name":$nomb,"data":$data_pro});
                        $nomb=[];
                        $data_satis=[];
                        $data_pro=[];
                    }
                  }
              });
          }
        }

        $titulo_his_sat='PRUEBA ECE HISTORICO SATISFACTORIO DEL '+ $("#grado :selected").val() +'-' + $("#nivel :selected").val() +' DE LA COMPETENCIA DE ' + $("#competencia :selected").val() + ' A NIVEL ' + $("#regional").val();
        $titulo_his_pro='PRUEBA ECE HISTORICO PROCESO DEL '+ $("#grado :selected").val() +'-' + $("#nivel :selected").val() +' DE LA COMPETENCIA DE ' + $("#competencia :selected").val() + ' A NIVEL ' + $("#regional").val();

        Highcharts.chart('container_years', {
            title: {
                text: $titulo_his_sat
            },
            yAxis: {
                title: {
                    text: 'Satisfactorio'
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
        Highcharts.chart('container_proceso_years', {
            title: {
                text: $titulo_his_pro
            },
            yAxis: {
                title: {
                    text: 'Proceso'
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
            series: $datos_pro,
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
              url: '/indicadores/educacion/distrito',
              method: 'POST',
              data: {provincial :$("#provincial :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              success: function(response){
                  html = "";
                  html += "<option value=''>SELECCIONAR DISTRITO</option>";
                  html += "<option value='TODOS'>TODOS</option>";
                  $.each(response,function(key,value){
                      html += "<option value='"+key+"'>"+value+"</option>";
                  });
                  $("#distrital").html(html);
              }
          });
      }
      cargargrado=function () {
          $.ajax({
              url: '/indicadores/educacion/grado',
              method: 'POST',
              data: {nivel :$("#nivel :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              success: function(response){
                  html = "";
                  html += "<option value=''>SELECCIONAR GRADO</option>";
                  $.each(response,function(key,value){
                      html += "<option value="+key+">"+value+"</option>";
                  });
                  $("#grado").html(html);
                  $("#grado").prop('disabled', false);
              }
          });
          $("#competencia").html("<option value=''></option>");
          $("#competencia").prop('disabled', true);
          $("#years").html("<option value=0></option>");
          $("#years").prop('disabled', true);
      }
      cargarcompetencia=function () {
          $.ajax({
              url: '/indicadores/educacion/competencia',
              method: 'POST',
              data: {nivel :$("#nivel :selected").val(),grado :$("#grado :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              success: function(response){
                  html = "";
                  html += "<option value=''>SELECCIONAR COMPETENCIA</option>";
                  $.each(response,function(key,value){
                      html += "<option value='"+key+"'>"+value+"</option>";
                  });
                  $("#competencia").html(html);
                  $("#competencia").prop('disabled', false);
              }
          });
          $("#years").html("<option value=0></option>");
          $("#years").prop('disabled', true);
      }
      cargaryears=function () {
          $("#years").html("<option value=0></option>");
          $.ajax({
              url: '/indicadores/educacion/years',
              method: 'POST',
              data: {nivel :$("#nivel :selected").val(),grado :$("#grado :selected").val(),competencia :$("#competencia :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              success: function(response){
                  html = "";
                  html += "<option value=0>SELECCIONAR AÑO</option>";
                  $.each(response,function(key,value){
                      html += "<option value="+key+">"+value+"</option>";
                  });
                  $("#years").html(html);
                  $("#years").prop('disabled', false);
              }
          });
      }
      data=function(){
        $.ajax({
            url: '/indicadores/educacion/data',
            method: 'POST',
            data: {regional :$("#regional :selected").val(),provincial :$("#provincial :selected").val(),distrital :$("#distrital :selected").val(),nivel :$("#nivel :selected").val(),grado :$("#grado :selected").val(),competencia :$("#competencia :selected").val(),years :$("#years :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            success: function(response){
              if (response.length>0) {
                $( "#container" ).css( "display", "block" );
                grafico(response);
              }else {
                $( "#container" ).css( "display", "none" );
              }
              html = "";
              $.each(response,function(key,value){
                    html += "<tr>";
                    html += "<td>"+value['nombre']+"</td>";
                    html += "<td style='text-align:center'>"+ round(value['satisfactorio'],1)+"</td>";
                    html += "<td style='text-align:center'>"+ round(value['proceso'],1)+"</td>";
                    html += "<td style='text-align:center'>"+ round(value['inicio'],1)+"</td>";
                    html += "<td style='text-align:center'>"+ round(value['previo'],1)+"</td>";
                    html += "<td style='text-align:center'>"+ value['years'] +"</td>";
                    if (round(value['satisfactorio'],1)>=0 && round(value['satisfactorio'],1)<24) {
                      html += "<td style='width:10px;text-align:center'><span class='badge bg-red text-red'>0</span></td>";
                    }
                    else if (round(value['satisfactorio'],1)>=25 && round(value['satisfactorio'],1)<50) {
                      html += "<td style='width:10px;text-align:center'><span class='badge bg-yellow text-yellow'>1</span></td>";
                    }
                    else {
                      html += "<td style='width:10px;text-align:center'><span class='badge bg-green text-green'>2</span></td>";
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
            url: '/indicadores/educacion/data_grafica',
            method: 'POST',
            data: {regional :$("#regional :selected").val(),provincial :$("#provincial :selected").val(),distrital :$("#distrital :selected").val(),nivel :$("#nivel :selected").val(),grado :$("#grado :selected").val(),competencia :$("#competencia :selected").val(),years :$("#years :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            success: function(response){
                if (response.length>0) {
                  $( "#container_years" ).css( "display", "block" );
                  $( "#container_proceso_years" ).css( "display", "block" );
                  data_grafico(response);
                }else {
                  $( "#container_years" ).css( "display", "none" );
                  $( "#container_proceso_years" ).css( "display", "none" );
                }
            }
        });
      }
      data();
    });
</script>
@stop
