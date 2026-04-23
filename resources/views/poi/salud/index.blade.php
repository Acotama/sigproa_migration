@extends('starter')
@section('htmlhead')
<style>

    .dt-center {
        text-align: center;
    }

    /*REWRITING TEXTBOX STYLES */
    /* TEXTBOX */    
  

    #poisalud-table tr{
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
    /*.form-control{
        background-color: rgba(51, 122, 183, 0.32)!important;
        border:0px;        
        border-radius: 0px 4px 4px 0px !important;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled]{
        background-color: rgba(51, 122, 183, 0.32)!important;
        font-size: 12px;
        border-radius: 0px 4px 4px 0px !important;        
    }*/

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
        <div class="content">   
            <div class="row">
                <label onclick="startTour();" class="pull-right"><i class="fa fa-question-circle fa-2x fa-hover" aria-hidden="true"></i><span style="font-size: 18px;font-weight: bold"> Ayuda</span></label>
            </div>
                     
            <br>            
            <div class="row">
                <table id="poisalud-table" data-step="2" class="table table-hover table-stripped" cellspacing="0">
                    <thead style="background: #3c8dbc;color: white;">
                        <tr>
                            <th></th>
                            <th style="text-align: center;vertical-align: middle">Documento</th>
                            <th style="text-align: center;vertical-align: middle">Fecha Nacimiento</th>
                            <th style="text-align: center;vertical-align: middle">Doc. Ident. Apoderado</th>
                            <th style="text-align: center;vertical-align: middle">Nombre de Madre</th>
                            <th style="text-align: center;vertical-align: middle">Años</th>
                            <th style="text-align: center;vertical-align: middle">Meses</th>
                            <!--th style="text-align: center;vertical-align: middle">Establecimiento Salud</th-->
                            <th style="text-align: center;vertical-align: middle">Acciones</th>
                    </thead>
                </table>
            </div>
        </div>

@section('script')

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
<script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src= "https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>


<link rel="stylesheet" type="text/css" href="{{ asset('/plugins/pickadate/compressed/themes/default.date.css') }}">
<script type="text/javascript" src="{{ asset('/plugins/pickadate/compressed/picker.js') }}"></script> 
<script type="text/javascript" src="{{ asset('/plugins/pickadate/compressed/picker.date.js') }}"></script> 

