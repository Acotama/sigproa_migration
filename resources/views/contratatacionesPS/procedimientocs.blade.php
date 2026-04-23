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

        #jnav ul{height:700px; width:100%;}
        #jnav ul{overflow:hidden; overflow-y:scroll;}
        .sweetalert-lg{
            width: 900px !important;
        }
        .imgContainer {
            position: relative;
            width: 100%;
        }

        .imgContainer .image {
          opacity: 1;
          display: block;
          width: 100%;
          height: 400px;
          transition: .5s ease;
          backface-visibility: hidden;
        }

        .imgContainer .middle {
          transition: .5s ease;
          opacity: 0;
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          -ms-transform: translate(-50%, -50%)
        }

        .imgContainer:hover .image {
          opacity: 0.3;
        }

        .imgContainer:hover .middle {
          opacity: 1;
        }

        .imgContainer .text {
          background-color: #4CAF50;
          color: white;
          font-size: 16px;
          padding: 16px 32px;
        }
    </style>
@endsection

@section('body')
<style type="text/css">

      button.dt-button, div.dt-button, a.dt-button{
        background: #337ab7 !important;
        color: #fff;
      }
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

      .scrollbar
      {
        float: left;
        height: 300px;
        background: #F5F5F5;
        overflow-y: scroll;
        margin-bottom: 25px;
      }

      .force-overflow
      {
        min-height: 450px;
      }


      /*
       *  STYLE 3
       */

      #style-3::-webkit-scrollbar-track
      {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
      }

      #style-3::-webkit-scrollbar
      {
        width: 6px;
        background-color: #F5F5F5;
      }

      #style-3::-webkit-scrollbar-thumb
      {
        background-color: #000000;
      }


        .nav-side-menu {
          overflow: auto;
          font-family: verdana;
          font-size: 12px;
          font-weight: 200;
          background-color: #2e353d;
          position: fixed;
          top: 0px;
          width: 300px;
          height: 100%;
          color: #e1ffff;
        }
        .nav-side-menu .brand {
          background-color: #23282e;
          line-height: 50px;
          display: block;
          text-align: center;
          font-size: 14px;
        }
        .nav-side-menu .toggle-btn {
          display: none;
        }
        .nav-side-menu ul,
        .nav-side-menu li {
          list-style: none;
          padding: 0px;
          margin: 0px;
          line-height: 35px;
          cursor: pointer;
          /*
            .collapsed{
               .arrow:before{
                         font-family: FontAwesome;
                         content: "\f053";
                         display: inline-block;
                         padding-left:10px;
                         padding-right: 10px;
                         vertical-align: middle;
                         float:right;
                    }
             }
        */
        }
        .nav-side-menu ul :not(collapsed) .arrow:before,
        .nav-side-menu li :not(collapsed) .arrow:before {
          font-family: FontAwesome;
          content: "\f078";
          display: inline-block;
          padding-left: 10px;
          padding-right: 10px;
          vertical-align: middle;
          float: right;
        }
        .nav-side-menu ul .active,
        .nav-side-menu li .active {
          border-left: 3px solid #d19b3d;
          background-color: #4f5b69;
        }
        .nav-side-menu ul .sub-menu li.active,
        .nav-side-menu li .sub-menu li.active {
          color: #d19b3d;
        }
        .nav-side-menu ul .sub-menu li.active a,
        .nav-side-menu li .sub-menu li.active a {
          color: #d19b3d;
        }
        .nav-side-menu ul .sub-menu li,
        .nav-side-menu li .sub-menu li {
          background-color: #181c20;
          border: none;
          line-height: 28px;
          border-bottom: 1px solid #23282e;
          margin-left: 0px;
        }
        .nav-side-menu ul .sub-menu li:hover,
        .nav-side-menu li .sub-menu li:hover {
          background-color: #020203;
        }
        .nav-side-menu ul .sub-menu li:before,
        .nav-side-menu li .sub-menu li:before {
          font-family: FontAwesome;
          content: "\f105";
          display: inline-block;
          padding-left: 10px;
          padding-right: 10px;
          vertical-align: middle;
        }
        .nav-side-menu li {
          padding-left: 0px;
          border-left: 3px solid #2e353d;
          border-bottom: 1px solid #23282e;
        }
        .nav-side-menu li a {
          text-decoration: none;
          color: #e1ffff;
        }
        .nav-side-menu li a i {
          padding-left: 10px;
          width: 20px;
          padding-right: 20px;
        }
        .nav-side-menu li:hover {
          border-left: 3px solid #d19b3d;
          background-color: #4f5b69;
          -webkit-transition: all 1s ease;
          -moz-transition: all 1s ease;
          -o-transition: all 1s ease;
          -ms-transition: all 1s ease;
          transition: all 1s ease;
        }
        @media (max-width: 767px) {
          .nav-side-menu {
            position: relative;
            width: 100%;
            margin-bottom: 10px;
          }
          .nav-side-menu .toggle-btn {
            display: block;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
            z-index: 10 !important;
            padding: 3px;
            background-color: #ffffff;
            color: #000;
            width: 40px;
            text-align: center;
          }
          .brand {
            text-align: left !important;
            font-size: 22px;
            padding-left: 20px;
            line-height: 50px !important;
          }
        }
        @media (min-width: 767px) {
          .nav-side-menu .menu-list .menu-content {
            display: block;
          }
        }
