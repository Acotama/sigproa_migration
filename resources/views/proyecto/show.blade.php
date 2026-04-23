<span class="cabecera">
    <h3 class="text-center"><b>{{ $filtro }}</b></h3>
    <h4 class="text-center"><b>    AVANCE DE LA EJECUCIÓN FINANCIERA DE LOS PROYECTOS DE INVERSIÓN {{$anio}}</b></h4>
</span>

<div id="container" >
    <div class="modal-body">
        <div id="cargando_modal" class="loading" style="display: none;"></div>
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
          @if(isset($gob_reg_ejecutora))
            <li id="p_ejecutora"><a href="#tab_5" data-toggle="tab" aria-expanded="false" onclick="actualizar()">Ejecutora</a></li>
          @endif
          @if(isset($gob_reg_etapa))
            <li id="p_etapa"><a href="#tab_1" data-toggle="tab" aria-expanded="false" onclick="actualizar()">Etapa</a></li>
          @endif
          @if(isset($gob_reg_provincia))
            <li id="p_provincia"><a href="#tab_2" data-toggle="tab" aria-expanded="false" onclick="actualizar()">Provincia</a></li>
          @endif
          @if(isset($gob_reg_sector))
            <li id="p_sector" ><a href="#tab_3" data-toggle="tab" aria-expanded="true" onclick="actualizar()">Sector</a></li>
          @endif
          @if(isset($gob_reg_fuente_financiamiento))
            <li ><a href="#tab_6" data-toggle="tab" aria-expanded="true" onclick="actualizar()">Fuente Financiamiento</a></li>
          @endif
            <li ><a href="#tab_4" data-toggle="tab" aria-expanded="true" onclick="actualizar()">Proyectos</a></li>
          </ul>
          <div class="tab-content">
          @if(isset($gob_reg_ejecutora))
            <div class="tab-pane" id="tab_5">
              <div class="col-md-12" style="margin-top: 15px;">
                <div class="row">
                  <div class="table table-bordered table-responsive">
                    <table class="table table-bordered " id="ejecutora" width="100%" cellspacing="0" class="form-control">
                      <thead>
                        <tr>
                          <th style='text-align: center;vertical-align: middle;'>N° PY</th>
                          <th style='text-align: center;vertical-align: middle;'>EJECUTORA</th>
                          <th style='text-align: center;vertical-align: middle;'>VER PROYECTOS</th>
                          <th style='text-align: center;vertical-align: middle;'>MONTO INV. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVEN. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>PIM {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>CERTIF {{$anio}}</th>
                          <th class="hide">COMP. ANUAL {{$anio}}</th>
                          <th class="hide">COMP. MENSUAL {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVENGADO {{$anio}}</th>
                          <th class="hide">GIRADO {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE {{$anio}}</th>
                          <!-- <th style='text-align: center;vertical-align: middle;'>AVANCE FISICO</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($gob_reg_ejecutora as $gob_reg)
                          @if ($gob_reg->orden == -1 || $gob_reg->orden == 9 || $gob_reg->orden  == 10 || $gob_reg->orden  == 11 || $gob_reg->orden  == 12)
                            @if($gob_reg->cant_proyectos>0)
                              <tr style='background-color: darkgray;'>
                                  <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->cant_proyectos }}</td>
                                  <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                                  @if($gob_reg->ger_direc == "UE SEDE")
                                    <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('ger_direc','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 1 }} )"><i class='fa fa-eye'></i></a></td>
                                  @else
                                    <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('ger_direc','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 0 }} )"><i class='fa fa-eye'></i></a></td>
                                  @endif
                                  <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_pip) }}</td>
                                  <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_deveng_a) }}</td>
                                  @if($gob_reg->m_pip==0)
                                    <td style='text-align: center;vertical-align: middle;'>0%</td>
                                  @else
                                    <td style='text-align: center;vertical-align: middle;'>{{ round(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2) }}%</td>
                                  @endif
                                  <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->pim_dia) }}</td>
                                  <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->certificacion_dia) }}</td>
                                  <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                                  <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                                  <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                                  <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                                  @if($gob_reg->pim_dia==0)
                                    <td style='text-align: center;vertical-align: middle;'>0%</td>
                                  @else
                                    <td style='text-align: center;vertical-align: middle;'>{{ round(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2) }}%</td>
                                  @endif
                                  <!-- <td style='text-align: center;vertical-align: middle;'>{{ round(($gob_reg->a_fisico/$gob_reg->cant_proyectos),2) }}%</td> -->
                              </tr>
                            @endif
                          @else
                            <tr>
                              <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->cant_proyectos }}</td>
                              <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                              <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('ger_direc','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}' )"><i class='fa fa-eye'></i></a></td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_pip) }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_deveng_a) }}</td>
                              @if($gob_reg->m_pip==0)
                                <td style='text-align: center;vertical-align: middle;'>0%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ round(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2) }}%</td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->pim_dia) }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->certificacion_dia) }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                              @if($gob_reg->pim_dia==0)
                                <td style='text-align: center;vertical-align: middle;'>0%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ round(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2) }}%</td>
                              @endif
                              <!-- <td style='text-align: center;vertical-align: middle;'>{{ round(($gob_reg->a_fisico/$gob_reg->cant_proyectos),2) }}%</td> -->
                            </tr>
                          @endif
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr  style="background-color:#3c8dbc9c">
                            <th style='text-align: center;vertical-align: middle;'>{{ $Headers->cant_proyectos }}</th>
                            <th colspan="2" style='text-align:left'>{{ $filtro }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->m_pip) }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->m_deveng_a) }}</th>
                            @if($Headers->m_pip==0)
                              <th style='text-align: center;vertical-align: middle;'>0%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ round(($Headers->m_deveng_a/$Headers->m_pip)*100,2) }}%</th>
                            @endif
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->pim_dia) }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->certificacion_dia) }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->comp_anual_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->ate_comp_anual_dia,0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->dev_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->girado_dia,0,'.',',') }}</th>
                            @if($Headers->pim_dia==0)
                              <th style='text-align: center;vertical-align: middle;'>0%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ round(($Headers->dev_dia/$Headers->pim_dia)*100,2) }}%</th>
                            @endif
                            <!-- @if($Headers->a_fisico==0)
                              <th style='text-align: center;vertical-align: middle;'>0%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ round(($Headers->a_fisico/$Headers->cant_proyectos),2) }}%</th>
                            @endif -->
                        </tr>
                    </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          @endif
          @if(isset($gob_reg_etapa))
            <div class="tab-pane" id="tab_1">
              <div class="col-md-12" style="margin-top: 15px;">
                <div class="row">
                  <div class="table table-bordered table-responsive">
                    <table class="table table-bordered " id="etapa" width="100%" cellspacing="0" class="form-control">
                      <thead>
                        <tr>
                          <th style='text-align: center;vertical-align: middle;'>N° PY</th>
                          <th style='text-align: center;vertical-align: middle;'>ETAPA</th>
                          <th style='text-align: center;vertical-align: middle;'>VER PROYECTOS</th>
                          <th style='text-align: center;vertical-align: middle;'>MONTO INV. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVEN. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>PIM {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>CERTIF {{$anio}}</th>
                          <th class="hide">COMP. ANUAL {{$anio}}</th>
                          <th class="hide">COMP. MENSUAL {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVENGADO {{$anio}}</th>
                          <th class="hide">GIRADO {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE {{$anio}}</th>
                          <!-- <th style='text-align: center;vertical-align: middle;'>AVANCE FISICO</th> -->
                        </tr>
                      </thead>
                      <tbody >
                        @foreach($gob_reg_etapa as $gob_reg)
                          <tr>
                              <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->cant_proyectos }}</td>
                              <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                              @if($filtro == "UE SEDE")
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('etapa','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 2 }} )"><i class='fa fa-eye'></i></a></td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('etapa','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 0 }} )"><i class='fa fa-eye'></i></a></td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_pip,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_deveng_a,0,'.',',') }}</td>
                              @if($gob_reg->m_pip==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2,'.',',') }}%</td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->pim_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->certificacion_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                              @if($gob_reg->pim_dia==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2,'.',',') }}%</td>
                              @endif
                              <!-- <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->a_fisico/$gob_reg->cant_proyectos),2,'.',',') }}%</td> -->
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr  style="background-color:#3c8dbc9c">
                            <th style='text-align: center;vertical-align: middle;'>{{ $Headers->cant_proyectos }}</th>
                            <th colspan="2" style='text-align:left'>{{ $filtro }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_pip),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a),0,'.',',') }}</th>
                            @if($Headers->m_pip==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a/$Headers->m_pip)*100,2,'.',',') }}%</th>
                            @endif
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->pim_dia),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->certificacion_dia),0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->comp_anual_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->ate_comp_anual_dia,0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->dev_dia),0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->girado_dia,0,'.',',') }}</th>
                            @if($Headers->pim_dia==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->dev_dia/$Headers->pim_dia)*100,2,'.',',') }}%</th>
                            @endif
                            <!-- @if($Headers->a_fisico==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->a_fisico/$Headers->cant_proyectos),2,'.',',') }}%</th>
                            @endif -->
                        </tr>
                    </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          @endif
          @if(isset($gob_reg_provincia))
            <div class="tab-pane" id="tab_2">
              <div class="col-md-12" style="margin-top: 15px;">
                <div class="row">
                  <div class="table table-bordered table-responsive">
                    <table class="table table-bordered " id="provincia" width="100%" cellspacing="0" class="form-control">
                      <thead>
                        <tr>
                          <th style='text-align: center;vertical-align: middle;'>N° PY</th>
                          <th style='text-align: center;vertical-align: middle;'>PROVINCIA</th>
                          <th style='text-align: center;vertical-align: middle;'>VER PROYECTOS</th>
                          <th style='text-align: center;vertical-align: middle;'>MONTO INV. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVEN. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>PIM {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>CERTIF {{$anio}}</th>
                          <th class="hide">COMP. ANUAL {{$anio}}</th>
                          <th class="hide">COMP. MENSUAL {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVENGADO {{$anio}}</th>
                          <th class="hide">GIRADO {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE {{$anio}}</th>
                          <!-- <th style='text-align: center;vertical-align: middle;'>AVANCE FISICO</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($gob_reg_provincia as $gob_reg)
                          <tr>
                              <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->cant_proyectos }}</td>
                              <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                              @if($filtro == "UE SEDE")
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('nom_prov','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 2 }} )"><i class='fa fa-eye'></i></a></td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('nom_prov','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 0 }} )"><i class='fa fa-eye'></i></a></td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_pip,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_deveng_a,0,'.',',') }}</td>
                              @if($gob_reg->m_pip==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2,'.',',') }}%</td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->pim_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->certificacion_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                              @if($gob_reg->pim_dia==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2,'.',',') }}%</td>
                              @endif
                              <!-- <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->a_fisico/$gob_reg->cant_proyectos),2,'.',',') }}%</td> -->
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr  style="background-color:#3c8dbc9c">
                            <th style='text-align: center;vertical-align: middle;'>{{ $Headers->cant_proyectos }}</th>
                            <th colspan="2" style='text-align:left'>{{ $filtro }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_pip),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a),0,'.',',') }}</th>
                            @if($Headers->m_pip==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a/$Headers->m_pip)*100,2,'.',',') }}%</th>
                            @endif
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->pim_dia),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->certificacion_dia),0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->comp_anual_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->ate_comp_anual_dia,0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->dev_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->girado_dia,0,'.',',') }}</th>
                            @if($Headers->pim_dia==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->dev_dia/$Headers->pim_dia)*100,2,'.',',') }}%</th>
                            @endif
                            <!-- @if($Headers->a_fisico==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->a_fisico/$Headers->cant_proyectos),2,'.',',') }}%</th>
                            @endif -->
                        </tr>
                    </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          @endif
          @if(isset($gob_reg_sector))
            <div class="tab-pane" id="tab_3">
              <div class="col-md-12" style="margin-top: 15px;">
                <div class="row">
                    <table class="table table-bordered " id="sector" width="100%" cellspacing="0" class="form-control">
                      <thead>
                        <tr>
                          <th style='text-align: center;vertical-align: middle;'>N° PY</th>
                          <th style='text-align: center;vertical-align: middle;'>SECTOR</th>
                          <th style='text-align: center;vertical-align: middle;'>VER PROYECTOS</th>
                          <th style='text-align: center;vertical-align: middle;'>MONTO INV. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVEN. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>PIM {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>CERTIF {{$anio}}</th>
                          <th class="hide">COMP. ANUAL {{$anio}}</th>
                          <th class="hide">COMP. MENSUAL {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVENGADO {{$anio}}</th>
                          <th class="hide">GIRADO {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE {{$anio}}</th>
                          <!-- <th style='text-align: center;vertical-align: middle;'>AVANCE FISICO</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($gob_reg_sector as $gob_reg)
                          <tr>
                              <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->cant_proyectos }}</td>
                              <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                              @if($filtro == "UE SEDE")
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('sector','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 2 }} )"><i class='fa fa-eye'></i></a></td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('sector','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 0 }} )"><i class='fa fa-eye'></i></a></td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_pip,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_deveng_a,0,'.',',') }}</td>
                              @if($gob_reg->m_pip==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2,'.',',') }}%</td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->pim_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->certificacion_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                              @if($gob_reg->pim_dia==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2,'.',',') }}%</td>
                              @endif
                              <!-- <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->a_fisico/$gob_reg->cant_proyectos),2,'.',',') }}%</td> -->
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr  style="background-color:#3c8dbc9c">
                            <th style='text-align: center;vertical-align: middle;'>{{ $Headers->cant_proyectos }}</th>
                            <th colspan="2" style='text-align:left'>{{ $filtro }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_pip),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a),0,'.',',') }}</th>
                            @if($Headers->m_pip==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a/$Headers->m_pip)*100,2,'.',',') }}%</th>
                            @endif
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->pim_dia),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->certificacion_dia),0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->comp_anual_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->ate_comp_anual_dia,0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->dev_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->girado_dia,0,'.',',') }}</th>
                            @if($Headers->pim_dia==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->dev_dia/$Headers->pim_dia)*100,2,'.',',') }}%</th>
                            @endif
                            <!-- @if($Headers->a_fisico==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->a_fisico/$Headers->cant_proyectos),2,'.',',') }}%</th>
                            @endif -->
                        </tr>
                    </tfoot>
                    </table>
                </div>
              </div>
            </div>
          @endif
          @if(isset($gob_reg_fuente_financiamiento))
            <div class="tab-pane" id="tab_6">
              <div class="col-md-12" style="margin-top: 15px;">
                <div class="row">
                  <div class="table table-bordered table-responsive">
                    <table class="table table-bordered " id="fuente_financiamiento" width="100%" cellspacing="0" class="form-control">
                      <thead>
                        <tr>
                          <th style='text-align: center;vertical-align: middle;'>N° PY</th>
                          <th style='text-align: center;vertical-align: middle;'>FUENTE FINANCIAMIENTO</th>
                          <th style='text-align: center;vertical-align: middle;'>VER PROYECTOS</th>
                          <th style='text-align: center;vertical-align: middle;'>MONTO INV. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVEN. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE. ACUM. ACT.</th>
                          <th style='text-align: center;vertical-align: middle;'>PIM {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>CERTIF {{$anio}}</th>
                          <th class="hide">COMP. ANUAL {{$anio}}</th>
                          <th class="hide">COMP. MENSUAL {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>DEVENGADO {{$anio}}</th>
                          <th class="hide">GIRADO {{$anio}}</th>
                          <th style='text-align: center;vertical-align: middle;'>AVANCE {{$anio}}</th>
                          <!-- <th style='text-align: center;vertical-align: middle;'>AVANCE FISICO</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $cantidad_proyecto=0;
                        @endphp
                        @foreach($gob_reg_fuente_financiamiento as $gob_reg)
                          <tr>
                              <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->cant_proyectos }}</td>
                              <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                              @if($filtro == "UE SEDE")
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('fuente_financiamiento','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 2 }} )"><i class='fa fa-eye'></i></a></td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' class='dropdown-toggle' onclick="loadModalPry('fuente_financiamiento','{{ $gob_reg->ger_direc }}','{{ $filtro }}','{{ $anio }}','{{ $ambito }}',{{ 0 }} )"><i class='fa fa-eye'></i></a></td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_pip,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_deveng_a,0,'.',',') }}</td>
                              @if($gob_reg->m_pip==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2,'.',',') }}%</td>
                              @endif
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->pim_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->certificacion_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                              <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                              <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                              @if($gob_reg->pim_dia==0)
                                <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                              @else
                                <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2,'.',',') }}%</td>
                              @endif
                              <!-- <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->a_fisico/$gob_reg->cant_proyectos),2,'.',',') }}%</td> -->
                          </tr>
                          @php
                            $cantidad_proyecto+=$gob_reg->cant_proyectos;
                          @endphp
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr  style="background-color:#3c8dbc9c">
                            <th style='text-align: center;vertical-align: middle;'>{{ $cantidad_proyecto }}</th>
                            <th colspan="2" style='text-align:left'>{{ $filtro }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_pip),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a),0,'.',',') }}</th>
                            @if($Headers->m_pip==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->m_deveng_a/$Headers->m_pip)*100,2,'.',',') }}%</th>
                            @endif
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->pim_dia),0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->certificacion_dia),0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->comp_anual_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->ate_comp_anual_dia,0,'.',',') }}</th>
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->dev_dia,0,'.',',') }}</th>
                            <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->girado_dia,0,'.',',') }}</th>
                            @if($Headers->pim_dia==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->dev_dia/$Headers->pim_dia)*100,2,'.',',') }}%</th>
                            @endif
                            <!-- @if($Headers->a_fisico==0)
                              <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                            @else
                              <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->a_fisico/$Headers->cant_proyectos),2,'.',',') }}%</th>
                            @endif -->
                        </tr>
                    </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          @endif
          <div class="tab-pane" id="tab_4">
            <div class="col-md-12" style="margin-top: 15px;">
              <div class="row">
                  <table class="table table-bordered " id="proyecto" width="100%" cellspacing="0" class="form-control">
                    <thead>
                      <tr>
                        <th style='text-align: center;vertical-align: middle;'>COD. UNIF</th>
                        <th style='text-align: center;vertical-align: middle;'>PROYECTOS</th>
                        <th style='text-align: center;vertical-align: middle;'>VER</th>
                        <!-- <th style='text-align: center;vertical-align: middle;'>ETAPA</th> -->
                        <th style='text-align: center;vertical-align: middle;'>MONTO INV. ACT.</th>
                        <th style='text-align: center;vertical-align: middle;'>DEVEN. ACUM. ACT.</th>
                        <th style='text-align: center;vertical-align: middle;'>AVANCE. ACUM. ACT.</th>
                        <th style='text-align: center;vertical-align: middle;'>PIM {{$anio}}</th>
                        <th style='text-align: center;vertical-align: middle;'>CERTIF {{$anio}}</th>
                        <th class="hide">COMP. ANUAL {{$anio}}</th>
                        <th class="hide">COMP. MENSUAL {{$anio}}</th>
                        <th style='text-align: center;vertical-align: middle;'>DEVENGADO {{$anio}}</th>
                        <th class="hide">GIRADO {{$anio}}</th>
                        <th style='text-align: center;vertical-align: middle;'>AVANCE {{$anio}}</th>
                        <th style='text-align: center;vertical-align: middle;'>AVANCE FISICO</th>
                        <!-- <th style='text-align: center;vertical-align: middle;'>PROYECTO PARTICIPATIVO</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($gob_reg_proyecto as $gob_reg)
                        <tr>
                          <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ir a SSI" target="_blank" href="http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo={{ $gob_reg->cant_proyectos }}&tipo=2" class='dropdown-toggle'>{{ $gob_reg->cant_proyectos }}</a></td>
                          <!-- if($gob_reg->cod_snip == 'SIN COD.')
                            <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->cant_proyectos }}</td>
                          else
                            <td style='text-align: center;vertical-align: middle;'><a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ir a SSI" target="_blank" href="http://ofi4.mef.gob.pe/bp/ConsultarPIP/frmConsultarPIP.asp?accion=consultar&txtCodigo={{ $gob_reg->cod_snip }}" class='dropdown-toggle'>{{ $gob_reg->cant_proyectos }}</a></td>
                          endif -->
                          <td style='text-align:left'>{{ $gob_reg->ger_direc }}</td>
                          <td style='text-align: center;vertical-align: middle;'>
                            <a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ir a Proyectos" class='dropdown-toggle' onclick="loadpry({{ $gob_reg->id }},'{{ $gob_reg->etapa }}')"><i class='fa fa-eye'></i></a>
                            <a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ver Metas" class='dropdown-toggle' onclick="loadModalOMeta({{ $gob_reg->cant_proyectos }},'{{ $gob_reg->ger_direc }}')"><i class='fa fa-legal'></i></a>
                            <a style='cursor:pointer' data-toggle="tooltip" data-placement="bottom" title="Ver Fuente" class='dropdown-toggle' onclick="loadModalFuente({{ $gob_reg->cant_proyectos }},'{{ $gob_reg->ger_direc }}')"><i class='fa fa-book'></i></a>
                          </td>
                          <!-- <td style='text-align: center;vertical-align: middle;'>{{ $gob_reg->etapa }}</td> -->
                          <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_pip,0,'.',',') }}</td>
                          <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->m_deveng_a,0,'.',',') }}</td>
                          @if($gob_reg->m_pip==0)
                            <td style='text-align: center;vertical-align: middle;'>0.00%</td>
                          @else
                            <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->m_deveng_a/$gob_reg->m_pip)*100,2,'.',',') }}%</td>
                          @endif
                          <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->pim_dia,0,'.',',') }}</td>
                          <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->certificacion_dia,0,'.',',') }}</td>
                          <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->comp_anual_dia,0,'.',',') }}</td>
                          <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->ate_comp_anual_dia,0,'.',',') }}</td>
                          <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->dev_dia,0,'.',',') }}</td>
                          <td class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->girado_dia,0,'.',',') }}</td>
                          @if($gob_reg->pim_dia==0)
                            <td style='text-align: center;vertical-align: middle;'>0%</td>
                          @else
                            <td style='text-align: center;vertical-align: middle;'>{{ number_format(($gob_reg->dev_dia/$gob_reg->pim_dia)*100,2,'.',',') }}%</td>
                          @endif
                          <td style='text-align: center;vertical-align: middle;'>{{ number_format($gob_reg->a_fisico,2,'.',',') }}%</td>
                          <!-- <td style='text-align: center;vertical-align: middle;'>{{ !empty($gob_reg->pic) ? 'SI' : 'NO' }}</td> -->
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr  style="background-color:#3c8dbc9c">
                          <th style='text-align: center;vertical-align: middle;'>TOTAL {{ $Headers->cant_proyectos }}</th>
                          <th colspan="2" style='text-align:left'>{{ $filtro }}</th>
                          <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->m_pip,0,'.',',') }}</th>
                          <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->m_deveng_a,0,'.',',') }}</th>
                          @if($Headers->m_pip==0)
                            <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                          @else
                            <th style='text-align: center;vertical-align: middle;'>{{ round(($Headers->m_deveng_a/$Headers->m_pip)*100,2) }}%</th>
                          @endif
                          <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->pim_dia,0,'.',',') }}</th>
                          <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->certificacion_dia,0,'.',',') }}</th>
                          <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->comp_anual_dia,0,'.',',') }}</th>
                          <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->ate_comp_anual_dia,0,'.',',') }}</th>
                          <th style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->dev_dia,0,'.',',') }}</th>
                          <th class="hide" style='text-align: center;vertical-align: middle;'>{{ number_format($Headers->girado_dia,0,'.',',') }}</th>
                          @if($Headers->pim_dia==0)
                            <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                          @else
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->dev_dia/$Headers->pim_dia)*100,2,'.',',') }}%</th>
                          @endif
                          @if($Headers->a_fisico==0)
                            <th style='text-align: center;vertical-align: middle;'>0.00%</th>
                          @else
                            <th style='text-align: center;vertical-align: middle;'>{{ number_format(($Headers->a_fisico/$Headers->cant_proyectos),2,'.',',') }}%</th>
                          @endif
                          <!-- <th style='text-align: center;vertical-align: middle;'></th> -->
                      </tr>
                  </tfoot>
                  </table>
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

      @if($ambito=="EJECUTORA")
        $("#p_etapa").addClass("active");
        $("#tab_1").addClass("active");
      @else
        $("#p_ejecutora").addClass("active");
        $("#tab_5").addClass("active");
      @endif

      tabla=function(id,orden,panel,titulo,columnas){
        var oTable = $(id).DataTable({
              processing: true,
              dom: 'B<"clear">lfrtip',
              buttons: {
                  orientation: 'landscape',
                  color:'#3c8dbc9c',
                  buttons: [ {
                      extend: 'excelHtml5',
                      text:   '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                      titleAttr: 'Excel',
                      autoFilter: false,
                      sheetName: panel,
                      title: titulo,
                      exportOptions: {
                        columns: columnas
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
              order: orden,
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
      actualizar = function(){
        setTimeout(function () {
             $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
        },0);
      }
      tabla("#ejecutora",'',"EJECUTORA","{{ $filtro }}-EJECUTORA",[0,1,3,4,5,6,7,8,9,10,11,12]);
      tabla("#etapa",[[ 3, "desc" ]],"ETAPA","{{ $filtro }}-ETAPA",[0,1,3,4,5,6,7,8,9,10,11,12]);
      tabla("#provincia",[[ 3, "desc" ]],"PROVINCIA","{{ $filtro }}-PROVINCIA",[0,1,3,4,5,6,7,8,9,10,11,12]);
      tabla("#sector",[[ 3, "desc" ]],"SECTOR","{{ $filtro }}-SECTOR",[0,1,3,4,5,6,7,8,9,10,11,12,13]);
      tabla("#fuente_financiamiento",'',"FUENTE FINANCIAMIENTO","{{ $filtro }}-FUENTE FINANCIAMIENTO",[0,1,3,4,5,6,7,8,9,10,11,12]);
      tabla("#proyecto",[[ 4, "desc" ]],"PROYECTOS","{{ $filtro }}-PROYECTOS",[0,1,3,4,5,6,7,8,9,10,11,12,13]);

      loadModalPry = function(ambito,ger_direc,filtro,anio,p_ambito,opc) {
        modaltype='modal_wide';
        $modal = $('#' + modaltype);
              $.ajax({
                  url: '{{ asset("/proyecto/showpry/") }}',
                  type: 'POST',
                  data:{ambito:ambito,ger_direc:ger_direc,filtro:filtro,anio:anio,p_ambito:p_ambito,opc:opc},
                  beforeSend: function () {
                      $("#cargando_modal").show();
                  },
                  success: function (response) {
                      $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                      $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                      $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                      $('#' + modaltype).modal('show', {backdrop: 'true'});
                  },
                  complete: function(response) {
                    $("#cargando_modal").hide();
                  },
              });
      }

      loadModalOMeta = function(filtro,nombre) {
        modaltype='modal_wide_pry';
        $modal = $('#' + modaltype);
              $.ajax({
                  url: '{{ asset("/proyecto/showMeta") }}',
                  type: 'POST',
                  data:{ambito :$("#ambito :selected").val(),cod_unif:filtro,nombre:nombre,anio:$("#anio :selected").val()},
                  beforeSend: function () {
                      $("#cargando_modal").show();
                      $("#cargando_modal1").show();
                  },
                  success: function (response) {
                      $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                      $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                      $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                      $('#' + modaltype).modal('show', {backdrop: 'true'});
                  },
                  complete: function(response) {
                    $("#cargando_modal").hide();
                    $("#cargando_modal1").hide();
                  },
              });
        }

      loadModalFuente = function(filtro,nombre) {
        modaltype='modal_wide_pry';
        $modal = $('#' + modaltype);
              $.ajax({
                  url: '{{ asset("/proyecto/showFuente") }}',
                  type: 'POST',
                  data:{ambito :$("#ambito :selected").val(),cod_unif:filtro,nombre:nombre,anio:$("#anio :selected").val()},
                  beforeSend: function () {
                      $("#cargando_modal").show();
                      $("#cargando_modal1").show();
                  },
                  success: function (response) {
                      $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                      $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                      $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                      $('#' + modaltype).modal('show', {backdrop: 'true'});
                  },
                  complete: function(response) {
                    $("#cargando_modal").hide();
                    $("#cargando_modal1").hide();
                  },
              });
        }

      loadpry=function (id,ger_direc)
      {
        window.open("/proyecto/abrirproyecto?id=" + id+"&tipopry="+ger_direc);
      }
    });
  </script>
</div>
