				<p class="blanco" >&nbsp;</p>
				<?php
				$letraItem++;
				echo '<p class="blancoSubTitulos">';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Ensayo de Impacto:</b></span>';
				echo '</p>';
				$i=1;
				?>

				<p class="blanco" >&nbsp;</p>

				<p class="inter15">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se presentan los resultados 
					del ensayo de impactos realizados a la muestra recibida, seg&uacute;n ASTM E23.
					<?php
						$txtEntalle = 'Las probetas ensayadas no poseen entalle de dimensiones ';
						$bdEN=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."'");
						if($rowEN=mysqli_fetch_array($bdEN)){
							$mm = $rowEN['mm'];
							if(intval($rowEN['mm']) == $rowEN['mm']){
								$mm = intval($rowEN['mm']);
							}
							if($rowEN['Entalle'] == 'Con'){
								$txtEntalle = 'Las probetas ensayadas poseen entalle de dimensiones ';
								if($rowEN['mm'] == 10){
									$txtEntalle .= 'estándar de '.$mm.'mm de ancho.';
								}else{
									$txtEntalle .= 'sub-estándar de '.$mm.' mm de ancho.';
								}
							}else{
								if($rowEN['mm'] == 10){
									$txtEntalle .= 'estándar de '.$mm.'mm de ancho.';
								}else{
									$txtEntalle .= 'sub-estándar de '.$mm.' mm de ancho.';
								}
							}
						}
						echo utf8_decode($txtEntalle);
					?>
				</p>

				<p class="blanco" >&nbsp;</p>

				<?php
				$cRef = 'No';
				$i	  = 0;
				$tpMuestraCtrl 	= '';
				$tpMuestraAnt 	= '';
				$tabla			= 'Cerrada';
				$nImpacto		= 0;
				
				$bdOT=$link->query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Ch' Order By Otam");
				if($rowOT=mysqli_fetch_array($bdOT)){
					do{
						$i++;
						if($tpMuestraCtrl != $rowOT['tpMuestra']){
							$tpMuestraAnt	= $tpMuestraCtrl;
							$tpMuestraCtrl  = $rowOT['tpMuestra'];
							$nImpacto		= $rowOT['Ind'];
							$Tem			= $rowOT['Tem'];
							$i = 1;
							if($tabla == 'Abierta'){
								if($cRef=='Si'){
									$cRef = 'No';
									imprimeTablaReferenciaCharpy($tpMuestraAnt, $nImpacto);
								}
								echo '</table>';
								$tabla = 'Cerrada';
							}
							echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de los ensayos de impacto. </span>';
							$tabla	= 'Abierta';
							encabezadoCharpy($rowOT['tpMuestra'], $rowOT['Ind'], $rowOT['Tem']);
						}
						if($tpMuestraCtrl == $rowOT['tpMuestra']){
							if($rowTabEns['Ref']=='CR'){
								$cRef = 'Si';
							}
							datosCharpy($CodInforme, $rowOT['Ind'], $rowOT['Otam'], $rowOT['tpMuestra']);
						}
					}while($rowOT=mysqli_fetch_array($bdOT));
					if($tabla == 'Abierta'){
						if($cRef=='Si'){
							$cRef = 'No';
							imprimeTablaReferenciaCharpy($tpMuestraCtrl, $nImpacto);
						}
						echo '</table>';
					}
				}
				?>
				<p class="blanco" >&nbsp;</p>
