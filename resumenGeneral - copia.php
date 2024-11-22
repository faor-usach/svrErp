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
	$bdInf=$link->query("SELECT * FROM Informes Order By AgnoInforme Asc");
	if($rowInf=mysqli_fetch_array($bdInf)){
		$prAgno = $rowInf['AgnoInforme'];
	}
	$link->close();
	
	$ivaVtaMes18 		= 0;
	
	$ItemsGen = array(	
					1 => 'Ventas', 
					2 => '0,775',
					3 => 'IVA Compras',
					4 => 'IVA Efectivo',
					5 => 'Sueldos',
					6 => 'Gastos',
					7 => 'Inversión'
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
<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="margin-bottom: 0px;">
	<form class="form-inline" name="form" action="plataformaErp.php" method="get">
		<div class="input-group mt-3 mb-3" style="padding:5px;">
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
		</div>
		<div class="input-group mt-3 mb-3" style="padding:5px;">
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
		</div>
		<button name="refrescar" class="btn btn-success" type="submit">Filtrar</button>
	</form>			
</nav>


<table class="table table-hover">
	<thead class="thead-light">
    	<th>
			<span style="padding-left:20px; font-size:24px;"><strong>Tabla Resumen General</strong></span>
			<?php
				$cIndice = "indIndice";
				$fechaHoy = date('Y-m-d');
				$fh = explode('-', $fechaHoy);
				
				$link=Conectarse();
				//echo intval($MesNum[$Mm]);
				$bdInd  = $link->query("SELECT * FROM tabIndices Where fechaIndice = '".$fechaHoy."'");
				//$bdInd  = $link->query("SELECT * FROM tabIndices Where month(fechaIndice) = '".$MesNum[$Mm]."' and year(fechaIndice) = '".$Agno."'");
				//$bdInd  = $link->query("SELECT * FROM tabIndices Where year(fechaIndice) = '".$Agno."'");
				if($rowInd=mysqli_fetch_array($bdInd)){

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
						$cIndice = "bg-success text-white"; 		
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
				$link->close();
			?>
		</th>
  	</tr>
	</thead>
</table>

<table class="table table-hover" style="margin-top: 0px;">
	<thead class="bg-info text-white text-center">
		<tr height="30">
			<th>
				<h4>Items</h4>
			</th>
				<?php
					$link=Conectarse();

					$arrayEfectivo = array(
						"IGT-1118"	=> array(
							"mes"	=> 0,
							"agno"	=> 0
						),
						"IGT-19"	=> array(
							"mes"	=> 0,
							"agno"	=> 0
						),
						"totales"	=> array(
							"mes"	=> 0,
							"agno"	=> 0,
						),
					);

					$arrayEfectivoPagar = array(
						"IGT-1118"	=> array(
							"mes"	=> 0,
							"agno"	=> 0
						),
						"IGT-19"	=> array(
							"mes"	=> 0,
							"agno"	=> 0
						),
						"totales"	=> array(
							"mes"	=> 0,
							"agno"	=> 0,
						),
					);
															
					$bdm=$link->query("SELECT * FROM movgastos Where efectivo ='on' and year(FechaGasto) = '".$Agno."'");
					while($rowm=mysqli_fetch_array($bdm)){
						if($rowm['Iva'] > 0){
							$fdEf = explode('-', $rowm['FechaGasto']);
							if($fdEf[0] == $Agno){
								$arrayEfectivo[$rowm['IdProyecto']]["agno"] += $rowm['Iva'];
								$arrayEfectivo['totales']["agno"] += $rowm['Iva'];
							}
							if($fdEf[1] == $MesNum[$Mm] and $fdEf[0] == $Agno){
								$arrayEfectivo[$rowm['IdProyecto']]["mes"] += $rowm['Iva'];
								$arrayEfectivo['totales']["mes"] += $rowm['Iva'];
							}
						}
					}


					$bdPr=$link->query("SELECT * FROM Proyectos");
					while($rowPr=mysqli_fetch_array($bdPr)){?>
							<th class="text-right"><?php echo $rowPr['IdProyecto']; ?></th>
							<?php
							$sColumna = array($rowPr['IdProyecto'] => 0 );
					}
					$link->close();
					?>
                    <th class="text-right">Total Mes</th>
					<?php
					$link=Conectarse();
					$bdPr=$link->query("SELECT * FROM Proyectos");
					while($rowPr=mysqli_fetch_array($bdPr)){?>
							<th class="text-right"><?php echo $rowPr['IdProyecto']; ?></th>
							<?php
					}
					$link->close();
				?>
			<th class="text-right">Total Año <?php echo $Agno; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$taEfectivo = 0;
			for($i=1; $i <=7 ; $i++){?>
				<tr>
					<td height="30" align="right"><?php echo $ItemsGen[$i]; ?></td>
						<?php
							//$Agno = 2014;
							//$Agno = date('Y');
							$tmEfectivo			= 0;

							$tMes 	 			= 0;
							$tMesSp  			= 0;
							$tAc1118 			= 0;
							$tAc1118Sp 			= 0;
							$tAc19 	 			= 0;
							$tAc19Sp 			= 0;
							$t19	 			= 0;
							$tGastoAg			= 0;
							$tGastoAgSp			= 0;
							$tSue 	 			= 0;
							$tSueGral			= 0;
							$tSue18 			= 0;
							$tSue19 			= 0;
							$tSue18Sp 			= 0;
							$tSue19Sp 			= 0;
							$facturasSP 		= 0;
							$facturasMes		= 0;
							$facturasAgno		= 0;
							$facturas19			= 0;
							$facturas18			= 0;
							$facturasSPMes 		= 0;
							$facturasSPMes19	= 0;
							$facturasSPMes18	= 0;
							$facturasSPAgno19	= 0;
							$facturasSPAgno18	= 0;
							$facturasSPAgno		= 0;
							$impMes				= 0;
							$imp18Agno			= 0;
							$imp19Agno			= 0;
							$ivaCompra18		= 0;
							$ivaCompra19		= 0;
							$ivaCompraMes		= 0;
							$tHon 	 	= 0;
							$p	  	 	= 0;
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							if($rowPr=mysqli_fetch_array($bdPr)){
								do{

									$p++;
									switch ($i) {
										case 1:
											echo '<td align="right">';
													$tBruto = 0;
													$result  = $link->query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = $Agno and IdProyecto = '".$rowPr['IdProyecto']."' and Eliminado != 'on'");
													while($rowGas=mysqli_fetch_array($result)){
															$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
														if ($rowP=mysqli_fetch_array($bdPer)){
																$cFree = $rowP['cFree'];
															if($rowP['cFree'] != 'on'){
																$fdf = explode('-',$rowGas['fechaSolicitud']);
																if($rowGas['pagoFactura'] != 'on'){
																				$facturasSPAgno += $rowGas['Neto'];
																}
																if($rowGas['Neto'] > 0){
																	if($fdf[1] == $MesNum[$Mm]){
																		$tBruto += $rowGas['Neto'];
																		$facturasMes += $rowGas['Neto'];
																		if($rowGas['pagoFactura'] != 'on'){
																			$facturasSPMes += $rowGas['Neto'];
																			$facturasSP += $rowGas['Neto'];
																			if($rowGas['IdProyecto'] == 'IGT-1118'){
																				$facturasSPMes18 += $rowGas['Neto'];
																			}
																			if($rowGas['IdProyecto'] == 'IGT-19'){
																				$facturasSPMes19 += $rowGas['Neto'];
																			}
																		}
																	}
																	if($rowGas['pagoFactura'] != 'on'){
																		if($fdf[1] <= $MesNum[$Mm]){
																			if($rowGas['IdProyecto'] == 'IGT-1118'){
																				$facturasSPAgno18 += $rowGas['Neto'];
																			}
																			if($rowGas['IdProyecto'] == 'IGT-19'){
																					$facturasSPAgno19 += $rowGas['Neto'];
																			}
																		}
																	}
																	if($fdf[1] <= $MesNum[$Mm]){
																		if($rowGas['IdProyecto'] == 'IGT-1118'){
																			$facturas18 += $rowGas['Neto'];
																		}
																		if($rowGas['IdProyecto'] == 'IGT-19'){
																			$facturas19 += $rowGas['Neto'];
																		}
																	}
																}
															}
														}
													}
															$tMes += $tBruto;

															// Iva Venta
															$rIva  = $link->query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' and year(fechaFactura) = '".$Agno."' and month(fechaFactura) = '".$MesNum[$Mm]."' and IdProyecto = '".$rowPr['IdProyecto']."' and Eliminado != 'on'");
															$rowIva	 = mysqli_fetch_array($rIva);
															if($rowIva['tIvaVenta']>0){
																$dIva[$p] += $rowIva['tIvaVenta'];
																$arrayEfectivoPagar[$rowPr['IdProyecto']]["mes"] += $rowIva['tIvaVenta'];
															}

															if($tBruto > 0){
																echo '<strong id="linkRango"><a href="vtas.php?IdProyecto='.$rowPr['IdProyecto'].'&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=Uno">'.number_format($tBruto, 0, ',', '.').'</a></strong>'; 
																if($rowPr['IdProyecto'] == 'IGT-1118'){
																	if($facturasSPMes18 > 0){
																		echo '<br><strong id="linkRangoRojo"><a href="vtas.php?nivelDetalle=2&IdProyecto='.$rowPr['IdProyecto'].'&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=Uno">'.number_format($facturasSPMes18, 0, ',', '.').'</a></strong>'; 
																	}
																}
																if($rowPr['IdProyecto'] == 'IGT-19'){
																	if($facturasSPMes19 > 0){
																		echo '<br><strong id="linkRangoRojo"><a href="vtas.php?nivelDetalle=2&IdProyecto='.$rowPr['IdProyecto'].'&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=Uno">'.number_format($facturasSPMes19, 0, ',', '.').'</a></strong>'; 
																	}
																}
															}
													echo '</td>';
													break;
												case 2:
													echo '<td align="right">';

															$tBruto = 0;
															
															$result  = $link->query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = $Agno and IdProyecto = '".$rowPr['IdProyecto']."' and Eliminado != 'on'");
															if($rowGas=mysqli_fetch_array($result)){
																do{
																	$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
																	if ($rowP=mysqli_fetch_array($bdPer)){
																		$cFree = $rowP['cFree'];
																		if($rowP['cFree'] != 'on'){
																			$fdfa = explode('-', $rowGas['fechaSolicitud']);
																			if($rowGas['Neto'] > 0){
																				if($fdfa[1] == $MesNum[$Mm]){
																					$tBruto += $rowGas['Neto'];
																					$impMes += $rowGas['Neto'];
																				}
																				if($fdfa[1] <= $MesNum[$Mm]){
																					if($rowGas['IdProyecto'] == 'IGT-1118'){
																						$imp18Agno += $rowGas['Neto'];
																					}
																					if($rowGas['IdProyecto'] == 'IGT-19'){
																						$imp19Agno += $rowGas['Neto'];
																					}
																				}
																			}
																		}
																	}
																}while ($rowGas=mysqli_fetch_array($result));
															}
															
															$tMes += $tBruto * 0.775;
															$sImp[$p] += $tBruto * 0.775;
															echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>';
															 
													echo '</td>';
													break;
												case 3:
													echo '<td align="right">';
															$ivaCompra = 0;
															$result  = $link->query("SELECT * FROM MovGastos WHERE Estado = 'I' and year(FechaGasto) = $Agno and IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowGas=mysqli_fetch_array($result)){
																do{
																	$fdfg = explode('-',$rowGas['FechaGasto']);
																	if($fdfg[1] == $MesNum[$Mm]){
																		if($rowGas['Iva'] > 0){
																			$ivaCompra 		+= $rowGas['Iva'];
																			$ivaCompraMes 	+= $rowGas['Iva'];
																		}
																	}
																	if($fdfg[1] <= $MesNum[$Mm]){
																		if($rowGas['Iva'] > 0){
																			if($rowGas['IdProyecto'] == 'IGT-1118'){
																				$ivaCompra18 += $rowGas['Iva'];
																			}
																			if($rowGas['IdProyecto'] == 'IGT-19'){
																				$ivaCompra19 += $rowGas['Iva'];
																			}
																		}
																	}
																}while ($rowGas=mysqli_fetch_array($result));
															}
															
															if($ivaCompra > 0){
																$tMes += $ivaCompra;
																$sIva[$p] += $ivaCompra;
																$cIva[$p] += $ivaCompra;?>
																<strong>
																	<a href="facturasCompras.php?IdProyecto=<?php echo $rowPr['IdProyecto']; ?>&mesCpra=<?php echo $MesNum[$Mm]; ?>&ageCpra=<?php echo $Agno; ?>&periodo=Mes">
																	<?php echo number_format($ivaCompra, 0, ',', '.'); ?>
																	</a>
																</strong>
																<?php 
															}
															
													echo '</td>';
													break;
												case 4:?>
													<td  align="right">
														<?php
														echo number_format($arrayEfectivo[$rowPr['IdProyecto']]["mes"], 0, ',', '.');
														?>
													</td>
													<?php
													break;
												case 5:
													echo '<td align="right">';
															// Sueldos
															$tSue 	= 0;
															$tHon 	= 0;
															$tFac 	= 0;
															
															$pPago = $MesNum[$Mm].'.'.$Agno;
															$bdSu=$link->query("SELECT * FROM Sueldos Where IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowSu=mysqli_fetch_array($bdSu)){
																do{
																	if($rowSu['PeriodoPago'] == $pPago){
																		$tSue += $rowSu['Liquido'];
																	}
																	$fdPp = explode('.',$rowSu['PeriodoPago']);
																	if($fdPp[0] <= $MesNum[$Mm] and  $fdPp[1] == $Agno){
																		$tSueGral += $rowSu['Liquido'];
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
																}while ($rowSu=mysqli_fetch_array($bdSu));
															}

															$bdSu=$link->query("SELECT * FROM Honorarios Where IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowSu=mysqli_fetch_array($bdSu)){
																do{
																	if($rowSu['PeriodoPago'] == $pPago){
																		$tHon += $rowSu['Total'];
																	}
																	$fdPp = explode('.',$rowSu['PeriodoPago']);
																	if($fdPp[0] <= $MesNum[$Mm] and  $fdPp[1] == $Agno){
																		$tSueGral += $rowSu['Total'];
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
																}while ($rowSu=mysqli_fetch_array($bdSu));
															}

															$bdSu=$link->query("SELECT * FROM Facturas Where year(FechaPago) = '".$Agno."' and IdProyecto = '".$rowPr['IdProyecto']."'");
															if($rowSu=mysqli_fetch_array($bdSu)){
																do{
																	if($rowSu['PeriodoPago'] == $pPago){
																		$tFac += $rowSu['Bruto'];
																	}
																	$fdPp = explode('.',$rowSu['PeriodoPago']);
																	if($fdPp[0] <= $MesNum[$Mm] and  $fdPp[1] == $Agno){
																		$tSueGral += $rowSu['Bruto'];
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
																}while ($rowSu=mysqli_fetch_array($bdSu));
															}
															$tMes += ($tSue + $tHon + $tFac);
															$sSue[$p] += ($tSue + $tHon + $tFac);
															if($sSue[$p] > 0){
																echo '<strong id="linkRango"><a href="dSueldos.php?IdProyecto='.$rowPr['IdProyecto'].'&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=MesProy">'.number_format(($tSue + $tHon + $tFac), 0, ',', '.').'</a></strong>'; 
															}
																if($rowPr['IdProyecto'] == 'IGT-1118'){
																	if($tSue18Sp > 0){
																		echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?nivelDetalle=2&IdProyecto='.$rowPr['IdProyecto'].'&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=MesProy">'.number_format($tSue18Sp, 0, ',', '.').'</a></strong>'; 
																	}
																}
																if($rowPr['IdProyecto'] == 'IGT-19'){
																	if($tSue19Sp > 0){
																		echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?nivelDetalle=2&IdProyecto='.$rowPr['IdProyecto'].'&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=MesProy">'.number_format($tSue19Sp, 0, ',', '.').'</a></strong>'; 
																	}
																}
													echo '</td>';
													break;
												case 6:
													echo '<td align="right">';
															$tBruto 	= 0;
															$tBrutoSp 	= 0;
															// +++
															$bdGas=$link->query("SELECT * FROM MovGastos WHERE Modulo = 'G' and year(FechaGasto) = $Agno and month(FechaGasto) <= '".$MesNum[$Mm]."'");
															if($rowGas=mysqli_fetch_array($bdGas)){
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
																}while ($rowGas=mysqli_fetch_array($bdGas));
															}
															echo '<strong id="linkRango"><a href="dGastos.php?IdProyecto='.$rowPr['IdProyecto'].'&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=MesProy">'.number_format($tBruto, 0, ',', '.').'</a></strong>'; 
															if($tBrutoSp > 0){
																echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?nivelDetalle=2&nivelDetalle=2&IdProyecto='.$rowPr['IdProyecto'].'&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=MesProy">'.number_format($tBrutoSp, 0, ',', '.').'</a></strong>'; 
															}
													echo '</td>';
													break;
												case 7:
													$tBru = 0;
													$tHon = 0;
													$sFac = 0;

													echo '<td align="right">';
															$tBruto = 0;
															$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno and month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysqli_fetch_array($result);
															if($rowGas['tBruto']>0){
																$tBru += $rowGas['tBruto'];
																$tMes += $tBru;
															}
															$fBruto = 0;
															$result  = $link->query("SELECT SUM(Bruto) as fBruto FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysqli_fetch_array($result);
															if($rowGas['fBruto']>0){
																$sFac += $rowGas['fBruto'];
																$tMes += $sFac;
															}
															//$result  = $link->query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && nInforme > 0 &&  PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$tTotal = 0;
															$result  = $link->query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and  PeriodoPago= '".$pPago."' && IdProyecto = '".$rowPr['IdProyecto']."'");
															$rowGas	 = mysqli_fetch_array($result);
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
										}while ($rowPr=mysqli_fetch_array($bdPr));
									}
								?>
							<td align="right">
								<?php 
									if($tMes > 0 and $i == 1){
										echo '<strong id="linkRango"><a href="vtas.php?mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=Meses">'.number_format($facturasMes, 0, ',', '.').'</a></strong>'; 
										$facturasSPMes = $facturasSPMes18 + $facturasSPMes19;
										if($facturasSPMes > 0){
											echo '<br><strong id="linkRangoRojo"><a href="vtas.php?nivelDetalle=2&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=Meses">'.number_format($facturasSPMes, 0, ',', '.').'</a></strong>'; 
										}
									}else{
										if($tMes > 0 and $i == 3){
											//echo $tMes
											?>
											<strong>
												<a href="facturasCompras.php?mesCpra=<?php echo $MesNum[$Mm]; ?>&ageCpra=<?php echo $Agno; ?>&periodo=Mes">

													<?php echo number_format($ivaCompraMes, 0, ',', '.'); ?>
												</a>
											</strong>
											<?php

										}else{
											if($i == 4){
												echo number_format($arrayEfectivo['totales']["mes"], 0, ',', '.');
												//echo number_format($tmEfectivo, 0, ',', '.');

											}else{
												if($tMes > 0 and $i == 5){
													echo '<strong id="linkRango"><a href="dSueldos.php?mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=Mes">'.number_format($tMes, 0, ',', '.').'</a></strong>'; 
													if(($tSue18Sp + $tSue19Sp) > 0){
														echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?nivelDetalle=2&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=Mes">'.number_format(($tSue18Sp + $tSue19Sp), 0, ',', '.').'</a></strong>'; 
													}
												}else{
													if($tMes > 0 and $i == 6){
														echo '<strong id="linkRango"><a href="dGastos.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Mes">'.number_format($tMes, 0, ',', '.').'</a></strong>'; 
														if($tMesSp > 0){
															echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?nivelDetalle=2&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Mes">'.number_format($tMesSp, 0, ',', '.').'</a></strong>'; 
														}
													}else{
														if($tMes > 0 and $i == 7){
															echo '<strong id="linkRango"><a href="dInversion.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Mes">'.number_format($tMes, 0, ',', '.').'</a></strong>'; 
														}else{
															//echo '<strong>'.number_format($tMes, 0, ',', '.').'</strong>'; 
															echo '<strong>'.number_format($impMes * 0.775, 0, ',', '.').'</strong>';
														}
													}
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
										echo '<strong id="linkRango"><a href="vtas.php?IdProyecto=IGT-1118&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($facturas18, 0, ',', '.').'</a></strong>'; 
										if($facturasSPAgno18 > 0){
											echo '<br><strong id="linkRangoRojo"><a href="vtas.php?nivelDetalle=2&IdProyecto=IGT-1118&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($facturasSPAgno18, 0, ',', '.').'</a></strong>'; 
										}
										break;

									case 2:
										$sImp[5] = 0;
										$dIva[5] = 0;

										$tMes 		= $imp18Agno * 0.775;
										$sImp[5] 	= $imp18Agno * 0.775;

										// Iva Venta
										$result  = $link->query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' and year(fechaFactura) = $Agno and month(fechaFactura) <= '".$MesNum[$Mm]."' and IdProyecto = 'IGT-1118' and Eliminado != 'on'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tIvaVenta']>0){
											$dIva[5] += $rowGas['tIvaVenta'];
										}
										
										echo '<strong>'.number_format($imp18Agno * 0.775, 0, ',', '.').'</strong>'; 

										break;
									case 3:
										$sIva[5] = 0;
										$cIva[5] = 0;
										if($ivaCompra18 > 0){
											$tMes 		= $ivaCompra18;
											$sIva[5] 	= $ivaCompra18;
											$cIva[5] 	= $ivaCompra18;?>
											<strong>
												<a href="facturasCompras.php?IdProyecto=IGT-1118&ageCpra=<?php echo $Agno; ?>&periodo=Año">

													<?php echo number_format($ivaCompra18, 0, ',', '.'); ?>
												</a>
											</strong>

											<?php
										}
										break;
									case 4:
										echo number_format($arrayEfectivo['IGT-1118']["agno"], 0, ',', '.');
										break;
									case 5:
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										$sSue[5] 	= $tSue18;
										if($tSue18 > 0){
											echo '<strong id="linkRango"><a href="dSueldos.php?IdProyecto=IGT-1118&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format($tSue18, 0, ',', '.').'</a></strong>'; 
											if($tSue18Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?nivelDetalle=2&IdProyecto=IGT-1118&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format($tSue18Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										break;
									case 6:
										// Columna 5 Total Anual Proyecto IGT-1118 +++
										if($tAc1118 > 0){
											$tMes = $tAc1118;
											echo '<strong id="linkRango"><a href="dGastos.php?IdProyecto=IGT-1118&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc1118, 0, ',', '.').'</a></strong>';
											if($tAc1118Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?nivelDetalle=2&IdProyecto=IGT-1118&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc1118Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										$sGto[5] 	= $tAc1118;
										break;
									case 7:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$fBru = 0;
										$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' and IdGasto = 2 && year(FechaGasto) = '".$Agno."' and month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tBruto'] > 0){
											$tBru = $rowGas['tBruto'];
										}

										$result  = $link->query("SELECT SUM(Bruto) as tBrutoF FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-1118'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tBrutoF']>0){
											$fBru = $rowGas['tBrutoF'];
										}

										$result  = $link->query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and IdProyecto = 'IGT-1118' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysqli_fetch_array($result);
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
										echo '<strong id="linkRango"><a href="vtas.php?IdProyecto=IGT-19&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($facturas19, 0, ',', '.').'</a></strong>'; 
										if($facturasSPAgno19 > 0){
											echo '<br><strong id="linkRangoRojo"><a href="vtas.php?nivelDetalle=2&IdProyecto=IGT-19&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($facturasSPAgno19, 0, ',', '.').'</a></strong>'; 
										}
										break;
									case 2:
										$sImp[6] = 0;
										$dIva[6] = 0;
										$tMes 		= $imp19Agno * 0.775;
										$sImp[6] 	= $imp19Agno * 0.775;

										$IdProyectoP = 'IGT-19';
										//echo $IdProyectoP; // Error aqui
										// Iva Venta
										//echo $rowPr['IdProyecto'];
										$result  = $link->query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' && year(fechaFactura) = $Agno and month(fechaFactura) = '".$MesNum[$Mm]."' && IdProyecto = '".$IdProyectoP."' and Eliminado != 'on'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tIvaVenta']>0){
											$dIva[6] += $rowGas['tIvaVenta'];
										}
										
										echo '<strong>'.number_format($imp19Agno * 0.775, 0, ',', '.').'</strong>'; 
										break;
									case 3:
										$sIva[6] = 0;
										$cIva[6] = 0;
										if($ivaCompra19 > 0){
											$tMes 		= $ivaCompra19;
											$sIva[6] 	= $ivaCompra19;
											$cIva[6] 	= $ivaCompra19;?>

											<strong>
												<a href="facturasCompras.php?IdProyecto=<?php echo $rowPr['IdProyecto']; ?>&mesCpra=<?php echo $MesNum[$Mm]; ?>&ageCpra=<?php echo $Agno; ?>&periodo=Año">

													<?php echo number_format($ivaCompra19, 0, ',', '.'); ?>
												</a>
											</strong>


											<?php
											//echo '<strong>'.number_format($ivaCompra19, 0, ',', '.').'</strong>'; 
										}
										break;
									case 4:
										echo number_format($arrayEfectivo['IGT-19']["agno"], 0, ',', '.');
										break;
									case 5:
										$tSue = 0;
										$tTot = 0;
										$tBru = 0;
										$sSue[6] 	= $tSue19;
										if($tSue19 > 0){
											echo '<strong id="linkRango"><a href="dSueldos.php?IdProyecto=IGT-19&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format($tSue19, 0, ',', '.').'</a></strong>'; 
											if($tSue19Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?nivelDetalle=2&IdProyecto=IGT-19&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=AgnoProy">'.number_format($tSue19Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										break;
									case 6:
										// Columna 5 Total Anual Proyecto IGT-19 +++
										$tMes = 0;
										if($tAc19 > 0){
											$tMes = $tAc19;
											echo '<strong id="linkRango"><a href="dGastos.php?IdProyecto=IGT-19&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc19, 0, ',', '.').'</a></strong>';
											if($tAc19Sp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?nivelDetalle=2&IdProyecto=IGT-19&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=AgnoProy">'.number_format($tAc19Sp, 0, ',', '.').'</a></strong>'; 
											}
										}
										$sGto[6] 	= $tAc19;
										break;
									case 7:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$fBru = 0;
										
										$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}

										$result  = $link->query("SELECT SUM(Bruto) as tBrutoF FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) <=  '".$MesNum[$Mm]."' && IdProyecto = 'IGT-19'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tBrutoF']>0){
											$fBru = $rowGas['tBrutoF'];
										}

										//$result  = $link->query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P' && IdProyecto = 'IGT-19' && PeriodoPago <= $pPago");
										$result  = $link->query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and IdProyecto = 'IGT-19' && PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysqli_fetch_array($result);
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
										$facturasAgno = $facturas19 + $facturas18;
										$tMes = $facturasAgno;
										
										echo '<strong id="linkRango"><a href="vtas.php?mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($facturasAgno, 0, ',', '.').'</a></strong>'; 
										if($facturasSPAgno > 0){
											echo '<br><strong id="linkRangoRojo"><a href="vtas.php?nivelDetalle=2&mesVta='.$MesNum[$Mm].'&ageVta='.$Agno.'&vta=AgnoProy">'.number_format($facturasSPAgno, 0, ',', '.').'</a></strong>'; 
										}
										break;
									case 2:
										$sImp[4] = 0;
										$dIva[4] = 0;
										
										$impAnual = (($imp18Agno+$imp19Agno) * 0.775);
										$tMes 		= $impAnual * 0.775;
										$sImp[4] 	= $impAnual * 0.775;

										// Iva Venta
										$IdProyectoP = 'IGT-1118';

										$result  = $link->query("SELECT SUM(Iva) as tIvaVenta FROM SolFactura WHERE Estado = 'I' && year(fechaFactura) = $Agno and month(fechaFactura) = '".$MesNum[$Mm]."' && IdProyecto = '".$IdProyectoP."' and Eliminado != 'on'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tIvaVenta']>0){
											$dIva[4] += $rowGas['tIvaVenta'];
										}
										
										//echo '<strong>'.number_format($tBruto * 0.775, 0, ',', '.').'</strong>'; 
										echo '<strong>'.number_format($impAnual, 0, ',', '.').'</strong>'; 
										break;
									case 3:
										$sIva[4] = 0;
										$cIva[4] = 0;
										$ivaCompraAnual = $ivaCompra18 + $ivaCompra19;
										if($ivaCompraAnual > 0){
											$tMes 		= $ivaCompraAnual;
											$sIva[4] 	= $ivaCompraAnual;
											$cIva[4] 	= $ivaCompraAnual;?>

											<strong>
												<a href="facturasCompras.php?ageCpra=<?php echo $Agno; ?>&periodo=Año">

													<?php echo number_format($ivaCompraAnual, 0, ',', '.'); ?>
												</a>
											</strong>


											<?php
										}
										
										break;
									case 4:
										echo number_format($arrayEfectivo['totales']["agno"], 0, ',', '.');
										break;
									case 5:
										$sSue[4] 	= $tSueGral;
										if($tSueGral > 0){
											echo '<strong id="linkRango"><a href="dSueldos.php?mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=Agno">'.number_format($tSueGral, 0, ',', '.').'</a></strong>'; 
											$tSueGralSp = $tSue18Sp + $tSue19Sp;
											if($tSueGralSp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dSueldos.php?nivelDetalle=2&mesSueldos='.$MesNum[$Mm].'&ageSueldos='.$Agno.'&Sueldos=Agno">'.number_format($tSueGralSp, 0, ',', '.').'</a></strong>'; 
											}
										}
										break;
									case 6:
										// Total A? Gastos +++
										$tMes = 0;
										if($tGastoAg > 0){
											echo '<strong id="linkRango"><a href="dGastos.php?mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Agno">'.number_format($tGastoAg, 0, ',', '.').'</a></strong>'; 
											if($tGastoAgSp > 0){
												echo '<br><strong id="linkRangoRojo"><a href="dGastos.php?nivelDetalle=2&mesGastos='.$MesNum[$Mm].'&ageGastos='.$Agno.'&Gastos=Agno">'.number_format($tGastoAgSp, 0, ',', '.').'</a></strong>'; 
											}
										}
										$sGto[4] 	= $tGastoAg;
										break;
									case 7:
										$tMes = 0;
										$tBru = 0;
										$tTot = 0;
										$fBru = 0;
										
										$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && IdGasto = 2 && year(FechaGasto) = $Agno && month(FechaGasto) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tBruto']>0){
											$tBru = $rowGas['tBruto'];
										}

										$result  = $link->query("SELECT SUM(Bruto) as tBrutoF FROM Facturas WHERE TpCosto = 'I' and year(FechaPago) = $Agno and month(FechaPago) <=  '".$MesNum[$Mm]."'");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tBrutoF']>0){
											$fBru = $rowGas['tBrutoF'];
										}
										$result  = $link->query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE TpCosto = 'I' and PeriodoPago <= $pPago and substr(PeriodoPago,4,4) = $Agno");
										$rowGas	 = mysqli_fetch_array($result);
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
	</tbody>
	
	<tfoot class="bg-dark text-white text-right">
	<tr>
		<th height="50">Saldos </th>
		<th>
			<?php 
				$tSaldo1 = $sImp[1] - ($sSue[1] + $sGto[1]);
				if($tSaldo1 <> 0){
					echo '<span align="right">'.number_format($tSaldo1, 0, ',', '.').'</span>'; 
				}
			?>
			
		</th>
		<th>
			<?php 
				$tSaldo2 = $sImp[2] - ($sSue[2] + $sGto[2]);
				if($tSaldo2 <> 0){
					echo number_format($tSaldo2, 0, ',', '.'); 
				}
			?>
		</th>
		<th>
			<?php 
				if(($tSaldo1 + $tSaldo2) <> 0){
					echo number_format(($tSaldo1 + $tSaldo2), 0, ',', '.'); 
				}
			?>
		</th>
		<th>
			<?php 
				$tSaldoPry1 = $sImp[5] - ($sSue[5] + $sGto[5]);
				if($tSaldoPry1 <> 0){
					echo number_format($tSaldoPry1, 0, ',', '.'); 
				}
			?>
		</th>
		<th>
			<?php 
				$tSaldoPry2 = $sImp[6] - ($sSue[6] + $sGto[6]);
				if($tSaldoPry2 <> 0){
					echo number_format($tSaldoPry2, 0, ',', '.'); 
				}
			?>
		</th>
		<th align="right">
			<?php 
				$tSaldo4 = $impAnual - ($sSue[4] + $sGto[4]);
				if($tSaldo4 <> 0){
					echo number_format($tSaldo4, 0, ',', '.'); 
				}
			?>
		</th>
	</tr>
	<tr class="bg-dark text-white text-right">
		<th width="10%" height="50">Saldo c/Iva</td>
		<th width="15%">
			<?php 
				//$tSaldo1 = ($sImp[1] + $sIva[1]) - ($sSue[1] + $sGto[1]);
				$tSaldo1 = ($sImp[1] - ($sSue[1] + $sGto[1])) + (($dIva[1] - $cIva[1]) - ($sImp[1] - ($sSue[1] + $sGto[1])));
				$A = ($sImp[1] - ($sSue[1] + $sGto[1]));
				$C = $dIva[1] - $cIva[1];
				$B = $dIva[1];
				$tSaldo1 = $A + ($B - $C);
				
				if($tSaldo1 <> 0){
					echo number_format($tSaldo1, 0, ',', '.'); 
				}
			?>
		</th>
		<th width="15%">
			<?php 
				$tSaldo2 = ($sImp[2] + $sIva[2]) - ($sSue[2] + $sGto[2]);
				if($tSaldo2 <> 0){
					echo number_format($tSaldo2, 0, ',', '.'); 
				}
			?>
		</th>
		<th width="15%">
			<?php 
				if(($tSaldo1 + $tSaldo2) <> 0){
					echo number_format(($tSaldo1 + $tSaldo2), 0, ',', '.'); 
				}
			?>
		</th>
		<th width="15%">
			<?php 
				$tSaldoPry1 = ($sImp[5] + $sIva[5]) - ($sSue[5] + $sGto[5]);
				if($tSaldoPry1 <> 0){
					echo number_format($tSaldoPry1, 0, ',', '.'); 
				}
			?>
		</th>
		<th width="15%">
			<?php 
				$tSaldoPry2 = ($sImp[6] + $sIva[6]) - ($sSue[6] + $sGto[6]);
				if($tSaldoPry2 <> 0){
					echo number_format($tSaldoPry2, 0, ',', '.'); 
				}
			?>
		</th>
		<th width="15%">
			<?php 
				$tSaldo4 = ($impAnual + $sIva[4]) - ($sSue[4] + $sGto[4]);
				if($tSaldo4 <> 0){
					echo number_format($tSaldo4, 0, ',', '.'); 
				}
			?>
		</th>
	</tr>


	<tr class="bg-dark text-white text-right">
		<th width="10%" height="50">Saldo c/Iva Efectivo</td>
		<th width="15%">
			<?php
				$s1 = ($sImp[1] - ($sSue[1] + $sGto[1]));
				$A = ($sImp[1] - ($sSue[1] + $sGto[1]));
				$B = $dIva[1];
				$D = $dIva[1] - $arrayEfectivo['IGT-1118']["mes"];
				
				$s1 = $A + ($B - $D);
				echo number_format($s1, 0, ',', '.');
			?>
		</th>
		<th width="15%">
			<?php
				$s2 = ($sImp[2] - ($sSue[2] + $sGto[2]));
				$A = ($sImp[2] - ($sSue[2] + $sGto[2]));
				$B = $dIva[2];
				$D = $dIva[2] - $arrayEfectivo['IGT-19']["mes"];
				
				$s2 = $A + ($B - $D);
				echo number_format($s2, 0, ',', '.');
			?>
		</th>
		<th width="15%">
			<?php
				echo number_format($s1+$s2, 0, ',', '.');
			?>
		</th>
		<th width="15%">
			<?php
				$s5 = ($sImp[5] - ($sSue[5] + $sGto[5]));
				$A = ($sImp[5] - ($sSue[5] + $sGto[5]));
				$B = $dIva[5];
				$D = $dIva[5] - $arrayEfectivo['IGT-1118']["agno"];
				
				$s5 = $A + ($B - $D);
				echo number_format($s5, 0, ',', '.');
			?>
		</th>
		<th width="15%">
			<?php
				$A = ($sImp[6] - ($sSue[6] + $sGto[6]));
				$B = $dIva[6];
				$D = $dIva[6] - $arrayEfectivo['IGT-19']["agno"];
				
				$s6 = $A + ($B - $D);
				echo number_format($s6, 0, ',', '.');
			?>
		</th>
		<th width="15%">
			<?php
			$sa = $s5+$s6;
			echo number_format($sa, 0, ',', '.');
			?>
		</th>
	</tr>





	</tfoot>
	<tbody>
	<tr>
		<td width="10%" height="50">Iva Venta Fact. Mes</td>
		<td width="15%" align="right">
			<?php 
				$impMes1 = 0;
				$impMes1 = $dIva[1] - $cIva[1];
				if($impMes1 <> 0){
					echo number_format($dIva[1], 0, ',', '.');
					//echo '<br>'.number_format($ivaVtaMes18, 0, ',', '.');
					
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
				if($tImpMes <> 0){
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

	<tr>
		<td width="10%" height="50">Iva a Pagar Efectivo</td>
		<td width="15%" align="right">
			<?php
				echo number_format($dIva[1] - $arrayEfectivo['IGT-1118']["mes"], 0, ',', '.');
			?>
		</td>
		<td width="15%" align="right">
			<?php
				echo number_format($dIva[2] - $arrayEfectivo['IGT-19']["mes"], 0, ',', '.');
			?>
		</td>
		<td width="15%" align="right">
			<?php
				echo number_format(($dIva[1]+$dIva[2]) - $arrayEfectivo['totales']["mes"], 0, ',', '.');
			?>
		</td>
		<td width="15%" align="right">
			<?php
				echo number_format($dIva[5] - $arrayEfectivo['IGT-1118']["agno"], 0, ',', '.');
			?>
		</td>
		<td width="15%" align="right">
			<?php
				echo number_format($dIva[6] - $arrayEfectivo['IGT-19']["agno"], 0, ',', '.');
			?>
		</td>
		<td width="15%" align="right">
			<?php
				echo number_format(($dIva[5]+$dIva[6]) - $arrayEfectivo['totales']["agno"], 0, ',', '.');
			?>
		</td>
	</tr>
	



	</tbody>
</table>
