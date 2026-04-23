<span class="cabecera">
    @if($ambito=='etapa')
        <h4 class="text-center"><b>PROYECTOS (ETAPA: {{ $ger_direc}})</b></h4>
    @elseif($ambito=='nom_prov')
        <h4 class="text-center"><b>PROYECTOS (PROVINCIA: {{ $ger_direc}})</b></h4>
    @elseif($ambito=='sector')
        <h4 class="text-center"><b>PROYECTOS (SECTOR: {{ $ger_direc}})</b></h4>
    @elseif($ambito=='fuente_financiamiento')
        <h4 class="text-center"><b>PROYECTOS (FUENTE FINANCIAMIENTO: {{ $ger_direc}})</b></h4>
    @elseif($ambito=='ger_direc')
        <h4 class="text-center"><b>PROYECTOS ({{ $ger_direc}})</b></h4>
    @endif

</span>

<div id="container" >
    <div class="modal-body">
        <div id="cargando_modal1" class="loading" style="display: none;"></div>
        <div class="col-md-12" style="margin-top: 15px;">
          <div class="row">
              <table class="table table-bordered " id="todosproyecto" width="100%" cellspacing="0" class="form-control">
                <thead>
                  <tr>
                    <th>COD. UNIF</th>
                    <th>PROYECTOS</th>
                    <th>VER</th>
                    <th>ETAPA</th>
                    <th>MONTO INV. ACT.</th>
                    <th>DEVEN. ACUM. ACT.</th>
                    <th>AVANCE. ACUM. ACT.</th>
                    <th>PIM {{$anio}}</th>
                    <th>CERTIF {{$anio}}</th>
                    <th class="hide">COMP. ANUAL {{$anio}}</th>
                    <th class="hide">COMP. MENSUAL {{$anio}}</th>
                    <th>DEVENGADO {{$anio}}</th>
                    <th class="hide">GIRADO {{$anio}}</th>
                    <th>AVANCE {{$anio}}</th>
                    <th>AVANCE FISICO</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($gob_reg_proyecto as $gob_reg)
                    <tr>
                      <!-- if($gob_reg->cod_snip == 'SIN COD.')
                        <td style='text-align:center'>{{ $gob_reg->cant_proyectos }}</td>
                      else -->
                      <td style='text-align:center'><a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ir a SSI" target="_blank" href="http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo={{ $gob_reg->cant_proyectos }}&tipo=2" class='dropdown-toggle'>{{ $gob_reg->cant_proyectos }}</a></td>
                      <!-- endif -->
                      <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                      <td style='text-align:center'>
                        <a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ir a Proyectos" class='dropdown-toggle' onclick="loadpry({{ $gob_reg->id }},'{{ $gob_reg->etapa }}')"><i class='fa fa-eye'></i></a>
                        <a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ver Metas" class='dropdown-toggle' onclick="loadModalOMeta({{ $gob_reg->cant_proyectos }},'{{ $gob_reg->ger_direc }}')"><i class='fa fa-legal'></i></a>
                        <a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ver Fuente" class='dropdown-toggle' onclick="loadModalFuente({{ $gob_reg->cant_proyectos }},'{{ $gob_reg->ger_direc }}')"><i class='fa fa-book'></i></a>
                      </td>
                      <td style='text-align:center'>{{ $gob_reg->etapa }}</td>
                      <td style='text-align:center'>{{ number_format($gob_reg->m_pip,0,'.',',') }}</td>
                      <td style='text-align:center'>{{ number_format($gob_reg->m_deveng_a,0,'.',',') }}</td>
                      @if($gob_reg->m_pip==0)
                        <td style='text-align:center'>0.00%</td>
                      @else
                        <td style='text-align:center'>{{ number_format(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2,'.',',') }}%</td>
                      @endif
                      <td style='text-align:center'>{{ number_format($gob_reg->pim_dia,0,'.',',') }}</td>
                      <td style='text-align:center'>{{ number_format($gob_reg->certificacion_dia,0,'.',',') }}</td>
                      <td class="hide" style='text-align:center'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                      <td class="hide" style='text-align:center'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                      <td style='text-align:center'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                      <td class="hide" style='text-align:center'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                      @if($gob_reg->pim_dia==0)
                        <td style='text-align:center'>0%</td>
                      @else
                        <td style='text-align:center'>{{ number_format(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2,'.',',') }}%</td>
                      @endif
                      <td style='text-align:center'>{{ number_format($gob_reg->a_fisico,2,'.',',') }}%</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr  style="background-color:#3c8dbc9c">
                      <th style='text-align:center'>TOTAL {{ $Headers->cant_proyectos }}</th>
                      <th colspan="3" style='text-align:left'>{{ $filtro }}</th>
                      <th style='text-align:center'>{{ number_format($Headers->m_pip,0,'.',',') }}</th>
                      <th style='text-align:center'>{{ number_format($Headers->m_deveng_a,0,'.',',') }}</th>
                      @if($Headers->m_pip==0)
                        <th style='text-align:center'>0.00%</th>
                      @else
                        <th style='text-align:center'>{{ round(($Headers->m_deveng_a/$Headers->m_pip)*100,2) }}%</th>
                      @endif
                      <th style='text-align:center'>{{ number_format($Headers->pim_dia,0,'.',',') }}</th>
                      <th style='text-align:center'>{{ number_format($Headers->certificacion_dia,0,'.',',') }}</th>
                      <th class="hide" style='text-align:center'>{{ number_format($Headers->comp_anual_dia,0,'.',',') }}</th>
                      <th class="hide" style='text-align:center'>{{ number_format($Headers->ate_comp_anual_dia,0,'.',',') }}</th>
                      <th style='text-align:center'>{{ number_format($Headers->dev_dia,0,'.',',') }}</th>
                      <th class="hide" style='text-align:center'>{{ number_format($Headers->girado_dia,0,'.',',') }}</th>
                      @if($Headers->pim_dia==0)
                        <th style='text-align:center'>0.00%</th>
                      @else
                        <th style='text-align:center'>{{ number_format(($Headers->dev_dia/$Headers->pim_dia)*100,2,'.',',') }}%</th>
                      @endif
                      @if($Headers->a_fisico==0)
                        <th style='text-align:center'>0.00%</th>
                      @else
                        <th style='text-align:center'>{{ number_format(($Headers->a_fisico/$Headers->cant_proyectos),2,'.',',') }}%</th>
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
                      sheetName: "PROYECTOS",
                      title: titulo,
                      exportOptions: {
                        columns: [0,1,3,4,5,6,7,8,9,10,11,12,13,14]
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
              order: [[ 8, "desc" ]],
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
      tabla("#todosproyecto","{{ $filtro }}-PROYECTOS");

    });
  </script>
</div>
