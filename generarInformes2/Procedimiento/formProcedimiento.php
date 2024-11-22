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
	
	$idEspecimen	= '';
	$idEspecimenDoblado = '';
	
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
	$bdSptr=mysql_query("Select * From solregproctr Where CodInforme = '".$CodInforme."' and idEspecimen = '".$idEspecimen."'");
	if($rowSptr=mysql_fetch_array($bdSptr)){
		$Ancho		= $rowSptr['Ancho'];
		$Espesor	= $rowSptr['Espesor'];
		$cMax		= $rowSptr['cMax'];
		$MPa		= $rowSptr['MPa'];
		$PSI		= $rowSptr['PSI'];
		$ubiCarFrac	= $rowSptr['ubiCarFrac'];
	}
	$bdSpdo=mysql_query("Select * From solregprocdo Where CodInforme = '".$CodInforme."' and idEspecimen = '".$idEspecimenDoblado."'");
	if($rowSpdo=mysql_fetch_array($bdSpdo)){
		$Tipo				= $rowSpdo['Tipo'];
		$ObservacionesDo	= $rowSpdo['Observaciones'];
		$Condicion			= $rowSpdo['Condicion'];
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

	<table cellpadding="0" cellspacing="0" border="0" id="idProcedimiento" align="center" width="100%">
		<tr>
			<td width="15%">Proceso de Soldadura: </td>
			<td width="85%"><input name="procesoSold" size="100" maxlength="100" value="<?php echo $procesoSold; ?>"></td>
		</tr>
		<tr>
			<td width="15%">Tipo : </td>
			<td width="85%">
				<div style="border:1px simple #ccc; padding:5px;">
					Manual : 
						<?php
							if($Tipo == 'Manu'){?>
								<input name="Tipo" type="radio" value="Manu" checked>
								<?php
							}else{
								?>
								<input name="Tipo" type="radio" value="Manu">
								<?php
							}
						?>
					Máquina : 
						<?php
							if($Tipo == 'Maqu'){?>
								<input name="Tipo" type="radio" value="Maqu" checked>
								<?php
							}else{
								?>
								<input name="Tipo" type="radio" value="Maqu">
								<?php
							}
						?>
					Semi - Automática : 
						<?php
							if($Tipo == 'Semi'){?>
								<input name="Tipo" type="radio" value="Semi" checked>
								<?php
							}else{
								?>
								<input name="Tipo" type="radio" value="Semi">
								<?php
							}
						?>
					Automática : 
						<?php
							if($Tipo == 'Auto'){?>
								<input name="Tipo" type="radio" value="Auto" checked>
								<?php
							}else{
								?>
								<input name="Tipo" type="radio" value="Auto">
								<?php
							}
						?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="15%">Norma : </td>
			<td width="85%">
				<select name="nNorma">
					<option></option>
					<?php 
						$link=Conectarse();
						$bdUs=mysql_query("Select * From normas");
						if($rowUs=mysql_fetch_array($bdUs)){
							do{
								if($rowUs['nNorma'] == $nNorma){?>
									<option selected 	value="<?php echo $rowUs['nNorma']; ?>"><?php echo $rowUs['Norma'].' : '.$rowUs['Agno'].' '.$rowUs['Descripcion']; ?></option>
								<?php }else{ ?>
									<option 			value="<?php echo $rowUs['nNorma']; ?>"><?php echo $rowUs['Norma'].' : '.$rowUs['Agno'].' '.$rowUs['Descripcion']; ?></option>
									<?php
								}
							}while ($rowUs=mysql_fetch_array($bdUs));
						}
						mysql_close($link);
					?>
				</select>
			</td>
		</tr>
	</table>
	<style>
		#cuadroIzq {
			width:50%;
			float:left;
		}
		#cuadroDer {
			width:50%;
			float:right;
		}
		#tabProceso {
			width:97%;
			margin:5px;
			border:1px solid #ccc;
			font-size:12px;
		}
		#tabProceso input{
			text-align:center;
		}
		#tabProceso .tabTitulo {
			font-weight:800;
			background-color:#F9FABE;
			height:30px;
			padding-left:10px;
		}
		#tabProceso .tabTitulo td {
			height:30px;
			padding-left:10px;
		}
		#tabProceso td {
			height:30px;
			padding-left:10px;
		}
	</style>
	<div id="cuadroIzq">
		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="4">Diseño de unión usado</td>
			</tr>
			<tr>
				<td width="23%">Tipo: </td>
				<td colspan="3">
					<input name="TipoUnion" size="50" maxlength="50" value="<?php echo $TipoUnion; ?>">
				</td>
			</tr>
			<tr>
				<td width="23%">Soldadura: </td>
				<td colspan="3">
					<div style="border:1px simple #ccc; padding:5px;">
						Simple: 
							<?php
								if($Soldadura == 'S'){?>
									<input name="Soldadura" type="radio" value="S" checked>
									<?php
								}else{
									?>
									<input name="Soldadura" type="radio" value="S">
									<?php
								}
							?>
						Doble : 
							<?php
								if($Soldadura == 'D'){?>
									<input name="Soldadura" type="radio" value="D" checked>
									<?php
								}else{
									?>
									<input name="Soldadura" type="radio" value="D">
									<?php
								}
							?>
					</div>
				</td>
			</tr>
			<tr>
				<td width="23%">Respaldo: </td>
				<td colspan="3">
					<div style="border:1px simple #ccc; padding:5px;">
						Si
							<?php
								if($Respaldo == 'S'){?>
									<input name="Respaldo" type="radio" value="S" checked>
									<?php
								}else{
									?>
									<input name="Respaldo" type="radio" value="S">
									<?php
								}
							?>
						No
							<?php
								if($Respaldo == 'N'){?>
									<input name="Respaldo" type="radio" value="N" checked>
									<?php
								}else{
									?>
									<input name="Respaldo" type="radio" value="N">
									<?php
								}
							?>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">Material de Respaldo: </td>
				<td colspan="2">
					<input name="matRespaldo" type="text" size="15" maxlength="15" value="<?php echo $matRespaldo; ?>">
				</td>
			</tr>
			<tr>
				<td>Abertura de ra&iacute;z: </td>
				<td width="27%"><input name="matRespaldo" type="text" size="15" maxlength="15" value="<?php echo $matRespaldo; ?>"></td>
				<td width="18%">Tal&oacute;n</td>
			    <td width="32%"><input name="Talon" type="text" size="15" maxlength="15" value="<?php echo $Talon; ?>"></td>
			</tr>
			<tr>
				<td>Ángulo de Canal: </td>
				<td width="27%"><input name="anguloCanal" type="text" size="15" maxlength="15" value="<?php echo $anguloCanal; ?>"></td>
				<td width="18%">Radio (J - U)</td>
			    <td width="32%"><input name="Radio" type="text" size="15" maxlength="15" value="<?php echo $Radio; ?>"></td>
			</tr>
			<tr>
				<td width="23%">Intervención de raíz: </td>
				<td colspan="3">
					<div style="border:1px simple #ccc; padding:5px;">
						Si
							<?php
								if($intRaiz == 'S'){?>
									<input name="intRaiz" type="radio" value="S" checked>
									<?php
								}else{
									?>
									<input name="intRaiz" type="radio" value="S">
									<?php
								}
							?>
						No
							<?php
								if($intRaiz == 'N'){?>
									<input name="intRaiz" type="radio" value="N" checked>
									<?php
								}else{
									?>
									<input name="intRaiz" type="radio" value="N">
									<?php
								}
							?>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">Método </td>
				<td colspan="2">
					<input name="Metodo" type="text" size="15" maxlength="15" value="<?php echo $Metodo; ?>">
				</td>
			</tr>
		</table>


		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="4">Metal base</td>
			</tr>
			<tr>
				<td>Especificaci&oacute;n Material : </td>
				<td width="27%"><input name="especMaterialDe" type="text" size="15" maxlength="15" value="<?php echo $especMaterialDe; ?>"></td>
				<td width="18%" align="center">a</td>
			    <td width="32%"><input name="especMaterialA" type="text" size="15" maxlength="15" value="<?php echo $especMaterialA; ?>"></td>
			</tr>
			<tr>
			  <td>Tipo o grado </td>
			  <td><input name="tpGradoDe" type="text" size="15" maxlength="15" value="<?php echo $tpGradoDe; ?>"></td>
			  <td align="center">a</td>
			  <td><input name="tpGradoA" type="text" size="15" maxlength="15" value="<?php echo $tpGradoA; ?>"></td>
		  </tr>
			<tr>
				<td>Espesor canal : </td>
				<td width="27%"><input name="espesorCanal" type="text" size="15" maxlength="15" value="<?php echo $espesorCanal; ?>"></td>
				<td width="18%">Filete</td>
			    <td width="32%"><input name="espesorFilete" type="text" size="15" maxlength="15" value="<?php echo $espesorFilete; ?>"></td>
			</tr>
			<tr>
				<td width="23%">Diametro Cañería: </td>
				<td colspan="3">
					<input name="diametroCaneria" type="text" size="15" maxlength="15" value="<?php echo $diametroCaneria; ?>">
				</td>
			</tr>
			<tr>
				<td>Grupo : </td>
				<td width="27%"><input name="grupoDe" type="text" size="15" maxlength="15" value="<?php echo $grupoDe; ?>"></td>
				<td width="18%" align="center">a</td>
			    <td width="32%"><input name="grupoA" type="text" size="15" maxlength="15" value="<?php echo $grupoA; ?>"></td>
			</tr>
			<tr>
				<td>Número P : </td>
				<td width="27%"><input name="numeroPde" type="text" size="15" maxlength="15" value="<?php echo $numeroPde; ?>"></td>
				<td width="18%" align="center">Numero P: </td>
			    <td width="32%"><input name="numeroPa" type="text" size="15" maxlength="15" value="<?php echo $numeroPa; ?>"></td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="4">Metal aporte</td>
			</tr>
			<tr>
				<td width="36%">Especificación AWS : </td>
				<td width="28%"><input name="especAWSde" type="text" size="15" maxlength="15" value="<?php echo $especAWSde; ?>"></td>
			    <td width="36%"><input name="especAWSa" type="text" size="15" maxlength="15" value="<?php echo $especAWSa; ?>"></td>
			</tr>
			<tr>
				<td width="36%">Clasificación AWS : </td>
				<td width="28%"><input name="clasAWSde" type="text" size="15" maxlength="15" value="<?php echo $clasAWSde; ?>"></td>
			    <td width="36%"><input name="clasAWSa" type="text" size="15" maxlength="15" value="<?php echo $clasAWSa; ?>"></td>
			</tr>
			<tr>
				<td width="36%">Diametro Electrodo : </td>
				<td width="28%"><input name="diametroElecDe" type="text" size="15" maxlength="15" value="<?php echo $diametroElecDe; ?>"></td>
			    <td width="36%"><input name="diametroElecA" type="text" size="15" maxlength="15" value="<?php echo $diametroElecA; ?>"></td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="6">Protección</td>
			</tr>
			<tr>
				<td width="31%">Fundente : </td>
				<td colspan="3"><input name="fundente" type="text" size="50" maxlength="50" value="<?php echo $fundente; ?>"></td>
			</tr>
			<tr>
				<td width="31%">Gas/Clasificación : </td>
				<td colspan="3"><input name="gasClasificacion" type="text" size="50" maxlength="50" value="<?php echo $gasClasificacion; ?>"></td>
			</tr>
			<tr>
				<td width="31%">Composición : </td>
				<td colspan="3"><input name="composicion" type="text" size="50" maxlength="50" value="<?php echo $composicion; ?>"></td>
			</tr>
			<tr>
				<td width="31%">Flujo : </td>
				<td width="16%"><input name="flujo" type="text" size="15" maxlength="15" value="<?php echo $flujo; ?>"></td>
			    <td width="20%">Tamaño tobera: </td>
			    <td width="33%"><input name="tamTobera" type="text" size="15" maxlength="15" value="<?php echo $tamTobera; ?>"></td>
			</tr>
			<tr>
				<td width="31%">Clase Fundente-electrodo : </td>
				<td colspan="3"><input name="claseFundenteElec" type="text" size="50" maxlength="50" value="<?php echo $claseFundenteElec; ?>"></td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="8">Precalentamiento</td>
			</tr>
			<tr>
				<td width="38%">Temp. Precalentamiento (mín.) : </td>
				<td colspan="3"><input name="preCalMin" type="text" size="10" maxlength="10" value="<?php echo $preCalMin; ?>"></td>
			</tr>
			<tr>
				<td width="38%">Temp. Interpase, Mín : </td>
				<td width="18%"><input name="interMin" type="text" size="10" maxlength="10" value="<?php echo $interMin; ?>"></td>
			    <td width="18%">M&aacute;x.</td>
			    <td width="26%"><input name="interMax" type="text" size="10" maxlength="10" value="<?php echo $interMax; ?>"></td>
			</tr>
		</table>

	</div>	
	<div id="cuadroDer">
		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="4">Posición</td>
			</tr>
			<tr>
				<td>Posición Canal : </td>
				<td><input name="Canal" size="10" maxlength="10" value="<?php echo $Canal; ?>"></td>
				<td>Filete : </td>
				<td><input name="Filete" size="10" maxlength="10" value="<?php echo $Filete; ?>"></td>
			</tr>
			<tr>
				<td>Progresión Vertical : </td>
				<td colspan="2">
					<div style="border:1px simple #ccc; padding:5px;">
						Asendente : 		
							<?php
								if($progresionVertical == 'A'){?>
									<input name="progresionVertical" type="radio" value="A" checked>
								<?php }else{ ?>
									<input name="progresionVertical" type="radio" value="A">
								<?php 
								} 
							?>
						Desendente : 			
							<?php
								if($progresionVertical == 'D'){?>
									<input name="progresionVertical" type="radio" value="D" checked>
								<?php }else{ ?>
									<input name="progresionVertical" type="radio" value="D">
								<?php 
								} 
							?>
					</div>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="3">Caraterísticas eléctricas : </td>
			</tr>
			<tr>
				<td colspan="3">Modo de transferencia (GMAW o FCAW)</td>
			</tr>
			<tr>
				<td colspan="3" align="right" style="padding-right:40px;">
					<div style="border:1px simple #ccc; padding:5px;">
						Corto circuito:
							<?php
								if($cortoCircuito == 1){?>
									<input name="modoTransferencia" type="radio" value="cortoCircuito" checked>
								<?php }else{ ?>
									<input name="modoTransferencia" type="radio" value="cortoCircuito">
								<?php 
								} 
							?>
						Globular: 		
							<?php
								if($Globular == 1){?>
									<input name="modoTransferencia" type="radio" value="Globular" checked>
								<?php }else{ ?>
									<input name="modoTransferencia" type="radio" value="Globular">
								<?php 
								} 
							?>
						Spray: 			
							<?php
								if($Spray == 1){?>
									<input name="modoTransferencia" type="radio" value="Spray" checked>
								<?php }else{ ?>
									<input name="modoTransferencia" type="radio" value="Spray">
								<?php 
								} 
							?>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3">Corriente y Polaridad</td>
			</tr>
			<tr>
				<td colspan="3" align="right" style="padding-right:40px;">
					<div style="border:1px simple #ccc; padding:5px;">
						CA: 	
							<?php
								if($CA == 1){?>
									<input name="corrientePolaridad" type="radio" value="CA" checked>
								<?php }else{ ?>
									<input name="corrientePolaridad" type="radio" value="CA">
								<?php 
								} 
							?>
						CCEP: 	
							<?php
								if($CCEP == 1){?>
									<input name="corrientePolaridad" type="radio" value="CCEP" checked>
								<?php }else{ ?>
									<input name="corrientePolaridad" type="radio" value="CCEP">
								<?php 
								} 
							?>
						CCEN: 	
							<?php
								if($CCEN == 1){?>
									<input name="corrientePolaridad" type="radio" value="CCEN" checked>
								<?php }else{ ?>
									<input name="corrientePolaridad" type="radio" value="CCEN">
								<?php 
								} 
							?>
					</div>
					<br><br>
					Otro: 	<input name="Otro" size="20" maxlength="20" value="<?php echo $Otro; ?>">
				</td>
			</tr>
			<tr>
				<td colspan="3">Electrodo Tungsteno(GTAW)</td>
			</tr>
			<tr>
				<td width="194">&nbsp;</td>
			    <td width="80">Tamaño : </td>
			    <td width="292"><input name="elecTunTam" size="20" maxlength="20" value="<?php echo $elecTunTam; ?>"></td>
			</tr>
			<tr>
				<td width="194">&nbsp;</td>
			    <td width="80">Tipo : </td>
			    <td width="292"><input name="elecTunTipo" size="20" maxlength="20" value="<?php echo $elecTunTipo; ?>"></td>
			</tr>
		</table>
		
		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="5">Técnica : </td>
			</tr>
			<tr>
				<td colspan="3">
					<div style="border:1px simple #ccc; padding:5px;">
						Cordón Recto : 		
							<?php
								if($Cordon == 'R'){?>
									<input name="Cordon" type="radio" value="R" checked>
								<?php }else{ ?>
									<input name="Cordon" type="radio" value="R">
								<?php 
								} 
							?>
						Osilado : 			
							<?php
								if($Cordon == 'O'){?>
									<input name="Cordon" type="radio" value="O" checked>
								<?php }else{ ?>
									<input name="Cordon" type="radio" value="O">
								<?php 
								} 
							?>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div style="border:1px simple #ccc; padding:5px;">
						Multipase : 		
							<?php
								if($Pase == 'M'){?>
									<input name="Pase" type="radio" value="M" checked>
								<?php }else{ ?>
									<input name="Pase" type="radio" value="M">
								<?php 
								} 
							?>
						Pase único : 			
							<?php
								if($Pase == 'U'){?>
									<input name="Pase" type="radio" value="U" checked>
								<?php }else{ ?>
									<input name="Pase" type="radio" value="U">
								<?php 
								} 
							?>
					</div>
				</td>
			</tr>
			<tr>
				<td width="222">N° Electrodos: </td>
			    <td colspan="2"><input name="nElectrodos" type="number" size="2" maxlength="2" value="<?php echo $nElectrodos; ?>"></td>
			</tr>
			<tr>
				<td colspan="3">Espaciamiento del electrodo : </td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td width="94">Longitudinal</td>
			  <td width="324"><input name="Longitudinal" type="text" size="20" maxlength="20" value="<?php echo $Longitudinal; ?>"></td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>Lateral : </td>
			  <td><input name="Lateral" type="text" size="20" maxlength="20" value="<?php echo $Lateral; ?>"></td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&Aacute;ngulo : </td>
			  <td><input name="Angulo" type="text" size="20" maxlength="20" value="<?php echo $Angulo; ?>"></td>
		  </tr>
			<tr>
			  <td>Distancia boquilla a pieza </td>
			  <td colspan="2" align="center"> <input name="Distancia" type="text" size="20" maxlength="20" value="<?php echo $Distancia; ?>"></td>
		  </tr>
			<tr>
			  <td>Martillado alivio tensiones </td>
			  <td colspan="2" align="center"><input name="Martillado" type="text" size="20" maxlength="20" value="<?php echo $Martillado; ?>"></td>
		  </tr>
			<tr>
				<td>Limpieza interpase </td>
			    <td colspan="2" align="center">
		        <input name="Limpieza" type="text" size="20" maxlength="20" value="<?php echo $Limpieza; ?>"></td>
		    </tr>
		</table>
		
		<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
			<tr class="tabTitulo">
				<td colspan="6">Tratamiento térmico Post - Soldadura : </td>
			</tr>
			<tr>
				<td>Temperatura : </td>
			    <td><input name="Temperatura" type="text" size="20" maxlength="20" value="<?php echo $Temperatura; ?>"></td>
			</tr>
			<tr>
				<td>Tiempo : </td>
			    <td><input name="Tiempo" type="text" size="20" maxlength="20" value="<?php echo $Tiempo; ?>"></td>
			</tr>
		</table>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" id="tabProceso">
		<tr class="tabTitulo">
			<td colspan="6">Observaciones </td>
		</tr>
		<tr>
			<td>
				<textarea name="Observaciones" cols="130" rows="5"><?php echo $Observaciones; ?></textarea>
			</td>
		</tr>
	</table>
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
		<?php
			if($fdProc[0] == 'PQR'){?>
				REGISTRO DE PROCEDIMIENTO DE SOLDADURA (PQR)
				<?php
			}else{ ?>
				ESPECIFICACION DE PROCEDIMIENTO DE SOLDADURA (WPS)
			<?php
			}
		?>
	</div>
	<table width="100%" border="1" cellpadding="0" cellspacing="0" id="tabProcedimiento">
		<tr class="tabTitulo">
			<td rowspan="2" width="10%">cordones <br>de soldadura </td>
		    <td rowspan="2" width="15%">Proceso</td>
		    <td colspan="2" width="20%">Materiales de aporte </td>
		    <td colspan="2" width="20%">Corriente</td>
		    <td rowspan="2" width="15%">Volts</td>
		    <td rowspan="2" width="15%">Velocidad de <br>avance <br>mm/min. </td>
		</tr>
		<tr class="tabTitulo">
			<td>Clase</td>
		    <td>Diámetro</td>
		    <td>Tipo &amp; <br>Polaridad </td>
		    <td>Amp &oacute; <br>VAA </td>
	    </tr>
		<?php
			$nCordon = 1;
			$link=Conectarse();
			$bdReg=mysql_query("Select * From solRegProcSoldadura Where CodInforme = '".$CodInforme."'");
			if(!$rowReg=mysql_fetch_array($bdReg)){
				mysql_query("insert into solRegProcsoldadura(
														CodInforme		,
														nCordon
														)
												values 	
														(
														'$CodInforme'	,
														'$nCordon'
														)",
				$link);
			}else{
				$bdReg=mysql_query("Select * From solRegProcSoldadura Where CodInforme = '".$CodInforme."' Order By nCordon Desc");
				if($rowReg=mysql_fetch_array($bdReg)){
					$nCordon = $rowReg['nCordon'];
				}
			}
			if(isset($_GET['accion'])){ 
				if($_GET['accion'] == 'ActualizaCordon'){ 
					$nCordon = $_GET['nCordon']; 
				}
			}
			//echo $CodInforme.' '.$nCordon;
			$bdReg=mysql_query("Select * From solRegProcSoldadura Where CodInforme = '".$CodInforme."' Order By nCordon");
			if($rowReg=mysql_fetch_array($bdReg)){
				do{
					if($nCordon == $rowReg['nCordon']){
						$nCordon 		= $rowReg['nCordon'];
						$Proceso 		= $rowReg['Proceso'];
						$matClase 		= $rowReg['matClase'];
						$matDiametro 	= $rowReg['matDiametro'];
						$corrienteTipo 	= $rowReg['corrienteTipo'];
						$corrienteAmp 	= $rowReg['corrienteAmp'];
						$Volt 			= $rowReg['Volt'];
						$Velocidad		= $rowReg['Velocidad'];
						?>
						<tr>
							<td><input name="nCordon" 		type="text" size="4" maxlength="4" value="<?php echo $nCordon; ?>">			</td>
							<td>
								<?php
									$Foco = '';
									if(isset($_POST['agregarProc'])){
										$Foco = 'autofocus';
									}
									if(isset($_POST['guardarProc'])){
										$Foco = 'autofocus';
									}
									if(isset($_GET['accion'])){ 
										if($_GET['accion'] == 'ActualizaCordon'){ 
											$Foco = 'autofocus';
										}
									}
									
								?>
								<input name="Proceso" 		type="text" size="6" maxlength="6" value="<?php echo $Proceso; ?>" <?php echo $Foco; ?> />
							</td>
							<td><input name="matClase" 		type="text" size="5" maxlength="5" value="<?php echo $matClase; ?>">		</td>
							<td><input name="matDiametro" 	type="text" size="4" maxlength="4" value="<?php echo $matDiametro; ?>">		</td>
							<td><input name="corrienteTipo" type="text" size="4" maxlength="4" value="<?php echo $corrienteTipo; ?>">	</td>
							<td><input name="corrienteAmp" 	type="text" size="7" maxlength="7" value="<?php echo $corrienteAmp; ?>">	</td>
							<td><input name="Volt" 			type="text" size="6" maxlength="6" value="<?php echo $Volt; ?>">			</td>
							<td><input name="Velocidad" 	type="text" size="8" maxlength="8" value="<?php echo $Velocidad; ?>">		</td>
						</tr>
					<?php
					}else{
						$Proceso 		= $rowReg['Proceso'];
						$matClase 		= $rowReg['matClase'];
						$matDiametro 	= $rowReg['matDiametro'];
						$corrienteTipo 	= $rowReg['corrienteTipo'];
						$corrienteAmp 	= $rowReg['corrienteAmp'];
						$Volt 			= $rowReg['Volt'];
						$Velocidad		= $rowReg['Velocidad'];
						?>
						<tr>
							<td>
								<a href="index.php?accion=ActualizaCordon&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $fdProc[0]; ?>&RutCli=<?php echo $RutCli; ?>&nCordon=<?php echo $rowReg['nCordon']; ?>"><?php echo $rowReg['nCordon']; ?></a>
							</td>
							<td><?php echo $Proceso; ?>				</td>
							<td><?php echo $matClase; ?>			</td>
							<td><?php echo $matDiametro; ?>			</td>
							<td><?php echo $corrienteTipo; ?>		</td>
							<td><?php echo $corrienteAmp; ?>		</td>
							<td><?php echo $Volt; ?>				</td>
							<td><?php echo $Velocidad; ?>			</td>
						</tr>
					<?php
					}
				}while ($rowReg=mysql_fetch_array($bdReg));
			}
			mysql_close($link);
		?>
		<tr>
			<td colspan="8" bgcolor="#F5F5F5">
				<button name="agregarProc" style=" float:right; margin:15px; text-align:center; font-size:10px;">
					<img src="../../imagenes/add_32.png" width="25"><br>
					Agregar
				</button>
				<button name="guardarProc" style=" float:right; margin:15px; text-align:center; font-size:10px;">
					<img src="../../imagenes/guardar.png" width="25"><br>
					Guardar
				</button>
			</td>
		</tr>
	</table>	
	<div id="registroSoldaduraTit">
		DETALLES DE LA UNIÓN
	</div>
	<table width="100%" border="1" cellpadding="0" cellspacing="0" id="tabProcedimiento">
		<tr>
			<td>
				<?php
					$link=Conectarse();
					$bdImg=mysql_query("Select * From solImagenUnion Where CodInforme = '".$CodInforme."'");
					if($rowImg=mysql_fetch_array($bdImg)){
						$fichero = "imgUniones/".$CodInforme."/".$rowImg['imagenUnion'];
						?>
						<img src="<?php echo $fichero; ?>">
						<?php
						echo $fichero;
					}
					mysql_close($link);
				?>
				
			</td>
		</tr>
		<tr>
			<td>
				<div style="padding:5px; float:right;">
					<a href="upImagen.php?accion=UpImagen&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $fdProc[1]; ?>&RutCli=<?php echo $RutCli; ?>"><img src="../../imagenes/upload2.png" width="50"></a>
				</div>
			</td>
		</tr>
	</table>
	<?php
		if($fdProc[0] == 'PQR'){?>
			<div id="registroSoldaduraTit">
				Ensayo(s) de Tracción
			</div>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" id="tabProcedimiento">
				<tr class="tabTitulo">
					<td width="10%" rowspan="2">ID <br>especimen 					</td>
					<td width="10%" rowspan="2">Ancho<br>[mm]						</td>
					<td width="10%" rowspan="2">Espesor<br>[mm] 					</td>
					<td width="10%" rowspan="2">Carga máxima<br>[Kgf]				</td>
					<td colspan="2">Esfuerzo de tracción 							</td>
					<td width="30%" rowspan="2">Ubicación y carácter de la factura </td>
				</tr>
				<tr class="tabTitulo">
				  	<td width="10%">[MPa]</td>
				  	<td width="10%">[PSI]</td>
			  	</tr>
				<?php
					if(isset($_GET['accion'])){
						if($_GET['accion'] == 'ActualizaTraccion'){
							$idEspecimen = $_GET['idEspecimen'];
						}
					}
					$link=Conectarse();
					$bdReg=mysql_query("Select * From solregproctr Where CodInforme = '".$CodInforme."'");
					if($rowReg=mysql_fetch_array($bdReg)){
						do{
							$Ancho 			= $rowReg['Ancho'];
							$Espesor		= $rowReg['Espesor'];
							$cMax 			= $rowReg['cMax'];
							$MPa 			= $rowReg['MPa'];
							$PSI 			= $rowReg['PSI'];
							$ubiCarFrac		= $rowReg['ubiCarFrac'];
							if($idEspecimen == $rowReg['idEspecimen']){
								$idEspecimen 	= $rowReg['idEspecimen'];
								?>
								<tr class="tabTitulo">
									<td>
										<input name="idEspecimen" type="text" list="listaTR" value="<?php echo $idEspecimen; ?>" autofocus />
										<datalist id="listaTR">
											<?php
											$bdPr=mysql_query("SELECT * FROM regTraccion Order By idItem ");
											if($rowPr=mysql_fetch_array($bdPr)){
												do{?>
													<option value="<?php echo $rowPr['idItem']; ?>">
												<?php
												}while ($rowPr=mysql_fetch_array($bdPr));
											}
											?>
										</datalist>
									</td>
									<td><input name="Ancho" 	type="text" value="<?php echo $Ancho; ?>" 	size="10"></td>
									<td><input name="Espesor" 	type="text" value="<?php echo $Espesor; ?>" size="10"></td>
									<td><input name="cMax" 		type="text" value="<?php echo $cMax; ?>" 	size="10"></td>
									<td><input name="MPa" 		type="text" value="<?php echo $MPa; ?>" 	size="10"></td>
									<td><input name="PSI" 		type="text" value="<?php echo $PSI; ?>" 	size="10"></td>
									<td><textarea rows="2" cols="40" name="ubiCarFrac"><?php echo $ubiCarFrac; ?></textarea></td>
								</tr>
							<?php
							}else{
							?>
								<tr class="tabTitulo">
									<td>
										<a href="index.php?accion=ActualizaTraccion&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $fdProc[0]; ?>&RutCli=<?php echo $RutCli; ?>&idEspecimen=<?php echo $rowReg['idEspecimen']; ?>"><?php echo $rowReg['idEspecimen']; ?></a>
									</td>
									<td><?php echo $Ancho; ?>		</td>
									<td><?php echo $Espesor; ?>		</td>
									<td><?php echo $cMax; ?>		</td>
									<td><?php echo $MPa; ?>			</td>
									<td><?php echo $PSI; ?>			</td>
									<td><?php echo $ubiCarFrac; ?>	</td>
								</tr>
							<?php
							}
						}while ($rowReg=mysql_fetch_array($bdReg));
					}
					mysql_close($link);
					
					if(isset($_POST['agregarTraccion'])){?>
						<tr class="tabTitulo">
							<td>
								<input name="idEspecimen" type="text" list="listaTR" autofocus />
								<datalist id="listaTR">
									<?php
									$link=Conectarse();
									$bdPr=mysql_query("SELECT * FROM regTraccion Order By idItem ");
									if($rowPr=mysql_fetch_array($bdPr)){
										do{?>
											<option value="<?php echo $rowPr['idItem']; ?>">
										<?php
										}while ($rowPr=mysql_fetch_array($bdPr));
									}
									mysql_close($link);
									?>
								</datalist>
							</td>
							<td><input name="Ancho" 	type="text" size="10"></td>
							<td><input name="Espesor" 	type="text" size="10"></td>
							<td><input name="cMax" 		type="text" size="10"></td>
							<td><input name="MPa" 		type="text" size="10"></td>
							<td><input name="PSI" 		type="text" size="10"></td>
							<td><textarea rows="2" cols="40" name="ubiCarFrac"></textarea></td>
						</tr>
						<?php
					}
					
				?>
				<tr>
					<td colspan="7" bgcolor="#F5F5F5">
						<button name="agregarTraccion" style=" float:right; margin:15px; text-align:center; font-size:10px;">
							<img src="../../imagenes/add_32.png" width="25"><br>
							Agregar
						</button>
						<button name="guardarTraccion" style=" float:right; margin:15px; text-align:center; font-size:10px;">
							<img src="../../imagenes/guardar.png" width="25" height="8"><br>
							Guardar
					  </button>
					</td>
				</tr>
			</table>
			
			
			<div id="registroSoldaduraTit">
				Ensayo(s) de Doblado Guiado
			</div>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" id="tabProcedimiento">
				<tr class="tabTitulo">
					<td width="10%">ID <br>especimen 					</td>
					<td width="25%">Tipo de Doblado						</td>
					<td width="25%">Resultado<br> [Cumple - No Cumple]	</td>
					<td width="40%">Evaluación de discontinuidades		</td>
				</tr>
				<?php
					if(isset($_GET['accion'])){
						if($_GET['accion'] == 'ActualizaDoblado'){
							$idEspecimenDoblado = $_GET['idEspecimenDoblado'];
						}
					}
					$link=Conectarse();
					$bdReg=mysql_query("Select * From solregprocdo Where CodInforme = '".$CodInforme."'");
					if($rowReg=mysql_fetch_array($bdReg)){
						do{
							$TipoDo				= $rowReg['Tipo'];
							$ObservacionesDo	= $rowReg['Observaciones'];
							$Condicion			= $rowReg['Condicion'];
							if($idEspecimenDoblado == $rowReg['idEspecimen']){
								$idEspecimenDoblado = $rowReg['idEspecimen'];
								?>
								<tr class="tabTitulo">
									<td>
										<input name="idEspecimenDoblado" type="text" list="listaDo" value="<?php echo $idEspecimenDoblado; ?>" autofocus />
										<datalist id="listaDo">
											<?php
											$bdPr=mysql_query("SELECT * FROM regDobladosReal Order By idItem ");
											if($rowPr=mysql_fetch_array($bdPr)){
												do{?>
													<option value="<?php echo $rowPr['idItem']; ?>">
												<?php
												}while ($rowPr=mysql_fetch_array($bdPr));
											}
											?>
										</datalist>
									</td>
									<td><input name="TipoDo" 		type="text" value="<?php echo $TipoDo; ?>" 		size="10"></td>
									<td><input name="Condicion" 	type="text" value="<?php echo $Condicion; ?>" 	size="10"></td>
									<td><textarea rows="2" cols="50" name="ObservacionesDo"><?php echo $ObservacionesDo; ?></textarea></td>
								</tr>
							<?php
							}else{
							?>
								<tr class="tabTitulo">
									<td>
										<a href="index.php?accion=ActualizaDoblado&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $fdProc[0]; ?>&RutCli=<?php echo $RutCli; ?>&idEspecimenDoblado=<?php echo $rowReg['idEspecimen']; ?>"><?php echo $rowReg['idEspecimen']; ?></a>
									</td>
									<td><?php echo $TipoDo; ?>			</td>
									<td><?php echo $Condicion; ?>		</td>
									<td><?php echo $ObservacionesDo; ?>	</td>
								</tr>
							<?php
							}
						}while ($rowReg=mysql_fetch_array($bdReg));
					}
					mysql_close($link);
					if(isset($_POST['agregarDoblado'])){?>
						<tr class="tabTitulo">
							<td>
								<input name="idEspecimenDoblado" type="text" list="listaDo" value="<?php echo $idEspecimenDoblado; ?>" autofocus />
								<datalist id="listaDo">
									<?php
									$link=Conectarse();
									$bdPr=mysql_query("SELECT * FROM regDobladosReal Order By idItem ");
									if($rowPr=mysql_fetch_array($bdPr)){
										do{?>
											<option value="<?php echo $rowPr['idItem']; ?>">
										<?php
										}while ($rowPr=mysql_fetch_array($bdPr));
									}
									mysql_close($link);
									?>
								</datalist>
							</td>
							<td><input name="TipoDo" 		type="text" value="<?php echo $TipoDo; ?>" 		size="10"></td>
							<td><input name="Condicion" 	type="text" value="<?php echo $Condicion; ?>" 	size="10"></td>
							<td><textarea rows="2" cols="50" name="ObservacionesDo"><?php echo $ObservacionesDo; ?></textarea></td>
						</tr>
						<?php
					}
					
				?>
				<tr>
					<td colspan="7" bgcolor="#F5F5F5">
						<button name="agregarDoblado" style=" float:right; margin:15px; text-align:center; font-size:10px;">
							<img src="../../imagenes/add_32.png" width="25"><br>
							Agregar
						</button>
						<button name="guardarDoblado" style=" float:right; margin:15px; text-align:center; font-size:10px;">
							<img src="../../imagenes/guardar.png" width="25"><br>
							Guardar
						</button>
					</td>
				</tr>
			</table>
			
			<?php
		}
	?>