<script>

    $(document).ready(function(){

        var table = $('#poisalud-table').DataTable({
            lengthMenu: [[10, 25, 50,1000], [10, 25, 50, 1000]],
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            autoWidth: false,
            stateSave: false,
            order: [[ 2, "desc" ]],
            dom: 'lpB<"cboTime">frtip',
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
                url: '{{ url("poi/salud/filter/programacion") }}',
                type: 'POST',
                data: function (d) {                                        
                                
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
                    targets:   -1,
                    render: function (data, type, full, meta) {

                        bevent = 'window.location.assign("/poi/salud/control/'+data+'")';

                        var bAdd = "<button class='btn btn-primary' onclick = 'loadfrmImg("+data+")' href=''><i class='fa fa-plus'></i></button> ";
                        var bList = "<button class='btn btn-success' onclick = 'loadfrmListDetail("+data+");loadTableIntervencionesList("+data+");' href=''><i class='fa fa-list'></i></button> ";

                        var bControl = "<button class='btn btn-danger' onclick = '"+bevent+"'><i class='fa fa-calendar'></i></button> ";

                        return bList + bAdd + bControl;
                    }
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
                {data: '', name: 'accion', orderable: false, searchable: false, width: '1%'},
                {data: 'nro_doc', name: 'nro_doc', width: '7%'},
                {data: 'fecha_nac', name: 'fecha_nac', width: '7%'},
                {data: 'nro_doc_madre', name: 'nro_doc', width: '7%'},
                {data: 'nom_madre', name: 'nom_madre', width: '7%', orderable: false, searchable: false},
                {data: 'edad_year', name: 'edad_year', width: '7%'},
                {data: 'edad_month', name: 'edad_month', width: '7%'},
                {data: 'id', name: 'accion', orderable: false, searchable: false , width: '12%'}
            ]
        });

        $.fn.dataTable.ext.errMode = 'none';

        reloadTable = function (){
           table.ajax.reload( null, false );
        }
    
        $(".dateSearch").change(function (){
           reloadTable();
        });

        $("#cboEstado").change(function (){
           reloadTable();
        });

        //DATEPICKER INICIALIZATION
        $(".datepicker").pickadate();

        var idPaciente;
        loadfrmImg = function(id){
            idPaciente = id;
          $.ajax({
                url: '/poi/salud/img',
                type: 'POST',
                data: {'id': id},
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
                     //DATEPICKER INICIALIZATION
                    $(".datepicker").pickadate({
                        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Dic'],
                        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                        // Buttons
                        today: 'Hoy',
                        clear: 'Limpiar',
                        close: 'Cerrar',
                        format: 'yyyy-mm-dd',
                    });
                    //fireDZ(id);
                    //cargarImg(id);
                    //FANCYBOX INIT
                    $(".fancybox").fancybox();                        
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }

        loadfrmEdit = function(id){
            idPaciente = id;
            $.ajax({
                url: '/poi/salud/intervencion/edit',
                type: 'POST',
                data: {'id': id},
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
                     //DATEPICKER INICIALIZATION
                    $(".datepicker").datepicker({
                        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
                        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        dateFormat: "dd-mm-yy",
                        yearRange: '2000:2020',
                        changeMonth: true,
                        changeYear: true,
                        maxDate: '+30Y',
                        beforeShow: function(input, obj) {
                            //$(input).after($(input).datepicker('widget'));
                            setTimeout(function(){
                                $('.ui-datepicker').css('z-index', 99999999999999);
                            }, 0);
                        }
                    });
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

        cargarImg = function(id){
            var imguid = id;
            $.get('/poi/salud/img/get/' + imguid.toString(), function(data) {
                $('.modal-scrollable #poi').html('');
                //console.log(data.taller_img.length);
                if(data.atencion_img.length != 0){
                    $.each(data.atencion_img, function (key, value) {

                        url = '/images' + value.url + "/" + value.nombre;
                $('.modal-scrollable #poi')
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
                    $('.modal-scrollable #poi').append('<h4>No hay imágenes disponibles</h4>');
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
                    url: "/poi/salud/img/eliminar",
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
            $('#dzone').trigger('click');
        };

        var fireDZ = function(id){
            var id = id;
            var counter = 0;
            var actual = 0;
            var cleanUp = true;    ;
          $(".modal-scrollable #dzone").dropzone({

                uploadMultiple: true,
                autoProcessQueue: false,
                maxFiles: 1,
                parallelUploads: 1,
                maxFilesize: 250,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.mp4,.mkv,.avi",
                previewsContainer: '#dropzonePreviewAntes',
                previewTemplate: document.querySelector('#preview-template').innerHTML,
                addRemoveLinks: true,
                dictRemoveFile: 'Quitar',
                //dictFileTooBig: 'La imagen es mayor a 8MB',
                dictRemoveFileConfirmation: "¿Estas seguro que deseas quitar esta imagen?",
                // The setting up of the dropzone
                createImageThumbnails: true,
                maxThumbnailFilesize: 100,
                accept: function(file, done) {
                    var mime_type = file.type;
                    if ( mime_type != 'image/gif'){
                        this.options.resizeWidth = 650;
                        this.options.resizeMimeType = 'image/jpeg';
                        this.options.resizeQuality = 0.55;
                        console.log(this.options);
                        done();
                        return;
                    }
                    done();
                },
                init:function() {
                    var dzuid = id;
                    //var uid = document.getElementById('uid').value;

                    var submitButton = document.querySelector("#submit-all");
                    myDropzone = this; // closure

                    submitButton.addEventListener("click", function(event) {
                        event.preventDefault();
                        if($('#fecha').val() !== '') {
                            myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                        } else{
                            $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
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
                    } else {
                         $('.validation-message').remove();
                            var li = "";                            

                            /*$('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>Revise su conexión a internet o contactese con el administrador</div>');                            */
                            $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>'+response+'</div>')
                            swal(
                                'Error',
                                'Error',
                                'error'
                            );
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

        function btnState(actual){
            if( actual > 0 ){
                $('#submit-all').show();
                $('#btnAddPhoto').css('display','none');
            }else{
                $('#submit-all').css('display','none');
                $('#btnAddPhoto').show();
            }                
        }

        addIntervencion = function(form){ 
            $.ajax({
                url: '/poi/salud/intervencion/save',
                type: 'POST',                
                data: $(form).serialize(),
                beforeSend: function () {
                    $("#loader").show();
                    $('.modal-scrollable #btnAddIntervencion').prop('disabled', true);
                },
                success: function (response) {                    
                    console.log(response);
                    swal(
                        'Correcto',
                        response.message,
                        'success'
                    );
                    //MOSTRAR SUBIDA IMAGEN
                    $(".modal-scrollable .hide-not-record").show();                    
                    fireDZ(response.data);                    
                    $('.modal-scrollable #btnAddIntervencion').remove();
                },
                complete: function(response) {
                    $("#loader").hide();
                },
                 error: function(jqXHR,error, errorThrown){
                    $("#loader").hide();                
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
                    $('.modal-scrollable #btnAddIntervencion').prop('disabled', false);
                }
            });
        }

        updateIntervencion = function(form){
            $.ajax({
                url: '/poi/salud/intervencion/update',
                type: 'POST',                
                data: $(form).serialize(),
                beforeSend: function () {
                    $("#loader").show();
                    $('.modal-scrollable #btnUpdateIntervencion').prop('disabled', true);
                },
                success: function (response) {                    
                    console.log(response);
                    swal(
                        'Correcto',
                        response.message,
                        'success'
                    );
                    //MOSTRAR SUBIDA IMAGEN                    
                    $('.modal-scrollable #btnUpdateIntervencion').remove();
                },
                complete: function(response) {
                    $("#loader").hide();
                },
                 error: function(jqXHR,error, errorThrown){
                    $("#loader").hide();                
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
                    $('.modal-scrollable #btnUpdateIntervencion').prop('disabled', false);
                }
            });  
        }

        editIntervencion = function(form){
        }

        //DOSIS
        loadDosis = function(ele){
            var act_op_id = $(ele).find('option:selected').val();
            
            $.ajax({
                url: '/poi/salud/intervencion/dosis',
                type: 'POST',
                data: {'id': act_op_id, 'idpaciente':idPaciente},
                beforeSend: function () {
                    $("#loader").show();  
                },
                success: function (response) {
                    console.log(response)
                    html = "<option value=''>--Seleccionar--</option>"
                    $.each( response, function( i, val ) {
                        html += "<option value='"+val['id']+"'>"+val['denom']+"</option>"                        
                    });

                    $("#cboDosis").html(html)
                    console.log(response);
                },
                complete: function(response) {
                    $("#loader").hide();
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }

        //INTERVENCIONES
        loadfrmListDetail = function(id){
            $.ajax({
                url: '/poi/salud/intervencion/list',
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
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }
        var tableIntervenciones;
        loadTableIntervencionesList = function($id){
            setTimeout(function(){
                tableIntervenciones = $('.modal-scrollable #listintervenciones-table').DataTable({          
                    processing: true,
                    serverSide: true,
                    orderCellsTop: true,
                    autoWidth: false,
                    stateSave: false,
                    dom: 'rt',            
                    responsive: {
                        details: {
                            type: 'column'
                        }
                    },
                    ajax: {
                        url: '{{ url("/poi/salud/filter/intervenciones") }}',
                        type: 'POST',
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
                                bDelete = "<button type='button' class='btn btn-danger' onclick='deleteIntervencion("+ data +")'><i id='S' class='fa fa-trash' aria-hidden='true'></i></button> ";

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
                        {data: 'meses', name: 'meses', width: '8%'},                        
                        {data: 'estado', name: 'estado', width: '8%'},
                        {data: 'observacion', name: 'observacion', width: '8%'},
                        {data: 'created_at', name: 'created_at', width: '8%'}
                    ]
                  });
                //$.fn.dataTable.ext.errMode = 'none';
            },500);
        }

        deleteIntervencion = function($id){

        }



    });

     
       

</script>

@endsection



@endsection