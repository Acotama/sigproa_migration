<span class="cabecera">
    <h2>Evidencia</h2>
</span>

<div id="container" class="container-fluid">


<style>
    .panel{
        background-color: rgb(209,227,243);
    }
</style>

<div class="col-md-12 main">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row" style="text-align: center">
                <h3></h3>
            </div>
        </div>
    </div>
    <div class="m-message"></div>
    <br>
    <label>Fecha: </label>
    <label class="label label-warning" id = "lblfecha">{{ $fecha }}</label>
    <br>
    <label>Tiempo: </label>
    <label class="label label-success" id = "lbltiempo">{{ $tiempo }}</label>

    <input type="hidden" name="idP" value="{{ $idObra }}">
    <div class="col-md-12">
        <br>
        <div class="row">
            <div class="col-md-12">
                <span>{{ Form::label('est_situ', 'Descripcion de estado (Público):') }}</span>
                <textarea id = "txtdesc" class="form-control" cols="12" rows="5" name="est_situ">{{ $model['descripcion'] }}</textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span>{{ Form::label('obs', 'Observación:') }}</span>
                <textarea id = "txtobs" class="form-control" cols="12" rows="5">{{$model['obs']}}</textarea>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-12">

                <label class="radio-inline" style="font-size:16px;font-weight: bold">
                    <input type="radio" name="tipo" value = "E" checked>Otro
                </label>

                <label class="radio-inline" style="font-size:16px;font-weight: bold">
                    <input type="radio" name="tipo" value = "P"  @if($model['tipo'] == "P")
                    {{'checked'}} @endif>Paralizado
                </label>

                <label class="radio-inline" style="font-size:16px;font-weight: bold">
                    <input type="radio" name="tipo" value = "PP" @if($model['tipo'] == 'PP') {{'checked'}} @endif>Primera Piedra

                </label>

                <label class="radio-inline" style="font-size:16px;font-weight: bold">
                    <input type="radio" name="tipo" value = "I" @if($model['tipo'] == 'I') {{'checked'}} @endif>Inauguración
                </label>

            </div>
        </div>
        <br>
        <!-- IMAGE UPLOAD -->
        <div class="row">
            <div class="col-md-12" style="text-align: center;">
              <div id='qqmessage'></div>
              <div id = "dropzone" style="height: 80px;width: 80px;margin: 0 auto;">
                <button
                    type="button"
                    style="width: 80px;height: 80px;border-radius: 50px;"
                    id = "btnAddPhoto"
                    onclick="dzoneclick();"
                    class="btn btn-success btn-lg">
                        <i class="fa fa-camera fa-2x"></i>
                </button>
              </div>
              <br>
              <div class="image-container" style="text-align: center;">
                  <img id = "thumbnail"></img>
                  <br>
                  <button
                    id      = "submit-allEvidenciaEstado"
                    style   = "display:none;margin: 0 auto;"
                    onclick = "retryUpload();"
                    class   = "btn btn-success btn-lg">
                        Guardar <i class="fa fa-upload"></i>
                   </button>
                   <i class="fa fa-spinner fa-2x" id = "loadingIcon" style="display:none;"></i>
              </div>
            </div>
        </div>



        <!-- BOXES -->
        <h3>Galería</h3><span id="foto_evidencias"></span>

        <div id="evidencias"></div>
	    <br>

    </div>


</div>

<div class="pie">

</div>
