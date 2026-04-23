
<div class="col-sm-6">

</div>
<div class="col-sm-12" id="resumen">
	<ul class="nav nav-tabs responsive">
	  <li class="active">
		  <a data-toggle="tab" href="#home">
		  <span class="glyphicon glyphicon-open-file"></span>
		  	PROYECTOS
		  </a>
	  </li>
	  <li>
		  <a data-toggle="tab" href="#menu1">
		  <span class="glyphicon glyphicon-compressed"></span>
		  	OBRAS
		  </a>
	  </li>
	  <li>
		  <a data-toggle="tab" href="#menu2">
		  <span class="glyphicon glyphicon-tasks"></span>
		  	ALCANCE
		  </a>
	  </li>
	  <li>
		  <a data-toggle="tab" href="#menu3">
		  <span class="glyphicon glyphicon-paste"></span>
		  	CONTRATO
		  </a>
	  </li>
	</ul>

	<div class="tab-content">
	  <div id="home" class="tab-pane fade in active">
	    <p>
	    <div class="panel panel-primary"">
		  <div class="panel-heading">
		    <h3 class="panel-title">NOMBRE DEL PROYECTO</h3>
		  </div>
		  <div class="panel-body">
		    {{ $proyecto->nom_proyec }}
		  </div>
		</div>
	    	
	  			<label>Código Snip</label>
					<label>{{ $proyecto->cod_snip }}</label><br>

					<label>Provincia</label>
					<label>{{ $proyecto->nom_prov }}</label><br>

					<label>Distrito</label>
					<label>{{ $proyecto->nom_dist }}</label><br>

					<label>Código Unificado</label>
					<label>{{ $proyecto->cod_unif }}</label><br>

					<label>Unidad Formuladora</label>
					<label>{{ $proyecto->u_formul }}</label><br>

					<label>Unidad Ejecutora Actual</label>
					<label>{{ $proyecto->ger_direc }}</label><br>

					<label>Sector</label>
					<label>{{ $proyecto->sector }}</label><br>

					<label>Programa</label>
					<label>{{ $proyecto->progr }}</label><br>

					<label>Sub Programa</label>
					<label>{{ $proyecto->sub_progr }}</label><br>

					<label>Monto Proyecto</label>
					<label>{{ $proyecto->m_pip }}</label><br>

					<label>Monto Viabilidad</label>
					<label>{{ $proyecto->m_viab }}</label><br>

					<label>Monto Expediente Técnico</label>
					<label>{{ $proyecto->m_exptec }}</label><br>

					<label>Estado del Proyecto</label>
					<label>{{ $proyecto->est_pry }}</label><br>

					<label>Tipo</label>
					<label>{{ $proyecto->tipo_pry }}</label><br>

					<label>Beneficiarios</label>
					<label>{{ $proyecto->beneficiarios }}</label><br>
	    </p>
	  </div>
	  <div id="menu1" class="tab-pane fade">
	    <h3>OBRAS</h3>
	    <p>
	    	<!-- INFO OBRAS -->
			@foreach($obras as $o)
				<label> Tipo de Ejecución </label>
				<?php
					switch( $o->tipo ){
						case 'M':
							echo 'META';
							break;
						case 'E':
							echo 'EJECUCIÓN INTEGRAL';
							break;
						case 'S':
							echo 'SALDO DE OBRA';
							break;
					}

				?>
				@if($o->nom_meta == 'M' or $o->nom_meta == 'S')
					<label>Nombre de Meta</label>
					<label>{{ $o->nom_meta }}</label>
				@endif
					<label>Etapa</label>
					<label>{{ $o->etapa }}</label>

					<label>Sub Etapa</label>
					<label>{{ $o->sub_etapa }}</label>

					<label>Estado Situacional</label>
					<label>{{ $o->est_situ }}</label>

					<label>Observación</label>
					<label>{{ $o->obs }}</label>

					<label>Avance Físico</label>
					<label>{{ $o->a_fisico }}</label>

					<label>Fecha Actualización</label>
					<label>{{ $o->fecha_act }}</label>				

					<label>Modalidad de Ejecución</label>
					<label>{{ $o->mod_ejec }}</label>

					<label>Fecha de Inicio</label>
					<label>{{ $o->f_inicio }}</label>

					<label>Fecha de Fin</label>
					<label>{{ $o->f_termino }}</label>

					<label>Tiempo de Ejecución en días</label>
					<label>{{ $o->t_ejec_dias }}</label>
			@endforeach
	    </p>
	  </div>
	  <div id="menu2" class="tab-pane fade">
	    <h3>ALCANCE</h3>
	    <p>
	    	<div class="row">
				<!-- ALCANCE -->
				<table>
				@foreach($alcance as $a)
					<tr>
						<td>{{$a->provincia}}</td>
						<td>{{$a->distrito}}</td>
						<td>{{$a->localidad}}</td>
					</tr>
				@endforeach
				</table>
			</div>
	    </p>
	  </div>
	  <div id="menu3" class="tab-pane fade">
	    <h3>CONTRATO</h3>
	    <p>
	    	<div class="row">
			<!-- INFO CONTRATOS -->
			@foreach($contratos as $c)
				<label>Fecha de Contrato</label>
				<label>{{$c->contrato_fecha}}</label>

				<label>Número de Contrato</label>
				<label>{{$c->contrato_nro}}</label>

				<label>Ejecutora</label>
				<label>{{$c->ejecutora}}</label>

				<label>Contratista</label>
				<label>{{$c->contratista}} RUC: {{$c->contratista_ruc}}</label>

				<label>Monto de Contrato</label>
				<label>{{$c->contrato_moneda}} {{$c->contrato_monto}}</label>

				<label>Tipo de Proceso</label>
				<label>{{$c->tipo_proceso}}</label>
			@endforeach
		</div>
	    </p>
	  </div>
	</div>
</div>

<style type="text/css">
	#resumen{

	}
</style>