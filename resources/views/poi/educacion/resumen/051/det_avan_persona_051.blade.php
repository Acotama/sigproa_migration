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
                        <label>Fecha Inicio</label>
                        <input type="text" value="<?php echo date('01-m-Y') ?>" class="dateSearch datepicker" placeholder="dd-mm-yyyy" id="dateB" onchange="reloadTable">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group text-center">
                        <label>&nbsp&nbsp&nbsp&nbsp Fecha Fin </label>
                        <input type="text" class="dateSearch datepicker" placeholder="" value="<?php echo date('d-m-Y') ?>" id="dateE" onchange="reloadTable();">
                    </div>
                </div>
            </div>
            <div class="row">
                <label>Actividad Operativa</label>
                <select class="form-control" id="ddlAct_op" onchange="reloadTable()">
                    <option value="0">-- TODOS --</option>
                    <option value="CAPACITACION A DOCENTES TUTORES PARA EL DESARROLLO DEL PROGRAMA PRESUPUESTAL DE PREVENCION Y TRATAMIENTO DEL CONSUMO DE DROGAS A TRAVES DE LA TUTORIA. - 0115 - PROTECCION DE POBLACIONES EN RIESGO">CAPACITACION A DOCENTES TUTORES PARA EL DESARROLLO DEL PROGRAMA PRESUPUESTAL DE PREVENCION Y TRATAMIENTO DEL CONSUMO DE DROGAS A TRAVES DE LA TUTORIA. - 0115 - PROTECCION DE POBLACIONES EN RIESGO</option>
                    <option value="APLICACIÓN DEL PROGRAMA DE PREVENCION DEL CONSUMO DE DROGAS EN EL AMBITO EDUCATIVO A TRAVES DE LA TUTORIA. - 0115 - PROTECCION DE POBLACIONES EN RIESGO">APLICACIÓN DEL PROGRAMA DE PREVENCION DEL CONSUMO DE DROGAS EN EL AMBITO EDUCATIVO A TRAVES DE LA TUTORIA. - 0115 - PROTECCION DE POBLACIONES EN RIESGO</option>
                    <option value="APLICACIÓN DE ESTRATEGIAS SOCIEDUCATIVAS PARA LA INTERVENCIÓN CON GRUPOS DE RIESGO. - 0115 - PROTECCION DE POBLACIONES EN RIESGO">APLICACIÓN DE ESTRATEGIAS SOCIEDUCATIVAS PARA LA INTERVENCIÓN CON GRUPOS DE RIESGO. - 0115 - PROTECCION DE POBLACIONES EN RIESGO</option>
                </select>
            </div> 
            <br>
            <div class="row table-responsive">
                <table id="poitaller-table" class="table table-hover table-stripped" cellspacing="0">
                    <thead style="background: #3c8dbc;color: white;">
                        <tr>
                            <!--th style="text-align: center;vertical-align: middle">Nro</th-->
                            <th style="text-align: center;vertical-align: middle">Nombre</th>
                            <!--th style="text-align: center;vertical-align: middle">DNI</th-->
                            <!--th style="text-align: center;vertical-align: middle">Telefono</th-->
                            <th style="text-align: center;vertical-align: middle">Dependencia</th>
                            <th style="text-align: center;vertical-align: middle">Incompletos</th>
                            <th style="text-align: center;vertical-align: middle">Completos</th>
                            <th style="text-align: center;vertical-align: middle">Planificados</th>
                            <th style="text-align: center;vertical-align: middle">Total</th>
                            <th style="text-align: center;vertical-align: middle">% Incompletos</th>
                            <th style="text-align: center;vertical-align: middle">% Completos</th>
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
<script type="text/javascript" src= "//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src= "//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src= "//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src= "//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src= "//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>

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
            dom: 'Brtip',
            responsive: {
                details: {
                    type: 'column'
                }
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<button class="btrn btn-default"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></button>',
                    className: '',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                },
                {
                    extend: 'print',
                    text: '<button class="btrn btn-default"><i class="fa fa-print fa-lg" aria-hidden="true"></i></button>',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                }
            ],
            ajax: {
                url: '{{ url("/poi/educacion/resumen/051/det_avan_persona/filter") }}',
                type: 'POST',
                data: function(d){
                    d.inicio          = $('#dateB').val();
                    d.fin             = $('#dateE').val();
                    d.ugel            = $('#cboUgel :selected').val();
                    d.act_op          = $('#ddlAct_op :selected').val();
                }
            },
            columnDefs: [
                { className: "dt-center", targets: "_all"},
                {
                    render: function (data, type, full, meta) {
                        html = "<div class='text-wrap width-100'>" + data;

                        if(full['activo'] == 0){
                            html += " <label class='label label-danger'>INACTIVO</label>"
                        }


                        html += "</div>";
                        return html;
                    },
                    targets: 0
                },
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-100'>" + data + "</div>";
                    },
                    targets: 1
                },
                {
                    render: function (data, type, full, meta) {
                        return "<label class='label label-danger'>" + data + " </label>";
                    },
                    targets: 2
                },
                {
                    render: function (data, type, full, meta) {
                        return "<label class='label label-success'>" + data + " </label>";
                    },
                    targets: 3
                },
                {
                    render: function (data, type, full, meta) {
                        return "<label class='label label-warning'>" + data + " </label>";
                    },
                    targets: 4
                },
                {
                    render: function (data, type, full, meta) {
                        return "<label class='label label-default'>" + data + " </label>";
                    },
                    targets: 5
                },
                 {
                    render: function (data, type, full, meta) {


                        return "<label class='label'  style='background-color:rgba(255, 0, 0, "+ (((data)/100)+0.4) +")'>" + data + "% </label>";


                    },
                    targets: 6
                },
                 {
                    render: function (data, type, full, meta) {
                        return "<label class='label' style='background-color:rgba(0, 170, 90, "+ (((data)/100)+0.4) +")'>" + data + "% </label>";
                    },
                    targets: 7
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
                {data: 'nombre_usuario', name: 'nombre_usuario', width: '20%', sortable:false},
                {data: 'ejecutora', name: 'ejecutora', width: '5%',sortable:false},
                {data: 'passed', name: 'passed', width: '5%',sortable:false},
                {data: 'complete', name: 'complete', width: '5%',sortable:false},
                {data: 'programmed', name: 'programmed', width: '5%',sortable:false},
                {data: 'total', name: 'total', width: '5%',sortable:false},
                {data: 'porcen_passed', name: 'porcen_passed', width: '5%',sortable:false},
                {data: 'porcen_complete', name: 'porcen_complete', width: '5%',sortable:false}
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
