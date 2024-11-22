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
	if(isset($_GET['Agno'])){
		$Agno 		= $_GET['Agno'];
		$Periodo 	= $MesNum[$Mm].'.'.$Agno;
	}	

	$link=Conectarse();
	$bdInf=mysql_query("SELECT * FROM Informes Order By AgnoInforme Asc");
	if($rowInf=mysql_fetch_array($bdInf)){
		$prAgno = $rowInf['AgnoInforme'];
	}
	mysql_close($link);
	
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
	$dIva  = array(0, 0, 0, 0, 0, 0, 0);
	$cIva  = array(0, 0, 0, 0, 0, 0, 0);

	if($Detect->IsMobile()) {
		//$maxTab = '83%';
		$maxTab = '99%';
	}else{
		$maxTab = '99%';
	}
	
?>
<div style="background-color:#999999; padding:10px; display:block;">
			<span style="font-size:24px; font-family:Arial, Helvetica, sans-serif;">Filtro </span>
			<!-- <select name="Mes" onChange="window.location = this.options[this.selectedIndex].value; return true;"> -->
			<form name="form" action="plataformaErp.php" method="get">
			<select name="Mm">
				<?php
				for($i=1; $i <=12 ; $i++){
					if($Mes[$i]==$Mm){
						//echo '<option selected value="resumenGeneral.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
						echo '<option selected value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
					}else{
						if($i > $fd[1]){
							echo '<option style="opacity:.5; color:#ccc;" value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
						}else{
							echo '<option value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
						}
					}
				}
				?>
			</select>
			<!-- <select name="Agno" onChange="window.location = this.options[this.selectedIndex].value; return true;"> -->
			<select name="Agno">
				<?php
					$prAgno = 2013;
					$AgnoAct = date('Y');
					for($a=$prAgno; $a<=$AgnoAct; $a++){
						if($a == $Agno){
							echo '<option selected 	value="'.$a.'">'.$a.'</option>';
						}else{
							echo '<option  			value="'.$a.'">'.$a.'</option>';
						}
					}
				?>
			</select>
			<button name="refrescar" title="Actualizar">
				<img src="imagenes/actualiza.png" width="30">
			</button>
			</form>
			</span>

