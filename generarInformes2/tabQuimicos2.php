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
				$bdMu=mysql_query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."'");
				if($rowMu=mysql_fetch_array($bdMu)){
					$idItem = $rowMu[idItem];
					$prMu  = explode('-',$idItem);
					$iniMu = intval($prMu[1]);
					$totMu = $iniMu + $rowTabEns[cEnsayos];
				}
				for($i=$iniMu; $i<$totMu; $i++){
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
								tablaQuimicoSR($tq);
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
								tablaQuimicoCR($tq);
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
								tablaQuimicoCoSR($tq);
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
								tablaQuimicoCoSR($tq);
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
								tablaQuimicoAl($tq);
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
								tablaQuimicoAl($tq);
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
