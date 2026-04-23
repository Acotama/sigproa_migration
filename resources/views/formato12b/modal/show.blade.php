<span class="cabecera">
    <h3 class="text-center"><b>{{ $titulo }}</b></h3>

</span>
<div id="container" >
    <div class="modal-body">
    <div class="row">
    <div class="col-md-12 connectedSortable ui-sortable">
        <div class="nav-tabs-custom" style="cursor: default;">
            <div class="tab-content">
                <div class="chart tab-pane active" style="position: relative;">
                    <div class="table  table-responsive">
                        <table id="proyectos_f12b" class="table table-striped table-bordered table-hover">
                            <thead style="background-color: #88b9d6">
                            <tr>
                                <th style="vertical-align: middle;" class="text-center">COD. UNIF</th>
                                <th style="vertical-align: middle;width:400px" class="text-center">NOMBRE PROYECTO</th>
                                <th style="vertical-align: middle;width:200px" class="text-center">UEI</th>
                                <th style="vertical-align: middle;" class="text-center">PIM</th>
                                <th style="vertical-align: middle;" class="text-center">DEVENGADO</th>
                                <th style="vertical-align: middle;" class="text-center">AVANCE ACUMULADO</th>
                                <th style="vertical-align: middle;" class="text-center">AVANCE FISICO</th>
                                @if($filtro == "dif_a_fin_a_afis" or $filtro == "no_dif_a_fin_a_afis" )
                                    <th style="vertical-align: middle;" class="text-center">DIF. AVANC. FINANCIERO ACU. Y FISICO</th>
                                @endif
                                <th style="vertical-align: middle;" class="text-center">FECHA DE ACTUALIZACIÓN F12B</th>
                                <th style="vertical-align: middle;" class="text-center">FECHA DE ACTUALIZACIÓN SITUACION F12B</th>
                                <th style="vertical-align: middle;" class="text-center">FECHA DE ACTUALIZACIÓN AVANC. EJECUCION F12B</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->cod_unif }}</td>
                                    <td>{{ $row->nom_proyec }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->ger_direc }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ number_format($row->pim_dia,2) }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ number_format($row->dev_dia,2) }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ number_format($row->a_financ_a,2) }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ number_format($row->avance_fisico,2) }}</td>
                                    @if($filtro == "dif_a_fin_a_afis" or $filtro == "no_dif_a_fin_a_afis" )
                                        <td style="vertical-align: middle;" class="text-center">{{ number_format($row->dif_a_fin_a_afis_pro,2) }}</td>
                                    @endif
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->fecha_actual }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->fecha_actual_situacion }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->fec_declara_estim }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <span style="font-weight: bold;font-size: 12px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                          Fuente: SIGPROA-PROYECTOS al {{$fecha->fecha}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
    </div>
</div>
<div class="pie">
    <script type="text/javascript">
        $(function(){
            tabla=function(titulo,col){
                var oTable = $("#proyectos_f12b").DataTable({
                    dom: 'B<"clear">lfrtip',
                    buttons: {
                        orientation: 'landscape',
                        color:'#008d4c',
                        buttons: [ {
                            extend: 'excelHtml5',
                            text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                            titleAttr: 'Excel',
                            autoFilter: false,
                            sheetName: titulo,
                            title: titulo,
                            exportOptions: {
                                columns: col
                            },
                        }]
                    },
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    responsive:true,
                    scrollY:        '350px',
                    scrollX:        true,
                    scrollCollapse: true,
                    paging:         false,
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
                oTable.buttons().container()
                .appendTo( $('.col-sm-6:eq(0)', oTable.table().container() ) );
                setTimeout(function () {
                    $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
                },200);
            }
            $filtro = '{{$filtro}}';
            if($filtro == "dif_a_fin_a_afis" || $filtro == "no_dif_a_fin_a_afis"){
                tabla('{{$titulo}}',[0,1,2,3,4,5,6,7,8,9,10]);
            }else{
                tabla('{{$titulo}}',[0,1,2,3,4,5,6,7,8,9]);
            }
        });
    </script>
</div>