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
            <div class="row">
                <table id="poitaller-table" class="table table-hover table-stripped" cellspacing="0">
                    <thead style="background: #3c8dbc;color: white;">
                        <tr>
                            <th></th>
                            <th style="text-align: center;vertical-align: middle">Funcion</th>
                            <th style="text-align: center;vertical-align: middle">Cat. Presupuestal</th>
                            <th style="text-align: center;vertical-align: middle">Producto</th>
                            <th style="text-align: center;vertical-align: middle">Act. Presupuestal</th>
                            <th style="text-align: center;vertical-align: middle">Actividad Operativa</th>
                            <th style="text-align: center;vertical-align: middle">Programados</th>
                            <th style="text-align: center;vertical-align: middle">Cumplidos</th>
                            <th style="text-align: center;vertical-align: middle">Avance</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

@section('script')

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
<script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src= "https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<script>

    $(document).ready(function(){

        var table = $('#poitaller-table').DataTable({
            lengthMenu: [[10, 25, 50,1000], [10, 25, 50, 1000]],
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            autoWidth: false,
            stateSave: false,
            order: [[ 2, "desc" ]],
            dom: 'lpBfrtip',
            /*"createdRow": function( row, data, dataIndex ) {
                $(row).addClass( data['state'] );

            },*/
            responsive: {
                details: {
                    type: 'column'
                }
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i>',
                    className: '',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print fa-lg" aria-hidden="true"></i>',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"><i>',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                }
            ],
            ajax: {
                url: '{{ url("poi-resumen-act-filter") }}',
                type: 'POST',
                /*data: function (d) {
                    d.tiempo = $('.cboTime').find(":selected").val();
                },*/
                /*dataSrc: function(json){

                    $.each(json.legend,function($key,$val){
                        $('#'+$key).html('<span style="color: green;"><b>'+$val+'</b><span>');
                    });

                    return json.data;
                }*/
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets:   0
                },
                { className: "dt-center", targets: "_all"},
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-100'>" + data + "</div>";
                    },
                    targets: 1
                },
                {
                    render: function (data, type, full, meta) {
                        var completas   = full['completas'];
                        var programadas = full['programadas'];

                        var prom = (completas / programadas)  * 100;

                        if(prom){
                            if(prom < 50.00){
                                return "<span class='label label-danger'>"+prom.toFixed(2)+"%</span>";
                            } else {
                                return "<span class='label label-success'>"+prom.toFixed(2)+"%</span>";
                            }
                        } else {
                            return "<span class='label label-danger'>0%</span>";
                        }
                    },
                    targets: -1
                },

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
                {data: '', name: 'accion', orderable: false, searchable: false, width: '1%'},
                {data: 'funcion', name: 'funcion', width: '5%'},
                {data: 'cat_presupuestal', name: 'cat_presupuestal', width: '10%'},
                {data: 'producto', name: 'producto', width: '10%'},
                {data: 'act_presupuestal', name: 'act_presupuestal', width: '10%'},
                {data: 'nombre', name: 'nombre', width: '20%'},
                {data: 'programadas', name: 'programadas', width: '5%'},
                {data: 'completas', name: 'completas', width: '5%'},
                {data: '', name: '', width: '5%'},
            ],
            initComplete: function (data) {

            }
        });

        $.fn.dataTable.ext.errMode = 'none';


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

    $("#cboDistrito").select2({
            dropdownParent: $("#modal_add"),
            ajax: {
                url: "/listDistritoByName",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    q: params.term, // search term
                    u: $("#idUsuario").val()
                  };
                },
                processResults: function (data, params) {
                  // parse the results into the format expected by Select2
                  // since we are using custom formatting functions we do not need to
                  // alter the remote JSON data, except to indicate that infinite
                  // scrolling can be used
                  //params.page = params.page || 1;
                  return {
                    results: $.map(data, function ($key,$val) {
                        return {
                            text: $key,
                            slug: $key,
                            id: $val
                        }
                    })
                    /*pagination: {
                      more: (params.page * 30) < data.total_count
                    }*/
                  };
                },
                cache: true
              },
              escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
              minimumInputLength: 3
              //templateResult: formatRepo, // omitted for brevity, see the source of this page
              //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });

});




</script>

@endsection



@endsection
