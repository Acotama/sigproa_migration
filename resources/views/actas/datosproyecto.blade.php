<!-- Datos del Proyecto -->
@php
    $year= date("Y");
@endphp
<div class="row" id="datos">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-database"></i>
                <h3 class="box-title bold"><strong>Datos del Proyecto</strong></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div role="tabpanel">
                    <div class="col-sm-2">
                        <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                            <li role="presentation" class="brand-nav active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">DATOS GENERALES</a></li>
                            <li role="presentation" class="brand-nav"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">DATOS DE EJECUCIÓN</a></li>
                            <li role="presentation" class="brand-nav"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">DATOS FINANCIEROS</a></li>
                            <li role="presentation" class="brand-nav"><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">FUENTE DE FINANCIAMIENTO</a></li>
                            <li role="presentation" class="brand-nav"><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab">SEGUIMIENTO DE INVERSIONES</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-10" style="border-left: 1px solid;overflow-y:scroll;height:300px">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                <h4><b>DATOS GENERALES</b></h4>
                                {{ Form::model($data) }}
                                <div class="row">
                                    <div class="col-md-4">
                                        {{ Form::label('sector', 'Sector:') }}
                                        {{ Form::text('sector', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::label('progr', 'Programa:') }}
                                        {{ Form::text('progr', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::label('sub_progr', 'Sub Programa:') }}
                                        {{ Form::text('sub_progr', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        {{ Form::label('u_formul', 'Unidad Formuladora:') }}
                                        {{ Form::textarea('u_formul', null, array('class' => 'form-control', 'readonly' => 'readonly','rows'=>'2')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::label('u_ejec', 'Unidad Ejecutora:') }}
                                        {{ Form::text('u_ejec', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::label('ger_direc', 'Gerencia/Direccion:') }}
                                        {{ Form::textarea('ger_direc', null, array('class' => 'form-control', 'readonly' => 'readonly','rows'=>'2')) }}
                                    </div>
                                </div><br>
                                <div class="row">
                                    {{ Form::hidden('nom_dpto', null, null) }}
                                    {{ Form::hidden('cod_dpto', null, null) }}
                                    <div class="col-md-4">
                                        {{ Form::label('cod_dpto', 'Nombre Departamento:') }}
                                        {{ Form::label('', 'LIMA',array('class'=>'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                    {{ Form::hidden('nom_prov', null, null) }}
                                    {{ Form::hidden('cod_prov', null, null) }}
                                    <div class="col-md-4">
                                        {{ Form::label('cod_prov', 'Nombre Provincia:') }}
                                        {{ Form::text('nom_prov', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                    {{ Form::hidden('nom_dist', null, null) }}
                                    {{ Form::hidden('cod_dist', null, null) }}
                                    <div class="col-md-4">
                                        {{ Form::label('cod_dist', 'Nombre Distrito:') }}
                                        {{ Form::text('nom_dist', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-8">
                                        {{ Form::label('nom_cp', 'Nombre Centro Poblado:') }}
                                        {{ Form::text('nom_cp', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab2">
                                <div class="row col-md-12">
                                    <h4><b>DATOS DE EJECUCIÓN</b></h4>
                                    @if(count($Obras) > 0 )
                                        <div class="row">
                                            @foreach($Obras as $obra)
                                            <div class="col-md-12" >
                                                <div class="col-md-12  bg-success">
                                                    <div class="col-md-6" style="border-right:2px solid #2c9a68;">
                                                        <label  style="padding:10px;font-size: 16px;font-weight: bold;">
                                                            {{$obra->nom_meta != '' ? $obra->nom_meta : 'OBRA' }}
                                                            <?php
                                                                switch ($obra->tipo) {
                                                                case 'M':
                                                                    echo '<label class="label label-success">Meta</label>';
                                                                    break;
                                                                case 'S':
                                                                    echo '<label class="label label-warning">Otros</label>';
                                                                    break;
                                                                case 'E':
                                                                    echo '<label class="label label-primary">Ejecución Integral</label>';
                                                                    break;
                                                                }
                                                            ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label  style="padding-left:10px;font-size: 16px;font-weight: bold;">
                                                        Año(s) de Ejecucion: {{empty($obra->anio_ejec)?'----':$obra->anio_ejec}}</label>
                                                        <label  style="padding-left:10px;font-size: 16px;font-weight: bold;">
                                                        Resolución de Aprobación de Exp. Tec: {{empty($obra->res_exp_tec)?'----':$obra->res_exp_tec}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-md-12">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Monto de expediente técnico</label>
                                                        <label class="form-control">{{empty($obra->m_exp_tec)?number_format(0,2):number_format($obra->m_exp_tec,2)}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Monto de la ejecución de la Obra</label>
                                                        <label class="form-control">{{empty($obra->m_vreferencial)?number_format(0,2):number_format($obra->m_vreferencial,2)}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Monto de la supervisión de la Obra</label>
                                                        <label class="form-control">{{empty($obra->m_supervision)?number_format(0,2):number_format($obra->m_supervision,2)}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Monto total de la Obra</label>
                                                        <label class="form-control">{{number_format($obra->m_exp_tec + $obra->m_vreferencial + $obra->m_supervision,2)}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-md-12">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Etapa</label>
                                                        <label class="form-control">{{$obra->etapa}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Sub Etapa</label>
                                                        <label class="form-control">{{$obra->sub_etapa}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Av. Físico</label>
                                                        <label class="form-control">{{$obra->a_fisico}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Actualizado el:</label>
                                                        <label class="form-control">{{$obra->fecha_act}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-md-12">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Modalidad de Ejecucion de la obra</label>
                                                        <label class="form-control">{{$obra->mod_ejec}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Número Contrato</label>
                                                        <label class="form-control">{{$obra->n_contrato}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fecha de Contrato</label>
                                                        <label class="form-control">{{$obra->f_contrato}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Monto de Contrato</label>
                                                        <label class="form-control">{{ !empty($obra->m_ejecucion)?number_format($obra->m_ejecucion,2):number_format(0,2)}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-md-12">
                                                <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Situación Actual </label>
                                                    <textarea readonly class="form-control">{{trim($obra->est_situ)}}</textarea readonly>
                                                </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <h4><b>ESTADO SITUACIONAL DEL PROYECTO</b></h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{ Form::label('est_pry', 'Estado Proyecto:') }}
                                                    {{ Form::text('est_pry', null, array('class' => 'form-control', 'readonly' => 'readonly','disabled' => 'disabled')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="form-group">
                                                        {{ Form::label('tipo_pry', 'Tipo de Proyecto:') }}
                                                        {{ Form::text('tipo_pry', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{ Form::label('etapa', 'Etapa:') }}
                                                    {{ Form::text('etapa', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{ Form::label('sub_etapa', 'Sub Etapa:') }}
                                                    {{ Form::text('sub_etapa', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('situa_pro', 'Situacion Actual:') }}
                                                    {{ Form::textarea('situa_pro', null, array('class' => 'form-control', 'readonly' => 'readonly', 'rows' => '4','id' => 'situa_pro')) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                                <div class="form-group">
                                                    {{ Form::label('f_etapsub', 'Fecha actualización de estado situacional:') }}
                                                    {{ Form::text('f_etapsub', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab3">
                                <h4><b>DATOS FINANCIEROS</b></h4>
                                <div class="row col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {{ Form::label('m_pip', 'Monto de Inversión Total:') }}
                                            <label class="form-control" >{{number_format($data['m_pip'],2)}}</label>
                                        </div>
                                        <div class="col-md-4">
                                            {{ Form::label('m_viab', 'Monto Viable:') }}
                                            <label class="form-control" >{{number_format($data['m_viab'],2)}}</label>
                                        </div>
                                        <div class="col-md-4">
                                            {{ Form::label('m_exptec', 'Monto Exp. Tec.:') }}
                                            <label class="form-control" >{{number_format($data['m_exptec'],2)}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-8 table table-responsive">
                                        <table id="strip" style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 13px;white-space:nowrap" border="1" >
                                            <thead style="background-color:#337ab7;color:white">
                                                <tr>
                                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">AÑO</th>
                                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">PIM</th>
                                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">DEVENGADO</th>
                                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">% AVANCE FINANCIERO ANUAL</th>
                                                    <!--<th style="width: 1%;text-align:center;font-size: 15px">PIM ACUMULADO</th>-->
                                                    <th style="width: 1%;text-align:center;font-size: 15px">DEV. ACUMULADO</th>
                                                    <th style="width: 1%;text-align:center;font-size: 15px">% AVANCE FINANCIERO TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody id='str' style="font-size:18px;">
                                                <tr>
                                                    <td  class="text-center" style="white-space: nowrap;">{{ $data['ult_anio_ejec_pry_financ'] }}</td>
                                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_pim'],2) }}</td>
                                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_deveng'],2) }}</td>
                                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['a_financ'],2) }}</td>
                                                    <!--<td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_pim_acu'],2) }}</td>-->
                                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_deveng_a'],2) }}</td>
                                                    @if($data['m_pip']==0)
                                                    <td  class="text-center" style="white-space: nowrap;">0.0</td>
                                                    @else
                                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format(($data['m_deveng_a']/$data['m_pip'])*100,2) }}</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                        <b>Actualizado al: {{ $data['f_deveng_a'] }}</b>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#m_infFin"><i class="fa fa-files-o"></i> Detalle</button>
                                    </div>
                                    </div>
                                    <div id="m_infFin" class="modal fade" tabindex="-1" data-width="760" style="top:45%;outline: none;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4>Información Financiera</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table id="strip" style="width: 100%; font-size:12px;border-color: black;text-align: left;font-size: 14px" border="1">
                                                <thead style="background-color:grey;color:white">
                                                <tr>
                                                    <th style="width: 30px;text-align:center;font-size: 15px">EJECUTORA</th>
                                                    <th style="width: 30px;text-align:center;font-size: 15px">AÑO</th>
                                                    <th style="width: 30px;text-align:center;font-size: 15px">PIA</th>
                                                    <th style="width: 30px;text-align:center;font-size: 15px">PIM</th>
                                                    <th style="width: 30px;text-align:center;font-size: 15px">CERTIFICACIÓN</th>
                                                    <th style="width: 30px;text-align:center;font-size: 15px">DEVENGADO</th>
                                                </tr>
                                                </thead>
                                                <tbody id='str'>
                                                @foreach($InfFinanciera as $if)
                                                    <tr>
                                                        <td>{{ $if['uni_ejec'] }}</td>
                                                        <td>{{ $if['anio_financ'] }}</td>
                                                        <td style="text-align: right">{{ number_format($if['pia'],2) }}</td>
                                                        <td style="text-align: right">{{ number_format($if['pim'],2) }}</td>
                                                        <td style="text-align: right">{{ number_format($if['certif'],2) }}</td>
                                                        <td style="text-align: right">{{ number_format($if['dev'],2) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <p><b>Fuente:</b><span>Aplicativo Informático SOSEM</span></p>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab4">
                                <h4><b>FUENTE DE FINANCIAMIENTO {{ $year }}</b></h4>
                                @if(count($Fuente_financiamiento) > 0 )
                                    <div class="row">
                                        <div class="col-md-12 table table-responsive">
                                        <table style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 14px;white-space:nowrap" border="1" >
                                            <thead style="background-color:#337ab7;color:white">
                                                <tr>
                                                <th style="vertical-align: middle;" class="text-center">FUENTE DE FINANCIAMIENTO</th>
                                                <th style="vertical-align: middle;" class="text-center">PIM</th>
                                                <th style="vertical-align: middle;" class="text-center">CERTIFICADO</th>
                                                <th style="vertical-align: middle;" class="text-center">DEVENGADO</th>
                                                <th style="vertical-align: middle;" class="text-center">GIRADO</th>
                                                <th style="vertical-align: middle;" class="text-center">% AVANCE</th>
                                                </tr>
                                            </thead>
                                            <tbody id='str' style="font-size:14px;">
                                                @foreach($Fuente_financiamiento as $fuente)
                                                @if($fuente[0]->fuente_financiamiento=='RECURSOS POR OPERACIONES OFICIALES DE CREDITO')
                                                    <tr>
                                                    <td class="text-left"><b>{{$fuente[0]->fuente_financiamiento}}</b></td>
                                                    <td class="text-center">{{number_format($fuente[0]->pim_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->certificacion_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->dev_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->girado_dia,2)}}</td>
                                                    @if($fuente[0]->pim_dia==0)
                                                        <td  class="text-center" style="white-space: nowrap;">0.00</td>
                                                    @else
                                                        <td class="text-center">{{number_format(($fuente[0]->dev_dia/$fuente[0]->pim_dia)*100,2)}}</td>
                                                    @endif
                                                    </tr>
                                                @endif
                                                @if($fuente[0]->fuente_financiamiento=='RECURSOS ORDINARIOS')
                                                    <tr>
                                                    <td class="text-left"><b>{{$fuente[0]->fuente_financiamiento}}</b></td>
                                                    <td class="text-center">{{number_format($fuente[0]->pim_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->certificacion_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->dev_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->girado_dia,2)}}</td>
                                                    @if($fuente[0]->pim_dia==0)
                                                        <td  class="text-center" style="white-space: nowrap;">0.00</td>
                                                    @else
                                                        <td class="text-center">{{number_format(($fuente[0]->dev_dia/$fuente[0]->pim_dia)*100,2)}}</td>
                                                    @endif
                                                    </tr>
                                                @endif
                                                @if($fuente[0]->fuente_financiamiento=='RECURSOS DETERMINADOS')
                                                    <tr>
                                                    <td class="text-left"><b>{{$fuente[0]->fuente_financiamiento}}</b></td>
                                                    <td class="text-center">{{number_format($fuente[0]->pim_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->certificacion_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->dev_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->girado_dia,2)}}</td>
                                                    @if($fuente[0]->pim_dia==0)
                                                        <td  class="text-center" style="white-space: nowrap;">0.00</td>
                                                    @else
                                                        <td class="text-center">{{number_format(($fuente[0]->dev_dia/$fuente[0]->pim_dia)*100,2)}}</td>
                                                    @endif
                                                    </tr>
                                                @endif
                                                @if($fuente[0]->fuente_financiamiento=='DONACIONES Y TRANSFERENCIAS')
                                                    <tr>
                                                    <td class="text-left"><b>{{$fuente[0]->fuente_financiamiento}}</b></td>
                                                    <td class="text-center">{{number_format($fuente[0]->pim_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->certificacion_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->dev_dia,2)}}</td>
                                                    <td class="text-center">{{number_format($fuente[0]->girado_dia,2)}}</td>
                                                    @if($fuente[0]->pim_dia==0)
                                                        <td  class="text-center" style="white-space: nowrap;">0.00</td>
                                                    @else
                                                        <td class="text-center">{{number_format(($fuente[0]->dev_dia/$fuente[0]->pim_dia)*100,2)}}</td>
                                                    @endif
                                                    </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                @else
                                    <b>->No hay Información</b>
                                @endif
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab5">
                                @if(count($Avance) > 0 )
                                    <h4><b>SEGUIMIENTO DE INVERSIONES {{$year}} <a target="_blank" href="https://ofi5.mef.gob.pe/invierte/seguimiento/verFichaSeguimiento/{!! $data['cod_unif'] !!}">(FORMATO 12-B)</a></b></h4>
                                    <div class="row">
                                        <div class="col-md-12 table table-responsive">
                                        <table style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 13px;white-space:nowrap" border="1" >
                                            <thead style="background-color:#337ab7;color:white">
                                                <tr>
                                                <th style="vertical-align: middle;" class="text-center">ESTADO</th>
                                                <th style="vertical-align: middle;" class="text-center">ENERO</th>
                                                <th style="vertical-align: middle;" class="text-center">FEBRERO</th>
                                                <th style="vertical-align: middle;" class="text-center">MARZO</th>
                                                <th style="vertical-align: middle;" class="text-center">ABRIL</th>
                                                <th style="vertical-align: middle;" class="text-center">MAYO</th>
                                                <th style="vertical-align: middle;" class="text-center">JUNIO</th>
                                                <th style="vertical-align: middle;" class="text-center">JULIO</th>
                                                <th style="vertical-align: middle;" class="text-center">AGOSTO</th>
                                                <th style="vertical-align: middle;" class="text-center">SEPTIEMBRE</th>
                                                <th style="vertical-align: middle;" class="text-center">OCTUBRE</th>
                                                <th style="vertical-align: middle;" class="text-center">NOVIEMBRE</th>
                                                <th style="vertical-align: middle;" class="text-center">DICIEMBRE</th>
                                                <th style="vertical-align: middle;" class="text-center">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody id='str' style="font-size:13px;">
                                                @foreach($Avance as $avance)
                                                @if($avance[0]->fase=='PROGRAMADO')
                                                    <tr>
                                                    <td class="text-center"><b>{{$avance[0]->fase}}</b></td>
                                                    <td class="text-center">{{number_format($avance[0]->enero,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->febrero,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->marzo,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->abril,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->mayo,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->junio,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->julio,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->agosto,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->septiembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->octubre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->noviembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->diciembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->total,2)}}</td>
                                                    </tr>
                                                @endif
                                                @if($avance[0]->fase=='ACTUALIZADO')
                                                    <tr>
                                                    <td class="text-center"><b>{{$avance[0]->fase}}</b></td>
                                                    <td class="text-center">{{number_format($avance[0]->enero,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->febrero,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->marzo,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->abril,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->mayo,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->junio,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->julio,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->agosto,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->septiembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->octubre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->noviembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->diciembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->total,2)}}</td>
                                                    </tr>
                                                @endif
                                                @if($avance[0]->fase=='EJECUTADO')
                                                    <tr>
                                                    <td class="text-center"><b>{{$avance[0]->fase}}</b></td>
                                                    <td class="text-center">{{number_format($avance[0]->enero,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->febrero,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->marzo,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->abril,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->mayo,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->junio,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->julio,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->agosto,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->septiembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->octubre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->noviembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->diciembre,2)}}</td>
                                                    <td class="text-center">{{number_format($avance[0]->total,2)}}</td>
                                                    </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                            @if(!empty($fecha_12b))
                                                <b> Actualizado al: {{$fecha_12b}}</b>
                                            @endif
                                        </table>
                                        </div>
                                        
                                    </div>
                                @else
                                    <h4><b>SEGUIMIENTO DE INVERSIONES {{$year}}</h4>
                                    <b>-> No hay Información</b>
                                @endif
                                <h4><b>PROGRAMACIÓN MULTIANUAL DE INVERSIONES</b></h4>
                                @if(count($Cartera) > 0 )
                                    <div class="row">
                                        <div class="col-md-12 table table-responsive">
                                        <table id="strip" style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 14px;white-space:nowrap" border="1" >
                                            <thead style="background-color:#337ab7;color:white">
                                                <tr>
                                                    <th style="width: 1%;text-align:center;font-size: 15px">AÑO {{$year}}</th>
                                                    <th style="width: 1%;text-align:center;font-size: 15px">AÑO {{$year + 1}}</th>
                                                    <th style="width: 1%;text-align:center;font-size: 15px">AÑO {{$year + 2 }}</th>
                                                    <th style="width: 1%;text-align:center;font-size: 15px">AÑO {{$year + 3 }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id='str' style="font-size:18px;">
                                                @foreach($Cartera as $cartera)
                                                    <td class="text-center">{{number_format($cartera->monto_1,2)}}</td>
                                                    <td class="text-center">{{number_format($cartera->monto_2,2)}}</td>
                                                    <td class="text-center">{{number_format($cartera->monto_3,2)}}</td>
                                                    <td class="text-center">{{number_format($cartera->monto_4,2)}}</td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                @else
                                    <b>->No hay Información</b>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>