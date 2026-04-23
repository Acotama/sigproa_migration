<!DOCTYPE html>
<html>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="icon" href="http://sayhuite.regionlima.gob.pe/sisgeolima/security/auth/images/ico.png">
<head>
	<title>{{ $PipTP['cod_unif'] }}</title>
</head>
<style media="screen">
	table {
					page-break-after: avoid;
	}
</style>
<body>
	<div class="container">
		<header class="container-fluid" style="background-color: white;text-align: center;">
			<img src="images/sys/logo1.gif" width="40%">
		</header>

		<section>
		<br>
		<br>
			<h3><center>{{ $PipTP['nom_proyec'] }}</center></h3>

			<span><h4>I. Datos Técnicos</h4></span>
			<table border="0" style="font-size: 11px" width="100%">
				<tr>
					<td width="1%"><b>1.</b></td>
					<td width="220px"><b>CODIGO SNIP</b></td>
					<td>{{ $PipTP['cod_snip'] }}</td>
				</tr>
				<tr>
					<td><b>2.</b></td>
					<td><b>CODIGO UNICO DE INVERSIONES</b></td>
					<td>{{ $PipTP['cod_unif'] }}</td>
				</tr>
				<tr>
					<td><b>3.</b></td>
					<td><b>NOMBRE DEL PROYECTO</b></td>
					<td>{{ $PipTP['nom_proyec'] }}</td>
				</tr>


				<tr>
					<td><b>4.</b></td>
					<td><b>SECTOR</b></td>
					<td>{{ $PipTP['sector'] }}</td>
				</tr>
				<tr>
					<td><b>5.</b></td>
					<td><b>PROGRAMA</b></td>
					<td>{{ $PipTP['progr'] }}</td>
				</tr>
				<tr>
					<td><b>6.</b></td>
					<td><b>SUB PROGRAMA</b></td>
					<td>{{ $PipTP['sub_progr'] }}</td>
				</tr>
				<tr>
					<td><b>7.</b></td>
					<td><b>BENEFICIARIOS</b></td>
					@if( $PipTP['beneficiarios'] == null)
						<td>0</td>
					@else
						<td>{{ $PipTP['beneficiarios'] }}</td>
					@endif
				</tr>

				<tr>
					<td><b>8.</b></td>
					<td><b>UNIDAD FORMULADORA</b></td>
					<td>{{ $PipTP['u_formul'] }}</td>
				</tr>
				<tr>
					<td><b>9.</b></td>
					<td><b>UNIDAD EJECUTORA</b></td>
					<td>{{ $PipTP['u_ejec'] }}</td>
				</tr>
				<tr>
					<td><b>10.</b></td>
					<td><b>GERENCIA/DIRECCIÓN</b></td>
					<td>{{ $PipTP['ger_direc'] }}</td>
				</tr>

				<tr>
					<td><b>11.</b></td>
					<td><b>DEPARTAMENTO</b></td>
					<td>{{ $PipTP['nom_dpto'] }}</td>
				</tr>
				<tr>
					<td><b>12.</b></td>
					<td><b>PROVINCIA</b></td>
					<td>{{ $PipTP['nom_prov'] }}</td>
				</tr>
				<tr>
					<td><b>13.</b></td>
					<td><b>DISTRITO</b></td>
					<td>{{ $PipTP['nom_dist'] }}</td>
				</tr>
				<tr>
					<td><b>14.</b></td>
					<td><b>CENTRO POBLADO</b></td>
					<td>{{ $PipTP['nom_cp'] }}</td>
				</tr>
				<tr>
					<td><b>15.</b></td>
					<td><b>ALCANCE DEL PROYECTO</b></td>
				</tr>
			</table>
			<br>
			<div>
				<table align="center" border=1 width="95%" style="font-size: 11px;border: 1px solid black;border-collapse: collapse;">
					<thead style="text-align: center;font-weight: bold">
						<tr>
							<td width="25%">Departamento</td>
							<td width="25%">Provincia</td>
							<td width="25%">Distrito</td>
							<td width="25%">Centro Poblado</td>
						</tr>
					</thead>
					<tbody>
						@if(count($Alcance) > 0)
							@foreach($Alcance as $A)
							<tr>
								<td style="text-align: center;">{{ $A->departamento }}</td>
								<td style="text-align: center;">{{ $A->provincia }}</td>
								<td style="text-align: center;">{{ $A->distrito }}</td>
								<td style="text-align: center;">{{ $A->localidad }}</td>
							</tr>
							@endforeach
						@else
						<tr>
							<td style="text-align: center;" colspan="4"><b><i>No se encontró información</b></i></td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>

			<span><h4>II. Datos Financieros (Actualizados al {{$PipTP['f_deveng_a']}})</h4></span>
			<table border="0" style="font-size: 11px" width="100%">
				<tr>
					<td width="1%"><b>16.</b></td>
					<td width="220px"><b>MONTO PIP</b></td>
					<td>S/. {{ number_format($PipTP['m_pip'],2) }}</td>
				</tr>
				<tr>
					<td><b>17.</b></td>
					<td><b>MONTO VIABLE</b></td>
					<td>S/. {{ number_format($PipTP['m_viab'],2) }}</td>
				</tr>
				<tr>
					<td><b>18.</b></td>
					<td><b>EXP. TÉCNICO</b></td>
					<td>S/. {{ number_format($PipTP['m_deveng_a'],2) }}</td>
				</tr>
				<tr>
					<td><b>19.</b></td>
					<td colspan="2"><b>DETALLE FINANCIERO: </b></td>
				</tr>
			</table>
			<br>
			<div>
				<table align="center" border=1 width="95%" style="font-size: 11px;border: 1px solid black;border-collapse: collapse;">
					<thead style="text-align: center;font-weight: bold">
						<tr>
							<td width="30%">Ejecutora</td>
							<td width="14%">Año</td>
							<td width="14%">PIA</td>
							<td width="14%">PIM</td>
							<td width="14%">Certificación</td>
							<td width="14%">Devengado</td>
							<td width="14%">Av. Financiero</td>
						</tr>
					</thead>
					<tbody>
						@if(count($PipTPFin)>0)
							@foreach($PipTPFin as $P)
							<tr>
								<td style="text-align: center;">{{ $P['uni_ejec'] }}</td>
								<td style="text-align: center;">{{ $P['anio_financ'] }}</td>
								<td style="text-align: right;">S/. {{ number_format($P['pia'],2) }}</td>
								<td style="text-align: right;">S/. {{ number_format($P['pim'],2) }}</td>
								<td style="text-align: right;">S/. {{ number_format($P['certif'],2) }}</td>
								<td style="text-align: right;">S/. {{ number_format($P['dev'],2) }}</td>
								@if(empty($P['pim']) or $P['pim']==0)
									<td style="text-align: center;">0.0 %</td>
								@else
									<td style="text-align: center;">{{ number_format($P['dev']/$P['pim']*100,2) }} %</td>
								@endif
							</tr>
							@endforeach
						@else
							<tr>
								<td style="text-align: center;" colspan="6"><b><i>No se encontró información</b></i></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			<br>
			<table border="0" style="font-size: 11px" width="100%">
				<tr>
					<td width="1%"><b>20.</b></td>
					<td width="220px"><b>PIM ACUMULADO GRL</b></td>
					<td>S/. {{ number_format($PipTP['m_pim_acu'],2) }}</td>
				</tr>
				<tr>
					<td><b>21.</b></td>
					<td><b>PIM ACUMULADO TOTAL</b></td>
					<td>S/. {{ number_format($PipTP['m_pim_a_todas_ue'],2) }}</td>
				</tr>
				<tr>
					<td><b>22.</b></td>
					<td><b>DEVENGADO ACUMULADO GRL</b></td>
					<td>S/. {{ number_format($PipTP['m_deveng_a'],2) }}</td>
				</tr>
				<tr>
					<td><b>23.</b></td>
					<td><b>DEVENGADO ACUMULADO TOTAL</b></td>
					<td>S/. {{ number_format($PipTP['m_deveng_a_todas_ue'],2) }}</td>
				</tr>
				<tr>
					<td><b>24.</b></td>
					<td><b>% AV. FINANCIERO TOTAL</b></td>
					<td>{{ $PipTP['a_financ_a'] }} %</td>
				</tr>
				<tr>
					<td><b>25.</b></td>
					<td><b>MONTO POR DEVENGAR TOTAL</b></td>
					<td>S/. {{ number_format($PipTP['m_pip'] - $PipTP['m_deveng_a_todas_ue'],2) }}</td>
				</tr>

			</table>
			<span><h4>III. Estado Situacional (Actualizado al {{$PipTP['f_etapsub']}})</h4></span>
			<table border="0" style="font-size: 11px">
				<tr>
					<td width="1%"><b>26.</b></td>
					<td width="220px"><b>ESTADO DE PROYECTO</b></td>
					<td>{{ $PipTP['est_pry'] }}</td>
				</tr>
				<tr>
					<td><b>27.</b></td>
					<td><b>TIPO DE PROYECTO</b></td>
					<td>{{ $PipTP['tipo_pry'] }}</td>
				</tr>
				<tr>
					<td><b>28.</b></td>
					<td><b>ETAPA</b></td>
					<td>{{ $PipTP['etapa'] }}</td>
				</tr>
				<tr>
					<td><b>29.</b></td>
					<td><b>SUB ETAPA</b></td>
					<td>{{ $PipTP['sub_etapa'] }}</td>
				</tr>

				<tr>
					<td><b>30.</b></td>
					<td><b>SITUACIÓN</b></td>
					@if(isset($formato_12b))
						<td>{{ $formato_12b }}</td>
					@else
						<td>{{ $PipTP['situa_pro'] }}</td>
					@endif
				</tr>
			</table>

			<span style="font-size:10px;"><i><b>* Nota:</b> Situación en base al último estado registrado.</i></span>

			<span><h4>IV. Contrataciones</h4></span>
			<table align="center" border=1 width="95%" style="font-size: 10px;border: 1px solid black;border-collapse: collapse;">
				<thead style="text-align: center;font-weight: bold;font-size: 9px;">
					<tr>
						<th style="text-align:center" width="40%" >DESCRIPCIÓN DE PROCESO</th>
						<th style="text-align:center" >TIPO CONTRATACIÓN</th>
						<th style="text-align:center" >FECHA DE CONVOCATORIA</th>
						<th style="text-align:center" >ESTADO</th>
						<th style="text-align:center" >S/. VALOR REFERENCIAL</th>
						<th style="text-align:center" >TIPO DE PROCESO</th>
						<th style="text-align:center" >NOMENCLATURA</th>
					</tr>
				</thead>
				<tbody>
					@if(count($Contrataciones))
						@foreach($Contrataciones as $row)
						<tr>
							<td style='text-align:center;vertical-align: middle' width='40%'>{{ $row->des_proceso }}</td>
							<td style='text-align:center;vertical-align: middle'>{{ $row->objeto_contratac }}</td>
							<td style='text-align:center;vertical-align: middle'>{{ $row->fec_convocatoria }}</td>
							<td style='text-align:center;vertical-align: middle'>{{ $row->estado }}</td>
							<td style='text-align:center;vertical-align: middle'>{{ number_format($row->valor_refer,0,'.',',') }}</td>
							<td style='text-align:center;vertical-align: middle'>{{ $row->tipo_proceso }}</td>
							<td style='text-align:center;vertical-align: middle'>{{ $row->nomenclatura }}</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td style="text-align: center;" colspan="7"><b><i>No se encontró información</b></i></td>
						</tr>
					@endif
				</tbody>
			</table>

			<span><h4>V. Datos de obra en ejecución</h4></span>
			<table align="center" border=1 width="95%" style="font-size: 11px;border: 1px solid black;border-collapse: collapse;">
				<thead style="text-align: center;font-weight: bold">
					<tr>
						<td width="20%">Obra/Actividad</td>
						<td width="10%">Tipo de Ejecución</td>
						<td width="10%">Etapa - Sub Etapa</td>
						<td width="10%">Avance Físico</td>
						<td width="25%">Descripción</td>
						<td width="15%">Observación</td>
						<td width="10%">Fecha Actualización</td>
					</tr>
				</thead>
				<tbody>
					@if(count($Obras)>0)
						@foreach($Obras as $O)
						<tr>
							<td style="text-align: justify;">{{ $O->nom_proyec . '.' . $O->nom_meta }}</td>
							<td style="text-align: center;"><?php
								switch ($O->tipo) {
									case 'E':
										echo 'INTEGRAL';
										break;
									case 'M':
										echo 'META';
										break;
									case 'S':
										echo 'SALDO DE OBRA';
										break;
								}
							?></td>
							<td style="text-align: center;">{{ $O->etapa .'-'. $O->sub_etapa }}</td>
							<td style="text-align: center;">{{ $O->a_fisico }}</td>
							<td style="text-align: center;">{{ $O->est_situ }}</td>
							<td style="text-align: center;">{{ $O->obs }}</td>
							<td style="text-align: center;">{{ $O->fecha_act }}</td>
						</tr>
						@endforeach
					@else
						<td style="text-align: center;" colspan="7"><b><i>No se ha registrado ejecución<i><b></td>
					@endif
				</tbody>
			</table>
			<br>
			<span style="font-size:10px;"><i><b>* Fuente:</b> SSI-MEF / CONSULTA AMIGABLE-MEF / {{$PipTP['ger_direc']}}</i></span>
			<span><h4>VI. Programación Multianual de inversiones</h4></span>
			@php
				$year= date("Y");
			@endphp
			<table align="center" border=1 width="95%" style="font-size: 11px;border: 1px solid black;border-collapse: collapse;">
				<thead style="text-align: center;font-weight: bold">
					<tr>
						<th width="25%" style="text-align:center;">AÑO {{$year}}</th>
						<th width="25%" style="text-align:center;">AÑO {{$year + 1}}</th>
						<th width="25%" style="text-align:center;">AÑO {{$year + 2 }}</th>
						<th width="25%" style="text-align:center;">AÑO {{$year + 3 }}</th>
					</tr>
				</thead>
				<tbody>
					@if(count($Cartera)>0)
						@foreach($Cartera as $cartera)
							<td style="text-align:center;">{{number_format($cartera->monto_1,2)}}</td>
							<td style="text-align:center;">{{number_format($cartera->monto_2,2)}}</td>
							<td style="text-align:center;">{{number_format($cartera->monto_3,2)}}</td>
							<td style="text-align:center;">{{number_format($cartera->monto_4,2)}}</td>
						@endforeach
					@else
						<td style="text-align: center;" colspan="7"><b><i>Sin información.<i><b></td>
					@endif
				</tbody>
			</table>
			<br>
			<span style="font-size:10px;"><i><b>* Fuente:</b> Ministerio de Economía y Finanzas</i></span>
			<span><h4>VII. Fuente de Financiamiento {{ $year }}</h4></span>
			<table align="center" border=1 width="95%" style="font-size: 11px;border: 1px solid black;border-collapse: collapse;">
				<thead style="text-align: center;font-weight: bold">
					<tr>
						<th style="vertical-align: middle;text-align: left;">FUENTE DE FINANCIAMIENTO</th>
						<th style="vertical-align: middle;text-align: center;">PIM</th>
						<th style="vertical-align: middle;text-align: center;">CERTIFICADO</th>
						<th style="vertical-align: middle;text-align: center;">DEVENGADO</th>
						<th style="vertical-align: middle;text-align: center;">GIRADO</th>
						<th style="vertical-align: middle;text-align: center;">% AVANCE</th>
					</tr>
				</thead>
				<tbody>
					@if(count($fuente_financiamiento) > 0)
						@foreach($fuente_financiamiento as $fuente)
							<tr>
								<td style="text-align: left;">{{$fuente->fuente_financiamiento}}</td>
								<td style="text-align: center;">{{number_format($fuente->pim_dia,2)}}</td>
								<td style="text-align: center;">{{number_format($fuente->certificacion_dia,2)}}</td>
								<td style="text-align: center;">{{number_format($fuente->dev_dia,2)}}</td>
								<td style="text-align: center;">{{number_format($fuente->girado_dia,2)}}</td>
								@if($fuente->pim_dia==0)
								<td  style="text-align: center;white-space: nowrap;">0.00</td>
								@else
								<td style="text-align: center;">{{number_format(($fuente->dev_dia/$fuente->pim_dia)*100,2)}}</td>
								@endif
							</tr>
						@endforeach
					@else
						<tr>
							<td style="text-align: center;" colspan="6">No se encontró información</td>
						</tr>
					@endif
				</tbody>
			</table>
			<br>
		</section>
	</div>
</body>
</html>
