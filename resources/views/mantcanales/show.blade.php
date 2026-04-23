<span class="cabecera">
    <div>
    @if($data['tipo_pry'] == 'PIC')
        <h3 class="text-center"><b>PROYECTO DE INVERSIÓN CONCERTADO</b></h3>
    @else
        <h3 class="text-center"><b>PROYECTO DE INVERSIÓN PÚBLICA</b></h3>
    @endif
    </div>
</span>

<div id="container" class="container-fluid">

    <input type=hidden id="uid" name="uid" value="{{ $data['cod_unif'] }}"/>
    <div class="row">
        <div class="col-md-2">{{ Form::label('cod_unif', 'Codigo Unificado:') }}</div>
        <div class="col-md-4"><b style="font-size:16px">{{ Form::label('', $data['cod_unif']) }}</b></div>

        <div class="col-md-2">{{ Form::label('cod_snip', 'Codigo SNIP:') }}</div>
        <div class="col-md-4"><b style="font-size:16px">{{ Form::label('', $data['cod_snip']) }}</b></div>
    </div>
    <div class="row">
        <div class="col-md-2">{{ Form::label('nom_proyec', 'Nombre del Proyecto:') }}</div>
        <div class="col-md-10"><b style="font-size:22px" class="text-center">{{ Form::label('', $data['nom_proyec']) }}</b></div>
    </div>
    <div>
        <ul class="nav nav-pills" role="tablist" style="color:white;">
            <li role="presentation" class="active" style="background-color:#337ab7"><a href="#tecnico" aria-controls="tecnico" role="tab" data-toggle="tab">Datos Tecnicos PIP</a></li>
            <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#galeria" onclick="cargarImg();" aria-controls="galeria" role="tab" data-toggle="tab">Galeria de Fotos PIP</a></li>
            <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#ubicacion" id="tabUbicacion" aria-controls="ubicacion" role="tab" data-toggle="tab">Ubicacion del PIP</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tecnico">
                <br>
                <div class="row">

                            <table class="table table-hover table-bordered" style="border-color: black;" border="1">
                                <tbody>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Estado del Proyecto</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" class="words" >{{ $data['est_pry'] }}</td>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Año del Proyecto</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" class="words">{{ $data['anio_ini_pry'] }}</td>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Tipo de Proyecto</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" class="words">{{ $data['tipo_pry'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Departamento</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" class="words" >LIMA</td>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Provincia</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" class="words">{{ $data['nom_prov'] }}</td>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Distrito</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" class="words">{{ $data['nom_dist'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Centro Poblado</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" colspan="5" class="words">{{ $data['nom_cp'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Unidad Formuladora</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" colspan="5" class="words" >{{ $data['u_formul'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Unidad Ejecutora</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" colspan="5" class="words">{{ $data['u_ejec'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Gerencia / Dirección</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" colspan="5" class="words">{{ $data['ger_direc'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Sector</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" colspan="5" class="words" >{{ $data['sector'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Programa</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" colspan="5" class="words">{{ $data['progr'] }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Sub Programa</td>
                                    <td style="background-color: #fdffb1;vertical-align:middle;" width="10%" colspan="5" class="words">{{ $data['sub_progr'] }}</td>
                                </tr>
                                </tbody>
                            </table>

                </div>

                <br><h3><b>DATOS FINANCIEROS</b></h3>
                <div class="row">
                    <table class="table table-hover table-bordered" >
                        <tbody>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Actualizado al</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" colspan="5" width="30%" class="words" >{{ $data['f_deveng_a'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Monto PIP</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" colspan="2" width="30%" class="words" >{{ number_format($data['m_pip'],2) }}</td>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Monto Viable</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" colspan="2" width="30%" class="words">{{ number_format($data['m_viab'],2) }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Monto Exp. Técnico</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" colspan="5" width="30%" class="words">{{ number_format($data['m_exptec'],2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="row">
                    <div class=" col-md-8 table-responsive">
                        <table id="strip" style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 14px;white-space:nowrap" border="1" >
                            <thead style="background-color:#337ab7;color:white">
                            <tr>
                                <th style="width: 1%;text-align:center;font-size: 15px">AÑO</th>
                                <th style="width: 1%;text-align:center;font-size: 15px">PIM</th>
                                <th style="width: 1%;text-align:center;font-size: 15px">PIM ACUMULADO</th>
                                <th style="width: 1%;text-align:center;font-size: 15px">DEVENGADO</th>
                                <th style="width: 1%;text-align:center;font-size: 15px">DEV. ACUMULADO</th>
                                <th style="width: 1%;text-align:center;font-size: 15px">AVANCE FINANCIERO</th>
                            </tr>
                            </thead>
                            <tbody id='str' style="font-size:18px;">
                            <tr>
                                <td style="white-space: nowrap;"><?php $ex = @explode('-',$data['f_deveng_a']);echo @$ex[2] ?></td>
                                <td style="white-space: nowrap;">{{ number_format($data['m_pim'],2) }}</td>
                                <td style="white-space: nowrap;">{{ number_format($data['m_pim_acu'],2) }}</td>
                                <td style="white-space: nowrap;">{{ number_format($data['m_deveng'],2) }}</td>
                                <td style="white-space: nowrap;">{{ number_format($data['m_deveng_a'],2) }}</td>
                                <td style="white-space: nowrap;">{{ number_format($data['a_financ'],2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4"><br>
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#m_infFin"><i class="fa fa-files-o"></i> Detalle</button>
                    </div>
                </div>

                <!-- Modal -->
                <!-- Large modal -->

                <div id="m_infFin" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3>Información Financiera</h3>
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
                            @foreach($infFinanciera as $if)
                                <tr>
                                    <td>{{ $if['uni_ejec'] }}</td>
                                    <td>{{ $if['anio_financ'] }}</td>
                                    <td>{{ number_format($if['pia'],2) }}</td>
                                    <td>{{ number_format($if['pim'],2) }}</td>
                                    <td>{{ number_format($if['certif'],2) }}</td>
                                    <td>{{ number_format($if['dev'],2) }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

                <br>
                <h3><b>ESTADO SITUACIONAL DEL PROYECTO</b></h3>
                <br>
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Fecha actualización de estado situacional</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" colspan="5" class="words">{{ $data['f_etapsub'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" style="vertical-align:middle;" width="20%">Estado antiguedad del proyecto</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="20%" colspan="5" class="words">{{ $data['estado_antiguedad_pry'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Etapa</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['etapa'] }}</td>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Sub Etapa</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['sub_etapa'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Situación Actual</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" colspan="4" width="80%" class="words">{{ $data['situa_pro'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                <br>
                <h3><b>DATOS DE OBRA EN EJECUCIÓN</b></h3>
                <br>
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Fecha de adjudicación</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" colspan="5" width="30%" class="words">{{ $data['f_adjudica'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Cantidad de Metas</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['cant_meta'] }}</td>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Meta Actual</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['meta_actual'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Modalidad de Ejecución</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['m_ejec'] }}</td>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" style="vertical-align:middle;" width="20%">Número de contrato</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="20%" class="words">{{ $data['nro_contrato'] }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table table-hover table-bordered" >
                        <tbody>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Inio de obra</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['f_i_obra'] }}</td>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Final de obra</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['f_f_obra'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Fecha reinico de obra</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['fech_reinicio_obra'] }}</td>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Nueva fecha de termino</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['nuev_fech_termino'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Avance Fisico</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['a_fisico'] }}</td>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Fecha de actualizacion de avance fisico</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['f_afisico'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Ultimo año de ejecución de la obra</td>
                            <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['ult_anio_ejec_pry'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                <br>
                @if($data['tipo_pry'] == 'PIC')
                    <h3><b>DATOS ADICIONALES PRESUPUESTO PARTICIPATIVO</b></h3>
                    <br>

                    <div class="row">
                        <table class="table table-hover table-bordered">
                            <tbody>
                            <tr>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Año del PIC</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['anio_pic'] }}</td>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" style="vertical-align:middle;" width="20%">Monto Presupuesto Participativo</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" width="20%" class="words">{{ $data['mpp_pic'] }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Monto Acuerdo</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['macr_pic'] }}</td>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Numero Acuerdo</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" colspan="2" width="30%" class="words">{{ $data['nacuerdo_pic'] }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Monto PIA</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['mpia_pic'] }}</td>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Estado PIC</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" colspan="2" width="30%" class="words">{{ $data['estado_pic'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div><br>
                @endif
                             
            </div>
            <div role="tabpanel" class="tab-pane" id="ubicacion">
                    <br>
                    <div class="row">
                        <table class="table table-hover table-bordered">
                            <tbody>
                            <tr>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Ubigeo</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['cod_prov'] }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Latitud</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" width="30%" class="words">{{ $data['latitud'] }}</td>
                                <td style="vertical-align:middle;" class="bg-primary headwords text-center" width="20%">Longitud</td>
                                <td style="background-color: #fdffb1;vertical-align:middle;" colspan="2" width="30%" class="words">{{ $data['longitud'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="mapContainer col-md-offset-1 col-md-10">
                            <div class="row">
                                <div id="map"></div>
                            </div>

                        </div>
                    </div>
            </div>



            <div role="tabpanel" class="tab-pane" id="galeria">

                <!-- BOXES -->
                <h3>ANTES</h3><span id="foto_antes"></span>
                <div id="antes"></div>

                <h3>DURANTE</h3><span id="foto_durante"></span>
                <div id="durante"></div>

                <h3>DESPUES</h3><span id="foto_despues"></span>
                <div id="despues"></div>

            </div>


            <script>
                //AJAX REQUEST ON IMAGE UPLOAD ->
                cargarImg = function(){
                    uid = document.getElementById('uid').value;
                    $.get('/server-images/' + uid.toString(), function(data) {
                        $('#antes').html('');
                        $('#durante').html('');
                        $('#despues').html('');


                        if(data.antes.length != 0){
                            $.each(data.antes, function (key, value) {

                                url = value.url;
                                $('#antes').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>');

                                //$('#antes').append('<img class=\'fancybox\' src=\''+ url +'\'  data-big=\' '+ url +' \' style=\'border-width:0px;width:280px; height:280px;\'>');
                                $('#foto_antes').text(' Fecha: ' + value.fecha);
                            });

                        } else {
                            $('#antes').append('<h4>No hay imagenes disponibles</h4>');
                        }

                        if(data.durante.length != 0){

                            $.each(data.durante, function (key, value) {
                                url = value.url;
                                $('#durante').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>');
                                $('#foto_durante').text(' Fecha: ' + value.fecha);
                            });
                        } else {
                            $('#durante').append('<h4>No hay imagenes disponibles</h4>');
                        }

                        if(data.despues !=''){
                            $.each(data.despues, function (key, value) {

                                url = value.url;
                                $('#despues').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>&nbsp;&nbsp');
                                $('#foto_despues').text(' Fecha: ' + value.fecha);
                            });
                        } else {
                            $('#despues').append('<h4>No hay imagenes disponibles</h4>');
                        }
                    });
                };



                $(function(){
                    $.fn.modalmanager.defaults.resize = true;
                    cargarImg();

                    //============================================= GALERIA ====================================
                    $('#tabGaleria').click(cargarImg());
                    //FANCYBOX INIT
                    $(".fancybox").fancybox();
                });
            </script>

        </div>
    </div>





</div>


<div class="pie">

</div>




