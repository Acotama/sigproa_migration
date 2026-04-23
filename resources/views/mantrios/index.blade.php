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
/*.dt-button{
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
}*/
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
            <h2 style="font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif"><center><b><u>Mantenimiento de rios</u></b></center></h2>
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
        $(document).ready(function () {
            var scw = $(window).width();
            scw -= 300;
            var lastsel;
            var lastselHover;
            table = $("#list2");
            table.jqGrid({
                url: '{{ url("/filter-data-mantrios") }}',
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
                    'Nombre',
                    'id',
                    'Departamento',
                    'Provincia',
                    'Distrito',
                    'Meta Fisica Ficha',
                    'Monto Ficha',
                    'Actividad',
                    'Meta Fisica Expediente',
                    'Monto Expediente',
                    'Meta Expediente',
                    'Monto Programado',
                    'Monto Ejecutado',
                    'Adicional',
                    'Ejecutado Adicional',
                    'Estado',
                    'Año'
                    ],
                colModel: [
                    {
                        name: 'act',
                        title:false,
                        index: 'act',
                        width: 36,
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
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {name: 'id',title: false, index: 'id', width: 100, hidden: true, search: false},
                    {name: 'dep',title: false, index: 'dep', width: 100, hidden: false, search: false, align: 'center'},
                    {name: 'prov',title: false, index: 'prov', width: 100, hidden: false, search: false, align: 'center'},
                    {name: 'dist',title: false,classes: 'wrapColumnText', index: 'dist', width: 100, hidden: false, search: false, align: 'center'},
                    {
                        name: 'mf_ficha',
                        title: false,
                        index: 'mf_ficha',
                        width: 80,
                        sorttype: 'string',
                        sortable: true,
                        search:true,
                        classes: 'wrapColumnText',
                        editable: true,
                        align: 'right',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'mt_ficha',
                        title: false,
                        index: 'mt_ficha',
                        width: 80,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'right',
                        editable: true
                    },
                    {
                        name: 'meta_ficha',
                        title: false,
                        index: 'meta_ficha',
                        width: 200,
                        classes: 'wrapColumnText',
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'center',
                        editable: true
                    },
                    {
                        name: 'mf_exp',
                        title: false,
                        index: 'mf_exp',
                        width: 80,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'right',
                        editable: true
                    },
                    {
                        name: 'mt_exp',
                        title: false,
                        index: 'mt_exp',
                        width: 80,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'right',
                        editable: true
                    },
                    {
                        name: 'meta_exp',
                        title: false,
                        index: 'meta_exp',
                        width: 200,
                        sorttype: 'string',
                        classes: 'wrapColumnText',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'center',
                        editable: true,
                        hidden:true
                    },
                    {
                        name: 'mpro',
                        title: false,
                        index: 'mpro',
                        width: 80,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'right',
                        editable: true
                    },
                    {
                        name: 'meje',
                        title: false,
                        index: 'meje',
                        width: 80,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'right',
                        editable: true
                    },
                    {
                        name: 'adic',
                        title: false,
                        index: 'adic',
                        width: 80,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'right',
                        editable: true,
                        classes: 'wrapColumnText'
                    },
                    {
                        name: 'ejecadi',
                        title: false,
                        index: 'ejecadi',
                        width: 100,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'right',
                        editable: true,
                        classes: 'wrapColumnText'
                    },
                    {
                        name: 'est',
                        title: false,
                        index: 'est',
                        width: 200,
                        classes: 'wrapColumnText',
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'center',
                        editable: true
                    },
                    {
                        name: 'anio',
                        title: false,
                        index: 'anio',
                        width: 200,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        sortable: true,
                        align: 'center',
                        editable: true
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

                    arrUrl = window.location.href.split('/');
                    var vYear = arrUrl[arrUrl.length - 1];
                    var vTipo = arrUrl[arrUrl.length - 2];

                    if(vYear != 'mantrios'){

                        try{
                            filters = $.parseJSON(postData.filters);


                            var tipo = new Object();
                            tipo.data = vTipo;
                            tipo.field = "tip_mant";
                            tipo.op = "cn";

                            var anio = new Object();
                            anio.data = vYear;
                            anio.field = "anio";
                            anio.op = "cn";

                            filters.rules.push(anio);
                            filters.rules.push(tipo);

                            postData.filters = JSON.stringify(filters);

                        }
                        catch(Exception){
                            postData["_search"] = true;
                            postData.filters = '{"groupOp":"AND","rules":[{"data":"'+vTipo+'","field":"tip_mant","op":"cn"},{"data":"'+vYear+'","field":"anio","op":"cn"}]}';
                        }
                    }
                    console.log(postData);
                    return postData;
                    //var myPostData = $.extend({}, postData); // make a copy of the input parameter
                    //myPostData.sidx = "'" + myPostData.sidx + "'";dd
                    //myPostData.sord = "'" + myPostData.sord + "'";
                },
                //viewrecords: true,
                sortorder: "desc",
                caption: "Mantenimiento de Ríos",
                rownumbers: true//,
                //editurl: '{{URL::to('mantvias/update')}}'
            });

            table.jqGrid('setFrozenColumns');//FIXED COLUMNS ACTIVATE

            table.jqGrid('filterToolbar', {searchOperators: true
            });

            edit = function(id){
                    table.jqGrid('editGridRow',id,{height:500,width:600,reloadAfterSubmit:false});
                }

             //MANAGEMENT BUTTONS
            function createButtons (cellvalue, options, rowObject){

                var cl = rowObject['id'];
                var bAddImg = "",bShow = "",bEdit;

                var bUpdateState;

                var ids = table.jqGrid('getDataIDs');

                var event = 'loadModal("/mantvias/images","full-width","1","' + cl + '")';



                bEdit   = "<button onclick='edit("+cl+")' class = 'bedata btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Editar' type='button' class='e'><i id='A' class='fa fa-edit fa-lg e' aria-hidden='true'></i></button>";

               return bEdit + bShow + bAddImg;

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
