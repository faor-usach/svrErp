				<?php 
				$letraItem++;
				echo '<p>';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Resultados de An�lisis Qu�mico:</b></span>';
				echo '</p>';
				$i=1;
				?>
				<p style="text-indent: 60px; line-height:24px;" align="justify">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se muestran los valores resultantes del an�lisis qu�mico, 
					obtenido mediante Espectrometr�a de Emisi�n �ptica.
				</p>
				<?php
				$cRef = 'No';
				$i	  = 0;
				$bdOT=mysql_query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Qu' Order By Otam");
				if($rowOT=mysql_fetch_array($bdOT)){
					do{
						$i++;
						if($i==1){
							echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de an�lisis qu�mico.</span>';
						}
						tablaOtra($CodInforme, $rowOT['Otam'], $rowOT[tpMuestra]);
						
					}while($rowOT=mysql_fetch_array($bdOT));
				}
				if($cRef == 'SiQuAl'){
					ReftablaOtra();
				}
				?>
