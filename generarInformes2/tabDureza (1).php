				<?php
				$letraItem++;
				echo '<p>';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Ensayo de Dureza:</b></span>';
				echo '</p>';
				$i=1;
				?>
				<p style="text-indent: 60px; line-height:16pt;" align="justify">
					La medición de dureza fue realizada en escala Rockwell C. La tabla <?php echo $letraItem.'.'.$i; ?> muestra los resultados del ensayo realizado a la muestra recibida.
				</p>
				<?php
				$cRef = 'No';
				for($i=1; $i<=$rowTabEns[cEnsayos]; $i++){
					?>
						<?php
							// Charpy
							if($rowTabEns[idEnsayo]=='Du'){
								if($rowTabEns[Ref]=='CR'){
									$cRef = 'SiDu';
								}
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-D'.$i;
								if($i<10){
									$tq = $ta[1].'-D0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de las durezas. </span>';
								}
								tablaDureza($CodInforme, $tq, $rowTabEns[tpMuestra], $rowTabEns[Ind]);
							}
						?>
					<?php
				}
				if($cRef == 'SiDu'){
					RefTablaDureza($CodInforme, $tq, $rowTabEns[tpMuestra], $rowTabEns[Ind]);
				}
				?>
