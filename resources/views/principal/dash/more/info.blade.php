
	
		<!--label class="label label-success">Pim Acumulado Total: {{ $resumen['PIM_ACUMULADO'] }} </label><br>
		<label class="label label-success">Devengado Acumulado Total: {{ $resumen['DEVENGADO_ACUMULADO'] }}</label><br>
		<label class="label label-success">A. Financiero Acumulado Total: {{ $resumen['AVANCE_FINANCIERO_ACUMULADO'] }}</label><br>
		<label class="label label-success">Pim {{ $proyectos[0]->ult_anio_ejec_pry_financ }} Total: {{ $resumen['DEVENGADO_ACTUAL'] }}</label><br>
		<label class="label label-success">Devengado {{ $proyectos[0]->ult_anio_ejec_pry_financ }} Total: {{ $resumen['PIM_ACTUAL'] }}</label><br>
		<label class="label label-success">Girado {{ $proyectos[0]->ult_anio_ejec_pry_financ }} Total: {{ $resumen['GIRADO_ACTUAL'] }}</label><br>
		<label class="label label-success">A. Financiero {{ $proyectos[0]->ult_anio_ejec_pry_financ }} Total: {{ $resumen['AVANCE_FINANCIERO_ACTUAL'] }}</label><br-->

<div class="table-responsive" style="height: 500px;overflow: scroll;">

<table border="1" class="table table-hover table-bordered">
	<thead>
		<tr border="0">
			<th style="text-align: center; width: 15%"></th>
			<th style="text-align: center; width: 3%"></th>
			<th style="text-align: center; width: 3%"></th>
			<th style="text-align: center; width: 3%"></th>
			<!--th>Monto Viable</th-->
			<!--th>Monto Exp. Tec.</th-->
			<th style="text-align: center; width: 3%">
				<label class="label label-success">Total: S/.{{ number_format($resumen['PIM_ACUMULADO'], 2, '.', ',') }} </label>
			</th>
			<th style="text-align: center; width: 3%">
				<label class="label label-success">Total: S/.{{ number_format($resumen['DEVENGADO_ACUMULADO'], 2, '.', ',') }}</label>
			</th>
			<th style="text-align: center; width: 3%">
				<!--label class="label label-success">Total: {{ number_format( ( ($resumen['DEVENGADO_ACUMULADO'] / $resumen['PIM_ACUMULADO']) ) , 2, '.', ',') }} %</label-->
			</th>
			<th style="text-align: center; width: 3%">
				<label class="label label-success">Total: S/.{{ number_format($resumen['DEVENGADO_ACTUAL'], 2, '.', ',') }}</label>
			</th>
			<th style="text-align: center; width: 3%">
				<label class="label label-success">Total: S/.{{ number_format($resumen['PIM_ACTUAL'], 2, '.', ',') }}</label>
			</th>
			<th style="text-align: center; width: 3%">
				<label class="label label-success">Total: S/.{{ number_format($resumen['GIRADO_ACTUAL'], 2, '.', ',') }}</label>
			</th>
			<th style="text-align: center; width: 3%">
				<label class="label label-success">Total: {{ number_format(  ( ($resumen['DEVENGADO_ACTUAL'] / $resumen['PIM_ACTUAL']) * 100 )  , 2, '.', ',') }} %</label>
			</th>			
			<th style="text-align: center; width: 1%"></th>
		</tr>
		<tr style="background-color: #3c8dbc;color:white;">
			<th style="text-align: center; width: 15%">Nombre Proyecto</th>
			<th style="text-align: center; width: 3%">C. Unificado</th>
			<th style="text-align: center; width: 3%">Monto Proyecto</th>
			<th style="text-align: center; width: 3%">Ejecutora</th>
			<!--th>Monto Viable</th-->
			<!--th>Monto Exp. Tec.</th-->
			<th style="text-align: center; width: 3%">Pim Años Anteriores </th>
			<th style="text-align: center; width: 3%">Devengado Años Anteriores</th>
			<th style="text-align: center; width: 3%">A. Financiero Acumulado</th>

			<th style="text-align: center; width: 3%">Pim {{ $proyectos[0]->ult_anio_ejec_pry_financ }}</th>			
			<th style="text-align: center; width: 3%">Devengado {{ $proyectos[0]->ult_anio_ejec_pry_financ }}</th>
			<th style="text-align: center; width: 3%">Girado {{ $proyectos[0]->ult_anio_ejec_pry_financ }}</th>

			<th style="text-align: center; width: 3%">A. Financiero {{ $proyectos[0]->ult_anio_ejec_pry_financ }}</th>			
			<th style="text-align: center; width: 1%"></th>
		</tr>	
	</thead>
	<tbody>
	@foreach($proyectos as $p)
		<tr>
			<td>{{ $p->nom_proyec }}</td>
			<td style="text-align: center;">{{ $p->cod_unif }}</td>
			<td style="text-align: right;">{{ number_format($p->m_pip, 2, '.', ',') }}</td>
			<td style="text-align: center;">{{ $p->ger_direc }}</td>
			<!--td>{{ $p->m_viab }}</td-->
			<!--td>{{ $p->m_exptec }}</td-->			
			<td style="text-align: right;">{{ number_format($p->m_pim_acu, 2, '.', ',') }}</td>
			<td style="text-align: right;">{{ number_format($p->m_deveng_a, 2, '.', ',') }}</td>
			<td style="text-align: right;">{{ number_format($p->a_financ_a, 2, '.', ',') }}</td>
			<td style="text-align: right;">{{ number_format($p->m_pim, 2, '.', ',') }}</td>			
			<td style="text-align: right;">{{ number_format($p->m_deveng, 2, '.', ',') }}</td>
			<td style="text-align: right;">{{ number_format($p->girado, 2, '.', ',') }}</td>
			<td style="text-align: right;">{{ number_format($p->a_financ, 2, '.', ',') }}</td>

			<td style="text-align: center;">
				<button class="btn btn-info"><i class="fa fa-eye"></i></button>
				<button class="btn btn-primary"><i class="fa fa-list"></i></button>
			</td>
			
		</tr>
	@endforeach

	</tbody>
</table>

</div>