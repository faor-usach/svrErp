				<?php
				$letraItem++;
				echo '<p>';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Resultados de Ensayos de Tracción:</b></span>';
				echo '</p>';
				$i=1;
				?>
				<p style="text-indent: 60px; line-height:16pt;" align="justify">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se presentan los resultados 
					del ensayo de tracción realizado a las muestras recibidas.
				</p>
				<?php
				$cRef = 'No';
				for($i=1; $i<=$rowTabEns[cEnsayos]; $i++){
							// Tracción - Redonda
							if($rowTabEns[idEnsayo]=='Tr' and $rowTabEns[tpMuestra]=='Re'){
								if($rowTabEns[Ref]=='CR'){
									$cRef = 'SiTrRe';
								}
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-T'.$i;
								if($i<10){
									$tq = $ta[1].'-T0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de tracción. </span>';
								}
								tablaTraccionRe($CodInforme, $tq, $rowTabEns[tpMuestra]);
							}

							// Tracción - Plana
							if($rowTabEns[idEnsayo]=='Tr' and $rowTabEns[tpMuestra]=='Pl'){
								if($rowTabEns[Ref]=='CR'){
									$cRef = 'SiTrPl';
								}
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-T'.$i;
								if($i<10){
									$tq = $ta[1].'-T0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de tracción. </span>';
								}
								tablaTraccionPl($CodInforme, $tq, $rowTabEns[tpMuestra]);
							}
				}
				if($cRef == 'SiTrRe'){
					RefTablaTraccionRe($CodInforme, $tq, $rowTabEns[tpMuestra]);
				}
				if($cRef == 'SiTrPl'){
					RefTablaTraccionPl($CodInforme, $tq, $rowTabEns[tpMuestra]);
				}
				?>
