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
				
?>
<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaTitInfos">
	<tr>
    	<td><span><strong>Resumen Facturas:&nbsp; </strong></span>
			<select name="Mes" onChange="window.location = this.options[this.selectedIndex].value; return true;">
				<?php
				for($i=1; $i <=12 ; $i++){
					if($Mes[$i]==$Mm){
						echo '<option selected value="resumenRescate.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
					}else{
						if($i > $fd[1]){
							echo '<option style="opacity:.5; color:#ccc;" value="resumenRescata.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
						}else{
							echo '<option value="resumenRescate.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
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
            	<tr height="30" style="font-size:16px; font-family:Georgia, "Times New Roman", Times, serif; float:right;">
                	<td width="30%" height="20px" align="center"><strong>Items de Facturas </strong></td>
					<?php
					$link=Conectarse();
					$bdPr=$link->query("SELECT * FROM Proyectos");
					if($rowPr=mysqli_fetch_array($bdPr)){
						do{
							echo '<td width="25%" align="center"><strong>'.$rowPr['IdProyecto'].'</strong></td>';
							$sColumna = array($rowPr['IdProyecto'] => 0 );
						}while ($rowPr=mysqli_fetch_array($bdPr));
					}
					$link->close();
					
					?>
                    <td width="20%" align="center"><strong>Total</strong></td>
               	</tr>
				<?php
				$nf 		= 0;
				$sFila 		= 0;
				$link=Conectarse();
				$nf++;
				echo '<tr id="barraBlanca" style="font-size:16px; font-family:Georgia, "Times New Roman", Times, serif; float:right;">';
				echo '	<td align="right">Solicitudes</td>';
				$bdPr=$link->query("SELECT * FROM Proyectos");
				if($rowPr=mysqli_fetch_array($bdPr)){
					do{
						//echo '<td align="right" style="padding:0 50px;">';
						echo '<td align="right">';

								$tBruto = 0;
								$result  = $link->query("SELECT * FROM SolFactura WHERE month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
								if($rowGas=mysqli_fetch_array($result)){
									do{
										$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
										if ($rowP=mysqli_fetch_array($bdPer)){
											$cFree = $rowP[cFree];
											if($rowP[cFree] != 'on'){
												if($rowGas[Neto]>0){
													$tBruto += $rowGas[Neto];
													//$tBruto += $rowGas[Bruto];
												}
											}
										}
									}while ($rowGas=mysqli_fetch_array($result));
								}
								$sFila += $tBruto;
								$sColumna[$rowPr['IdProyecto']] += $tBruto;
								echo '<strong>'.number_format($tBruto, 0, ',', '.').'</strong>'; 

/*
								$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM SolFactura WHERE Estado = 'I' && month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
								$rowGas	 = mysqli_fetch_array($result);
								if($rowGas['tBruto']>0){
									$sFila += $rowGas['tBruto'];
									$sColumna[$rowPr['IdProyecto']] += $rowGas['tBruto'];
									echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
								}
*/
						echo '</td>';
					}while ($rowPr=mysqli_fetch_array($bdPr));
				}
				//echo '	<td align="right" style="padding:0 50px;">';
				echo '	<td align="right">';
						if($sFila>0){
							echo '<strong>'.number_format($sFila, 0, ',', '.').'</strong>';
						}
				echo '	</td>';
				echo '</tr>';

				$sFila = 0;
				echo '<tr id="barraBlanca" style="font-size:16px; font-family:Georgia, "Times New Roman", Times, serif; float:right;">';
				echo '	<td align="right">0,775</td>';
				$bdPr=$link->query("SELECT * FROM Proyectos");
				if($rowPr=mysqli_fetch_array($bdPr)){
					do{
						//echo '<td align="right" style="padding:0 50px;">';
						echo '<td align="right">';
								if($sColumna[$rowPr['IdProyecto']]>0){
									$Impuesto = $sColumna[$rowPr['IdProyecto']] * 0.775;
									$sFila += $Impuesto;
									echo '<strong>'.number_format($Impuesto, 0, ',', '.').'</strong>'; 
								}
						echo '</td>';
					}while ($rowPr=mysqli_fetch_array($bdPr));
				}
				//echo '	<td align="right" style="padding:0 50px;">';
				echo '	<td align="right">';
						if($sFila>0){
							echo '<strong>'.number_format($sFila, 0, ',', '.').'</strong>';
						}
				echo '	</td>';
				echo '</tr>';

				$link->close();
				?>
        	</table>
		</td>
  	</tr>
</table>

<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
	<tr>
		<td width="30%" height="30">Ingresos </td>
		<?php
			$sProyectos = 0;
			$link=Conectarse();
			$bdPr=$link->query("SELECT * FROM Proyectos");
			if($rowPr=mysqli_fetch_array($bdPr)){
				do{
					//echo '<td width="25%" align="right" style="padding:0 50px;">';
					echo '<td width="25%" align="right">';
					if($sColumna[$rowPr['IdProyecto']]>0){
						$Impuesto = $sColumna[$rowPr['IdProyecto']] * 0.775;
						$sProyectos += $Impuesto;
						echo '<strong>'.number_format($Impuesto, 0, ',', '.').'</strong>'; 
					}
					echo '</td>';
				}while ($rowPr=mysqli_fetch_array($bdPr));
			}
			$link->close();
		?>
		<td width="20%" align="right" style="padding:0 30px;">
			<?php 
				if($sProyectos>0){
					echo 	number_format($sProyectos, 0, ',', '.'); 
				}
			?>
		</td>
	</tr>
</table>
