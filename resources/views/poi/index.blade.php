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
                <button type="button" class="btn btn-success btn-lg" id = "btnAdd">Agregar Programación</button>
            </div>            
            <br>            
            <div class="row">                                                
                <table id="poitaller-table" data-step="1" data-intro="Gestione la información de cada programación agregada" class="table table-hover table-stripped" cellspacing="0">
                    <thead style="background: #3c8dbc;color: white;">
                        <tr>                                
                            <th></th>
                            <th style="text-align: center;vertical-align: middle">Taller</th>
                            <th style="text-align: center;vertical-align: middle">Fecha</th>
                            <th style="text-align: center;vertical-align: middle">Distrito</th>
                            <th style="text-align: center;vertical-align: middle">Ejecutora</th>
                            <th style="text-align: center;vertical-align: middle">Responsable</th>
                            <th style="text-align: center;vertical-align: middle">Descripción</th>
                            <th style="text-align: center;vertical-align: middle">Acciones</th>
                            @permission('poi-publicar-taller')
                            <th style="text-align: center;vertical-align: middle">Publicada</th>
                            @endpermission
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


    
    <?php
    if( Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){
    ?>
    <!-- ADD TALLER [MODAL] -->
    <div id="modal_add" class="modal container fade" tabindex="-1" id = "containerDt" data-focus-on="input:first" data-backdrop="static" data-keyboard="false">
        <div class="modal-content">
        <form id="frmAddTaller">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" style="text-align: center;">Agregar Programación de Taller</h3>
            </div>
            <div class="m-message"></div>
                <div class="modal-body">
                    <div class="content">                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">DNI Responsable</span>
                                      <input class="form-control" id= "txtDni" name="txtDni" onkeypress="return isNumber(event)" minlength="8" maxlength="8" />
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                      <button class="btn btn-success" type="button" id="btnFindDNI">Buscar</button>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Nombre</span>
                                      <label class="form-control" id= "lblNombres" />
                                    </div>
                                </div>
                                <input type="hidden" name="idUsuario" id="idUsuario">
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Ejecutora</span>
                                      <label class="form-control" id= "lblEjecutora" />
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Intervención</span>
                                      <label class="form-control" id= "lblIntervencion" />
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Actividad</span>
                                      <select class="form-control" id= "cboActividad" name="cboActividad">
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Actividad Operativa</span>
                                      <select class="form-control" id= "cboActividadOperativa" name="cboTaller">
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Docente</span>
                                      <input type="text" name="txtDocente">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Institución Educativa</span>
                                      <input type="text" name="txtIE">
                                    </div>
                                </div>                                
                                <div class="form-group col-xs-12 col-md-6 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon2">Fecha</span>
                                        <input type="text" name="txtFecha" class="form-control datepicker" placeholder="Fecha dd-mm-yyyy" readonly="readonly">
                                    </div>
                                </div>

                                
                                <div class="form-group col-xs-12 col-md-6 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">Distrito</span>
                                        <select class="form-control" id = "cboDistrito" name="cboDistrito" style="width: 100%">
                                        </select>
                                    </div>
                                </div>

                                
                                
                                <!--div class="form-group col-xs-12 col-md-3 col-lg-2">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon">Hora (24h)</span>
                                        <input type="text" class="form-control" style="border-radius: 0;" value="00:00" name="txtHora" maxlength="5" >
                                    </div>                                    
                                </div-->
                                <div class="form-group col-xs-12 col-md-12 col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">Descripción</span>
                                        <textarea name="txtDescripcion" placeholder="Descripción" id="txtDescripcion" class="form-control" rows = 6></textarea>
                                    </div>
                                </div>
                                <!--script type="text/javascript">
                                    $(function(){
                                        $('.time').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm', lang : 'fr', weekStart : 1, cancelText : 'Cancelar' });
                                    });                                    
                                </script-->
                            </div>  
                        </div>                    
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </form>   
        </div>
    </div>
    <?php
    }
    ?>

