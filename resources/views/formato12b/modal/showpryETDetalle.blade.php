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
                        <table id="proyectos_f12b_et" class="table table-striped table-bordered table-hover">
                            <thead style="background-color:#88b9d6">
                                <tr>
                                    <th style="vertical-align: middle;" class="text-center">COD. UNIF</th>
                                    <th style="vertical-align: middle;width:200px" class="text-center">ETAPA</th>
                                    <th style="vertical-align: middle;width:200px" class="text-center">HITO</th>
                                    <th style="vertical-align: middle;" class="text-center">FECHA PROGRAMADA</th>
                                    <th style="vertical-align: middle;" class="text-center">FECHA ACTUALIZADA</th>
                                    @if($filtro == 'nvo')
                                        <th style="vertical-align: middle;" class="text-center">ESTADO</th>
                                    @else
                                        <th style="vertical-align: middle;" class="text-center">FECHA FINAL</th>
                                    @endif
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->codigo_unico }}</td> 
                                    <td style="vertical-align: middle;">{{ $row->etapa }}</td>
                                    <td style="vertical-align: middle;">{{ $row->hito }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->fec_program }}</td>
                                    <td style="vertical-align: middle;" class="text-center">{{ $row->fec_actualizada }}</td>
                                    @if($filtro == 'nvo')
                                        <td style="vertical-align: middle;" class="text-center">{{ $row->estado_hito }}</td>
                                    @else
                                        <td style="vertical-align: middle;" class="text-center">{{ $row->fec_final }}</td>
                                    @endif
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
                var oTable = $("#proyectos_f12b_et").DataTable({
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
            tabla('{{$titulo}}',[0,1,2,3,4]);

        });
    </script>
</div>