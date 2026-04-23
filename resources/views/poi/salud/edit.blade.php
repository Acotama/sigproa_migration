<span class="cabecera">
    <h3>Información Fotográfica</h3>
</span>

<div id="container" class="container-fluid">
    <input type=hidden id="uid" name="uid" value=""/>

    <?php
    set_time_limit(600000);
    ?>        
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <form id = "frmIntervencion" name = "frmIntervencion">
                            <input type="hidden" name="txtidPaciente" id = "txtidPaciente">
                            <div class="form-group">
                                <label>Intervención</label>
                                <select id = "cboIntervencion" class="form-control" name="cboIntervencion">
                                    <option value = 0 selected>--Seleccionar--</option>
                                    @foreach($act_op as $ao)
                                        <option value = "{{ $ao->id }}"> {{$ao->nombre}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dosis</label>
                                <input type="text" name="txtDosis" id="txtDosis" class="form-input" readonly>
                            </div>
                            <div class="form-group">
                                <label>Edad en Meses</label>
                                <input type="text" name="txtEdad" id="txtMeses" class="form-input">
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="optEstado" value="realizado">Realizado</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="optEstado" value="aplazado">Aplazado</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="optEstado" value="no realizado">No Realizado</label>
                            </div>                        
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea class="form-input" name="txtObservacion"></textarea>
                            </div>
                            <br>
                            <button class="btn btn-success" class="">Guardar</button>
                        </form>
                </div>
            </div><br>
            <div class="row">                
                <div id='message'></div>
                <h3><span id="counter"></span></h3>



                <form action="/poi/salud/img/upload" enctype="multipart/formdata" id = "dzone" class="dropzone" style="border:0px;">
                    <div class="text-center">
                        <button type="button" style="width: 80px;height: 80px;border-radius: 50px" id = "btnAddPhoto" onclick="dzoneclick();" class="btn btn-success btn-lg"><i class="fa fa-camera fa-2x"></i></button>
                        <button id="submit-all" style="display: none;" class="btn btn-success btn-lg">Guardar</button>
                    </div>
                    <div class="dz-message">

                    </div>

                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>

                    <div class="dropzone-previews" id="dropzonePreviewAntes"  style="text-align: center;"></div>
                </form>                
            </div>

        </div>
    </div>

    <!-- Dropzone Preview Template -->
    <div id="preview-template" style="display: none;">
        <div class="dz-preview dz-file-preview">
            <div class="dz-image"><img data-dz-thumbnail=""></div>
            <!--input type="hidden" class="serverfilename"/-->
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
    <h3>Galería</h3><span id="foto_poi"></span>

    <div id="poi"></div>    
    <!-- MAIN SCRIPT -->
   



</div>
