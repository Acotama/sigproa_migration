<span class="cabecera">
    <h3 class="text-center"><b>CONTRATACIONES: PROCEDIMIENTOS DE SELECCIÓN : {{$anio}}</b></h3>
    @if($categoria == 'EJECUTORA')
        <h4 class="text-center"><b class="text-uppercase">EJECUTORA : {{ $filtro}}</b></h4>
    @elseif($categoria == 'TIPO')
        <h4 class="text-center"><b class="text-uppercase">TIPO : {{ $filtro}}</b></h4>
    @elseif($categoria == 'ESTADO')
        <h4 class="text-center"><b class="text-uppercase">ESTADO : {{ $filtro}}</b></h4>
    @elseif($categoria == 'PROYECTO')
        <h4 class="text-center"><b class="text-uppercase">PROYECTO : {{ $filtro}}</b></h4>
    @endif
</span>

<div id="container" >
    <div class="modal-body">
        <div id="cargando_modal" class="loading" style="display: none;"></div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @if(isset($consulta_ejecutora))
                    <li id="p_ejecutora"><a href="#pd_ejecutora" data-toggle="tab" aria-expanded="false" activa onclick="actualizar()"><b>EJECUTORA</b></a></li>
                @endif
                @if(isset($consulta_tipo))
                    <li id="p_tipo"><a href="#pd_tipo" data-toggle="tab" aria-expanded="false" onclick="actualizar()"><b>TIPO</b></a></li>
                @endif
                @if(isset($consulta_estado))
                    <li id="p_estado"><a href="#pd_estado" data-toggle="tab" aria-expanded="false" onclick="actualizar()"><b>ESTADO</b></a></li>
                @endif
                @if(isset($consulta_proyecto))
                    <li id="p_proyecto"><a href="#pd_proyecto" data-toggle="tab" aria-expanded="false" onclick="actualizar()"><b>PROYECTOS</b></a></li>
                @endif
                <li id="p_contrataciones"><a href="#pd_contrataciones" data-toggle="tab" aria-expanded="false" onclick="actualizar()"><b>CONTRATACIONES</b></a></li>
            </ul>
            <div class="tab-content">
                @if(isset($consulta_ejecutora))
                    @php
                        $total_nprocesos = 0;
                        $total_valorrf = 0;
                    @endphp
                    <div class="tab-pane" id="pd_ejecutora">
                        <div class="col-md-12" style="margin-top: 15px;">
                            <div class="row">
                                <div class="table table-bordered table-responsive">
                                    <table class="table table-bordered " id="t_ejecutora" width="100%" cellspacing="0" class="form-control">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center" width="30%" >EJECUTORA</th>
                                                <th style="text-align:center" >DETALLE</th>
                                                <th style="text-align:center" >N° PROCEDIMIENTOS DE SELECCIÓN</th>
                                                <th style="text-align:center" > S/. TOTAL DE VALOR REFERENCIAL</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach($consulta_ejecutora as $row)
                                                @php 
                                                    $total_nprocesos += $row->n_proce;
                                                    $total_valorrf += $row->total; 
                                                @endphp
                                                <tr>
                                                    <td style='text-align:left;vertical-align: middle' class='text-uppercase'>{{ $row->categoria }}</td>
                                                    <td style='text-align:center;vertical-align: middle'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('{{ $categoria }}','{{ $filtro }}','ger_direc','{{ $row->categoria }}','{{ $anio }}')"><i class='fa fa-eye'></i></a></td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ $row->n_proce }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->total,0,'.',',') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr  style="background-color:#3c8dbc9c">
                                                <th style='text-align:center' colspan='2'>GOBIERNO REGIONAL DE LIMA</th>
                                                <th style='text-align:center'>{{ $total_nprocesos }}</th>
                                                <th style='text-align:center'>{{ number_format($total_valorrf,0,'.',',') }}</th>
                                            </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(isset($consulta_tipo))
                    @php
                        $total_nprocesos = 0;
                        $total_valorrf = 0;
                    @endphp
                    <div class="tab-pane" id="pd_tipo">
                        <div class="col-md-12" style="margin-top: 15px;">
                            <div class="row">
                                <div class="table table-bordered table-responsive">
                                    <table class="table table-bordered " id="t_tipo" width="100%" cellspacing="0" class="form-control">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center" width="30%" >TIPO</th>
                                                <th style="text-align:center" >DETALLE</th>
                                                <th style="text-align:center" >N° PROCEDIMIENTOS DE SELECCIÓN</th>
                                                <th style="text-align:center" > S/. TOTAL DE VALOR REFERENCIAL</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach($consulta_tipo as $row)
                                                @php 
                                                    $total_nprocesos += $row->n_proce;
                                                    $total_valorrf += $row->total; 
                                                @endphp
                                                <tr>
                                                    <td style='text-align:left;vertical-align: middle' class='text-uppercase'>{{ $row->categoria }}</td>
                                                    <td style='text-align:center;vertical-align: middle'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('{{ $categoria }}','{{ $filtro }}','objeto_contratac','{{ $row->categoria }}','{{ $anio }}')"><i class='fa fa-eye'></i></a></td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ $row->n_proce }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->total,0,'.',',') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr  style="background-color:#3c8dbc9c">
                                                <th style='text-align:center' colspan='2'>GOBIERNO REGIONAL DE LIMA</th>
                                                <th style='text-align:center'>{{ $total_nprocesos }}</th>
                                                <th style='text-align:center'>{{ number_format($total_valorrf,0,'.',',') }}</th>
                                            </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(isset($consulta_estado))
                    @php
                        $total_nprocesos = 0;
                        $total_valorrf = 0;
                    @endphp
                    <div class="tab-pane" id="pd_estado">
                        <div class="col-md-12" style="margin-top: 15px;">
                            <div class="row">
                                <div><img src="contrataciones/contrataciones_estado.png" class="img-fluid" alt="Responsive image"></div>
                                <div class="table table-bordered table-responsive">
                                    <table class="table table-bordered " id="t_estado" width="100%" class="form-control">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center" width="30%" >ESTADO</th>
                                                <th style="text-align:center" >DETALLE</th>
                                                <th style="text-align:center" >N° PROCEDIMIENTOS DE SELECCIÓN</th>
                                                <th style="text-align:center" > S/. TOTAL DE VALOR REFERENCIAL</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach($consulta_estado as $row)
                                                @php 
                                                    $total_nprocesos += $row->n_proce;
                                                    $total_valorrf += $row->total; 
                                                @endphp
                                                <tr>
                                                    @php
                                                        switch ($row->categoria) {
                                                            case "Contratado":
                                                            case "Consentido":
                                                            case "Convocado":
                                                            case "Adjudicado":
                                                    @endphp
                                                            <td style='text-align:left;vertical-align: middle' class='text-uppercase'><span class='badge bg-green text-green'>0</span>  {{ $row->categoria }}</td>
                                                    @php
                                                            break;
                                                            case "Pendiente de Registro Efecto":
                                                            case "Apelado":
                                                            case "Retrotraído por resolución":
                                                    @endphp
                                                            <td style='text-align:left;vertical-align: middle' class='text-uppercase'><span class='badge bg-yellow text-yellow'>1</span>  {{ $row->categoria }}</td>
                                                    @php
                                                            break;
                                                            case "Desierto":
                                                            case "Nulo":
                                                            case "No Subscripcion del Contrato por Decision de la Entidad":
                                                            case "Cancelado":
                                                    @endphp
                                                            <td style='text-align:left;vertical-align: middle' class='text-uppercase'><span class='badge bg-red text-red'>2</span>  {{ $row->categoria }}</td>
                                                    @php            
                                                                break;
                                                            default:
                                                    @endphp
                                                            <td style='text-align:left;vertical-align: middle' class='text-uppercase'>{{ $row->categoria }}</td>
                                                    @php  
                                                        }
                                                    @endphp
                                                    <td style='text-align:center;vertical-align: middle'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('{{ $categoria }}','{{ $filtro }}','contratacionesps.estado','{{ $row->categoria }}','{{ $anio }}')"><i class='fa fa-eye'></i></a></td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ $row->n_proce }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->total,0,'.',',') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr  style="background-color:#3c8dbc9c">
                                                <th style='text-align:center' colspan='2'>GOBIERNO REGIONAL DE LIMA</th>
                                                <th style='text-align:center'>{{ $total_nprocesos }}</th>
                                                <th style='text-align:center'>{{ number_format($total_valorrf,0,'.',',') }}</th>
                                            </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(isset($consulta_proyecto))
                    @php
                        $total_nprocesos = 0;
                        $total_valorrf = 0;
                        $pim_dia_2020 = 0;
                        $pim_dia_2019 = 0;
                        $dev_dia_2020 = 0;
                        $dev_dia_2019 = 0;
                    @endphp
                    <div class="tab-pane" id="pd_proyecto">
                        <div class="col-md-12" style="margin-top: 15px;">
                            <div class="row">
                                <div class="table table-bordered table-responsive">
                                    <table class="table table-bordered " id="t_proyecto" cellspacing="0" class="form-control">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;vertical-align:middle" width="40%">PROYECTOS</th>
                                                <th style="text-align:center;vertical-align:middle" >DETALLE</th>
                                                <th style="text-align:center;vertical-align:middle" >N° PROCEDIMIENTOS DE SELECCIÓN</th>
                                                <th style="text-align:center;vertical-align:middle" > S/. TOTAL DE VALOR REFERENCIAL</th>
                                                <th style="text-align:center;vertical-align:middle" > S/. PIM {{ date("Y") }}</th>
                                                <th style="text-align:center;vertical-align:middle" > S/. PIM {{ date("Y") -1 }}</th>
                                                <th style="text-align:center;vertical-align:middle" > S/. DEVENGADO {{ date("Y") }}</th>
                                                <th style="text-align:center;vertical-align:middle" > S/. DEVENGADO {{ date("Y") -1 }}</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach($consulta_proyecto as $row)
                                                @php 
                                                    $total_nprocesos += $row->n_proce;
                                                    $total_valorrf += $row->total; 
                                                    $pim_dia_2020 += $row->pim_dia_2020;
                                                    $pim_dia_2019 += $row->pim_dia_2019;
                                                    $dev_dia_2020 += $row->dev_dia_2020;
                                                    $dev_dia_2019 += $row->dev_dia_2019;
                                                @endphp
                                                <tr>
                                                    <td style='text-align:left;vertical-align: middle' class='text-uppercase' width='40%'>{{ $row->categoria }}</td>
                                                    <td style='text-align:center;vertical-align: middle'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('{{ $categoria }}','{{ $filtro }}','cod_unico','{{ trim(explode(":",$row->categoria)[0]) }}','{{ $anio }}')"><i class='fa fa-eye'></i></a></td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ $row->n_proce }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->total,0,'.',',') }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->pim_dia_2020,0,'.',',') }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->pim_dia_2019,0,'.',',') }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->dev_dia_2020,0,'.',',') }}</td>
                                                    <td style='text-align:center;vertical-align: middle'>{{ number_format($row->dev_dia_2019,0,'.',',') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr  style="background-color:#3c8dbc9c">
                                                <th style='text-align:center' colspan='2'>GOBIERNO REGIONAL DE LIMA</th>
                                                <th style='text-align:center'>{{ $total_nprocesos }}</th>
                                                <th style='text-align:center'>{{ number_format($total_valorrf,0,'.',',') }}</th>
                                                <th style='text-align:center'>{{ number_format($pim_dia_2020,0,'.',',') }}</th>
                                                <th style='text-align:center'>{{ number_format($pim_dia_2019,0,'.',',') }}</th>
                                                <th style='text-align:center'>{{ number_format($dev_dia_2020,0,'.',',') }}</th>
                                                <th style='text-align:center'>{{ number_format($dev_dia_2019,0,'.',',') }}</th>
                                            </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Inicio Lista de Contrataciones --}}
                @php
                    $total_nprocesos = 0;
                    $total_valorrf = 0;
                @endphp
                <div class="tab-pane" id="pd_contrataciones">
                    <div class="col-md-12" >
                        <div class="row">
                            <div class="table table-bordered table-responsive">
                                <table class="table table-bordered " id="t_contrataciones" cellspacing="0" class="form-control">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center" >CUI</th>
                                            <th style="text-align:center" width="20%" >DESCRIPCIÓN DE PROCESO</th>
                                            <th style="text-align:center" width="20%" >DESCRIPCIÓN DE ITEM</th>
                                            <th style="text-align:center" >TIPO CONTRATACIÓN</th>
                                            <th style="text-align:center" >FECHA DE CONVOCATORIA</th>
                                            <th style="text-align:center" >ESTADO</th>
                                            <th style="text-align:center" > S/. VALOR REFERENCIAL</th>
                                            <th style="text-align:center" >TIPO DE PROCESO</th>
                                            <th style="text-align:center" >NOMENCLATURA</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach($consulta_contrataciones as $row)
                                            @php 
                                                $total_nprocesos += 1;
                                                $total_valorrf += $row->valor_refer; 
                                            @endphp
                                            <tr>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->cod_unico }}</td>
                                                <td style='text-align:center;vertical-align: middle' width='20%'>{{ $row->des_proceso }}</td>
                                                <td style='text-align:center;vertical-align: middle' width='20%'>{{ $row->des_item }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->objeto_contratac }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->fec_convocatoria }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->estado }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ number_format($row->valor_refer,0,'.',',') }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->tipo_proceso }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->nomenclatura }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr  style="background-color:#3c8dbc9c">
                                            <th style='text-align:left' colspan='6'>GOBIERNO REGIONAL DE LIMA -- TOTAL DE CONTRATACIONES = {{ $total_nprocesos }}</th>
                                            <th style='text-align:center'>{{ number_format($total_valorrf,0,'.',',') }}</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Fin Lista de Contrataciones --}}
            </div>
        </div>
    </div>
