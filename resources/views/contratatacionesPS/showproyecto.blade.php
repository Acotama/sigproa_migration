<span class="cabecera">
    <h3 class="text-center"><b class="text-uppercase">{{ $f_categoria }} : {{ $f_filtro}}</b></h3>
    @if($categoria=='ger_direc')
        <h4 class="text-center"><b class="text-uppercase">CONTRATACIONES (EJECUTORA : {{ $filtro}})</b></h4>
    @elseif($categoria=='objeto_contratac')
        <h4 class="text-center"><b class="text-uppercase">CONTRATACIONES (TIPO : {{ $filtro}})</b></h4>
    @elseif($categoria=='contratacionesps.estado')
        <h4 class="text-center"><b class="text-uppercase">CONTRATACIONES (ESTADO : {{ $filtro}})</b></h4>
    @elseif($categoria=='cod_unico')
        <h4 class="text-center"><b class="text-uppercase">CONTRATACIONES (PROYECTO : {{ $filtro}})</b></h4>
    @endif
</span>

<div id="container" >
    <div class="modal-body">
        <div id="cargando_modal1" class="loading" style="display: none;"></div>
        <div class="col-md-12" style="margin-top: 15px;">
            <div class="row">
                @php
                    $total_nprocesos = 0;
                    $total_valorrf = 0;
                @endphp
                <table class="table table-bordered " id="td_contrataciones" width="100%" cellspacing="0" class="form-control">
                    <thead>
                        <tr>
                            <th style="text-align:center" >CUI</th>
                            <th style="text-align:center" >DESCRIPCIÓN DE PROCESO</th>
                            <th style="text-align:center" >DESCRIPCIÓN DE ITEM</th>
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
                                <td style='text-align:center;vertical-align: middle'>{{ $row->des_proceso }}</td>
                                <td style='text-align:center;vertical-align: middle'>{{ $row->des_item }}</td>
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

<div class="pie">
  <script type="text/javascript">
    $(function(){
      tabla=function(id,titulo){
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
                      sheetName: "PROYECTOS",
                      title: titulo,
                      exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8]
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
               $($.fn.dataTable.tables( true)).DataTable().columns.adjust().draw();
          },200);
      }

      tabla("#td_contrataciones","{{ $filtro }}-CONTRATACIONES");

    });
  </script>
</div>