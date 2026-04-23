<span class="cabecera">
    <h2>Asignar responsable de actualización de obra</h2>
</span>

<div id="container" class="container-fluid">


<style>
    .panel{
        background-color: rgb(209,227,243);
    } 
</style>

<div class="col-md-12 main" style="background-color: #d1e3f3;">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row" style="text-align: center">
                <h3>{{ $Obra->nom_proyec }}</h3>
                <input type="hidden" name="idobra" id = "idobra" value="{{ $Obra->id }}">
            </div>           
        </div>
    </div>
    <br>    
    <div class="col-md-12">    	
        <div class="row">
            <div class="col-md-6">
                <form onsubmit="searchUsuario(this);" name = "frmSearchUsuario" id = "frmSearchUsuario">                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Nombre o DNI</span>
                                    <input type="text" class="form-control" name="txtEncargado">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                        </div>
                    </div>
                    <div id = "message" class="label label-danger"></div>
                </form>                
                <br>
                <div id = "divAsignarInspector">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Nombre</span>
                                    <label class="form-control" id = "lblNombre"></label>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Dependencia</span>
                                    <label class="form-control" id = "lblDependencia"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">DNI</span>
                                    <label class="form-control" id = "lblDNI"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Celular</span>
                                    <label class="form-control" id = "lblCelular"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <button class="btn btn-success" onclick="asignarInspector();" type="button">Asignar <i class="fa fa-share" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="panel panel-primary">
                    <div class="panel-heading">Responsables</div>
                    <div class="panel-body"  style="padding: 0px;">                    
                        <ul class="list-group" id = "listResponsables">
                            @foreach($Inspector as $i)                                
                                <a id = "{{$i['idusuario']}}" class="list-group-item"> {{ $i['apellidos'] . ', ' . $i['nombres'] }}<i class="fa fa-user-times pull-right" aria-hidden="true" onclick="quitarInspector(this);"></i></a>
                            @endforeach
                        </ul>
                    </div>
                </div>                
            </div>
        </div>     
    </div>

   
</div>

<div class="pie">

</div>




