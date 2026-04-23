<span class="cabecera">
    @if(isset($data))
        <h3 class="text-center"><b>Editar Inversiones no Previstas</b></h3>
    @else
        <h3 class="text-center"><b>Agregar Inversiones no Previstas</b></h3>
    @endif
</span>
<div id="container" >
    <div class="modal-body">
        <div id="cargando_modal" class="loading" style="display: none;"></div>
        <div  class="col-md-12">
            <div class="form-group">
                <label for="codigo">Codigo Unico</label>
                <input type="number" class="form-control" id="codigo" placeholder="Ingrese Codigo" value="{{ isset($data)? $data->cod_unif :''}}">
            </div>
            <div class="form-group">
                <label for="monto">Monto de Ejecución</label>
                <input type="number" class="form-control" id="monto" placeholder="Ingrese Monto" value="{{ isset($data)? $data->monto_ejecucion :''}}">
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <textarea   rows="3" class="form-control" id="estado" placeholder="Ingrese Estado">{{ isset($data)? $data->estado :''}}</textarea >
            </div>
            <div class="form-group">
                <label for="modalidad">Modalidad</label>
                <input type="text" class="form-control" id="modalidad" placeholder="Ingrese Modalidad" value="{{ isset($data)? $data->modalidad :''}}">
            </div>
            @if(isset($data))
                <button type="submit" class="btn btn-primary" id="btn_agregar" onclick='agregar(1,{{ $data->id }})'><i class="fa fa-save"> Actualizar</i></button>
                <button type="submit" class="btn btn-danger" id="btn_eliminar" onclick='eliminar(2,{{ $data->id }})'><i class="fa fa-trash"> Eliminar</i></button>
            @else
                <button type="submit" class="btn btn-primary" id="btn_agregar" onclick='agregar(0,null)'><i class="fa fa-save"> Agregar</i></button>
            @endif
        </div>
    </div>
</div>

<div class="pie">
