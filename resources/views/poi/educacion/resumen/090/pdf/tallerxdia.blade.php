<!DOCTYPE html>
<html>
	<meta charset="utf-8">   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="icon" href="http://sayhuite.regionlima.gob.pe/sisgeolima/security/auth/images/ico.png">    
<head>
	<title>Reporte Taller por día</title>
</head>
<body>
<style type="text/css">
	h2 {
		page-break-before: always;
	}
	h2:first-of-type {
            page-break-before: avoid;
        }
</style>
	<div class="container">
		<header class="container-fluid" style="background-color: white">
			<div style="width: 33%;float: left;">
				<img src="images/sys/logo1.gif" width="80%">
			</div>
			<div style="width: 33%;float: left;">
				<img src="images/sys/sayhuite.png" width="80%">
			</div>
			<div style="width: 33%;float: left;">
				<img src="images/sys/slogan2.gif" width="80%">
			</div>			
		</header>

		<section>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
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
				
				$arr = $data;				
				foreach ($arrEjec as $key => $value) {
					$tmpUgel = $key;
					$dtmpUgel = $value;
					$first = true;					
					foreach ($arr as $key => $value) {
						if($first){?>
							<h2><?php echo $dtmpUgel ?></h2><h4> Programación: <?php echo $arr[$key]->fecha ?></h4>
							<table border=1 align="right" width="50%" style="font-size: 12px;border: 1px solid black;border-collapse: collapse;">
								<thead style="text-align: center;font-weight: bold">
									<tr>
										
										<th  width="10%">Cargo</th>
										<th  width="30%">Nombre</th>
										<th  width="10%">Celular</th>
									</tr>
								</thead>			
								<tbody>
									<tr>
										
										<td>Director</td>
										<td><?php echo $arr[$key]->director ?></td>
										<td><?php echo $arr[$key]->celdirector ?></td>
									</tr>	
									<tr>
										
										<td>Gestor</td>
										<td><?php echo $arr[$key]->gestor ?></td>
										<td><?php echo $arr[$key]->celgestor ?></td>										
									</tr>	
									<tr>
										
										<td>AGP</td>
										<td><?php echo $arr[$key]->agp ?></td>
										<td><?php echo $arr[$key]->celagp ?></td>
									</tr>	
								</tbody>
							</table>
							<br>
							<br>
							<br>
							<br>
							<br>
							<table align="center" border=1 width="100%" style="font-size: 12px;border: 1px solid black;border-collapse: collapse;">
								<thead style="text-align: center;font-weight: bold">
									<tr>
										<!--th>A.Operativa</th-->
										<th width="20%">Distrito</th>
										<!--th width="20%">Fecha</th-->
										<th width="60%">Acompañante</th>
										<th width="20%">Estado de Actividad</th>
									</tr>
								</thead>
								<tbody>
						<?php
							$first = false;
						}						
						if($tmpUgel == $arr[$key]->ejecutora){?>
									<tr>
										<!--td><?php echo $arr[$key]->activ_operativa ?></td-->
										<td><?php echo $arr[$key]->nom_dist ?></td>
										<!--td style="text-align: center;"><?php echo $arr[$key]->fecha ?></td-->
										<td><?php echo $arr[$key]->nombre_usuario ?></td>
										<td style="text-align: center;background-color: <?php echo $arr[$key]->estado=="COMPLETO" ? "rgb(75, 191, 111)" :"";  ?>"><?php echo $arr[$key]->estado ?></td>
									</tr>								

							<?php
							unset($arr[$key]);
						}					
					}
					?>
						</tbody>
					</table>
					<?php
				}
				
			?>
			
		</section>

	

	</div>
</body>
</html>