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

@endsection
@section('body')
<div id = "loader" class="loader" style="display: none"></div>
    <script type="text/javascript">
         function startTour() {
            var tour = introJs();
            tour.setOption('tooltipPosition', 'auto');
            tour.setOption('positionPrecedence', ['left','right','top','bottom']);
            tour.start();
        }
    </script>
    <div class="content">
        <div class="row">
            <label onclick="startTour();" class="pull-right"><i class="fa fa-question-circle fa-2x fa-hover" aria-hidden="true"></i><span style="font-size: 18px;font-weight: bold"> Ayuda</span></label>
        </div>

        <div class="row">
            <table id="poitaller-table" data-step="2" data-intro="Gestione la información de cada programación agregada" class="table table-hover table-stripped" cellspacing="0">
                <thead style="background: #3c8dbc;color: white;">
                    <tr>
                        <th></th>
                        <th style="text-align: center;vertical-align: middle">Proyecto</th>
                        <th style="text-align: center;vertical-align: middle">Actualizado</th>
                        <!--th style="text-align: center;vertical-align: middle">Etapa</th-->
                        <th style="text-align: center;vertical-align: middle">U.E.</th>
                        <th style="text-align: center;vertical-align: middle">Snip</th>
                        <th style="text-align: center;vertical-align: middle">SubEtapa</th>
                        <th style="text-align: center;vertical-align: middle">Av. Fisico</th>
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
                    <h3 class="modal-title" style="text-align: center;">Fecha</h3>
                </div>
                <div class="m-message"></div>
                    <div class="modal-body">
                        <div>
                            <input type="text" name="fecha" class="form-control datepicker"  value="<?php echo date('d-m-Y') ?>" />
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


