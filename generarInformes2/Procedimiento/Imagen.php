<style>
#idProcedimiento {
	margin-top:5px;
	background-color:#FFFFFF;
	border:1px solid #ccc;
	font-size:12px;
}
#idProcedimiento td{
	padding:5px;
}
</style>
<?php
	$Cliente = '';
	$link=Conectarse();
	$bdCl=mysql_query("Select * From Clientes Where RutCli = '".$RutCli."'");
	if($rowCl=mysql_fetch_array($bdCl)){
		$Cliente = $rowCl['Cliente'];
	}
	
	$procesoSold 	= '';
	$Norma			= '';
	$bdPs=mysql_query("Select * From solprocsoldadura Where CodInforme = '".$CodInforme."'");
	if($rowPs=mysql_fetch_array($bdPs)){
		$procesoSold = $rowPs['procesoSold'];
		$nNorma 	 = $rowPs['nNorma'];
		$Tipo 	 	 = $rowPs['Tipo'];
	}
	
	$TipoUnion 		= '';
	$Soldadura		= '';
	$Respaldo		= '';
	$matRespaldo	= '';
	$aberturaRaiz	= '';
	$Talon			= '';
	$anguloCanal	= '';
	$Radio			= '';
	$intRaiz		= '';
	$Metodo			= '';
	
	$bdSun=mysql_query("Select * From solUnionUsado Where CodInforme = '".$CodInforme."'");
	if($rowSun=mysql_fetch_array($bdSun)){
		$TipoUnion 		= $rowSun['Tipo'];
		$Soldadura 		= $rowSun['Soldadura'];
		$Respaldo 		= $rowSun['Respaldo'];
		$matRespaldo 	= $rowSun['matRespaldo'];
		$aberturaRaiz 	= $rowSun['aberturaRaiz'];
		$Talon 			= $rowSun['Talon'];
		$anguloCanal	= $rowSun['anguloCanal'];
		$Radio			= $rowSun['Radio'];
		$intRaiz		= $rowSun['intRaiz'];
		$Metodo			= $rowSun['Metodo'];
	}

	$bdSmb=mysql_query("Select * From solMetalBase Where CodInforme = '".$CodInforme."'");
	if($rowSmb=mysql_fetch_array($bdSmb)){
		$especMaterialDe	= $rowSmb['especMaterialDe'];
		$especMaterialA		= $rowSmb['especMaterialA'];
		$tpGradoDe			= $rowSmb['tpGradoDe'];
		$tpGradoA			= $rowSmb['tpGradoA'];
		$espesorCanal		= $rowSmb['espesorCanal'];
		$espesorFilete		= $rowSmb['espesorFilete'];
		$diametroCaneria	= $rowSmb['diametroCaneria'];
		$grupoDe			= $rowSmb['grupoDe'];
		$grupoA				= $rowSmb['grupoA'];
		$numeroPde			= $rowSmb['numeroPde'];
		$numeroPa			= $rowSmb['numeroPa'];
	}

	$bdSma=mysql_query("Select * From solMetalAporte Where CodInforme = '".$CodInforme."'");
	if($rowSma=mysql_fetch_array($bdSma)){
		$especAWSde			= $rowSma['especAWSde'];
		$especAWSa			= $rowSma['especAWSa'];
		$clasAWSde			= $rowSma['clasAWSde'];
		$clasAWSa			= $rowSma['clasAWSa'];
		$diametroElecDe		= $rowSma['diametroElecDe'];
		$diametroElecA		= $rowSma['diametroElecA'];
	}
	
	$bdSpr=mysql_query("Select * From solProteccion Where CodInforme = '".$CodInforme."'");
	if($rowSpr=mysql_fetch_array($bdSpr)){
		$fundente			= $rowSpr['fundente'];
		$gasClasificacion	= $rowSpr['gasClasificacion'];
		$composicion		= $rowSpr['composicion'];
		$flujo				= $rowSpr['flujo'];
		$tamTobera			= $rowSpr['tamTobera'];
		$claseFundenteElec	= $rowSpr['claseFundenteElec'];
	}
	
	$bdSpc=mysql_query("Select * From solPreCalentamiento Where CodInforme = '".$CodInforme."'");
	if($rowSpc=mysql_fetch_array($bdSpc)){
		$preCalMin	= $rowSpc['preCalMin'];
		$interMin	= $rowSpc['interMin'];
		$interMax	= $rowSpc['interMax'];
	}
	
	$bdSpo=mysql_query("Select * From solPosicion Where CodInforme = '".$CodInforme."'");
	if($rowSpo=mysql_fetch_array($bdSpo)){
		$Canal				= $rowSpo['Canal'];
		$Filete				= $rowSpo['Filete'];
		$progresionVertical	= $rowSpo['progresionVertical'];
	}

	$bdSce=mysql_query("Select * From solCarElec Where CodInforme = '".$CodInforme."'");
	if($rowSce=mysql_fetch_array($bdSce)){
		$cortoCircuito	= $rowSce['cortoCircuito'];
		$Globular		= $rowSce['Globular'];
		$Spray			= $rowSce['Spray'];
		$CA				= $rowSce['CA'];
		$CCEP			= $rowSce['CCEP'];
		$CCEN			= $rowSce['CCEN'];
		$Otro			= $rowSce['Otro'];
		$elecTunTam		= $rowSce['elecTunTam'];
		$elecTunTipo	= $rowSce['elecTunTipo'];
	}

	// +++	
	$bdSte=mysql_query("Select * From solTecnica Where CodInforme = '".$CodInforme."'");
	if($rowSte=mysql_fetch_array($bdSte)){
		$Cordon			= $rowSte['Cordon'];
		$Pase			= $rowSte['Pase'];
		$nElectrodos	= $rowSte['nElectrodos'];
		$Longitudinal	= $rowSte['Longitudinal'];
		$Lateral		= $rowSte['Lateral'];
		$Angulo			= $rowSte['Angulo'];
		$Distancia		= $rowSte['Distancia'];
		$Martillado		= $rowSte['Martillado'];
		$Limpieza		= $rowSte['Limpieza'];
	}
	
	$bdStt=mysql_query("Select * From solTermico Where CodInforme = '".$CodInforme."'");
	if($rowStt=mysql_fetch_array($bdStt)){
		$Temperatura	= $rowStt['Temperatura'];
		$Tiempo			= $rowStt['Tiempo'];
	}
	$fdProc = explode('-', $CodInforme);
	mysql_close($link);
