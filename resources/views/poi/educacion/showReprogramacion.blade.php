<span class="cabecera">
    <h3>Datos de Actividad</h3>
</span>

<div id="container" class="container-fluid">
    <input type=hidden id="uid" name="uid" value="{{ $Taller->id }}"/>

    <div class="row">
        <div class="col-md-12">            
            <div class="row">
                <!-- TALLER -->                
                <div class="col-md-12">
                    <h3>Actividad</h3>

                    <div class="text-center">
                        <label style="font-size: 16px;"><b>{{$Taller->nom_prov}}</b>- {{$Taller->nom_dist}}</label>
                    </div>
                    <ul class="list-group">
                      <li class="list-group-item list-group-item-success">Sector: {{$Taller->funcion}}</li>
                      <li class="list-group-item list-group-item-info">Categoria: {{$Taller->cat_presupuestal}}</li>
                      <li class="list-group-item list-group-item-info">Producto: {{$Taller->producto}}</li>
                      <li class="list-group-item list-group-item-info">Actividad: {{$Taller->act_presupuestal}}</li>
                      <li class="list-group-item list-group-item-success">Actividad Operativa:  {{$Taller->nombre}} </li>                      
                    </ul>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Fecha</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Taller->fecha }}" >
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Lugar</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Taller->ie }}" >
                            </div>
                        </div>                     
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label><?php echo is_numeric($Taller->docente) ? 'Cant. Docentes' :  'Docente' ?></label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $Taller->docente }}" >
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-md-12">
                    <h3>Responsable Institucional</h3>
                    <div class="row">                        
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Responsable Institucional</label></span>
                                <textarea class="form-control" type="text" readonly=""> {{ $Taller->resp_institucional }}</textarea>
                            </div>                            
                        </div>
                        <div class="col-md-3 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Celular</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $ResponsableInstitucional->celular or '' }}" >
                            </div>
                        </div>
                        <div class="col-md-3 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Correo</label></span>
                                <input class="form-control" type="text" readonly="" value = "{{ $ResponsableInstitucional->email or '' }}" >
                            </div>
                        </div>
                    </div>                    
                </div><br>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h3>Responsable Operativo</h3>
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
                                <input class="form-control" type="text" readonly="" value = "{{ $Taller->intervencion }}" >
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
                                <input class="form-control" type="text" readonly="" value = "{{ $Responsable->celular }}" >
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
  
    <h3>Galería</h3><span id="foto_poi"></span>

    <div id="poi"></div>   


</div>