</style>

<div class="well">
  <div class="text-center">
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">CONTRATACIONES: PROCEDIMIENTOS DE SELECCIÓN</span>
  </div>
</div>

<div  class="row align-items-center" style="margin-top: 20px;">
  <div class="col-md-1"></div>
  <div class="col-md-10">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
            <label for="filtro">AÑO : </label>
            <select  name="anio" class="form-control" id="anio" onchange="tablecontratacionesPS()">
                <option value="Todas">TODAS</option>
                @foreach($anio as $row)
                  <option value="{{ $row->anio }}">{{ $row->anio }}</option>
                @endforeach
            </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for="filtro">FILTRAR POR : </label>
            <select  name="filtro" class="form-control" id="filtro" onchange="tablecontratacionesPS()">
                <option value="EJECUTORA" selected>EJECUTORAS</option>
                <option value="TIPO">TIPO</option>
                <option value="ESTADO">ESTADO</option>
                <option value="PROYECTO">PROYECTOS</option>
            </select>
        </div>
      </div>
    </div>
    <div class="table table-bordered table-responsive"  >
      <div id="cargando" class="loading" style="display: none;"></div>
      <div id="imagen" style="display: none;"><img src="contrataciones/contrataciones_estado.png" class="img-fluid" alt="Responsive image"></div>
      <table class="table" id="contratacionesPS" style="margin-bottom:0px;display:none">
        <thead>
          <tr>
            <th style="text-align:center;vertical-align:middle" width="40%" id="categoria" colspan="2"></th>
            <th style="text-align:center;vertical-align:middle" >DETALLE</th>
            <th style="text-align:center;vertical-align:middle" >N° PROCEDIMIENTOS DE SELECCIÓN</th>
            <th style="text-align:center;vertical-align:middle" > S/. TOTAL DE VALOR REFERENCIAL</th>
          </tr>
        </thead>
        <tbody id="cuerpo">
        </tbody>
        <tfoot id="encabezado" style="background-color:#3c8dbc9c">
        </tfoot>
      </table>
      <table class="table" id="pry_contratacionesPS" style="margin-bottom:0px;display:none">
        <thead>
          <tr>
            <th style="text-align:center;vertical-align:middle" width="60%">PROYECTOS</th>
            <th style="text-align:center;vertical-align:middle" >DETALLE</th>
            <th style="text-align:center;vertical-align:middle" >N° PROCEDIMIENTOS DE SELECCIÓN</th>
            <th style="text-align:center;vertical-align:middle" > S/. TOTAL DE VALOR REFERENCIAL</th>
            <th style="text-align:center;vertical-align:middle" > S/. PIM {{ date("Y") }}</th>
            <th style="text-align:center;vertical-align:middle" > S/. PIM {{ date("Y") -1 }}</th>
            <th style="text-align:center;vertical-align:middle" > S/. DEVENGADO {{ date("Y") }}</th>
            <th style="text-align:center;vertical-align:middle" > S/. DEVENGADO {{ date("Y") -1 }}</th>
          </tr>
        </thead>
        <tbody id="pry_cuerpo">
        </tbody>
        <tfoot id="pry_encabezado" style="background-color:#3c8dbc9c">
        </tfoot>
      </table>
      <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Fuente: Dirección General de Programación Multianual de Inversiones - MEF (Actualizado al {{ $fecha  }})
      </span>
    </div>
  </div>
  <div class="col-md-1"></div>
