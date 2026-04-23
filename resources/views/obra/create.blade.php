<span class="cabecera">
    <b style="font-size:25px;text-align:center;">Agregar Ejecución</b>
</span>
<div id="container">
  <form method="POST" name="frmObra" action="/piptotalpriori/ejecucion/obra/store" id = "frmObra" onsubmit="updateObra(event)">
    <div class="panel panel-primary">
      <input type="hidden" name="idP" value="{{ $id }}">
      <div class="panel-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      {{ Form::label('', ' Nombre del proyecto:') }}
                      <label class="form-control" style="height:auto">{{ $pInfo['nom_proyec'] }}</label>
                  </div>
              </div>
          </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        {{ Form::label('', ' Código Snip:') }}
                        <label class="form-control">{{ $pInfo['cod_snip'] }}</label>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5">
                    <div class="form-group">
                        {{ Form::label('', ' Código Unificado:') }}
                        <label class="form-control">{{ $pInfo['cod_unif'] }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-heading" style="border-top-left-radius: 0px;border-top-right-radius:0px;"><b>Datos del expediente técnico</b></div>
        <div class="panel-body">
            <div class="row form-group">
                <div class="col-md-3 text-center" >
                    <label class="label h1 label-warning" style="font-size:15px">Tipo de Ejecución</label>
                </div>
                <div class="col-md-3">
                    <label class="radio-inline" onchange="divMeta()" style="font-size:16px;font-weight: bold"><input class="tipometa" type="radio" name="tipo" value = "E" checked>Ejecución Integral</label>
                </div>
                <div class="col-md-3">
                    <label class="radio-inline" onchange="divMeta()" style="font-size:16px;font-weight: bold"><input class="tipometa" type="radio" name="tipo" value = "M">Ejecución de Meta</label>
                </div>
                <div class="col-md-3">
                    <label class="radio-inline" onchange="divMeta()" style="font-size:16px;font-weight: bold"><input class="tipometa" type="radio" name="tipo" value = "S">Otros</label>
                </div>
            </div>
                <div id = "divMeta" style="display: none;">
                <div class="row">
                    <div class="col-md-3" id="meta_ocul">
                        <div class="form-group">
                                    {{ Form::label('nro_meta', ' Orden De Ejecución / N° Meta:') }}
                            {{ Form::text('nro_meta', null, array('class' => 'form-control', 'placeholder' => 'Ej. 2')) }}
                    </div>
                    </div>
                    <div class="col-md-9" id="cl_nom_meta">
                    <div class="form-group">
                        <label for="nom_meta">Nombre de Meta (Componente): <span id="cl_nom_meta_s" style="color:red;display: none;"> Saldo de obra, Arbitraje, etc.</span></label>
                        {{ Form::text('nom_meta', null, array('class' => 'form-control', 'placeholder' => 'Ej. Meta II : (Infraestructura, Equipo, Capacitación, etc.)')) }}
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('m_exp_tec', 'Monto de Elaboración de Expediente Técnico:') }}
                        {{ Form::text('m_exp_tec','0.00', array('class' => 'form-control','step'=>'1','onkeyup'=>'total_obra(this)','onkeypress'=>'if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;','onblur'=>'formato_numero(this)')) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('res_exp_tec', 'Resolución de Aprobación de Exp. Tec:') }}
                        {{ Form::text('res_exp_tec', null, array('class' => 'form-control','placeholder' => 'Ej. RESOLUCIÓN GERENCIAL REGIONAL N° 001-2019-GRL/GRI')) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('m_vreferencial', 'Monto de la ejecución de la Obra (*)') }}
                        {{ Form::text('m_vreferencial','0.00', array('class'=>'form-control','required','step'=>'1','onkeyup'=>'total_obra(this)','onkeypress'=>'if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;','onblur'=>'formato_numero(this)')) }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('m_supervision', 'Monto de la supervisión de la Obra (*)') }}
                        {{ Form::text('m_supervision','0.00', array('class'=>'form-control','required','step'=>'1','onkeyup'=>'total_obra(this)','onkeypress'=>'if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;','onblur'=>'formato_numero(this)')) }}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('total_obra','Monto total de la Obra') }}
                        <label class="form-control" for="total_obra" id="total_obra">S/ {{ number_format(0,2) }}</label>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
      </div>
        <!-- ESTADO SITUACIONAL -->
      <div class="panel-heading" style="border-top-left-radius: 0px;border-top-right-radius:0px;"><b>Estado Actual de la Meta</b></div>
      <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('etapa', 'Etapa (*)') }}
                    <select name = "etapa" id="cboEtapa" class="form-control" onchange="loadSubEtapa()"><option selected="selected">- Seleccionar -</option>@foreach($etapas as $key => $etapa)<option value="{{ $key }}" >{{ $etapa }}</option>@endforeach</select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('sub_etapa', 'Sub Etapa (*)') }}
                    <select name = "sub_etapa"  id = "cboSubEtapa" onchange="cambiarsubetapa()" class="form-control"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('a_fisico', 'Avance Fisico (*)') }}
                    {{ Form::text('a_fisico', null, array('class' => 'form-control', 'id' => 'a_fisico_obra')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('fecha_act', ' Fecha de Actualización (*)') }}
                    <input type="date" class="form-control" name="fecha_act" id="fecha_act" value="<?php echo date('Y-m-d') ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  {{ Form::label('est_situ', 'Descripcion de estado (*)') }}
                  {{ Form::textarea('est_situ', null, array('class' => 'form-control','cols' => '12', 'rows' => '5')) }}
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('tipo_obs', 'Tipo de observación:') }}
                {{ Form::select('tipo_obs',
                  array(''=>'- Seleccionar -',
                  'PROCEDIMIENTO DE SELECCIÓN' => 'PROCEDIMIENTO DE SELECCIÓN',
                  'ATRASOS Y/O PARALIZACIONES' => 'ATRASOS Y/O PARALIZACIONES',
                  'RESOLUCIÓN DE CONTRATO' => 'RESOLUCIÓN DE CONTRATO',
                  'RESOLUCIÓN DE CONVENIO' => 'RESOLUCIÓN DE CONVENIO',
                  'DISPONIBILIDAD DE TERRENO' => 'DISPONIBILIDAD DE TERRENO',
                  'PERMISOS Y LICENCIAS' => 'PERMISOS Y LICENCIAS',
                  'OTRAS AUTORIZACIONES' => 'OTRAS AUTORIZACIONES',
                  'INTERFERENCIAS' => 'INTERFERENCIAS',
                  'ARBITRAJE' => 'ARBITRAJE',
                  'RECURSOS FINANCIEROS' => 'RECURSOS FINANCIEROS',
                  'SUPERVISOR/INSPECTOR' => 'SUPERVISOR/INSPECTOR',
                  'RIESGO NO IDENTIFICADO' => 'RIESGO NO IDENTIFICADO',
                  'VALORIZACIÓN OBSERVADA' => 'VALORIZACIÓN OBSERVADA',
                  'RECEPCIÓN OBSERVADA' => 'RECEPCIÓN OBSERVADA',
                  'OTRAS OBSERVACIONES' => 'OTRAS OBSERVACIONES'
                  ),
                    null, array('class' => 'form-control'))
                  }}
                </select>
            </div>
          </div>
          <div class="col-md-8">
              <div class="form-group">
                {{ Form::label('obs', 'Observación (Problemática):') }}
                {{ Form::textarea('obs', null , array('class' => 'form-control','cols' => '12', 'rows' => '5')) }}
              </div>
          </div>
        </div>
      </div>
        <!-- ESTADO SITUACIONAL #END-->
      <div  class="panel-heading" style="border-top-left-radius: 0px;border-top-right-radius:0px;"><b>Datos de Obra</b></div>
        <div class="panel-body" id="estado_opc">
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('f_inicio', 'Fecha Inicio Programada') }}
                    <input type="date" class="form-control" name="f_inicio" id="f_inicio" onchange="calculotiempo();" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('f_termino', ' Fecha Finalización Programada') }}
                    <input type="date" class="form-control" name="f_termino" id="f_termino" onchange="calculotiempo();" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('mod_ejec', 'Modalidad de Ejecucion de la obra') }}
                  {{ Form::select('mod_ejec', array(''=> '- Seleccionar -', 'ADMINISTRACION DIRECTA' => 'ADMINISTRACION DIRECTA', 'CONTRATA' => 'CONTRATA', 'OBRA POR IMPUESTO' => 'OBRA POR IMPUESTO O CONVENIO','OTROS' => 'OTROS'),'', array('class' => 'form-control','onchange'=>'AdmOContM(this)')) }}
                </div>
              </div>
          </div>
          <div class="row" id = "dvNro_ContratoM" style="display: none;">
            <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('n_contrato', ' Número Contrato:') }}
                  {{ Form::text('n_contrato',null, array('class' => 'form-control','onkeyup'=>'buscar_contrato(this)')) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('f_contrato', ' Fecha de Contrato:') }}
                    <input type="date" class="form-control" name="f_contrato" id="f_contrato" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('m_ejecucion', ' Monto Contrato:') }}
                    {{ Form::number('m_ejecucion','0.00', array('class' => 'form-control','step'=>'any', 'placeholder' => 'Monto Contrato')) }}
                </div>
            </div>
          </div>
          <div class="row" style="display:none">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('f_adjudicacion', 'Fecha de Adjudicacion') }}
                    <input type="date" class="form-control" name="f_adjudicacion" />
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                  {{ Form::label('f_reinicio', ' Fecha de Inicio Real') }}
                  <input type="date" class="form-control" name="f_reinicio" />
                </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('f_termino_nueva', 'Fecha de Termino Real') }}
                <input type="date" class="form-control" name="f_termino_nueva"/>
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('f_inaug', ' Fecha Inauguracion:') }}
                    <input type="date" class="form-control" name="f_inaug"/>
                </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                {{ Form::label('u_ejec', ' Unidad Ejecutora') }}
                <select class="selectpicker form-control" name="u_ejec">@foreach($ger as $g)<option>{{ $g }}</option>@endforeach</select>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('anio_ejec', ' Año de Ejecucion') }}
                    {{ Form::text('anio_ejec', null, array('class' => 'form-control','readonly')) }}
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('t_ejec_dias', ' Tiempo De Ejecución(días)') }}
                    {{ Form::text('t_ejec_dias', null, array('class' => 'form-control','readonly')) }}
                </div>
              </div>
          </div>
          <br>
          <br>
      </div>
    </div>
    <div class="text-left">
      <b>(*) Campos Obligatorios.</b>
    </div>
    <div class="text-center">
      <button class="btn btn-success" type="submit"> Crear </button>
    </div>
  </form>
</div>

<div class="pie"></div>
