<?php ini_set('max_execution_time', 1000); //300 seconds = 5 minutes ?>
<body>
  <meta charset="UTF-8">
  <style>
    table {
      border-collapse: collapse;
    }
    table, th, td {
      border: 0.5pt solid #000;
      font-size: 10pt;
      vertical-align: middle;
    }

    .header {
      border-top: 1pt solid #000;
      border-bottom: 1pt solid #000;
      font-size: 11pt;
      background-color: #0070C0;
      color: white;
      font-weight: bold;
      text-align: center;
    }

    .center {
      text-align: center;
      vertical-align: middle;
    }

    .left {
      text-align: left;
      vertical-align: middle;
    }

    .right {
      text-align: right;
      vertical-align: middle;
    }

  </style>

<table>
      <tr></tr>
      <tr></tr>

      <tr>
        <td class="header" rowspan="2" width="80">COD. UNIFICADO</td>
        <td style="border-right: 1pt solid #000;" class="header" rowspan="2" width="80">COD. SNIP</td>
        <td class="header" rowspan="2" width="400">NOMBRE PROYECTO</td>
        <td class="header" rowspan="2" width="120">GERENCIA / DIRECCIÓN</td>
        <td class="header" rowspan="2" width="80">TIPO</td>
        <td class="header" rowspan="2" width="80">AÑO FINANCIERO</td>
        <!--<td class="header" colspan="3">PRE-INVERSIÓN (LLENAREN CASO NO )</td>-->
        <td class="header" colspan="13">ESTADO DE OBRAS/ACTIVIDADES DEL PROYECTO</td>
        <td class="header" colspan="2">INFORMACIÓN FOTOGRÁFICA</td>
      </tr>

      <tr id="header">
        <td class="header" width="150">NOMBRE</td>
        <td class="header" width="120">MODALIDAD EJECUCIÓN</td>
        <td class="header" width="100">ETAPA</td>
        <td class="header" width="120">SUB ETAPA</td>
        <td class="header" width="500">DESCRIPCIÓN</td>
        <td class="header" width="100">AV. FÍSICO DE OBRA/ACTIVIDAD</td>
        <td class="header" width="100">F.INICIO PROGRAMADA DE OBRA/ACTIVIDAD</td>
        <td class="header" width="100">F.FIN PROGRAMADA DE OBRA/ACTIVIDAD</td>
        <td class="header" width="100">F.INICIO REAL DE OBRA/ACTIVIDAD</td>
        <td class="header" width="100">F.FIN REAL DE OBRA/ACTIVIDAD</td>
        <td class="header" width="100">T. EJECUCIÓN (Días) DE OBRA/ACTIVIDAD</td>
        <td class="header" width="100">F.INAUGURACIÓN DE OBRA/ACTIVIDAD</td>
        <td class="header" width="100">ÚLTIMA ACTUALIZACIÓN EL</td>

        <td class="header" width="80">DURANTE</td>
        <td class="header" width="80">DESPUES</td>
      </tr>

      @foreach($data as $row)
      <?php

            $rowspanNum = count( $row->obras );
            $noObras = false;
            if ( $rowspanNum == 0 ){
                $noObras = true;
                $rowspanNum = 1;
            }
      ?>


      <tr id="Rows">
          <td style="border-top: 1pt solid #000;" class="center" rowspan="<?php echo $rowspanNum ?>">{{$row->cod_unif}}</td>
          <td style="border-top: 1pt solid #000;border-right: 1pt solid #000;" class="center" rowspan="<?php echo $rowspanNum ?>">{{$row->cod_snip}}</td>
          <td style="border-top: 1pt solid #000;" class="left" rowspan="<?php echo $rowspanNum ?>">{{ $row->nom_proyec }}</td>
          <td style="border-top: 1pt solid #000;" class="center" rowspan="<?php echo $rowspanNum ?>">{{ $row->ger_direc }}</td>
          <td style="border-top: 1pt solid #000;" class="center" rowspan="<?php echo $rowspanNum ?>">{{ $row->tipo_pry }}</td>
          <td style="border-top: 1pt solid #000;" class="center" rowspan="<?php echo $rowspanNum ?>">{{ $row->ult_anio_ejec_pry_financ }}</td>
          <?php
          if($noObras){ ?>
          <td style="border-top: 1pt solid #000;" class="center"> - </td>
          <td style="border-top: 1pt solid #000;" class="center"> - </td>
          <!-- <td style="border-top: 1pt solid #000;" class="center"> - </td> -->
          <td style="border-top: 1pt solid #000;" class="center">{{ $row->etapa }}</td>
          <td style="border-top: 1pt solid #000;" class="center">{{ $row->sub_etapa }}</td>
          <td style="border-top: 1pt solid #000;" class="left">{{ $row->est_situ }}</td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <td style="border-top: 1pt solid #000;" class=""></td>
          <?php
          } else {
          ?>
          <td style="border-top: 1pt solid #000;" class="center"><?php echo trim($row->obras[$rowspanNum-1]->nom_meta) == '' ? 'OBRA/ACTIVIDAD' : strtoupper($row->obras[$rowspanNum-1]->nom_meta); ?></td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->mod_ejec }} </td>
          <!-- <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->anio_ejec }} </td> -->
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->etapa }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->sub_etapa }} </td>
          <td style="border-top: 1pt solid #000;" class="left"> {{ $row->obras[$rowspanNum-1]->est_situ }} </td>
          <td style="border-top: 1pt solid #000;" class="right"> {{ $row->obras[$rowspanNum-1]->a_fisico }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->f_inicio }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->f_termino }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->f_reinicio }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->f_termino_nueva }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->t_ejec_dias }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->f_inaug }} </td>
          <td style="border-top: 1pt solid #000;" class="center"> {{ $row->obras[$rowspanNum-1]->fecha_act }} </td>
          <?php
          }
          ?>
          @if ( $row->ffoto_durante )
          <td rowspan="<?php echo $rowspanNum ?>" style="border-top: 1pt solid #000;" class="center"> {{ $row->ffoto_durante }} </td>
          @else
          <td rowspan="<?php echo $rowspanNum ?>" style="border-top: 1pt solid #000;background-color:#999;color:black;" class="center"> SIN FOTO </td>
          @endif

          @if ( $row->ffoto_despues )
          <td rowspan="<?php echo $rowspanNum ?>" style="border-top: 1pt solid #000;" class="center"> {{ $row->ffoto_despues }} </td>
          @else
          <td rowspan="<?php echo $rowspanNum ?>" style="border-top: 1pt solid #000;background-color:#999;color:black;" class="center"> SIN FOTO </td>
          @endif

      </tr>
      <?php
      $rowspanNum--;
      for($x=$rowspanNum;$x>0;$x--){ ?>

      <tr id="Row5" class="body-row-2">

          <td class="center"><?php echo trim($row->obras[$rowspanNum-1]->nom_meta) == '' ? 'OBRA/ACTIVIDAD' : strtoupper($row->obras[$x-1]->nom_meta); ?></td>
          <td class="center">{{ $row->obras[$x-1]->mod_ejec }}</td>
          <!-- <td class="center">{{ $row->obras[$x-1]->anio_ejec }}</td> -->
          <td class="center">{{ $row->obras[$x-1]->etapa }}</td>
          <td class="center">{{ $row->obras[$x-1]->sub_etapa }}</td>
          <td class="left">{{ $row->obras[$x-1]->est_situ }}</td>
          <td class="right">{{ $row->obras[$x-1]->a_fisico }}</td>
          <td class="center">{{ $row->obras[$x-1]->f_inicio }}</td>
          <td class="center">{{ $row->obras[$x-1]->f_termino }}</td>
          <td class="center">{{ $row->obras[$x-1]->f_reinicio }}</td>
          <td class="center">{{ $row->obras[$x-1]->f_termino_nueva }} </td>
          <td class="center">{{ $row->obras[$x-1]->t_ejec_dias }} </td>
          <td class="center">{{ $row->obras[$x-1]->f_inaug }} </td>
          <td class="center">{{ $row->obras[$x-1]->fecha_act }} </td>
      </tr>

      <?php
      }
      ?>
@endforeach
</table>

</body>
