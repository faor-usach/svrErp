				<?php 
				$letraItem++;
				echo '<p>';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Resultados de Análisis Químico:</b></span>';
				echo '</p>';
				$i=1;
				?>
				<p style="text-indent: 60px; line-height:24px;" align="justify">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se muestran los valores resultantes del análisis químico, 
					obtenido mediante Espectrometría de Emisión Óptica.
				</p>
				<?php
				$cRef = 'No';
				for($i=1; $i<=$rowTabEns[cEnsayos]; $i++){
							// Químico - Acero
							if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Ac' and $rowTabEns[Ref]=='SR'){
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-Q'.$i;
								if($i<10){
									$tq = $ta[1].'-Q0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de análisis químico.</span>';
								}
								tablaQuimicoSR($CodInforme, $tq, $rowTabEns[tpMuestra]);
							}
							if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Ac' and $rowTabEns[Ref]=='CR'){
								$cRef = 'SiQuAc';
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-Q'.$i;
								if($i<10){
									$tq = $ta[1].'-Q0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de análisis químico.</span>';
								}
								tablaQuimicoSR($CodInforme, $tq, $rowTabEns[tpMuestra]);
								//tablaQuimicoCR($tq);
							}
							// Químico - Cobre
							if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Co' and $rowTabEns[Ref]=='SR'){
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-Q'.$i;
								if($i<10){
									$tq = $ta[1].'-Q0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de análisis químico.</span>';
								}
								tablaQuimicoCoSR($CodInforme, $tq, $rowTabEns[tpMuestra]);
							}
							if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Co' and $rowTabEns[Ref]=='CR'){
								$cRef = 'SiQuCo';
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-Q'.$i;
								if($i<10){
									$tq = $ta[1].'-Q0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de análisis químico.</span>';
								}
								tablaQuimicoCoSR($CodInforme, $tq, $rowTabEns[tpMuestra]);
								//tablaQuimicoCoSR($tq);
							}
							// Químico - Aluminio
							if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Al' and $rowTabEns[Ref]=='SR'){
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-Q'.$i;
								if($i<10){
									$tq = $ta[1].'-Q0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de análisis químico.</span>';
								}
								tablaQuimicoAl($CodInforme, $tq, $rowTabEns[tpMuestra]);
							}
							if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Al' and $rowTabEns[Ref]=='CR'){
								$cRef = 'SiQuAl';
								$ta = explode('-',$CodInforme);
								$tq = $ta[1].'-Q'.$i;
								if($i<10){
									$tq = $ta[1].'-Q0'.$i;
								}
								if($i==1){
									echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de análisis químico.</span>';
								}
								tablaQuimicoAl($CodInforme, $tq, $rowTabEns[tpMuestra]);
								//tablaQuimicoAl($tq);
							}
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
