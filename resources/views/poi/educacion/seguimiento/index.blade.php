@extends('starter')
@section('htmlhead')
<style>

    .dt-center {
        text-align: center;
    }

    /*REWRITING TEXTBOX STYLES */
    /* TEXTBOX */


    #poitaller-table tr{
        border-top: 1px solid black !important;
        border-bottom: : 1px solid black !important;
    }

    select {
      width: 200px;
      max-width: 100%; /* So it doesn't overflow from it's parent */
    }

    textarea {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;

        width: 100%;
    }

    option {
      /* wrap text in compatible browsers */
      -moz-white-space:pre-wrap;
      -o-white-space:pre-wrap;
      white-space:pre-wrap;

      /* hide text that can't wrap with an ellipsis */
      overflow: hidden;
      text-overflow:ellipsis;

      /* add border after every option */
      border-bottom: 1px solid #DDD;
    }
    /*.ui-jqgrid .loading
    {
        left: 45%;
        top: 45%;
        background: url(ajax-loader.gif);
        background-position-x: 50%;
        background-position-y: 50%;
        background-repeat: no-repeat;
        height: 20px;
        width: 20px;
    }*/

    table {
        border-collapse: collapse !important;
    }

    .published{
        background: rgba(62, 117, 165, 0.72) !important;
    }
    .programed{
        background: rgba(241, 250, 0, 0.7) !important;
    }

    .executing{
        background: rgb(0, 166, 90) !important
    }
    .passed{
        background: rgb(232, 72, 53) !important;
    }   

    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        position: fixed;
        z-index: 99999;
        top: 25%;
        left: 45%;
    }

    .select2-container .select2-selection--single{
        height: 34px !important;
    }

    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single{
        padding: 14px 12px !important;
    }

    @-webkit-keyframes spin {
              0% { -webkit-transform: rotate(0deg); }
              100% { -webkit-transform: rotate(360deg); }
            }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    #containerDt{
        position: relative !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('/plugins/pickadate/compressed/themes/default.css') }}">
