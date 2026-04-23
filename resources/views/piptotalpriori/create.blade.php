@extends('starter')
@section('htmlhead')
<style>
.nav>li{

  color:white;
}
.nav>li:hover{
  color:white;
}
</style>
@endsection
@section('body')
<div class="col-md-12 main">
    <div class="row">
        <div class="panel panel-primary">
             <div class="panel-heading" style="background-color:#3c8dbc">
                <div class="panel-title"><h2><center>CREAR PROYECTO DE INVERSION PUBLICA</center></h2></div>
            </div>
            {{ Form::open(array('action' => 'PipTotalPrioriController@store')) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">{{ Form::label('cod_unif', 'Codigo Unificado:') }}</div>
                    <div class="col-md-3">{{ Form::text('cod_unif', null, array('class' => 'form-control')) }}</div>

                    <div class="col-md-3">{{ Form::label('cod_snip', 'Codigo SNIP:') }}</div>
                    <div class="col-md-3">{{ Form::text('cod_snip', null, array('class' => 'form-control')) }}</div>
                </div>
                <div class="row">
                    <div class="col-md-3">{{ Form::label('nom_proyec', 'Nombre del Proyecto:') }}</div>
                    <div class="col-md-9">{{ Form::text('nom_proyec', null, array('class' => 'form-control')) }}</div>
                </div>
                <br>
                <div>
                    <ul class="nav nav-pills" role="tablist" style="color:white;">
                        <li role="presentation" class="active" style="background-color:#337ab7"><a href="#tecnico" aria-controls="tecnico" role="tab" data-toggle="tab">Datos Tecnicos PIP</a></li>
                        <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#tiempo" aria-controls="tiempo" role="tab" data-toggle="tab">Linea de Tiempo PIP</a></li>
                        <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#galeria" aria-controls="galeria" role="tab" data-toggle="tab">Galeria de Fotos PIP</a></li>
                        <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#ubicacion" aria-controls="ubicacion" role="tab" data-toggle="tab">Ubicacion del PIP</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tecnico">
                            <br>
                            <div class="row">
                                {{ Form::hidden('nom_dpto', 'LIMA', null) }}
                                <div class="col-md-3">{{ Form::label('cod_dpto', 'Nombre Departamento:') }}</div>
                                <div class="col-md-3">{{ Form::select('cod_dpto', $depCombo, null, array('class' => 'form-control', 'id'=>'combo1')) }}</div>

                                {{ Form::hidden('nom_prov', null, null) }}
                                <div class="col-md-3">{{ Form::label('cod_prov', 'Nombre Provincia:') }}</div>
                                <div class="col-md-3">{{ Form::select('cod_prov', $provCombo, null, array('class' => 'form-control', 'id'=>'combo2')) }}</div>
                            </div>
                            <div class="row">
                                {{ Form::hidden('nom_dist', null, null) }}
                                <div class="col-md-3">{{ Form::label('cod_dist', 'Nombre Distrito:') }}</div>
                                <div class="col-md-3">{{ Form::select('cod_dist', $disCombo, null, array('class' => 'form-control', 'id'=>'combo3')) }}</div>

                                <div class="col-md-3">{{ Form::label('nom_cp', 'Nombre Centro Poblado:') }}</div>
                                <div class="col-md-3">{{ Form::text('nom_cp', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('u_formul', 'Unidad Formuladora:') }}</div>
                                <div class="col-md-9">{{ Form::text('u_formul', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('u_ejec', 'Unidad Ejecutora:') }}</div>
                                <div class="col-md-9">{{ Form::text('u_ejec', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('ger_direc', 'Gerencia/Direccion:') }}</div>
                                <div class="col-md-9">{{ Form::text('ger_direc', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('sector', 'Sector:') }}</div>
                                <div class="col-md-3">{{ Form::text('sector', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('progr', 'Programa:') }}</div>
                                <div class="col-md-9">{{ Form::text('progr', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('sub_progr', 'Sub Programa:') }}</div>
                                <div class="col-md-9">{{ Form::text('sub_progr', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('m_pip', 'Monto PIP:') }}</div>
                                <div class="col-md-3">{{ Form::text('m_pip', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('m_viab', 'Monto Viable:') }}</div>
                                <div class="col-md-3">{{ Form::text('m_viab', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('m_exptec', 'Monto Exp. Tec.:') }}</div>
                                <div class="col-md-3">{{ Form::text('m_exptec', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <br>
                            <h4>ESTADO SITUACIONAL DEL PROYECTO</h4>
                            <br>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('etapa', 'Etapa:') }}</div>
                                <div class="col-md-3">{{ Form::select('etapa', $etaCombo, null, array('class' => 'form-control', 'id'=>'combo4')) }}</div>

                                <div class="col-md-3">{{ Form::label('sub_etapa', 'Sub Etapa:') }}</div>
                                <div class="col-md-3">{{ Form::select('sub_etapa', $subCombo, null, array('class' => 'form-control', 'id'=>'combo5')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('f_etapsub', 'Fecha Etapa:') }}</div>
                                <div class="col-md-3">{{ Form::text('f_etapsub', null, array('class' => 'form-control datepicker')) }}</div>

                                <div class="col-md-3">{{ Form::label('est_pry', 'Estado Proyecto:') }}</div>
                                <div class="col-md-3">{{ Form::text('est_pry', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('situa_pro', 'Situacion Actual:') }}</div>
                                <div class="col-md-9">{{ Form::text('situa_pro', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('anio_proye', 'Año del Proyecto:') }}</div>
                                <div class="col-md-3">{{ Form::text('anio_proye', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('tipo_pry', 'Tipo de Proyecto:') }}</div>
                                <div class="col-md-3">{{ Form::text('tipo_pry', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <br>
                            <h4>ULTIMA OBRA EN EJECUCION</h4>
                            <br>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('f_adjudica', 'Fecha Adjudicacion:') }}</div>
                                <div class="col-md-3">{{ Form::text('f_adjudica', null, array('class' => 'form-control datepicker')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('m_ejec', 'Modalidad de Ejecucion:') }}</div>
                                <div class="col-md-3">{{ Form::text('m_ejec', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('nro_contrato', 'Numero de Contrato:') }}</div>
                                <div class="col-md-3">{{ Form::text('nro_contrato', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('f_i_obra', 'Inicio de Obra:') }}</div>
                                <div class="col-md-3">{{ Form::text('f_i_obra', null, array('class' => 'form-control datepicker')) }}</div>

                                <div class="col-md-3">{{ Form::label('f_f_obra', 'Final de Obra:') }}</div>
                                <div class="col-md-3">{{ Form::text('f_f_obra', null, array('class' => 'form-control datepicker')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('cant_meta', 'Cantidad de Metas:') }}</div>
                                <div class="col-md-3">{{ Form::text('cant_meta', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('meta_actual', 'Meta actual:') }}</div>
                                <div class="col-md-3">{{ Form::text('meta_actual', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('a_fisico', 'Avance Fisico:') }}</div>
                                <div class="col-md-3">{{ Form::number('a_fisico', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('f_afisico', 'Fecha Avance Fisico:') }}</div>
                                <div class="col-md-3">{{ Form::text('f_afisico', null, array('class' => 'form-control datepicker')) }}</div>
                            </div>
                            <br>
                            <h4>DATOS ADICIONALES PRESUPUESTO PARTICIPATIVO</h4>
                            <br>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('anio_pic', 'Año del PIC:') }}</div>
                                <div class="col-md-3">{{ Form::text('anio_pic', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('mpp_pic', 'Monto Pres. Partic.:') }}</div>
                                <div class="col-md-3">{{ Form::text('mpp_pic', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('macr_pic', 'Monto Acuerdo:') }}</div>
                                <div class="col-md-3">{{ Form::text('macr_pic', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('nacuerdo_pic', 'Numero Acuerdo:') }}</div>
                                <div class="col-md-3">{{ Form::text('nacuerdo_pic', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('mpia_pic', 'Monto PIA:') }}</div>
                                <div class="col-md-3">{{ Form::text('mpia_pic', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('estado_pic', 'Estado PIC:') }}</div>
                                <div class="col-md-3">{{ Form::text('estado_pic', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('fuente', 'Fuente:') }}</div>
                                <div class="col-md-9">{{ Form::text('fuente', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <br>
                            <br>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-danger" href="{{URL::to('/piptotalpriori')}}"><span class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR</button>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="ubicacion">
                            <br>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('latitud', 'Latitud:') }}</div>
                                <div class="col-md-3">{{ Form::text('latitud', null, array('class' => 'form-control')) }}</div>

                                <div class="col-md-3">{{ Form::label('longitud', 'Longitud:') }}</div>
                                <div class="col-md-3">{{ Form::text('longitud', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{{ Form::label('ubigeo', 'Ubigeo:') }}</div>
                                <div class="col-md-3">{{ Form::text('ubigeo', null, array('class' => 'form-control')) }}</div>
                            </div>
                            <br>
                            <br>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-danger" href="{{URL::to('/piptotalpriori')}}"><span class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div role="tabpanel" class="tab-pane" id="galeria">
                            <br>
                            <input type=hidden id="uid" name="uid" value=""/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="jumbotron how-to-create">
                                        <div class="col-md-4"><input type="radio" name="tipo" value="antes" checked> ANTES<br></div>
                                        <div class="col-md-4"><input type="radio" name="tipo" value="durante"> DURANTE<br></div>
                                        <div class="col-md-4"><input type="radio" name="tipo" value="despues"> DESPUES<br></div>

                                        <br/>
                                        <h3><span id="counter"></span></h3>

                                        {!! Form::open(['action' => 'ImageController@postUpload', 'class' => 'dropzone', 'files'=>true, 'id'=>'dzone']) !!}

                                        <div class="dz-message">

                                        </div>

                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <div class="dropzone-previews" id="dropzonePreviewAntes"></div>

                                        <h4 style="text-align: center;color:#428bca;">Arrastra las imagenes a esta área  <span class="glyphicon glyphicon-open-file"></span></h4>

                                        <button id="submit-all">Guardar</button>
                                        {!! Form::close() !!}
                                        <label>Fecha de toma de las imagenes anexadas</label>
                                        <br />
                                        <input style='z-index:999999' type=text id="fecha" name="fecha"class="datepicker" />
                                        <div id = 'message'></div>

                                    </div>

                                </div>
                            </div>

                            <!-- Dropzone Preview Template -->
                            <div id="preview-template" style="display: none;">

                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-image"><img data-dz-thumbnail=""></div>
                                    <input type="hidden" class="serverfilename"/>

                                    <div class="dz-details">
                                        <div class="dz-size"><span data-dz-size=""></span></div>
                                        <div class="dz-filename"><span data-dz-name=""></span></div>
                                    </div>
                                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                                    <div class="dz-error-message"><span data-dz-errormessage=""></span></div>

                                    <div class="dz-success-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>Check</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                        </g>
                                        </svg>
                                    </div>

                                    <div class="dz-error-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>error</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                        <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                        </g>
                                        </g>
                                        </svg>
                                    </div>

                                </div>
                            </div>
                            <!-- End Dropzone Preview Template -->

                            <!-- BOXES -->

                            <h3>ANTES</h3><span id="foto_antes"></span>

                            <div id="antes"></div>
                            <h3>DURANTE</h3><span id="foto_durante"></span>

                            <div id="durante"></div>

                            <h3>DESPUES</h3><span id="foto_despues"></span>

                            <div id="despues"></div>

                        </div>

                    </div>
                </div>
                <script>
                    $('#myTabs a').click(function (e) {
                        e.preventDefault()
                        $(this).tab('show')
                    })
                </script>
                <script>
                    $(".datepicker").datepicker({
                        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
                        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        dateFormat: "dd-mm-yy"
                    });
                </script>
                @if(Session::get('mensaje_error'))
                <div class="alert alert-danger">{!!Session::get('mensaje_error')!!}</div>
                @endif
                @if(Session::get('mensaje_exito'))
                <div class="alert alert-success">{!!Session::get('mensaje_exito')!!}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#combo2").change(function () {
            comboUno();
        });
        $("#combo4").change(function () {
            comboDos();
        });
    });

    function comboUno() {
        $("#combo2 option:selected").each(function () {
            var id = $(this).val();
            if (id == "")
                id = 0;
            $.ajax({
                url: "{{URL::to('/piptotalpriori/combodistrito')}}/"+id,
                success: function (data)
                {
                    $("#combo3").html(data);
                }
            });
        });
    }

    function comboDos() {
        $("#combo4 option:selected").each(function () {
            var id = $(this).val();
            if (id == "")
                id = 0;
            $.ajax({
                url: "{{URL::to('/piptotalpriori/combosubetapa')}}/"+id,
                success: function (data)
                {
                    $("#combo5").html(data);
                }
            });
        });
    }
</script>
{!! HTML::script('/librerias/dropzone/dropzone.js') !!}
{!! HTML::script('/assets/js/dropzone-config-2.js') !!}

<script>
    $(function(){
        $('#date').change(function(){
            if($('#date').val() == ''){

            }
        })
    });
</script>

@stop
