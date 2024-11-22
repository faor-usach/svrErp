<?php
	$fd 	= explode('-', date('Y-m-d'));
	
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

	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
	}else{
		$Mm = $Mes[intval($fd[1])];
	}
	$Periodo = $MesNum[$Mm].'.'.$fd[0];
	$Agno = date('Y');
	if(isset($_GET[Agno])){
		$Agno 		= $_GET[Agno];
		$Periodo 	= $MesNum[$Mm].'.'.$Agno;
	}	
	
	$ItemsGen = array(	
					1 => 'Ventas', 
					2 => '0,775',
					3 => 'IVA Compras',
					4 => 'Sueldos',
					5 => 'Gastos',
					6 => 'Inversión'
				);
				
	$sImp  = array(0, 0, 0, 0, 0, 0, 0);
	$sSue  = array(0, 0, 0, 0, 0, 0, 0);
	$sGto  = array(0, 0, 0, 0, 0, 0, 0);
	$sIva  = array(0, 0, 0, 0, 0, 0, 0);

	if($Detect->IsMobile()) {
		//$maxTab = '83%';
		$maxTab = '99%';
	}else{
		$maxTab = '99%';
	}
	
?>
<table border="0" width="<?php echo $maxTab; ?>" cellspacing="0" cellpadding="0" id="CajaTitInfos">
	<tr>
    	<td><span><strong>Tabla Resumen General:</strong> 
			<select name="Mes" onChange="window.location = this.options[this.selectedIndex].value; return true;">
				<?php
				for($i=1; $i <=12 ; $i++){
					if($Mes[$i]==$Mm){
						echo '<option selected value="resumenGeneral.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
					}else{
						if($i > $fd[1]){
							echo '<option style="opacity:.5; color:#ccc;" value="plataformaErp.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
						}else{
							echo '<option value="plataformaErp.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
						}
					}
				}
				?>
			</select>
			</span>
		</td>
  	</tr>
