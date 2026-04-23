<!DOCTYPE html>
<html>	

	<tr>
		<td>
			<img src="images/sys/logo1.gif" height="100%">
		</td>
		<td>
			<img src="images/sys/sayhuite.png" height="100%">
		</td>
		<td>
			<!-- <img src="images/sys/slogan2.gif" height="100%"> -->
		</td>
	</tr>

	<?php

        $arrEjec = [
            'UGEL 08' => 'UGEL 08 - CAÑETE',
            'UGEL 09' => 'UGEL 09 - HUAURA',
            'UGEL 10' => 'UGEL 10 - HUARAL',
            'UGEL 11' => 'UGEL 11 - CAJATAMBO',
            'UGEL 12' => 'UGEL 12 - CANTA',
            'UGEL 13' => 'UGEL 13 - YAUYOS',
            'UGEL 14' => 'UGEL 14 - OYON',
            'UGEL 15' => 'UGEL 15 - HUAROCHIRI',
            'UGEL 16' => 'UGEL 16 - BARRANCA'
        ];
        
        $arrState = [
            'programmed' => 'Planificado',
            'passed' => 'Incompleto',
            'complete' => 'Programado'            
        ];

        $StyleState = [
            'programmed' => ';background-color:#f39c12;',
            'passed' => ';background-color:#dd4b39;',
            'complete' => ';background-color:#00a65a;'
        ];
       
	?>
    <tr style="text-align: center;font-weight: bold">
            <td style="border: 1px solid #000000">Actividad Operativa</td>
            <td style="border: 1px solid #000000">Alias Actividad Operativa</td>
            <td style="border: 1px solid #000000">Ejecutora</td>
            <td style="border: 1px solid #000000">Fecha</td>
            <td style="border: 1px solid #000000">Código Taller</td>
            <td style="border: 1px solid #000000">Responsable Institucional</td>
            <td style="border: 1px solid #000000">Docente/Cantidad Docente</td>
            <td style="border: 1px solid #000000">I.E.</td>
            <td style="border: 1px solid #000000">Distrito</td>
            <td style="border: 1px solid #000000">Responsable Operativo</td>
            <td style="border: 1px solid #000000">DNI Responsable Operativo</td>
            <td style="border: 1px solid #000000">Intervención</td>
            <td style="border: 1px solid #000000">Estado</td>
    </tr>
    @foreach($data as $d)
        <tr style="text-align: center">
            <td style="border: 1px solid #000000">{{ $d->activ_operativa }}</td>
            <td style="border: 1px solid #000000">{{ $d->tipo_activ_operativa }}</td>
            <td style="border: 1px solid #000000">{{ $d->ejecutora }}</td>
            <td style="border: 1px solid #000000">{{ $d->fecha }}</td>
            <td style="border: 1px solid #000000">{{ $d->codigo_taller }}</td>
            <td style="border: 1px solid #000000">{{ $d->resp_institucional }}</td>
            <td style="border: 1px solid #000000">{{ $d->docente }}</td>
            <td style="border: 1px solid #000000">{{ $d->ie }}</td>
            <td style="border: 1px solid #000000">{{ $d->nom_dist }}</td>
            <td style="border: 1px solid #000000">{{ $d->nombre_usuario }}</td>
            <td style="border: 1px solid #000000">{{ $d->dni }}</td>
            <td style="border: 1px solid #000000">{{ $d->intervencion }}</td>
            <td style="border: 1px solid #000000; {{ $StyleState[$d->state] }} ">{{ $arrState[$d->state] }}</td>
        </tr>
    @endforeach

</html>