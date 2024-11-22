				<p class="blanco" >&nbsp;</p>
				<?php
				$letraItem++;
				echo '<p class="blancoSubTitulos">';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Ensayo de Dureza:</b></span>';
				echo '</p>';
				$i=1;
				?>

				<p class="blanco" >&nbsp;</p>

				<p class="inter15">
					<?php
					$bdtMu=$link->query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$rowTabEns['idEnsayo']."' and tpMuestra = '".$rowTabEns['tpMuestra']."'");
					if($rowtMu=mysqli_fetch_array($bdtMu)){
						$tipoEnsayo = $rowtMu['tipoEnsayo'];
					}
					?>
					La medici&oacute;n de dureza fue realizada en escala <?php echo $tipoEnsayo; ?>. La tabla <?php echo $letraItem.'.'.$i; ?> muestra los resultados del ensayo realizado a la muestra recibida.
				</p>

				<p class="blanco" >&nbsp;</p>

				<?php
				$cRef 			= 'No';
				$i	  			= 0;
				$tpMuestraCtrl 	= '';
				$tpMuestraAnt 	= '';
				$tabla			= 'Cerrada';
				$nIndenta		= 0;
				$mIndenta		= 0;
/*
				$bdOT=$link->query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Du' Order By tpMuestra, Ind Desc");
				if($rowOT=mysqli_fetch_array($bdOT)){
					$mIndenta = $rowOT['Ind'];
				}
*/				
				$bdOT=$link->query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Du' Order By tpMuestra, Ind Desc, Otam");
				if($rowOT=mysqli_fetch_array($bdOT)){
					do{
						$i++;
						if($tpMuestraCtrl != $rowOT['tpMuestra']){
							$tpMuestraAnt	= $tpMuestraCtrl;
							$tpMuestraCtrl  = $rowOT['tpMuestra'];
							$nIndenta		= $rowOT['Ind'];
							$i = 1;
							if($tabla == 'Abierta'){
								if($cRef=='Si'){
									$cRef = 'No';
									imprimeTablaReferenciaDureza($tpMuestraAnt, $nIndenta);
									//imprimeTablaReferenciaDureza($tpMuestraAnt, $mIndenta);
								}
								echo '</table>';
								$tabla = 'Cerrada';
							}
							echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de las durezas. </span>';
							$tabla	= 'Abierta';
							encabezadoDureza($rowOT['tpMuestra'], $rowOT['Ind']);
							$mIndenta = $rowOT['Ind'];
							//encabezadoDureza($rowOT['tpMuestra'], $mIndenta);
						}
						if($tpMuestraCtrl == $rowOT['tpMuestra']){
							if($rowTabEns['Ref']=='CR'){
								$cRef = 'Si';
							}
							datosDureza($CodInforme, $rowOT['Ind'], $rowOT['Otam'], $rowOT['tpMuestra'], $mIndenta);
						}
					}while($rowOT=mysqli_fetch_array($bdOT));
					if($tabla == 'Abierta'){
						if($cRef=='Si'){
							$cRef = 'No';
							//imprimeTablaReferenciaDureza($tpMuestraCtrl, $nIndenta);
							imprimeTablaReferenciaDureza($tpMuestraCtrl, $mIndenta);
						}
						echo '</table>';
					}
				}
				?>
				<p class="blanco" >&nbsp;</p>

<?php
/*						
						if($rowOT['idEnsayo']=='Du'){
							if($rowTabEns['Ref']=='CR'){
								$cRef = 'SiDu';
							}
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de las durezas. </span>';
							}
							tablaDureza($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra'], $rowOT['Ind']);
						}


				if($cRef == 'SiDu'){
					RefTablaDureza($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra'], $rowOT['Ind']);
				}
*/						
?>