</table>
<table width="<?php echo $maxTab; ?>"  border="0" cellspacing="0" cellpadding="0" id="CajaCpoInfos">
	<tr>
    	<td>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
            	<tr height="30">
                	<td width="10%" height="20px">
						<strong>
							Items 
						</strong>
					</td>
					<?php
					$link=Conectarse();
					$bdPr=mysql_query("SELECT * FROM Proyectos");
					if($rowPr=mysql_fetch_array($bdPr)){
						do{
							echo '<td width="15%" align="center"><strong>'.$rowPr['IdProyecto'].'</strong></td>';
							$sColumna = array($rowPr['IdProyecto'] => 0 );
						}while ($rowPr=mysql_fetch_array($bdPr));
					}
					mysql_close($link);
					?>
                    <td width="15%" align="center"><strong>Total Mes</strong></td>
					<?php
					$link=Conectarse();
					$bdPr=mysql_query("SELECT * FROM Proyectos");
					if($rowPr=mysql_fetch_array($bdPr)){
						do{
							echo '<td width="15%" align="center"><strong>'.$rowPr['IdProyecto'].'</strong></td>';
						}while ($rowPr=mysql_fetch_array($bdPr));
					}
					mysql_close($link);
					?>
                    <td width="15%" align="center"><strong>Total Año <br><?php echo $Agno; ?></strong></td>
               	</tr>
				<?php
				for($i=1; $i <=6 ; $i++){?>
						<tr id="barraBlanca">
							<td height="30" align="right"><?php echo $ItemsGen[$i]; ?></td>
								<?php
									//$Agno = 2014;
									//$Agno = date('Y');
									$tMes = 0;
									$tSue = 0;
									$tHon = 0;
									$p	  = 0;
									
									$link=Conectarse();
									$bdPr=mysql_query("SELECT * FROM Proyectos");
									if($rowPr=mysql_fetch_array($bdPr)){
										do{
											$p++;
											switch ($i) {
												case 1:
													echo '<td align="right">';
															$tBruto = 0;
															$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowGas=mysql_fetch_array($result)){
																do{
																	$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
																	if ($rowP=mysql_fetch_array($bdPer)){
																		$cFree = $rowP[cFree];
																		if($rowP[cFree] != 'on'){
																			if($rowGas[Neto]>0){
																				$tBruto += $rowGas[Neto];
																				//$tBruto += $rowGas[Bruto];
																			}
																		}
																	}
																}while ($rowGas=mysql_fetch_array($result));
															}
															$tMes += $tBruto;
															echo '<strong>'.number_format($tBruto, 0, ',', '.').'</strong>'; 

/*
															$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tMes += $rowGas['tBruto'];
																echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
															}
*/
															
													echo '</td>';
													break;
												case 2:
													echo '<td align="right">';

															$tBruto = 0;
															$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' &&year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowGas=mysql_fetch_array($result)){
																do{
																	$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
																	if ($rowP=mysql_fetch_array($bdPer)){
																		$cFree = $rowP[cFree];
																		if($rowP[cFree] != 'on'){
																			if($rowGas[Neto]>0){
																				$tBruto += $rowGas[Neto];
																				//$tBruto += $rowGas[Bruto];
																			}
																		}
																	}
																}while ($rowGas=mysql_fetch_array($result));
															}
															$tMes += $tBruto * 0.775;
															$sImp[$p] += $tBruto * 0.775;
															echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 

/*
															$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tMes += $rowGas['tBruto'] * 0.775;
																$sImp[$p] += $rowGas['tBruto'] * 0.775;
																echo '<strong>'.number_format($rowGas['tBruto'] * 0.775, 0, ',', '.').'</strong>'; 
															}
*/
															
													echo '</td>';
													break;
												case 3:
													echo '<td align="right">';
															$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno and month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tIvaCompra']>0){
																$tMes += $rowGas['tIvaCompra'];
																$sIva[$p] += $rowGas['tIvaCompra'];
																echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
															}
													echo '</td>';
													break;
												case 4:
													echo '<td align="right">';
															$tSue = 0;
															$tHon = 0;
															$tFac = 0;
															
															$pPago = $MesNum[$Mm].'.'.$Agno;
															$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE Estado = 'P' && year(FechaPago) = $Agno and PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tLiquido']>0){
																$tSue += $rowGas['tLiquido'];
															}
															$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE nInforme > 0 && year(fechaCancelacion) = $Agno and PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tTotal']>0){
																$tHon += $rowGas['tTotal'];
															}
															$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE TpCosto = 'M' && year(FechaPago) = $Agno and PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tFac += $rowGas['tBruto'];
															}
															$tMes += ($tSue + $tHon + $tFac);
															$sSue[$p] += ($tSue + $tHon + $tFac);
															if($sSue[$p] > 0){
																echo '<strong>'.number_format(($tSue + $tHon + $tFac), 0, ',', '.').'</strong>'; 
															}
													echo '</td>';
													break;
												case 5:
													echo '<td align="right">';
															$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = $Agno and month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tMes += $rowGas['tBruto'];
																$sGto[$p] += $rowGas['tBruto'];
																echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
															}
													echo '</td>';
													break;
												case 6:
													$tBru = 0;
													$tHon = 0;
													echo '<td align="right">';
															$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno and month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tBru += $rowGas['tBruto'];
																$tMes += $tBru;
															}
															$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && nInforme > 0 &&  PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tTotal']>0){
																$tHon += $rowGas['tTotal'];
																$tMes += $tHon;
															}
															if(($tBru + $tHon) > 0){
																echo '<strong>'.number_format(($tBru + $tHon), 0, ',', '.').'</strong>'; 
															}
													echo '</td>';
													break;
												default:
													echo '<td>&nbsp;</td>';
											}
										}while ($rowPr=mysql_fetch_array($bdPr));
									}
								?>
							<td align="right">
								<?php 
									if($tMes > 0){
										echo number_format($tMes, 0, ',', '.'); 
									}
								?>
							</td>
							<td align="right">
							<?php
								switch ($i) {
									case 1:

										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP[cFree];
													if($rowP[cFree] != 'on'){
														if($rowGas[Neto]>0){
															$tBruto += $rowGas[Neto];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										echo '<strong>'.number_format($tBruto, 0, ',', '.').'</strong>'; 

/*
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
										}
*/
										break;

									case 2:
										$sImp[5] = 0;

										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP[cFree];
													if($rowP[cFree] != 'on'){
														if($rowGas[Neto]>0){
															$tBruto += $rowGas[Neto];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes 		= $tBruto * 0.775;
										$sImp[5] 	= $tBruto * 0.775;
										echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 
/*

										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes 		= $rowGas['tBruto'] * 0.775;
											$sImp[5] 	= $rowGas['tBruto'] * 0.775;
											echo '<strong>'.number_format($rowGas['tBruto'] * 0.775, 0, ',', '.').'</strong>'; 
										}
*/


										break;
									case 3:
										$sIva[5] = 0;
										$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaCompra']>0){
											$tMes 		= $rowGas['tIvaCompra'];
											$sIva[5] 	= $rowGas['tIvaCompra'];
											echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
										}
										break;
									case 4:
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										
										$pPago = $MesNum[$Mm].'.'.$Agno;
										
										$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE Estado = 'P' && IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tLiquido']>0){
											$tSue = $rowGas['tLiquido'];
										}
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE Estado = 'P' && IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE TpCosto = 'M' && IdProyecto = 'IGT-1118' && year(FechaPago) = $Agno and month(FechaPago) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$sSue[5] 	= ($tSue + $tTot + $tBru);
										if(($tSue + $tTot + $tBru) > 0){
											echo '<strong>'.number_format(($tSue + $tTot + $tBru), 0, ',', '.').'</strong>'; 
										}
										break;
									case 5:
										$tMes = 0;
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes = $rowGas['tBruto'];
											echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
										}
										$sGto[5] 	= $rowGas['tBruto'];
										break;
									case 6:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P' && IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										if(($tBru + $tTot) > 0){
											echo '<strong>'.number_format(($tBru + $tTot), 0, ',', '.').'</strong>'; 
										}
										break;
								}
							?>
							</td>
							<td align="right">
							<?php
								switch ($i) {
									case 1:

										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP[cFree];
													if($rowP[cFree] != 'on'){
														if($rowGas[Neto]>0){
															$tBruto += $rowGas[Neto];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										echo '<strong>'.number_format($tBruto, 0, ',', '.').'</strong>'; 

/*
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											//$tMes = $rowGas['tBruto'];
											echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
										}
*/
										
										break;
									case 2:
										$sImp[6] = 0;

										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP[cFree];
													if($rowP[cFree] != 'on'){
														if($rowGas[Neto]>0){
															$tBruto += $rowGas[Neto];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes 		= $tBruto * 0.775;
										$sImp[6] 	= $tBruto * 0.775;
										echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 

/*
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes 		= $rowGas['tBruto'] * 0.775;
											$sImp[6] 	= $rowGas['tBruto'] * 0.775;
											echo '<strong>'.number_format($rowGas['tBruto'] * 0.775, 0, ',', '.').'</strong>'; 
										}
*/										
										break;
									case 3:
										$sIva[6] = 0;
										$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaCompra']>0){
											$tMes 		= $rowGas['tIvaCompra'];
											$sIva[6] 	= $rowGas['tIvaCompra'];
											echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
										}
										break;
									case 4:
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE Estado = 'P' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tLiquido']>0){
											$tSue = $rowGas['tLiquido'];
										}
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE Estado = 'P' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE TpCosto = 'M' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$sSue[6] 	= ($tSue + $tTot + $tBru);
										if(($tSue + $tTot + $tBru) > 0){
											echo '<strong>'.number_format(($tSue + $tTot + $tBru), 0, ',', '.').'</strong>'; 
										}
										break;
									case 5:
										$tMes = 0;
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes = $rowGas['tBruto'];
											echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
										}
										$sGto[6] 	= $rowGas['tBruto'];
										break;
									case 6:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										if(($tBru + $tTot) > 0){
											echo '<strong>'.number_format(($tBru + $tTot), 0, ',', '.').'</strong>'; 
										}
										break;
								}
							?>
							
							</td>
							<td align="right">
							<?php
								switch ($i) {
									case 1:

										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP[cFree];
													if($rowP[cFree] != 'on'){
														if($rowGas[Neto]>0){
															$tBruto += $rowGas[Neto];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes = $tBruto;
										echo '<strong>'.number_format($tBruto, 0, ',', '.').'</strong>'; 


/*
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes = $rowGas['tBruto'];
											echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
										}
*/										
										break;
									case 2:
										$sImp[4] = 0;

										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP[cFree];
													if($rowP[cFree] != 'on'){
														if($rowGas[Neto]>0){
															$tBruto += $rowGas[Neto];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes 		= $tBruto * 0.775;
										$sImp[4] 	= $tBruto * 0.775;
										echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 

/*
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes 		= $rowGas['tBruto'] * 0.775;
											$sImp[4] 	= $rowGas['tBruto'] * 0.775;
											echo '<strong>'.number_format($rowGas['tBruto'] * 0.775, 0, ',', '.').'</strong>'; 
										}
*/										
										break;
									case 3:
										$sIva[4] = 0;
										$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaCompra']>0){
											$tMes 		= $rowGas['tIvaCompra'];
											$sIva[4] 	= $rowGas['tIvaCompra'];
											echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
										}
										break;
									case 4:
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE Estado = 'P' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tLiquido']>0){
											$tSue = $rowGas['tLiquido'];
										}
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE Estado = 'P' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE TpCosto = 'M' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$sSue[4] 	= ($tSue + $tTot + $tBru);
										if(($tSue + $tTot + $tBru) > 0){
											echo '<strong>'.number_format(($tSue + $tTot + $tBru), 0, ',', '.').'</strong>'; 
										}
										break;
									case 5:
										$tMes = 0;
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes = $rowGas['tBruto'];
											echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
										}
										$sGto[4] 	= $rowGas['tBruto'];
										break;
									case 6:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P' && PeriodoPago <= $pPago");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										if(($tBru + $tTot) > 0){
											echo '<strong>'.number_format(($tBru + $tTot), 0, ',', '.').'</strong>'; 
										}
										break;
								}
							?>
							</td>
						</tr>
				<?php
				}
				?>
        	</table>
		</td>
  	</tr>
