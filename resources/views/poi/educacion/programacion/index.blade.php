@extends('starter')
@section('htmlhead')
<style>

    .select2-dropdown {
    z-index: 9001;
    }

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

    /*.input-group-addon{
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
    }*/
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

        <div class="content">
            <!--p class="bg-danger">Se comunica a todos los acompañantes pedagógicos que la planificación del mes de noviembre estará habilitada a partir del medio día, gracias por su comprensión.</p-->
            <!-- ADD TALLER [MODAL] -->
            <div id="modal_video" class="modal container fade" tabindex="-1" id = "containerDt" data-focus-on="input:first" data-backdrop="static" data-keyboard="false">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                        <div class="modal-body">
                            <div class="content text-center">

                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <button onclick="loadVideo(1)" class="btn btn-default" onclick=""><i class="glyphicon glyphicon-question-sign"></i>  Ayuda PC</button>
                </div>
                <div class="col-md-1">
                    <button onclick="loadVideo(2)" class="btn btn-default hidden-lg hidden-md"><i class="glyphicon glyphicon-question-sign"></i> Ayuda Móvil</button>
                </div>
                <form method="GET" action="/poi/educacion/reporte" id = "frmRpt">
                    <div class="col-md-1">
                        <input type="hidden" value="" name="txtRptFechaIni">
                        <input type="hidden" value="" name="txtRptFechaFin">
                        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-duplicate"></i> Reporte</button>
                    </div>
                </form>
            </div><br>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group text-center">
                        <select id="cboEstado">
                            <option value="">Todo</option>
                            <option value="1">Completo</option>
                            <option value="2">Incompletos</option>
                            <option value="3">Programados</option>
                            <option value="4">No Programados</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group text-center">
                        <label>Fecha Inicio</label>
                        <input type="text" value="<?php echo date('d-m-Y') ?>" class="dateSearch datepicker" placeholder="dd-mm-yyyy" id="dateB">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group text-center">
                        <label>&nbsp&nbsp&nbsp&nbsp Fecha Fin </label>
                        <input type="text" class="dateSearch datepicker" placeholder="dd-mm-yyyy" id="dateE">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group text-center">
                        <input type="text" id="txtSearch" onkeypress="if (event.keyCode==13){ reloadTable(); }">
                        <button class="btn btn-primary" onclick="reloadTable()">&nbspBuscar&nbsp</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <table id="poitaller-table" data-step="2" data-intro="Gestione la información de cada programación agregada" class="table table-hover table-stripped" cellspacing="0">
                    <thead style="background: #3c8dbc;color: white;">
                        <tr>
                            <th></th>
                            <th style="text-align: center;vertical-align: middle">Actividad</th>
                            <th style="text-align: center;vertical-align: middle">Fecha</th>
                            <th style="text-align: center;vertical-align: middle">Nivel</th>
                            <th style="text-align: center;vertical-align: middle">Distrito</th>
                            <th style="text-align: center;vertical-align: middle">Docente(s)</th>
                            <th style="text-align: center;vertical-align: middle">Lugar</th>

                            <th style="text-align: center;vertical-align: middle">Acciones</th>
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


