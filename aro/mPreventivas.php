		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="45%" valign="top">
					<?php informesAcciones(); ?>
				</td>
			</tr>
		</table>
		
		<?php
		function informesAcciones(){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">N� Acci�n			</td>';
				echo '			<td  width="08%">							Fecha<br>Apertura	</td>';
				echo '			<td  width="08%">							Implem.<br>Resp.	</td>';
				echo '			<td  width="25%">							Hallazgo			</td>';
				echo '			<td  width="08%">							Fecha<br>Tent.		</td>';
				echo '			<td  width="08%">							Fecha<br>Verif.		</td>';
				echo '			<td  width="08%">							Fecha<br>Cierre		</td>';
				echo '			<td  width="18%" align="center" colspan="3">Acciones			</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$link=Conectarse();
				//$sql = "SELECT * FROM accionesCorrectivas Where verCierreAccion != 'on' Order By fechaApertura Desc";
				$sql = "SELECT * FROM accionesPreventivas Order By nInformePreventiva Desc";
				$bdEnc=mysql_query($sql);
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$fd = explode('-', $row[accFechaTen]);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts = strtotime($row[accFechaTen]); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						
						$tr = "bBlanca";
						if($row[accFechaTen]<$fechaHoy){ 
							$tr = "bBlanca";
						}
						if($row[accFechaTen]>=$fechaHoy){ 
							// 22/7 >= 21/7
							$tr = 'bRoja';
						}
						if($row[accFechaTen]>$fechaHoy){ 
							$tr = 'bVerde';
						}
						if($row[accFechaTen]==$fechaHoy+1){ 
							$tr = "bAmarilla";
						}
						if($nDias==1){ 
							$tr = "bAmarilla";
						}
						if($nDias>1){ 
							$tr = "bVerde";
						}
						if($nDias==0 or $nDias < 0){ 
							$tr = "bRoja";
						}
						if($fd[0]==0){ 
							$tr = "bBlanca";
						}

						if($nDias<=5){ 
							$tr = "bAmarilla";
						}
						if($nDias>5){ 
							$tr = "bVerde";
						}
						if($nDias==0 or $nDias < 0){ 
							$tr = "bRoja";
						}

						if($row[verCierreAccion]=='on'){ 
							$tr = "bAzul";
						}
						
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">';
						echo			$row[nInformePreventiva];
						echo 		'</strong>';
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[fechaApertura]);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row[usrApertura];
									//echo '<br>'.$_SESSION[usr];
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[accFechaImp]);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row[usrResponsable];
						echo '	</td>';
						echo '	<td width="25%" style="font-size:12px;">';
									echo $row[desHallazgo];
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[accFechaTen]);
									echo $fd[2].'/'.$fd[1];
									if($nDias > 0){
										echo '<br>'.$nDias;
									}
						echo ' 	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[accFechaApli]);
									echo $fd[2].'/'.$fd[1];
						echo ' 	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[fechaCierre]);
									echo $fd[2].'/'.$fd[1];
						echo ' 	</td>';
						echo '	<td width="06%" align="center"><a href="accionesPreventivas.php?nInformePreventiva='.$row[nInformePreventiva=].'&accion=Imprimir"	><img src="../imagenes/informes.png" 				width="40" height="40" title="Imprimir Acci�n Preventiva">		</a></td>';
						echo '	<td width="06%" align="center"><a href="accionesPreventivas.php?nInformePreventiva='.$row[nInformePreventiva=].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Acci�n Preventiva">		</a></td>';
						echo '	<td width="06%" align="center"><a href="accionesPreventivas.php?nInformePreventiva='.$row[nInformePreventiva=].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Acci�n Preventiva">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
			}
			?>

