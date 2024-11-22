				<?php
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrResponzable Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				$tRAMsUF = 0;
				$tRAMsPe = 0;
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloSel">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40" >&nbsp;			</td>';
				echo '			<td  width="10%" align="center" 			>PAM 		 	</td>';
				echo '			<td  width="10%">							Inicio		 	</td>';
				echo '			<td  width="10%">							Término		 	</td>';
				echo '			<td  width="18%">							Clientes	 	</td>';
				echo '			<td  width="25%">							Observaciones	</td>';
				echo '			<td  width="10%">							Imprimir<br>RAM </td>';
				echo '			<td  width="12%" align="center">			Seg.			</td>';
				echo '		</tr>';
				//echo '	</table>';
				//echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437' or substr($_SESSION['IdPerfil'],0,1) == 0){
					if($filtro){
						if($usrFiltro=='Baja'){
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By tpEnsayo Desc, RAM Asc";
						}else{
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' ".$filtro." Order By tpEnsayo Desc, RAM Asc";
						}
						$bdEnc=$link->query($sql);
						//$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' and usrCotizador Like '%".$usrFiltro."%' Order By RAM Asc");
					}else{
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc");
					}
				}else{
					if($filtro){
						if($usrFiltro=='Baja'){
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By tpEnsayo Desc, RAM Asc";
						}else{
							$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' ".$filtro." Order By tpEnsayo Desc, RAM Asc";
						}
						$bdEnc=$link->query($sql);
					}else{
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By tpEnsayo Desc, RAM Asc");
					}
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$tRAMsUF += $row['NetoUF'];
						$tRAMsPe += $row['Neto'];
						
						$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
						$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
										
						$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
						$ft = $row['fechaInicio'];
						$dh	= $row['dHabiles']-1;
						$dd	= 0;
						for($i=1; $i<=$dh; $i++){
							$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row['fechaInicio'] ) );
							$ft	= date ( 'Y-m-d' , $ft );
							$dia_semana = date("w",strtotime($ft));
							if($dia_semana == 0 or $dia_semana == 6){
								$dh++;
								$dd++;
							}
						}
						
						$fd = explode('-', $ft);
										
						$fechaHoy = date('Y-m-d');
						$start_ts 	= strtotime($fechaHoy); 
						$end_ts 	= strtotime($ft); 
										
						$tDias = 1;
						$nDias = $end_ts - $start_ts;

						$nDias = round($nDias / 86400)+1;
						if($ft < $fechaHoy){
							$nDias = $nDias - $dd;
						}
						
						$tr = "bBlanca";
						list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']);

						if($row['Estado']=='P' and $nDias <= 1){ // Enviada
							$tr = "bAmarillaSel";
							if($nDias <= 0){ // En Proceso
								$tr = 'bRojaSel';
							}
						}else{
							if($row['Estado'] == 'P'){ // Aceptada
								$tr = 'bVerdeSel';
							}
						}
						
						if($dhf > 0){ // Enviada
							if($dhf == 2 or $dhf == 1){ // Enviada
								$tr = 'bAmarillaSel';
							}else{
								$tr = 'bVerdeSel';
							}
						}
						if($dha > 0){ // Enviada
							$tr = "bRojaSel";
						}
						if($row['Fan'] > 0){ // Clon
							$tr = "bVerdeChillonSel";
						}
						$OTAM = 'NO';
						$bRAM = $row['RAM'];
						$bdfRAM=$link->query("SELECT * FROM formRAM Where CAM = '".$row['CAM']."' and RAM = '".$row['RAM']."'");
						if($rowfRAM=mysqli_fetch_array($bdfRAM)){
							$OTAM = 'SI';
						}else{
							//$tr = 'bMorado';
							$OTAM = 'NO';
						}
						echo '<tr class="'.$tr.'">';
						echo '	<td style="font-size:12px;" align="center" valign="top">';
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['nFactPend'] > 0){
											echo '<img src="../imagenes/gener_32.png" align="left" width="16">'.$rowCli['nFactPend'];
										}
									}
									if($row['Fan'] > 0){
										echo '<img style="padding:10px;" src="../imagenes/extra_column.png" align="left" width="32" title="CLON"><br>Clon Facturar';
									}
									if($row['correoAutomatico'] == 'on'){ ?>
											<img style="padding:5px;" src="../imagenes/siEnviado.png" align="left" width="32" title="Cotización enviado en correo autom谩tico">
											<?php
									}?>
									<div style="clear:both;"></div>
									<?php
									if($row['correoInicioPAM'] == 'on'){
											echo '<img style="padding:5px;" src="../imagenes/draft_16.png" align="left" title="Correo de ingreso a PAM enviado al Cliente">';
									}
									?>
									<div style="clear:both;"></div>
									<?php
										if($row['tpEnsayo'] == 2){
											?>
												<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
													AF
												</div>
											<?php
										}
										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
										if($rowCli=mysqli_fetch_array($bdCli)){
											if($rowCli['Clasificacion'] == 1){
												echo '<br><img src="../imagenes/Estrella_Azul.png" width=10>';
												echo '<img src="../imagenes/Estrella_Azul.png" width=10>';
												echo '<img src="../imagenes/Estrella_Azul.png" width=10>';
											}else{	
												if($rowCli['Clasificacion'] == 2){
													echo '<br><img src="../imagenes/Estrella_Azul.png" width=10>';
													echo '<img src="../imagenes/Estrella_Azul.png" width=10>';
												}else{
													if($rowCli['Clasificacion'] == 3){
														echo '<br><img src="../imagenes/Estrella_Azul.png" width=10>';
													}
												}
											}
											
										}
										
						echo '	</td>';
						echo '	<td style="font-size:12px;" align="center">';
						
						//echo fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']).'<br>';
						//echo $ft.' '.$dhf.' '.$dha;
						echo		'<strong style="font-size:14; font-weight:700">R'.$row['RAM'];
						if($row['Fan'] > 0){
							echo '-'.$row['Fan'];
						}
						echo 		'</strong><br>C'.$row['CAM'];
									if($row['Cta']){
										echo '<br>CC';
									}

									// Verificar si tiene Facturas Pendientes de Pago
									$sDeuda = 0;
									$cFact	= 0;
									$fechaHoy = date('Y-m-d');
									$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
									$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
									$bdDe=$link->query("SELECT * FROM SolFactura Where RutCli = '".$row['RutCli']."' and fechaPago = '0000-00-00'");
									if($rowDe=mysqli_fetch_array($bdDe)){
										do{
											if($rowDe['fechaFactura'] > '0000-00-00'){
												if($rowDe['fechaFactura'] < $fecha90dias){
													$sDeuda += $rowDe['Bruto'];
													$cFact++;
												}
											}
										}while ($rowDe=mysqli_fetch_array($bdDe));
									}
									if($sDeuda > 0){
										?>
										<script>
											var RutCli = '<?php echo $row["RutCli"]; ?>';
										</script>
										<?php
										echo '<br><div onClick="verDeuda(RutCli)"><img src="../imagenes/bola_amarilla.png"></div>';
										echo '<br><span style="color:#000; font-weight:800;">$ '.number_format($sDeuda, 0, ',', '.').'</span>';
										//echo '<br><span style="color:#FFFF00;">'.$fecha90dias.'</span>';
										
									}
									//Fin Verificación Deuda
									
										//echo '<br>'.$sql;
						echo '	</td>';
						echo '	<td style="font-size:12px;">';
									if($row['fechaInicio'] != 0){
										$fd = explode('-', $row['fechaInicio']);
										echo $fd[2].'/'.$fd[1];
										echo '<br>'.$row['usrResponzable'];
									}else{
										echo 'NO Asignado';
									}
						echo '	</td>';
						echo '	<td style="font-size:12px;">';
									if($row['fechaInicio'] != 0){
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$fechaHoy = date('Y-m-d');
										$dsemana = date("w",strtotime($ftermino));
										$fdt = explode('-', $ftermino);
										echo '<br>'.$dSem[$dsemana];
										echo '<br>'.$fdt[2].'/'.$fdt[1];
										if($dhf > 0 and $dha == 0){ // En Proceso
											if($dhf == 1){ // En Proceso
												echo '<div class="sVencerVerde">';
												echo 	$dhf;
												echo '</div';
											}else{
												echo '<div class="sVencer">';
												echo 	$dhf;
												echo '</div';
											}
										}
										if($dha > 0){ // En Proceso
											echo '<div class="pVencer" title="Atraso">';
											echo 	$dha;
											echo '</div';
										}
										
									}else{
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';
						echo '	<td style="font-size:12px;">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo 	$rowCli['Cliente'];
							}
						echo '	</td>';
						echo '	<td>';
						echo '		<strong style="font-size:10px;">';
