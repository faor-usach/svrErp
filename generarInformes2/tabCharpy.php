				<?php
				$letraItem++;
				echo '<p>';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Ensayo de impacto:</b></span>';
				echo '</p>';
				$i=1;
				?>
				<p style="text-indent: 60px; line-height:16pt;" align="justify">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se presentan los resultados 
					del ensayo de impacto realizados a la muestra recibida, según ASTM E23.
				</p>
				<?php
				$cRef = 'No';
				for($i=1; $i<=$rowTabEns['cEnsayos']; $i++){
							// Charpy
							if($rowTabEns['idEnsayo']=='Ch'){
								if($rowTabEns['Ref']=='CR'){
									$cRef = 'SiCh';
								}
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-Ch'.$i;
								if($i<10){
									$tq = $ta[1].'-Ch0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de impacto. </span>';
								}
								tablaCharpy($CodInforme, $tq, $rowTabEns['tpMuestra'], $rowTabEns['Ind'], $rowTabEns['Tem']);
							}
				}
				if($cRef == 'SiCh'){
					RefTablaCharpy($CodInforme, $tq, $rowTabEns['tpMuestra'], $rowTabEns['Ind'], $rowTabEns['Tem']);
				}
				?>