</table>
<table width="<?php echo $maxTab; ?>"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
	<tr>
		<td height="50">Saldos </td>
		<td align="right">
			<?php 
				$tSaldo1 = $sImp[1] - ($sSue[1] + $sGto[1]);
				if($tSaldo1 <> 0){
					echo number_format($tSaldo1, 0, ',', '.'); 
				}
			?>
		</td>
		<td align="right">
			<?php 
				$tSaldo2 = $sImp[2] - ($sSue[2] + $sGto[2]);
				if($tSaldo2 <> 0){
					echo number_format($tSaldo2, 0, ',', '.'); 
				}
			?>
		</td>
		<td align="right">
			<?php 
				if(($tSaldo1 + $tSaldo2) <> 0){
					echo number_format(($tSaldo1 + $tSaldo2), 0, ',', '.'); 
				}
			?>
		</td>
		<td align="right">
			<?php 
				$tSaldoPry1 = $sImp[5] - ($sSue[5] + $sGto[5]);
				if($tSaldoPry1 <> 0){
					echo number_format($tSaldoPry1, 0, ',', '.'); 
				}
			?>
		</td>
		<td align="right">
			<?php 
				$tSaldoPry2 = $sImp[6] - ($sSue[6] + $sGto[6]);
				if($tSaldoPry2 <> 0){
					echo number_format($tSaldoPry2, 0, ',', '.'); 
				}
			?>
		</td>
		<td align="right">
			<?php 
				$tSaldo4 = $sImp[4] - ($sSue[4] + $sGto[4]);
				if($tSaldo4 <> 0){
					echo number_format($tSaldo4, 0, ',', '.'); 
				}
			?>
		</td>
	</tr>
	<tr>
		<td colspan="7"><hr></td>
	</tr>
	<tr>
		<td width="10%" height="50">Saldo c/Iva</td>
		<td width="15%" align="right">
			<?php 
				$tSaldo1 = ($sImp[1] + $sIva[1]) - ($sSue[1] + $sGto[1]);
				if($tSaldo1 <> 0){
					echo number_format($tSaldo1, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php 
				$tSaldo2 = ($sImp[2] + $sIva[2]) - ($sSue[2] + $sGto[2]);
				if($tSaldo2 <> 0){
					echo number_format($tSaldo2, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php 
				if(($tSaldo1 + $tSaldo2) <> 0){
					echo number_format(($tSaldo1 + $tSaldo2), 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php 
				$tSaldoPry1 = ($sImp[5] + $sIva[5]) - ($sSue[5] + $sGto[5]);
				if($tSaldoPry1 <> 0){
					echo number_format($tSaldoPry1, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php 
				$tSaldoPry2 = ($sImp[6] + $sIva[6]) - ($sSue[6] + $sGto[6]);
				if($tSaldoPry2 <> 0){
					echo number_format($tSaldoPry2, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php 
				$tSaldo4 = ($sImp[4] + $sIva[4]) - ($sSue[4] + $sGto[4]);
				if($tSaldo4 <> 0){
					echo number_format($tSaldo4, 0, ',', '.'); 
				}
			?>
		</td>
	</tr>
</table>
