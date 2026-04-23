<span class="cabecera">
    <h2>Obra</h2>
</span>

<div id="container" class="container-fluid">


<style>


    .panel{
        background-color: rgb(209,227,243);
    }
 

    /*.valid {
        border: 2px solid green !important;
    }*/



  /*table tr:nth-child(even) {background-color: rgb(216,206,88);}*/

</style>

<div class="col-md-12 main" style="background-color: #d1e3f3;">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row" style="text-align: center">
                <h3>{{ $Proyecto->nom_proyec }}</h3>
            </div>           
        </div>
    </div>

    <br>
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">
                    <label>Código Snip</label></span>
                    <label class="form-control">{{ $Proyecto->cod_snip }}</label>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-12">
                <label>Tipo: </label>
                <h4><label class="label label-warning">
                @php
                    switch($Obra->tipo){
                        case 'M':
                            echo 'Meta';
                            break;
                        case 'E':
                            echo 'Ejecución Integral';
                            break;
                        case 'S':
                            echo 'Saldo de Meta';
                            break;
                    }
                    
                @endphp
                </label></h4>
            </div>
        </div>
        @if($Obra->tipo == "M")
        <div id = "divMeta">
            <div class="row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Número de meta</label>
                        </span>
                        <label class="form-control">{{$Obra->nro_meta}}</label>                        
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Nombre de Meta</label></span>
                        <label class="form-control">{{$Obra->nom_meta}}</label>
                    </div>
                </div>
            </div>
        </div>         
        @endif

        @if($Obra->tipo == "M")
        <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Monto de exp. tecnico</label>
                        </span>
                        <label class="form-control">{{$Obra->m_exp_tec}}</label>
                    </div>
                </div>
        </div>
        @endif
        <br>
        <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Monto de valor referencial</label>
                        </span>                        
                        <label class="form-control">{{$Obra->m_vreferencial}}</label>
                    </div>
                </div>
        </div>
        <br>
         <!-- ESTADO SITUACIONAL -->
        <h3>Estado Actual</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Fecha Estado: </label>
                    </span>                    
                    <label class="form-control">{{$Obra->fecha_act}}</label>
                </div>
            </div>            
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 form-group">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Etapa</label>
                    </span>
                    <label class="form-control">{{$Obra->etapa}}</label>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Sub Etapa</label>
                    </span>
                    <label class="form-control">{{$Obra->sub_etapa}}</label>
                </div>
            </div>
        </div>        
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Descripción de estado</label>
                    </span>                    
                    <textarea rows="8" class="form-control">{{$Obra->est_situ}}</textarea>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Observación</label>
                    </span>                    
                    <textarea rows="5" class="form-control">{{$Obra->obs}}</textarea>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Avance Físico</label>
                    </span>                    
                    <label class="form-control">{{$Obra->a_fisico}}</label>
                </div>
            </div>
        </div>
        <!-- ESTADO SITUACIONAL #END -->
        <h3>Datos de Obra</h3>            
        <br>
        <div class="row">           
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Año de ejecución</label>
                        </span>
                        <label class="form-control">{{$Obra->anio_ejec}}</label>
                    </div>
                </div>
        </div>
        <br>
        <div class="row">              
            <div class="col-md-6">
                <div class="input-group">
                    <label class="input-group-addon">
                        <label>Modalidad de Ejecución</label>
                    </label>
                    <label class="form-control">{{$Obra->mod_ejec}}</label>
                </div>
            </div>        
        </div>
        <br>         
        
        <br>        
        <div class="row">
            <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Tiempo de Ejecucion en dias</label>
                        </span>                        
                        <label class="form-control">{{$Obra->t_ejec_dias}}</label>
                    </div>
            </div>                  
        </div>
        <br>
         <div class="row">              
            <div class="col-md-6">
                <div class="input-group">
                        <label class="input-group-addon">
                            <label>Fecha de Inicio Programada</label>                        
                        </label>
                        <label class="form-control">{{$Obra->f_inicio}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Fecha de Finalización Programada</label>
                    </span>                    
                    <label class="form-control">{{$Obra->f_termino}}</label>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Fecha de Inicio Real</label>
                    </span>                    
                    <label class="form-control">{{$Obra->f_reinicio}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                        <label class="input-group-addon">
                            <label>Fecha de Termino Real</label>
                        </label>                        
                        <label class="form-control">{{$Obra->f_termino_nueva}}</label>
                </div>
            </div>
        </div>
        <h3>Contratos (Proyecto)</h3>            
        <div class="row">
            <ul class="list-group">
            @foreach($Contratos as $c)
                <li class="list-group-item list-group-item-dark">
                    <b>Fecha Contrato: {{$c->contrato_fecha}}</b><br>
                    <b>{{$c->tipo_proceso}}</b><br>                    
                    <b>{{$c->contrato_nro}}</b>
                    <p>{{$c->contratista}} (RUC: {{$c->contratista_ruc}})</p>
                    <p>Monto: {{$c->contrato_moneda}} {{$c->contrato_monto}}</p>
                    <p>{{ $c->descripcion }}</p>

                </li>

            @endforeach
            </ul>
        </div>
        <br>        
        <br>
    </div>

    
</div>

<div class="pie">

</div>




