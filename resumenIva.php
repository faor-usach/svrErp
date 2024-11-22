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
		$Agno 	= $_GET[Agno];
	}else{
		$Periodo = $MesNum[$Mm].'.'.$fd[0];
		$Agno 	= $fd[0];
	}
				
?>
<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaTitInfos">
	<tr>
    	<td><span><strong>Tabla Resumen I.V.A. :&nbsp; </strong></span>
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
                	<td width="30%" height="20px" align="center"><strong>Impuestos Compra/Venta </strong></td>
					<?php
					$link=Conectarse();
					$bdPr=$link->query("SELECT * FROM Proyectos");
					if($rowPr=mysqli_fetch_array($bdPr)){
						do{
							echo '<td width="25%" align="center"><strong>'.$rowPr['IdProyecto'].'</strong></td>';
							$sColumnaV = array($rowPr['IdProyecto'] => 0 );
							$sColumnaC = array($rowPr['IdProyecto'] => 0 );
						}while ($rowPr=mysqli_fetch_array($bdPr));
					}
					$link->close();
					
					?>
                    <td width="20%" align="center"><strong>Total</strong></td>
               	</tr>
				<?php
				$nf 		= 0;
				$sFilaVta	= 0;
				$link=Conectarse();
				$nf++;
				echo '<tr id="barraBlanca">';
				echo '	<td align="right">I.V.A. Ventas</td>';
				$bdPr=$link->query("SELECT * FROM Proyectos");
				if($rowPr=mysqli_fetch_array($bdPr)){
					do{
						echo '<td align="right">';
								
								$tIvaVta = 0;
								$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
								if($rowGas=mysqli_fetch_array($result)){
									do{
										$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas[RutCli]."'");
										if ($rowP=mysqli_fetch_array($bdPer)){
											$cFree = $rowP[cFree];
											if($rowP[cFree] != 'on'){
												if($rowGas[Iva]>0){
													$tIvaVta += $rowGas['Iva'];
												}
											}
										}
									}while ($rowGas=mysqli_fetch_array($result));
								}
								$sFilaVta += $tIvaVta;
								$sColumnaV[$rowPr['IdProyecto']] += $tIvaVta;
								echo '<strong>'.number_format($tIvaVta, 0, ',', '.').'</strong>'; 
/*
								$result  = $link->query("SELECT SUM(Iva) as tIvaVta FROM SolFactura WHERE month(fechaSolicitud) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
								$rowGas	 = mysqli_fetch_array($result);
								if($rowGas['tIvaVta']>0){
									$sFilaVta += $rowGas['tIvaVta'];
									$sColumnaV[$rowPr['IdProyecto']] += $rowGas['tIvaVta'];
									echo '<strong>'.number_format($rowGas['tIvaVta'], 0, ',', '.').'</strong>'; 
								}
*/								
						echo '</td>';
					}while ($rowPr=mysqli_fetch_array($bdPr));
				}
				echo '	<td align="right">';
						if($sFilaVta>0){
							echo '<strong>'.number_format($sFilaVta, 0, ',', '.').'</strong>';
						}
				echo '	</td>';
				echo '</tr>';

				$sFilaCompra	= 0;
				echo '<tr id="barraBlanca">';
				echo '	<td align="right">I.V.A. Compras</td>';
				$bdPr=$link->query("SELECT * FROM Proyectos");
				if($rowPr=mysqli_fetch_array($bdPr)){
					do{
						echo '<td align="right">';
								//$result  = $link->query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Modulo = 'G' &&  month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
								$result  = $link->query("SELECT SUM(Iva) as tIvaCompra FROM MovGastos WHERE Estado = 'I' && year(FechaGasto) = $Agno and month(FechaGasto) = '".$MesNum[$Mm]."' && IdProyecto = '".$rowPr['IdProyecto']."'");
								$rowGas	 = mysqli_fetch_array($result);
								if($rowGas['tIvaCompra']>0){
									$sFilaCompra += $rowGas['tIvaCompra'];
									$sColumnaC[$rowPr['IdProyecto']] += $rowGas['tIvaCompra'];
									echo '<strong>'.number_format($rowGas['tIvaCompra'], 0, ',', '.').'</strong>'; 
								}
						echo '</td>';
					}while ($rowPr=mysqli_fetch_array($bdPr));
				}
				echo '	<td align="right">';
						if($sFila>0){
							echo '<strong>'.number_format($sFilaCompra, 0, ',', '.').'</strong>';
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
		<td height="30">Total IVA</td>
		<?php
			$sProyectos = 0;
			$link=Conectarse();
			$bdPr=$link->query("SELECT * FROM Proyectos");
			if($rowPr=mysqli_fetch_array($bdPr)){
				do{
					echo '<td width="25%" align="right">';
					if($sColumna[$rowPr['IdProyecto']]>0){
						echo 	number_format(($sColumnaV[$rowPr['IdProyecto']] - $sColumnaC[$rowPr['IdProyecto']]), 0, ',', '.');
					}
					echo '</td>';
					$sProyectos += ($sColumnaV[$rowPr['IdProyecto']] - $sColumnaC[$rowPr['IdProyecto']]);
				}while ($rowPr=mysqli_fetch_array($bdPr));
			}
			$link->close();
		?>
		<td width="20%" align="right">
			<?php 
				if($sProyectos>0){
					echo 	number_format($sProyectos, 0, ',', '.'); 
				}
			?>
		</td>
	</tr>
</table>
