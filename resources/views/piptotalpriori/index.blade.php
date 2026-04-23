@extends('starter')
@section('htmlhead')


<!-- JqueryUI -->
<link rel="stylesheet" href="{{ asset('librerias/jquery-ui/themes/redmond/jquery-ui.min.css') }}">
<!-- jqGRID -->
<link rel="stylesheet" href="{{asset('plugins/jqgrid/css/ui.jqgrid.css')}}"/>
<link rel="stylesheet" href="{{asset('plugins/jqgrid/plugins/css/ui.multiselect.min.css')}}">

<!--link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-tree/css/jquery.tree.css') }}" /-->
<!-- CHOSEN-->
<link rel="stylesheet" href="{{ asset('plugins/chosen/chosen.css') }}">

<link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"  rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">

<style>

    .prior {
        background-color: red !important;
    }

    .wrapColumnTextEtapa {
        white-space: normal !important;
        height: auto;
    }
    .wrapColumnText
    {
        white-space: normal !important;
        height:auto;
        padding: 4px !important;
    }

    #gview_list2 .ui-jqgrid-title {
     color:black;
    }

    #gview_list2 .ui-widget-header {
        background: white !important;
    }

    .navtable .ui-pg-button {
        font-size: 100%;
    }

    .ui-pg-table .ui-pg-button {
        font-size: 150%;
    }

    .ui-search-clear{
        font-size: 150%;
    }

    /* SCROLLBAR JQGRID */
    /*.gridWrapper{
        width: 100%;
        overflow:auto; /* <---set the overflow to auto
    }*/

    .ui-jqgrid-bdiv{
        max-height: 600px;
    }

    /* MULTILINE HEADER */
    th.ui-th-column div{
        white-space:normal !important;
        height:auto !important;
        padding:2px !important;
    }

    .ui-jqgrid .ui-jqgrid-labels th.ui-th-column {
        background-color: #3c8dbc;
        background-image: none;
        color: white;
    }


    .loader {
          border: 16px solid #f3f3f3;
          border-radius: 50%;
          border-top: 16px solid blue;
          border-bottom: 16px solid blue;
          width: 120px;
          height: 120px;
          -webkit-animation: spin 2s linear infinite;
          animation: spin 2s linear infinite;
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

        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }


</style>

@endsection
@section('body')

<script>

    //CLEAN LOCAL STORAGE
    //window.localStorage.clear();


    function startTour() {
        var tour = introJs();
        tour.setOption('tooltipPosition', 'auto');
        tour.setOption('positionPrecedence', ['left', 'right','top']);
        tour.start();

    }
</script>

    <div class="col-md-12-main">
        <div class="container-fluid">
            <!--div class="row">
                <h5>Proyectos de Inversión</h5>
                <label class="pull-right" onclick="startTour();"><i class="fa fa-question-circle fa-hover" aria-hidden="true"></i><span style="font-weight: bold"> Ayuda</span></label>
            </div-->
       
            <div class="row">
                <div class="row">
                    <div class=" col-md-8">
                        <!--<a class="btn btn-success pull-right" onclick="loadModal('infFinanciera/vwEjecucion','full-width','1','ejecucion')" style="" href="#Ejecucion">% Ejecucion</a>-->
                    </div>
                </div>
                
                <div class="table-responsive" style="border:0px">
                    <div id='gridwrapper' class='gridWrapper'>
                        <table id='list2'  data-step="2" data-intro="Lista de proyectos"><tr><td></td></tr></table>
                        <div id='pager2'></div>
                    </div>
                </div>
                <br>
                <!--div class="row table-responsive">
                    <table id="list2"></table>
                    <div id="pager2"></div>
                </div-->
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="well">
                            <table width="100%">
                                    <thead>
                                    <tr>
                                        <th colspan="6" style="padding-left: 85%" >Ayuda <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Cada estado del proyecto tendrá asignado un icono y un color, dependiendo el estado de la información que posee actualizada"></i></th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" style="text-align: center;" > <label style="font-size: 14px;text-decoration: underline;">Estado de Proyecto</label></th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td colspan="2" valign="middle"><label style="float: left"> <b>MANTENER ACTUALIZADO</b> </label></td>
                                    <td colspan="4">
                                        <div>
                                            <i class="fa fa-star" aria-hidden="true" style="color: orange;font-size: 20px;"></i>
                                        </div>
                                    </td>
                                </tr>
                                <!--<tr style="background-color: rgba(221, 206, 57, 0.55)">
                                    <td colspan="2" valign="middle"><label> <b>Informacion Fotográfica</b></label></td>
                                    <td colspan="2">
                                        <div>
                                            <div>Actualizado = <i class='fa fa-file-image-o' aria-hidden='true' style='color:green'></i></div>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div>
                                            <div>Desactualizado = <i class='fa fa-file-image-o' aria-hidden='true' style='color:red'></i></div>
                                        </div>
                                    </td>
                                </tr>-->
                                <!--<tr style="background-color: #dadada">
                                    <td colspan="2"><label> <b>Estado Situacional</b> </label></td>
                                    <td colspan="2">
                                        <div>
                                            <div>Actualizado = <i class='fa fa-book' aria-hidden='true' style='color:green'></i></div>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div>
                                            <div>Desactualizado = <i class='fa fa-book' aria-hidden='true' style='color:red'></i></div>
                                        </div>
                                    </td>
                                </tr>-->
                                <tr>
                                    <td colspan="2"><label> <b>Paralizado</b> </label></td>
                                    <td colspan="4">
                                        <div>
                                            <div><i class='fa fa-exclamation-triangle' aria-hidden='true' style='color:orange'></i></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="well">
                        <table border='0' style="width: 100%;text-align: left" data-step="1" data-intro="Cantidad de proyectos por etapas (Leyenda)">
                            <thead>
                            <tr>
                                <th colspan="6" style="padding-left: 85%" >Ayuda <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Cada etapa del proyecto tendrá asignado un color"></i></th>
                            </tr>
                            <tr>
                                <th colspan="6" style="text-align: center;" > <label style="text-decoration: underline;">Etapas de Proyecto</label></th>
                            </tr>
                            </thead>
                            <tr style="height: 12px">
                                <td style="width: 2%"><div class="leyendbox perfil"></div></td>
                                <td><label> Perfil/ Ficha</label> : <span id="perfil"></span></td>

                                <td style="width: 2%"><div class="leyendbox exptec"></div></td>
                                <td><label> Expediente Técnico</label> : <span id="exptec"></span></td>

                                <td style="width: 2%"><div class="leyendbox ejecucion"></div></td>
                                <td><label> Ejecución</label> : <span id="ejec"></span></td>
                            </tr>
                            <tr>
                                <td style="width: 2%"><div class="leyendbox culminado"></div></td>
                                <td><label> Culminado</label> : <span id="culminado"></span></td>

                                <td style="width: 2%"><div class="leyendbox liquidacion"></div></td>
                                <td><label> Liquidación</label> : <span id="liquid"></span></td>

                                <td><div class="leyendbox transferencia"></div></td>
                                <td><label> Transferencia</label> : <span id = 'transf'></span></td>

                            </tr>
                            <tr>
                                <td><div class="leyendbox total"></div></td>
                                <td><label> Con Etapa</label> : <span id = 'total'></span></td>

                                <td><div class="leyendbox total"></div></td>
                                <td><label> Total</label> : <span id = 'totaln'></span></td>
                            </tr>
                            <tr>
                                <td><div class="leyendbox" style="background-color: red"></div></td>
                                <td colspan="4"><label> <b>¿En SAYHUITE Georreferenciado? (SI/NO)</b></label></td>
                            </tr>
                        </table>
                        </div>

                        <script>
                            $(function () {
                                $('[data-toggle="tooltip"]').tooltip()
                            })
                        </script>
                    </div>
            </div>
            <br>
        </div>
    </div>
    <div id="modal_exportar" class="modal fade" role="dialog" tabindex="-1" data-target=".bd-example-modal-sm" style="outline: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center"><b>Exportar Información del proyecto</b></h4>
        </div>
        <div id="m-message"></div>
        <div class="modal-body">
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div> -->
    </div>