/*
										if($row[obsServicios]){
											echo substr($row[obsServicios],0,100).'...';
										}
*/										
										if($row['Descripcion']){
											echo substr($row['Descripcion'],0,100).'...';
										}
						//echo 			number_format($row[BrutoUF], 2, ',', '.').' UF';
						echo '		</strong>'; 
						echo ' 	</td>';
						echo '	<td>';
									if($row['Estado'] == 'P'){ // En Proceso
										$bdRAM=$link->query("SELECT * FROM registroMuestras WHERE RAM = '".$row['RAM']."'");
										if($rowRAM=mysqli_fetch_array($bdRAM)){
											echo '<a href="../registroMat/formularios/iRAM.php?RAM='.$row['RAM'].'"><img src="../imagenes/newPdf.png" 	width="22" title="RAM">					</a>';
										}
										if($OTAM == 'NO'){
											echo '<br><a href="../otamsajax/pOtams.php?RAM='.$row['RAM'].'&CAM='.$row['CAM'].'&accion=Nuevo&prg=Procesos" data-toggle="tooltip" title="Crear Ensayos"><img src="../imagenes/materiales.png" 	width="22">					</a>';
										}else{
											echo '<br><a href="../otamsajax/pOtams.php?RAM='.$row['RAM'].'&CAM='.$row['CAM'].'&accion=Old&prg="  data-toggle="tooltip" title="Ensayos"><img src="../imagenes/ensayos.png" 	width="22" >					</a>';
										}
									}
									if($row['Estado'] == 'C'){ // Cerrada
										echo '<img src="../imagenes/tpv.png" 				width="22" title="Cerrada para Cobranza">';
									}
						echo ' 	</td>';
						echo '	<td align="center">';
								if($row['Estado'] == 'P'){ // En Proceso
									echo '<a href="plataformaCotizaciones.php?CAM='.$row['CAM'].'&RAM='.$row['RAM'].'&accion=SeguimientoRAM"			><img src="../gastos/imagenes/klipper.png" 		width="22" title="Seguimiento">			</a><br>';
									echo '<a href="formularios/iCAM.php?CAM='.$row['CAM'].'&Rev='.$row['Rev'].'&Cta='.$row['Cta'].'&accion=Reimprime"	><img src="../imagenes/informeUP.png" 		width="22" title="CAM">					</a>';
								}else{
									echo '<img src="../gastos/imagenes/klipper.png" width="22" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
					echo '<tr id="bAzul">';
					echo '	<td colspan=8 style="font-size: 18px; font-weight:700">';

								$sTotales = 0;
								$txt = 'Total RAM (última UF '.number_format($ultUF, 2, ',', '.').') x ';
								if($tRAMsUF>0){
									$txt .= number_format($tRAMsUF, 2, ',', '.').' UF';
									$sTotales = $ultUF * $tRAMsUF;
									$txt .= ' = '.number_format($sTotales, 0, ',', '.');
								}
								echo $txt;
								
					echo '	</td>';
					echo '</tr>';
				echo '	</table>';
