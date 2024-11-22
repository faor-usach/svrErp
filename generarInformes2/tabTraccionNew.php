				<p class="blanco" >&nbsp;</p>
				<?php
				$letraItem++;
				echo '<p class="blancoSubTitulos">';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Resultados de Ensayos de Tracci&oacute;n:</b></span>';
				echo '</p>';
				$i=1;
				?>

				<p class="blanco" >&nbsp;</p>

				<p class="inter15">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se presentan los resultados 
					del ensayo de tracci&oacute;n realizado a las muestras recibidas.
				</p>

				<p class="blanco" >&nbsp;</p>

				<?php
				$cRef 	= 'No';
				$i	  	= 0;
				$nro 	= 0;
				$tpMuestraCtrl = '';
				$tpMuestraAnt = '';
				$tabla	= 'Cerrada';
				
				$bdOT=$link->query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Tr' Order By Otam");
				if($rowOT=mysqli_fetch_array($bdOT)){
					do{
						$i++;
						if($tpMuestraCtrl != $rowOT['tpMuestra']){
							$tpMuestraAnt	= $tpMuestraCtrl;
							$tpMuestraCtrl  = $rowOT['tpMuestra'];
							$i = 1;
							if($tabla == 'Abierta'){
								if($cRef=='Si'){
									$cRef = 'No';
									imprimeTablaReferencia($tpMuestraAnt);
								}
								echo '</table>';
								$tabla = 'Cerrada';
							}
							echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de tracci&oacute;n. </span>';
							$tabla	= 'Abierta';
							encabezadoTraccion($rowOT['tpMuestra']);
						}
						if($tpMuestraCtrl == $rowOT['tpMuestra']){
							if($rowTabEns['Ref']=='CR'){
								$cRef = 'Si';
							}
							datosTraccion($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}
/*						
						if($rowOT['tpMuestra']=='Re'){
							$nro++;
							if($rowTabEns['Ref']=='CR'){
								$cRef = 'SiTrRe';
							}
							if($i==1){
								//echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de tracci贸n. </span>';
							}
							tablaTraccionRe($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra'], $nro);
						}

						// Tracci髇 - Plana
						if($rowOT['tpMuestra']=='Pl'){
							if($rowTabEns['Ref']=='CR'){
								$cRef = 'SiTrPl';
							}
							if($i==1){
								//echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de tracci贸n. </span>';
							}
							tablaTraccionPl($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}
*/						
					}while($rowOT=mysqli_fetch_array($bdOT));
					if($tabla == 'Abierta'){
						if($cRef=='Si'){
							$cRef = 'No';
							imprimeTablaReferencia($tpMuestraCtrl);
						}
						echo '</table>';
					}
				}
				if($cRef == 'SiTrRe'){
					RefTablaTraccionRe($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
				}
				if($cRef == 'SiTrPl'){
					RefTablaTraccionPl($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
				}
				?>
				<p class="blanco" >&nbsp;</p>
