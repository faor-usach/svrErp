				<?php
				$letraItem++;
				echo '<p>';
					echo '<b>'.$letraItem.'.- <span style="text-decoration:underline;">Ensayo de Dureza:</span></b>';
				echo '</p>';
				$i=1;
				?>
				<p style="margin-left:60px;" align="justify">
					La medición de dureza fue realizada en escala Rockwell C. La tabla <?php echo $letraItem.'.'.$i; ?> muestra los resultados del ensayo realizado a la muestra recibida.
				</p>
				<?php
				$cRef = 'No';
				for($i=1; $i<=$rowTabEns[cEnsayos]; $i++){
					?>
					<p>
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
									echo '<span style="font-size:0.9em;">Tabla '.$letraItem.'.'.$i.' Resultados de las durezas. </span>';
								}
								tablaDureza($tq);
							}
						?>
					</p>
					<?php
				}
				if($cRef == 'SiDu'){
					RefTablaDureza();
				}
				?>