<!-- FINE UPLOADER -->
<script type="text/javascript" src="{{ asset('/plugins/fineuploader/fine-uploader.core.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
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
                url: '{{ url("poi/educacion/filter/programacion") }}',
                type: 'POST',
                data: function (d) {
                    d.sector = window.location.href.split("/")[window.location.href.split("/").length - 1];
                    d.inicio          = $('#dateB').val();
                    d.search['value'] = $('#txtSearch').val();
                    d.fin             = $('#dateE').val();
                    d.estado          = $('#cboEstado :selected').val();

                    $("#frmRpt input[name=txtRptFechaIni]").val(d.inicio);
                    $("#frmRpt input[name=txtRptFechaFin]").val(d.fin);
                },
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets:   0
                },
                {
                    className: "dt-center",
                    targets: "_all"
                },
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
                                f_programada += '<label class="label label-default"> Modificado ('+full['reprogramada']+')</label> ';
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

                        eImg = 'loadfrmImg("' + data + '")';
                        eView = 'loadfrmShow("' + data + '")';
                        eEdit = 'loadModalEdit("' + data + '")';
                        eDelete = 'loadModalDelete("' + data + '")';

                        var tImg;
                        var tView;
                        var tEdit;
                        var tDelete;

                        if(meta.row == 0){
                            tEdit = 'data-step="3" data-intro="Edite programación"';
                            tView = 'data-step="4" data-intro="Vea datos relacionados a una programación"';
                            tImg = 'data-step="5" data-intro="Agregue Foto de ejecución de la programación"';
                            tDelete = 'data-step="6" data-intro="Elimine Programación"';

                        }

                        var bView = "";
                        var bImg = "";
                        var bEdit = "";
                        var bDelete = "";

                        bEdit = "<button class='btn btn-primary' "+ tEdit +" onclick = "+ eEdit +"><i class='fa fa-calendar'></i></button> ";
                        bView = "<button class='btn btn-info' "+ tView +" onclick = "+ eView +"><i class='fa fa-eye'></i></button> ";
                        bImg  = "<button class='btn btn-warning' "+ tImg +" onclick = "+ eImg +"><i class='fa fa-image'></i></button> ";
                        bDelete = "<button class='btn btn-danger' "+ tDelete +" onclick = "+ eDelete +"><i class='fa fa-trash'></i></button> ";

                        return bDelete + bEdit + bView + bImg;
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
                {data: 'tipo_activ_operativa', name: 'tipo_activ_operativa', width: '12%'},
                {data: 'fecha', name: 'fecha', width: '7%', orderable: true},
                {data: 'grupo_funcional', name: 'grupo_funcional', width: '5%'},
                {data: 'nom_dist', name: 'nom_dist', width: '8%'},
                {data: 'docente', name: 'docente', width: '8%'},
                {data: 'ie', name: 'ie', width: '10%'},
                {data: 'id', name: 'accion', orderable: false, searchable: false , width: '12%'}
            ],
            initComplete: function (data) {

            }
        });

        reloadTable = function (){
           table.ajax.reload( null, false );
        }

        $(".dateSearch").change(function (){
           reloadTable();
        });

        $("#cboEstado").change(function (){
           reloadTable();
        });

        $.fn.dataTable.ext.errMode = 'none';
        //EVENTOS

        //LoadModalEdit
        loadModalEdit = function (data){
            $modal = $('#modal_wide');
            //clean errors
            $(".m-message").html('<div></div>');
            $.ajax({
                url: '/poi/educacion/edit',
                type: 'POST',
                data: {'id': data},
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (response) {
                    $('#modal_wide .modal-title').html($(response).filter('.cabecera'));
                    $('#modal_wide .modal-body').html($(response).filter('#container'));
                    $('#modal_wide .modal-footer').append($(response).filter('.pie'));
                    $('#modal_wide').modal('show', {backdrop: 'true'});
                },
                complete: function(response) {
                    $("#loader").hide();
                    $("#ddlSearchDistrito").select2();

                    //Piackadate INICIALIZATION
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
                }
            });
        }

        //LoadModalDelete
        loadModalDelete = function (data){
            $modal = $('#modal_wide');
            //clean errors
            $(".m-message").html('<div></div>');
            $.ajax({
                url: '/poi/educacion/delete',
                type: 'POST',
                data: {'id': data},
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (response) {
                    $('#modal_wide .modal-title').html($(response).filter('.cabecera'));
                    $('#modal_wide .modal-body').html($(response).filter('#container'));
                    $('#modal_wide .modal-footer').append($(response).filter('.pie'));
                    $('#modal_wide').modal('show', {backdrop: 'true'});
                },
                complete: function(response) {
                    $("#loader").hide();
                }
            });
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
        };

        loadfrmImg = function(id){
              $.ajax({
                    url: '/poi/educacion/img',
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
                        fireDZ(id);
                        cargarImg(id);
                        //FANCYBOX INIT
                        $(".fancybox").fancybox();
                    },
                    error: function(response){
                        $("#loader").hide();
                    }
                });
        };

        ctrlHasChanged = function(){
            var msg = "",
            txtIE = $(".modal-scrollable #frmEditTaller input[name='txtIe']").val(),
            ddlDistrito = $(".modal-scrollable #frmEditTaller #ddlSearchDistrito :selected").val(),
            txtDocente = $(".modal-scrollable #frmEditTaller input[name='txtDocente']").val(),
            txtDni = $(".modal-scrollable #frmEditTaller input[name='txtDni']").val(),
            txtFecha = $(".modal-scrollable #frmEditTaller input[name='txtFecha']").val(),

            ie = $(".modal-scrollable #frmEditTaller input[name='ie']").val(),
            distrito = $(".modal-scrollable #frmEditTaller input[name='distrito']").val(),
            docente = $(".modal-scrollable #frmEditTaller input[name='docente']").val(),
            dni = $(".modal-scrollable #frmEditTaller input[name='dni']").val(),
            fecha = $(".modal-scrollable #frmEditTaller input[name='fecha']").val();

            var splited = txtFecha.split("-");
            txtFecha = splited[2] + '-' + splited[1] + '-' + splited[0];

            $(".modal-scrollable #frmEditTaller #rprogrammedMsg").html(msg);

            if ( txtIE != ie ) {
                msg += "<button style='border-radius: 15px;margin:2px' type='button' class='btn btn-flat btn-danger'>Modificada Institución Educativa</button>";
            }
            if ( ddlDistrito != distrito ) {
                msg += "<button style='border-radius: 15px;margin:2px' type='button' class='btn btn-flat btn-danger'>Modificado Distrito</button>";
            }
            if ( txtDocente != docente ) {
                msg += "<button style='border-radius: 15px;margin:2px' type='button' class='btn btn-flat btn-danger'>Modificado Docente</button>";
            }
            if ( txtDni != dni ) {
                msg += "<button style='border-radius: 15px;margin:2px' type='button' class='btn btn-flat btn-danger'>Modificado DNI</button>";
            }
            if ( txtFecha != fecha ) {
                msg += "<button style='border-radius: 15px;margin:2px' type='button' class='btn btn-flat btn-danger'>Modificada Fecha</button>";
            }
            if( msg != "" ){
                $(".modal-scrollable #frmEditTaller #if-modified").show();
            } else {
                $(".modal-scrollable #frmEditTaller #if-modified").hide();
            }
            $(".modal-scrollable #frmEditTaller #rprogrammedMsg").html(msg);
        }

        updateTaller = function (e){
            e.preventDefault();
            $.ajax({
                url: "/poi/educacion/update",
                type: 'POST',
                data: $("#frmEditTaller").serialize(),
                timeout: 4000,
                beforeSend: function () {
                    $(':input[type="submit"]').prop('disabled', true);
                    $("#loader").show();
                },
                success: function (response) {
                    $('.modal-scrollable .validation-message').remove();
                        swal(
                            'Guardado',
                            'Los cambios se guardaron exitosamente!',
                            'success'
                            );
                        table.ajax.reload( null, false );
                        setTimeout(function(){
                            $('#modal_wide').modal('hide');
                            $("#tbl_PoiTaller").trigger("reloadGrid", { fromServer: true});
                        },1000);
                },
                complete: function(response) {
                    $("#loader").hide();
                    $(':input[type="submit"]').prop('disabled', false);
                },
                error: function(jqXHR,error, errorThrown){
                    html = "";
                    if(jqXHR.status&&jqXHR.status==400){
                        data = $.parseJSON(jqXHR.responseText);
                        if (data.error === 1){
                            li = "";
                            $('.modal-scrollable .validation-message').remove();
                            $.each(data.messages, function( index, value ) {
                                li += "<li>"+ value +"</li>";
                            });

                            $(".modal-scrollable .m-message").prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                            $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');
                            $("#m_message").focus();
                        }
                    } else {
                        html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                    }
                }
            });
        };

        deleteTaller = function (e){
            e.preventDefault();
            $.ajax({
                url: "/poi/educacion/destroy",
                type: 'POST',
                data: $("#frmDeleteTaller").serialize(),
                timeout: 4000,
                beforeSend: function () {
                    $(':input[type="submit"]').prop('disabled', true);
                    $("#loader").show();
                },
                success: function (response) {
                    $('.modal-scrollable .validation-message').remove();
                        swal(
                            'Guardado',
                            'Se eliminó la actividad',
                            'success'
                            );
                        table.ajax.reload( null, false );
                        setTimeout(function(){
                            $('#modal_wide').modal('hide');
                            $("#tbl_PoiTaller").trigger("reloadGrid", { fromServer: true});
                        },1000);
                },
                complete: function(response) {
                    $("#loader").hide();
                    $(':input[type="submit"]').prop('disabled', false);
                },
                error: function(jqXHR,error, errorThrown){
                    html = "";
                    if(jqXHR.status&&jqXHR.status==400){
                        data = $.parseJSON(jqXHR.responseText);
                        if (data.error === 1){
                            li = "";
                            $('.modal-scrollable .validation-message').remove();
                            $.each(data.messages, function( index, value ) {
                                li += "<li>"+ value +"</li>";
                            });

                            $(".modal-scrollable .m-message").prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                            $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');
                            $("#m_message").focus();
                        }
                    } else {
                        html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                    }
                }
            });
        };


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
                                +'</div>'
                            +'</div>'
                        +'</div>');
                    });

                } else {
                    $('#full-width #poi').append('<h4>No hay imágenes disponibles</h4>');
                }

            });
        };

        deleteImg = function($id, $idtaller){
            var id = $id;
            swal({
                title: '¿Estas seguro?',
                text: "Se eliminara esta imagen",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No, cancelar!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true
            }).then(function() {
                $.ajax({
                    url: "/poi/educacion/img/eliminar",
                    type: 'POST',
                    data: {id: id},
                    success: function (data) {
                        cargarImg($idtaller);

                        swal(
                            'Listo',
                            'Se ha eliminado la imagen',
                            'success'
                        )

                        table.ajax.reload( null, false );
                    },
                    error: function(e){
                        swal(
                        'Error',
                        'Error al eliminar la imagen',
                        'error'
                        )
                    }
                });

            }, function(dismiss) {

                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            }).catch(swal.noop);
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

        dzoneclick = function(){
             $('#dropzone').trigger('click');
        };

        var uploader;
        fireDZ = function(id){
            var id_programacion = id;
            var counter = 0;
            var actual = 0;
            var cleanUp = true;

            uploader = new qq.FineUploaderBasic({
                debug: false,
                button: $("#full-width #dropzone")[0],
                autoUpload: false,
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'bmp']
                },
                scaling: {
                    sendOriginal: false,
                    includeExif: true,
                    sizes: [
                        { name: "qqfile", maxSize: 1400}
                    ]
                },
                request: {
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    endpoint: "/poi/educacion/img/upload"
                },
                callbacks: {
                    onUpload: function( id, fileName ) {
                        var file = this.getFile(id);
                        var nDate = new Date(file.lastModified);
                        var datestring = nDate.getFullYear() + "-" +
                                         ("0"+(nDate.getMonth()+1)).slice(-2) + "-" +
                                         ("0" + nDate.getDate()).slice(-2) + " " +
                                         ("0" + nDate.getHours()).slice(-2) + ":" +
                                         ("0" + nDate.getMinutes()).slice(-2) + ":" +
                                         ("0" + nDate.getSeconds()).slice(-2);

                        var params = {
                            uid:    id_programacion,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            fecha:  datestring,
                            cdata: file.lastModifiedDate+ ";" + file.name + ";" + file.lastModified
                        }

                        uploader.setParams(params);
                        $(".modal-scrollable #submit-all").prop('disabled',true);
                        loadingIcon(true);

                    },
                    onProgress: function( id, fileName, uploadedBytes, totalBytes ) {
                        console.log('Progress');
                    },
                    onSubmit: function(id, fileName){
                        counter++;
                        btnState(counter);

                        console.log('file Added');
                        this.drawThumbnail( id, $('.modal-scrollable #thumbnail')[0], 220, false);
                        $(".modal-scrollable #submit-allEvidenciaEstado").prop('disable',false);
                    },
                    onComplete: function(id, name, responseJSON, xhr){
                        loadingIcon(false);
                         $(".modal-scrollable #submit-all").prop('disabled',false);
                        if ( responseJSON.success ) {
                            this.reset();

                            $(".modal-scrollable #thumbnail").attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');

                            counter--;
                            btnState(counter);

                            if ( responseJSON.observada == true ) {
                              swal(
                                'Guardado',
                                'Imagen observada por duplicidad',
                                'warning'
                              );
                            } else {
                              swal(
                                'Guardado',
                                'La imagen se guardó correctamente',
                                'success'
                              );
                            }

                            cargarImg(id_programacion);
                        } else if ( responseJSON.error ) {
                            li = responseJSON.message;
                            $('.modal-scrollable .validation-message').remove();

                            $(".modal-scrollable .m-message").prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                            $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');
                            $("#m_message").focus();

                        }

                        console.log(responseJSON);
                    },
                    onError: function (id, name, errorReason, xhrOrXdr){
                        console.log('erroReason: ' + errorReason );

                        swal(
                            'Error',
                            'Error al subir la imágen',
                            'error'
                        );

                    }
                },
                retry: {
                    enableAuto: false
                }
            });



        };

        function btnState(actual){
            if( actual > 0 ){
                //$(".modal-scrollable #btnAddPhoto").css('display','none');
                $(".modal-scrollable #submit-all").css('display','block');
            }else{
                //$(".modal-scrollable #btnAddPhoto").css('display','block');
                $(".modal-scrollable #submit-all").css('display','none');
            }
        };

        function loadingIcon(state) {
            if ( state ){
                $(".modal-scrollable #submit-allEvidenciaEstado").prop('disable');
                $(".modal-scrollable #loadingIcon").css('display','block');
            } else {
                $(".modal-scrollable #loadingIcon").css('display','none');
                $(".modal-scrollable #submit-allEvidenciaEstado").prop('disable');
            }

        }

        retryUpload = function() {
            uploader.retry(0);
        }

        saveObservation = function($id){

            var opt  = $('.modal-scrollable #cboObservation option:selected').val();
            var desc = $('.modal-scrollable #cboObservation').val();
            //var nro_participantes = $('.modal-scrollable #nro_participantes').val();

            $.ajax({
                url: "/poi/educacion/saveObservation",
                type: 'POST',
                data: {
                    obs: opt,
                    desc:desc,
                    id: $id/*,
                    nro_participantes: nro_participantes*/
                },
                success: function (data) {

                },
                error: function(e){

                }
            });
        }

        loadVideo = function($t){
            var html = "";
            switch($t){
                case 1:

                    html += '<video width="100%" controls>';
                        html += '<source src="{{asset("images/sys/pcTuto.mp4")}}" type="video/mp4">';
                    html += 'Tu navegador no soporta videos';
                    html += '</video>';
                    break;
                case 2:
                    html += '<video width="100%" controls>';
                        html += '<source src="{{asset("images/sys/mTuto.mp4")}}" type="video/mp4">';
                    html += 'Tu navegador no soporta videos';
                    html += '</video>';
                    break;
            }
            $("#modal_video .content").html(html);

            $("#modal_video").modal('show', {backdrop: 'true'}).fadeIn('fast');
        }
    });

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



</script>

@endsection



@endsection
