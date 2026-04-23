<span class="cabecera">
    <h4 class="text-center"><b>PROYECTO: {{ $nombre}} - METAS</b></h4>
</span>

<div id="container" >
    <div class="modal-body">
        <div class="col-md-12" style="margin-top: 15px;">
          <div class="row">
              <table class="table table-bordered " id="todosmeta" width="100%" cellspacing="0" class="form-control">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>META O COMPONENTE</th>
                    <th>TIPO</th>
                    <th>AÑO DE EJECUCIÓN</th>
                    <th>MONTO DE EJECUCIÓN</th>
                    <th>MONTO DE SUPERVISION</th>
                    <th>ETAPA</th>
                    <th>SUB-ETAPA</th>
                    <th>AVANCE FISICO</th>
                    <th>ACTUALIZADO</th>
                    <th>ESTADO SITUACIONAL</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($gob_reg_meta as $gob_reg)
                    <tr>
                      <td>{{ $gob_reg->nro_meta }}</td>
                      <td>{{ $gob_reg->nom_meta}}</td>
                      @if($gob_reg->tipo=="E")
                        <td>EJECUCIÓN INTEGRAL</td>
                      @elseif($gob_reg->tipo=="M")
                        <td>META</td>
                      @elseif($gob_reg->tipo=="S")
                        <td>OTROS</td>
                      @endif
                      <td style='text-align:center'>{{ $gob_reg->anio_ejec }}</td>
                      @if($gob_reg->m_ejecucion==null)
                        <td style='text-align:center'>0.00</td>
                      @else
                        <td style='text-align:center'>{{ $gob_reg->m_ejecucion }}</td>
                      @endif
                      @if($gob_reg->m_supervision==null)
                        <td style='text-align:center'>0.00</td>
                      @else
                        <td style='text-align:center'>{{ $gob_reg->m_supervision }}</td>
                      @endif
                      <td style='text-align:center'>{{ $gob_reg->etapa }}</td>
                      <td style='text-align:center'>{{ $gob_reg->sub_etapa }}</td>
                      <td style='text-align:center'>{{ $gob_reg->a_fisico }}</td>
                      <td style='text-align:center'>{{ $gob_reg->fecha_act }}</td>
                      <td style='text-align:center'>{{ $gob_reg->est_situ }}</td>
                    </tr>
                  @endforeach
                </tbody>
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
                      sheetName: "META",
                      title: titulo,
                      exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
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

      tabla("#todosmeta","{{$nombre}}-META");

    });
  </script>
</div>
