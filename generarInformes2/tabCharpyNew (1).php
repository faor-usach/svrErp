				<p class="blanco" >&nbsp;</p>
				<?php
				$letraItem++;
				echo '<p class="blanco">';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Ensayo de impacto:</b></span>';
				echo '</p>';
				$i=1;
				?>

				<p class="blanco" >&nbsp;</p>

				<p class="inter15">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se presentan los resultados 
					del ensayo de impacto realizados a la muestra recibida, según ASTM E23.
				</p>

				<p class="blanco" >&nbsp;</p>

				<?php
				$cRef = 'No';
				$i	  = 0;
				$bdOT=mysql_query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Ch' Order By Otam");
				if($rowOT=mysql_fetch_array($bdOT)){
					do{
						$i++;
						if($rowOT['idEnsayo']=='Ch'){
							if($rowTabEns['Ref']=='CR'){
								$cRef = 'SiCh';
							}
							if($i==1){
								echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de impacto. </span>';
							}
							tablaCharpy($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra'], $rowOT['Ind'], $rowOT['Tem']);
						}
					}while($rowOT=mysql_fetch_array($bdOT));
				}
				if($cRef == 'SiCh'){
					RefTablaCharpy($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra'], $rowOT['Ind'], $rowOT['Tem']);
				}
				?>
				<p class="blanco" >&nbsp;</p>
