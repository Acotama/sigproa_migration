<span class="cabecera">
    <h3>Editar paquete de Fotografías</h3>
</span>

<div id="container" class="container-fluid">


<style>

    .panel{
        background-color: rgb(209,227,243);
    }

</style>

<div class="col-md-12 main" style="background-color: #d1e3f3;">
    <br>
    <form method="POST" name="frmImageUpdate" onsubmit="event.preventDefault();updateImage();" action="/piptotalpriori/updateImage/{{$PipTotalPriori->id}}" id = "frmImageUpdate">
    <div class="row">
      <div class="col-md-12">
          <div class="row" style="text-align: center">
              <h3>{{ $PipTotalPriori->nom_proyec }}</h3>
          </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="form-group">
          <h4><b>Meta</b></h4>
          <div class="row">
            <input type="hidden" name="old_optObra" value="{{ $PipTotalPrioriImg[0]->idobra }}"></label>
            @foreach($Obras as $Obra)
              <div class="col-xs-12 col-md-2 col-lg-2"><label>
                @if($Obra->tipo=='E')
                  EJECUCIÓN INTEGRAL
                @else
                  {{ $Obra->nom_meta }}
                @endif
                <input type="radio" name="optObra" value="{{ $Obra->id }}" <?php if($PipTotalPrioriImg[0]->idobra == $Obra->id){ echo 'checked';} ?>></label>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <h4><b>Tiempo de toma de imágenes</b></h4>
          <div class="row">
            <input type="hidden" name="old_tiempo" value="{{ $PipTotalPrioriImg[0]->tiempo }}"></label>
            <div class="col-xs-12 col-md-2 col-lg-2"><label>Antes <input type="radio" name="tiempo" value="ANTES" @if($PipTotalPrioriImg[0]->tiempo == 'ANTES') checked @endif></label></div>
            <div class="col-xs-12 col-md-2 col-lg-2"><label>Durante <input type="radio" name="tiempo" value="DURANTE" @if($PipTotalPrioriImg[0]->tiempo == 'DURANTE') checked @endif></label></div>
            <div class="col-xs-12 col-md-2 col-lg-2"><label>Despues <input type="radio" name="tiempo" value="DESPUES" @if($PipTotalPrioriImg[0]->tiempo == 'DESPUES') checked @endif></label></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <h4><b>Fecha</b></h4>
          <input type="hidden" name="old_fecha" value="{{ $PipTotalPrioriImg[0]->fecha }}"></label>
          <input class="datepicker" type="text" name="fecha" class="form-control" placeholder="Fecha" value="{{ $fecha = date('d-m-Y',strtotime($PipTotalPrioriImg[0]->fecha)) }}">
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <label style="font-size: 16px">
          Tipo</label><br>
          <div class="col-xs-12 col-md-2 col-lg-2"><label>Primera piedra <input type="radio" name="tipo" value="PP"  @if($PipTotalPrioriImg[0]->tipo == 'PP') checked @endif></label></div>
          <div class="col-xs-12 col-md-2 col-lg-2"><label>Ejecución <input type="radio" name="tipo" value="E"  @if($PipTotalPrioriImg[0]->tipo == 'E') checked @endif></label></div>
          <div class="col-xs-12 col-md-2 col-lg-2"><label>Inauguración <input type="radio" name="tipo" value="I"  @if($PipTotalPrioriImg[0]->tipo == 'I') checked @endif></label></div>
          <div class="col-xs-12 col-md-2 col-lg-2"><label>Paralizado <input type="radio" name="tipo" value="P"  @if($PipTotalPrioriImg[0]->tipo == 'P') checked @endif></label></div>
          <div class="col-xs-12 col-md-2 col-lg-2"><label>Otro <input type="radio" name="tipo" value="O"  @if($PipTotalPrioriImg[0]->tipo == 'O') checked @endif></label></div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="form-group">
          <h4><b>Descripción</b></h4>
          <textarea class="form-control" name="descripcion" placeholder="Descripción" rows="6" >{{$PipTotalPrioriImg[0]->descripcion}}</textarea>
        </div>
      </div>

      <br>
      <div class="text-center">
          <button class="btn btn-success" type="submit"> Actualizar </button>
      </div>

      <br>
      <br>
      <br>
      </form>

      <div id="paqueteImg">
        
      </div>

    </div>
</div>

<div class="pie">

</div>

