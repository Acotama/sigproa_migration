@extends('starter')

@section('body')
    <?php
      function cambioTipo($val){
        if ($val < 0){
          return 'camb-negative';
        }

        if( $val == 0 ){
          return '';
        }
        return 'camb-positive';
      }

      function getHelpLabel($val){
        if ($val < 0){
          return "<label class='num-negative'>(".$val.")</label>";
        }

        if( $val == 0 ){
          return '';
        }
        return "<label class='num-positive'>(+".$val.")</label>";
      }


    ?>
    <style>
      .camb{
        background-color: #00a65a;
        color: white;
      }

      .camb-negative{
        background-color: red;
      }

      .camb-positive{
        background-color: #00a65a;
      }

      .num-negative{
        color:red;
      }

      .num-positive{
        color:green;
      }

      .right{
        text-align: right;
      }

      .left{
        text-align: left;
      }

      .center{
        text-align: center;
      }
    </style>

    <div class="col-md-12 main">

        <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border text-center">
                <h2 class="box-title"><strong>{{ $Proyecto->nom_proyec }}</strong></h2>
                <br>
                <p>
                    <b>Codigo Unificado:</b> {{ $Proyecto->cod_unif }}
                    - <b>Codigo Snip:</b> {{ $Proyecto->cod_snip }}</p>

                <!-- /.box-tools -->
              </div>
            </div>
            <!-- /.box -->

        </div>
        <div class="row">
            <div class="pull-left">
                <!--<a href="/piptotalpriori/pdfExportHistory/{{-- $proyecto->id --}}" class="btn btn-default"><i class="fa fa-print"></i></a>-->
            </div>
        </div>
        <br>
        <div class="row table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="center">Fecha</th>
                <th class="center">PIA</th>
                <th class="center">PIM</th>
                <th class="center">Certificado</th>
                <th class="center">Compromiso Anual</th>
                <th class="center">Atención de compromiso Anual</th>
                <th class="center">Devengado</th>
                <th class="center">Girado</th>
                <th class="center">Avance %</th>
              </tr>
            </thead>
            <tbody>
            @if(count($HistoryFinance)>0)
              @foreach ($HistoryFinance as $row)
              @if( $row->camb == '1' )
              <!--<tr style="{{ $row->reg_ant_dia != '1' ? 'border-bottom: 2px solid black' : '' }}">
                <td class="{{ $row->camb == '1' ? 'camb' : '' }}">{{ $row->fecha }}</td>
                <td class="<?php echo cambioTipo($row->dif_pia_dia); ?>">{{ $row->pia_dia }}</td>
                <td class="<?php echo cambioTipo($row->dif_pim_dia); ?>">{{ $row->pim_dia }}</td>
                <td class="<?php echo cambioTipo($row->dif_certificacion_dia); ?>">{{ $row->certificacion_dia }}</td>
                <td class="<?php echo cambioTipo($row->dif_comp_anual_dia); ?>">{{ $row->comp_anual_dia }}</td>
                <td class="<?php echo cambioTipo($row->dif_ate_comp_anual_dia); ?>">{{ $row->ate_comp_anual_dia }}</td>
                <td class="<?php echo cambioTipo($row->dif_dev_dia); ?>">{{ $row->dev_dia }}</td>
                <td class="<?php echo cambioTipo($row->dif_girado_dia); ?>">{{ $row->girado_dia }}</td>
                <td class="<?php echo cambioTipo($row->dif_a_financ_dia); ?>">{{ $row->a_financ_dia }}</td>
              </tr-->

              <tr style="{{ $row->reg_ant_dia != '1' ? 'border-bottom: 2px solid black' : '' }}">
                <td class="{{ $row->camb == '1' ? 'camb' : '' }}">{{ $row->fecha }}</td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_pia_dia)
                    ?>
                    {{ number_format($row->pia_dia,2) }}
                </td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_pim_dia)
                    ?>
                    {{ number_format($row->pim_dia,2) }}
                </td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_certificacion_dia)
                    ?>
                    {{ number_format($row->certificacion_dia,2) }}
                </td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_comp_anual_dia)
                    ?>
                    {{ number_format($row->comp_anual_dia,2) }}
                </td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_ate_comp_anual_dia)
                    ?>
                    {{ number_format($row->ate_comp_anual_dia,2) }}
                </td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_dev_dia)
                    ?>
                    {{ number_format($row->dev_dia,2) }}
                </td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_girado_dia)
                    ?>
                    {{ number_format($row->girado_dia,2) }}
                </td>
                <td class="right">
                    <?php
                      echo getHelpLabel($row->dif_a_financ_dia)
                    ?>
                    {{ number_format($row->a_financ_dia,2) }}
                </td>
              </tr>

              @endif
              @endforeach
            @else
              <tr>
                <td class="center" colspan="9"><b><i>No se tiene registro de información</i></b></td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
    </div>
@endsection
