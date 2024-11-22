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

	if(isset($_GET[Agno])){
		$Agno 		= $_GET[Agno];
		$Periodo 	= $MesNum[$Mm].'.'.$Agno;
	}	
	$link=Conectarse();
	$bdInf=$link->query("SELECT * FROM Informes Order By AgnoInforme Asc");
	if($rowInf=mysqli_fetch_array($bdInf)){
		$prAgno = $rowInf[AgnoInforme];
	}
	$link->close();
	
				
?>
<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaTitInfos">
	<tr>
    	<td><span><strong>Tabla Resumen Gastos:&nbsp; </strong></span> 
			<select name="Mm" onChange="window.location = this.options[this.selectedIndex].value; return true;">
				<?php
				for($i=1; $i <=12 ; $i++){
					if($Mes[$i]==$Mm){
						echo '<option selected value="plataformaErp.php?Mm='.$Mes[$i].'&Agno='.$Agno.'">'.$Mes[$i].'</option>';
					}else{
						if($i > $fd[1]){
							echo '<option style="opacity:.5; color:#ccc;" value="plataformaErp.php?Mm='.$Mes[$i].'&Agno='.$Agno.'">'.$Mes[$i].'</option>';
						}else{
							echo '<option value="plataformaErp.php?Mm='.$Mes[$i].'&Agno='.$Agno.'">'.$Mes[$i].'</option>';
						}
					}
				}
				?>
			</select>
			<select name="Agno" onChange="window.location = this.options[this.selectedIndex].value; return true;">
				<?php
					$AgnoAct = date('Y');
					for($a=$prAgno; $a<=$AgnoAct; $a++){
						if($a == $Agno){
							echo '<option selected 	value="plataformaErp.php?Mm='.$Mm.'&Agno='.$a.'">'.$a.'</option>';
						}else{
							echo '<option  			value="plataformaErp.php?Mm='.$Mm.'&Agno='.$a.'">'.$a.'</option>';
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
                	<td width="30%" height="20px"><strong>Items de Gastos </strong></td>
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
                    <td width="20%" align="center"><strong>Total Gastos</strong></td>
               	</tr>
				<?php
				$nf 		= 0;
				$sFila 		= 0;
				$link=Conectarse();
				$bdIt=$link->query("SELECT * FROM ItemsGastos Order By nItem");
				if($rowIt=mysqli_fetch_array($bdIt)){
					do{
						$nf++;
						$sFila = 0;
						echo '<tr id="barraBlanca">';
						echo '	<td align="right">'.$rowIt['Items'].'</td>';
						$bdPr=$link->query("SELECT * FROM Proyectos");
						if($rowPr=mysqli_fetch_array($bdPr)){
							do{
								//echo '<td align="right" style="padding:0 50px;">';
								echo '<td align="right">';
										$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' &&  month(FechaGasto) = '".$MesNum[$Mm]."' && year(FechaGasto) = '".$Agno."' && nItem = '".$rowIt['nItem']."' && IdProyecto = '".$rowPr['IdProyecto']."'");
										//$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Estado = 'I' && month(FechaGasto) = '".$MesNum[$Mm]."' && nItem = '".$rowIt['nItem']."' && IdProyecto = '".$rowPr['IdProyecto']."' && IdGasto <> 2");
										$rowGas	 = mysqli_fetch_array($result);
										if($rowGas['tBruto']>0){
											$sFila += $rowGas['tBruto'];
											$sColumna[$rowPr['IdProyecto']] += $rowGas['tBruto'];
											echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
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
					}while ($rowIt=mysqli_fetch_array($bdIt));
				}
				$link->close();
				echo '<tr id="barraBlanca" style="font-size:16px; font-family:Georgia, "Times New Roman", Times, serif; float:right;">';
				echo '	<td align="right"> Inversión </td>';
							$nf++;
							$sFila = 0;
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							if($rowPr=mysqli_fetch_array($bdPr)){
								do{
									//echo '<td align="right" style="padding:0 50px;">';
									echo '<td align="right">';
											//$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Estado = 'I' && month(FechaGasto) = '".$MesNum[$Mm]."' && nItem = '".$rowIt['nItem']."' && IdProyecto = '".$rowPr['IdProyecto']."'");
											$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE Estado = 'I' && month(FechaGasto) = '".$MesNum[$Mm]."' && year(FechaGasto) = '".$Agno."' && IdGasto = '2' && IdProyecto = '".$rowPr['IdProyecto']."'");
											$rowGas	 = mysqli_fetch_array($result);
											if($rowGas['tBruto']>0){
												$sFila += $rowGas['tBruto'];
												echo '<strong>'.number_format($rowGas['tBruto'], 0, ',', '.').'</strong>'; 
											}
									echo '	</td>';
								}while ($rowPr=mysqli_fetch_array($bdPr));
							}
							$link->close();
						//echo '	<td align="right" style="padding:0 50px;">';
						echo '	<td align="right">';
								if($sFila>0){
									echo '<strong>'.number_format($sFila, 0, ',', '.').'</strong>';
								}
						echo '	</td>';
				echo '</tr>';
				?>
        	</table>
		</td>
  	</tr>
</table>
<table width="500"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
	<tr>
		<td width="30%" height="50">Total Gastos</td>
		<?php
			$sProyectos = 0;
			$link=Conectarse();
			$bdPr=$link->query("SELECT * FROM Proyectos");
			if($rowPr=mysqli_fetch_array($bdPr)){
				do{
					//echo '<td width="25%" align="right" style="padding:0 50px;">';
					echo '<td width="25%" align="right">';
					if($sColumna[$rowPr['IdProyecto']]>0){
						echo 	number_format($sColumna[$rowPr['IdProyecto']], 0, ',', '.');
					}
					echo '</td>';
					$sProyectos += $sColumna[$rowPr['IdProyecto']];
				}while ($rowPr=mysqli_fetch_array($bdPr));
			}
			$link->close();
		?>
		<td width="20%" align="right" style="padding:0 50px;">
			<?php 
				if($sProyectos>0){
					echo 	number_format($sProyectos, 0, ',', '.'); 
				}
			?>
		</td>
	</tr>
</table>
