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

    table {
        border-collapse: collapse !important;
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
</style>

<script type="text/javascript" src="{{ asset('/plugins/fineuploader/fine-uploader.core.min.js') }}"></script>

@endsection
@section('body')
<div id = "loader" class="loader" style="display: none"></div>
    <div class="content">
        <div class="row">
            <div class="col-md-5">
                <label>Buscar:</label><br>
                <div class="input-group">
                    <input type="text" name="txtSearch" id = "txtSearch" class="form-control" placeholder="Snip, Unificado, Nombre, Provincia, Distrito" onkeyup="if(this.keyCode == 13){reloadTable()}">
                    <div class="input-group-btn">
                        <button class="btn btn-success" onclick="reloadTable()"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label>Provincia:</label><br>
                <div class="input-group">
                    <select class="form-control" onchange="reloadTable()" id = "cboprovincia">
                        <option value = "">-- Seleccionar --</option>
                        <option value = "BARRANCA">BARRANCA</option>
                        <option value = "HUARAL">HUARAL</option>
                        <option value = "HUAURA">HUAURA</option>
                        <option value = "CAÑETE">CAÑETE</option>
                        <option value = "YAUYOS">YAUYOS</option>
                        <option value = "OYON">OYON</option>
                        <option value = "HUAROCHIRI">HUAROCHIRI</option>
                        <option value = "CANTA">CANTA</option>
                        <option value = "CAJATAMBO">CAJATAMBO</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <table id="evidencia-table" data-step="2" data-intro="Gestione la información de cada programación agregada" class="table table-hover table-stripped" cellspacing="0">
                <thead style="background: #3c8dbc;color: white;">
                    <tr>
                        <th></th>
                        <th style="text-align: center;vertical-align: middle">Obra</th>
                        <th style="text-align: center;vertical-align: middle">Última Foto</th>
                        <th style="text-align: center;vertical-align: middle">U.E.</th>
                        <th style="text-align: center;vertical-align: middle">Snip</th>
                        <th style="text-align: center;vertical-align: middle">Etapa</th>
                        <th style="text-align: center;vertical-align: middle">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- ADD EJECUCIOn [MODAL] -->
    <div id="modal_add" class="modal fade" tabindex="-1" data-focus-on="input:first" data-backdrop="static" data-keyboard="false">
        <div class="modal-content">
            <form action="" id = "frmAddDate">
                <input type="hidden" id = "obra" name="idobra">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" style="text-align: center;">Tiempo y Fecha</h3>
                </div>
                <div class="m-message"></div>
                    <div class="modal-body">
                        <div class="">
                            <label class="label label-danger">Tiempo de Toma</label>
                        </div>
                        <div class="">
                            <label class="radio-inline" style="font-size:16px;font-weight: bold"><input type="radio" name="tiempo" value = "ANTES">Antes de Ejecución</label>
                            <br>
                            <label class="radio-inline" style="font-size:16px;font-weight: bold"><input type="radio" name="tiempo" value = "DURANTE" checked>Durante</label>
                            <br>
                            <label class="radio-inline" style="font-size:16px;font-weight: bold"><input type="radio" name="tiempo" value = "DESPUES">Después de Ejecución</label>
                        </div>
                        <br>
                        <div class="">
                            <input type="text" name="fecha" id="fecha" class="form-control datepicker"  value="<?php echo date('d-m-Y') ?>" />
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Siguiente <i class="fa fa-next"></i> </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

<script>

    //CLEAN LOCAL STORAGE
    //window.localStorage.clear();
</script>

@section('script')

<link rel="stylesheet" type="text/css" href="{{ asset('/plugins/pickadate/compressed/themes/default.date.css') }}">
<script type="text/javascript" src="{{ asset('/plugins/pickadate/compressed/picker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/pickadate/compressed/picker.date.js') }}"></script>


<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
<!--script type="text/javascript" src= "https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script-->
<script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src= "https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<script>

    $(document).ready(function(){

        var table = $('#evidencia-table').DataTable({
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
                url: '{{ url("/piptotalpriori/ejecucion/obra/evidencia/filter") }}',
                type: 'POST',
                contentType: "application/json",
                data: function (d) {
                    d.txtsearch = $('#txtSearch').val();
                    d.cboprov   = $('#cboprovincia option:selected').val();
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets:   0
                },
                {
                    orderable: false,
                    targets:   2,
                    render: function(data, type, full, meta){
                        if( data != null ){
                            var today    = new Date();
                            var updated  = new Date(data);
                            var timeDiff = Math.abs(today.getTime() - updated.getTime());

                            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) - 1;

                            html_class = "primary";
                            if ( diffDays > 20 ) {
                                html_class = "danger";
                            }

                            if( today == updated){
                                return "<label class='label label-success'>Hoy</label>";
                            }

                            return "<label class='label label-"+html_class+"'>hace " + diffDays  + " día(s)</label>";
                        } else {
                            return "<label class='label label-default'>Sin Actualización</label>";
                        }

                        return data;
                    }
                },
                { className: "dt-center", targets: "_all"},
                {
                    orderable: false,
                    targets:   -1,
                    render: function (data, type, full, meta) {

                        eVal = 'loadfrmAddVal("' + data + '")';
                        eView = 'loadfrmListDetail("' + data + '")';
                        eShow = 'loadfrmShow("' + data + '")';

                        var bVal = "";
                        var bView = "";
                        var bDelete = "";
                        var bImg = "";

                        bVal = "<button class='btn btn-success' onclick = "+ eVal +"><i class='fa fa-plus'></i></button> ";
                        bView = "<button class='btn btn-info' onclick = "+ eView +";loadTableEvidenciaList("+data+")><i class='fa fa-list-ul'></i></button> ";
                        bShowObra = "<button class='btn btn-warning' onclick = "+ eShow +"><i class='fa fa-eye'></i></button>";

                        return bVal + bView + bShowObra;
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
                {data: 'nom_proyec', name: 'nom_proyec', width: '7%', orderable: true},
                {data: 'last_fecha_act', name: 'last_fecha_act', width: '7%', orderable: true},
                {data: 'ger_direc', name: 'ger_direc', width: '5%'},
                {data: 'cod_snip', name: 'cod_snip', width: '5%'},
                {data: 'etapa', name: 'etapa', width: '5%'},
                {data: 'id', name: 'id', width: '5%'}
            ],
            initComplete: function (data) {

            }
        });

        $.fn.dataTable.ext.errMode = 'none';

        //EVENTOS

        reloadTable = function (){
           table.ajax.reload( null, false );
        }

        //-- LISTENERS
        var clickedO;
        loadfrmAddVal = function (id){
            $("#modal_add #obra").val(id);
            clickedO = id;
            $("#modal_add").modal('show', {backdrop: 'true'}).fadeIn('fast');
        }



        $("#modal_add #frmAddDate").submit(function (e){
            e.preventDefault();
            //TODO
            var fechaAdd = $(".modal-scrollable #frmAddDate #fecha").val();
            var tiempo   = $(".modal-scrollable #frmAddDate input[name=tiempo]:checked").val();

            $("#modal_add").modal('hide');

            loadfrmEdit(fechaAdd, tiempo, clickedO);
        });



        $(".datepicker").pickadate({
                        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Dic'],
                        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                        // Buttons
                        today: '',
                        clear: '',
                        close: '',
                        format: 'dd-mm-yyyy',
        });

        loadfrmEdit = function(fechaAdd, tiempo, id){
            $.ajax({
                url: '/piptotalpriori/ejecucion/obra/evidencia/create',
                type: 'POST',
                data: {'fecha': fechaAdd, 'idobra': id, 'tiempo':tiempo},
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
                    cargarImg(id, $("#lblfecha").text());
                    //FANCYBOX INIT
                    $(".fancybox").fancybox();
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }

        loadfrmShow = function(id){
            $.ajax({
                url: '/piptotalpriori/ejecucion/obra/evidencia/show',
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
                    //FANCYBOX INIT
                    $(".fancybox").fancybox();
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }

        loadfrmListDetail = function(id){
            $.ajax({
                url: '/piptotalpriori/ejecucion/obra/evidencia/list',
                type: 'POST',
                async:false,
                data: {'id': id},
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
                    //FANCYBOX INIT
                    //$(".fancybox").fancybox();
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }

        cargarImg = function(id, fecha){
            var imguid = id;
            $.get('/piptotalpriori/ejecucion/obra/evidencia/img/get/' + imguid.toString() + '/' + fecha.toString(), function(data) {
                $('#full-width #evidencias').html('');
                //console.log(data.taller_img.length);
                if(data.length != 0){
                    $.each(data, function (key, value) {

                        url = '/' + value.url + value.nombre;
                $('#full-width #evidencias')
                .append('<div class="container col-lg-3 col-sm-6 col-md-4 col-xs-12">'
                            +'<div style="border:1px solid;border-radius:2%;margin-right:8px;margin-top:12px;">'
                                +'<a class="fancybox" rel="group" href="'+ url +'">'
                                    +'<img width=100% height=150px src="'+ url +'" alt="" />'
                                +'</a>'
                                +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                    +'<span style="font-weight:bold">&nbsp&nbspFecha: ' + value.created_at + '</span>'
                                +'</div>'
                                +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                    + '<button style="float:right" onclick = "deleteImg('+value.id+')" class="btn btn-danger"><i class="fa fa-trash"></i></button> '
                                    <?php
                                        if( Auth::user()->hasRole('admin') ){
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
                    $('#full-width #obras').append('<h4>No hay imágenes disponibles</h4>');
                }

            });
        };

        deleteImg = function($id){
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
                    url: "/piptotalpriori/ejecucion/obra/evidencia/img/delete",
                    type: 'POST',
                    data: {id: id},
                    success: function (data) {
                        cargarImg($id, $(".modal-scrollable #lblfecha").text());

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
                        'Error'
                )

            }).catch(swal.noop);
        };

        showImgData = function($id){
            $.ajax({
                url: '/piptotalpriori/ejecucion/estado/img/meta',
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

        evidenciaSubmit = function(frm){
            event.preventDefault();

            $.ajax({
                url: '/piptotalpriori/ejecucion/obra/evidencia/store',
                type: 'POST',
                data: $(frm).serialize(),
                    beforeSend: function () {
                    $("#loader").show();
                },
                success: function (response) {
                    swal(
                            'Listo',
                            response,
                            'success'
                        )
                },
                complete: function(response) {
                    $("#loader").hide();
                }
            });
        };

        dzoneclick = function(){
            $('#dzoneEvidenciaEstado').trigger('click');
        };
        var uploader;
        fireDZ = function(id){
            var idObra = id;
            var counter = 0;
            var actual = 0;
            var cleanUp = true;

            uploader = new qq.FineUploaderBasic({
                debug: false,
                button: $(".modal-scrollable #dropzone")[0],
                autoUpload: false,
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
                    endpoint: "/piptotalpriori/ejecucion/obra/evidencia/img/upload",
                    params: {
                        uid: idObra,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }
                },
                callbacks: {
                    onUpload: function( id, fileName ) {
                        console.log('onUpload');

                        var params = {
                            uid:    idObra,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            fecha:  $(".modal-scrollable #lblfecha").text(),
                            tiempo: $(".modal-scrollable #lbltiempo").text(),
                            tipo:   $(".modal-scrollable input[name=tipo]:checked").val(),
                            desc:   $(".modal-scrollable #txtdesc").val(),
                            obs:    $(".modal-scrollable #txtobs").val()
                        }

                        uploader.setParams(params);
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

                        if ( responseJSON.success ) {
                            this.reset();

                            $(".modal-scrollable #thumbnail").attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');

                            counter--;
                            btnState(counter);
                            swal(
                            'Guardado',
                            'La imagen se guardó correctamente',
                            'success'
                            );

                            cargarImg(idObra, $(".modal-scrollable #lblfecha").text());
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
                        console.log('erroReason: ' + erroReason );

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
                $(".modal-scrollable #submit-allEvidenciaEstado").css('display','block');
            }else{
                //$(".modal-scrollable #btnAddPhoto").css('display','block');
                $(".modal-scrollable #submit-allEvidenciaEstado").css('display','none');
            }
        }

        function loadingIcon(state) {
            if ( state ){
                $(".modal-scrollable #submit-allEvidenciaEstado").prop('disable');
                $(".modal-scrollable #loadingIcon").css('display','block');
            } else {
                $(".modal-scrollable #loadingIcon").css('display','none');
                $(".modal-scrollable #submit-allEvidenciaEstado").prop('disable'), false;
            }

        }

        /*submitImage = function() {
           uploader.uploadStoredFiles();
        }
*/
        retryUpload = function() {
            uploader.retry(0);
        }


        var tableObras;
        loadTableEvidenciaList = function($id){
            setTimeout(function(){
                tableevidencias = $('.modal-scrollable #listevidencias-table').DataTable({
                    processing: true,
                    serverSide: true,
                    orderCellsTop: true,
                    autoWidth: false,
                    stateSave: false,
                    dom: 'rt',
                    lengthMenu: [[10, 25, 50,100], [10, 25, 50, 100]],
                    responsive: {
                        details: {
                            type: 'column'
                        }
                    },
                    ajax: {
                        url: '{{ url("/piptotalpriori/ejecucion/obra/evidencia/list/filter") }}',
                        type: 'POST',
                        contentType: "application/json",
                        data: function (d) {
                            d.id = $id;
                        },
                    },
                    columnDefs: [
                        {
                            className: "dt-center",
                            targets: "_all"
                        },
                        {
                            orderable: false,
                            targets:   1,
                            render: function (data, type, full, meta) {

                            var e = 'loadfrmEdit(\''+full['fecha']+'\',\''+full['tiempo']+'\','+ full['idobra'] +')';
                                bEdit = "<button type='button' class='btn btn-primary' onclick="+e+"><i id='E' class='fa fa-pencil' aria-hidden='true'></i></button> ";

                                return bEdit;
                            }
                        },
                        {
                            orderable: false,
                            targets:   4,
                            render: function (data, type, full, meta) {

                            html = "";

                                switch (data) {
                                    case 'P':
                                        html = "<label class='label label-warning'>Paralizado</label>";
                                        break;
                                    case 'PP':
                                        html = "<label class='label label-success'>Primera Piedra</label>";
                                        break;
                                    case 'E':
                                        html = "<label class='label label-default'>Otro</label>";
                                        break;
                                    case 'I':
                                        html = "<label class='label label-success'>Inaugurado</label>";
                                        break;
                                }

                                return html;
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
                        {data: 'id', name: 'id', orderable: false, searchable: false, width: '10%'},
                        {data: 'fecha', name: 'fecha', width: '8%'},
                        {data: 'tiempo', name: 'tiempo', width: '8%'},
                        {data: 'tipo', name: 'tipo', width: '7%', orderable: false},
                        {data: 'descripcion', name: 'descripcion', width: '7%', orderable: false}
                    ]
                  });

                $.fn.dataTable.ext.errMode = 'none';
              },500);
            }


        });



</script>

@endsection



@endsection