@endsection
@section('body')
<div id = "loader" class="loader" style="display: none"></div>
        <div class="content">

            <!--div class="alert alert-danger" role="alert">
                Buen día estimado usuario, se le comunica que el equipo técnico se encuentra recopilando la información de los talleres planificados, a partir del lunes 13 de octubre podrá empezar a visualizar los talleres programados para el presente mes.
            </div-->
            <div class="row">
                <form method="GET" action="/poi/educacion/export/all/seguimiento/excel">
                    <input type="hidden" name="inicio" id="inicio">
                    <input type="hidden" name="fin" id="fin">
                    <input type="hidden" name="estado" id="estado">
                    <input type="hidden" name="search" id="search">
                    <input type="hidden" name="ugel" id="ugel">
                    <input type="hidden" name="type" id="tipo" value="seguimiento">

                    <button type="submit" name="" class="btn btn-default"><i class="fa fa-file-excel-o"> Exportar</i></button>
                </form>

                <div class="col-md-2">
                    <div class="form-group text-center">
                        Estado: <select id="cboEstado">
                            <option value="">Todo</option>
                            <option value="1">Completo</option>
                            <option value="2">Incompletos</option>
                            <option value="3">Programados</option>
                            <option value="4">No Programados</option>
                        </select>
                    </div>
                </div>

                <?php
                if( Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){
                ?>
                <div class="col-md-2">
                    <div class="form-group text-center">
                        Ugel:
                            <select id = "cboUgel" onchange="reloadTable();">
                                <option value="0">Todo</option>
                                <option value="1">UGEL 08</option>
                                <option value="2">UGEL 09</option>
                                <option value="3">UGEL 10</option>
                                <option value="4">UGEL 11</option>
                                <option value="5">UGEL 12</option>
                                <option value="6">UGEL 13</option>
                                <option value="7">UGEL 14</option>
                                <option value="8">UGEL 15</option>
                                <option value="9">UGEL 16</option>
                            </select>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="col-md-4">
                    <div class="form-group text-center">
                        <input type="text" id="txtSearch" onkeypress="if (event.keyCode==13){ reloadTable(); }">
                        <button class="btn btn-primary" onclick="reloadTable()">Buscar</button>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group text-center">
                        Tipo Act.: 
                        <select id="cboTipAct"  onchange="reloadTable();">
                            <option value="">Todo</option>
                            @role('pp-090')
                            <option value="TALLER SOPORTE PP-090">TALLER SOPORTE PP-090</option>
                            <option value="MATERIALES SECUNDARIA PP-090">MATERIALES SECUNDARIA PP-090</option>
                            <option value="VISITA MULTIGRADO PP-090">VISITA MULTIGRADO PP-090</option>
                            <option value="GIA SOPORTE PP-090">GIA SOPORTE PP-090</option>
                            <option value="TALLER MULTIGRADO PP-090">TALLER MULTIGRADO PP-090</option>
                            <option value="GIA EIB PP-090">GIA EIB PP-090</option>
                            <option value="MATERIALES INICIAL PP-090">MATERIALES INICIAL PP-090</option>
                            <option value="TALLER MACRORREGIONAL PP-090">TALLER MACRORREGIONAL PP-090</option>
                            <option value="TALLER PP-090">TALLER PP-090</option>
                            <option value="MATERIALES PRIMARIA PP-090">MATERIALES PRIMARIA PP-090</option>
                            <option value="GIA MULTIGRADO PP-090">GIA MULTIGRADO PP-090</option>
                            <option value="PAGO AGUA PP-090">PAGO AGUA PP-090</option>
                            <option value="VISITA EIB PP-090">VISITA EIB PP-090</option>
                            <option value="TALLER EIB PP-090">TALLER EIB PP-090</option>
                            <option value="PAGO ENERGÍA ELECTRICA PP-090">PAGO ENERGÍA ELECTRICA PP-090</option>
                            <option value="VISITA SOPORTE PP-090">VISITA SOPORTE PP-090</option>
                            <option value="MONITOREO ESPECIALISTA PP-090">MONITOREO ESPECIALISTA PP-090</option>
                            @endrole
                            @role('pp-106')
                            <option value="ASISTENCIA PP-106">ASISTENCIA PP-106</option>
                            <option value="MATERIALES PP-106">MATERIALES PP-106</option>
                            <option value="VISITA PP-106">VISITA PP-106</option>
                            <option value="TALLER PP-106">TALLER PP-106</option>
                            <option value="MONITOREO PP-106">MONITOREO PP-106</option>
                            <option value="CAMPAÑA PP-106">CAMPAÑA PP-106</option>
                            @endrole
                            @role('pp-068')
                            <option value="VISITA PP-068">VISITA PP-068</option>
                            <option value="CAPACITACIÓN  PP-068">CAPACITACIÓN  PP-068</option>
                            @endrole
                            @role('pp-051')
                            <option value="CAPACITACIÓN  PP-051">CAPACITACIÓN  PP-051</option>                            
                            <option value="APLICACION DE ESTRAT. PP-051">APLICACION DE ESTRAT. PP-051</option>
                            <option value="APLICACIÓN DEL PROG. PP-051">APLICACIÓN DEL PROG. PP-051</option>
                            <option value="CAPACITACIÓN DOCENTES PP-051">CAPACITACIÓN DOCENTES PP-051</option>
                            @endrole
                        </select>
                    </div>
                </div>                
            </div>

            <div class="row">
              <div class="col-md-3">
                  <div class="form-group text-center">
                      Fecha Inicio:
                      <input type="text" value="<?php echo date('d-m-Y') ?>" class="dateSearch datepicker" placeholder="dd-mm-yyyy" id="dateB">
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group text-center">
                      Fecha Fin:
                      <input type="text" class="dateSearch datepicker" placeholder="dd-mm-yyyy" id="dateE">
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-2">Completos: <label id = "lblcomplete" class="label label-success"></label></div>
                <div class="col-md-2">Incompletos: <label id = "lblincomplete" class="label label-danger"></label></div>
                <div class="col-md-2">Planificados: <label id = "lblplanificados" class="label label-warning"></label></div>
                <div class="col-md-2">Total: <label id = "lbltotal" class="label label-default"></label></div>
            </div>     <br>
            <div class="row">
                <table id="poitaller-table" data-step="2" data-intro="Gestione la información de cada programación agregada" class="table table-hover table-stripped" cellspacing="0">
                    <thead style="background: #3c8dbc;color: white;">
                        <tr>
                            <th></th>
                            <th style="text-align: center;vertical-align: middle">Actividad</th>
                            <th style="text-align: center;vertical-align: middle">Fecha</th>
                            <th style="text-align: center;vertical-align: middle">Código</th>
                            <th style="text-align: center;vertical-align: middle">Distrito</th>
                            <th style="text-align: center;vertical-align: middle">Ejecutora</th>
                            <th style="text-align: center;vertical-align: middle">A cargo de</th>
                            <th style="text-align: center;vertical-align: middle">Detalle</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>



<script>

    //CLEAN LOCAL STORAGE
    //window.localStorage.clear();
</script>

@section('script')

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
<!--script type="text/javascript" src= "https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script-->
<script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src= "https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<script>

    $(document).ready(function(){

        var table = $('#poitaller-table').DataTable({
            lengthMenu: [[10, 25, 50,100], [10, 25, 50, 100]],
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            autoWidth: false,
            stateSave: false,
            order: [[ 2, "desc" ]],
            dom: 'lpBrtip',
            responsive: {
                details: {
                    type: 'column'
                }
            },
            ajax: {
                url: '{{ url("poi/educacion/filter/seguimiento") }}',
                type: 'POST',
                data: function (d) {
                    d.sector = window.location.href.split("/")[window.location.href.split("/").length - 1];
                    d.inicio          = $('#dateB').val();
                    d.search['value'] = $('#txtSearch').val();
                    d.fin             = $('#dateE').val();
                    d.estado          = $('#cboEstado :selected').val();
                    d.ugel            = $('#cboUgel :selected').val();
                    d.tipact          = $('#cboTipAct :selected').val();

                    $('#inicio').val(d.inicio);
                    $('#fin').val(d.fin);
                    $('#estado').val(d.estado);
                    $('#search').val(d.search['value']);
                    $('#ugel').val(d.ugel);
                    $('#cboTipAct').val(d.tipact);
                },
                dataSrc: function (json) {

                    $("#lblcomplete").html(json['legend']['completos']);
                    $("#lblincomplete").html(json['legend']['incompletos']);
                    $("#lblplanificados").html(json['legend']['planificados']);
                    $("#lbltotal").html(json['recordsFiltered']);

                    return json.data;
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets:   0
                },
                { className: "dt-center", targets: "_all"},
                {
                    orderable: false,
                    targets:   2,
                    render: function (data, type, full, meta) {

                        f_programada = data;
                        if ( f_programada ){
                            //TODAY
                            var currentTime = new Date();
                            var month = currentTime.getMonth() + 1;
                            var day = currentTime.getDate();
                            var year = currentTime.getFullYear();

                            if(month<10){
                                month = '0'+month;
                            }
                            if(day<10){
                                day = '0'+day;
                            }
                            //console.log(full);
                            var today = year+'-'+month+'-'+day;
                            var today1 = year+'-'+month+'-'+day;
                            var f_programada1 = f_programada.split('-');

                            var today = new Date(today);
                            var f_programada = new Date(f_programada);
                            var timeDiff = ( f_programada.getTime() - today.getTime() );

                            diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                            //console.log(diffDays);

                            if( diffDays == 0 ){
                                f_programada = '<label class="label label-success">Hoy</label>';
                            } else if( diffDays == 1 ){
                                f_programada = '<label class="label label-primary">Mañana</label>';
                            } else if( diffDays > 1 ){
                                f_programada = '<label class="label label-primary">  '+ f_programada1[2]+'-'+f_programada1[1]+'-'+f_programada1[0] + '</label> ';
                            } else if( diffDays == -1 ){
                                f_programada = '<label class="label label-default">Ayer</label> ';
                            } else if( diffDays < 1 ){
                                f_programada = '<label class="label label-default">  '+ f_programada1[2]+'-'+f_programada1[1]+'-'+f_programada1[0] + '</label> ';
                            }

                            //return f_programada;

                            if( full['state'] == "complete" ){
                                f_programada += '<br><label class="label label-success">Completo</label> ';
                            } else if( full['state'] == "passed" ) {
                                f_programada += '<br><label class="label label-danger">Incompleto</label> ';
                            } else if( full['state'] == "reprogramed" ) {
                                f_programada += '<br><label class="label label-warning">Reprogramado</label> ';
                            } else {
                                f_programada += '<br><label class="label label-warning">Planificado</label> ';
                            }

                            // Reprogramado
                            if( full['reprogramada'] > 0 ){
                                f_programada += '<label class="label label-default"> Reprogramada ('+full['reprogramada']+')</label> ';
                            }

                            return f_programada;
                        } else {
                            return '<label class="label label-default">No Programado</label>';
                        }
                    }
                },
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-100'>" + data + "</div>";
                    },
                    targets: 5
                },
                {
                    orderable: false,
                    targets:   7,
                    render: function (data, type, full, meta) {

                        eView = 'loadfrmShow("' + data + '")';
                        var tView;

                        if(meta.row == 0){
                            tView = 'data-step="4" data-intro="Vea datos relacionados a una programación"';
                        }
                        var bView = "";

                        bView = "<button class='btn btn-info' "+ tView +" onclick = "+ eView +"><i class='fa fa-eye'></i></button> ";

                        return bView;
                    }
                }


            ],
            language:{
                "sProcessing":     "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                "sLengthMenu":     "Mostrar _MENU_",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty":      "Vacio",
                "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
            ,
            columns: [
                {data: '', name: 'accion', orderable: false, searchable: false, width: '1%'},
                {data: 'activ_operativa', name: 'activ_operativa', width: '30%'},
                {data: 'fecha', name: 'fecha', width: '7%', orderable: true},
                {data: 'codigo_taller', name: 'codigo_taller', width: '5%'},
                {data: 'nom_dist', name: 'nom_dist', width: '8%'},
                {data: 'ejecutora', name: 'ejecutora', width: '8%'},
                {data: 'nombre_usuario', name: 'nombre_usuario', width: '10%'},
                {data: 'id', name: 'accion', orderable: false, searchable: false , width: '12%'}
            ]
        });

        reloadTable = function (){
           table.ajax.reload( null, false );
           $('#export').val(0);
        }

        $(".dateSearch").change(function (){
           reloadTable();
        });

        $("#cboEstado").change(function (){
           reloadTable();
        });

        $.fn.dataTable.ext.errMode = 'none';

        $(".datepicker").pickadate({
                        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Dic'],
                        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                        // Buttons
                        today: 'Hoy',
                        clear: '',
                        close: 'Cerrar',
                        format: 'dd-mm-yyyy',
        });


    loadfrmShow = function(id){
             $.ajax({
                        url: '/poi/educacion/show',
                        type: 'POST',
                        data: {'id': id},
                        beforeSend: function () {
                            $("#loader").show();
                        },
                        success: function (response) {
                            $('#full-width .modal-title').html($(response).filter('.cabecera'));
                            $('#full-width .modal-body').html($(response).filter('#container'));
                            $('#full-width .modal-footer').append($(response).filter('.pie'));
                            $('#full-width').modal('show', {backdrop: 'true'});
                        },
                        complete: function(response) {
                            $("#loader").hide();
                            cargarImg(id);
                            //FANCYBOX INIT
                            $(".fancybox").fancybox();
                        },
                        error: function(response){
                            $("#loader").hide();
                        }
                    });
    }

        cargarImg = function(id){
            var imguid = id;
            $.get('/poi/educacion/img/get/' + imguid.toString(), function(data) {
                $('#full-width #poi').html('');
                //console.log(data.taller_img.length);
                if(data.taller_img.length != 0){
                    $.each(data.taller_img, function (key, value) {

                        url = '/images' + value.url + "/" + value.nombre;
                $('#full-width #poi')
                .append('<div class="container col-lg-3 col-sm-6 col-md-4 col-xs-12">'
                            +'<div style="border:1px solid;border-radius:2%;margin-right:8px;margin-top:12px;">'
                                +'<a class="fancybox" rel="group" href="'+ url +'">'
                                    +'<img width=100% height=150px src="'+ url +'" alt="" />'
                                +'</a>'
                                +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                    +'<span style="font-weight:bold">&nbsp&nbspFecha: ' + value.created_at + '</span>'
                                +'</div>'
                                +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                    + '<button style="float:right" onclick = "deleteImg('+value.id+','+imguid
                                    +')" class="btn btn-danger"><i class="fa fa-trash"></i></button> '
                                    <?php
                                        if( Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){
                                    ?>
                                    + '<button style="float:right" onclick = "showImgData('+value.id+')" class="btn btn-info"><i class="fa fa-eye"></i></button>'
                                    <?php
                                        }
                                    ?>
                                +'</div>'
                            +'</div>'
                        +'</div>');
                    });

                } else {
                    $('#full-width #poi').append('<h4>No hay imágenes disponibles</h4>');
                }

            });
        };

    showImgData = function($id){
           $.ajax({
                        url: '/poi/educacion/img/meta',
                        type: 'POST',
                        data: {'id': $id},
                        beforeSend: function () {
                            $("#loader").show();
                        },
                        success: function (response) {
                            $('#modal_simple .modal-title').html($(response).filter('.cabecera'));
                            $('#modal_simple .modal-body').html($(response).filter('#container'));
                            $('#modal_simple .modal-footer').append($(response).filter('.pie'));
                            $('#modal_simple').modal('show', {backdrop: 'true'});
                        },
                        complete: function(response) {
                            $("#loader").hide();
                        }
                    });
    };

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }

});







</script>

@endsection



@endsection
