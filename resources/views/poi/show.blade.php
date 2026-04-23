<span class="cabecera">
    <h3>Ver Datos De Taller</h3>
</span>

<div id="container" class="container-fluid">
    <input type=hidden id="uid" name="uid" value="{{ $Taller->id }}"/>

    <div class="row">
        <div class="col-md-12">            
            <div class="row">
                <!-- TALLER -->                
                <div class="col-md-6">
                    <h3>Taller</h3>

                    <div class="text-center">
                        <label style="font-size: 16px;"><b>{{$Taller->nom_prov}}</b>- {{$Taller->nom_dist}}</label>
                    </div>
                    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading0">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse0" aria-expanded="false" aria-controls="collapse0">
                              Sector
                            </a>
                          </h4>
                        </div>
                        <div id="collapse0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                          <div class="panel-body">
                            {{$Taller->sector}}
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading1">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
                              Categoria
                            </a>
                          </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
                          <div class="panel-body">
                            {{$Taller->categoria}}
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading2">
                          <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                              Producto
                            </a>
                          </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                          <div class="panel-body">
                            {{$Taller->product}}
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading3">
                          <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                              Actvidad
                            </a>
                          </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                          <div class="panel-body">
                            {{$Taller->activ}}
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading4">
                          <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                              Actvidad Operativa
                            </a>
                          </h4>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading4" aria-expanded="true">
                          <div class="panel-body">
                            {{$Taller->nombre}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Descripción</label></span>
                                <textarea class="form-control" type="text" readonly="" rows="4"> {{ $Taller->descripcion }} </textarea>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Fecha</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Taller->fecha }}" >
                            </div>
                        </div>
                        <!--div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Hora</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Taller->hora }}" >
                            </div>
                        </div-->
                    </div>
                </div>
                <!-- RESPONSABLE -->                
                <div class="col-md-6">
                    <h3>Responsable</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Responsable</label></span>
                                <textarea class="form-control" type="text" readonly=""> {{ $Responsable->apellidos. ', ' .$Responsable->nombres }}</textarea>
                            </div>                   
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Intervención</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Responsable->intervencion }}" >
                            </div>                   
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>DNI</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Responsable->dni }}" >
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="input-group ">
                                <span class="input-group-addon"><label>Teléfono</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Responsable->telefono }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Usuario</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Responsable->username }}" >
                            </div>
                        </div>                        
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>E-mail</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Responsable->email }}" >
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <!--h3>Galeria</h3><span id="foto_poi"></span>

    <div id="poi"></div-->

   
    


</div>
