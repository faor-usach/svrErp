<?php
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	$usrFiltro = '';
	
	if(isset($_GET['usrFiltro'])) { $usrFiltro  = $_GET['usrFiltro']; 	}
	if(isset($_SESSION['empFiltro'])) { 
		//$empFiltro  = $_GET['empFiltro']; 	
		$empFiltro = $_SESSION['empFiltro'];
		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$empFiltro."%'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$filtroCli = $rowCli['RutCli'];
		}
		$link->close();
	}else{
		$filtroCli = '';
	}
	
	if(isset($_SESSION['usrFiltro'])) { $usrFiltro = $_SESSION['usrFiltro']; }
	
	
	?>
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
				echo '			<td  width="10%" align="center" height="40">N° Acción			</td>';
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
				$sql = "SELECT * FROM accionesCorrectivas Order By nInformeCorrectiva Desc";
				$bdEnc=$link->query($sql);
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$fd = explode('-', $row['accFechaTen']);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts = strtotime($row['accFechaTen']); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						
						$tr = "bBlanca";
						if($row['accFechaTen']<$fechaHoy){ 
							$tr = "bBlanca";
						}
						if($row['accFechaTen']>=$fechaHoy){ 
							// 22/7 >= 21/7
							$tr = 'bRoja';
						}
						if($row['accFechaTen']>$fechaHoy){ 
							$tr = 'bVerde';
						}
						$fechaHoymas = date("d-m-Y",strtotime($fechaHoy."+ 1 days"));

						if($row['accFechaTen']==$fechaHoymas){ 
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

						if($row['verCierreAccion']=='on'){ 
							$tr = "bAzul";
						}
						
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">';
						echo			$row['nInformeCorrectiva'];
						echo 		'</strong>';
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['fechaApertura']);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row['usrApertura'];
									//echo '<br>'.$_SESSION[usr];
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['accFechaImp']);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row['usrResponsable'];
						echo '	</td>';
						echo '	<td width="25%" style="font-size:12px;">';
									echo $row['desHallazgo'];
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">'; 
									$fd = explode('-', $row['accFechaTen']);
									echo $fd[2].'/'.$fd[1];
									if($nDias > 0){
										echo '<br>'.$nDias;
									}
						echo ' 	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['accFechaApli']);
									echo $fd[2].'/'.$fd[1];
						echo ' 	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['fechaCierre']);
									echo $fd[2].'/'.$fd[1];
						echo ' 	</td>';?>
								<td width="06%" align="center">
								<?php
								$ruta = 'Y://AAA/LE/CALIDAD/AC/AC-'.$row['nInformeCorrectiva'].'/Anexos/'; 
								if(file_exists($ruta)){
									?>
									<a href="#"><img src="../imagenes/Confirmation_32.png" 	width="40" height="40" title="Anexos">		</a>
									<?php
								}else{
									?>
									<a href="#"><img src="../imagenes/no_32.png" 	width="40" height="40" title="Sin Anexos">		</a>
									<?php
								}?>
								</td>
								<?php
						echo '	<td width="06%" align="center"><a href="accionesCorrectivas.php?nInformeCorrectiva='.$row['nInformeCorrectiva'].'&accion=Imprimir"	><img src="../imagenes/informes.png" 				width="40" height="40" title="Imprimir Acción Correctiva">		</a></td>';
						echo '	<td width="06%" align="center"><a href="regCorrectiva.php?nInformeCorrectiva='.$row['nInformeCorrectiva'].'&accion=Actualizar"><img src="../gastos/imagenes/corel_draw_128.png" 		width="40" height="40" title="Editar Acción Correctiva">		</a></td>';
						echo '	<td width="06%" align="center"><a href="accionesCorrectivas.php?nInformeCorrectiva='.$row['nInformeCorrectiva'].'&accion=Borrar"	><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Acción Correctiva">		</a></td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			}
			?>

