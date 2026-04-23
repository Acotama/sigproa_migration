<span class="cabecera">
    <h2 style="text-align: center;">Reprogramar Actividad</h2>
</span>

<div id="container" class="container-fluid">


<style>

    /*.valid {
        border: 2px solid green !important;
    }*/



  /*table tr:nth-child(even) {background-color: rgb(216,206,88);}*/

</style>

<div class="col-md-12 main">
         <form id="frmEditTaller">
                            <div class="row">
                               <ul class="list-group">
                                  <li class="list-group-item list-group-item-success">Sector: {{$Taller->funcion}}</li>
                                  <li class="list-group-item list-group-item-info">Categoria: {{$Taller->cat_presupuestal}}</li>
                                  <li class="list-group-item list-group-item-info">Producto: {{$Taller->producto}}</li>
                                  <li class="list-group-item list-group-item-info">Actividad: {{$Taller->act_presupuestal}}</li>
                                  <li class="list-group-item list-group-item-danger">Actividad Operativa:  {{$Taller->nombre}} </li>                      
                                </ul>                                             
                                <div class="row">
                                  <div class="form-group form-group col-md-12">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label>Responsable Institucional</label></span>
                                            <input class="form-control" type="text" readonly="" value = "{{ $Taller->resp_institucional }}" >
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                              <span class="input-group-addon"><label>Responsable Operativo</label></span>
                                              <input class="form-control" type="text" readonly="" value = "{{ $Taller->resp_operativo }}" >
                                            </div>
                                        </div>                                        
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="row">                            
                                <input type="hidden" name="id" value="{{$Taller->id}}">
                                  
                                <div class="form-group form-group col-xs-12 col-md-6 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon2">Fecha</span>
                                        <input type="text" name="txtFecha" class="form-control datepicker" placeholder="Fecha dd-mm-yyyy" value="{{$Taller->fecha}}" onchange="reprogramar(this);">
                                        <input type="hidden" name="fecha" value = "{{$Taller->fecha}}">
                                    </div>                                    
                                </div>                                
                                
                                <input type="hidden" name="reprogramado" value = "0">                                
                                <span id = "divReprogramadoMsg" class="text-center"></span>

                                <script type="text/javascript">
                                    reprogramar = function($this){
                                        //console.log(Date.parse($($this).val()));
                                        
                                        if( ( ($($this).val()).length) == 10 ){
                                            $("#divReprogramadoMsg").html('<h3><label class="label label-warning h1">Reprogramado</label></h3>');
                                        } else {
                                            $("#divReprogramadoMsg").html('');
                                        }
                                    }                                    
                                </script>
                            </div>                            
                        <br>
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-success">Reprogramar</button>    
                            </div>
                        </div>
                        
        </form>
</div>

<div class="pie">
        
</div>