?>
<input name="CodInforme" 			type="hidden" value="<?php echo $CodInforme; ?>">
<input name="RutCli" 				type="hidden" value="<?php echo $RutCli; ?>">
<input name="accion" 				type="hidden" value="<?php echo $accion; ?>">
<input name="RAM" 					type="hidden" value="<?php echo $RAM; ?>">

<input name="CodigoVerificacion" 	type="hidden" value="<?php echo $CodigoVerificacion; ?>">

	<table cellpadding="0" cellspacing="0" border="0" id="idProcedimiento" align="center" width="100%">
		<tr>
			<td width="10%"><b>Cliente:</b> </td>
			<td colspan="3" width="60%"><?php echo $Cliente; ?></td>
			<td width="15%"><b>Fecha de Creación:</b></td>
			<td colspan="2" width="15%"><input name="fechaCreacion" type="date" value="<?php echo $fechaCreacion; ?>"></td>
		</tr>
		<tr>
			<td>Identificación <b><?php echo $fdProc[0]; ?></b>: </td>
			<td colspan="3"><?php echo $CodInforme; ?></td>
			<td>Fecha de Emisión: </td>
			<td colspan="2"><input name="fechaEmision" type="date" value="<?php echo $fechaEmision; ?>"></td>
		</tr>
		<?php
			if($fdProc[0] == 'WPS'){?>
				<tr>
					<td>Respaldo PQR : </td>
					<td colspan="6">
						<input name="RespaldoId" type="text" list="listaPQR" value="<?php echo $RespaldoId; ?>">
						<datalist id="listaPQR">
							<?php
							$link=Conectarse();
							$bdPr=mysql_query("SELECT * FROM solidsoldadura Where CodInforme Like '%PQR%' and RutCli = '".$RutCli."'");
							if($rowPr=mysql_fetch_array($bdPr)){
								do{?>
									<option value="<?php echo $rowPr['CodInforme']; ?>">
								<?php
								}while ($rowPr=mysql_fetch_array($bdPr));
							}
							mysql_close($link);
							?>
						</datalist>
					</td>
				</tr>
				<?php
			}
		?>
		<tr>
			<td>Por : </td>
			<td width="20%">
				<?php 
					$link=Conectarse();
					$bdUs=mysql_query("Select * From usuarios Where usr = '".$usrResponsable."'");
					if($rowUs=mysql_fetch_array($bdUs)){
						echo $rowUs['usuario']; 
					}
					mysql_close($link);
				?>
		  </td>
			<td width="10%">Autorizado: </td>
			<td colspan="2" width="20%">
				<select name="usrAutorizador">
					<option></option>
					<?php 
						$link=Conectarse();
						$bdUs=mysql_query("Select * From usuarios Where apruebaOfertas = 'on'");
						if($rowUs=mysql_fetch_array($bdUs)){
							do{
								if($rowUs['usr'] == $usrAutorizador){?>
									<option selected 	value="<?php echo $rowUs['usr']; ?>"><?php echo $rowUs['usuario']; ?></option>
								<?php }else{ ?>
									<option 			value="<?php echo $rowUs['usr']; ?>"><?php echo $rowUs['usuario']; ?></option>
									<?php
								}
							}while ($rowUs=mysql_fetch_array($bdUs));
						}
						mysql_close($link);
					?>
				</select>
			</td>
			<td>Rev.</td>
		    <td>
				<input name="Rev" type="text" size="2" maxlength="2" value="<?php echo $Rev; ?>">
			</td>
		</tr>
	</table>


	<?php
		$Manual = '';
		if(isset($_POST['Manual'])){ $Manual = $_POST['Manual']; }
	?>
	<style>
		#registroSoldaduraTit {
			font-weight:800;
			background-color:#F9FABE;
			height:30px;
			padding-left:10px;
			border:1px solid #ccc;
			margin-top:5px;
		}
		#tabProcedimiento {
			width:97%;
			margin:5px;
			border:1px solid #ccc;
			font-size:12px;
		}
		#tabProcedimiento input{
			text-align:center;
		}
		#tabProcedimiento .tabTitulo {
			font-weight:800;
			background-color:#F9FABE;
			height:30px;
			padding-left:10px;
			text-align:center;
		}
		#tabProcedimiento .tabTitulo td {
			height:30px;
			padding-left:10px;
		}
		#tabProcedimiento td {
			height:30px;
			padding-left:10px;
			text-align:center;
		}
		
	</style>

	<div id="registroSoldaduraTit">
		DETALES DE LA UNIÓN
	</div>
	<table width="100%" border="1" cellpadding="0" cellspacing="0" id="tabProcedimiento">
		<tr>
			<td style="padding:50px;">
				<?php
					$link=Conectarse();
					$bdImg=mysql_query("Select * From solImagenUnion Where CodInforme = '".$CodInforme."'");
					if($rowImg=mysql_fetch_array($bdImg)){
						$fichero = "imgUniones/".$CodInforme."/".$rowImg['imagenUnion'];
						?>
						<img src="<?php echo $fichero; ?>">
						<?php
						//echo $fichero;
					}
					mysql_close($link);
				?>
				<hr>
				<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
				<input name="fotoMuestra" type="file" id="fotoMuestra">
			</td>
		</tr>
		<tr>
			<td>
				<div style="padding:5px; float:right;">
					<button name="UpImagen">
						<img src="../../imagenes/upload2.png" width="50">
					</button>
				</div>
			</td>
		</tr>
	</table>