<script>

    //CLEAN LOCAL STORAGE
    //window.localStorage.clear();
</script>

@section('script')

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
<!--script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
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
            dom: 'lpB<"cboTime">frtip',
            /*initComplete: function () {
                alert('asdasddsa');
                var self = this.api();
                var filter_input = $('#'+settings.nTableWrapper.id+' .dataTables_filter input').unbind();
                var search_button = $('<button type="button">Search</button>').click(function() {
                    self.search(filter_input.val()).draw();
                });
                var clear_button = $('<button type="button">Clear</button>').click(function() {
                    filter_input.val('');
                    search_button.click();
                });

                $(document).keypress(function (event) {
                    if (event.which == 13) {
                        search_button.click();
                    }
                });

                $('#'+settings.nTableWrapper.id+' .dataTables_filter').append(search_button, clear_button);
            },*/
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
                url: '{{ url("poi-filter-data") }}',
                type: 'POST',
                data: function (d) {                                        
                    d.sector = window.location.href.split("/")[window.location.href.split("/").length - 1];                    
                    d.tiempo = $('.cboTime').find(":selected").val();                    
                },
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
                /*{
                    orderable: false,
                    targets:   2,
                    render: function (data, type, full, meta) {
                        
                        
                    }
                },*/
                {
                    orderable: false,
                    targets:   2,
                    render: function (data, type, full, meta) {
                        
                        f_programada = data;
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

                        var today = year+'-'+month+'-'+day;
                        var today1 = year+'-'+month+'-'+day;
                        var f_programada1 = f_programada.split('-');

                        var today = new Date(today);
                        var f_programada = new Date(f_programada);
                        var timeDiff = ( f_programada.getTime() - today.getTime() );

                        diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                        console.log(diffDays);

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
                        } else {
                            f_programada += '<br><label class="label label-warning">Pendiente</label> ';
                        }
                        
                        return f_programada;
                    }
                },
                @permission('poi-publicar-taller'){
                    orderable: false,
                    targets:   -1,
                    render: function (data, type, full, meta) {
                        chk = '';
                        if (data === '1') {                            
                            return "<label class='label label-success'>Publicada</label>";
                        }
                        var tChk;
                            if( meta.row == 0){
                                tChk = 'data-step="7" data-intro="Cuando los datos esten completos, publiquela"';
                            }
                        return '<input class=\"form-input stateSayhuite\" '+tChk+' type=\"checkbox\" onchange=\"publicar(this)\" name="' + full['id'] + '" ' + chk + '>';
                    }
                },@endpermission
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
                        
                        var eImg = 'loadModal("/poi/img","modal_wide","1","' + data + '")';
                        var eView = 'loadModal("/poi/show","full-width","1","' + data + '")';
                        var eDelete = 'deleteTaller("'+ data +'")';
                        var eEdit = 'loadModal("/poi/edit","modal_wide","1","' + data + '")';

                        var tImg;
                        var tView;
                        var tEdit;
                        var tDelete;

                        if(meta.row == 0){
                            tEdit = 'data-step="3" data-intro="Edite programación"';
                            tView = 'data-step="4" data-intro="Vea datos relacionados a una programación"';
                            tImg = 'data-step="5" data-intro="Agregue Foto de ejecución de la programación"';
                            tDelete = 'data-step="6" data-intro="Borre una programación"';    
                        }

                        var bEdit = "";
                        var bView = "";
                        var bDelete = "";
                        var bImg = "";

                        @permission('poi-publicar-taller')
                        bEdit = "<button class='btn btn-primary' "+ tEdit +" onclick = "+ eEdit +"><i class='fa fa-pencil'></i></button> ";
                        @endpermission
                        bView = "<button class='btn btn-info' "+ tView +" onclick = "+ eView +"><i class='fa fa-eye'></i></button> ";
                        bImg = "<button class='btn btn-warning' "+ tImg +" onclick = "+ eImg +"><i class='fa fa-image'></i></button> ";
                        @permission('poi-publicar-taller')
                        bDelete = "<button class='btn btn-danger' "+ tDelete +" onclick = "+ eDelete +"><i class='fa fa-trash'></i></button>";
                        @endpermission

                        return bEdit + bView + bImg + bDelete;
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
                {data: 'activ_operativa', name: 'activ_operativa', width: '30%'},
                {data: 'fecha', name: 'fecha', width: '7%'},
                {data: 'nom_dist', name: 'nom_dist', width: '8%'},
                {data: 'ejecutora', name: 'ejecutora', width: '8%'},
                {data: 'nombre_usuario', name: 'nombre_usuario', width: '10%'},
                {data: 'descripcion', name: 'descripcion', width: '22%'},                
                {data: 'id', name: 'accion', orderable: false, searchable: false , width: '12%'},
                @permission('poi-publicar-taller'){data: 'publicada', name: 'poi_taller_usuario.publicada', width: '5%'}@endpermission
            ]
        });

        $.fn.dataTable.ext.errMode = 'none';

        function addCommas(nStr)
        {
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

        //OPEN MODAL ADD
        $("#btnAdd").click(function(e){
            e.preventDefault();
            $("#modal_add").modal('show', {backdrop: 'true'}).fadeIn('fast');
        });

        $('#modal_add').on('shown.bs.modal', function() {
            $("#txtDescripcion").focus();
        })

        $("#frmAddTaller").submit(function(frm){
            frm.preventDefault();
            var formData = $(frm).serialize();
            console.log(formData);
            $.ajax({
                url: "/poi/add",
                type: 'POST',
                data: $("#frmAddTaller").serialize(),
                timeout: 4000,
                beforeSend: function () {
                     $("#loader").show();                 
                },
                success: function (response) {
                    $('.validation-message').remove();
                        swal(
                            'Guardado',
                            'Los cambios se guardaron exitosamente!',
                            'success'
                            );
                        table.ajax.reload();
                        setTimeout(function(){
                            $('#modal_add').modal('hide');
                            $("#tbl_PoiTaller").trigger("reloadGrid", { fromServer: true});
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
        }); //FIN MODAL ADD

      
        //-- LOAD MODAL
        loadModal = function(url,modaltype,CRUD,opc) {
            $modal = $('#' + modaltype);
            //clean errors
            $(".m-message").html('<div></div>');
            switch (CRUD) {
                //WITH ID [SHOW]
                case '1':
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {'id': opc},
                        beforeSend: function () {
                            $("#loader").show();  
                        },
                        success: function (response) {
                            $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                            $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                            $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                            $('#' + modaltype).modal('show', {backdrop: 'true'});
                        },
                        complete: function(response) {
                            $("#loader").hide();
                                dzoneclick = function(){
                                    $('#dzone').trigger('click');
                                }
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
                                        $(input).after($(input).datepicker('widget'));
                                    }
                                });
                                $("#frmEditTaller").submit(function (e){
                                    e.preventDefault();                
                                    $.ajax({
                                        url: "/poi/update",
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
                                                table.ajax.reload();
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
                                           }else{
                                                html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                                           }
                                        }
                                    });
                                });
                        }
                    });
                    break;
            }
        }

        $("#cboActividad").bind('change',function(ele){

            //console.log($(ele).text());
            Actividad = ele;
            $.ajax({
                url: '/ActividadOperativa/ActividadOperativaxActividad',
                method: 'POST',
                data: {idActividad :$("#cboActividad :selected").val()},
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function(){
                    $("#loader").show();
                },
                success: function(response){
                    html = "<option value=0>-- Seleccionar --</option>";
                    $.each(response,function(key,value){
                        html += "<option value="+key+">"+value+"</option>";
                    });
                    $("#cboActividadOperativa").html(html);
                },
                complete: function(response) {
                    $("#loader").hide();                    
                },
                error: function(jqXHR, textStatus, errorThrown){
                    if (textStatus == 'timeout') {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }            
                        return;
                    }
                    if (jqXHR.status == 500) {
                        //handle error
                    } else {
                        //handle error
                    }
                }                
            });
        });

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


        
        $("#btnFindDNI").click(function(){

            var dni = $("#txtDni").val();

            if ( dni.length < 8 ){
                return false;
            }

            $.ajax({
                url: '/getUserbyDNI/'+ dni,
                type: 'GET',
                timeout:4000,
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function(){
                    $("#loader").show();                    
                    $("#btnFindDNI").prop('disabled',true);
                },
                success: function(response){                                
                    if( response['usuario'] ){                    
                        nombre = response['usuario'].nombres + ', ' + response['usuario'].apellidos;
                        intervencion = response['usuario'].intervencion;
                        ejecutoras = response['usuario'].ejecutora;
                        idU = response['usuario'].idusuario;

                        $("#lblNombres").text(nombre);
                        $("#lblEjecutora").text(ejecutoras);
                        $("#lblIntervencion").text(intervencion);
                        $("#idUsuario").val(idU);
                    }

                    if( response['actividad'] ){
                        var html = "<option value = 0>-- Seleccionar --</option>";
                        $.each(response['actividad'], function($key,$value){
                            html += "<option value = "+$key+">"+$value+"</option>";
                        });

                        $("#cboActividad").html(html);
                    }
                    
                    $("#btnFindDNI").prop('disabled',false);
                },
                complete: function(response) {
                    $("#loader").hide();
                    $("#btnFindDNI").prop('disabled',false);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    if (textStatus == 'timeout') {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }            
                        return;
                    }
                    if (jqXHR.status == 500) {
                        //handle error
                    } else {
                        //handle error
                    }
                    $("#btnFindDNI").prop('disabled',false);
                }
            });    
        });

        publicar = function(elem){
            //$(elem).prop('disabled', true);
            that = elem;
            //console.log(elem);
            if(that.checked){
                st = 1;
                nemesis = false;
            } else {
                st = 0;
                nemesis = true;
            }


            swal({
                title: '¿Estas seguro?',
                text: "Se mostrara publicamente la información de este taller",
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
                    url: "/poi/publicar",
                    type: 'POST',
                    data: {st: st, uid: that.name},
                    success: function (data) {
                        swal(
                        'Listo',
                        'Se ha publicado información del taller',
                        'success'
                        )

                        table.ajax.reload();
                    },
                    error: function(jqXHR,error, errorThrown){
                       html = "";
                       if(jqXHR.status&&jqXHR.status==403){
                            data = $.parseJSON(jqXHR.responseText);                             
                            swal(
                                    'Error',
                                    data.message,
                                    'error'
                            )
                       }else{
                            html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                       }
                       $(that).prop('checked',nemesis);
                    }
                });
                
            }, function(dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                $(that).prop('checked',nemesis);
                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            }).catch(swal.noop);
        };

        deleteTaller = function(id){
            console.log(id);
            swal({
                title: '¿Estas seguro?',
                text: "Se eliminará la programación",
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
                    url: "/poi/delete",
                    type: 'POST',
                    data: {id: id},
                    success: function (data) {
                        swal(
                        'Listo',
                        'Se elimino la programación',
                        'success'
                        )

                        table.ajax.reload();
                    },
                    error: function(jqXHR,error, errorThrown){
                       html = "";
                       if(jqXHR.status&&jqXHR.status==403){
                            data = $.parseJSON(jqXHR.responseText);                             
                            swal(
                                    'Error',
                                    data.message,
                                    'error'
                            )
                       }else{
                            html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                       }
                       //$(that).prop('checked',nemesis);
                    }
                });
                
            }, function(dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                //$(that).prop('checked',nemesis);
                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            }).catch(swal.noop);  
        };


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


       

</script>

@endsection



@endsection