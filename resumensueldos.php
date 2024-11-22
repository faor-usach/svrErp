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
	if(isset($_GET['Agno'])) { 
		$Periodo = $MesNum[$Mm].'.'.$_GET[Agno];
	}else{
		$Periodo = $MesNum[$Mm].'.'.$fd[0];
	}
	$TotalMesP1 = 0;
	$TotalMesP2 = 0;
				
?>
<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaTitInfos">
	<tr>
    	<td><span><strong>Tabla Resumen Sueldos: &nbsp; </strong></span>
			<select name="Mes" onChange="window.location = this.options[this.selectedIndex].value; return true;">
				<?php
				for($i=1; $i <=12 ; $i++){
					if($Mes[$i]==$Mm){
						echo '<option selected value="plataformaErp.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
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
		</td>
  	</tr>
</table>
<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaCpoInfos">
	<tr>
    	<td>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
            	<tr height="30">
                	<td width="30%" height="20px" align="center"><strong>Detalle Sueldos </strong></td>
                    <td width="25%" align="center"><strong>IGT-1118</strong></td>
                    <td width="25%" align="center"><strong>IGT-19</strong></td>
                    <td width="20%" align="center"><strong>Total</strong></td>
               	</tr>
                <tr id="barraBlanca">
                	<td><strong>Sueldos :</strong></td>
                    <td align="right">
						<?php
							$link=Conectarse();
							//$result  = $link->query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago = '".$Periodo."' && Estado = 'P' && IdProyecto = 'IGT-1118'");
							$result  = $link->query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago = '".$Periodo."' && Estado = 'P' && IdProyecto = 'IGT-1118'");
							$row 	 = mysqli_fetch_array($result);
							if($row['tLiquido']>0){
								echo '<strong>'.number_format($row['tLiquido'], 0, ',', '.').'</strong>'; 
								$TotalMesP1 += $row['tLiquido'];
							}
							$link->close();
						?>
					</td>
                    <td align="right">
						<?php
							$link=Conectarse();
							$result  = $link->query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago = '".$Periodo."' && Estado = 'P' && IdProyecto = 'IGT-19'");
							$row 	 = mysqli_fetch_array($result);
							if($row['tLiquido']>0){
								echo '<strong>'.number_format($row['tLiquido'], 0, ',', '.').'</strong>'; 
								$TotalMesP2 += $row['tLiquido'];
							}
							$link->close();
						?>

					</td>
					<td align="right">
						<?php
							$link=Conectarse();
							$result  = $link->query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago = '".$Periodo."' && Estado = 'P' ");
							$row 	 = mysqli_fetch_array($result);
							if($row['tLiquido']>0){
								echo '<strong>'.number_format($row['tLiquido'], 0, ',', '.').'</strong>'; 
							}
							$link->close();
						?>
					</td>
             	</tr>
                <tr id="barraBlanca">
                	<td colspan="4"><strong>Honorarios </strong></td>
               	</tr>
                <tr id="barraBlanca">
                	<td align="right">Mensuales : </td>
                    <td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE TpCosto = 'M' && nInforme > 0  && IdProyecto = 'IGT-1118'");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'M' and IdProyecto = 'IGT-1118'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP1 += $tTotal;
							}
						?>
					</td>
                    <td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE TpCosto = 'M' && nInforme > 0  && IdProyecto = 'IGT-19'");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'M' and IdProyecto = 'IGT-19'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP2 += $tTotal;
							}
						?>
					</td>
					<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE TpCosto = 'M' && nInforme > 0");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'M'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
							}
							
						?>
					</td>
              	</tr>
                <tr id="barraBlanca">
               		<td align="right">Esporadicos : </td>
                  	<td align="right">
					<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE (TpCosto = 'E' || TpCosto = 'I') && nInforme > 0  && IdProyecto = 'IGT-1118'");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and (TpCosto = 'E' || TpCosto = 'I') and IdProyecto = 'IGT-1118'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$Periodo.'</strong>';
								$TotalMesP1 += $tTotal;
							}
						?>
					</td>
                  	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE (TpCosto = 'E' || TpCosto = 'I') && nInforme > 0  && IdProyecto = 'IGT-19'");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and (TpCosto = 'E' || TpCosto = 'I') and IdProyecto = 'IGT-19'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP2 += $tTotal;
							}
						?>
					</td>
					<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE (TpCosto = 'E' || TpCosto = 'I') && nInforme > 0");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and (TpCosto = 'E' || TpCosto = 'I')");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
							}
						?>
					</td>
              	</tr>
                <tr id="barraBlanca">
             		<td align="right">Inversi&oacute;n :</td>
                  	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE TpCosto = 'I' && nInforme > 0 && IdProyecto = 'IGT-1118'");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'I' and IdProyecto = 'IGT-1118'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
							}
						?>
					</td>
                  	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE TpCosto = 'I' && nInforme > 0 && IdProyecto = 'IGT-19'");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'I' and IdProyecto = 'IGT-19'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								//$TotalMes += $tTotal;
							}
						?>
					</td>
					<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE TpCosto = 'I' && nInforme > 0");
							$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'I'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
							}
						?>
					</td>
              	</tr>
                <tr id="barraBlanca">
             		<td><strong>Facturas</strong></td>
              		<td align="right">&nbsp;</td>
              		<td align="right">&nbsp;
					</td>
              	</tr>
                <tr id="barraBlanca">
               		<td align="right">Mensuales: </td>
                  	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'M' && Estado = 'P' && IdProyecto = 'IGT-1118'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP1 += $tTotal;
							}
						?>
					</td>
                  	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'M' && Estado = 'P' && IdProyecto = 'IGT-19'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP2 += $tTotal;
							}
						?>
					</td>
					<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'M' && Estado = 'P'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}while ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
							}
						?></td>
               	</tr>
                <tr id="barraBlanca">
              		<td align="right">Esporadicos : </td>
                   	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'E' && Estado = 'P' && IdProyecto = 'IGT-1118'");
							if ($row=mysqli_fetch_array($result)){
								do{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row[PeriodoPago]){
										$tTotal += $row[Bruto];
									}
								}while($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP1 += $tTotal;
							}
						?></td>
                   	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'E' && Estado = 'P' && IdProyecto = 'IGT-19'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP2 += $tTotal;
							}
						?>
					</td>
					<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'E' && Estado = 'P'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
							}
						?></td>
             	</tr>
                <tr id="barraBlanca">
              		<td align="right">Inversi&oacute;n : </td>
                  	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'I' && Estado = 'P' && IdProyecto = 'IGT-1118'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP1 += $tTotal;
							}
						?>
					</td>
                  	<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = $link->query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'I' && Estado = 'P' && IdProyecto = 'IGT-19'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMesP2 += $tTotal;
							}
						?>
					</td>
					<td align="right">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							$result  = $link->query("SELECT * FROM Facturas WHERE PeriodoPago = '".$Periodo."' and TpCosto = 'I' && Estado = 'P'");
							if ($row=mysqli_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysqli_fetch_array($result));
							}
							$link->close();
							if($tTotal>0){
								echo '<strong>'.number_format($tTotal, 0, ',', '.').'</strong>';
							}
						?>
					</td>
              	</tr>
        	</table>
		</td>
  	</tr>
</table>
<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
	<tr>
		<td width="30%" height="50">Total Sueldos</td>
		<td width="25%" align="right">
			<?php
				if($TotalMesP1 > 0){
					echo '<strong>'.number_format($TotalMesP1, 0, ',', '.').'</strong>'; 
				}
			?>
		</td>
	    <td width="25%" align="right">
			<?php
				if($TotalMesP2 > 0){
					echo '<strong>'.number_format($TotalMesP2, 0, ',', '.').'</strong>'; 
				}
			?>
		</td>
		<td width="20%" align="right">
			<?php
				if(($TotalMesP1 + $TotalMesP2) > 0){
					echo '<strong>'.number_format(($TotalMesP1 + $TotalMesP2), 0, ',', '.').'</strong>'; 
				}
			?></td>
	</tr>
</table>
