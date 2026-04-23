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
				
				$arr = $data;				
				foreach ($arrEjec as $key => $value) {
					$tmpUgel = $key;
					$dtmpUgel = $value;
					$first = true;					
					foreach ($arr as $key => $value) {
						if($first){?>
									<tr><td colspan="2"><b><?php echo $dtmpUgel ?> </b></td><td>Programación: <?php echo $arr[$key]->fecha ?><td></tr>
									<tr style="text-align: center;font-weight: bold">
										<td style="border: 1px solid #000000">Cargo</td>
										<td style="border: 1px solid #000000">Nombre</td>
										<td style="border: 1px solid #000000">Celular</td>
									</tr>
								
									<tr>
										
										<td style="border: 1px solid #000000">Director</td>
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->director ?></td>
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->celdirector ?></td>
									</tr>	
									<tr>
										
										<td style="border: 1px solid #000000">Gestor</td>
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->gestor ?></td>
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->celgestor ?></td>										
									</tr>	
									<tr>
										
										<td style="border: 1px solid #000000">AGP</td>
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->agp ?></td>
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->celagp ?></td>
									</tr>																
									<tr></tr>
									<tr style="text-align: center;font-weight: bold">
										<!--th>A.Operativa</th-->
										<td style="border: 1px solid #000000">Distrito</td>
										<!--th width="20%">Fecha</th-->
										<td style="border: 1px solid #000000">Acompañante</td>
										<td style="border: 1px solid #000000">Estado de Actividad</td>
									</tr>
						<?php
							$first = false;
						}						
						if($tmpUgel == $arr[$key]->ejecutora){?>
									<tr>
										<!--td><?php echo $arr[$key]->activ_operativa ?></td-->
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->nom_dist ?></td>
										<!--td style="text-align: center;"><?php echo $arr[$key]->fecha ?></td-->
										<td style="border: 1px solid #000000"><?php echo $arr[$key]->nombre_usuario ?></td>
										<td style="border: 1px solid #000000;text-align: center;background-color: <?php echo $arr[$key]->estado=="COMPLETO" ? "#09a960" :"##dd4b39";  ?>"><?php echo $arr[$key]->estado ?></td>
									</tr>								

							<?php
							unset($arr[$key]);
						}					
					}
					?>
					<tr></tr>
					<tr></tr>
					<tr></tr>
					<tr></tr>
					<?php
				}
				
			?>

</html>