<?php
	
	if(isset($_POST['borrarSolicitud'])){ 
		if($_POST['nSolicitud']) { $nSolicitud  = $_POST['nSolicitud']; 	}
		if($_POST['RutCli']) 	 { $RutCli   	= $_POST['RutCli']; 		}
		$link=Conectarse();
		$bdDet=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowDet=mysqli_fetch_array($bdDet)){
			$Cliente = $rowDet['Cliente'];
		}
		$link->close();
		$link=Conectarse();
		$bdSol=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
		if($rowSol=mysqli_fetch_array($bdSol)){
			$bdSol=$link->query("DELETE FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
			$bdDet=$link->query("DELETE FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
		}
		$link->close();
		$RutCli 	= "";
		$nSolicitud = "";
	}

	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
		$MesFiltro = $Mes[intval($fd[1])];
	}

	$pPago = $Mm.'.'.$fd[0];

	//$MesHon 	= $Mm;
	$Proyecto 	= "Proyectos";
	//$MesFiltro  = "Mes";
	$Situacion 	= "Estado";
	$Agno     	= date('Y');
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	$dBuscado = '';
	$nOrden	  = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}
	
?>

			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
					<!-- Fitra por Proyecto -->
						<!--
						<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
							<?php 
								echo "<option value='plataformaFacturas.php?Proyecto=Proyectos&MesFiltro=".$MesFiltro."&Estado=".$Situacion."'>Proyectos</option>";
								$link=Conectarse();
								$bdPr=$link->query("SELECT * FROM Proyectos");
								if ($row=mysqli_fetch_array($bdPr)){
									do{
										if($Proyecto == $row['IdProyecto']){
											echo "	<option selected 	value='plataformaFacturas.php?Proyecto=".$row['IdProyecto']."&MesFiltro=".$MesFiltro."&Estado=".$Situacion."'>".$row['IdProyecto']."</option>";
										}else{
											echo "	<option  			value='plataformaFacturas.php?Proyecto=".$row['IdProyecto']."&MesFiltro=".$MesFiltro."&Estado=".$Situacion."'>".$row['IdProyecto']."</option>";
										}
									}while ($row=mysqli_fetch_array($bdPr));
								}
								$link->close();
							?>
						</select>
					-->
					<!-- Fitra por Fecha -->
					<!--
	  					<select name='MesFiltro' id='MesFiltro' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								//echo '<option value="plataformaFacturas.php?Proyecto='.$Proyecto.'&MesFiltro=Mes&Estado='.$Situacion.'">Mes</option>';
								for($i=1; $i <=12 ; $i++){
									if($Mes[$i]==$MesFiltro){
										echo '		<option selected 									value="plataformaFacturas.php?Proyecto='.$Proyecto.'&MesFiltro='.$Mes[$i].'&Estado='.$Situacion.'">'.$Mes[$i].'</option>';
									}else{
										if($Agno == date('Y')){
											if($i > strval($fd[1])){
												echo '	<option style="opacity:.5; color:#ccc;" disabled 	value="plataformaFacturas.php?Proyecto='.$Proyecto.'&MesFiltro='.$Mes[$i].'&Estado='.$Situacion.'">'.$Mes[$i].'</option>';
											}else{
												echo '	<option 											value="plataformaFacturas.php?Proyecto='.$Proyecto.'&MesFiltro='.$Mes[$i].'&Estado='.$Situacion.'">'.$Mes[$i].'</option>';
											}
										}else{
											echo '	<option 											value="plataformaFacturas.php?Proyecto='.$Proyecto.'&MesFiltro='.$Mes[$i].'&Estado='.$Situacion.'">'.$Mes[$i].'</option>';
										}
									}
								}
							?>
						</select>
					-->
					<!-- Fin Filtro -->

					<!-- Fitra por A�o -->
					<!--
	  					<select name='Agno' id='Agno' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								$AgnoAct = date('Y');
								for($a=2013; $a<=$AgnoAct; $a++){
									if($a == $Agno){
										echo "<option selected 	value='plataformaFacturas.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
									}else{
										echo "<option  			value='plataformaFacturas.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
									}
								}
							?>
						</select>
					-->
					<!-- Fin Filtro -->

					<!-- Fitra Estado 
	  					<select name='Estado' id='Estado' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								for($i=1; $i <=4 ; $i++){
									if($Estado[$i]==$Situacion){
										echo '<option selected  value="plataformaFacturas.php?Proyecto='.$Proyecto.'&MesFiltro='.$MesFiltro.'&Estado='.$Estado[$i].'">'.$Estado[$i].'</option>';
									}else{
										echo '<option   		value="plataformaFacturas.php?Proyecto='.$Proyecto.'&MesFiltro='.$MesFiltro.'&Estado='.$Estado[$i].'">'.$Estado[$i].'</option>';
									}
								}
							?>
						</select>
						-->						
						<div style="padding-left:15px; display:inline;">
							<?php
							if(isset($_POST['filtroPeriodo'])){
								$fechaDesde = $_POST['fechaDesde'];
								$fechaHasta = $_POST['fechaHasta'];
							}else{
								$fechaDesde = $Agno.'-01-01';
								$fechaHasta = date('Y-m-d');
							}
							?>
							<form name="form" action="plataformaFacturas.php" method="post" style="display:inline; ">
								Fechas :
									<input name="fechaDesde" id='fechaDesde' type="date" value="<?php echo $fechaDesde; ?>">
								-	<input name="fechaHasta" id='fechaHasta' type="date" value="<?php echo $fechaHasta; ?>">
								<button name="filtroPeriodo">
									Filtrar
								</button>
							</form>
						</div>
						
					<!-- Fin Filtro
					<form name="form" action="plataformaFacturas.php" method="post" style="display:inline; ">
						Rut Cliente a buscar
						<input name="dBuscado" align="right" maxlength="20" size="20" title="Ingrese RUT del Cliente a buscar...">
						OC
						<input name="nOrden" align="right" maxlength="20" size="20" title="Ingrese N� OC a buscar...">
						<button name="Buscar">
							<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
						</button>
					</form>
					-->
			</div>
			<div id="BarraFiltro">
				<?php 
					$tDocencia		= 0;
					
					$link=Conectarse();
					$m = intval($MesNum[$MesFiltro]);
					$filtroFacturas = "Where year(fechaSolicitud) = ".$Agno." and month(fechaSolicitud) = $m ";
					$filtroFacturas = "fechaSolicitud >= '".$fechaDesde."' and fechaSolicitud <= '".$fechaHasta."'";
					
					$bdHon=$link->query("SELECT * FROM SolFactura Where $filtroFacturas");
					if($row=mysqli_fetch_array($bdHon)){
						do{
							$cFree = '';
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if ($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								//if($row[Estado] == 'I'){
									if($cFree == 'on'){
										$tDocencia += $row['Bruto'];
									}
								//}
							}
							
						}while ($row=mysqli_fetch_array($bdHon));
					}
					$link->close();?>
					<span style="font-size: 12px; margin: 3px; color:#fff; font-family:Verdana, Arial, Helvetica, sans-serif;">
						Facturaci�n en Docencia <?php echo '<span style="font-size:11px;">('.$fechaDesde.' - '.$fechaHasta.')</span> <span style="font-size:12px;">$ '.number_format($tDocencia, 0, ',', '.').'</span>'; ?>
					</span>
			</div>
			<?php
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N�	</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fecha  			</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Proyecto		</strong></td>';
				echo '			<td  width="15%" align="center"><strong>Cliente			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fotocopia		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Factura			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Monto			</strong></td>';
				echo '			<td  width="15%" ><strong>Estado 						</strong></td>';
				echo '			<td  width="17%" align="center" colspan="2"><strong>Acciones		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
				/* Inicio Filtros */

				$m = intval($MesNum[$MesFiltro]);
				$filSQL = "Where year(fechaSolicitud) = ".$Agno;

				
				if($Proyecto <> 'Proyectos'){
					$filSQL .= "and IdProyecto = '".$Proyecto."'";
					
					$filtroSQL = " IdProyecto = '".$Proyecto."'";
				}
				if($Situacion <> 'Estado'){
					if($Situacion == 'Canceladas'){
						$filSQL .= " and pagoFactura = 'on'";
						
						$filtroSQL = ' pagoFactura = "on"';
					}
					if($Situacion == 'Factura'){
						$filSQL .= " and Factura = 'on' && pagoFactura <> 'on'";
						
						$filtroSQL = ' Factura = "on" && pagoFactura <> "on"';
					}
					if($Situacion == 'Fotocopia'){
						$filSQL .= " and Fotocopia = 'on' && pagoFactura <> 'on'";
						
						$filtroSQL = ' Fotocopia = "on" && pagoFactura <> "on"';
					}
					if($Situacion == 'Estado'){
						$filtroSQL = '';
					}
				}else{
						$filSQL .= " and pagoFactura != 'on'";
				}
				$m = intval($MesNum[$MesFiltro]);
				$filtroSQL = "Where month(fechaSolicitud) <= $m and ";
					
				$filtroSQL = $filSQL;
				$bdHon=$link->query("SELECT * FROM SolFactura $filtroSQL and pagoFactura <> 'on' Order By nSolicitud Desc");

				if($filtroSQL == ''){
					//$bdHon=$link->query("SELECT * FROM SolFactura where pagoFactura <> 'on' Order By nSolicitud");
					$m = intval($MesNum[$MesFiltro]);
					$filtroSQL = "Where month(fechaSolicitud) <= $m and ";
					
					$filtroSQL = $filSQL;
					//$bdHon=$link->query("SELECT * FROM SolFactura $filtroSQL and pagoFactura <> 'on' Order By fechaSolicitud Desc");
					$bdHon=$link->query("SELECT * FROM SolFactura $filtroSQL and pagoFactura <> 'on' Order By nSolicitud Desc");
				}else{
					$m = intval($MesNum[$MesFiltro]);
					$filtroSQL = "Where month(fechaSolicitud) <= $m and ".$filtroSQL;
					//$bdHon=$link->query("SELECT * FROM SolFactura $filtroSQL Order By nSolicitud" );

					$filtroSQL = $filSQL;
					//$bdHon=$link->query("SELECT * FROM SolFactura $filtroSQL Order By fechaSolicitud Desc" );
					$bdHon=$link->query("SELECT * FROM SolFactura $filtroSQL Order By nSolicitud Desc" );
				}
				if($dBuscado){
					$bdPer=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscado."%' or RutCli = '".$dBuscado."'");
					if ($rowP=mysqli_fetch_array($bdPer)){
						$RutCli = $rowP['RutCli'];
						$bdHon=$link->query("SELECT * FROM SolFactura Where RutCli = '".$rowP['RutCli']."'");
						$dBuscado = '';
					}
				}
				if($nOrden != ''){
					$bdHon=$link->query("SELECT * FROM SolFactura where nOrden Like '%".$nOrden."%'");
				}
				$filtroFacturas = "fechaSolicitud >= '".$fechaDesde."' and fechaSolicitud <= '".$fechaHasta."'";
				$bdHon=$link->query("SELECT * FROM SolFactura Where $filtroFacturas");
				if ($row=mysqli_fetch_array($bdHon)){
					do{
						//echo $row[RutCli].'<br>';
						$bdCF=$link->query("SELECT * FROM Clientes Where cFree = 'on' and RutCli = '".$row['RutCli']."'");
						if($rowCF=mysqli_fetch_array($bdCF)){
						
							$fd = explode('-', $row['fechaSolicitud']);
							$tr = "barraBlanca";
							if($row['Estado']=='I'){
								$tr = 'barraVerde';
							}
							if($row['Fotocopia']=='on' && $row['Factura'] == 'on'){
								$tr = 'barraAmarilla';
							}
							if($row['Fotocopia']=='on' && $row['Factura'] == ''){
								$tr = 'barraNaranjo';
							}
							if($row['pagoFactura']=='on'){
								$tr = 'barraPagada';
							}
							echo '	<tr id="'.$tr.'">';
							echo '			<td width="05%" style="font-size:16px;">'.$row['nSolicitud'].'</td>';
							echo '			<td width="10%">';
												$fd = explode('-', $row['fechaSolicitud']);
												echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							echo '			</td>';
							echo '			<td width="08%">'.$row['IdProyecto'].'</td>';
							echo '			<td width="15%">';
												$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
												if ($rowP=mysqli_fetch_array($bdPer)){
													echo '<strong>'.$rowP['Cliente'].'</strong>';
												}
							echo '			</td>';
							echo '			<td width="10%" align="center">';
												if($row['Fotocopia'] == 'on'){
													$fd = explode('-', $row['fechaFotocopia']);
													echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
												}
												if($row['nOrden']){
													echo '<br>OC-'.$row['nOrden'];
												}
							echo ' 			</td>';
							echo '			<td width="10%" align="center">';
												if($row['Factura'] == 'on'){
													$fd = explode('-', $row['fechaFactura']);
													echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
													echo $fd[2].'-'.$fd[1].'-'.$fd[0].'<br>';
													echo 'N� '.$row['nFactura'];
												}
							echo ' 			</td>';
							echo '			<td width="10%" align="center">';
												if($row['tipoValor']=='U'){
													if($row['Neto']>0){
														echo $row['brutoUF'].' UF <br>';
														echo number_format($row['Bruto'], 0, ',', '.');
													}else{
														echo $row['brutoUF'].' UF';
													}
												}else{
													echo number_format($row['Bruto'], 0, ',', '.');
												}
							echo ' 			</td>';
							echo '			<td width="15%">';
												if($row['pagoFactura'] == 'on'){
													$fd = explode('-', $row['fechaPago']);
													echo '<img src="../gastos/imagenes/Confirmation_32.png" width="16" height="16">';
													echo $fd[2].'-'.$fd[1].'-'.$fd[0].'<br>';
												}
							echo '			</td>';
							echo '			<td width="6%"><a href="seguimientoSolicitudes.php?Proceso=2&RutCli='.$row['RutCli'].'&nSolicitud='.$row['nSolicitud'].'"><img src="../gastos/imagenes/klipper.png"   		width="32" height="32" title="Seguimiento">					</a></td>';
							echo '			<td width="6%"><a href="formSolicitaFactura.php?Proceso=2&RutCli='.$row['RutCli'].'&nSolicitud='.$row['nSolicitud'].'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Solicitud de Factura">	</a></td>';
							echo '			<td width="5%"><a href="plataformaFacturas.php?Proceso=5&RutCli='.$row['RutCli'].'&nSolicitud='.$row['nSolicitud'].'"><img src="../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar Solicitud">			</a></td>';
							echo '		</tr>';
						}
						
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
				if(isset($_GET['Proceso']) == 5){
					?>
					<div class="boxEliminacion">
						<form name="form" action="plataformaFacturas.php" method="post">
							�Seugro de borrar <b>Solicitud de Factura</b>?
							<br><br>
							<hr>
							<table width="100%">
								<tr>
									<td width="24%">N� Solicitud</td>
									<td>:
										<?php echo $_GET['nSolicitud']; ?>
										<input name="nSolicitud" type="hidden" value="<?php echo $_GET['nSolicitud']; ?>">
									</td>
								</tr>
								<tr>
									<td>Cliente</td>
									<td>:
										<?php 
											$link=Conectarse();
											$bdDet=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$_GET['RutCli']."'");
											if($rowDet=mysqli_fetch_array($bdDet)){
												$Cliente = $rowDet['Cliente'];
											}
											$link->close();
											echo $Cliente; 
										?>
										<input name="RutCli" type="hidden" value="<?php echo $_GET['RutCli']; ?>">
									</td>
								</tr>
								<tr>
									<td>Fecha Solicitud</td>
									<td>:
										<?php 
											$link=Conectarse();
											$bdDet=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$_GET['nSolicitud']."'");
											if($rowDet=mysqli_fetch_array($bdDet)){
												$fechaSolicitud = $rowDet['fechaSolicitud'];
												$tipoValor 		= $rowDet['tipoValor'];
												$brutoUF 		= $rowDet['brutoUF'];
												$Bruto 			= $rowDet['Bruto'];
											}
											$link->close();
											$fd = explode('-', $fechaSolicitud);
											echo $fd[2].'-'.$fd[1].'-'.$fd[0];
										?>
									</td>
								</tr>
								<tr>
									<td>Monto</td>
									<td>:
										<?php 

											if($tipoValor == 'U'){
												echo $brutoUF.' UF';
											}
											if($tipoValor == 'P'){
												echo '$ '.number_format($Bruto, 0, ',', '.');
											}
										?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
								<tr>
									<td colspan="2" align="right">							
										<button name="cancelarEliminacion" title="Cancelar">
											<img src="../gastos/imagenes/flecha_return.png" width="100" height="100">
										</button>
										<button name="borrarSolicitud" title="Borrar Solicitud de Factura">
											<img src="../gastos/imagenes/inspektion.png" width="100" height="100">
										</button>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<?php
				}
			?>
		</div>
		