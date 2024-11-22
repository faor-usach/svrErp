				<p class="blanco" >&nbsp;</p>
				<?php 
				$letraItem++;
				echo '<p class="blancoSubTitulos">';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Resultados de An&aacute;lisis Qu&iacute;mico:</b></span>';
				echo '</p>';
				$i=1;
				?>

				<p class="blanco" >&nbsp;</p>

				<!-- <p style="text-indent: 60px; line-height:15pt;" align="justify"> -->
				<p class="inter15">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se muestran los valores resultantes del an&aacute;lisis qu&iacute;mico, 
					obtenido mediante espectrometr&iacute;a de emisi&oacute;n &oacute;ptica.
				</p>
				
				<p class="blanco" >&nbsp;</p>
				
				<?php
				$cRef = 'No';
				$i	  = 0;
				$bdOT=$link->query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Qu' Order By Otam");
				if($rowOT=mysqli_fetch_array($bdOT)){
					do{
						$i++;
						if($rowOT['tpMuestra']=='Ac' and $rowTabEns['Ref']=='SR'){
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de an&aacute;lisis qu&iacute;mico.</span>';
							}
							tablaQuimicoSR($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}
						
						if($rowOT['tpMuestra']=='Ac' and $rowTabEns['Ref']=='CR'){
							$cRef = 'SiQuAc';
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de an&aacute;lisis qu&iacute;mico.</span>';
							}
							tablaQuimicoSR($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}
						// Químico - Cobre
						if($rowOT['tpMuestra']=='Co' and $rowTabEns['Ref']=='SR'){
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de an&aacute;lisis qu&iacute;mico.</span>';
							}
							tablaQuimicoCoSR($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}
						if($rowOT['tpMuestra']=='Ac' and $rowTabEns['Ref']=='CR'){
							$cRef = 'SiQuCo';
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de an&aacute;lisis qu&iacute;mico.</span>';
							}
							tablaQuimicoCoSR($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}
						
						// Químico - Aluminio
						if($rowOT['tpMuestra']=='Al' and $rowTabEns['Ref']=='SR'){
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de an&aacute;lisis qu&iacute;mico.</span>';
							}
							tablaQuimicoAl($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}
						if($rowOT['tpMuestra']=='Al' and $rowTabEns['Ref']=='SR'){
							$cRef = 'SiQuAl';
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de an&aacute;lisis qu&iacute;mico.</span>';
							}
							tablaQuimicoAl($CodInforme,$rowOT['Otam'], $rowOT['tpMuestra']);
						}
					}while($rowOT=mysqli_fetch_array($bdOT));
				}
				if($cRef == 'SiQuAc'){
					ReftablaQuimicoCR();
				}
				if($cRef == 'SiQuCo'){
					ReftablaQuimicoCo();
				}
				if($cRef == 'SiQuAl'){
					ReftablaQuimicoAl();
				}
				?>
				<p class="blanco" >&nbsp;</p>
