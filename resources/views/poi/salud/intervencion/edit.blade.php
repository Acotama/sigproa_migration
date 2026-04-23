<span class="cabecera">
    <h3>Información Fotográfica</h3>
</span>

<div id="container" class="container-fluid">
    <?php
    set_time_limit(600000);
    ?>        
    <div class="row">
        <div class="col-md-12">
        <div class="m-message"></div>
            <div class="row">
                <div class="col-md-12">
                    <form id = "frmIntervencion" name = "frmIntervencion" onsubmit="event.preventDefault();updateIntervencion(this)">
                            <input type="hidden" name="txtidPaciente" id = "txtidPaciente" value="{{$Paciente->id}}">
                             <div class="form-group">
                                <label>Fecha de Intervención</label>
                                <input type="text" name="txtFecha" class="form-control datepicker" value="{{$Atencion->fecha_intervencion}}"  />
                            </div>
                            <div class="form-group">
                                <label>Intervención</label>
                                <select id = "cboIntervencion" class="form-control" name="cboIntervencion" onchange="loadDosis(this);">
                                    <option value = 0 selected>--Seleccionar--</option>
                                    @foreach($act_op as $ao)
                                        <option value = "{{ $ao->id }}" {{$ao->selected? 'selected':''}}> {{$ao->nombre}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dosis</label>
                                <select id = "cboDosis" class="form-control" name="cboDosis">
                                    @foreach($dosis as $do)
                                        <option value = "{{ $do->id }}" {{$do->selected ? 'selected':''}}> {{$do->denom}} </option>
                                    @endforeach                                 
                                </select>
                            </div>
                            <h4>Edad</h4>
                            <div class="form-group">
                                <label>Año(s)</label>
                                <input type="number" name="txtYears" id="txtYears" class="form-input" value="{{$Atencion->years}}">                                
                            </div>
                            <div class="form-group">
                                <label>Mes(es)</label>
                                <input type="number" name="txtMeses" id="txtMeses" class="form-input" value="{{$Atencion->meses}}">
                            </div>
                            <h4>Crecimiento</h4>
                            <div class="form-group">
                                <label>Peso</label>
                                <input type="number" name="txtPeso" id="txtPeso" class="form-input" value="{{$Atencion->peso}}">
                            </div>
                            <div class="form-group">
                                <label>Talla en centímetos</label>
                                <input type="number" name="txtTalla" id="txtTalla" class="form-input" value="{{$Atencion->talla}}">
                            </div>
                                                  
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea class="form-input" name="txtObservacion">{{$Atencion->observacion}}</textarea>
                            </div>
                            <br>
                            <button class="btn btn-primary" id = "btnAddIntervencion">Actualizar</button>
                        </form>
                </div>
            </div><br>
            <div class="row hide-not-record">                
                <div id='message'></div>
                <h3><span id="counter"></span></h3>



                <form action="/poi/salud/img/upload" enctype="multipart/formdata" id = "dzone" class="dropzone" style="border:0px;">
                <div class="text-center">
                    <button type="button" style="width: 80px;height: 80px;border-radius: 50px" id = "btnAddPhoto" onclick="dzoneclick();" class="btn btn-success btn-lg"><i class="fa fa-camera fa-2x"></i></button>
                    <button id="submit-all" style="display: none;" class="btn btn-success btn-lg">Subir Foto</button>
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
    
    <div class="hide-not-record">
        <!-- BOXES -->
        <h3>Galería</h3><span id="foto_poi"></span>

        <div id="poi"></div>    
    </div>

</div>