</div>
<table border="0" width="<?php echo $maxTab; ?>" cellspacing="0" cellpadding="0" id="CajaTitInfos">
	<tr>
    	<td>
			<span style="padding-left:20px; font-size:24px;"><strong>Tabla Resumen General</strong></span>
			<?php
				$cIndice = "indIndice";
				$fechaHoy = date('Y-m-d');
				$link=Conectarse();
				$bdInd  = mysql_query("SELECT * FROM tabIndices Where fechaIndice = '".$fechaHoy."'");
				if($rowInd=mysql_fetch_array($bdInd)){

					$iMin = round((($rowInd['iMinimo'] 	/ 30) * $fd[2]),2);
					$iMet = round((($rowInd['iMeta'] 	/ 30) * $fd[2]),2);

					$cIndiceMet = "indIndice";
					if($rowInd['indVtas'] >= $iMet)	{ 
						$cIndiceMet = "indIndiceVerde"; 		
					}else{
						$cIndiceMet = "indIndiceRojo"; 		
					}
					
					$cIndiceMin = "indIndice";
					if($rowInd['indVtas'] >= $iMin)	{ 
						$cIndiceMin = "indIndiceVerde";
					}else{
						$cIndiceMin = "indIndiceRojo"; 
					}

					$cProduc = "indIndice";
					if($rowInd['iProductividad'] >= $iMin)	{ 
						$cProduc = "indIndiceVerde"; 		
						if($rowInd['iProductividad'] >= $iMet)	{ 
							$cProduc = "indIndiceVerde"; 		
						}else{
							$cProduc = "indIndiceAmarillo";
						}
					}else{
						$cProduc = "indIndiceRojo"; 		
					}
					
					$cIndice = "indIndice";
					if($rowInd['indVtas'] >= $iMin)	{
						// 15.45 >= 32 
						$cIndice = "indIndiceVerde"; 		
						if($rowInd['indVtas'] >= $iMet)	{ 
							$cIndice = "indIndiceVerde"; 		
						}else{
							$cIndice = "indIndiceAmarillo";
						}
					}else{
						$cIndice = "indIndiceRojo"; 		
					}

					?>
					<div class="<?php echo $cIndice; ?>" style="width:60px; text-align:center; float:right;">
						<span style="font-size:12px; ">Indice</span>
						<?php echo number_format($rowInd['indVtas'], 2, ',', '.');?>
					</div>
					<div class="<?php echo $cIndiceMet; ?>" style="width:60px; text-align:center; float:right;">
						<span style="font-size:12px; ">Meta</span>
						<?php echo number_format($rowInd['iMeta'], 2, ',', '.');?>
					</div>
					<div class="<?php echo $cIndiceMin; ?>" style="width:60px; text-align:center; float:right;">
						<span style="font-size:12px; ">Mínimo</span>
						<?php echo number_format($rowInd['iMinimo'], 2, ',', '.');?>
					</div>
					<div class="<?php echo $cProduc; ?>" style="width:60px; text-align:center; float:right;">
						<span style="font-size:12px; ">Produc.</span>
						<?php echo number_format($rowInd['iProductividad'], 2, ',', '.');?>
					</div>
					<?php
				}
				mysql_close($link);
			?>
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
									$tMes 	 	= 0;
									$tMesSp  	= 0;
									$tAc1118 	= 0;
									$tAc1118Sp 	= 0;
									$tAc19 	 	= 0;
									$tAc19Sp 	= 0;
									$t19	 	= 0;
									$tGastoAg	= 0;
									$tGastoAgSp	= 0;
									$tSue 	 	= 0;
									$tSue18 	= 0;
									$tSue19 	= 0;
									$tSue18Sp 	= 0;
									$tSue19Sp 	= 0;

									$tHon 	 	= 0;
									$p	  	 	= 0;
									
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
																	$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
																	if ($rowP=mysql_fetch_array($bdPer)){
																		$cFree = $rowP['cFree'];
																		if($rowP['cFree'] != 'on'){
																			if($rowGas['Neto']>0){
																				$tBruto += $rowGas['Neto'];
																				//$tBruto += $rowGas[Bruto];
																			}
																		}
																	}
																}while ($rowGas=mysql_fetch_array($result));
															}
															$tMes += $tBruto;

															// Iva Venta
															$rIva  = mysql_query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' and year(fechaFactura) = '".$Agno."' and month(fechaFactura) = '".$MesNum[$Mm]."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowIva	 = mysql_fetch_array($rIva);
															if($rowIva['tIvaVenta']>0){
																$dIva[$p] += $rowIva['tIvaVenta'];
															}

															if($tBruto > 0){
																echo '<strong id="linkRango"><a href="vtas.php?IdProyecto='.$rowPr['IdProyecto'].'&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=Uno">'.number_format($tBruto, 0, ',', '.').'</a></strong>'; 
															}
													echo '</td>';
													break;
												case 2:
													echo '<td align="right">';

															$tBruto = 0;
															$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$MesNum[$Mm]."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowGas=mysql_fetch_array($result)){
																do{
																	$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
																	if ($rowP=mysql_fetch_array($bdPer)){
																		$cFree = $rowP['cFree'];
																		if($rowP['cFree'] != 'on'){
																			if($rowGas['Neto']>0){
																				$tBruto += $rowGas['Neto'];
																				//$tBruto += $rowGas[Bruto];
																			}
																		}
																	}
																}while ($rowGas=mysql_fetch_array($result));
															}
															$tMes += $tBruto * 0.775;
															$sImp[$p] += $tBruto * 0.775;
															echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 
													echo '</td>';
													break;
												case 3:
													echo '<td align="right">';
															$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno and month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tIvaCompra']>0){
																$tMes += $rowGas['tIvaCompra'];
																$sIva[$p] += $rowGas['tIvaCompra'];
																$cIva[$p] += $rowGas['tIvaCompra'];
																echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
															}
													echo '</td>';
													break;
												case 4:
													echo '<td align="right">';
															// Sueldos +++
															$tSue 	= 0;
															$tHon 	= 0;
															$tFac 	= 0;
															
															$pPago = $MesNum[$Mm].'.'.$Agno;
															//$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE IdProyecto = 'IGT-1118' and PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");

															//$bdSu=mysql_query("SELECT * FROM Sueldos Where PeriodoPago = '".$pPago."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															$bdSu=mysql_query("SELECT * FROM Sueldos Where IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowSu=mysql_fetch_array($bdSu)){
																do{
																	if($rowSu['PeriodoPago'] == $pPago){
																		$tSue += $rowSu['Liquido'];
																	}
																	$fdPp = explode('.',$rowSu['PeriodoPago']);
																	if($fdPp[0] <= $MesNum[$Mm] and  $fdPp[1] == $Agno){
																		if($rowSu['IdProyecto'] == 'IGT-1118'){
																			$tSue18 += $rowSu['Liquido'];
																			if($rowSu['Estado'] != 'P'){
																				$tSue18Sp += $rowSu['Liquido'];
																			}
																		}
																		if($rowSu['IdProyecto'] == 'IGT-19'){
																			$tSue19 += $rowSu['Liquido'];
																			if($rowSu['Estado'] != 'P'){
																				$tSue19Sp += $rowSu['Liquido'];
																			}
																		}
																	}
																}while ($rowSu=mysql_fetch_array($bdSu));
															}
