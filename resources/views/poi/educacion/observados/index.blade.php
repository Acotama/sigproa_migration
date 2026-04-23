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
<div class="content">

    <div class="row">
        <div class="col-md-4">
            Tipo Act.: 
            <select id="cboTipAct"  onchange="reloadTable();">
                <option value="">Todo</option>
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
                
                <option value="ASISTENCIA PP-106">ASISTENCIA PP-106</option>
                <option value="MATERIALES PP-106">MATERIALES PP-106</option>
                <option value="VISITA PP-106">VISITA PP-106</option>
                <option value="TALLER PP-106">TALLER PP-106</option>
                <option value="MONITOREO PP-106">MONITOREO PP-106</option>
                <option value="CAMPAÑA PP-106">CAMPAÑA PP-106</option>
                
                <option value="VISITA PP-068">VISITA PP-068</option>
                <option value="CAPACITACIÓN  PP-068">CAPACITACIÓN  PP-068</option>
                
                <option value="CAPACITACIÓN  PP-051">CAPACITACIÓN  PP-051</option>                            
                <option value="APLICACION DE ESTRAT. PP-051">APLICACION DE ESTRAT. PP-051</option>
                <option value="APLICACIÓN DEL PROG. PP-051">APLICACIÓN DEL PROG. PP-051</option>
                <option value="CAPACITACIÓN DOCENTES PP-051">CAPACITACIÓN DOCENTES PP-051</option>
                
            </select>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <input type="text" id="txtSearch" onkeypress="if (event.keyCode==13){ reloadTable(); }">
            <button class="btn btn-primary" onclick="reloadTable()">Buscar</button>
        </div>
    </div>
    <br>
    <div class="row">
        <table id="poitaller-table" data-step="2" data-intro="Gestione la información de cada programación agregada" class="table table-hover table-stripped" cellspacing="0">
            <thead style="background: #3c8dbc;color: white;">
                <tr>
                    <th></th>
                    <th style="text-align: center;vertical-align: middle">Actividad</th>
                    <th style="text-align: center;vertical-align: middle">UGEL</th>
                    <th style="text-align: center;vertical-align: middle">Responsable</th>
                    <th style="text-align: center;vertical-align: middle">Fecha Creación/Modificación</th>
                    <th style="text-align: center;vertical-align: middle">Fecha de Foto</th>
                    <th style="text-align: center;vertical-align: middle">Acciones</th>
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
                url: '{{ url("poi/educacion/filter/observados") }}',
                type: 'POST',
                data: function (d) {
                    //d.sector = window.location.href.split("/")[window.location.href.split("/").length - 1];
                    //d.inicio          = $('#dateB').val();
                    d.search['value'] = $('#txtSearch').val();
                    //d.fin             = $('#dateE').val();
                    //d.estado          = $('#cboEstado :selected').val();
                    d.ugel            = $('#cboUgel :selected').val();
                    d.tipact          = $('#cboTipAct :selected').val();

                    //$('#inicio').val(d.inicio);
                    //$('#fin').val(d.fin);
                    //$('#estado').val(d.estado);
                    $('#search').val(d.search['value']);
                    $('#ugel').val(d.ugel);
                    $('#cboTipAct').val(d.tipact);
                }
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
                    targets:   -1,
                    render: function (data, type, full, meta) {

                        eImg = 'loadFrmCoincidencias("' + data + '")';

                        var tImg;

                        var bView = "";
                        var bImg = "";

                        bImg = "<button class='btn btn-warning' "+ tImg +" onclick = "+ eImg +"><i class='fa fa-image'></i></button> ";

                        return bImg;
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
                {data: 'tipo_activ_operativa', name: 'vw_poi_taller_usuario_educacion.tipo_activ_operativa', orderable: false, searchable: false, width: '10%'},
                {data: 'ejecutora', name: 'vw_poi_taller_usuario_educacion.ejecutora', orderable: false, searchable: false, width: '10%'},
                {data: 'nombre_usuario', name: 'vw_poi_taller_usuario_educacion.nombre_usuario', orderable: true, searchable: false, width: '10%'},
                {data: 'created_at', name: 'poi_taller_img.created_at', width: '7%', orderable: true},
                {data: 'fecha', name: 'poi_taller_img.fecha', width: '7%', orderable: true},
                {data: 'idimg', name: 'poi_taller_img.idimg', width: '7%', orderable: true}
            ],
            initComplete: function (data) {

            }
        });

        reloadTable = function (){
           table.ajax.reload( null, false );
        }

        $.fn.dataTable.ext.errMode = 'none';
        //EVENTOS

        cargarCoincidencias = function (id){
            var imguid = id;
            $.get('/poi/educacion/img/coincidencias/' + imguid.toString(), function(data) {
                $('.modal-scrollable #all-coincidencias').html('');
                console.log(data);
                if(data.semejantes.length != 0){
                    $.each(data.semejantes, function (key, value) {

                    url = '/images' + value.url + "/" + value.nombre;

                    var celular = value.celular;

                    if(!value.celular){
                        celular = ' -';
                    }
                    
                    var exif = '';
                    var imgname = '';

                    if ( value.exif == 0 ){
                        exif = "<br><label class='label label-warning'>Modificado/Creado PC</label>";

                        imgname = '<br><label class="label label-default">'+value.imgcdata.split(';')[1];+'</label>'
                    }

                    var htmltmp = `<br>
                                <table class="table table-bordered" width='100%'>
                                    <tr>
                                        <td style="font-weight:bold;" width="20%">Fecha Taller</td>
                                        <td width="20%">`+value.fecha_programacion+`</td>
                                        <td style="font-weight:bold;" width="20%">Fecha Fotografía</td>
                                        <td style="text-align:center;" width="20%">`+value.fecha 
                                                         + exif 
                                                         + imgname
                                                         + `</td>
                                        <td width="20%" style="border:0px; margin:0px;padding:0px;" rowspan="4">
                                         <div style="border:1px solid;">
                                              <a class="fancybox" rel="group" href="`+ url +`">
                                                  <img width=100% height=150px src="`+ url +`" alt="" />
                                              </a>
                                          </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">I.E. </td>
                                        <td>`+value.ie+`</td>
                                        <td style="font-weight:bold;">Docente</td>
                                        <td>`+value.docente+`</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Código Taller </td>
                                        <td>`+value.codigo_taller+`</td>
                                        <td style="font-weight:bold;">Usuario</td>
                                        <td>`+value.username+`</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Nombre </td>
                                        <td>`+value.apellidos+ `, ` +value.nombres +`</td>
                                        <td style="font-weight:bold;">Telefono</td>
                                        <td>`+celular+`</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Dependencia </td>
                                        <td>`+value.sigla+ `</td>
                                        <td> </td>
                                        <td> </td>
                                        <td style="text-align:center;">
                                            <button onclick = "deleteImg(`+value.id+`,`+id+`)" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Borrar
                                            </button>
                                            <button onclick = "quitarImg(`+value.id+`,`+id+`)" class="btn btn-warning">
                                                <i class="fa fa-minus-circle"></i> Quitar
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                `;

                    $('.modal-scrollable #all-coincidencias').append(htmltmp);

                });

                } else {
                    $('.modal-scrollable #all-coincidencias').append('<h4>No hay imágenes disponibles</h4>');
                }

            });
        };

        loadFrmCoincidencias = function (id){
          $.ajax({
                url: '/poi/educacion/observados/detail',
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
                    cargarCoincidencias(id);
                    //FANCYBOX INIT
                    $(".fancybox").fancybox();
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }        
            
        borrarRelacion = function($id){
            var id = $id;
            swal({
                title: '¿Estas seguro?',
                text: "Se eliminara esta relación",
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
                    url: "/poi/educacion/observados/borrarRelacion",
                    type: 'POST',
                    data: {id: id},
                    success: function (data) {                        
                        $('#full-width').modal('hide');
                        swal(
                            'Listo',
                            'Se ha eliminado la relacion',
                            'success'
                        )                        

                        table.ajax.reload( null, false );
                    },
                    error: function(e){
                        swal(
                        'Error',
                        'Error al eliminar la relación',
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

        quitarImg = function($id, $idTaller){
            var id = $id;
            swal({
                title: '¿Estas seguro?',
                text: "Se quitara la imagen de la relación",
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
                    url: "/poi/educacion/observados/quitarImagen",
                    type: 'POST',
                    data: {id: id},
                    success: function (data) {
                        loadFrmCoincidencias($idTaller);
                        $('#full-width').modal('hide');
                        swal(
                            'Listo',
                            'Se ha eliminado la imagen  de la relacion',
                            'success'
                        )                        

                        table.ajax.reload( null, false );
                    },
                    error: function(e){
                        swal(
                        'Error',
                        'Error al eliminar la imagen de la relación',
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

        deleteImg = function($id, $idTaller){
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
                        loadFrmCoincidencias($idTaller);

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
    });

</script>

@endsection



@endsection