@section('script')


<!-- JQUERY UI -->
<script src="{{ asset('librerias/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- DROPZONE -->
<script src="{{ asset('/librerias/dropzone/dropzone.js') }}"></script>
<!-- JqGRID -->
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/jquery.jqgrid.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/plugins/ui.multiselect.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/plugins/jquery.contextmenu.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/jqgridExcelExportClientSide-libs.js')}}" ></script>


<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script  src="https://demos.codexworld.com/print-specific-area-of-web-page-using-jquery/jquery.PrintArea.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>


<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
<!-- CHOSEN -->
<script src="{{ asset('plugins/chosen/chosen.jquery.min.js') }}"></script>

<script>

    $(document).ready(function () {

            scw = $(window).width();
            scw -= 315;

            var WidthNomProyec;
            WidthNomProyec = 250;
            if(scw>1285){
                WidthNomProyec = scw - 1285 + 150;
            }
            @permission('sayhuite-state')scw += 30;@endpermission

                var click_frozen = 1,
                    table = $("#list2"),
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
            cm = [  //ESTADO
                    {
                        name: 'est',
                        title: false,
                        index: 'est',
                        width: 100,
                        align:'center',
                        sortable: false,
                        editable: false,
                        search: false,
                        fixed: true,
                        frozen:true,
                        hidden:false,
                        formatter: createIndicators
                    },//ACCCIONES
                    {
                        name: 'act',
                        title: false,
                        index: 'act',
                        width: 100,
                        align:'center',
                        sortable: false,
                        editable: false,
                        search: false,
                        fixed: true,
                        frozen:true,
                        formatter: createButtons
                    },//C. UNIFICADO
                    {
                        fixed:true,
                        frozen:true,
                        name: 'cod_unif',
                        title: false,
                        index: 'cod_unif',
                        width: 70,
                        align:'center',
                        sortable:true,
                        editable: false,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//C. SNIP
                    {
                        fixed: true,
                        frozen:true,
                        name: 'cod_snip',
                        title: false,
                        index: 'cod_snip',
                        width: 70,
                        align:'center',
                        sortable:true,
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//NOMBRE PROYECTO
                    {
                        name: 'nom_proyec',
                        title: false,
                        index: 'nom_proyec',
                        width: WidthNomProyec,
                        frozen:true,
                        align:'left',
                        classes: 'wrapColumnText',
                        sortable:true,
                        editoptions:{rows:"3"},
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'etapa',
                        title: false,
                        index: 'etapa',
                        width: 100,
                        search:true,
                        sortable:true,
                        align:'center',
                        classes: 'wrapColumnTextEtapa',
                        cellattr: function (rowId, val, rawObject) {

                            $arrNameTipo = {
                                'TDR': 'tdr',
                                'PERFIL': 'perfil' ,
                                'EXPEDIENTE TÉCNICO' : 'exptec',
                                'EN EJECUCIÓN' : 'ejecucion',
                                'EN LIQUIDACIÓN': 'liquidacion' ,
                                'EN TRANSFERENCIA': 'transferencia' ,
                                'CULMINADO' : 'culminado' ,
                                'CIERRE' : 'cierre',
                                '' : ''};

                            var cls = $arrNameTipo[val];

                            return " class='"+ cls +"'";
                        },
                        defaultSearch: "cn",
                        searchoptions: {value: ":[Todo];PERFIL:PERFIL/FICHA;EXPEDIENTE TÉCNICO:EXPEDIENTE TÉCNICO;EN EJECUCIÓN:EN EJECUCIÓN;CULMINADO:CULMINADO;EN TRANSFERENCIA:EN TRANSFERENCIA;EN LIQUIDACIÓN:EN LIQUIDACIÓN;CIERRE:CIERRE"},
                        stype:'select'

                    },
                    //ID
                    {
                        name: 'id',
                        title: false,
                        index: 'id',
                        hidedlg: true,
                        width: 20,
                        hidden: true,
                        search: false
                    },
                    //PROVINCIA
                    {
                        name: 'prov',
                        title: false,
                        index: 'nom_prov',
                        width: 100,
                        sortable:true,
                        sorttype: 'string',
                        search:true,
                        align:'center',
                        hidden:false,
                        formatter:'string',
                        defaultSearch: "cn",
                        // searchoptions: {sopt: ['cn', 'eq', 'nc']}
                        searchoptions: {value: ":[Todo];BARRANCA:BARRANCA;CAJATAMBO:CAJATAMBO;CANTA:CANTA;CAÑETE:CAÑETE;HUARAL:HUARAL;HUAROCHIRI:HUAROCHIRI;HUAURA:HUAURA;OYON:OYON;YAUYOS:YAUYOS;MULTIPROVINCIAL:MULTIPROVINCIAL"},
                        stype:'select'
                    },
                    //MONTO PIP
                    {
                        name: 'm_pip',
                        title: false,
                        index: 'm_pip',
                        width: 115,
                        classes: 'wrapColumnText',
                        sortable:true,
                        sorttype: 'string',
                        search:false,
                        align:'right',
                        formatter:'number'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//MONTO TOTAL FINANCIADO
                    {
                        name: 'm_financiado',
                        title: false,
                        index: 'm_financiado',
                        width: 80,
                        classes: 'wrapColumnText',
                        sortable:true,
                        sorttype: 'string',
                        search:false,
                        align:'right',
                        formatter:'number',
                        hidden:true
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    //PROGRAMA
                    {
                        name: 'progr',
                        title: false,
                        index: 'progr',
                        align:'center',
                        width: 100,
                        search:false,
                        sortable:true,
                        hidden:true,
                        classes:'wrapColumnText',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    //UNIDAD FORMULADORA
                    {
                        name: 'u_formul',
                        title: false,
                        index: 'u_formul',
                        width: 100,
                        classes: 'wrapColumnText',
                        sortable:true,
                        sorttype: 'string',
                        search:true,
                        hidden:true,
                        align:'center',
                        formatter:'string'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    //MODALIDAD DE EJECUCION
                    {
                        name: 'm_ejec',
                        title: false,
                        index: 'm_ejec',
                        width: 100,
                        classes: 'wrapColumnText',
                        sortable:true,
                        sorttype: 'string',
                        search:true,
                        hidden:true,
                        align:'center',
                        formatter:'string'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//EJECUTORA
                    {
                        name: 'ger_direc',
                        title: false,
                        index: 'ger_direc',
                        width: 100,
                        align:'center',
                        sorttype: 'string',
                        seach:true,
                        sortable:true,
                        defaultSearch: "cn",
                        searchoptions: {value: ":[Todo];DIRECCION REGIONAL DE AGRICULTURA:DRA;GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE:GRRNGMA;GERENCIA SUB REGIONAL LIMA SUR:GSRLS;GERENCIA REGIONAL DE DESARROLLO ECONOMICO:GRDE;GERENCIA REGIONAL DE DESARROLLO SOCIAL:GRDS;GERENCIA REGIONAL DE INFRAESTRUCTURA:GRI;DIRECCION REGIONAL DE SALUD:DIRESA;DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES:DRTC;DIRECCION REGIONAL DE TRABAJO:DRT"},
                        stype:'select',
                        formatter: gerenciaTextFormatter
                    },//TIPO DE PROYECTO
                    {
                        name: 'tipo_pry',
                        title: false,
                        index: 'tipo_pry',
                        width: 90,
                        align:'center',
                        sorttype: 'string',
                        search:true,
                        sortable:true,
                        defaultSearch: "cn",
                        searchoptions: {value: ":[Todo];PIC:PIC;PIP:PIP;NO PIP:IOARR"},
                        stype:'select'
                    },//ULTIMO AÑO DE EJECUCION FINANCIERA
                    {
                        name: 'ult_anio_ejec_pry_financ',
                        title: false,
                        index: 'ult_anio_ejec_pry_financ',
                        width: 80,
                        align:'right',
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//AÑO DEL PIC
                    {
                        name: 'anio_pic',
                        title: false,
                        index: 'anio_pic',
                        width: 90,
                        align:'right',
                        sorttype: 'string',
                        hidden:true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {//MONTO PIA ULTIMO AÑO
                        name: 'pia',
                        title: false,
                        index: 'pia',
                        width: 90,
                        search:false,
                        sortable:true,
                        align:'right',
                        hidden: true,
                        formatter:'number'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {//MONTO PIM ULTIMO AÑO
                        name: 'm_pim',
                        title: false,
                        index: 'm_pim',
                        width: 90,
                        search:false,
                        sortable:true,
                        align:'right',
                        hidden: false,
                        formatter:'number'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {//MONTO PIM ACUMULADO
                        name: 'm_pim_acu',
                        title: false,
                        index: 'm_pim_acu',
                        width: 80,
                        search:false,
                        sortable:true,
                        align:'right',
                        hidden: true
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    //DEVENGADO ANUAL
                    {
                        name: 'm_deveng',
                        title: false,
                        index: 'm_deveng',
                        width: 80,
                        search:false,
                        sortable:true,
                        hidden:false,
                        align:'right',
                        formatter:'number'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    //GIRADO ANUAL
                    {
                        name: 'girado',
                        title: false,
                        index: 'girado',
                        width: 80,
                        search:false,
                        sortable:true,
                        hidden:true,
                        align:'right',
                        formatter:'number'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//DEVENGADO ACUMULADO
                    {
                        name: 'm_deveng_a',
                        title: false,
                        index: 'm_deveng_a',
                        hidden:true,
                        width: 80,
                        search:false,
                        sortable:true,
                        align:'right'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    //AVANCE FIANACIERO ANUAL
                    {
                        name: 'a_financ',
                        title: false,
                        index: 'a_financ',
                        width: 70,
                        search:false,
                        sortable:false,
                        align:'right'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//AVANCE FINANCIERO ACUMULADO
                    {
                        name: 'a_financ_a',
                        title: false,
                        index: 'a_financ_a',
                        width: 80,
                        search:false,
                        sortable:true,
                        align:'right'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    //FECHA FINANCIERA
                    {
                        name: 'f_deveng_a',
                        title: false,
                        index: 'f_deveng_a',
                        width: 70,
                        hidden:true
                    },//AVANCE FISICO PROYECTO
                    {
                        name: 'a_fisico',
                        title: false,
                        index: 'a_fisico',
                        align:'right',
                        width: 70,
                        search:false,
                        sortable:true
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'meta_actual',
                        title: false,
                        index: 'meta_actual',
                        align:'center',
                        width: 100,
                        search:false,
                        hidden:true,
                        sortable:true,
                        classes:'wrapColumnText'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'f_afisico',
                        title: false,
                        index: 'f_afisico',
                        width: 70,
                        hidden:true
                    },
                    {
                        name: 'sub_etapa',
                        title: false,
                        index: 'sub_etapa',
                        width: 100,
                        hidden: true
                    },
                    {
                        name: 'situa_pro',
                        title: false,
                        index: 'situa_pro',
                        classes: 'wrapColumnText',
                        width: 500,
                        hidden:true
                    },
                    {
                        name: 'f_etapsub',
                        title: false,
                        index: 'f_etapsub',
                        width: 100,
                        align:'right',
                        sorttype: 'string',
                        search:false
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'estado_pic',
                        title: false,
                        index: 'estado_pic',
                        width: 60,
                        cellattr: function (rowId, val, rawObject) {
                            //console.log(val);
                            var c = 'GREY';
                            if(val === 'PRIORIZADO'){
                                c = 'RED';
                            }

                            return " style='color:white;background-color:"+c+"'";
                        },
                        formatter: colorMostradoSayhuite,
                        align:'center',
                        sorttype: 'string',
                        search:false

                    }
                    @permission('sayhuite-state'),
                    {
                        name: 'chkSayhuite',
                        title: false,
                        index: 'chkSayhuite',
                        width: 36,
                        align:'center',
                        sortable: false,
                        search: false,
                        formatter: createCheckboxSayhuite
                    }@endpermission
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
            url: '{{ url("/filter-data") }}',
            datatype: "json",
            mtype: 'POST',
            //autoencode:false,
            //loadonce:true,
            colNames: [
                'Actualización',
                'Acción',
                'Código Unificado',
                'Código SNIP',
                'Nombre Del Proyecto',
                'Etapa',
                'id',
                'Provincia',
                'Monto actualizado del PIP (S/.)',
                'Monto Financiado (S/.)',
                'Cadena Funcional',
                'Unidad Formuladora',
                'Modalidad de Ejecucion',
                'Unidad Ejecutora',
                'Origen',
                'Último año con información financiera',
                'Año del proyecto de inversión concertado',
                'PIA Último Año (S/.)',
                'PIM Último Año (S/.)',
                'PIM Acumulado (S/.)',
                'Devengado Último Año (S/.)',
                'Girado Último Año (S/.)',
                'Devengado Acumulado (S/.)',
                '% Avance Financiero Anual',
                '% Avance Financiero Acumulado',
                'Fecha de Actualizacion Financiera',
                '% Avance Fisico de la Obra',
                'Meta Actual',
                'Fecha de Avance Fisico',
                'Sub Etapa',
                'Situacion del Proyecto',
                'Fecha de Actualizacion de estado Situacional',
                'Mostrado en Sayhuite'
                @permission('sayhuite-state'),'Sayhuite'@endpermission
            ],
            colModel: cm,
            autoResizing: { compact: true },
            iconSet: "fontAwesome",
            //guiStyle: "bootstrap",
            shrinkToFit: false,
            width: scw,
            viewrecords: true,
            //sortable: true,
            toppager: true,
            rownumbers: true,
            rowNum: 10,
            rowList: [10,15 , 20, 30, 100, 200, 300, 400, 500, 600, 700],
            pager: '#pager2',
            page: isColState ? myColumnsState.page : 1,
            search: isColState ? myColumnsState.search : false,
            postData: isColState ? { filters: myColumnsState.filters } : {},
            sortname: isColState ? myColumnsState.sortname : "estado_pic",
            sortorder: isColState ? myColumnsState.sortorder : "desc",
            toolbar: [true, "top"],
            //sortname: 'estado_pic',
            //viewrecords: true,
            //sortorder: "desc",
            caption: "Proyectos de Inversión",
            sortable: {
                update: function () {
                    saveColumnState.call(table);
                },
                options: {
                    opacity: 0.8
                }
            },
            //rownumbers: true
            serializeGridData: function (postData) {
                //CREDITO SUPLEMENTARIO
                postData["_credito"] = $("#_cs_flag").is(':checked');
                if(postData["_credito"]){
                    postData["_continuidad"] = $("#_cs_continuidad").is(':checked');
                    postData["_financiamiento"]  = $("#_cs_transferencia").is(':checked');
                }

                postData["_multianual"] = $("#_multianual_flag").is(':checked');

                // console.log(postData);
                return postData;
            },
            recreateFilter:true,
            loadComplete: function (data) {
                $(window).bind('resize', function() {

                    // Get width of parent container
                    var gridId = "list2";
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

                    var dt = data.rows;

                    var ids = table.jqGrid('getDataIDs');

                    //LEGEND
                    $.each(data.legend,function($key,$val){
                        $('#'+$key).html('<span style="color: green;"><b>'+$val+'</b><span>');
                        if($key == 'singerencia'){
                            $('#sin_ger_count').html($val);
                            if($val == '0'){
                                $('#sin_ger_count').parent().fadeOut("slow");
                            }
                        }
                    });

                    //SUMAS
                    $.each(data.suma,function($key,$val){
                        //console.log($key);
                        $('#'+$key).html('<span style="color: green;"><b>'+ addCommas($val) +'</b><span>');
                    });



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


            },
            resizeStop: function () {
                saveColumnState.call(table, table[0].p.remapColumns);
            }
        }).jqGrid("navGrid", { add: false, edit: false, del: false })
            //.jqGrid("inlineNav")
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
                        //table.jqGrid('exportarExcelCliente',{nombre:"Proyectos",formato:"excel"});
                        o = {nombre:"Proyectos",formato:"excel"};
                        var archivoExporta, hojaExcel;
                        archivoExporta = {
                            worksheets: [[]],
                            creator: "Javier",
                            created: new Date(),
                            lastModifiedBy: "OPMI",
                            modified: new Date(),
                            activeWorksheet: 0
                        };
                        hojaExcel = archivoExporta.worksheets[0];
                        hojaExcel.name = o.nombre;

                        var arrayCabeceras = new Array();
                        arrayCabeceras = $(this).getDataIDs();
                        var dataFilaGrid = $(this).getRowData(arrayCabeceras[0]);
   
                        var nombreColumnas = new Array();
                        var nombreColumnasLabel = new Array();
                        var ii = 0;
                        colums = 
                        {
                            "cod_unif" :	'Código Unificado',
                            "cod_snip" :	'Código SNIP',
                            "nom_proyec" :	'Nombre Del Proyecto',
                            "etapa" :	'Etapa',
                            "prov" :	'Provincia',
                            "m_pip" :	'Monto actualizado del PIP (S/.)',
                            "m_financiado" :	'Monto Financiado (S/.)',
                            "progr" :	'Cadena Funcional',
                            "u_formul" :	'Unidad Formuladora',
                            "m_ejec" :	'Modalidad de Ejecucion',
                            "ger_direc" :	'Unidad Ejecutora',
                            "tipo_pry" :	'Origen',
                            "ult_anio_ejec_pry_financ" :	'Último año con información financiera',
                            "anio_pic" :	'Año del proyecto de inversión concertado',
                            "pia" :	'PIA Último Año (S/.)',
                            "m_pim" :	'PIM Último Año (S/.)',
                            "m_pim_acu" :	'PIM Acumulado (S/.)',
                            "m_deveng" :	'Devengado Último Año (S/.)',
                            "girado" :	'Girado Último Año (S/.)',
                            "m_deveng_a" :	'Devengado Acumulado (S/.)',
                            "a_financ" :	'% Avance Financiero Anual',
                            "a_financ_a" :	'% Avance Financiero Acumulado',
                            "f_deveng_a" :	'Fecha de Actualizacion Financiera',
                            "a_fisico" :	'% Avance Fisico de la Obra',
                            "meta_actual" :	'Meta Actual',
                            "f_afisico" :	'Fecha de Avance Fisico',
                            "sub_etapa" :	'Sub Etapa',
                            "situa_pro" :	'Situacion del Proyecto',
                            "f_etapsub" :	'Fecha de Actualizacion de estado Situacional',
                        };

                        for (var i in dataFilaGrid) {
                            if(i != 'est' && i != 'act' && i != 'chkSayhuite' && i != 'estado_pic' && i != 'id'){
                                nombreColumnas[ii] = i;
                                nombreColumnasLabel[ii] = colums[i];
                                ii++;
                            }
                        }
                        
                        hojaExcel.push(nombreColumnasLabel);
                        var dataFilaArchivo;
                        for (i = 0; i < arrayCabeceras.length; i++) {
                            dataFilaGrid = $(this).getRowData(arrayCabeceras[i]);
                            dataFilaArchivo = new Array();
                            for (j = 0; j < nombreColumnas.length; j++) {
                                dataFilaArchivo.push(dataFilaGrid[nombreColumnas[j]]);
                            }
                            hojaExcel.push(dataFilaArchivo);
                        }
                        return window.location = xlsx(archivoExporta).href();
                    },
                })
                //.jqGrid("setFrozenColumns");

            $('#t_' + $.jgrid.jqID(table[0].id))
                .append($("<div><label for=\"globalSearchText\">Busqueda General:&nbsp;</label><input id=\"globalSearchText\" type=\"text\"></input>&nbsp;<button id=\"globalSearch\" type=\"button\">Buscar</button></div>"));
            $("#globalSearchText").keypress(function (e) {
                var key = e.charCode || e.keyCode || 0;
                if (key === $.ui.keyCode.ENTER) { // 13
                    $("#globalSearch").click();
                }
            });
            $("#globalSearch").button({
                icons: { primary: "ui-icon-search" },
                text: false
            }).click(function () {
                var postData = table.jqGrid("getGridParam", "postData"),
                    colModel = table.jqGrid("getGridParam", "colModel"),
                    rules = [],
                    searchText = $("#globalSearchText").val(),
                    l = colModel.length,
                    i,
                    cm;
                for (i = 0; i < l; i++) {
                    cm = colModel[i];
                    if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {
                        rules.push({
                            field: cm.name,
                            op: "cn",
                            data: searchText
                        });
                    }
                }
                postData.filters = JSON.stringify({
                    groupOp: "OR",
                    rules: rules
                });
                table.jqGrid("setGridParam", { search: true });
                table.trigger("reloadGrid", [{page: 1, current: true}]);
                return false;
            });

        //MANAGEMENT BUTTONS
        function createButtons (cellvalue, options, rowObject){

            var cl = rowObject['id'];
            var bEdit = "",bShow,bPrint,bGantt = "";

            var bUpdateState;

            @permission('pi-edit')
            // ||Solo Aparecerá si tiene permiso de editar proyectos||
              //* Verificar si puede editar el proyecto
              if(rowObject['canEdit'])
                bEdit = "<button class='btn btn-default' data-step='3' data-intro='Edite Información del proyecto' style='height:30px;width:30px;margin: 0;padding: 0;' id='E' title = 'Editar' type='button' class='e' onclick='window.location.assign(\"/piptotalpriori/edit/" + cl + "\")'\"><i id='E' class='fa fa-edit fa-lg e' aria-hidden='true'></i></button>";
              else{
                bEdit = "<button class='btn btn-default' disabled='disabled' data-step='3' data-intro='Edite Información del proyecto' style='height:30px;width:30px;margin: 0;padding: 0;' id='E' title = 'Editar' type='button' class='e' onclick=''\"><i id='E' class='fa fa-edit fa-lg e' aria-hidden='true'></i></button>";
              }

              @if(Auth::user()->hasRole('admin') == true )
                bEdit = "<button class='btn btn-default' data-step='3' data-intro='Edite Información del proyecto' style='height:30px;width:30px;margin: 0;padding: 0;' id='E' title = 'Editar' type='button' class='e' onclick='window.location.assign(\"/piptotalpriori/edit/" + cl + "\")'\"><i id='E' class='fa fa-edit fa-lg e' aria-hidden='true'></i></button>";
              @endif
            @endpermission

            bShow = "<button class='btn btn-default' data-step='4' data-intro='Muestre Información del proyecto' style='height:30px;width:30px;margin: 0;padding: 0;' id='S' title = 'Ver' type='button' class='e' onclick='loadModal(\"/piptotalpriori/show\",\"full-width\",\"1\",\""+ cl +"\",\"PROYECTO\")'\"><i id='S' class='fa fa-eye fa-lg e' aria-hidden='true'></i></button>";
            bPrint = "<button class='btn btn-default' data-step='7' data-intro='Exporte Información del proyecto' style='height:30px;width:30px;margin: 0;padding: 0;' id='P' title = 'Exportar' type='button' class='e' onclick='modal_exportar("+cl+")'><i id='P' class='fa fa-print fa-lg e' aria-hidden='true'></i></button>";
            bHistoryF = "<button class='btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' id='P' title = 'Estado Financiero' type='button' class='e' onclick='window.open(\"/piptotalpriori/historyf/"+cl+"\",\"_blank\")'><i id='P' class='fa fa-calculator fa-lg e' aria-hidden='true'></i></button>";

            bHistory = "<br><button class='btn btn-default' style='height:30px;width:30px;margin: 0;padding: 0;' type='button' class='e' title='Linea de Tiempo' onclick='window.open(\"/piptotalpriori/history/"+cl+"\",\"_blank\")'><i id='P' class='fa fa-tasks fa-lg e' aria-hidden='true'></i></button>";

            bGantt= "<button class='btn btn-default' data-step='' data-intro='' style='height:30px;width:30px;margin: 0;padding: 0;' id='S' title = 'Formato N° 12-B' type='button' class='e' onclick='goToCronograma("+cl+")'><i class='fa fa-calendar fa-lg e' aria-hidden='true'></i></button>";

            // <button class='btn btn-default' data-step='7' data-intro='Exporte Información del proyecto' style='height:30px;width:30px;margin: 0;padding: 0;' id='P' title = 'Información del proyecto' type='button' class='e' data-toggle='modal' data-target='#modal_exportar'><i id='P' class='fa fa-print fa-lg e' aria-hidden='true'></i></button>
            // <button class='btn btn-default' data-step='7' data-intro='Exporte Información del proyecto' style='height:30px;width:30px;margin: 0;padding: 0;' id='P' title = 'Información del proyecto' type='button' class='e' onclick='window.open(\"/piptotalpriori/pdfExport/"+cl+"\",\"_blank\")'><i id='P' class='fa fa-print fa-lg e' aria-hidden='true'></i></button>
           return bEdit + bShow + bPrint + bHistory + bGantt + bHistoryF
        }

        modal_exportar=function(id) {
          $html='<div class="row">'+
                      '<div class="col-md-6 text-center">'+
                        '<a class="btn btn-app" onclick="window.open(\'/piptotalpriori/pdfExport/'+id+'\',\'_blank\')" style="background-color:#dd4b39;color: #fff;">'+
                          '<i class="fa fa-file-pdf-o"></i> PDF'+
                        '</a>'+
                      '</div>'+
                      '<div class="col-md-6 text-center">'+
                        '<a class="btn btn-app" href="piptotalpriori/wordExport/'+id+'" style="background-color:#3c8dbc;color: #fff;">'+
                          '<i class="fa fa-file-word-o"></i> Word'+
                        '</a>'+
                      '</div>'+
                    '</div>';
          $('#modal_exportar .modal-body').html($html);
          $('#modal_exportar').modal('show', {backdrop: 'true'});
        }
        //GERENCIA TEXT FORMATTER
        function gerenciaTextFormatter(cellvalue, options, rowObject){
            var arrUE = {
                'DIRECCION REGIONAL DE AGRICULTURA' : 'DRA',
                'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE': 'GRRNGMA',
                'GERENCIA SUB REGIONAL LIMA SUR' : 'GSRLS',
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' :'GRDE',
                'GERENCIA REGIONAL DE DESARROLLO SOCIAL' : 'GRDS',
                'GERENCIA REGIONAL DE INFRAESTRUCTURA' : 'GRI',
                'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES' : 'DRTC',
                'DIRECCION REGIONAL DE SALUD' : 'DIRESA',
                'DIRECCION REGIONAL DE EDUCACION' : 'DRE',
                'DIRECCION REGIONAL DE TRABAJO' : 'DRT',
                '' : ''
            };
            return arrUE[cellvalue];
        }
        //SAYHUITE CHECKS
        function createCheckboxSayhuite(cellvalue, options, rowObject){

                var cl = rowObject['id'];

                //Sayhuite check
                chk = '';

                if (rowObject['estado_pic'] == 'PRIORIZADO') {
                    chk = 'checked';
                }
                be = "<input onclick='sayhuite(this)' name='" + cl + "' type='checkbox' id ='S' value = " + cl + " " + chk + "/>";

               return be;
        }
        //COLOR MOSTRADO SAYHUITE SI/NO
        function colorMostradoSayhuite(cellvalue, options, rowObject){
            //console.log(cellvalue);
            var val;
            switch (cellvalue){
                case 'NO':
                    val = 'NO';
                    break;
                case 'PT':
                    val = 'NO';
                    break;
                case 'PRIORIZADO':
                    val = 'SI';
                    break;
            }
            return val;
        }
        //INDICATORS ESTADO
        function createIndicators(cellvalue, options, rowObject){
        
            if ( rowObject['completo'] ){
                best ="<label class='label label-success'>Ejecución Completa <i class='fa fa-check'></i></label>";
            } else {

                var etitle,ftitle,fotitle,ptitle;

                //ESTADO TITLE
                switch ( rowObject['etapaState'][0] ){
                    case 'success':
                        etitle = 'Estado Situacional: ACTUALIZADO';
                            break;
                    case 'warning':
                        etitle = 'Estado Situacional: ACTUALIZAR';
                            break;
                    case 'danger':
                        etitle = 'Estado Situacional: NO ACTUALIZADO';
                            break;
                    default:
                        etitle = '';
                            break;
                }

                //FOTO TITLE
                switch (rowObject['imgState']){
                    case 'success':
                        ftitle = 'Información Fotográfica: ACTUALIZADO';
                        break;
                    case 'warning':
                        ftitle = 'Información Fotográfica: ACTUALIZAR';
                        break;
                    case 'danger':
                        ftitle = 'Información Fotográfica: NO ACTUALIZADO';
                        break;
                    default:
                        ftitle = '';
                        break;
                }

                /*PRIORIDAD
                var pcolor;
                 switch (rowObject['prioridad']){
                     case '1':
                         ptitle = 'PRIORIDAD 1';
                         pcolor = 'orange';
                        break;
                     case '2':
                         ptitle = 'PRIORIDAD 2';
                         pcolor = 'orange';
                        break;
                     case '3':
                         ptitle = 'PRIORIDAD 3';
                         pcolor = 'white';
                        break;
                     default:
                         ptitle = 'MANTENER ACTUALIZADO';
                         pcolor = 'white';
                        break;
                }*/

                var best = "<div>";
                if(rowObject['etapaState'][0] == 'danger'){
                    if(rowObject['etapaState'][1] == 0){
                        best += "<label class='label label-"+rowObject['etapaState'][0]+"'> Sin Registro</label><br>"; //ESTADO
                    }else{
                        best += "<label class='label label-"+rowObject['etapaState'][0]+"'> Estado hace "+rowObject['etapaState'][1]+" días</label><br>"; //ESTADO
                    }
                }else{
                    best += "<label class='label label-"+rowObject['etapaState'][0]+"'> Estado hace "+rowObject['etapaState'][1]+" días</label><br>"; //ESTADO
                }
                
               /*if(rowObject['imgState'][1]==0){
                    best += "<label class='label label-"+rowObject['imgState'][0]+"'> Sin Registro de Foto</label><br>"; //IMAGEN
               }else{
                    best += "<label class='label label-"+rowObject['imgState'][0]+"'> Foto hace "+rowObject['imgState'][1]+" días</label><br>"; //IMAGEN
               }*/
            
                /*if(rowObject['prioridad'] == 1 || rowObject['prioridad'] == 2) {
                    best += "<br><div title='" + ptitle + "' style='float:rigth;font-size:20px;margin-right:2px'><i class='fa fa-star' aria-hidden='true' style='color:" + pcolor
                         + ";'></i></div>"; //PRIORIDAD
                }*/
                best +="</div>";

                /*
                best += "<div>"
                if(rowObject['paralizado'] != 'success'){
                    best += "<div title='PARALIZADO' style='float:right;font-size:20px;margin-left:2px'><i class='fa fa-exclamation-triangle' aria-hidden='true' style='color:orange'></i></div>"; //PARALIZADO
                }
                best +="</div>";*/
            }
            return best
        }


        /* SELECT2 -------------------------------------------> */
        var $select = $('#gs_list2_ger_direc');
        $select.select2();
        var $selecttipPry = $('#gs_list2_tipo_pry');
        $selecttipPry.select2();
        var $selectEtapa = $('#gs_list2_etapa');
        $selectEtapa.select2();

        $selecttipPry.change(function(){

            //$('input[id*="gs_"]').val("");
            //$('select[id*="gs_"]').val("TODO");
            //table.jqGrid('setGridParam', { search: false, postData: { "filters": ""} }).trigger("reloadGrid");

            switch($(this).val()){
                case 'PIC':
                    table.jqGrid('hideCol', ["ult_anio_ejec_pry_financ"]);
                    table.jqGrid('showCol', ["anio_pic"]);
                    table.setColProp('ult_anio_ejec_pry_financ', {search: false});
                    table.setColProp('anio_pic', {search: true});
                    break;
                case 'PIP':
                    table.jqGrid('showCol', ["ult_anio_ejec_pry_financ"]);
                    table.jqGrid('hideCol', ["anio_pic"]);
                    table.setColProp('ult_anio_ejec_pry_financ', {search: true});
                    table.setColProp('anio_pic', {search: false});
                    break;
                case 'IOAR':
                    table.jqGrid('showCol', ["ult_anio_ejec_pry_financ"]);
                    table.jqGrid('hideCol', ["anio_pic"]);
                    table.setColProp('ult_anio_ejec_pry_financ', {search: true});
                    table.setColProp('anio_pic', {search: false});
                    break;
                default:
                    table.jqGrid('showCol', ["ult_anio_ejec_pry_financ"]);
                    table.jqGrid('hideCol', ["anio_pic"]);
                    break;
            }

            table.trigger("reloadGrid");
        });

        triggerSearch = function(){
            setTimeout(function() {
                table.trigger("reloadGrid");
            }, 500);
        }

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

        sayhuite = function(elem){
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
            }).then(function() {
                console.log(that.name);
                $.ajax({
                    url: "/stateSayhuite",
                    type: 'POST',
                    data: {st: st, uid: that.name},
                    success: function (data) {
                        console.log(data);
                    }
                });
                swal(
                        'Listo',
                        'La visibilidad del proyecto se ha cambiado',
                        'success'
                )
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

    });
</script>

<script>

  function goToCronograma(idProyecto){
    $.ajax({
        url: '/piptotalpriori/getMetas/'+idProyecto,
        type: 'GET',
        beforeSend: function () {

        },
        success: function (response) {
          if(response.metas.length===0){
            swal('El proyecto no tiene ejecución registrada, agregue una')
          } else {
            var win = window.open('/piptotalpriori/cronograma/'+idProyecto, '_blank');
            win.focus();
          }
        }
    });
  }
  function loadModal(url,modaltype,CRUD,opc,tipo_pry) {
    $modal = $('#' + modaltype);
    //clean errors
    $(".m-message").html('<div></div>');
    switch (CRUD) {
      //WITH ID [SHOW]
      case '1':
          $.ajax({
              url: url,
              type: 'POST',
              data: {'id': opc,'tipopry':tipo_pry},
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
      //WITHOUT ID [MODALS]
      case '2':
          $.ajax({
              url: url,
              type: 'POST',
              dataType: "html",
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

  @if(!empty($accion) and $accion==1)
    loadModal("/piptotalpriori/show","full-width",'1',{{ $id }},'{{$tipopry}}');
  @endif
</script>
@endsection
@endsection