/*
															$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tLiquido']>0){
																$tSue += $rowGas['tLiquido'];
															}
*/															
															//$bdSu=mysql_query("SELECT * FROM Honorarios Where PeriodoPago = '".$pPago."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															$bdSu=mysql_query("SELECT * FROM Honorarios Where IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowSu=mysql_fetch_array($bdSu)){
																do{
																	if($rowSu['PeriodoPago'] == $pPago){
																		$tHon += $rowSu['Total'];
																	}
																	$fdPp = explode('.',$rowSu['PeriodoPago']);
																	if($fdPp[0] <= $MesNum[$Mm] and  $fdPp[1] == $Agno){
																		if($rowSu['IdProyecto'] == 'IGT-1118'){
																			$tSue18 += $rowSu['Total'];
																			if($rowSu['Cancelado'] != 'on'){
																				$tSue18Sp += $rowSu['Total'];
																			}
																		}
																		if($rowSu['IdProyecto'] == 'IGT-19'){
																			$tSue19 += $rowSu['Total'];
																			if($rowSu['Cancelado'] != 'on'){
																				$tSue19Sp += $rowSu['Total'];
																			}
																		}
																	}
																}while ($rowSu=mysql_fetch_array($bdSu));
															}

/*															$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tTotal']>0){
																$tHon += $rowGas['tTotal'];
															}
*/															
															// Suma Todas las Facturas Mes
															//$bdSu=mysql_query("SELECT * FROM Facturas Where year(FechaPago) = '".$Agno."' and PeriodoPago= '".$pPago."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															$bdSu=mysql_query("SELECT * FROM Facturas Where year(FechaPago) = '".$Agno."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowSu=mysql_fetch_array($bdSu)){
																do{
																	if($rowSu['PeriodoPago'] == $pPago){
																		$tFac += $rowSu['Bruto'];
																	}
																	$fdPp = explode('.',$rowSu['PeriodoPago']);
																	if($fdPp[0] <= $MesNum[$Mm] and  $fdPp[1] == $Agno){
																		if($rowSu['IdProyecto'] == 'IGT-1118'){
																			$tSue18 += $rowSu['Bruto'];
																			if($rowSu['Estado'] != 'P'){
																				$tSue18Sp += $rowSu['Bruto'];
																			}
																		}
																		if($rowSu['IdProyecto'] == 'IGT-19'){
																			$tSue19 += $rowSu['Bruto'];
																			if($rowSu['Estado'] != 'P'){
																				$tSue19Sp += $rowSu['Bruto'];
																			}
																		}
																	}
																}while ($rowSu=mysql_fetch_array($bdSu));
															}
