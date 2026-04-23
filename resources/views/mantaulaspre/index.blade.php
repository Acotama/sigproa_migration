@extends('starter')
@section('htmlhead')


<!-- JqueryUI -->
<link rel="stylesheet" href="{{ asset('librerias/jquery-ui/themes/redmond/jquery-ui.min.css') }}">
<!-- DROPZONE -->
<link rel="stylesheet" href="{{ asset('librerias/dropzone/dropzone.min.css') }}">
<!-- jqGRID -->
<link rel="stylesheet" href="{{asset('plugins/jqgrid/css/ui.jqgrid.css')}}"/>
<link rel="stylesheet" href="{{asset('plugins/jqgrid/plugins/css/ui.multiselect.min.css')}}"/>
    <style>
        .dt-button{
            background-color: red !important;
        }
        .buttons-print {
            background-image: linear-gradient(to bottom, #e9e9e9 0%, #e9e9e9 100%) !important;
            color: black !important;
        }
        .buttons-excel {
            background-image: linear-gradient(to bottom, #e9e9e9 0%, #e9e9e9 100%) !important;
            background-color: blue !important;
            color: black !important;
        }
        .dtcolunm-search{
            padding: 0 !important;
            background-color: #f8fff9;
        }

        .table-stripedd>tbody>tr:nth-child(odd)>td,
        .table-stripedd>tbody>tr:nth-child(odd)>th {
            background-color: rgb(181, 212, 230);
        }

        .table-hoverr tbody tr:hover td, .table-hoverr tbody tr:hover th {
            background-color: rgba(38, 255, 47, 0.11);
        }
        .wrapColumnText
        {
            white-space: normal !important;
            height:auto;
            vertical-align:text-top;
        }
        .ui-jqgrid .ui-jqgrid-labels th.ui-th-column {
            background-color: #3c8dbc;
            background-image: none;
            color: white;
        }

        /* MULTILINE HEADER */
        th.ui-th-column div{
            white-space:normal !important;
            height:auto !important;
            padding:2px;
        }

    </style>

@endsection
@section('body')

    <div class="col-md-12 main">
        <div class="row">
            <h2 style="font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif"><center><b><u>AULAS PREFABRICADAS</u></b></center></h2>
            <div class="container-fluid">
                <br>
                <div class="row">
                    <div id='gridwrapper' class='gridWrapper'>
                        <table id='list2'><tr><td></td></tr></table>
                        <div id='pager2'></div>
                    </div>
                </div>
                <br>
                <!--div class="row table-responsive">
                    <table id="list2"></table>
                    <div id="pager2"></div>
                </div-->

            </div>
        </div>


</div>


<!-- JQUERY UI -->
<script src="{{ asset('librerias/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- DROPZONE -->
<script src="{{ asset('/librerias/dropzone/dropzone.js') }}"></script>
<!-- JqGRID -->
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/jquery.jqgrid.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/plugins/ui.multiselect.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/plugins/jquery.contextmenu.js')}}"></script>

    <script>
        var scw = $(window).width();
        scw -= 300;
        var lastsel;
        var lastselHover;
        $(document).ready(function () {

            table = $("#list2");
            table.jqGrid({
                url: '{{ url("/filter-data-aulasprefabricadas") }}',
                datatype: "json",
                mtype: 'POST',
                shrinkToFit: false,
                viewrecords: true,
                width:scw,
                colNames: [
                    'Provincia',
                    'Codigo Provincia',
                    'Distrito',
                    'Codigo Distrito',
                    'Centro Poblado',
                    'Dirección',
                    'Altitud',
                    'Nombre de IE',
                    'Número de Aulas Entregadas',
                    'Situación Actual',
                    'Codigo Modular',
                    'Codigo Local',
                    'id',
                    'UGEL',
                    'Director',
                    'Nivel',
                    'Caracteristica',
                    'Cantidad de Alumnos',
                    'Cantidad de Docentes',
                    'Cantidad de Secciones'
                ],

                colModel: [
                     {
                        name: 'provincia',
                        index: 'provincia',
                        width: 80,
                        align:'left',
                        sortable: false,
                        editable: false,
                        title: false,
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        fixed:true,
                        frozen:true,
                        name: 'cod_prov',
                        index: 'cod_prov',
                        width: 100,
                        align:'center',
                        title: false,
                        classes: 'wrapColumnText',
                        sortable:true,
                        editable: true,
                        hidden:true,
                        sorttype: 'string',
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'distrito',
                        index: 'distrito',
                        width: 80,
                        align:'left',
                        title: false,
                        fixed: true,
                        classes: 'wrapColumnText',
                        editable: true,
                        sortable:true,
                        search:false,
                        hidden: true,
                        sorttype: 'string',
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'cod_dist',
                        index: 'cod_dist',
                        width: 200,
                        align:'center',
                        title: false,
                        classes: 'wrapColumnText',
                        sortable:true,
                        editable: true,
                        hidden: true,
                        sorttype: 'string',
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'centro_problado',
                        index: 'centro_problado',
                        title: false,
                        width: 80,
                        search:false,
                        fixed: true,
                        sortable: true,
                        editable: true,
                        align: "left",
                        classes: 'wrapColumnText',
                        sorttype: 'string',
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'direccion',
                        index: 'direccion',
                        search:false,
                        width: 150,
                        title: false,
                        fixed: true,
                        align: "left",
                        editable: true,
                        classes: 'wrapColumnText',
                        sorttype: 'string',
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'altitud',
                        index: 'altitud',
                        width: 70,
                        search:false,
                        sortable: true,
                        editable: true,
                        title: false,
                        hidden: true,
                        align: "center",
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'listado_final',
                        index: 'listado_final',
                        width: 250,
                        search:false,
                        fixed: true,
                        title: false,
                        editable: true,
                        align:'left',
                        classes: 'wrapColumnText',
                        sorttype: 'string',
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'nro_aula',
                        index: 'nro_aula',
                        width: 80,
                        search:false,
                        sortable: true,
                        title: false,
                        editable: true,
                        align: "right",
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'situacion_actual',
                        index: 'situacion_actual',
                        width: 70,
                        search:false,
                        sortable: true,
                        classes: 'wrapColumnText',
                        editable: true,
                        title: false,
                        align: "center",
                        sorttype: 'string',
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'cod_modular',
                        index: 'cod_modular',
                        align: 'center',
                        sortable: true,
                        width: 120,
                        editable: true,
                        title: false,
                        search:false,
                        edittype: 'text'
                    },
                    {
                        name: 'cod_local',
                        index: 'cod_local',
                        width: 80,
                        editable: true,
                        sorttype: 'string',
                        search:false,
                        title: false,
                        sortable:false,
                        align:'center',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'id',
                        index: 'id',
                        width: 20,
                        hidden: true,
                        title: false,
                        search: false
                    },
                    {
                        name: 'ugel',
                        index: 'ugel',
                        align: 'center',
                        sortable: true,
                        title: false,
                        width: 120,
                        classes: 'wrapColumnText',
                        editable: true,
                        edittype: 'text',
                        search:true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'director',
                        index: 'director',
                        align: 'right',
                        width: 100,
                        title: false,
                        editable: true,
                        sorttype: 'string',
                        hidden: true,
                        search:false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name:'nivel',
                        index:'nivel',
                        width:80,
                        editable:true,
                        title: false,
                        align:'right',
                        search:true,
                        classes: 'wrapColumnText',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name:'caracteristica',
                        index:'caracteristica',
                        width:100,
                        editable:true,
                        title: false,
                        align:'right',
                        classes: 'wrapColumnText',
                        search:false
                    },
                    {
                        name: 'alumno',
                        index: 'alumno',
                        width: 70,
                        search:false,
                        sortable: true,
                        title: false,
                        editable: true,
                        align: "right",
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'docente',
                        index: 'docente',
                        width: 70,
                        search:false,
                        sortable: true,
                        title: false,
                        editable: true,
                        align: "right",
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'seccion',
                        index: 'seccion',
                        width: 70,
                        search:false,
                        sortable: true,
                        title: false,
                        editable: true,
                        align: "right",
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    }
                ],
                //loadonce:true,
                rowNum: 100,
                rowList: [10, 20, 30, 100, 200, 300],
                pager: '#pager2',
                sortname: 'nro_aula',
                gridComplete: function () {

                    //var data = table.jqGrid('getGridParam','data');
                    //console.log(data[0]);
                    var ids = table.jqGrid('getDataIDs');
                    for (var i = 0; i < ids.length; i++) {
                        var cl = ids[i];
                        var event = 'loadModal("mantaulaspre/images","full-width","1","' + cl + '")';
                        bai = "<button style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Anexar Imagen' type='button' class='e' onclick='" + event + "'\"><i id='A' class='fa fa-picture-o fa-lg e' aria-hidden='true'></i></button>";

                        table.jqGrid('setRowData', ids[i], {act: bai/* + be + se + ce ,chkSayhuite:be*/});
                    }
                },
                loadComplete: function (data) {

                },
                sortorder: "desc",
                caption: "Aulas Prefabricadas",
                rownumbers: true,
                editurl: "{{URL::to('mantaulaspre/update')}}"
            });

            table.jqGrid('setFrozenColumns');//FIXED COLUMNS ACTIVATE

            table.jqGrid('setGroupHeaders', {
                useColSpanStyle: true,
                groupHeaders: [
                    { startColumnName: 'aeo', numberOfColumns: 4, titleText: '<span id="generales">Datos generales</span>'},
                    { startColumnName: 'monto', numberOfColumns: 10, titleText: '<span id="fisica">Avance Financiero</span>' },
                    { startColumnName: 't_ejec_dia', numberOfColumns: 2, titleText: '<span id="financiera">Avance Fisico</span>' },
                    { startColumnName: 'est_proyec', numberOfColumns: 3, titleText: '<span id="situacional">Datos de estado Situacional</span>'}
                ]
            });

            $(function () {
                $("#generales").parent().addClass("generales");
                $("#fisica").parent().addClass("fisica");
                $("#financiera").parent().addClass("financiera");
                $("#situacional").parent().addClass("situacional");
            });
            table.jqGrid('filterToolbar', {searchOperators: true});


        });
    </script>

    <script>
        $(function(){
            $.fn.modalmanager.defaults.resize = true;
        });
    </script>

    <script>

        function loadModal(url,modaltype,CRUD,opc) {
            $modal = $('#' + modaltype);
            //clean errors
            $(".m-message").html('<div></div>');
            switch (CRUD) {
                case '1':
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {'id': opc},
                        beforeSend: function () {
                            // $("#error").fadeOut();
                        },
                        success: function (response) {
                            $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                            $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                            $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                            $('#' + modaltype).modal('show', {backdrop: 'true'});
                        }
                    });
                    break;
            }
        }

        sayhuite = function(elem) {
            //$(elem).prop('disabled', true);
            that = elem;
            //console.log(elem);
            if (that.checked) {
                st = 1;
                nemesis = false;
            } else {
                st = 0;
                nemesis = true;
            }


            swal({
                title: '¿Estas seguro?',
                text: "Esto controla que los proyectos se muestren o no en Sayhuite",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No, cancelar!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true
            }).then(function () {
                console.log(that.name);
                $.ajax({
                    url: "/",
                    type: 'POST',
                    data: {st: st, uid: that.name},
                    success: function (data) {
                        $("#list2").trigger("reloadGrid", { fromServer: true});
                    }
                });
                swal(
                        'Listo',
                        'La visibilidad del proyecto se ha cambiado',
                        'success'
                )

            }, function (dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                $(that).prop('checked', nemesis);
                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            }).catch(swal.noop);
        };
    </script>

@stop
