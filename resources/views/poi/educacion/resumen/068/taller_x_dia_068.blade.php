@extends('starter')
@section('htmlhead')
<style>

    .dt-center {
        text-align: center;
        /*font-size: 11px;*/
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

    .input-group-addon{
        background-color: rgb(51, 122, 183) !important;
        color:white !important;
        border: 0px !important;
        border-radius: 4px 0px 0px 4px !important;
    }
    .form-control{
        background-color: rgba(51, 122, 183, 0.32)!important;
        border:0px;
        border-radius: 0px 4px 4px 0px !important;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled]{
        background-color: rgba(51, 122, 183, 0.32)!important;
        font-size: 12px;
        border-radius: 0px 4px 4px 0px !important;
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
<div id= "loader" class="loader" style="display: none"></div>

        <div class="content">
            <?php
            if( Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){
            ?>

            <form method="GET">
                <input type="hidden" name="fecha" id="hdnfecha">
                <input type="hidden" name="ugel" id="hdnugel">
                <input type="hidden" name="type" value="tallerxdia" id="tallerxdia">

                <button type="submit" formaction="/poi/educacion/export/pdf" class="btn btn-default"><i class="fa fa-file-pdf-o"></i></button>
                <button type="submit" formaction="/poi/educacion/export/excel" class="btn btn-default"><i class="fa fa-file-excel-o"></i></button>
            </form>
            <br>
             <div class="row">
                <select id = "cboUgel" onchange="reloadTable();">
                    <option value="0">-- TODO --</option>
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
            </div><br>
            <?php
            }
            ?>
            <div class="row">
                 <div class="col-md-3">
                    <div class="form-group text-center">
                        <label>Fecha</label>
                        <input type="text" value="<?php echo date('d-m-Y') ?>" class="dateSearch datepicker" placeholder="dd-mm-yyyy" id="dateB" onchange="reloadTable();">
                    </div>
                </div>
            </div>
            <div class="row">
                <label>Actividad Operativa</label>
                <select class="col-md-12" id="ddlAct_op" onchange="reloadTable()">
                    <option value="0">-- TODOS --</option>
                    <option value="MONITOREO Y ASISTENCIA TÉCNICA A LAS INSTITUCIONES EDUCATIVAS Y UGEL - 0035 - PREVENCION DE DESASTRES">MONITOREO Y ASISTENCIA TÉCNICA A LAS INSTITUCIONES EDUCATIVAS Y UGEL - 0035 - PREVENCION DE DESASTRES</option>
                    <option value="FORMACIÓN Y CAPACITACIÓN EN MATERIA DE GESTIÓN DE RIESGO DE DESASTRES Y ADAPTACIÓN AL CAMBIO CLIMÁTICO - 0035 - PREVENCION DE DESASTRES">FORMACIÓN Y CAPACITACIÓN EN MATERIA DE GESTIÓN DE RIESGO DE DESASTRES Y ADAPTACIÓN AL CAMBIO CLIMÁTICO - 0035 - PREVENCION DE DESASTRES</option>
                </select>
            </div>
            <br>
            <div class="row table-responsive">
                <table id="poitaller-table" class="table table-hover table-stripped" cellspacing="0">
                    <thead style="background: #3c8dbc;color: white;">
                        <tr>
                            <th style="text-align: center;vertical-align: middle">Ugel</th>
                            <th style="text-align: center;vertical-align: middle">Director</th>
                            <th style="text-align: center;vertical-align: middle">Gestor</th>
                            <th style="text-align: center;vertical-align: middle">AGP</th>
                            <th style="text-align: center;vertical-align: middle">A. Operativa</th>
                            <th style="text-align: center;vertical-align: middle">Distrito</th>
                            <th style="text-align: center;vertical-align: middle">Fecha</th>
                            <th style="text-align: center;vertical-align: middle">Responsable</th>
                            <th style="text-align: center;vertical-align: middle">Estado</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

@section('script')

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
<script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src= "https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>

<script>

    $(document).ready(function(){

        var table = $('#poitaller-table').DataTable({
            lengthMenu: [[10, 25, 50,1000], [10, 25, 50, 1000]],
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            autoWidth: false,
            stateSave: false,
            order: [[ 1, "desc" ]],
            dom: 'rt',
            responsive: {
                details: {
                    type: 'column'
                }
            },
            ajax: {
                url: '{{ url("/poi/educacion/resumen/068/taller_x_dia/filter") }}',
                type: 'POST',
                data: function(d){
                    d.fecha          = $('#dateB').val();
                    d.ugel            = $('#cboUgel :selected').val();
                    d.act_op          = $('#ddlAct_op :selected').val();

                    $('#hdnfecha').val(d.fecha);
                    $('#hdnugel').val(d.ugel);
                }
            },
            columnDefs: [
                { className: "dt-center", targets: "_all"},
                {
                    render: function (data, type, full, meta) {
                        return "<p>" + data + "</p></br><p style='font-weight:bold'>"+ " Cel. "+full['celdirector'] +"</p>";
                    },
                    targets: 1
                },
                {
                    render: function (data, type, full, meta) {
                        return "<p>" + data + "</p></br><p style='font-weight:bold'>"+ " Cel. "+full['celgestor'] +"</p>";
                    },
                    targets: 2
                },
                {
                    render: function (data, type, full, meta) {
                        return "<p>" + data + "</p></br><p style='font-weight:bold'>" + " Cel. "+full['celagp'] +"</p>";
                    },
                    targets: 3
                },
                {
                    render: function (data, type, full, meta) {
                        if( data === "INCOMPLETO" ){
                            return "<label class='label label-danger'>" + data + "</label>";
                        } else {
                            return "<label class='label label-success'>" + data + "</label>";
                        }
                    },
                    targets: -1
                }
            ],
            language:
            {
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
                //{data: '', name: '', width: '2%', sortable:false},
                {data: 'ejecutora', name: 'ejecutora', width: '5%', sortable:false},
                {data: 'director', name: 'director', width: '5%', sortable:false},
                {data: 'gestor', name: 'gestor', width: '5%',sortable:false},
                {data: 'agp', name: 'agp', width: '5%',sortable:false},
                {data: 'activ_operativa', name: 'activ_operativa', width: '5%',sortable:false},
                {data: 'nom_dist', name: 'nom_dist', width: '5%',sortable:false},
                {data: 'fecha', name: 'fecha', width: '5%',sortable:false},
                {data: 'nombre_usuario', name: 'nombre_usuario', width: '5%',sortable:false},
                {data: 'estado', name: 'estado', width: '5%',sortable:false}
            ],
            initComplete: function (data) {

            }
        });


        /*table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();*/


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

        //DATEPICKER INICIALIZATION
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

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    reloadTable = function (){
        table.ajax.reload( null, false );
    }

});




</script>

@endsection



@endsection