</div>

<script  src="https://demos.codexworld.com/print-specific-area-of-web-page-using-jquery/jquery.PrintArea.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>


<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>

<script>
  $(function(){

      years = function () {
        $(".years").text($("#anio :selected").val());
        if($("#anio :selected").val() == 2015 || $("#anio :selected").val() == 2016 || $("#anio :selected").val() == 2017 ){
          $("#grafica").hide();
        }else{
          $("#grafica").show();
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
      
      tablecontratacionesPS=function () { 
          $("#imagen").hide(); 
          $.ajax({
              url: '{{ url("/contratacionesps/data") }}',
              method: 'POST',
              data: {filtro :$("#filtro :selected").val(),anio :$("#anio :selected").val()},
              tryCount : 0,
              retryLimit : 3,
              beforeSend: function () {
                  $("#cargando").show();
              },
              success: function(response){
                html = "";
                html_total = "";
                total_nprocesos = 0;
                total_valorrf = 0;
                if($("#filtro :selected").val() != 'PROYECTO'){
                  $("#categoria").text($("#filtro :selected").text());
                  $("#pry_contratacionesPS").hide();
                  $("#contratacionesPS").show();
                  $('#pry_contratacionesPS').DataTable().destroy();
                  $.each(response.filtro,function(key,value){
                    total_nprocesos += parseInt(value['n_proce']);
                    total_valorrf += parseInt(value['total']);
                    html += "<tr>";
                    html += "<td style='text-align:left' class='text-uppercase'>" + value['categoria'] + "</td>";
                    if($("#filtro :selected").val() == 'ESTADO'){
                      $("#imagen").show();
                      switch (value['categoria']) {
                        case "Contratado":
                        case "Consentido":
                        case "Convocado":
                        case "Adjudicado":
                          html += "<td style='text-align:left'><span class='badge bg-green text-green'>0</span></td>";
                          break;
                        case "Pendiente de Registro Efecto":
                        case "Apelado":
                        case "Retrotraído por resolución":
                          html += "<td style='text-align:left'><span class='badge bg-yellow text-yellow'>0</span></td>";
                          break;
                        case "Desierto":
                        case "Nulo":
                        case "No Subscripcion del Contrato por Decision de la Entidad":
                        case "Cancelado":
                          html += "<td style='text-align:left'><span class='badge bg-red text-red'>0</span></td>";
                          break;
                        default:
                          html += "<td style='text-align:left'></td>";
                          break;
                      }
                    }else{
                      html += "<td style='text-align:left'></td>";
                    }
                    html += "<td style='text-align:center'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModal(\""+ value['categoria'] +"\")'><i class='fa fa-eye'></i></a></td>";
                    html += "<td style='text-align:center'>" + value['n_proce'] + "</td>";
                    html += "<td style='text-align:center'>" + number_format(value['total'],0) + "</td>";
                    html += "</tr>";
                  });
                  html_total += "<tr>";
                  html_total += "<th style='text-align:center' colspan='3'>GOBIERNO REGIONAL DE LIMA</th>";
                  html_total += "<th style='text-align:center'>" + total_nprocesos + "</th>";
                  html_total += "<th style='text-align:center'>" + number_format(total_valorrf,0) + "</th>";
                  html_total += "</tr>";
                  $("#cuerpo").html(html);
                  $("#encabezado").html(html_total);
                }else{
                  pim_dia_anio_act = 0;
                  pim_dia_anio_ant = 0;
                  dev_dia_anio_act = 0;
                  dev_dia_anio_ant = 0;
                  $("#pry_contratacionesPS").show();
                  $("#contratacionesPS").hide();
                  $('#pry_contratacionesPS').DataTable().destroy();
                  $.each(response.filtro,function(key,value){
                    total_nprocesos += parseInt(value['n_proce']);
                    total_valorrf += parseInt(value['total']);
                    pim_dia_anio_act += parseInt(value['pim_dia_anio_act']);
                    pim_dia_anio_ant += parseInt(value['pim_dia_anio_ant']);
                    dev_dia_anio_act += parseInt(value['dev_dia_anio_act']);
                    dev_dia_anio_ant += parseInt(value['dev_dia_anio_ant']);
                    html += "<tr>";
                    html += "<td style='text-align:left' class='text-uppercase' width='50%'>" + value['categoria'] + "</td>";
                    html += "<td style='text-align:center'><a style='cursor:pointer' class='dropdown-toggle' onclick='loadModal(\""+ value['categoria'] +"\")'><i class='fa fa-eye'></i></a></td>";
                    html += "<td style='text-align:center'>" + value['n_proce'] + "</td>";
                    html += "<td style='text-align:center'>" + number_format(value['total'],0) + "</td>";
                    html += "<td style='text-align:center'>" + number_format(value['pim_dia_anio_act'],0) + "</td>";
                    html += "<td style='text-align:center'>" + number_format(value['pim_dia_anio_ant'],0) + "</td>";
                    html += "<td style='text-align:center'>" + number_format(value['dev_dia_anio_act'],0) + "</td>";
                    html += "<td style='text-align:center'>" + number_format(value['dev_dia_anio_ant'],0) + "</td>";
                    html += "</tr>";
                  });
                  html_total += "<tr>";
                  html_total += "<th style='text-align:center' colspan='2'>GOBIERNO REGIONAL DE LIMA</th>";
                  html_total += "<th style='text-align:center'>" + total_nprocesos + "</th>";
                  html_total += "<th style='text-align:center'>" + number_format(total_valorrf,0) + "</th>";
                  html_total += "<th style='text-align:center'>" + number_format(pim_dia_anio_act,0) + "</th>";
                  html_total += "<th style='text-align:center'>" + number_format(pim_dia_anio_ant,0) + "</th>";
                  html_total += "<th style='text-align:center'>" + number_format(dev_dia_anio_act,0) + "</th>";
                  html_total += "<th style='text-align:center'>" + number_format(dev_dia_anio_ant,0) + "</th>";
                  html_total += "</tr>";
                  $("#pry_cuerpo").html(html);
                  $("#pry_encabezado").html(html_total);

                  var oTable = $("#pry_contratacionesPS").DataTable({
                    processing: true,
                    dom: 'B<"clear">lfrtip',
                    buttons: {
                        orientation: 'landscape',
                        color:'#008d4c',
                        buttons: [ {
                            extend: 'excelHtml5',
                            text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                            titleAttr: 'Excel',
                            autoFilter: false,
                            sheetName: 'CONTRATACIONES-PROYECTO',
                            title: 'CONTRATACIONES-PROYECTO',
                            exportOptions: {
                                columns: [0,2,3,4,5,6,7]
                            },
                        }]
                    },
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    responsive:true,
                    scrollY:        '350px',
                    scrollCollapse: true,
                    paging:         false,
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
                  setTimeout(function () {
                      $($.fn.dataTable.tables( true)).DataTable().columns.adjust().draw();
                  },200);
                }
              },
              complete: function(response) {
                $("#cargando").hide();
              }
          });
      }

      tablecontratacionesPS();

      loadModal = function(filtro) {
        modaltype='full-width';
        $modal = $('#' + modaltype);
              $.ajax({
                  url: '{{ asset("/contratacionesps/show") }}',
                  type: 'POST',
                  data:{categoria :$("#filtro :selected").val(),anio :$("#anio :selected").val(),filtro:filtro},
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
