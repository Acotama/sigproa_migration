<span class="cabecera">
    <h3>Información Fotográfica</h3>
</span>

<div id="container" class="container-fluid">
    <input type=hidden id="uid" name="uid" value="{{ $taller->id }}"/>

    <?php
    set_time_limit(600000);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-center"><b>{{$taller->nombre}}</b></h4>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <b>Programado para: {{$taller->f_fecha}}</b>
                </div>
            </div>

            <div class="row">
                <div id='message'></div>
                <h3><span id="counter"></span></h3>


                <div class="col-md-3">
                    <div class="row text-center">
                        <p>¿Problemas al subir la imagen? </p>
                        <p>Observación: </p>
                        <select id="cboObservation">
                            @foreach($options as $i => $v)
                                <option value="{{$i}}" {{$v['state']}}>{{$v['value']}}</option>
                            @endforeach
                        </select>


                    </div>

                    <br>
                        <!--div class="row text-center">
                                 <p>Numero de Participantes : </p>

                                  <input type="Numero" name="nro_participantes" value="{{ $taller->nro_participantes }}" id = "nro_participantes">
                        </div-->
                    <div class="row text-center">
                        <button class="btn btn-primary text-center" onclick="saveObservation('{{$taller->id}}')">Guardar Observación</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="ObsDiv"></div>
                </div>
            </div>

        </div>
    </div>


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
                id      = "submit-all"
                style   = "display:none;margin: 0 auto;"
                onclick = "retryUpload();"
                class   = "btn btn-success btn-lg">
                    Guardar <i class="fa fa-upload"></i>
               </button>
               <br>
               <label id = "loadingIcon" style="display:none;">Cargando ... <i class="fa fa-spinner fa-2x"></i></label>
          </div>
        </div>
    </div>


    <!-- BOXES -->
    <h3>Galería</h3><span id="foto_poi"></span>

    <div id="poi"></div>
    <!-- MAIN SCRIPT -->



</div>
