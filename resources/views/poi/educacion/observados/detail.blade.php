<span class="cabecera">
    <h3>Información Fotográfica</h3>
</span>

<div id="container" class="container-fluid">


	<div class="row">
	    <div class="col-md-12">
			<button class="btn btn-primary pull-right" onclick="borrarRelacion({{ $Imagen->id }});">
				<i class="fa fa-eraser"></i> Borrar Relación
			</button>
			<br>
	    	<div class="row">
	    		<div class="col-md-6">
	    			<a class="fancybox" rel="group" href="/images{{ $Imagen->url . '/' . $Imagen->nombre }}">
                        <img  width="100%" src="/images{{ $Imagen->url . '/' . $Imagen->nombre }}">
                    </a>
		    	</div>		    	
		    	<div class="col-md-6">
		    		<label>Fecha Taller:</label>
		    		{{ $Imagen->fecha_programacion }}
		    		<br>
		    		<label>Fecha Fotografía:</label>
		    		{{ $Imagen->fecha }} 
					@if($Imagen->exif == '0')
						<label class="label label-warning">Modificado/Creado PC</label>
						<label class="label label-default"><?php echo explode(';', $Imagen->imgcdata )[1] ?> </label>
					@endif
		    		<br>
		    		<label>I.E:</label>
		    		{{ $Imagen->ie }}
					<br>
					<label>Docente:</label>
		    		{{ $Imagen->docente }}
					<br>
		    		<label>Codigo Taller:</label>
		    		{{ $Imagen->codigo_taller }}
		    		<br>
		    		<label>Usuario:</label>
		    		{{ $Imagen->username }}
		    		<br>
		    		<label>Nombre:</label>
		    		{{ $Imagen->apellidos }}, {{ $Imagen->nombres }}
		    		<br>
		    		<label>Telefono:</label>
		    		{{ $Imagen->celular }}
		    		<br>
					<label>Dependencia:</label>
		    		{{ $Imagen->sigla }}

		    	</div>
	    	</div>
	    </div>
    </div>

    <div class="row">
	    <div class="col-md-12" id = "all-coincidencias">

	    </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>



</div>
