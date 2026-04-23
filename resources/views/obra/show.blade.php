<span class="cabecera">
    <h2>Editar Ejecución</h2>
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
                <h3>{{ $pInfo->nom_proyec }}</h3>
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
                    <label class="form-control">{{ $pInfo->cod_snip }}</label>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-12">
                <h3><label class="label h1 label-warning">Tipo </label></h3>
                <label class="form-control">
                @php
                    switch($pInfo->tipo){
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
                </label>
            </div>
        </div>
        <br>


        @if($pInfo->tipo == "M")
        <div id = "divMeta">
            <div class="row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Número de meta</label>
                        </span>
                        <label class="form-control">{{$pInfo->nro_meta}}</label>                        
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Nombre de Meta</label></span>
                        <label class="form-control">{{$pInfo->nom_meta}}</label>
                    </div>
                </div>
            </div>
        </div>         
        @endif
        <br>

        <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Monto de exp. tecnico</label>                            
                        </span>
                        <label class="form-control">{{$pInfo->m_exp_tec}}</label>
                    </div>
                </div>
        </div>
        <br>
        <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Monto de valor referencial</label>
                        </span>                        
                        <label class="form-control">{{$pInfo->m_vreferencial}}</label>
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
                        <label>Fecha de Actualización: </label>
                    </span>                    
                    <label class="form-control">{{$pInfo->fecha_act}}</label>
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
                    <label class="form-control">{{$pInfo->etapa}}</label>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Sub Etapa</label>
                    </span>
                    <label class="form-control">{{$pInfo->sub_etapa}}</label>
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
                    <textarea rows="8" class="form-control">{{$pInfo->est_situ}}</textarea>
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
                    <textarea rows="5" class="form-control">{{$pInfo->obs}}</textarea>
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
                    <label class="form-control">{{$pInfo->a_fisico}}</label>
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
                        <label class="form-control">{{$pInfo->anio_ejec}}</label>
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
                    <label class="form-control">{{$pInfo->mod_ejec}}</label>
                </div>
            </div>        
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Fecha de Adjudicación</label>
                        </span>                        
                        <label class="form-control">{{$pInfo->f_adjudicacion}}</label>
                    </div>
            </div>
        </div>
        <br>
        <div class="row" id = "dvNro_ContratoM">
            <div class="col-md-12"> 
                <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label>Monto de Contrato</label>
                                </span>
                                <label class="form-control">{{$pInfo->m_ejecucion}}</label>
                            </div>
                        </div>
                </div>
                <br> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <label>Número de Contrato</label>
                            </span>
                            <label class="form-control">{{$pInfo->n_contrato}}</label>
                        </div>
                    </div>    
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <label>Fecha de Contrato</label>
                            </span>                            
                            <label class="form-control">{{$pInfo->f_contrato}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>        
        <div class="row">
            <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label>Tiempo de Ejecucion en dias</label>
                        </span>                        
                        <label class="form-control">{{$pInfo->t_ejec_dias}}</label>
                    </div>
            </div>                  
        </div>
        <br>
         <div class="row">              
            <div class="col-md-6">
                <div class="input-group">
                        <label class="input-group-addon">
                            <label>Fecha de Inicio</label>                        
                        </label>
                        <label class="form-control">{{$pInfo->f_inicio}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Fecha de Finalización</label>
                    </span>                    
                    <label class="form-control">{{$pInfo->f_termino}}</label>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label>Fecha de Reinicio</label>
                    </span>                    
                    <label class="form-control">{{$pInfo->f_reinicio}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                        <label class="input-group-addon">
                            <label>Nueva Fecha de Termino</label>
                        </label>                        
                        <label class="form-control">{{$pInfo->f_termino_nueva}}</label>
                </div>
            </div>
        </div>        
        <h4>Responsables Asignados</h4>
        <div class="row">
            <ul class="list-group">
            @if(count($supervisores))
                @foreach($supervisores as $s)
                    <li class="list-group-item">
                        $s->nombres
                    </li>
                @endforeach
            @else
                <li class="list-group-item">
                        No se ha asignado responsable
                </li>
            @endif
            </ul>
        </div>
        <br>        
        <br>
    </div>

    
</div>

<div class="pie">

</div>




