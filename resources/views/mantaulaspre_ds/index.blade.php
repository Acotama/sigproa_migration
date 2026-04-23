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
        /* SCROLLBAR JQGRID */
        .gridWrapper{
            width: 100%;
            overflow:auto; /* <---set the overflow to auto*/
        }
        .ui-jqgrid-bdiv{
            max-height: 500px;
        }

        .generales{
            color: white !important;
            background-color: rgb(236,128,20) !important;
        }
        .fisica{
            color: white !important;
            background-color: rgb(22,54,92) !important;
        }
        .financiera{
            color: white !important;
            background-color: rgb(79,98,40) !important;
        }
        .situacional{
            color: white !important;
            background-color: rgb(79,98,40) !important;
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
    <script type="text/javascript">
        $.jgrid.no_legacy_api = true;
        $.jgrid.useJSON = true;
    </script>

@endsection
@section('body')

    <div class="col-md-12 main">
        <div class="row">
            <h2 style="font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif"><center><b><u>AULAS PREFABRICADAS</u></b></center></h2>
            <div class="container-fluid">
                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button style='height:30px;width:30px;' title='Editar' type='button' onclick='fEdit();'><i class='fa fa-edit fa-lg'></i> </button>
                        <button style='height:30px;width:30px;' title='Guardar' type='button' onclick='fSave();'><i class='fa fa-save fa-lg'></i> </button>
                        <button style='height:30px;width:30px;' title='Cancelar' type='button' onclick='fCancel();'><i class='fa fa-ban fa-lg'></i> </button>
                    </div>
                </div>
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
                url: '{{ url("/filter-data-mantaulaspre") }}',
                datatype: "json",
                mtype: 'POST',
                shrinkToFit: false,
                //autowidth: true,
                //shrinkToFit: false,
                //forceFit: true,
                //focusField: true,
                //gridview: true,
                viewrecords: true,
                width:scw,
                //loadonce:true,
                colNames: [
                    'Accion',
                    'Actividad',
                    'Poblacion Beneficiada',
                    'id',
                    'Situación',
                    'Fecha de Inicio',
                    'Fecha Fin',
                    'Unidad de medida',
                    'Cantidad',
                    //-- FINANCIERA
                    'Total',//.
                    'Avance Financiero',//.
                    'Avance Fisico',//contrapartida
                    'Año de ejecucion Fisica',//.
                    'Año de ejecución Financiera'],
                colModel: [
                    {
                        name: 'act',
                        index: 'act',
                        width: 38,
                        align:'center',
                        sortable: false,
                        editable: false,
                        search: false,
                        fixed: true,
                        frozen:true
                    },
                    {
                        fixed:true,
                        frozen:true,
                        name: 'nom_activ',
                        index: 'nom_activ',
                        width: 300,
                        align:'center',
                        classes: 'wrapColumnText',
                        sortable:true,
                        editable: true,
                        edittype: 'textarea',
                        editoptions:{rows:"2"},
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'pob_benef',
                        index: 'pob_benef',
                        width: 80,
                        align:'right',
                        classes: 'wrapColumnText',
                        editable: true,
                        sortable:true,
                        search:false,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {name: 'id', index: 'id', width: 20, hidden: true, search: false},
                    {
                        name: 'situacion',
                        index: 'situacion',
                        width: 200,
                        align:'center',
                        classes: 'wrapColumnText',
                        sortable:true,
                        editable: true,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'f_inicio',
                        index: 'f_inicio',
                        align: 'center',
                        sortable: true,
                        formatter: 'date',
                        width: 120,
                        editable: true,
                        edittype: 'text',
                        search:false,
                        formatoptions: {
                            srcformat: 'ISO8601Long',
                            newformat: 'd-m-Y',
                            defaultValue:null
                        },
                        editoptions: {
                            size: 12,
                            maxlengh: 12,
                            dataInit: function (element) {
                                $(element).datepicker({
                                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
                                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                                    dateFormat: "dd-mm-yy",
                                    yearRange: '2000:2020',
                                    changeMonth: true,
                                    changeYear: true,
                                    maxDate: '+30Y',
                                    beforeShow: function () {
                                        /*setTimeout(function(){
                                         $('.ui-datepicker').css('z-index', 99999999999999);
                                         }, 0);*/
                                    }
                                })
                            }
                        }
                    },
                    {
                        name: 'f_fin',
                        index: 'f_fin',
                        align: 'center',
                        sortable: true,
                        formatter: 'date',
                        width: 120,
                        editable: true,
                        search:false,
                        edittype: 'text',
                        formatoptions: {
                            srcformat: 'ISO8601Long',
                            newformat: 'd-m-Y',
                            defaultValue:null
                        },
                        editoptions: {
                            size: 12,
                            maxlengh: 12,
                            dataInit: function (element) {
                                $(element).datepicker({
                                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
                                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                                    dateFormat: "dd-mm-yy",
                                    yearRange: '2000:2020',
                                    changeMonth: true,
                                    changeYear: true,
                                    maxDate: '+30Y',
                                    beforeShow: function () {
                                        /*setTimeout(function(){
                                         $('.ui-datepicker').css('z-index', 99999999999999);
                                         }, 0);*/
                                    }
                                })
                            }
                        }
                    },
                    {
                        name: 'u_medida',
                        index: 'u_medida',
                        width: 80,
                        editable: true,
                        sorttype: 'string',
                        search:false,
                        sortable:false,
                        align:'center',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'cantidad',
                        index: 'cantidad',
                        width: 80,
                        search:false,
                        editable: true,
                        align:'right',
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'ctotal',
                        index: 'ctotal',
                        align: 'right',
                        width: 100,
                        editable: true,
                        sorttype: 'string',
                        search:false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {name:'a_financ',index:'a_financ', width:80,editable:true, align:'right',search:false},
                    {name:'a_fisico',index:'a_fisico', width:80,editable:true, align:'right',search:false},
                    {
                        name: 'a_ejec_fis',
                        index: 'a_ejec_fis',
                        search:false,
                        width: 70,
                        align: "center",
                        editable: true,
                        sorttype: 'integer',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'a_ejec_financ',
                        index: 'a_ejec_financ',
                        width: 70,
                        search:false,
                        sortable: true,
                        editable: true,
                        align: "center",
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    }
                ],
                //loadonce:true,
                rowNum: 10,
                rowList: [10, 20, 30, 100, 200, 300],
                pager: '#pager2',
                sortname: 'nom_activ',
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
                            @permission('procompite-sayhuite-state')
                                var dt = data.rows;
                    var ids = table.jqGrid('getDataIDs');
                    for (var i = 0; i < ids.length; i++) {
                        var cl = ids[i];

                        //Sayhuite check
                        chk = '';
                        if (dt[i].estado == 'COMPLETO') {
                            chk = 'checked';
                        }
                        be = "<input onclick='sayhuite(this)' name='" + cl + "' type='checkbox' id ='S' value = " + cl + " " + chk + "/>";

                        table.jqGrid('setRowData', ids[i], {chkSayhuite: be});
                    }
                    @endpermission
                    },
                beforeSelectRow: function(rowid, e) {
                    console.log(e.target.id);
                    if(e.target.id === 'A' || e.target.id === 'S'){
                        return false;
                    }
                    return true;
                },
                onSelectRow: function (rowid, iRow, iCol, e) {
                    //table.jqGrid('restoreRow',lastsel);
                    //table.jqGrid('restoreRow',lastselHover);
                    lastselHover=rowid;
                    console.log('Select row -> hover = ' +  lastselHover);
                    console.log('Select row -> last = ' +  lastsel);
                    getLocationInfo();

                },
                ondblClickRow: function (rowid, iRow, iCol, e) {
                    table.jqGrid('restoreRow',lastsel);
                    lastselHover=rowid;
                    lastsel=rowid;
                    console.log('2 click row -> hover = ' +  lastselHover);
                    console.log('2 click row -> last = ' +  lastsel);
                    var p = table[0].p;
                    if ((p.multiselect && $.inArray(rowid, p.selarrrow) < 0) || rowid !== p.selrow) {
                        // if the row are still non-selected
                        table.jqGrid("setSelection", rowid, true);
                    }
                    table.jqGrid('editRow', rowid, true);
                    var $clickedCell = $(e.target).closest("td");
                    setTimeout(function () {
                                $clickedCell.find("input, select").focus()
                            }
                            , 1);
                    return;
                },
                //viewrecords: true,
                sortorder: "desc",
                caption: "Aulas Prefabricadas",
                rownumbers: true,
                editurl: '{{URL::to('mantaulaspre/update')}}'
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


            fEdit= function(){
                table.jqGrid('restoreRow', lastsel, true);
                lastsel=lastselHover;
                //table.jqGrid('restoreRow', lastselHover, true);
                table.jqGrid('editRow', lastsel, true);
            };

            fSave= function(){
                table.jqGrid('saveRow', lastsel, true);
            };

            fCancel= function(){
                table.jqGrid('restoreRow', lastsel, true);
            };

            function optModEjec() {
                return {
                    'ADMINISTRACION DIRECTA': 'ADMINISTRACION DIRECTA',
                    'CONTRATA': 'CONTRATA'
                };
            }

            /*function optEstadoProyecto() {
             return {
             'INAUGURADO': 'ADMINISTRACION DIRECTA',
             'CONTRATA': 'CONTRATA'
             };
             }*/


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
