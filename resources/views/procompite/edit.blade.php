@extends('starter')
@section('htmlhead')
<style>

/*REWRITING TEXTBOX STYLES */
/* TEXTBOX */

.form-control , .input-group-addon{
  border-color: black !important;
}
/*******************************/
    .panel{
        background-color: rgb(209,227,243);
    }
  #map {
    width:90%;
    height:400px !important;
  }
  .nav>li{
     color:white;
  }
  .nav>li:hover{
     color:white;
  }

  .disabled {
      pointer-events:none;
  opacity:0.6;
  }

  table tr:nth-child(even) {background-color: rgb(216,206,88);}

</style>


@endsection
@section('body')
    <?php
    set_time_limit(600000);
    ?>
<div class="col-md-12 main">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading" style="background-color:#3c8dbc">
                <div class="panel-title"><h2><center>ACTUALIZAR ACTIVIDAD DE MANTENIMIENTO DE VÍAS</center></h2></div>
            </div>

            <div class="modal-body">
              @if(Session::has('mensaje_error'))
              <div class="alert alert-danger">{!!Session::get('mensaje_error')!!}</div>
              <script>
                  swal(
                    'Error al guardar la información',
                    'Revise los errores en la parte superior del formulario!',
                    'error'
                  );
              </script>


              @endif
              @if(Session::has('mensaje_exito'))
              <div class="alert alert-success">{!!Session::get('mensaje_exito')!!}</div>
              <script>
                  swal(
                    'Actualizado',
                    'Los cambios se guardaron exitosamente!',
                    'success'
                  );
              </script>
              @endif
                <div class="row">
                    <div class="col-md-2">{{ Form::label('activ', 'Nombre de actividad:') }}</div>
                    <div class="col-md-8"><b style="font-size:22px" class="text-center">{{ Form::label('', $data['activ']) }}</b></div>
                    <!--div class="col-md-10">{{ Form::text('activ', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}</div-->
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ Form::label('anio', 'Año:') }}</span>
                                    {{ Form::text('anio', null, array('class' => 'form-control')) }}
                                </div>
                            </div>
                        </div><br>
                    </div>
                </div>
                <br>
                <div>
                    <ul class="nav nav-pills" role="tablist" style="color:white;">
                        <li role="presentation" class="active" style="background-color:#337ab7"><a href="#tecnico" aria-controls="tecnico" role="tab" data-toggle="tab">Datos Técnicos</a></li>
                        <li role="presentation" style="background-color:#337ab7;color:white;"><a href="#galeria" aria-controls="galeria" role="tab" data-toggle="tab">Galeria de Fotos</a></li>
                    </ul>
                    <?php //if(Auth::user()->ability('xcxcv',array('image-upload'),$options = array('validate_all' => true))){ echo("disabled");} ?>

                    <div class="tab-content">
                        @permission('pi-list')
                        <div role="tabpanel" class="tab-pane active" id="tecnico">
                            {{ Form::model($data, array('method' => 'POST', 'action' => array('ProcompiteController@update', $data->id))) }}
                            <br>
                            <input type=hidden id="id" name="id" value="{{ $data['id'] }}"/>
                            {{ Form::hidden('idusuario', Auth::user()->idusuario) }}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('cod_ruta', 'Código de ruta:') }}</span>
                                        {{ Form::text('cod_ruta', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                {{ Form::hidden('nom_dpto', null, null) }}
                                {{ Form::hidden('cod_dpto', null, null) }}

                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('cod_dpto', 'Nombre Departamento:') }}</span>
                                        {{ Form::label('', 'LIMA',array('class'=>'form-control')) }}
                                    </div>
                                </div>
                                {{ Form::hidden('nom_prov', null, null) }}
                                {{ Form::hidden('cod_prov', null, null) }}

                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('cod_prov', 'Nombre Provincia:') }}</span>
                                        {{ Form::select('cod_prov', $provCombo, null, array('class' => 'form-control', 'id'=>'combo2')) }}
                                    </div>
                                </div>

                                {{ Form::hidden('nom_dist', null, null) }}
                                {{ Form::hidden('cod_dist', null, null) }}

                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('cod_dist', 'Nombre Distrito:') }}</span>
                                        {{ Form::select('cod_dist', $disCombo, null, array('class' => 'form-control', 'id'=>'combo3')) }}
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('num_benef', 'Número de beneficiarios:') }}</span>
                                        {{ Form::text('num_benef', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('tip_mant', 'Tipo de Mantenimiento:') }}</span>
                                        {{ Form::text('tip_mant', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('tip_activ', 'Tipo de actividad:') }}</span>
                                        {{ Form::textarea('tip_activ', null, array('class' => 'form-control','rows'=>'2')) }}
                                    </div>
                                </div>
                            </div><br>

                            <br><h3><b>DATOS ESTADO FISICO</b></h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('mfis_pro', 'Monto Fisico Programado:') }}</span>
                                        {{ Form::text('mfis_pro', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('ejec_fisico', 'Ejecución Fisica:') }}</span>
                                        {{ Form::text('ejec_fisico', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('av_fisico', 'Monto Fisico Programado:') }}</span>
                                        {{ Form::text('av_fisico', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                            </div>

                            <br><h3><b>DATOS ESTADO FINANCIERO</b></h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('mod_ejec', 'Modo de ejecución:') }}</span>
                                        {{ Form::text('mod_ejec', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('mfin_pro', 'MontoFinanciero Programado:') }}</span>
                                        {{ Form::text('mfin_pro', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('deven_finan', 'Devengado Financiero:') }}</span>
                                        {{ Form::text('deven_finan', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('av_finan', 'Avance Financiero:') }}</span>
                                        {{ Form::text('av_finan', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('f_afinanc', 'Fecha Avance Financiero:') }}</span>
                                        {{ Form::text('f_afinanc', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                            </div>

                            <br>
                            <h3><b>ESTADO SITUACIONAL</b></h3>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('est', 'Estado:') }}</span>
                                        {{ Form::text('est', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('subest', 'Sub estado:') }}</span>
                                        {{ Form::text('subest', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ Form::label('f_estado', 'Fecha de estado:') }}</span>
                                        {{ Form::text('f_estado', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                            </div><br>

                            <br>

                            <div class="modal-footer">
                                <div class="col-md-6"><h6>{{ Form::label('fuente', 'Fuente:') }} {{ Form::label('fuente', $data['fuente']) }}</h6></div>
                                <a type="button" class="btn btn-danger" href="{{URL::to('/piptotalpriori')}}"><span class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                        @endpermission
                        @permission('image-upload')
                        <div role="tabpanel" class="tab-pane" id="galeria">
                            <br>
                            <input type=hidden id="uid" name="uid" value="{{ $data['cod_unif'] }}"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="jumbotron how-to-create" style="background-color: rgb(209,227,243)">
                                        <div id = 'message'></div>
                                        <div class='row col-md-12'>
                                            <label>Tiempo de toma de imagenes</label><br>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1"><input type="radio" name="tipo" value="antes"> ANTES<br></div>
                                            <div class="col-md-1"><input type="radio" name="tipo" value="durante"> DURANTE<br></div>
                                            <div class="col-md-1"><input type="radio" name="tipo" value="despues"> DESPUES<br></div>
                                        </div>
                                        <br>
                                        <div class="row col-md-12">
                                            <label>Fecha de toma de las imagenes anexadas</label><br>
                                            <input type=text id="fecha" name="fecha"class="datepicker" /><br><br>
                                        </div>
                                        <br/>
                                        <br/>
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

                                    </div>

                                    <div class="dz-error-mark">
                                       
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

                        @endpermission
                    </div>
                </div>
                <!-- MAIN SCRIPT -->
                <script>
                    //INIT
                    comboUno();
                    $(function(){
                        //=========== TAB FICHA ===================
                        //POPULATING DDLS
                        $("#combo2").change(function () {
                            comboUno();
                        });
                        comboDos();
                        $("#combo4").change(function () {
                            comboDos();
                        });

                        //============= TAB GALERIA ================
                        //CARGA DE IMAGENES DE SERVIDOR
                        //cargarImg();

                    });

                    //============================ FICHA TECNICA ==============================
                    function comboUno() {
                        $("#combo2 option:selected").each(function () {
                            var id = $(this).val();
                            if (id == "")
                                id = 0;
                            $.ajax({
                                url: "{{URL::to('/piptotalpriori/combodistrito')}}/" + id,
                                success: function (data)
                                {
                                    console.log(data,id);
                                    $("#combo3").html(data);
                                }
                            });
                        });
                    }
                    function comboDos() {
                        $("#combo4 option:selected").each(function () {
                            var id = $(this).val();
                            console.log(id);
                            if (id == "")
                                id = 0;
                            $.ajax({
                                url: "{{URL::to('/piptotalpriori/combosubetapa')}}/" + id,
                                success: function (data)
                                {
                                    $("#combo5").html(data);
                                }
                            });
                        });
                    }
                    //DATEPICKER INICIALIZATION
                    $(".datepicker").datepicker({
                        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
                        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        dateFormat: "dd-mm-yy",
                        yearRange: '2000:2020',
                        changeMonth: true,
                        changeYear: true,
                        maxDate: '+30Y',
                        beforeShow: function() {
                            setTimeout(function(){
                                $('.ui-datepicker').css('z-index', 99999999999999);
                            }, 0);
                        }
                    });

                    //INPUT COLOR CHANGE ON TEXT MODIFICATION
                    $(".form-control").focus(function(){
                        var that = this;
                        var a_val = $(this).val();
                        $(this).keyup(function(){
                            if(a_val === $(that).val()){
                                $(that).css({"background-color":"white","color":"black"});
                            }else{
                                $(this).css({"background-color":"rgb(0,114,200)","color":"white"});
                            }
                        });
                        $(this).change(function(){
                            if(a_val === $(that).val()){
                                $(that).css({"background-color":"white","color":"black"});
                            }else{
                                $(this).css({"background-color":"rgb(0,114,200)","color":"white"});
                            }
                        });

                    });

                    //PREVENT FORM SUBMITTING ON KEY ENTER PRESS
                    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
                        if(e.which == 13) {
                            e.preventDefault();
                            return false;
                        }
                    });
                    //============================================= GALERIA ====================================

                    //FANCYBOX INIT
                    $(".fancybox").fancybox();

                </script>
            </div>
        </div>
    </div>
</div>

<!-- ========================================= LIBS ======================================= -->


@stop