/*
															$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE year(FechaPago) = '".$Agno."' and PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tFac += $rowGas['tBruto'];
															}
*/															
															$tMes += ($tSue + $tHon + $tFac);
															$sSue[$p] += ($tSue + $tHon + $tFac);
															if($sSue[$p] > 0){
																echo '<strong id="linkRango"><a href="dSueldos.php?IdProyecto='.$rowPr['IdProyecto'].'&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=MesProy">'.number_format(($tSue + $tHon + $tFac), 0, ',', '.').'</a></strong>'; 
															}
													echo '</td>';
													break;
												case 5:
													echo '<td align="right">';
															$tBruto 	= 0;
															$tBrutoSp 	= 0;
								     //$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' and year(FechaGasto) = $Agno and month(FechaGasto) <= '".$MesNum[$Mm]."' and IdProyecto = 'IGT-1118'");
															//$bdGas=mysql_query("SELECT * FROM MovGastos WHERE Modulo = 'G' and year(FechaGasto) = $Agno and month(FechaGasto)  = '".$MesNum[$Mm]."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															$bdGas=mysql_query("SELECT * FROM MovGastos WHERE Modulo = 'G' and year(FechaGasto) = $Agno and month(FechaGasto) <= '".$MesNum[$Mm]."'");
															if($rowGas=mysql_fetch_array($bdGas)){
																do{
																	$fd = explode('-',$rowGas['FechaGasto']);
																	if($fd[1] == $MesNum[$Mm] and $rowGas['IdProyecto'] == $rowPr['IdProyecto']){
																		$tBruto += $rowGas['Bruto'];
																		$tMes += $rowGas['Bruto'];
																		$sGto[$p] += $rowGas['Bruto'];
																		if($rowGas['Reembolso'] != 'on'){
																			$tBrutoSp += $rowGas['Bruto'];
																			$tMesSp += $rowGas['Bruto'];
																			if($rowGas['IdProyecto'] == 'IGT-19'){
																				//$t19 += $rowGas['Bruto'];
																			}
																		}
																	}
																	if($fd[1] <= $MesNum[$Mm] and $rowGas['IdProyecto'] == $rowPr['IdProyecto']){
																		$tGastoAg += $rowGas['Bruto'];
																		if($rowGas['Reembolso'] != 'on'){
																			$tGastoAgSp += $rowGas['Bruto'];
																		}
																		if($rowGas['IdProyecto'] == 'IGT-1118'){
																			$tAc1118 += $rowGas['Bruto'];
																			if($rowGas['Reembolso'] != 'on'){
																				$tAc1118Sp += $rowGas['Bruto'];
																			}
																		}
																		if($rowGas['IdProyecto'] == 'IGT-19'){
																			$tAc19 += $rowGas['Bruto'];
																			if($rowGas['Reembolso'] != 'on'){
																				$tAc19Sp += $rowGas['Bruto'];
																			}
																		}
																	}
																}while ($rowGas=mysql_fetch_array($bdGas));
															}
															echo '<strong id="linkRango"><a href="dGastos.php?IdProyecto='.$rowPr['IdProyecto'].'&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=MesProy">'.number_format($tBruto, 0, ',', '.').'</a></strong>'; 
															if($tBrutoSp > 0){
																echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?IdProyecto='.$rowPr['IdProyecto'].'&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=MesProy">'.number_format($tBrutoSp, 0, ',', '.').'</a></strong>'; 
															}
													echo '</td>';
													break;
												case 6:
													$tBru = 0;
													$tHon = 0;
													$sFac = 0;

													echo '<td align="right">';
															$tBruto = 0;
															$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno and month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tBru += $rowGas['tBruto'];
																$tMes += $tBru;
															}
															$fBruto = 0;
															$result  = mysql_query("SELECT SUM(Bruto) as fBruto FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['fBruto']>0){
																$sFac += $rowGas['fBruto'];
																$tMes += $sFac;
															}
															//$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && nInforme > 0 &&  PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$tTotal = 0;
															$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and  PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysql_fetch_array($result);
															if($rowGas['tTotal']>0){
																$tHon += $rowGas['tTotal'];
																$tMes += $tHon;
															}
															if(($tBru + $tHon + $sFac) > 0){
																echo '<strong id="linkRango"><a href="dInversion.php?IdProyecto='.$rowPr['IdProyecto'].'&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=MesProy">'.number_format(($tBru + $tHon + $sFac), 0, ',', '.').'</a></strong>'; 
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
									if($tMes > 0 and $i == 1){
										echo '<strong id="linkRango"><a href="vtas.php?mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=Meses">'.number_format($tMes, 0, ',', '.').'</a></strong>'; 
									}else{
										if($tMes > 0 and $i == 4){
											echo '<strong id="linkRango"><a href="dSueldos.php?mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=Mes">'.number_format($tMes, 0, ',', '.').'</a></strong>'; 
										}else{
											if($tMes > 0 and $i == 5){
												echo '<strong id="linkRango"><a href="dGastos.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Mes">'.number_format($tMes, 0, ',', '.').'</a></strong>'; 
												if($tMesSp > 0){
													echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Mes">'.number_format($tMesSp, 0, ',', '.').'</a></strong>'; 
												}
											}else{
												if($tMes > 0 and $i == 6){
													echo '<strong id="linkRango"><a href="dInversion.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Mes">'.number_format($tMes, 0, ',', '.').'</a></strong>'; 
												}else{
													echo '<strong>'.number_format($tMes, 0, ',', '.').'</strong>'; 
												}
											}
										}
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
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP['cFree'];
													if($rowP['cFree'] != 'on'){
														if($rowGas['Neto']>0){
															$tBruto += $rowGas['Neto'];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										echo '<strong id="linkRango"><a href="vtas.php?IdProyecto=IGT-1118&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($tBruto, 0, ',', '.').'</a></strong>'; 
										break;

									case 2:
										$sImp[5] = 0;
										$dIva[5] = 0;

										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP['cFree'];
													if($rowP['cFree'] != 'on'){
														if($rowGas['Neto']>0){
															$tBruto += $rowGas['Neto'];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes 		= $tBruto * 0.775;
										$sImp[5] 	= $tBruto * 0.775;

										// Iva Venta
										$result  = mysql_query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' && year(fechaFactura) = $Agno and month(fechaFactura) <= '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaVenta']>0){
											$dIva[5] += $rowGas['tIvaVenta'];
										}
										
										echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 
										break;
									case 3:
										$sIva[5] = 0;
										$cIva[5] = 0;
										
										$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaCompra']>0){
											$tMes 		= $rowGas['tIvaCompra'];
											$sIva[5] 	= $rowGas['tIvaCompra'];
											$cIva[5] 	= $rowGas['tIvaCompra'];
											echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
										}
										break;
									case 4:
										// Total Sueldos X Mes Proyecto 1118 +++
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										
										$pPago = $MesNum[$Mm].'.'.$Agno;
										
										$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tLiquido']>0){
											$tSue = $rowGas['tLiquido'];
										}

										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE IdProyecto = 'IGT-1118' and year(FechaPago) = '".$Agno."' and month(FechaPago) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$sSue[5] 	= ($tSue + $tTot + $tBru);
										if(($tSue + $tTot + $tBru) > 0){
											echo '<strong id="linkRango"><a href="dSueldos.php?IdProyecto=IGT-1118&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format(($tSue + $tTot + $tBru), 0, ',', '.').'</a></strong>'; 
											if($tSue18Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?IdProyecto=IGT-1118&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format($tSue18Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										break;
									case 5:
										// Columna 5 Total Anual Proyecto IGT-1118 +++
										if($tAc1118 > 0){
											$tMes = $tAc1118;
											echo '<strong id="linkRango"><a href="dGastos.php?IdProyecto=IGT-1118&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc1118, 0, ',', '.').'</a></strong>';
											if($tAc1118Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?IdProyecto=IGT-1118&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc1118Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										$sGto[5] 	= $tAc1118;
										break;
									case 6:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$fBru = 0;
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' and IdGasto = 2 && year(FechaGasto) = '".$Agno."' and month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto'] > 0){
											$tBru = $rowGas['tBruto'];
										}

										$result  = mysql_query("SELECT SUM(Bruto) as tBrutoF FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBrutoF']>0){
											$fBru = $rowGas['tBrutoF'];
										}

										//$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P' && IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago");
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										if(($tBru + $tTot + $fBru) > 0){
											echo '<strong id="linkRango"><a href="dInversion.php?IdProyecto=IGT-1118&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format(($tBru + $tTot + $fBru), 0, ',', '.').'</a></strong>'; 
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
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP['cFree'];
													if($rowP['cFree'] != 'on'){
														if($rowGas['Neto']>0){
															$tBruto += $rowGas['Neto'];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										echo '<strong id="linkRango"><a href="vtas.php?IdProyecto=IGT-19&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($tBruto, 0, ',', '.').'</a></strong>'; 
										break;
									case 2:
										$sImp[6] = 0;
										$dIva[6] = 0;
										
										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP['cFree'];
													if($rowP['cFree'] != 'on'){
														if($rowGas['Neto']>0){
															$tBruto += $rowGas['Neto'];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes 		= $tBruto * 0.775;
										$sImp[6] 	= $tBruto * 0.775;
										
										// Iva Venta
										$result  = mysql_query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' && year(fechaFactura) = $Agno and month(fechaFactura) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaVenta']>0){
											$dIva[6] += $rowGas['tIvaVenta'];
										}
										
										echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 
										break;
									case 3:
										$sIva[6] = 0;
										$cIva[6] = 0;
										$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaCompra']>0){
											$tMes 		= $rowGas['tIvaCompra'];
											$sIva[6] 	= $rowGas['tIvaCompra'];
											$cIva[6] 	= $rowGas['tIvaCompra'];
											echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
										}
										break;
									case 4:
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										//$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE Estado = 'P' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE IdProyecto = 'IGT-19' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tLiquido']>0){
											$tSue = $rowGas['tLiquido'];
										}
										//$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE Estado = 'P' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE IdProyecto = 'IGT-19' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE IdProyecto = 'IGT-19' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$sSue[6] 	= ($tSue + $tTot + $tBru);
										if(($tSue + $tTot + $tBru) > 0){
											echo '<strong id="linkRango"><a href="dSueldos.php?IdProyecto=IGT-19&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format(($tSue + $tTot + $tBru), 0, ',', '.').'</a></strong>'; 
											if($tSue19Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?IdProyecto=IGT-19&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format($tSue19Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										break;
									case 5:
										// Columna 5 Total Anual Proyecto IGT-19 +++
										$tMes = 0;
										if($tAc19 > 0){
											$tMes = $tAc19;
											echo '<strong id="linkRango"><a href="dGastos.php?IdProyecto=IGT-19&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc19, 0, ',', '.').'</a></strong>';
											if($tAc19Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?IdProyecto=IGT-19&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc19Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										$sGto[6] 	= $tAc19;

/*										
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes = $rowGas['tBruto'];
											echo '<strong id="linkRango"><a href="dGastos.php?IdProyecto=IGT-19&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($rowGas['tBruto'], 0, ',', '.').'</a></strong>'; 
										}
										if($t19 > 0){
											echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?IdProyecto=IGT-1118&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($t19, 0, ',', '.').'</a></strong>'; 
										}
										$sGto[6] 	= $rowGas['tBruto'];
*/										
										break;
									case 6:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$fBru = 0;
										
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}

										$result  = mysql_query("SELECT SUM(Bruto) as tBrutoF FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBrutoF']>0){
											$fBru = $rowGas['tBrutoF'];
										}

										//$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and IdProyecto = 'IGT-19' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										if(($tBru + $tTot + $fBru) > 0){
											echo '<strong id="linkRango"><a href="dInversion.php?IdProyecto=IGT-19&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format(($tBru + $tTot + $fBru), 0, ',', '.').'</a></strong>'; 
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
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP['cFree'];
													if($rowP['cFree'] != 'on'){
														if($rowGas['Neto']>0){
															$tBruto += $rowGas['Neto'];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes = $tBruto;
										echo '<strong id="linkRango"><a href="vtas.php?mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($tBruto, 0, ',', '.').'</a></strong>'; 
										break;
									case 2:
										$sImp[4] = 0;
										$dIva[4] = 0;
										
										$tBruto = 0;
										$result  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' && year(fechaSolicitud) = $Agno && month(fechaSolicitud) <=  '".$MesNum[$Mm]."'");
										if($rowGas=mysql_fetch_array($result)){
											do{
												$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
												if ($rowP=mysql_fetch_array($bdPer)){
													$cFree = $rowP['cFree'];
													if($rowP['cFree'] != 'on'){
														if($rowGas['Neto']>0){
															$tBruto += $rowGas['Neto'];
															//$tBruto += $rowGas[Bruto];
														}
													}
												}
											}while ($rowGas=mysql_fetch_array($result));
										}
										$tMes 		= $tBruto * 0.775;
										$sImp[4] 	= $tBruto * 0.775;

										// Iva Venta
										$result  = mysql_query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' && year(fechaFactura) = $Agno and month(fechaFactura) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaVenta']>0){
											$dIva[4] += $rowGas['tIvaVenta'];
										}
										
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
										$cIva[4] = 0;
										$result  = mysql_query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tIvaCompra']>0){
											$tMes 		= $rowGas['tIvaCompra'];
											$sIva[4] 	= $rowGas['tIvaCompra'];
											$cIva[4] 	= $rowGas['tIvaCompra'];
											echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
										}
										break;
									case 4:
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										//$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE Estado = 'P' && PeriodoPago <= $pPago");
										$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tLiquido']>0){
											$tSue = $rowGas['tLiquido'];
										}
										//$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE Estado = 'P' && PeriodoPago <= $pPago");
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}
										$sSue[4] 	= ($tSue + $tTot + $tBru);
										if(($tSue + $tTot + $tBru) > 0){
											//echo '<strong id="linkRango"><a href="dSueldos.php?IdProyecto=IGT-19&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format(($tSue + $tTot + $tBru), 0, ',', '.').'</a></strong>'; 
											echo '<strong id="linkRango"><a href="dSueldos.php?mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=Agno">'.number_format(($tSue + $tTot + $tBru), 0, ',', '.').'</a></strong>'; 
										}
										break;
									case 5:
										// Total Año Gastos +++
										$tMes = 0;
/*
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tMes = $rowGas['tBruto'];
											echo '<strong id="linkRango"><a href="dGastos.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Agno">'.number_format($rowGas['tBruto'], 0, ',', '.').'</a></strong>'; 
										}
										$sGto[4] 	= $rowGas['tBruto'];
*/										
										if($tGastoAg > 0){
											echo '<strong id="linkRango"><a href="dGastos.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Agno">'.number_format($tGastoAg, 0, ',', '.').'</a></strong>'; 
											if($tGastoAgSp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Agno">'.number_format($tGastoAgSp, 0, ',', '.').'</a></strong>'; 
											}
										}
										$sGto[4] 	= $tGastoAg;
										break;
									case 6:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$fBru = 0;
										
										$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}

										$result  = mysql_query("SELECT SUM(Bruto) as tBrutoF FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tBrutoF']>0){
											$fBru = $rowGas['tBrutoF'];
										}

										//$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P' && PeriodoPago <= $pPago");
										$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysql_fetch_array($result);
										if($rowGas['tTotal']>0){
											$tTot = $rowGas['tTotal'];
										}
										if(($tBru + $tTot + $fBru) > 0){
											echo '<strong id="linkRango"><a href="dInversion.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Agno">'.number_format(($tBru + $tTot + $fBru), 0, ',', '.').'</a></strong>'; 
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
<table width="<?php echo $maxTab; ?>"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos2">
	<tr>
		<td width="10%" height="50">Iva Venta Fact. Mes</td>
		<td width="15%" align="right">
			<?php 
				$impMes1 = 0;
				$impMes1 = $dIva[1] - $cIva[1];
				if($impMes1 <> 0){
					echo number_format($dIva[1], 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php 
				$impMes2 = 0;
				$impMes2 = $dIva[2] - $cIva[2];
				if($impMes2 <> 0){
					echo number_format($dIva[2], 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$tImpMes = $dIva[1] + $dIva[2];
				if($tImpMes > 0){
					echo number_format($tImpMes, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$impAgno1 = 0;
				$impAgno1 = $dIva[5];
				if($impAgno1 <> 0){
					echo number_format($impAgno1, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$impAgno2 = 0;
				$impAgno2 = $dIva[6];
				if($impAgno2 <> 0){
					echo number_format($impAgno2, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$tImpAgno = $impAgno1;
				if($tImpAgno > 0){
					echo number_format($tImpAgno, 0, ',', '.'); 
				}
			?>
		</td>
	</tr>

	<tr>
		<td colspan="7"><hr></td>
	</tr>
	<tr>
		<td width="10%" height="50">Iva a Pagar</td>
		<td width="15%" align="right">
			<?php 
				$impMes1 = 0;
				$impMes1 = $dIva[1] - $cIva[1];
				if($impMes1 <> 0){
					echo number_format($impMes1, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php 
				$impMes2 = 0;
				$impMes2 = $dIva[2] - $cIva[2];
				if($impMes2 <> 0){
					echo number_format($impMes2, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$tImpMes = $impMes1 + $impMes2;
				if($tImpMes > 0){
					echo number_format($tImpMes, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$impAgno1 = 0;
				$impAgno1 = $dIva[5] - $cIva[5];
				if($impAgno1 <> 0){
					echo number_format($impAgno1, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$impAgno2 = 0;
				$impAgno2 = $dIva[6] - $cIva[6];
				if($impAgno2 <> 0){
					echo number_format($impAgno2, 0, ',', '.'); 
				}
			?>
		</td>
		<td width="15%" align="right">
			<?php
				$tImpAgno = $impAgno1 + $impAgno2;
				if($tImpAgno > 0){
					echo number_format($tImpAgno, 0, ',', '.'); 
				}
			?>
		</td>
	</tr>




</table>
