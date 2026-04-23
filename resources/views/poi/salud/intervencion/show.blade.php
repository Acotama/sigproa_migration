<span class="cabecera">
    <h3>Información Fotográfica</h3>
</span>

<div id="container" class="container-fluid">
    <?php
    set_time_limit(600000);
    ?>        
    <div class="row">
        <div class="col-md-12">        
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha de Intervención</label>
                        <p>{{$Atencion->fecha_intervencion}}</p>                                
                    </div>
                    <div class="form-group">
                        <label>Intervención</label>                        
                        <p>{{$Atencion->nombre}}</p>
                    </div>
                    <div class="form-group">
                        <label>Dosis</label>
                        <p>{{$Atencion->denom}}</p>
                    </div>                    

                    <h4>Estado</h4>
                    
                    <div class="form-group">
                        <label>Observación</label>
                        <p>{{$Atencion->observacion}}</p>
                    </div>                            
                </div>
                <div class="col-md-6">
                    <h4>Edad</h4>
                    <div class="form-group">
                        <label>Año(s)</label>
                        <p>{{$Atencion->years}}</p>
                    </div>
                    <div class="form-group">
                        <label>Mes(es)</label>
                        <p>{{$Atencion->meses}}</p>
                    </div>
                    <h4>Crecimiento</h4>
                    <div class="form-group">
                        <label>Peso</label>
                        <p>{{$Atencion->peso}}</p>
                    </div>
                    <div class="form-group">
                        <label>Talla en centímetos</label>
                        </p>{{$Atencion->talla}}</p>
                    </div>
                </div>
            </div><br>
        </div>
    </div>   
    
    <div class="">
        <!-- BOXES -->
        <h3>Galería</h3><span id="foto_poi"></span>

        <div id="poi"></div>    
    </div>

</div>
