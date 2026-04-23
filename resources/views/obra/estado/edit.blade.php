<span class="cabecera">
    <h2 style="text-align: center;"></h2>
</span>

<div id="container" class="container-fluid">


<style>  

</style>

<div class="col-md-12 main">         
            <div class="row">
              <h3>{{ $ObraEstado->nom_proyec . ' - ' . $ObraEstado->nom_meta }}</h3>
            </div>            
            <b>Con Fecha:</b> <label class="label label-warning" style="font-size: 12px;">{{ date ( 'd-m-Y', strtotime($ObraEstado->fecha_act) ) }}</label>            
            <br>
            <br>
            <div class="row">

                <form method="POST" onsubmit="valorizacionSubmit(this);" id = "frmEstado" name="frmEstado">
                  <input type="hidden" name="idEstado" value="{{$ObraEstado->id}}">
                  <div class="row">
                    <div class="form-group form-group col-md-12">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><label>Etapa</label></span>
                              <select id = "cboEtapa" name="cboEtapa" onchange="loadSubEtapa()" class="form-control">
                                @foreach($Etapa as $key => $E)
                                  <option value="{{$key}}" {{ $E['state'] }} >{{ $E['nombre'] }}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><label>Sub Etapa</label></span>
                              <select id = "cboSubEtapa" name="cboSubEtapa" class="form-control">
                                @foreach($SubEtapa as $key => $E)
                                  <option value="{{$key}}" {{ $E['state'] }} >{{ $E['nombre'] }}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>                                        
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group form-group col-md-12">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><label>Descripción (Público)</label></span>
                            <textarea name="txtdescripcion" placeholder="Descripción de estado situacional" rows="5" class="form-control">{{$ObraEstado->est_situ}}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group form-group col-md-12">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><label>Observación</label></span>
                            <textarea name="txtobservacion" placeholder="Observación" rows="5" class="form-control">{{$ObraEstado->obs}}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group form-group col-md-12">
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><label>Avance Físico</label></span>
                            <input type="text" name="txtafisico" value="{{ $ObraEstado->a_fisico or 0.00 }}" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row text-center">
                    <button class="btn btn-primary">Guardar <i class="fa fa-save"></i></button>
                  </div>
                </form>

                <!-- IMAGE UPLOAD -->
                <!--div class="row">                
                      <div id='message'></div>
                      <h3><span id="counter"></span></h3>               

                      <form action="/piptotalpriori/ejecucion/estado/img/upload" enctype="multipart/formdata" id = "dzoneObraEstado" name="dzoneObraEstado" class="dropzone" style="border:0px;">
                        <div class="text-center">
                            <button type="button" style="width: 80px;height: 80px;border-radius: 50px" id = "btnAddPhotoObraEstado" onclick="dzoneclick();" class="btn btn-success btn-lg"><i class="fa fa-camera fa-2x"></i></button>
                            <button id="submit-allObraEstado" style="display: none;" class="btn btn-primary btn-lg">Subir <i class="fa fa-upload"></i> </button>
                        </div>
                        <div class="dz-message">

                        </div>

                        <div class="fallback">
                            <input name="file" type="file" />
                        </div>

                        <div class="dropzone-previews" id="dropzonePreviewAntesObraEstado"  style="text-align: center;"></div>
                      
                      </form>
                </div-->
                <!-- Dropzone Preview Template -->
                <!--div id="preview-template-ObraEstado" style="display: none;">
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image"><img data-dz-thumbnail=""></div-->
                        <!--input type="hidden" class="serverfilename"/-->
                        <!--div class="dz-details">
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
                </div-->
                <!-- End Dropzone Preview Template -->
                
                <!-- BOXES -->
                <!--h3>Galería</h3><span id="foto_obras"></span>

                <div id="obras"></div-->    
            </div>

            <br>
            <div class="row">

              <!--div class="col-md-12" style="text-align: center;">
                <button type="submit" class="btn btn-success">Guardar</button>
              </div-->
            </div>
</div>

<div class="pie">
        
</div>