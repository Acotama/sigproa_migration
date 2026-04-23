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

.meta{
    color: white !important;
    background-color: rgb(236,128,20) !important;
}
.fisica{
    color: white !important;
    background-color: rgb(22,54,92) !important;
}
.cemento{
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


@endsection
@section('body')

    <div class="col-md-12 main">
        <div class="row">
            <h2 style="font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif"><center><b><u>Mantenimiento de Canales</u></b></center></h2>
            <div class="container-fluid">
                <br>
                <div class="row">
                    <div id='gridwrapper' class='gridWrapper'>
                        <table id='tblCanales'><tr><td></td></tr></table>
                        <div id='pager_tblCanales'></div>
                    </div>
                </div>
                <br>
                <!--div class="row table-responsive">
                    <table id="list2"></table>
                    <div id="pager2"></div>
                </div-->

            </div>
        </div>

        <div id="location-modal" class="modal container fade" tabindex="-1" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ubicacion</h4>
            </div>
            <div class="modal-body">
                <form id="frm_location" class="ubicacion" method="POST">
                    <br>

                    <br>

                    <div class="row">
                        <br>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input type="text" class="form-control col-md-12" id="pac-input" placeholder="Busqueda en mapa"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><label for="latitud">Latitud</label></span>
                                    <div><input type="text" name="latitud" class="form-control" id="lat"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><label for="longitud">Longitud</label></span>
                                    <div><input type="text" name="longitud" class="form-control" id="lon"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="map" style="height: 500px;width: 100%"></div>




                    </div>
                    <br>

                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                        <button type="button" id="btnSaveLocation" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR
                        </button>
                    </div>
                </form>
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



        var lat = -11.127036;
        var lon = -77.596699;

        var scw = $(window).width();
        scw -= 300;

        var lastsel;
        var lastselHover;
        $(document).ready(function () {
            //VAR & FUNCTIONS
                var click_frozen = 1,
                    table = $("#tblCanales"),
                    numberSearchOptions = ["eq", "ne", "lt", "le", "gt", "ge", "nu", "nn", "in", "ni"],
                    numberTemplate = {formatter: "number", align: "right", sorttype: "number",
                        searchoptions: { sopt: numberSearchOptions }},
                    myDefaultSearch = "cn",
                    refreshSerchingToolbar = function (table, myDefaultSearch) {
                        var p = table.jqGrid("getGridParam"), postData = p.postData, filters, i, l,
                                rules, rule, iCol, cm = p.colModel,
                                cmi, control, tagName;

                        for (i = 0, l = cm.length; i < l; i++) {
                            control = $("#gs_" + $.jgrid.jqID(cm[i].name));
                            if (control.length > 0) {
                                tagName = control[0].tagName.toUpperCase();
                                if (tagName === "SELECT") { // && cmi.stype === "select"
                                    control.find("option[value='']")
                                            .attr("selected", "selected");
                                } else if (tagName === "INPUT") {
                                    control.val("");
                                }
                            }
                        }

                        if (typeof (postData.filters) === "string" &&
                                typeof (table[0].ftoolbar) === "boolean" && table[0].ftoolbar) {

                            filters = $.parseJSON(postData.filters);
                            if (filters && filters.groupOp === "AND" && filters.groups === undefined) {
                                // only in case of advance searching without grouping we import filters in the
                                // searching toolbar
                                rules = filters.rules;
                                for (i = 0, l = rules.length; i < l; i++) {
                                    rule = rules[i];
                                    iCol = p.iColByName[rule.field];
                                    if (iCol >= 0) {
                                        cmi = cm[iCol];
                                        control = $("#gs_" + $.jgrid.jqID(cmi.name));
                                        if (control.length > 0 &&
                                                (((cmi.searchoptions === undefined ||
                                                cmi.searchoptions.sopt === undefined)
                                                && rule.op === myDefaultSearch) ||
                                                (typeof (cmi.searchoptions) === "object" &&
                                                $.isArray(cmi.searchoptions.sopt) &&
                                                cmi.searchoptions.sopt.length > 0 &&
                                                cmi.searchoptions.sopt[0] === rule.op))) {
                                            tagName = control[0].tagName.toUpperCase();
                                            if (tagName === "SELECT") { // && cmi.stype === "select"
                                                control.find("option[value='" + $.jgrid.jqID(rule.data) + "']")
                                                        .attr("selected", "selected");
                                            } else if (tagName === "INPUT") {
                                                control.val(rule.data);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
            cm = [
                    {
                        name: 'act',
                        index: 'act',
                        width: 70,
                        sortable: false,
                        editable: false,
                        search: false,
                        formatter: createButtons
                    },
                    {
                        name: 'nombre',
                        index: 'nombre',
                        width: 350,
                        sortable: false,
                        editable: true,
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        edittype: 'textarea',
                        editoptions:{rows:"4"},
                        classes: 'wrapColumnText'
                    },
                    {
                        name: 'nom_dpto',
                        index: 'nom_dpto',
                        width: 70,
                        sortable: false,
                        editable: true,
                        search: false,
                        hidden:true
                    },
                    {
                        name: 'cod_dpto',
                        index: 'cod_dpto',
                        width: 70,
                        sortable: false,
                        editable: false,
                        search: false,
                        hidden:true
                    },
                    {
                        name: 'nom_prov',
                        index: 'nom_prov',
                        width: 100,
                        align:'center',
                        sortable: false,
                        editable: true,
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        hidden:false,
                        classes: 'wrapColumnText'
                    },
                    {
                        name: 'cod_prov',
                        index: 'cod_prov',
                        width: 70,
                        sortable: false,
                        editable: false,
                        search: false,
                        hidden:true
                    },
                    {
                        name: 'nom_dist',
                        index: 'nom_dist',
                        width: 100,
                        align:'center',
                        sortable: false,
                        editable: true,
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']},
                        hidden:false,
                        classes: 'wrapColumnText'
                    },
                    {
                        name: 'cod_dist',
                        index: 'cod_dist',
                        width: 70,
                        sortable: false,
                        editable: false,
                        search: false,
                        hidden:true
                    },
                    {
                        name: 'id',
                        index: 'id',
                        width: 70,
                        sortable: false,
                        editable: false,
                        search: false,
                        hidden:true
                    },
                    {
                        name: 'monto_ejec',
                        index: 'monto_ejec',
                        width: 80,
                        align: 'right',
                        sortable: false,
                        editable: true,
                        formatter:'number',
                        search: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'meta_programada',
                        index: 'meta_programada',
                        width: 80,
                        align: 'right',
                        sortable: false,
                        editable: true,
                        formatter:'number',
                        search: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'meta_ejec',
                        index: 'meta_ejec',
                        width: 80,
                        align: 'right',
                        sortable: false,
                        formatter:'number',
                        editable: true,
                        search: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'beneficiarios',
                        index: 'beneficiarios',
                        width: 100,
                        align: 'right',
                        formatter:'number',
                        sortable: false,
                        editable: true,
                        search: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'hect_riego',
                        index: 'hect_riego',
                        width: 80,
                        align: 'right',
                        sortable: false,
                        formatter:'number',
                        editable: true,
                        search: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'cemento_entreg',
                        index: 'cemento_entreg',
                        width: 80,
                        align: 'right',
                        formatter:'number',
                        sortable: false,
                        editable: true,
                        search: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'anio',
                        index: 'anio',
                        width: 80,
                        align: 'center',
                        sortable: false,
                        editable: true,
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'estado',
                        index: 'estado',
                        width: 100,
                        align: 'center',
                        sortable: false,
                        editable: true,
                        search: true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'nro_conv',
                        index: 'nro_conv',
                        width: 160,
                        align: 'center',
                        sortable: false,
                        editable: false,
                        search: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    }
            ],
            saveObjectInLocalStorage = function (storageItemName, object) {
                if (window.localStorage !== undefined) {
                    window.localStorage.setItem(storageItemName, JSON.stringify(object));
                }
            },
            removeObjectFromLocalStorage = function (storageItemName) {
                if (window.localStorage !== undefined) {
                    window.localStorage.removeItem(storageItemName);
                }
            },
            getObjectFromLocalStorage = function (storageItemName) {
                if (window.localStorage !== undefined) {
                    return $.parseJSON(window.localStorage.getItem(storageItemName));
                }
            },
            myColumnStateName = function (grid) {
                return window.location.pathname + "#" + grid[0].id;
            },
            idsOfSelectedRows = [],
            getColumnNamesFromColModel = function () {
                var colModel = this.jqGrid("getGridParam", "colModel");
                return $.map(colModel, function (cm, iCol) {
                    // we remove "rn", "cb", "subgrid" columns to hold the column information
                    // independent from other jqGrid parameters
                    return $.inArray(cm.name, ["rn", "cb", "subgrid"]) >= 0 ? null : cm.name;
                });
            },
            saveColumnState = function () {
                var p = this.jqGrid("getGridParam"), colModel = p.colModel, i, l = colModel.length, colItem, cmName,
                        postData = p.postData,
                        columnsState = {
                            search: p.search,
                            page: p.page,
                            rowNum: p.rowNum,
                            sortname: p.sortname,
                            sortorder: p.sortorder,
                            cmOrder: getColumnNamesFromColModel.call(this),
                            selectedRows: idsOfSelectedRows,
                            colStates: {}
                        },
                        colStates = columnsState.colStates;

                if (postData.filters !== undefined) {
                    columnsState.filters = postData.filters;
                }

                for (i = 0; i < l; i++) {
                    colItem = colModel[i];
                    cmName = colItem.name;
                    if (cmName !== "rn" && cmName !== "cb" && cmName !== "subgrid") {
                        colStates[cmName] = {
                            width: colItem.width,
                            hidden: colItem.hidden
                        };
                    }
                }
                saveObjectInLocalStorage(myColumnStateName(this), columnsState);
            },
            myColumnsState,
            isColState,
            restoreColumnState = function (colModel) {
                var colItem, i, l = colModel.length, colStates, cmName,
                        columnsState = getObjectFromLocalStorage(myColumnStateName(this));

                if (columnsState) {
                    colStates = columnsState.colStates;
                    for (i = 0; i < l; i++) {
                        colItem = colModel[i];
                        cmName = colItem.name;
                        if (cmName !== "rn" && cmName !== "cb" && cmName !== "subgrid") {
                            colModel[i] = $.extend(true, {}, colModel[i], colStates[cmName]);
                        }
                    }
                }
                return columnsState;
            },
            updateIdsOfSelectedRows = function (id, isSelected) {
                var index = $.inArray(id, idsOfSelectedRows);
                if (!isSelected && index >= 0) {
                    idsOfSelectedRows.splice(index, 1); // remove id from the list
                } else if (index < 0) {
                    idsOfSelectedRows.push(id);
                }
            },
            firstLoad = true;

            myColumnsState = restoreColumnState.call(table, cm);
            isColState = myColumnsState !== undefined && myColumnsState !== null;
            idsOfSelectedRows = isColState && myColumnsState.selectedRows !== undefined ? myColumnsState.selectedRows : [];



            table.jqGrid({
                url: '{{ url("/filter-data-mantcanales") }}',
                datatype: "json",
                mtype: 'POST',
                width:scw,
                colNames: [
                    'Acción',
                    'Nombre',
                    'Departamentp',
                    'C. Departamento',
                    'Provincia',
                    'C. Provincia',
                    'Distrito',
                    'C. Distrito',
                    'id',
                    'Monto Ejecutado S/.',
                    'Meta Programada (m)',
                    'Meta Ejecutada (m)',
                    'Beneficiarios',
                    'Hectareas Bajo Riego',
                    'Cemento Entregado (Bolsas)',
                    'Año',
                    'Estado',
                    'N° Convenio / Expediente'
                   ],
                colModel: cm,
                autoResizing: { compact: true },
                iconSet: "fontAwesome",
                shrinkToFit: false,
                viewrecords: true,
                toppager: true,
                rowNum: 10,
                rowList: [10, 20, 30, 100, 200, 300],
                pager: '#pager_tblCanales',
                sortname: 'id',
                gridComplete: function () {
                },
                sortable: {
                    update: function () {
                        saveColumnState.call(table);
                    },
                    options: {
                        opacity: 0.8
                    }
                },
                serializeGridData: function (postData) {
                    return postData;
                    //var myPostData = $.extend({}, postData); // make a copy of the input parameter
                    //myPostData.sidx = "'" + myPostData.sidx + "'";dd
                    //myPostData.sord = "'" + myPostData.sord + "'";
                },
                loadComplete: function (data) {
                    $(window).bind('resize', function() {

                        // Get width of parent container
                        var gridId = "tblCanales";
                        var width = $('#gbox_' + gridId).parent().width();
                        if (width == null || width < 1){
                            // For IE, revert to offsetWidth if necessary
                            width = $('#gbox_' + gridId).parent().attr('offsetWidth');
                        }
                        width = width - 6; // Fudge factor to prevent horizontal scrollbars
                        if (width > 0 &&
                                    // Only resize if new width exceeds a minimal threshold
                                    // Fixes IE issue with in-place resizing when mousing-over frame bars
                                Math.abs(width - table.width()) > 5)
                        {
                            table.setGridWidth(width);
                        }

                    }).trigger('resize');

                    var $this = $(this), p = $this.jqGrid("getGridParam"), i, count;

                    if (firstLoad) {
                        firstLoad = false;
                        if (isColState && myColumnsState.cmOrder != null && myColumnsState.cmOrder.length > 0) {
                            // We compares the values from myColumnsState.cmOrder array
                            // with the current names of colModel and remove wrong names. It could be
                            // required if the column model are changed and the values from the saved stated
                            // not corresponds to the
                            var fixedOrder = $.map(myColumnsState.cmOrder, function (name) {
                                return p.iColByName[name] === undefined ? null : name;
                            });
                            $this.jqGrid("remapColumnsByName", fixedOrder, true);
                        }
                        if (typeof (this.ftoolbar) !== "boolean" || !this.ftoolbar) {
                            // create toolbar if needed
                            $this.jqGrid("filterToolbar",
                                    {stringResult: true, searchOnEnter: true, defaultSearch: myDefaultSearch});
                        }
                    }
                    refreshSerchingToolbar($this, myDefaultSearch);
                    for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
                        $this.jqGrid("setSelection", idsOfSelectedRows[i], false);
                    }
                    saveColumnState.call($this, this.p.remapColumns);

                     var dt = data.rows;

                        var ids = table.jqGrid('getDataIDs');

                    $.each(data.legend,function($key,$val){
                           $('#'+$key).html('<span style="color: green;"><b>'+$val+'</b><span>');
                           if($key == 'singerencia'){
                               $('#sin_ger_count').html($val);
                               if($val == '0'){
                                   $('#sin_ger_count').parent().fadeOut("slow");
                               }
                           }
                    });
                },
                resizeStop: function () {
                    saveColumnState.call(table, table[0].p.remapColumns);
                },
                afterSubmit: function (response) {
                  console.log(response);
                  console.log('asdasd');
                },
                recreateFilter:true,
                //viewrecords: true,
                sortorder: "desc",
                caption: "Mantenimiento de Canales",
                rownumbers: true,
                editurl: "{{URL::to('mantcanales/update')}}"
            })
            .jqGrid("navGrid", {add: false, edit: true, del: false })
            .jqGrid('filterToolbar', {searchOperators: true})
            .jqGrid("gridResize")
            .jqGrid("navButtonAdd", {
                caption: "",
                buttonicon: "fa-table",
                title: "Escoger Columnas",
                onClickButton: function () {
                    $(this).jqGrid("columnChooser", {notSkipFrozen: true, width:500});
                    $(this).jqGrid("columnChooser", {
                        done: function (perm) {
                            if (perm) {
                                this.jqGrid("remapColumns", perm, true);
                                saveColumnState.call(this);
                            }
                        }
                    });
                }
            })
            .jqGrid("navButtonAdd", {
                caption: "",
                buttonicon: "fa-times",
                title: "Restablecer tabla",
                onClickButton: function () {
                    removeObjectFromLocalStorage(myColumnStateName($(this)));
                    window.location.reload();
                }
            })
            .jqGrid("navButtonAdd", {
                caption: "",
                buttonicon: "fa-file-excel-o",
                title: "Exportar",
                onClickButton: function () {
                    window.location.href = "/exportar"
                }
            })
            .jqGrid('setFrozenColumns')//FIXED COLUMNS ACTIVATE;

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


            edit = function(id){
                table.jqGrid('editGridRow',id,{
                    height:650,
                    width:600,
                    reloadAfterSubmit:false,
                    afterSubmit : function( data) {
                      console.log(table);
                      if ( !data.responseJSON.error ){
                        swal(
                          'Correcto',
                          'Se guardaron los cambios correctamente',
                          'success'
                        )
                      } else {
                        console.log(data)
                      }
                    }
                  }
                );
            }

             //MANAGEMENT BUTTONS
            function createButtons (cellvalue, options, rowObject){

                var cl = rowObject['id'];
                var bAddImg = "",bShow = "",bEdit;

                var bUpdateState;

                var ids = table.jqGrid('getDataIDs');

                var event = 'loadModal("/mantcanales/images","full-width","1","' + cl + '")';
                var eventpdf = 'loadModal("/mantcanales/pdf","full-width","1","' + cl + '")';
                var eventloc = 'getLocationInfo();';

                bai = "<button class = 'btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Anexar Imagen' type='button' class='e' onclick='" + event + "'\"><i id='A' class='fa fa-picture-o fa-lg e' aria-hidden='true'></i></button>";
                bpdf = "<button class = 'btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='P' title = 'Anexar PDF' type='button' class='e' onclick='" + eventpdf + "'\"><i id='P' class='fa fa-file-pdf-o fa-lg e' aria-hidden='true'></i></button>\n";
                bloc = "<button class = 'btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='E' data-target='#location-modal' data-toggle='modal' title = 'Agregar Ubicación' type='button' class='e' onclick='" + eventloc + "'\"><i onclick='" + eventloc + "' id='E' class='fa fa-globe fa-lg e' aria-hidden='true'></i></button>";

                bEdit   = "<button onclick='edit("+cl+")' class = 'bedata btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Editar' type='button' class='e'><i id='A' class='fa fa-edit fa-lg e' aria-hidden='true'></i></button>";

               return bai + bpdf + bloc + bEdit;

            }
            var createExcelFromGrid = function(gridID,filename) {
        var excluidos = ['act','est','estado_pic','chkSayhuite'];
        var grid = $('#' + gridID);
        var rowIDList = grid.getDataIDs();
        var row = grid.getRowData(rowIDList[0]);
        var colNames = [];
        var i = 0;
        for(var cName in row) {
            colNames[i++] = cName; // Capture Column Names
        }
        //console.log(colNames);
        var html = "data:application/vnd.ms-excel,<table>";

            html += "<thead><tr>";
                for(var i = 0 ; i<colNames.length ; i++ ) {
                    if( excluidos.indexOf(colNames[i]) == -1 ){
                        html += "<td>";
                        html += colNames[i]; // Create a CSV delimited with ;
                        html += "</td>";
                    }
                }
            html += "</tr></thead>";
        for(var j=0;j<rowIDList.length;j++) {
            html += "<tr>";
            row = grid.getRowData(rowIDList[j]); // Get Each Row
            for(var i = 0 ; i<colNames.length ; i++ ) {
                //console.log(colNames[i], excluidos.indexOf(colNames[i]) != -1);
                if( excluidos.indexOf(colNames[i]) == -1 ){
                    html += "<td>";
                    html += row[colNames[i]]; // Create a CSV delimited with ;
                    html += "</td>";
                }
            }
            html += "</tr>";
        }
        //alert(html);
        html += '</table>';
        //console.log(html);
        var a         = document.createElement('a');
        a.id = 'ExcelDL';
        a.href        = html;
        a.download    = filename ? filename + ".xls" : 'DataList.xls';
        document.body.appendChild(a);
        a.click(); // Downloads the excel document
        document.getElementById('ExcelDL').remove();
    }

        });
    </script>


    <script>

        //LOAD GOOGLE MAPS API
        var map;
        function initMap() {
            document.getElementById('map').style.display="block";

            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: lat, lng: lon},
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.HYBRID
            });
            var marker = new google.maps.Marker({
                position: {lat: lat, lng: lon},
                map: map
            });
            console.log(lat, lon);
            google.maps.event.addListener(map, 'click', function (event) {
                $('#lat').val(event.latLng.lat());
                $('#lon').val(event.latLng.lng());
            });
            google.maps.event.trigger(map, 'resize');
            google.maps.event.addListenerOnce(map, 'idle', function () {
                google.maps.event.trigger(map, 'resize');
            });
            // Create the search box and link it to the UI element.
            var input = /** @type {HTMLInputElement} */ (
                    document.getElementById('pac-input'));
            var searchBox = new google.maps.places.SearchBox(
                    /** @type {HTMLInputElement} */
                    (input));
            // Listen for the event fired when the user selects an item from the
            // pick list. Retrieve the matching places for that item.
            var markers = [];
            google.maps.event.addListener(searchBox, 'places_changed', function () {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };
                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
                google.maps.event.trigger(map, 'resize');
            });
        }

        //============================== UBICACIÓN ================================
        // GET LOCATION SAVED OR SET DEFAULT

        function getLocationInfo() {
            $('#lat').val('');
            $('#lon').val('');
            //uid = document.getElementById('uid').value;
            var uid = lastselHover;
            $.ajax({
                url: "/mantcanales-getLocationInfo",
                type: 'POST',
                data: {uid: uid},
                async:true,
                success: function (data) {
                    console.log(data);
                    $('#lat').val(data.data['latitud']);
                    $('#lon').val(data.data['longitud']);
                    if ((data.data['latitud'] === null || !data.data['latitud']) && (data.data['longitud'] === null || !data.data['longitud'])) {
                        lat = -11.127036;
                        lon = -77.596699;
                    } else {
                        lat = parseFloat(data.data['latitud']);
                        lon = parseFloat(data.data['longitud']);
                    }
                    initMap();
                    google.maps.event.trigger(map, 'resize');
                }
            });
            return false;

        }


        //SAVE LOCATION PARAMS
        $("#btnSaveLocation").click(function (e) {
            e.preventDefault();
            //var formData = new FormData($(this)[0]);
            var uid = lastselHover;
            var latitud  = $('#lat').val();
            var longitud = $('#lon').val();
            console.log(uid);
            if(latitud === '' || longitud === ''){
                return false;
            }

            $.ajax({
                url: '/mantcanales-updateLocationInfo',
                type: 'POST',
                data: {uid:uid,latitud:latitud,longitud:longitud},
                async: false,
                cache: false,
                //contentType: false,
                //processData: false,
                beforeSend: function () {
                    $('button').attr('disabled', 'disabled');
                },
                success: function (response) {
                    $('button').removeAttr('disabled');
                    swal(
                            'Correcto',
                            'Datos actualizados correctamente!',
                            'success'
                    );
                    getLocationInfo();
                },
                error: function (response) {
                    $('button').removeAttr('disabled');
                    response = $.parseJSON(response.responseText);
                    swal(
                            'Error',
                            'Error al guardar los cambios',
                            'error'
                    );
                }
            });
            return false;
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
                    url: "/stateSayhuiteMantCanales",
                    type: 'POST',
                    data: {st: st, uid: that.name},
                    success: function (data) {
                        $("#tblCanales").trigger("reloadGrid", { fromServer: true});
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

    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBea_vgTFolz7EGBG32BaUeR0FvFJbpdrQ&libraries=places&callback=initMap"></script>
@stop
