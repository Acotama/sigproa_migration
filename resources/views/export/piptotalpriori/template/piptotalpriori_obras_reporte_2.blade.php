<?php ini_set('max_execution_time', 1000); //300 seconds = 5 minutes ?>

<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>

      .b { text-align:center ;vertical-align:middle;}
      .e { text-align:center }
      .f { text-align:right }
      .inlineStr { text-align:left }
      .n { text-align:right }
      .s { text-align:left }
      .style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#fff }
      .style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#fff }
      .style1 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:9pt; background-color:#fff }
      .style1 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:9pt; background-color:#fff }
      .style2 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Century Gothic'; font-size:12pt; background-color:#fff }
      .style2 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Century Gothic'; font-size:12pt; background-color:#fff }
      .style3 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style3 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style4 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style4 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style5 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#0070C0 }
      .style5 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#0070C0 }
      .style6 { vertical-align:middle; text-align: center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style6 { vertical-align:middle; text-align: center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style7 { vertical-align:bottom; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style7 { vertical-align:bottom; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style8 { vertical-align:middle;text-align: justify; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style8 { vertical-align:middle;text-align: justify; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style9 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style9 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style10 { vertical-align:bottom; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#fff }
      .style10 { vertical-align:bottom; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#fff }
      .style11 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:#FFFF00 }
      .style11 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:#FFFF00 }
      .style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style15 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style15 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style16 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style16 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style17 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style17 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style18 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style18 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style19 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:8pt; background-color:#0070C0 }
      .style19 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:8pt; background-color:#0070C0 }
      .style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:8pt; background-color:#0070C0 }
      .style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:8pt; background-color:#0070C0 }
      .style21 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style21 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style22 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style22 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style23 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style23 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:#0070C0 }
      .style24 { vertical-align:middle; text-align:justify; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style24 { vertical-align:middle; text-align:justify; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style25 { vertical-align:middle; text-align:justify; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style25 { vertical-align:middle; text-align:justify; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style26 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style26 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style27 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style27 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style28 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style28 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style29 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style29 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style30 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }
      .style30 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:#fff }

      .column0 { width:33px }
      .column1 { width:33px }
      .column2 { width:33px }
      .column3 { width:20px }
      .column4 { width:18px }
      .column5 { width:18px }
      .column6 { width:33px }
      .column7 { width:15px }
      .column8 { width:18px }
      .column9 { width:31px }

      .row5 {height: 30px}

    </style>
  </head>

          <tr class="row0">
            <td class="column0"></td>
            <td class="column1 style0 s"></td>
            <td class="column2"></td>
            <td class="column3"></td>
            <td class="column4 style2 s"></td>
            <td class="column5"></td>
            <td class="column6"></td>
            <td class="column7"></td>
            <!-- <td class="column8"></td> -->
            <td class="column9 style1 null"></td>
          </tr>
          <tr class="row1">
            <td class="column0"></td>
            <td class="column1"></td>
            <td class="column2"></td>
            <td class="column3"></td>
            <td class="column4"></td>
            <td class="column5"></td>
            <td class="column6"></td>
            <td class="column7"></td>
            <!-- <td class="column8"></td> -->
            <td class="column9 style1 null"></td>
          </tr>

        <?php
          $arrGer = [
            'DIRECCION REGIONAL DE AGRICULTURA',
            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
            'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES',
            'GERENCIA REGIONAL DE DESARROLLO SOCIAL',
            'DIRECCIÓN REGIONAL DE AGRICULTURA',
            'GERENCIA REGIONAL DE INFRAESTRUCTURA',
            'GERENCIA SUB REGIONAL LIMA SUR',
            'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE'
            ];
        ?>

        <tr class="row3">
      <td class="column0 style12 s style14" colspan="3" rowspan="2">NOMBRE PROYECTO</td>
      <td class="column3 style15 s style16" rowspan="2">COD. UNIFICADO</td>
      <td class="column3 style15 s style16" rowspan="2">COD. SNIP</td>
      <!--<td class="column4 style17 s style18" rowspan="2">ESTADO</td>-->
      <td class="column6 style21 s style23" colspan="10">ESTADO DE OBRAS</td>
      </tr>
      <tr class="row4">
          <td class="column0"></td>
          <td class="column1"></td>
          <td class="column2"></td>
          <td class="column3"></td>
          <td class="column3"></td>
          <!--<td class="column4"></td>-->
          <td class="column6 style3 s">NOMBRE</td>
          <td class="column7 style4 s">ESTADO</td>
          <td class="column7 style4 s">DESCRIPCIÓN</td>
          <td class="column8 style5 s">AV. FÍSICO</td>
          <td class="column7 style4 s">F.INICIO PROGRAMADA</td>
          <td class="column7 style4 s">F.FIN PROGRAMDA</td>
          <td class="column7 style4 s">F.INICIO REAL</td>
          <td class="column7 style4 s">F.FIN REAL</td>
          <td class="column7 style4 s">F.INAUGURACIÓN</td>
          <td class="column7 style4 s">ESTADO ACTUALIZADO AL</td>
      </tr>

@foreach($arrGer as $ger)

          <tr class="row2">
            <td class="column0 style11 s style11" colspan="15">{{$ger}}</td>
            <td class="column1"></td>
            <td class="column2"></td>
            <td class="column4"></td>
            <td class="column5"></td>
            <td class="column6"></td>
            <td class="column7"></td>
            <td class="column7"></td>
            <td class="column7"></td>
            <td class="column7"></td>
            <td class="column7"></td>
            <td class="column7"></td>
            <td class="column7"></td>
            <!-- <td class="column8"></td> -->
            <td class="column9"></td>
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

      @if ($row->ger_direc == $ger )
      <tr class="row5">
          <td class="column0 style24 null style25" colspan="3" rowspan="<?php echo $rowspanNum ?>">{{ $row->nom_proyec }}</td>
          <td class="column3 style26 null style28" rowspan="<?php echo $rowspanNum ?>">{{$row->cod_unif}}</td>
          <td class="column3 style26 null style28" rowspan="<?php echo $rowspanNum ?>">{{$row->cod_snip}}</td>
          <!--<td class="column4 style26 null style28" rowspan="<?php echo $rowspanNum ?>">{{$row->etapa_main}}</td>-->
          <?php
          if($noObras){ ?>
          <td class="column6 style8 s"> - </td>
          <td class="column7 style6 .b null"> - </td>
          <!-- <td class="column8 style6 .b null"> - </td> -->
          <?php
          } else {
          ?>
          <td class="column6 style8 s"><?php echo trim($row->obras[$rowspanNum-1]->nom_meta) == '' ? 'OBRA' : strtoupper($row->obras[$rowspanNum-1]->nom_meta); ?></td>
          <td class="column7 style6 .b null"> {{ $row->obras[$rowspanNum-1]->etapa_main }} </td>
          <td class="column7 style6 .b null"> {{ $row->obras[$rowspanNum-1]->est_situ }} </td>
          <td class="column8 style6 .b null"> {{ $row->obras[$rowspanNum-1]->a_fisico }} </td>
          <td class="column7 style6 .b null"> {{ $row->obras[$rowspanNum-1]->f_inicio }} </td>
          <td class="column7 style6 .b null"> {{ $row->obras[$rowspanNum-1]->f_termino }} </td>
          <td class="column7 style6 .b null"> {{ $row->obras[$rowspanNum-1]->f_reinicio }} </td>
          <td class="column7 style6 .b null"> {{ $row->obras[$rowspanNum-1]->f_termino_nueva }} </td>
          <td class="column7 style6 .b null"> {{ $row->obras[$rowspanNum-1]->f_inaug }} </td>
          <td class="column8 style6 .b null"> {{ $row->obras[$rowspanNum-1]->fecha_act }} </td>
          <?php
          }
          ?>
      </tr>
      <?php
      $rowspanNum--;
      for($x=$rowspanNum;$x>0;$x--){ ?>

        <tr class="row6">
                <td class="column1"></td>
                <td class="column2"></td>
                <td class="column3"></td>
                <td class="column3"></td>
                <td class="column4"></td>
          <td class="column6 style8 s"><?php echo trim($row->obras[$rowspanNum-1]->nom_meta) == '' ? 'OBRA' : strtoupper($row->obras[$x-1]->nom_meta); ?></td>
          <td class="column7 style6 .b">{{ $row->obras[$x-1]->etapa_main }}</td>
          <td class="column8 style6 .b">{{ $row->obras[$x-1]->est_situ }}</td>
          <td class="column8 style6 .b">{{ $row->obras[$x-1]->a_fisico }}</td>
          <td class="column7 style6 .b">{{ $row->obras[$x-1]->f_inicio }}</td>
          <td class="column7 style6 .b">{{ $row->obras[$x-1]->f_termino }}</td>
          <td class="column7 style6 .b">{{ $row->obras[$x-1]->f_reinicio }}</td>
          <td class="column7 style6 .b">{{ $row->obras[$x-1]->f_termino_nueva }} </td>
          <td class="column7 style6 .b">{{ $row->obras[$x-1]->f_inaug }} </td>
          <td class="column7 style6 .b">{{ $row->obras[$x-1]->fecha_act }} </td>
        </tr>

      <?php
      }
      ?>
      @endif
      @endforeach

@endforeach
</html>
