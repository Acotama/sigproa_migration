<span class="cabecera">
    <h4 class="text-center"><b>FUENTE FINANCIAMIENTO</b></h4>
</span>

<div id="container" >
    <div class="modal-body">
        <div class="col-md-12" style="margin-top: 15px;">
          <div class="row">
              <table class="table table-bordered " id="fuente_financiamiento_pry" width="100%" cellspacing="0" class="form-control">
                <thead>
                  <tr>
                    <th>N° PY</th>
                    <th>FUENTE FINANCIAMIENTO</th>
                    <th>PIM {{$anio}}</th>
                    <th>CERTIF {{$anio}}</th>
                    <th>DEVENGADO {{$anio}}</th>
                    <th>AVANCE {{$anio}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($gob_reg_fuente_financiamiento as $gob_reg)
                      <tr>
                        <td>{{ $gob_reg->cant_proyectos }}</td>
                        <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                        <td style='text-align:center'>{{ number_format($gob_reg->pim_dia) }}</td>
                        <td style='text-align:center'>{{ number_format($gob_reg->certificacion_dia) }}</td>
                        <td style='text-align:center'>{{ number_format($gob_reg->dev_dia) }}</td>
                        @if($gob_reg->pim_dia==0)
                          <td style='text-align:center'>0%</td>
                        @else
                          <td style='text-align:center'>{{ round(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2) }}%</td>
                        @endif
                      </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr  style="background-color:#3c8dbc9c">
                      <th>{{ $Headers->cant_proyectos }}</th>
                      <th style='text-align:left'>{{ $filtro }}</th>
                      <th style='text-align:center'>{{ number_format($Headers->pim_dia) }}</th>
                      <th style='text-align:center'>{{ number_format($Headers->certificacion_dia) }}</th>
                      <th style='text-align:center'>{{ number_format($Headers->dev_dia) }}</th>
                      @if($Headers->pim_dia==0)
                        <th style='text-align:center'>0%</th>
                      @else
                        <th style='text-align:center'>{{ round(($Headers->dev_dia/$Headers->pim_dia)*100,2) }}%</th>
                      @endif
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
                      sheetName: "FUENTE FINANCIAMIENTO",
                      title: titulo,
                      exportOptions: {
                        columns: [0,1,2,3,4,5]
                      },
                  }]
              },
              bSort: true,
              bInfo: true,
              bAutoWidth: true,
              responsive:true,
              scrollY:'350px',
              scrollCollapse: true,
              paging:         false,
              order: [[ 2, "desc" ]],
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

      tabla("#fuente_financiamiento_pry","{{$nombre}}-META");

    });
  </script>
</div>
