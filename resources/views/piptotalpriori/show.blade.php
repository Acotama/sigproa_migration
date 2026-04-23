<span class="cabecera">
    <div>
    @if($data['tipo_pry'] == 'PIC')
        <h4 class="text-center"><b>PROYECTO DE INVERSIÓN CONCERTADO</b></h4>
    @else
        <h4 class="text-center"><b>PROYECTO DE INVERSIÓN PÚBLICA</b></h4>
    @endif
    </div>
</span>

<div id="container" class="container-fluid">
  <style></style>
<div class="col-md-12 main">
    <div class="row">
        <div class="panel">
            <div class="modal-body">
                <div class="row">
                  <div class="form-group  pull-left">
                    <div class="col-md-12">
                      <div class="col-md-6"><label for="cod_unif">Codigo Unificado:</label></div>
                      <div class="col-md-6"><b style="font-size:16px"><label for="cod_unif">{{ $data['cod_unif'] }}</label></b></div>
                    </div>
                  </div>
                  <div class="form-group pull-right">
                    <div class="col-md-12">
                      <div class="col-md-6"><label for="cod_snip">Codigo SNIP:</label></div>
                      <div class="col-md-6"><b style="font-size:16px"><a href="http://ofi4.mef.gob.pe/bp/ConsultarPIP/frmConsultarPIP.asp?accion=consultar&txtCodigo={!! $data['cod_snip'] !!}" target="_blank"><label for="cod_snip">{{ $data['cod_snip'] }}</label></a></b></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="color:black;"><b style="font-size:22px" class="text-center"><label>{{ $data['nom_proyec'] }}</label></b></div>
                </div>
                <div class="row col-md-12">
                    <ul class="nav nav-pills" role="tablist" style="color:white;">
                        <li role="presentation" class="active" style="background-color:#337ab7"><a href="#tecnico" aria-controls="tecnico" role="tab" data-toggle="tab">Datos Técnicos PIP</a></li>
                        <!--<li role="presentation" style="background-color:#337ab7;color:white;"><a href="#tiempo" id="tabLinea" onclick="cargarPdf();" aria-controls="tiempo" role="tab" data-toggle="tab">Linea de Tiempo PIP</a></li>-->
                        <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#galeria" id="tabGaleria" onclick="cargarImg({{ $data['id'] }});" aria-controls="galeria" role="tab" data-toggle="tab">Galeria de Fotos PIP</a></li>
                        <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#ubicacion" id="tabUbicacion" aria-controls="ubicacion" role="tab" data-toggle="tab">Ubicación del PIP</a></li>
                    </ul>
                    <?php //if(Auth::user()->ability('xcxcv',array('image-upload'),$options = array('validate_all' => true))){ echo("disabled");} ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tecnico">
                              <input type=hidden id="id" name="id" value="{{ $data['id'] }}"/>
                              <input type="hidden" name="idusuario" value="{{ Auth::user()->idusuario }}">
                              <h4><b>DATOS GENERALES</b></h4>
                              <div class="row">
                                  <div class="col-md-4">
                                    <label for="sector">Sector:</label>
                                    <input type="text" name="sector" class="form-control" value="{{ $data->sector }}" readonly>
                                  </div>
                                  <div class="col-md-4">
                                    <label for="progr">Programa:</label>
                                    <input type="text" name="progr" class="form-control" value="{{ $data->progr }}" readonly>
                                  </div>
                                  <div class="col-md-4">
                                    <label for="sub_progr">Sub Programa:</label>
                                    <input type="text" name="sub_progr" class="form-control" value="{{ $data->sub_progr }}" readonly>
                                  </div>
                              </div>
                              <br>
                              <div class="row">
                                  <div class="col-md-4">
                                      <label for="u_formul">Unidad Formuladora:</label>
                                      <textarea name="u_formul" class="form-control" readonly rows="2" readonly>{{  $data->u_formul }}</textarea>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="u_ejec">Unidad Ejecutora:</label>
                                      <input type="text" name="u_ejec" class="form-control" value="{{ $data->u_ejec }}" readonly>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="ger_direc">Gerencia/Direccion:</label>
                                      <textarea name="ger_direc" class="form-control" rows="2" readonly>{{  $data->ger_direc }}</textarea>
                                  </div>
                              </div><br>
                              <div class="row">
                                  <input type="hidden" name="nom_dpto">
                                  <input type="hidden" name="cod_dpto">
                                  <div class="col-md-4">
                                    <label for="cod_dpto">Nombre Departamento:</label>
                                    <label class="form-control" readonly>LIMA</label>
                                  </div>
                                    <input type="hidden" name="nom_prov">
                                    <input type="hidden" name="cod_prov">
                                  <div class="col-md-4">
                                      <label for="cod_prov">Nombre Provincia:</label>
                                      <input type="text" name="nom_prov" class="form-control" value="{{ $data->nom_prov }}" readonly>
                                  </div>
                                  <input type="hidden" name="nom_dist">
                                  <input type="hidden" name="cod_dist">
                                  <div class="col-md-4">
                                    <label for="cod_dist">Nombre Distrito:</label>
                                    <input type="text" name="nom_dist" class="form-control" value="{{ $data->nom_dist }}" readonly>
                                  </div>
                              </div><br>
                              <div class="row">
                                  <div class="col-sm-12 col-md-12 col-lg-8">
                                      <label for="nom_cp">Nombre Centro Poblado:</label>
                                      <input type="text" name="nom_cp" class="form-control" value="{{ $data->nom_cp }}" readonly>
                                  </div>
                              </div>
                              @php
                                $year= date("Y");
                              @endphp
                              <h4><b>DATOS FINANCIEROS</b></h4>
                              <h5><b>Actualizado al: {{ $data['f_deveng_a'] }}</b></h5>
                              <div class="row">
                                  <div class="col-md-4">
                                    <label for="m_pip">Monto de Inversión Total:</label>
                                    <label class="form-control" >{{number_format($data['m_pip'],2)}}</label>
                                  </div>
                                  <div class="col-md-4">
                                    <label for="m_viab">Monto Viable:</label>
                                    <label class="form-control" >{{number_format($data['m_viab'],2)}}</label>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="m_exptec">Monto Exp. Tec.:</label>
                                      <label class="form-control" >{{number_format($data['m_exptec'],2)}}</label>
                                  </div>
                              </div>
                              <div class="row col-md-12">
                                <div class="table table-responsive">
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
                                                  <td style="text-align: right">{{ $if['uni_ejec'] }}</td>
                                                  <td style="text-align: center">{{ $if['anio_financ'] }}</td>
                                                  <td style="text-align: center">{{ number_format($if['pia'],2) }}</td>
                                                  <td style="text-align: center">{{ number_format($if['pim'],2) }}</td>
                                                  <td style="text-align: center">{{ number_format($if['certif'],2) }}</td>
                                                  <td style="text-align: center">{{ number_format($if['dev'],2) }}</td>
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
                              @if(count($Fuente_financiamiento) > 0 )
                                <h4><b>FUENTE DE FINANCIAMIENTO {{ $year }}</b></h4>
                                <div class="row col-md-12">
                                  <div class="table table-responsive">
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
                              @endif
                              @if(count($Avance) > 0 )
                                <h4><b>SEGUIMIENTO DE INVERSIONES {{$year}} <a target="_blank" href="https://ofi5.mef.gob.pe/invierte/seguimiento/verFichaSeguimiento/{!! $data['cod_unif'] !!}">(FORMATO 12-B)</a></b></h4>
                                <div class="row col-md-12">
                                  <div class="table table-responsive">
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
                                        @if(!empty($formato12b))
                                            <b> Actualizado al: {{$formato12b->fecha_actual}}</b> 
                                        @endif
                                    </table>
                                  </div>
                                  
                                </div>
                                
                              @endif
                              @if(count($Cartera) > 0 )
                                <h4><b>PROGRAMACIÓN MULTIANUAL DE INVERSIONES</b></h4>
                                <div class="row col-md-12">
                                  <div class="table table-responsive">
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
                              @endif
                              @if(count($Obras) > 0 )
                                <h4><b>DATOS DE EJECUCIÓN</b></h4>
                                  @if(!empty($formato12b))
                                      {{-- <h5><b>Actualizado al: {{ $data['f_deveng_a'] }}</b></h5> --}}
                                      <div class="col-md-12">
                                          <div class="table table-responsive">
                                              <table id="strip" style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 13px;white-space:nowrap" border="1" >
                                                  <thead style="background-color:#337ab7;color:white">
                                                      <tr>
                                                          <th colspan="2" style="width: 1%;text-align:center;font-size: 15px;background-color: #337ab7;">FECHA DE LA EJECUCIÓN FÍSICA</th>
                                                          <th colspan="2" style="width: 1%;text-align:center;font-size: 15px;background-color: #337ab7;">AVANCE</th>
                                                      </tr>
                                                      <tr>
                                                          <th style="width: 1%;text-align:center;font-size: 15px;background-color: #337ab7;">INICIO</th>
                                                          <th style="width: 1%;text-align:center;font-size: 15px;background-color: #337ab7;">CULMINACION</th>
                                                          <th style="width: 1%;text-align:center;font-size: 15px;background-color: #337ab7;">EJECUCIÓN DE LA INVERSIÓN</th>
                                                          <th style="width: 1%;text-align:center;font-size: 15px;background-color: #337ab7;">EJECUCIÓN FÍSICA DE LA INVERSIÓN</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id='str' style="font-size:15px;">
                                                      <tr>
                                                          <td  class="text-center">{{ $formato12b->fec_ini_ejec }}</td>
                                                          <td  class="text-center">{{ $formato12b->fec_fin_ejec }}</td>
                                                          <td  class="text-center">{{ number_format($formato12b->avance_ejecucion,2) }}%</td>
                                                          <td  class="text-center">{{ number_format($formato12b->avance_fisico,2) }}%</td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                          <h5><b>SITUACIÓN DEL PROYECTO</b></h5>
                                          <div class="form-group">
                                              <textarea  readonly class="form-control">{{ $formato12b->ult_est_situal }}</textarea readonly>
                                          </div>
                                      </div>
                                  @endif

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
                                              <label>Situación de la Meta Actual </label>
                                              <textarea readonly class="form-control">{{trim($obra->est_situ)}}</textarea readonly>
                                          </div>
                                      </div>
                                      </div>
                                  @endforeach
                              @else
                                  <h4><b>ESTADO SITUACIONAL DEL PROYECTO</b></h4>
                                  <div class="row">
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="est_pry">'Estado Proyecto:</label>
                                          <input type="text" name="est_pry" class="form-control" value="{{ $data->est_pry }}" readonly disabled>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="tipo_pry">Tipo de Proyecto:</label>
                                          <input type="text" name="tipo_pry" class="form-control" value="{{ $data->tipo_pry }}" readonly>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etapa">Etapa:</label>
                                          <input type="text" name="etapa" class="form-control" value="{{ $data->etapa }}" readonly>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                          <div class="form-group">
                                            <label for="sub_etapa">Sub Etapa:</label>
                                            <input type="text" name="sub_etapa" class="form-control" value="{{ $data->sub_etapa }}" readonly>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="situa_pro">Situacion Actual:</label>
                                              <textarea name="situa_pro" class="form-control" rows="4" readonly id="situa_pro">{{  $data->situa_pro }}</textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                          <div class="form-group">
                                              <label for="f_etapsub">Fecha actualización de estado situacional:</label>
                                              <input type="text" name="f_etapsub" class="form-control" value="{{ $data->f_etapsub }}" readonly>
                                          </div>
                                      </div>
                                  </div>
                              @endif
                              @if(count($consulta_contrataciones) > 0 )
                                <h4><b>CONTRATACIONES</b></h4>
                                <div class="row">
                                  <div class="col-sm-12">
                                      @php
                                          $total_nprocesos = 0;
                                          $total_valorrf = 0;
                                      @endphp
                                      <div class="table table-bordered table-responsive">
                                          <table class="table table-bordered " id="t_contrataciones" cellspacing="0" class="form-control">
                                              <thead>
                                                  <tr>
                                                      <th style="text-align:center" width="20%" >DESCRIPCIÓN DE PROCESO</th>
                                                      <th style="text-align:center" width="20%" >DESCRIPCIÓN DE ITEM</th>
                                                      <th style="text-align:center" >TIPO CONTRATACIÓN</th>
                                                      <th style="text-align:center" >FECHA DE CONVOCATORIA</th>
                                                      <th style="text-align:center" >ESTADO</th>
                                                      <th style="text-align:center" >S/. VALOR REFERENCIAL</th>
                                                      <th style="text-align:center" >TIPO DE PROCESO</th>
                                                      <th style="text-align:center" >NOMENCLATURA</th>
                                                  </tr>
                                              </thead>
                                              <tbody >
                                                  @foreach($consulta_contrataciones as $row)
                                                      @php 
                                                          $total_nprocesos += 1;
                                                          $total_valorrf += $row->valor_refer; 
                                                      @endphp
                                                      <tr>
                                                          <td style='text-align:center;vertical-align: middle' width='20%'>{{ $row->des_proceso }}</td>
                                                          <td style='text-align:center;vertical-align: middle' width='20%'>{{ $row->des_item }}</td>
                                                          <td style='text-align:center;vertical-align: middle'>{{ $row->objeto_contratac }}</td>
                                                          <td style='text-align:center;vertical-align: middle'>{{ $row->fec_convocatoria }}</td>
                                                          <td style='text-align:center;vertical-align: middle'>{{ $row->estado }}</td>
                                                          <td style='text-align:center;vertical-align: middle'>{{ number_format($row->valor_refer,0,'.',',') }}</td>
                                                          <td style='text-align:center;vertical-align: middle'>{{ $row->tipo_proceso }}</td>
                                                          <td style='text-align:center;vertical-align: middle'>{{ $row->nomenclatura }}</td>
                                                      </tr>
                                                  @endforeach
                                              </tbody>
                                              <tfoot>
                                                  <tr  style="background-color:#72ca70c7">
                                                      <th style='text-align:left' colspan='5'>GOBIERNO REGIONAL DE LIMA -- TOTAL DE CONTRATACIONES = {{ $total_nprocesos }}</th>
                                                      <th style='text-align:center'>{{ number_format($total_valorrf,0,'.',',') }}</th>
                                                      <th></th>
                                                      <th></th>
                                                  </tr>
                                              </tfoot>
                                          </table>
                                      </div>
                                  </div>
                                </div>
                              @endif
                              @if($data['tipo_pry'] == 'PIC')
                                  <h4><b>DATOS ADICIONALES PRESUPUESTO PARTICIPATIVO</b></h4>
                                  <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              {{ Form::label('anio_pic', 'Año del PIC:') }}
                                              {{ Form::text('anio_pic', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              {{ Form::label('mpp_pic', 'Monto Pres. Partic.:') }}
                                              {{ Form::text('mpp_pic', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              {{ Form::label('macr_pic', 'Monto Acuerdo:') }}
                                              {{ Form::text('macr_pic', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              {{ Form::label('nacuerdo_pic', 'Numero Acuerdo:') }}
                                              {{ Form::text('nacuerdo_pic', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              {{ Form::label('mpia_pic', 'Monto PIA:') }}
                                              {{ Form::text('mpia_pic', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
                                          </div>
                                      </div>
                                  </div>
                              @endif
                              <div class="modal-footer">
                                  <h6><label for="fuente">Fuente:</label> <label for="fuente">{{ $data['fuente'] }}</label></h6>
                              </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="ubicacion">
                            <form id="frm_location" class="ubicacion" method="POST">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <div class="form-group">
                                                <!-- <span class="input-group-addon"> <label for="cod_prov">Ubigeo:</label></span>
                                                <div><input type="text" name="cod_prov" class="form-control" readonly disabled id="ubigeo" value="{{ $data->cod_prov }}"></div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                                  <input type="text" readonly="readonly" class="form-control col-md-12" id="pac-input" placeholder="Busqueda en mapa"/>
                                              </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="latitud">Latitud</label>
                                                <input type="text" name="latitud" class="form-control" readonly disabled id="lat"  value="{{ $data->latitud }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="longitud">Longitud</label>
                                                <input type="text" name="longitud" class="form-control" readonly disabled id="lon" value="{{ $data->longitud }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mapContainer col-md-offset-1 col-md-10">
                                        <div class="row">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </form>
                            <br>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="galeria">
                            <!-- BOXES -->
                            <div id="imgPorEjecucion">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  //AJAX REQUEST ON IMAGE UPLOAD ->
  cargarImg = function(id){
      $.get('/getServer-images2/' + id, function(data) {

        html = "";
        $.each(data.imgObras, function($i,$k){

          var lbltipo = "";

          switch($k.tipo){
            case 'E':
              lbltipo = " <i><label class='label label-success'>Ejecución Integral</label></i>";
            break;
            case 'S':
              lbltipo = " <i><label class='label label-warning'>Saldo de Obra</label></i>";
            break;
            case 'M':
              lbltipo = " <i><label class='label label-primary'>Meta</label></i>";
            break;
          }

          html += `
                    <br>
                    <div class="container-fluid">
                      <div class="row">
                        <h4><b>`+$k.nom_proyec +lbltipo+`</b></h4>
                  `;

          if( $k.img.length > 0 ) {
            $.each($k.img, function($in,$r){

              html += `
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#`+$r.img[0].fecha+`">
                        <i class="glyphicon glyphicon-play"></i> <b>`+$r.img[0].tiempo+ `( <i>`+$r.fecha +`</i> )</b>
                      </a>
                    </h4>
                  </div>
                  <div id="`+$r.img[0].fecha+`" class="panel-collapse collapse">
                    <div class="panel-body">`;

                    $.each($r.img, function($x,$y){

                        var imgUrl = '/' + $y.url + $y.nombre;

                      html += `
                              <a href="#">
                                <img width="180px" height="180px" src="`+imgUrl+`">
                              </a>
                          `;
                    });


              html += `
                    </div>
                  </div>
                </div>
              </div>`;


            });
          } else {
            html += '<b><i>No se encontraron fotografías registradas</b></i>';
          }

          html += `
                        </div>
                      </div>
                  `;
        });

        var porAsignarHtml = '';

        if ( data.imgPorAsignar.length === 0 ) {
          porAsignarHtml = '<b><i>No se encontraron fotografías registradas</b></i>';
        }

        $.each(data.imgPorAsignar, function($i,$k){
              porAsignarHtml += `
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#`+$k.img[0].fecha+`">
                        <i class="glyphicon glyphicon-play"></i> <b>`+$k.img[0].tiempo+ `( <i>`+$k.fecha +`</i> )</b>
                      </a>
                      <button type="button" class="btn btn-primary btn-xs" onclick="loadfrmEditImage(`+$k.img[0].idproyecto+`,`+$k.img[0].idobra+`,'`+$k.img[0].fecha+`','`+$k.img[0].tiempo+`')"><i class="fa fa-edit"></i></button>
                    </h4>
                  </div>
                  <div id="`+$k.img[0].fecha+`" class="panel-collapse collapse">
                    <div class="panel-body">`;
                    $.each($k.img, function($x,$y){

                      var imgUrl = '/' + $y.url + $y.nombre;

                      porAsignarHtml += `
                              <a href="#">
                                <img width="180px" height="180px" src="`+imgUrl+`">
                              </a>
                          `;
                    });
              porAsignarHtml += `
                    </div>
                  </div>
                </div>
              </div>`;

        });

        porAsignarHtml = `
              <br>
              <div class="container-fluid">
                <div class="row">
                  <p><b>FOTOGRAFÍAS NO RELACIONADAS A UNA OBRA/ACTIVIDAD</b></p>
                  `+porAsignarHtml+`
                </div>
              </div>
            `;

        $(".modal-scrollable #imgPorEjecucion").html(html+porAsignarHtml);

      }).fail(function() {
          console.log("Falló obtener lista de fotos");
      });
  };
</script>
<!-- ========================================= LIBS ======================================= -->
<!--script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBea_vgTFolz7EGBG32BaUeR0FvFJbpdrQ&libraries=places&callback=initMap"></script-->
</div>

<div class="pie">
  <script type="text/javascript">
    $(function(){
      tabla=function(){
        var table = $('#contrato').DataTable({
            scrollY:        "400px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            autoWidth:      true,
            searching:      false,
            ordering:       false,
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
          $('#container').css( 'display', 'block' );
          setTimeout(function() {
              table.columns.adjust().draw();
           }, 1000);
      }
      tabla();

       tablac=function(id,orden,panel,titulo,columnas){
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
            setTimeout(function () {
                $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
            },200);
        }

        tablac("#t_contrataciones",'',"CONTRATACIONES","CONTRATACIONES",[0,1,2,3,4,5,6,7]);
    });
  </script>
</div>
