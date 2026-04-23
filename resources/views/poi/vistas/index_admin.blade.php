@extends('piptotalpriori.index')

@section('table_top')
                        <div class="row">                             
                            <div class=" col-md-8">
                                <!--a class="btn btn-success pull-right" onclick="loadModal('infFinanciera/vwEjecucion','full-width','1','ejecucion')" style="" href="#Ejecucion">% Ejecucion</a-->
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                                <div class="row">
                                <br>
                                    <div id="tree">
                                        <ul>
                                            <li>
                                                <input type="checkbox" id = "_cs_flag" onchange="triggerSearch();" /><span> Credito Suplementario</span>
                                                <ul>
                                                    <li>
                                                        <input type="checkbox" onchange="triggerSearch();" /><span> 2017</span>
                                                        <ul>
                                                            <li><input type="checkbox" id = "_cs_transferencia" onchange ="triggerSearch();" /><span> Financiamiento</span></li>
                                                            <li><input type="checkbox" id = "_cs_continuidad" onchange="triggerSearch();" /><span> Continuidad</span></li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                
                                            </li>                                            
                                        </ul>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-9">                                
                                <button id="tuto-searchbar" data-step="5" data-intro="Identifique los proyectos que le pertenecen a su gerencia" type="button" class="btn btn-danger btn-lg pull-right" onclick="loadModal('piptotalpriori/selectpi','modal_simple','2','0');event.stopPropagation();">Identifica qué proyectos pertenecen a tu gerencia <span class="badge" id="sin_ger_count"></span></button>
                                <a class="btn btn-success btnAgregar" style="pointer-events:none;cursor:default;display: none;" href="{{-- URL::to('/piptotalpriori/create') --}}" disabled=disabled><span class="glyphicon glyphicon-plus"></span> AGREGAR</a><a class="btn btn-success btnAgregar" style="pointer-events:none;cursor:default;display: none;" href="{{-- URL::to('/piptotalpriori/create') --}}" disabled=disabled><span class="glyphicon glyphicon-plus"></span> AGREGAR</a>
                            </div>
                        </div>

@endsection

@section('cm')
    [  //ESTADO
                    {
                        name: 'est',
                        title: false,
                        index: 'est',
                        width: 70,
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
                    },//ID
                    {
                        name: 'id',
                        title: false,
                        index: 'id',
                        hidedlg: true,
                        width: 20,
                        hidden: true,
                        search: false
                    },//MONTO PIP
                    {
                        name: 'm_pip',
                        title: false,
                        index: 'm_pip',
                        width: 80,
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
                    //PROVINCIA
                    {
                        name: 'nom_prov',
                        title: false,
                        index: 'nom_prov',
                        width: 100,
                        classes: 'wrapColumnText',
                        sortable:true,
                        sorttype: 'string',
                        search:true,
                        align:'center',
                        hidden:false,
                        formatter:'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//UNIDAD FORMULADORA
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
                        width: 80,
                        align:'center',
                        sorttype: 'string',
                        seach:true,
                        sortable:true,
                        defaultSearch: "cn",
                        searchoptions: {value: ":[Todo];DIRECCION REGIONAL DE AGRICULTURA:DRA;GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE:GRRNGMA;GERENCIA SUB REGIONAL LIMA SUR:GSRLS;GERENCIA REGIONAL DE DESARROLLO ECONOMICO:GRDE;GERENCIA REGIONAL DE DESARROLLO SOCIAL:GRDS;GERENCIA REGIONAL DE INFRAESTRUCTURA:GRI;DIRECCION REGIONAL DE SALUD:DIRESA;DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES:DRTC"},
                        stype:'select',
                        formatter: gerenciaTextFormatter
                    },//TIPO DE PROYECTO
                    {
                        name: 'tipo_pry',
                        title: false,
                        index: 'tipo_pry',
                        width: 80,
                        align:'center',
                        sorttype: 'string',
                        search:true,
                        sortable:true,
                        defaultSearch: "cn",
                        searchoptions: {value: ":[Todo];PIC:PIC;PIP:PIP"},
                        stype:'select'
                    },//ULTIMO AÑO DE EJECUCION FINANCIERA
                    {
                        name: 'ult_anio_ejec_pry_financ',
                        title: false,
                        index: 'ult_anio_ejec_pry_financ',
                        width: 70,
                        align:'right',
                        sorttype: 'string',
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//AVANCE FIANACIERO ANUAL
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
                        width: 70,
                        search:false,
                        sortable:true,
                        align:'right'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {//MONTO PIM ULTIMO AÑO
                        name: 'm_pim',
                        title: false,
                        index: 'm_pim',
                        width: 70,
                        search:false,
                        sortable:true,
                        align:'right',
                        hidden: true
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {//MONTO PIM ACUMULADO
                        name: 'm_pim_acu',
                        title: false,
                        index: 'm_pim_acu',
                        width: 70,
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
                        width: 70,
                        search:false,
                        sortable:true,
                        hidden:true,
                        align:'right'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//DEVENGADO ACUMULADO
                    {
                        name: 'm_deveng_a',
                        title: false,
                        index: 'm_deveng_a',
                        hidden:true,
                        width: 70,
                        search:false,
                        sortable:true,
                        align:'right'
                        //searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },//FECHA FINANCIERA
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
                        searchoptions: {value: ":[Todo];PERFIL:PERFIL/FICHA;EXPEDIENTE TÉCNICO:EXPEDIENTE TÉCNICO;EN EJECUCIÓN:EN EJECUCIÓN;CULMINADO:CULMINADO;EN TRANSFERENCIA:EN TRANSFERENCIA;EN LIQUIDACIÓN:EN LIQUIDACIÓN"},
                        stype:'select'

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
                        name: 'anio_pic',
                        title: false,
                        index: 'anio_pic',
                        width: 70,
                        align:'right',
                        sorttype: 'string',
                        hidden:true,
                        searchoptions: {sopt: ['cn', 'eq', 'nc']}
                    },
                    {
                        name: 'estado_pic',
                        title: false,
                        index: 'estado_pic',
                        width: 60,
                        cellattr: function (rowId, val, rawObject) {
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
            ]
@endsection
@section('colNames')
    [
                'Estado',
                'Acción',
                'Código Unificado',
                'Código SNIP',
                'Nombre Del Proyecto',
                'id',
                'Monto PIP (S/.)',
                'Monto Financiado (S/.)',
                'Cadena Funcional',
                'Provincia',
                'Unidad Formuladora',
                'Modalidad de Ejecucion',
                'Ejecutora',
                'Tipo de Proyecto',
                'Ultimo Año de ejecución del proyecto',
                '% Avance Financiero Anual',
                '% Avance Financiero Acumulado',
                'PIM Último Año',
                'PIM Acumulado',
                'Devengado Anual',
                'Devengado Acumulado (B)',
                'Fecha de Actualizacion Financiera',
                '% Avance Fisico de la Obra',                
                'Meta Actual',
                'Fecha de Avance Fisico',
                'Etapa',
                'Sub Etapa',
                'Situacion del Proyecto',
                'Fecha de Actualizacion de estado Situacional',
                'Año del proyecto de inversión concertado',
                'Mostrado en Sayhuite'
                @permission('sayhuite-state'),'Sayhuite'@endpermission
            ]
@endsection