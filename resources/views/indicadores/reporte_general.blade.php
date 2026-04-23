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
  <br>
  <div class="row">
    <div class="col-md-12">
          <div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">EDUCACIÓN</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" id="box_id_edu">
              <div id="grafico_ece">

              </div>
            </div>
          </div>
    </div>
    <div class="col-md-12">
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">SALUD</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" id="box_id_salud">
              <!-- <div id="1">

              </div> -->
            </div>
          </div>
    </div>
    <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">POBREZA</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" id="box_id_pobreza">
              <div id="pobreza">

              </div>
            </div>
          </div>
    </div>
  </div>

   <div id="container_years" style="  min-width: 380px; max-width: 400px; height: 400px; margin: 0 auto"></div>

   <footer>
        <div class='define'>
            <!-- <p>Fuente : </p> -->
        </div>
    </footer>
   <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
   <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

   <script src="https://code.highcharts.com/highcharts.js"></script>
   <script src="https://code.highcharts.com/modules/exporting.js"></script>
   <script src="https://code.highcharts.com/modules/export-data.js"></script>
   <script src="https://code.highcharts.com/highcharts-more.js"></script>
   <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
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


      dibujar_row=function($box,$row,$data,$opc){
        $("#"+$row).remove();
        $("#"+$box).append("<div id='" + $row + "'></div>");
        $valor=0;
        $contenedor=[];
        $val=0;
        $print="";
        $print_fin="";
        $text=[]
        $rest=0;
        for (var i = 0; i < $data.length; i++) {
          $val=$data.length-(i+1);
          $print="<div class='col-md-4'>"+
                      "<div id='" + $row +"_"+ $val + "'" + " style='margin: 0 auto;max-width: 400px;min-width: 310px;'></div>"+
                  "</div>";
          $text.unshift($print);
          $contenedor.push($row +"_"+ $val);
          if($val % 3==0) {
            $.each($text,function(key,value){
              $print_fin+=value;
            });
            $("#"+$row).prepend("<div class='row'>"+$print_fin+"</div>");
            $text=[];
            $print_fin="";
            $print="";
          }
        }
        $.each($data,function(key,value){
          $rest=$data.length - (key +1);
          if ($opc == "educacion") {
            grafico_dibujar_ece($contenedor[$rest],value);
          }
          else if ($opc == "pobreza") {
            grafico_dibujar_pobreza($contenedor[$rest],value);
          }
          else if ($opc == "salud") {
            grafico_dibujar_salud($contenedor[$rest],value);
          }

        });
      }

      grafico_dibujar_ece=function($contenedor,$value){

        $titulo="EDUCACIÓN "+ $value['nivel'] + " DEL " + $value['grado'] + " " + $value['competencia'] + " " + $value['years'];
        $data_val=[];
        $datas=[];
        if ($value['satisfactorio_reg']!=null) {
          $data_val.push({"color":Highcharts.getOptions().colors[0],"radius":'112%',"innerRadius":'88%',"y": round($value['satisfactorio_reg'],1)});
          $datas.push({"name":$value['regional'],"data":$data_val});
          $data_val=[];
          if ($value['satisfactorio_prov']!=null) {
            $data_val.push({"color":Highcharts.getOptions().colors[1],"radius":'87%',"innerRadius":'63%',"y": round($value['satisfactorio_prov'],1)});
            $datas.push({"name":$value['provincia'],"data":$data_val});
            $data_val=[];
            if ($value['satisfactorio_dist']!=null) {
              $data_val.push({"color":"#f39c12","radius":'62%',"innerRadius":'38%',"y": round($value['satisfactorio_dist'],1)});
              $datas.push({"name":$value['distrito'],"data":$data_val});
            }
          }
        }
        grafico_espiral($contenedor,$titulo,$datas);
      }
      grafico_dibujar_pobreza=function($contenedor,$value){

        $titulo="POBREZA AÑO " + $value['years'];
        $data_val=[];
        $datas=[];
        if ($value['promedio_reg']!=null) {
          $data_val.push({"color":Highcharts.getOptions().colors[0],"radius":'112%',"innerRadius":'88%',"y": round($value['promedio_reg'],1)});
          $datas.push({"name":$value['regional'],"data":$data_val});
          $data_val=[];
          if ($value['promedio_prov']!=null) {
            $data_val.push({"color":Highcharts.getOptions().colors[1],"radius":'87%',"innerRadius":'63%',"y": round($value['promedio_prov'],1)});
            $datas.push({"name":$value['provincia'],"data":$data_val});
            $data_val=[];
            if ($value['promedio_dist']!=null) {
              $data_val.push({"color":"#f39c12","radius":'62%',"innerRadius":'38%',"y": round($value['promedio_dist'],1)});
              $datas.push({"name":$value['distrito'],"data":$data_val});
            }
          }
        }
        grafico_espiral($contenedor,$titulo,$datas);
      }
      grafico_dibujar_salud=function($contenedor,$value){

        $titulo=$value['tipo'] + " AÑO  " + $value['years'];
        $data_val=[];
        $datas=[];
        if ($value['valor_reg']!=null) {
          $data_val.push({"color":Highcharts.getOptions().colors[0],"radius":'112%',"innerRadius":'88%',"y": round($value['valor_reg'],1)});
          $datas.push({"name":$value['regional'],"data":$data_val});
          $data_val=[];
          if ($value['valor_prov']!=null) {
            $data_val.push({"color":Highcharts.getOptions().colors[1],"radius":'87%',"innerRadius":'63%',"y": round($value['valor_prov'],1)});
            $datas.push({"name":$value['provincia'],"data":$data_val});
            $data_val=[];
            if ($value['valor_dist']!=null) {
              $data_val.push({"color":"#f39c12","radius":'62%',"innerRadius":'38%',"y": round($value['valor_dist'],1)});
              $datas.push({"name":$value['distrito'],"data":$data_val});
            }
          }
        }
        grafico_espiral($contenedor,$titulo,$datas);
      }

      grafico_espiral=function($contenedor,$titulo,$datas) {
        Highcharts.chart($contenedor, {
            chart: {
                type: 'solidgauge',
                height: '80%'
            },
            title: {
                text: $titulo,
                style: {
                    fontSize: '12px'
                }
            },
            tooltip: {
                borderWidth: 0,
                backgroundColor: 'none',
                shadow: false,
                style: {
                    fontSize: '10px'
                },
                pointFormat: '{series.name}<br><span style="font-size:1.8em; color: {point.color}; font-weight: bold">{point.y}%</span>',
                positioner: function (labelWidth) {
                    return {
                        x: (this.chart.chartWidth - labelWidth) / 2,
                        y: (this.chart.plotHeight / 2) + 15
                    };
                }
            },
            pane: {
                startAngle: 0,
                endAngle: 360,
                background: [{ // Track for Move
                    outerRadius: '112%',
                    innerRadius: '88%',
                    backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[0])
                        .setOpacity(0.3)
                        .get(),
                    borderWidth: 0
                }, { // Track for Exercise
                    outerRadius: '87%',
                    innerRadius: '63%',
                    backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[1])
                        .setOpacity(0.3)
                        .get(),
                    borderWidth: 0
                }, { // Track for Stand
                    outerRadius: '62%',
                    innerRadius: '38%',
                    backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[2])
                        .setOpacity(0.3)
                        .get(),
                    borderWidth: 0
                }]
            },

            yAxis: {
                min: 0,
                max: 100,
                lineWidth: 0,
                tickPositions: []
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        enabled: false
                    },
                    linecap: 'round',
                    stickyTracking: false,
                    rounded: true
                }
            },
            series: $datas
        });
      }

      data_grafico=function($data){
      }
      cargardistrito=function () {
          $.ajax({
              url: '/indicadores/reporte_general/distrito',
              method: 'POST',
              data: {provincial :$("#provincial :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              success: function(response){
                  html = "";
                  html += "<option value=''>SELECCIONAR DISTRITO</option>";
                  $.each(response,function(key,value){
                      html += "<option value="+key+">"+value+"</option>";
                  });
                  $("#distrital").html(html);
              }
          });
      }
      data=function(){
        $.ajax({
            url: '/indicadores/reporte_general/data',
            method: 'POST',
            data: {regional :$("#regional :selected").val(),provincial :$("#provincial :selected").val(),distrital :$("#distrital :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            success: function(response){
              dibujar_row("box_id_edu","grafico_ece",response,"educacion");
            }
        });
        $.ajax({
            url: '/indicadores/reporte_general/data_pobreza',
            method: 'POST',
            data: {regional :$("#regional :selected").val(),provincial :$("#provincial :selected").val(),distrital :$("#distrital :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            success: function(response){
              dibujar_row("box_id_pobreza","pobreza",response,"pobreza");
            }
        });
        $.ajax({
            url: '/indicadores/reporte_general/data_salud',
            method: 'POST',
            data: {regional :$("#regional :selected").val(),provincial :$("#provincial :selected").val(),distrital :$("#distrital :selected").val()},
            tryCount : 0,
            retryLimit : 3,
            success: function(response){
              dibujar_row("box_id_salud","salud",response,"salud");
            }
        });
      }
      data();
    });
</script>
@stop