</div>

<div class="pie">
    <script type="text/javascript">
        $(function(){

            @if($categoria == "EJECUTORA")
                $("#p_tipo").addClass("active");
                $("#pd_tipo").addClass("active");
            @else
                $("#p_ejecutora").addClass("active");
                $("#pd_ejecutora").addClass("active");
            @endif

            tabla=function(id,orden,panel,titulo,columnas){
                var oTable = $(id).DataTable({
                    processing: true,
                    dom: 'B<"clear">lfrtip',
                    buttons: {
                        orientation: 'landscape',
                        color:'#008d4c',
                        buttons: [ {
                            extend: 'excelHtml5',
                            text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                            titleAttr: 'Excel',
                            autoFilter: false,
                            sheetName: panel,
                            title: titulo,
                            exportOptions: {
                                columns: columnas
                            },
                        }]
                    },
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    responsive:true,
                    scrollY:        '350px',
                    scrollCollapse: true,
                    paging:         false,
                    order: orden,
                    language:
                    {
                            "sLengthMenu":     "Mostrar _MENU_",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla",
                            "sInfo":           "_START_ al _END_ de _TOTAL_ Registros",
                            "sInfoEmpty":      "Vacio",
                            "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "processing": "Cargando...",
                            "oPaginate":
                            {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     ">",
                                "sPrevious": "<"
                            },
                            "oAria":
                            {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                    }
                });
                setTimeout(function () {
                    $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
                },200);
            }

            actualizar = function(){
                setTimeout(function () {
                    $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
                },0);
            }

            tabla("#t_ejecutora",'',"EJECUTORA","{{ $filtro }}-EJECUTORA",[0,1,3]);
            tabla("#t_tipo",'',"TIPO","{{ $filtro }}-TIPO",[0,1,3]);
            tabla("#t_estado",'',"ESTADO","{{ $filtro }}-ESTADO",[0,2,3]);
            tabla("#t_proyecto",'',"PROYECTO","{{ $filtro }}-PROYECTO",[0,1,2,3,4,5,6,7]);
            tabla("#t_contrataciones",'',"CONTRATACIONES","{{ $filtro }}".split(':')[0] + " - CONTRATACIONES",[0,1,2,3,4,5,6,7]);

            loadModalPry = function(f_categoria,f_filtro,categoria,filtro,anio) {
                modaltype='modal_wide';
                $modal = $('#' + modaltype);
                    $.ajax({
                        url: '{{ asset("/contratacionesps/showpry/") }}',
                        type: 'POST',
                        data:{f_categoria:f_categoria,f_filtro:f_filtro,categoria:categoria,filtro:filtro,anio:anio},
                        beforeSend: function () {
                            $("#cargando_modal").show();
                        },
                        success: function (response) {
                            $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                            $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                            $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                            $('#' + modaltype).modal('show', {backdrop: 'true'});
                        },
                        complete: function(response) {
                            $("#cargando_modal").hide();
                        },
                    });
            }
        });
    </script>
</div>