<!-- JQUERY UI -->
<script src="{{ asset('librerias/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- DROPZONE -->
<script src="{{ asset('/librerias/dropzone/dropzone.js') }}"></script>


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
                url: '{{ url("/piptotalpriori/ejecucion/obra/filter/ejecucion") }}',
                type: 'POST',
                contentType: "application/json",
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

                        var today    = new Date();
                        var updated  = new Date(data);

                        var timeDiff = Math.abs(today.getTime() - updated.getTime());
                        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                        html_class = "primary";
                        if ( diffDays > 20 ) {
                            html_class = "danger";
                        }

                        return "<label class='label label-"+html_class+"'>hace " + diffDays + " día(s)</label>";
                    },
                    targets: 2
                },
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
                        bView = "<button class='btn btn-info' onclick = "+ eView +";loadTableEstadoList("+data+")><i class='fa fa-list-ul'></i></button> ";
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
                {data: 'fecha_act', name: 'fecha_act', width: '7%', orderable: true},
                //{data: 'etapa', name: 'etapa', width: '5%'},
                {data: 'ger_direc', name: 'ger_direc', width: '5%'},
                {data: 'cod_snip', name: 'cod_snip', width: '5%'},
                {data: 'sub_etapa', name: 'sub_etapa', width: '5%'},
                {data: 'a_fisico', name: 'a_fisico', width: '5%'},
                {data: 'id', name: 'id', width: '5%'}
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

        //EVENTOS

        //-- LISTENERS

        loadfrmAddVal = function (id){
            $("#modal_add #obra").val(id);
            $("#modal_add").modal('show', {backdrop: 'true'}).fadeIn('fast');
        }

        $("#modal_add #frmAddDate").submit(function (e){
            e.preventDefault();
            $("#modal_add").modal('hide');
            created = createVal(  $("#modal_add #frmAddDate") );

        });

        function createVal(frm){
            $.ajax({
                url: "/piptotalpriori/ejecucion/estado/create",
                type: 'POST',
                data: $(frm).serialize(),
                timeout: 4000,
                beforeSend: function () {
                     $("#loader").show();
                },
                success: function (response) {
                    $('.validation-message').remove();
                        setTimeout(function(){
                            $('#modal_add').modal('hide');
                            loadfrmEdit(response['estado']);
                        },1000);
                },
                complete: function(response) {
                    $("#loader").hide();
                },
                error: function(jqXHR,error, errorThrown){
                   html = "";
                   if(jqXHR.status&&jqXHR.status==400){
                        data = $.parseJSON(jqXHR.responseText);
                        if (data.error === 1){
                            li = "";
                            $('.validation-message').remove();
                            $.each(data.messages, function( index, value ) {
                                li += "<li>"+ value +"</li>";
                            });

                            $("#frmAddTaller .m-message").prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                            $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');
                            $("#m_message").focus();
                        }
                   }else{
                        html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                   }
                }
            });
        };

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

        loadfrmEdit = function(id){
            $.ajax({
                url: '/piptotalpriori/ejecucion/estado/edit',
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
        }

        loadfrmShow = function(id){
            $.ajax({
                url: '/piptotalpriori/ejecucion/obra/show',
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
                url: '/piptotalpriori/ejecucion/estado/list',
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

        cargarImg = function(id){
            var imguid = id;
            $.get('/piptotalpriori/ejecucion/estado/img/get/' + imguid.toString(), function(data) {
                $('#full-width #obras').html('');
                //console.log(data.taller_img.length);
                if(data.taller_img.length != 0){
                    $.each(data.taller_img, function (key, value) {

                        url = '/images' + value.url + "/" + value.nombre;
                $('#full-width #obras')
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
                    $('#full-width #obras').append('<h4>No hay imágenes disponibles</h4>');
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
                    url: "/piptotalpriori/ejecucion/estado/img/delete",
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

        valorizacionSubmit = function(frm){
            event.preventDefault();


            $.ajax({
                url: '/piptotalpriori/ejecucion/estado/add',
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
            $('#dzoneObraEstado').trigger('click');
        };
        fireDZ = function(id){
            var id = id;
            var counter = 0;
            var actual = 0;
            var cleanUp = true;
          $("#full-width #dzoneObraEstado").dropzone({
                uploadMultiple: true,
                autoProcessQueue: false,
                maxFiles: 1,
                parallelUploads: 1,
                maxFilesize: 250,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.mp4,.mkv,.avi",
                previewsContainer: '#dropzonePreviewAntesObraEstado',
                previewTemplate: document.querySelector('#preview-template-ObraEstado').innerHTML,
                addRemoveLinks: true,
                dictRemoveFile: 'Quitar',
                //dictFileTooBig: 'La imagen es mayor a 8MB',
                dictRemoveFileConfirmation: "¿Estas seguro que deseas quitar esta imagen?",
                // The setting up of the dropzone
                createImageThumbnails: true,
                maxThumbnailFilesize: 100,

                init:function() {
                    var dzuid = id;

                    var submitButton = document.querySelector("#submit-allObraEstado");
                    myDropzone = this; // closure

                    submitButton.addEventListener("click", function(event) {
                        event.preventDefault();
                        if($('#fecha').val() !== '') {
                            myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                        } else{
                            $('#submit-allObraEstado').attr('disabled','disabled').addClass('btn btn-alert');
                        }

                    });

                    $('input[type=radio][name=tipo]').change(function() {
                        cleanUp = false;
                        btnState(actual);
                    });
                    this.on("addedfile", function(file) {
                        actual++;
                        console.log(file);
                        btnState(actual);
                    });
                    this.on("maxfilesexceeded", function(){
                        swal(
                                'Error',
                                'Solo Puede subir una imagen!',
                                'error'
                        );
                    });
                    indx = 0;
                    this.on("sendingmultiple", function(file, xhr, formData){
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        var uid = id;
                        var nDate = new Date(file[0].lastModified)



                        var datestring = nDate.getFullYear() + "-" +
                                         ("0"+(nDate.getMonth()+1)).slice(-2) + "-" +
                                         ("0" + nDate.getDate()).slice(-2) + " " +
                                         ("0" + nDate.getHours()).slice(-2) + ":" +
                                         ("0" + nDate.getMinutes()).slice(-2) + ":" +
                                         ("0" + nDate.getSeconds()).slice(-2);

                        console.log(JSON.stringify(file[0]));
                        formData.append('uid',id);
                        formData.append('fecha',datestring);
                        formData.append('cdata', file[0].lastModifiedDate+ ";" + file[0].name + ";" + file[0].lastModified  );
                        formData.append('_token', csrf_token);
                    });
                    this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
                    this.on("removedfile", function(file) {
                        actual--;
                        btnState(actual);
                    });
                },
                error: function(file, response) {
                    $('.validation-message').remove();
                    if(response.error){

                        if(response.messages){
                            var li = "";
                            $.each(response.messages, function( index, value ) {
                                li += "<li>"+ value +"</li>";
                            });

                            $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');

                            swal(
                                'Error',
                                'Error al subir la imagen, intentelo nuevamente!',
                                'error'
                            );
                        } else if(response.message){
                            $('.validation-message').remove();
                            var li = "";

                            $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + response.message + '</div>');

                            swal(
                                'Error',
                                response.message,
                                'error'
                            );
                        }
                    }




                },
                success: function(file,response) {
                    $('.validation-message').remove();
                    var myDropzone = this;
                    $('.serverfilename', file.previewElement).val(response.filename);
                    counter++;
                    $("#photoCounterAntes").text( "(" + counter + ")");

                    //$('#message').html('<div class=\'alert alert-success fade in\'>La imagen se Guardó Exitosamente</div>');
                    cargarImg(id);
                    cleanUp = false;
                    myDropzone.removeAllFiles();
                    swal(
                            'Correcto',
                            'La imágen se guardó correctamente',
                            'success'
                    );
                    //$("#poitaller-table").ajax.reload();
                }
            });
        };

        loadSubEtapa = function(){

            var etapa = $('.modal-scrollable #cboEtapa :selected').val();

            $.ajax({
                url: "{{URL::to('/piptotalpriori/combosubetapa')}}/" + etapa,
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (response) {
                    $(".modal-scrollable #cboSubEtapa").html(response);
                },
                complete: function(response) {
                    $("#loader").hide();
                }
            });
        }

        function btnState(actual){
            if( actual > 0 ){
                $('.modal-scrollable #submit-allObraEstado').show();
                $('.modal-scrollable #btnAddPhotoObraEstado').css('display','none');
            }else{
                $('.modal-scrollable #submit-allObraEstado').css('display','none');
                $('.modal-scrollable #btnAddPhotoObraEstado').show();
            }
        }


        var tableObras;
        loadTableEstadoList = function($id){
            setTimeout(function(){
                tableObras = $('.modal-scrollable #listestado-table').DataTable({
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
                        url: '{{ url("/piptotalpriori/ejecucion/estado/filter") }}',
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
                            targets:   0,
                            render: function (data, type, full, meta) {

                                bEdit = "<button type='button' class='btn btn-primary' onclick='loadfrmEdit(" + data + ")'><i id='E' class='fa fa-pencil' aria-hidden='true'></i></button> ";
                                bDelete = "<button type='button' class='btn btn-danger' onclick='deleteEstado("+ data +")'><i id='S' class='fa fa-trash' aria-hidden='true'></i></button> ";

                                return bEdit + bDelete;
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
                        {data: 'id', name: 'id', orderable: false, searchable: false, width: '10%'},
                        {data: 'fecha_act', name: 'fecha_act', width: '8%'},
                        {data: 'etapa', name: 'etapa', width: '8%'},
                        {data: 'sub_etapa', name: 'sub_etapa', width: '7%', orderable: false},
                        {data: 'est_situ', name: 'est_situ', width: '7%', orderable: false},
                        {data: 'a_fisico', name: 'a_fisico', width: '5%'}
                    ]
                  });

                $.fn.dataTable.ext.errMode = 'none';
              },500);
            }

            deleteEstado = function($id){
                var id = $id;
                swal({
                    title: '¿Estas seguro?',
                    text: "Se eliminara la ejecucion registrada",
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
                        url: "/piptotalpriori/ejecucion/estado/delete",
                        type: 'POST',
                        data: {id: id},
                        success: function (data) {
                            swal(
                                'Listo',
                                'Se ha eliminado la imagen',
                                'success'
                            )

                            tableObras.ajax.reload( null, false );
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
            }

            divMeta = function(){
                if ( $('input[name=tipo]:checked').val() != 'E' ){

                    $('.modal-scrollable #divMeta').show();

                } else {
                    $('.modal-scrollable #divMeta').hide();
                }
            }

        });



</script>

@endsection



@endsection
