@if ($data->count())
<table border=1 class="jtable">
    <thead>
        <tr>
            <!--th>Provincia</th-->
            <!--th>Distrito</th-->
            <th>Editar</th>
            <th>UNIF</th>
            <th>SNIP</th>
            <th>Nombre del Proyecto</th>
            <th>Monto PIP</th>
            <th>U. Ejecutora</th>
            <!--th>Sector</th-->
            <th>Tipo Proyecto</th>
            <th>% Avanc. Financ</th>
            <th>% Avanc. Fisico</th>
            <th>Etapa</th>
            <th>Etapa actualizada al</th>
            <th>Año de Proyecto</th>
            <?php if ( Auth::user()->can('sayhuite-state')) {?>
            <th>Sayhuite (Priorizado)</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <?php
        $SIGLAS = '';
        switch ($item['ger_direc']) {
          case 'SUB GERENCIA REGIONAL LIMA SUR':
             $SIGLAS = 'SGRLS';
            break;
          case 'DIRECCION REGIONAL DE AGRICULTURA':
             $SIGLAS = 'DRA';
            break;
          case 'GERENCIA REGIONAL DE RECURSOS NATURALES':
             $SIGLAS = 'GRRN';
            break;
          case 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO':
             $SIGLAS = 'GRDE';
            break;
          case 'GERENCIA REGIONAL DE DESARROLLO SOCIAL':
             $SIGLAS = 'GRDS';
            break;
          case 'GERENCIA REGIONAL DE INFRAESTRUCTURA':
             $SIGLAS = 'GRI';
            break;
          case 'DIRECCION REGIONAL DE SALUD':
             $SIGLAS = 'DRS';
            break;
          case 'PROGRAMA DE DESARROLLO PRODUCTIVO AGRARIO RURAL - AGRORURAL':
             $SIGLAS = 'AGRORURAL';
            break;
          default:

            break;
        }

        $tp = '';
        switch ($item->tipo_pry) {
          case 'PIP':
            $tp = 'INICIATIVA';
            break;
          case 'PIC':
            $tp = 'PIC';
        }

        $arrColors = ['TDR' => 'tdr',
                      'PERFIL' => 'perfil',
                      'EXPEDIENTE TÉCNICO' => 'exptec',
                      'EN EJECUCIÓN' => 'ejecucion',
                      'CULMINADO' => 'culminado',
                      'EN LIQUIDACIÓN' => 'liquidacion',
                      'EN TRANSFERENCIA' => 'transferencia']
        ?>
        <tr>
            <!--td>{{-- $item->nom_prov --}}</td-->
            <!--td>{{-- $item->nom_dist --}}</td-->
            <td style="text-align:center;">
                <a value="{{ $item->id }}" class="btn btn-primary btn-xs btnEditar" href="{{URL::to('/piptotalpriori/edit/'.$item->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
                <!--button value="{{-- $item->id --}}" class="btn btn-danger btn-xs btnEliminar"><span class="glyphicon glyphicon-trash"></span></button-->
            </td>
            <td>{{ $item->cod_unif }}</td>
            <td>{{ $item->cod_snip }}</td>
            <td>{{ $item->nom_proyec }}</td>
            <td>{{ $item->m_pip }}</td>
            <td>{{ $SIGLAS }}</td>
            <!--td>{{ $item->sector }}</td-->
            <td>{{ $tp }}</td>
            <th>{{ $item->a_financ }}</th>
            <th>{{ $item->a_fisico }}</th>
            <td class="{{ isset($arrColors[$item->etapa]) ? $arrColors[$item->etapa] : '' }}"> <b>{{ $item->etapa }} </b></td>
            <th>{{ $item->f_etapsub }}</th>
            <th>{{ $item->anio_ini_pry }}</th>
            <?php if ( Auth::user()->can('sayhuite-state')) {?>
            <th style="text-align:center;"><label>{{ Form::checkbox($item->id,'' , $item->estado_pic =='PRIORIZADO' ? true : false, array('class' => 'form-input stateSayhuite')) }}</label></th>
            <?php } ?>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    <center>{{ $data->links() }}</center>
</div>
<script>



    $('input[type=checkbox]').change(function() {

        that = this;
        if(this.checked){
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


    });

</script>
@else
<div id="message" class="alert alert-danger">NO SE ENCONTRARON DATOS.</div>
@endif
