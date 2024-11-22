<?php

	$Estado = array(
					1 => 'Todos', 
					2 => 'Pendientes',
					3 => 'Terminados',
					4 => 'Sin Informe'
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
	$link=Conectarse();
	$bdInf=mysql_query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
	if($rowInf=mysql_fetch_array($bdInf)){
		$nMuestras 			= $rowInf[nMuestras];
		$tipoMuestra		= $rowInf[tipoMuestra];
		$tpEnsayo			= $rowInf[tpEnsayo];
		$fechaRecepcion 	= $rowInf[fechaRecepcion];
		$fechaInforme 		= $rowInf[fechaInforme];
		$CodigoVerificacion = $rowInf[CodigoVerificacion];
		$imgQR 				= $rowInf[imgQR];
	}
	mysql_close($link);
?>

<form name="form" action="edicionInformes.php" method="post">
		
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaGenInf.php" title="Informes">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					PAMs
				</div>
				<div id="ImagenBarraLeft">
					<?php
						$r = explode('-',$CodInforme);
						$cIn 	= $r[0].'-'.$r[1];
					?>
					<a href="nominaInformes.php?CodInforme=<?php echo $cIn; ?>" title="Informes">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					Informes
				</div>
				<div id="ImagenBarraLeft">
					<button name="actualizaTabMuestras" style="float:right;" title="Guardar Tablas">
							<img src="../gastos/imagenes/guardar.png" width="55" height="55">
					</button>
					<br>
					Guardar
				</div>
				<div id="ImagenBarraLeft">
					<!-- <a href="#" title="Generar Word" onClick="bajarInformeWord($('#CodInforme').val(), $('#accion').val())"> -->
					<a href="exportarInforme.php?CodInforme=<?php echo $CodInforme; ?>&accion=<?php echo $accion; ?>" title="Generar Word">
						<img src="../imagenes/word.gif"></a>
					<br>
					Generar
				</div>
				<div id="ImagenBarraLeft">
					<a href="plantilla.doc" title="Bajar Plantilla">
						<img src="../imagenes/descargaword.gif"></a>
					<br>
					Plantilla
				</div>
				<div id="ImagenBarraLeft">
					<a href="#" title="Subir Imagen de Muestra" onClick="subirFotoMuestra($('#CodInforme').val(), $('#accion').val())"> 
						<img src="../imagenes/fotoMuestras.gif"></a>
					<br>
					Muestra
				</div>
				
			</div>
			
			<input name="CodInforme" 	id="CodInforme" type="hidden" 	value="<?php echo $CodInforme; 	?>" />
			<input name="idEnsayo" 		id="idEnsayo" 	type="hidden" 	value="<?php echo $idEnsayo; 	?>" />
			<input name="tpMuestra" 	id="tpMuestra" 	type="hidden" 	value="<?php echo $tpMuestra;	?>" />
			<input name="Ref" 			id="Ref" 		type="hidden" 	value="<?php echo $Ref;			?>" />
			<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
								<td width="19%">Cliente </td>
								<td colspan="3" valign="top">:
									<?php
									$link=Conectarse();
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
									if($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli[Cliente];
										$Direccion = $rowCli[Direccion];
									}
									mysql_close($link);
									?>
								</td>
							</tr>
							<tr>
								<td>Direcci&oacute;n </td>
								<td colspan="3">:
									<?php
										if($Direccion){
											echo $Direccion;
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Cantidad de Muestras </td>
								<td width="37%">: 
									<?php echo $nMuestras; ?>
								</td>
								<td width="20%">&nbsp;</td>
								<td width="24%">&nbsp;</td>
							</tr>
							<tr>
							  <td>Tipo de Muestra </td>
							  <td colspan="3">: 
							  	<?php echo $tipoMuestra; ?>
							  </td>
						  </tr>
							<tr>
								<td>Tipo de Ensayo </td>
								<td>: 
									<?php
										$link=Conectarse();
										$bdEns=mysql_query("SELECT * FROM amTpEnsayo Where tpEnsayo = '".$tpEnsayo."'");
										if($rowEns=mysql_fetch_array($bdEns)){
											echo $rowEns[Ensayo];
										} 
										mysql_close($link);
										?>
								</td>
								<td>Fecha de Recepci&oacute;n</td>
								<td>: 
									<?php 
										$fd = explode('-',$fechaRecepcion);
										echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
									?>
								</td>
							</tr>
							<tr>
								<td>Solicitante</td>
								<td>: 
									<?php
									$link=Conectarse();
									$bdCot=mysql_query("SELECT * FROM Cotizaciones Where RAM = '".$Ra[1]."'");
									if($rowCot=mysql_fetch_array($bdCot)){
										$bdCli=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCot[RutCli]."' and nContacto = '".$rowCot[nContacto]."'");
										if($rowCli=mysql_fetch_array($bdCli)){
											echo $rowCli[Contacto];
										}
									}
									mysql_close($link);
									?>
								</td>
								<td>Fecha Emisi&oacute;n Informe</td>
								<td>: 
									<?php
										$fd = explode('-',$fechaInforme);
										echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
									?>
							</tr>
						</table>
					</td>
				</tr>
		</table>

		<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
			<tr>
				<td>
					<?php
					$txtItemA = 'B.- Tabla Ensayos '.$_GET[idEnsayo];
					echo '<strong>'.$txtItemA.'</strong>';
					?>
				</td>
			</tr>

			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" id="tablaIdMuestras">
						<tr bgcolor="#CCCCCC">
							<td width="10%" align="center">
								ID<br>
								Ensayo
							</td>
							<td width="15%">
								Tipo de Muestra 
							</td>
							<td width="23%">Con/Sin Referencia </td>
							<td>Cantidad Ensayos </td>
							<td>&nbsp;</td>
						</tr>
						<?php
						$link=Conectarse();
						$bdEns=mysql_query("SELECT * FROM amEnsayos Where idEnsayo = '".$_GET[idEnsayo]."'");
						if($rowEns=mysql_fetch_array($bdEns)){
							do{?>
								<tr>
									<td align="center"><?php echo $rowEns[Ensayo]; ?></td>
									<td>
										<?php 
										$idEnsayo 	= '';
										$tpMuestra	= '';
										$Ref 		= '';
										$cEnsayos 	= '';
										
										$campoTpMuestra = 'tpMuestra'.$rowEns[idEnsayo];
										$bdTabEns=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns[idEnsayo]."' and tpMuestra = '".$_GET[tpMuestra]."' and Ref = '".$_GET[Ref]."'");
										if($rowTabEns=mysql_fetch_array($bdTabEns)){
											$idEnsayo  	= $rowTabEns[idEnsayo];
											$tpMuestra 	= $rowTabEns[tpMuestra];
											$Ref 		= $rowTabEns[Ref];
											$cEnsayos	= $rowTabEns[cEnsayos];
											$Ind		= $rowTabEns[Ind];
											$Tem		= $rowTabEns[Tem];
										}
										$bdTpEns=mysql_query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$rowEns[idEnsayo]."'");
										if($rowTpEns=mysql_fetch_array($bdTpEns)){
											do{
												if($rowTpEns[idEnsayo] == $idEnsayo and $rowTpEns[tpMuestra] == $tpMuestra){
													echo $rowTpEns[Muestra];
												}
											}while($rowTpEns=mysql_fetch_array($bdTpEns));
										} 
										?>
									
									</td>
									<td>
										<?php $campoRef = 'Ref'.$rowEns[idEnsayo]; ?>
										<?php 
											if($Ref == 'SR'){
												echo 'Sin Referencia';
											}else{
												echo 'Con Referencia';
											}
										?>
									</td>
									<td>
										<?php $campocEnsayos = 'cEnsayos'.$rowEns[idEnsayo]; ?>
							  			<?php echo $cEnsayos; ?>
									</td>
									<td>
										<?php
										if($idEnsayo == 'Du'){
											$campoInd = 'Ind'.$rowEns[idEnsayo];
											echo 'Indentaciones: '.Ind;
										}
										?>
									</td>
								</tr>
								<?php 
							}while($rowEns=mysql_fetch_array($bdEns));
						}
						mysql_close($link);
						?>
					</table>
				</td>
			</tr>
		</table>
		<?php
			include_once('ingDatosTablas.php');
		?>
</form>
		
		<span id="resultadoEdicionMuestra"></span>
		<span id="resultado"></span>
		<span id="resultadoRegistro"></span>
		<span id="resultadoSubir"></span>
