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
.wrapColumnText
{
    white-space: normal !important;
    height:auto;
    vertical-align:text-top;
}
/* SCROLLBAR JQGRID*/
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
.ui-jqgrid .ui-widget-header {
    background-color: none;
    background-image: none;
    color: none;
}
.ui-jqgrid .ui-jqgrid-labels th.ui-th-column {
    background-color: #3c8dbc;
    background-image: none;
    color: white;
}
</style>

@endsection
@section('body')

    <div class="col-md-12 main">
        <div class="row">
            <h2 style="font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif"><center><b><u>Mantenimiento de vías</u></b></center></h2>
            <div class="container-fluid">
                <br>
                <div class="row">
                    <button class="btn btn-success">Nuevo</button>
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
        $(document).ready(function () {
            var scw = $(window).width();
            scw -= 300;
            var lastsel;
            var lastselHover;
            table = $("#list2");
            table.jqGrid({
                url: '{{ url("/filter-data-mantvias") }}',
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
                    'id',
                    'Tipo de actividad',
                    'Tipo mantenimiento',
                    'Provincia',
                    'Distrito',
                    'Cod. Ruta',
                    'Meta Fisica Programada',
                    'Ejecucion Fisica',
                    'Unidad de medida',
                    '% Avance Fisico',
                    'Meta Financiera programada',
                    'Devengado Financiero',
                    '% Avance Financiero',
                    'Fecha avance Financiero',
                    'Modalidad de ejecución',
                    'Estado',
                    'F. Actualización estado',
                    'Año',
                    'Estado',
                    'Sayhuite'],
                colModel: [
                    {
                        name: 'act',
                        title:false,
                        index: 'act',
                        width: 70,
                        sortable: false,
                        editable: false,
                        search: false,
                        fixed: true,
                        frozen:true,
                        formatter: createButtons
                    },
                    {
                        frozen: true,
                        title: false,
                        name: 'activ',
                        index: 'activ',
                        width: 350,
                        classes: 'wrapColumnText',
                        editable: true,
                        search:true,
                        /*TEXT AREA */
                        edittype: 'textarea',
                        align: 'left',
                        editoptions:{rows:"4"},
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'id',
                        index: 'id',
                        title: false,
                        width: 20,
                        hidden: true,
                        search: false
                    },
                    {
                        name: 'tip_activ',
                        title: false,
                        index: 'tip_activ',
                        width: 200,
                        sorttype: 'string',
                        sortable: true,
                        search:true,
                        classes: 'wrapColumnText',
                        editable: true,
                        edittype: 'textarea',
                        editoptions:{rows:"3"},
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'tip_mant',
                        title: false,
                        index: 'tip_mant',
                        width: 200,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'center',
                        editable: true,
                        cellEdit: true,
                        edittype: 'select',
                        formatter: 'select',
                        editoptions: {value: optTipoMant()}
                    },
                     {
                        name: 'prov',
                        title: false,
                        index: 'prov',
                        width: 100,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        classes: 'wrapColumnText',
                        align: 'center',
                        editable: true,
                        cellEdit: true
                    },
                     {
                        name: 'dist',
                        title: false,
                        index: 'dist',
                        width: 100,
                        classes: 'wrapColumnText',
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'center',
                        editable: true,
                        cellEdit: true
                    },
                    {
                        name: 'cod_ruta',
                        title: false,
                        index: 'cod_ruta',
                        width: 60,
                        editable: true,
                        sorttype: 'string',
                        align: 'center',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        fixed: true
                    },
                    {
                        name: 'mfis_pro',
                        title: false,
                        index: 'mfis_pro',
                        width: 90,
                        editable: true,
                        sortable:false,
                        align: 'right',
                        search:false,
                        editrules:{number:true}},
                    {
                        name: 'ejec_fisico',
                        title: false,
                        index: 'ejec_fisico',
                        width: 90,
                        editable: true,
                        sortable:false,
                        align: 'right',
                        search:false,
                        editrules:{number:true}},
                    {
                        name: 'u_medida',
                        title: false,
                        index: 'u_medida',
                        width: 80,
                        align:'center',
                        editable: true,
                        sortable:false,
                        search:false
                    },
                    {
                        name: 'av_fisico',
                        title: false,
                        align: 'right',
                        index: 'av_fisico',
                        width: 90,
                        editable: true,
                        sortable:false,
                        search:false,
                        editrules:{number:true}
                    },
                    {
                        name: 'mfin_pro',
                        title: false,
                        index: 'mfin_pro',
                        width: 80,
                        align: 'right',
                        editable: true,
                        formatter:'number',
                        sortable:false,
                        search:false,
                        editrules:{number:true}
                    },
                    {
                        name: 'deven_finan',
                        title: false,
                        index: 'deven_finan',
                        align: 'right',
                        width: 90,
                        editable: true,
                        sortable:false,
                        search:false,
                        editrules:{number:true}
                    },
                    {
                        name: 'av_finan',
                        title: false,
                        index: 'av_finan',
                        width: 90,
                        editable: true,
                        align: 'right',
                        sortable:false,
                        search:false,
                        editrules:{number:true}
                    },
                    {
                        name: 'f_afinanc',
                        title: false,
                        index: 'f_afinanc',
                        align: 'center',
                        search:false,
                        sortable: true,
                        formatter: 'date',
                        formatoptions: {
                            srcformat: 'ISO8601Long',
                            newformat: 'd/m/Y',
                            defaultValue:null
                        },
                        width: 100,
                        editable: true,
                        edittype: 'text',
                        editoptions: {
                            size: 12,
                            maxlengh: 12,
                            search: false,
                            dataInit: function (element) {
                                $(element).datepicker({
                                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
                                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                                    dateFormat: "dd/mm/yy",
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
                            //editrules: {date: true}
                    },
                    {
                        name: 'mod_ejec',
                        index: 'mod_ejec',
                        width: 200,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'center',
                        editable: true,
                        cellEdit: true,
                        edittype: 'select',
                        formatter: 'select',
                        editoptions: {value: optModEjec()}
                    },
                    {
                        name: 'est',
                        index: 'est',
                        width: 100,
                        align: 'center',
                        editable: true,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'f_estado',
                        index: 'f_estado',
                        align: 'center',
                        sortable: true,
                        formatter: 'date',
                        formatoptions: {
                            srcformat: 'ISO8601Long',
                            newformat: 'd-m-Y',
                            defaultValue:null
                        },
                        width: 120,
                        editable: true,
                        edittype: 'text',
                        editoptions: {
                            size: 12,
                            maxlengh: 12,
                            search: false,
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
                        //editrules: {date: true}
                    },
                    {
                        name: 'anio',
                        index: 'anio',
                        width: 60,
                        align: "center",
                        editable: true,
                        sorttype: 'integer',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'est_info',
                        index: 'est_info',
                        width: 100,
                        sortable: true,
                        editable: false,
                        sorttype: 'string',
                        align: 'center',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'chkSayhuite',
                        index: 'chkSayhuite',
                        width: 60,
                        align: 'center',
                        sortable: false,
                        editable: false,
                        search: false
                    }
                ],
                rowNum: 10,
                rowList: [10, 20, 30, 100, 200, 300],
                pager: '#pager2',
                sortname: 'activ',
                loadComplete: function (data) {
                    var dt = data.rows;
                    var ids = table.jqGrid('getDataIDs');
                    for (var i = 0; i < ids.length; i++) {
                        var cl = ids[i];

                        //Sayhuite check
                        chk = '';
                        if (dt[i].est_info == 'PRIORIZADO') {
                            chk = 'checked';
                        }
                        be = "<input onclick='sayhuite(this)' name='" + cl + "' type='checkbox' id ='S' value = " + cl + " " + chk + "/>";

                        table.jqGrid('setRowData', ids[i], {chkSayhuite: be});
                    }
                },
                serializeGridData: function (postData) {
                    return postData;
                },
                //viewrecords: true,
                sortorder: "desc",
                caption: "Mantenimiento de Vías",
                rownumbers: true,
                editurl: '{{URL::to('mantvias/update')}}'
            });

            table.jqGrid('setFrozenColumns');//FIXED COLUMNS ACTIVATE

            table.jqGrid('filterToolbar', {searchOperators: true
            });

            edit = function(id){
                    table.jqGrid('editGridRow',id,{height:800,width:600,reloadAfterSubmit:false});
                }

             //MANAGEMENT BUTTONS
            function createButtons (cellvalue, options, rowObject){

                var cl = rowObject['id'];
                var bAddImg = "",bShow = "",bEdit;

                var bUpdateState;

                var ids = table.jqGrid('getDataIDs');

                var event = 'loadModal("/mantvias/images","full-width","1","' + cl + '")';

                bAddImg = "<button class = 'btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Anexar Imagen' type='button' class='e' onclick='" + event + "'\"><i id='A' class='fa fa-picture-o fa-lg e' aria-hidden='true'></i></button>";

                bEdit   = "<button onclick='edit("+cl+")' class = 'bedata btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Editar' type='button' class='e'><i id='A' class='fa fa-edit fa-lg e' aria-hidden='true'></i></button>";
                

                bSup  = "<br><button class = 'bedata btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Editar' type='button' class='e'><i id='A' class='fa fa-address-book fa-lg e' aria-hidden='true'></i></button>";                

                bgeo  = "<button class = 'bedata btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Editar' type='button' class='e'><i id='A' class='fa fa-globe fa-lg e' aria-hidden='true'></i></button>";                

               return bEdit + bShow + bAddImg + bSup + bgeo;

            }

            function optTipoMant() {
                return {
                    'MANTENIMIENTO RUTINARIO': 'MANTENIMIENTO RUTINARIO',
                    'MANTENIMIENTO PERIODICO': 'MANTENIMIENTO PERIODICO',
                    'MANTENIMIENTO EMERGENCIA': 'MANTENIMIENTO EMERGENCIA'
                };
            }
            function optModEjec() {
                return {
                    'CONTRATA': 'CONTRATA',
                    'ADM. DIRECTA': 'ADM. DIRECTA'
                };
            }

            function loadModal(url, modaltype, CRUD, opc) {
                $modal = $('#' + modaltype);
                console.log('hello');
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
        });
    </script>


<script>
    $(function(){


        $.fn.modalmanager.defaults.resize = true;
        //$.fn.dataTable.ext.errMode = 'none';


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
                    url: "/stateSayhuiteMantVias",
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
