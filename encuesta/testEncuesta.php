<?php
		if($_GET['nSolicitud']) { $nSolicitud   = $_GET['nSolicitud']; 	}
		if($_GET['RutCli']) 	{ $RutCli   	= $_GET['RutCli']; 		}

		if($_POST['nSolicitud']) { $nSolicitud  = $_POST['nSolicitud']; }
		if($_POST['RutCli']) 	 { $RutCli   	= $_POST['RutCli']; 	}


/*      Recalcular */
		$link=Conectarse();
		if(isset($_POST['Recalcular'])){
			if($_POST['nSolicitud']) 	 { $nSolicitud   	= $_POST['nSolicitud']; 	}
			if($_POST['RutCli']) 	 	 { $RutCli   		= $_POST['RutCli']; 		}
			if($_POST['valorUF']) 	 	 { $valorUF   		= $_POST['valorUF']; 		}
			if($_POST['Fotocopia']) 	 { $Fotocopia   	= $_POST['Fotocopia']; 		}
			if($_POST['Factura']) 	 	 { $Factura   		= $_POST['Factura']; 		}
			if($_POST['nFactura']) 	 	 { $nFactura   		= $_POST['nFactura']; 		}
			if($_POST['fechaFactura']) 	 { $fechaFactura 	= $_POST['fechaFactura']; 	}

			if($_POST['Fotocopia']) 	 { 
				$Fotocopia   	= $_POST['Fotocopia']; 		
				if($_POST['fechaFotocopia']) { $fechaFotocopia  = $_POST['fechaFotocopia']; }
			}else{
				$fechaFotocopia  = "0000-00-00";
			}

			if($_POST['pagoFactura']) 	 { 
				$pagoFactura   	= $_POST['pagoFactura']; 		
				if($_POST['fechaPago']) { $fechaPago  = $_POST['fechaPago']; }
			}else{
				$fechaPago  	= "0000-00-00";
			}

			if($_POST['Factura']) 	 { 
				$Factura   	= $_POST['Factura']; 		
				if($_POST['nFactura']) 	 	{ $nFactura   	= $_POST['nFactura']; 		}
				if($_POST['fechaFactura']) 	{ $fechaFactura = $_POST['fechaFactura']; 	}
			}else{
				$nFactura  		= 0;
				$fechaFactura  	= "0000-00-00";
			}
			
			$bdFac=mysql_query("SELECT * FROM SolFactura Where nSolicitud = '".$nSolicitud."'");
			if($rowFac=mysql_fetch_array($bdFac)){
				//$nFactura 		= $rowFac['nFatura'];
				//$fechaFactura 	= $rowFac['fechaFatura'];
				$netoUF 		= $rowFac['netoUF'];
				$ivaUF 			= $rowFac['ivaUF'];
				$brutoUF 		= $rowFac['brutoUF'];
				//$Neto 			= $rowFac['Neto'];
				//$Iva 			= $rowFac['Iva'];
				//$Bruto 			= $rowFac['Bruto'];
			}
			
			$Neto 	= $netoUF 	* $valorUF;
			$Iva  	= $Neto 	* 0.19;
			$Bruto  = $Neto 	* 1.19;
			
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="Fotocopia			='".$Fotocopia."',";
			$actSQL.="fechaFotocopia	='".$fechaFotocopia."',";
			$actSQL.="pagoFactura		='".$pagoFactura."',";
			$actSQL.="fechaPago			='".$fechaPago."',";
			$actSQL.="Factura			='".$Factura."',";
			$actSQL.="nFactura			='".$nFactura."',";
			$actSQL.="fechaFactura		='".$fechaFactura."',";
			$actSQL.="valorUF			='".$valorUF."',";
			$actSQL.="Neto				='".$Neto."',";
			$actSQL.="Iva				='".$Iva."',";
			$actSQL.="Bruto				='".$Bruto."'";
			$actSQL.="WHERE nSolicitud	= '".$nSolicitud."' && RutCli = '".$RutCli."'";
			$bdFac=mysql_query($actSQL);
			
		}
/*      Recalcular */

		$bdDet=mysql_query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowDet=mysql_fetch_array($bdDet)){
			$Cliente = $rowDet['Cliente'];
		}

/*      Guardar */
		if(isset($_POST['Guardar'])){
			if($_POST['nSolicitud']) 	 { $nSolicitud   	= $_POST['nSolicitud']; 	}
			if($_POST['RutCli']) 	 	 { $RutCli   		= $_POST['RutCli']; 		}
			if($_POST['valorUF']) 	 	 { $valorUF   		= $_POST['valorUF']; 		}
			if($_POST['Factura']) 	 	 { $Factura   		= $_POST['Factura']; 		}
			if($_POST['nFactura']) 	 	 { $nFactura   		= $_POST['nFactura']; 		}
			if($_POST['fechaFactura']) 	 { $fechaFactura 	= $_POST['fechaFactura']; 	}

			if($_POST['Fotocopia']) 	 { 
				$Fotocopia   	= $_POST['Fotocopia']; 		
				if($_POST['fechaFotocopia']) { $fechaFotocopia  = $_POST['fechaFotocopia']; }
			}else{
				$fechaFotocopia  = "0000-00-00";
			}

			if($_POST['Factura']) 	 { 
				$Factura   	= $_POST['Factura']; 		
				if($_POST['nFactura']) 	 	{ $nFactura   	= $_POST['nFactura']; 		}
				if($_POST['fechaFactura']) 	{ $fechaFactura = $_POST['fechaFactura']; 	}
			}else{
				$nFactura  		= 0;
				$fechaFactura  	= "0000-00-00";
			}
			
			if($_POST['pagoFactura']) 	 { 
				$pagoFactura   	= $_POST['pagoFactura']; 		
				if($_POST['fechaPago']) { $fechaPago  = $_POST['fechaPago']; }
			}else{
				$fechaPago  	= "0000-00-00";
			}
			
			$bdFac=mysql_query("SELECT * FROM SolFactura Where nSolicitud = '".$nSolicitud."'");
			if ($rowFac=mysql_fetch_array($bdFac)){
				$actSQL="UPDATE SolFactura SET ";
				$actSQL.="valorUF			='".$valorUF."',";
				$actSQL.="Fotocopia			='".$Fotocopia."',";
				$actSQL.="fechaFotocopia	='".$fechaFotocopia."',";
				$actSQL.="Factura			='".$Factura."',";
				$actSQL.="nFactura			='".$nFactura."',";
				$actSQL.="fechaFactura		='".$fechaFactura."',";
				$actSQL.="pagoFactura		='".$pagoFactura."',";
				$actSQL.="fechaPago			='".$fechaPago."'";
				$actSQL.="WHERE nSolicitud	= '".$nSolicitud."' && RutCli = '".$RutCli."'";
				$bdFac=mysql_query($actSQL);
			}
		}		
		$bdFac=mysql_query("SELECT * FROM SolFactura Where nSolicitud = '".$nSolicitud."'");
		if ($rowFac=mysql_fetch_array($bdFac)){
			$tipoValor 		= $rowFac['tipoValor'];
			$valorUF 		= $rowFac['valorUF'];
			$fechaUF 		= $rowFac['fechaUF'];
			$netoUF 		= $rowFac['netoUF'];
			$ivaUF 			= $rowFac['ivaUF'];
			$brutoUF 		= $rowFac['brutoUF'];

			$Neto 			= $rowFac['Neto'];
			$Iva 			= $rowFac['Iva'];
			$Bruto 			= $rowFac['Bruto'];

			$Fotocopia 		= $rowFac['Fotocopia'];
			$fechaFotocopia = $rowFac['fechaFotocopia'];

			$Factura 		= $rowFac['Factura'];
			$nFactura 		= $rowFac['nFactura'];
			$fechaFactura 	= $rowFac['fechaFactura'];

			$pagoFactura 	= $rowFac['pagoFactura'];
			$fechaPago 		= $rowFac['fechaPago'];
		}
		mysql_close($link);
?>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<form name="form" action="index.php" method="post">
	<table width="60%"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<div id="CuerpoEncuesta">
					<div id="ImagenBarra">
						<a href="http://simet.cl/" title="Cerrar">
							<img src="../gastos/imagenes/no_32.png">
						</a>
					</div>
					<div id="titulocaja">
						<img src="../imagenes/simet.png" align="absmiddle">
						<strong style="font-size:24px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF;">
							Encuesta de Satisfacci�n a Clientes
						</strong>
					</div>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td colspan="5" align="center" class="txtGrandeSub">
								<?php echo '<span style="color:#FFFF00; ">Estimado Cliente '.$Cliente.'</span>'; ?><br>
								<span style="text-align:justify; padding:20px;">
									Le rogamos tengan la amabilidad de cumplimentar los apartados que consideren oportunos con relaci�n al contrato / servicio que hemos realizado para Uds.
								</span>
								<input type="hidden" name="RutCli" 		style="font-size:18px;" value="<?php echo $RutCli; ?>">
								<input type="hidden" name="nSolicitud" 	style="font-size:18px;" value="<?php echo $nSolicitud; ?>">
						</td>
					  </tr>
					  <tr>
						<td colspan="5"><hr></td>
					  </tr>
					  <tr>
						<td width="8%" align="center" class="numeroGrande" valign="top">A</td>
						<td colspan="4" class="tMed">
                        	Por favor, punt&uacute;e del 1 al 4 su valoraci&oacute;n para cada uno de los aspectos que se relacionan de acuerdo con la siguiente escala:
							<br><br>
							<table width="100%">
								<tr>
									<td>Muy satisfecho</td>
									<td>Satisfecho</td>
									<td>Insatisfecho</td>
									<td>Muy Insatisfecho</td>
									<td>No Procede</td>
								</tr>
								<tr>
									<td align="center">4</td>
									<td align="center">3</td>
									<td align="center">2</td>
									<td align="center">1</td>
									<td align="center">N.P.</td>
								</tr>
							</table>
							<br>
							<div class="txtGrandeSub">
							<table width="100%" border="0" style="padding:5px; ">
								<tr>
									<td align="center"><span class="boxRedondo">1</span></td>
									<td>Valoraci�n de la ASISTENCIA COMERCIAL (visitas, competencia, rapidez de respuesta, amabilidad, etc.)</td>
									<td valign="middle">
										<select style="font-size:30px; ">
											<option>&nbsp;</option>
											<option>4</option>
											<option>3</option>
											<option>2</option>
											<option>1</option>
											<option>N.P.</option>
										</select>
									</td>
								</tr>
							</table>
							</div>
						</td>
					  </tr>

					  <tr>
						<td width="8%" align="center" class="numeroGrande">A</td>
						<td width="25%" class="tMed">
								Fotocopia
						</td>
						<td width="15%" align="center">
							<?php if($Fotocopia == 'on'){ ?>
								<input name="Fotocopia" type="checkbox" checked>
							<?php }else{ ?>
								<input name="Fotocopia" type="checkbox">
							<?php } ?>
						</td>
						<td width="15%" align="center">&nbsp;</td>
						<td width="37%">
							<input type="date" name="fechaFotocopia" style="font-size:18px;" value="<?php echo $fechaFotocopia; ?>">
						</td>
					  </tr>


					  <tr>
						<td colspan="5"><hr></td>
					  </tr>
					  <tr>
					    <td class="numeroGrande">2</td>
					    <td class="txtGrande">Factura</td>
					    <td align="center">
							<?php if($Factura == 'on'){ ?>
								<input name="Factura" type="checkbox" checked>
							<?php }else{ ?>
								<input name="Factura" type="checkbox">
							<?php } ?>
						</td>
					    <td align="center"><input type="text" name="nFactura"  style="font-size:18px;" size="10" maxlength="10" value="<?php echo $nFactura; ?>" title="Registre el N� de Factura"></td>
					    <td><input type="date" name="fechaFactura"  style="font-size:18px;" value="<?php echo $fechaFactura; ?>"></td>
				  	</tr>
					<?php
						if($tipoValor == 'U'){?>
							<tr>
							  	<td height="61">&nbsp;</td>
							  	<td class="txtMenor" align="right">UF Referencial: </td>
							  	<td colspan="2" align="center">
							  		<input type="text" name="valorUF"  style="font-size:18px;" size="10" maxlength="10" value="<?php echo $valorUF; ?>" title="Valor referencial de la U.F. seg�n Factura">
								</td>
							  	<td>
									<button name="Recalcular" style="padding:10px;" title="Recalcular y pasar a Pesos">
										<img src="../gastos/imagenes/refresh_128.png" width="32" height="32">
									</button>
							  	</td>
					  		</tr>
							<tr>
								<td height="29">&nbsp;</td>
								<td class="txtMenor" align="center">Neto</td>
								<td class="txtMenor" colspan="2" align="center">Iva</td>
								<td class="txtMenor" align="center">Bruto</td>
							</tr>
							<tr class="txtGrandeSub">
								<td>&nbsp;</td>
								<td align="center">
									<?php
										echo $netoUF.' UF';
									?>
								</td>
								<td colspan="2" align="center">
									<?php
										echo $ivaUF.' UF';
									?>
								</td>
								<td align="center">
									<?php
										echo $brutoUF.' UF';
									?>
								</td>
							</tr>
							<?php if($Neto > 0){?>
									<tr class="txtGrandeSub">
										<td>&nbsp;</td>
										<td align="center">
											<?php
												echo number_format($Neto, 0, ',', '.');
											?>
										</td>
										<td colspan="2" align="center">
											<?php
												echo number_format($Iva, 0, ',', '.');
											?>
										</td>
										<td align="center">
											<?php
												echo number_format($Bruto, 0, ',', '.');
											?>
										</td>
									</tr>
							<?php } ?>
					<?php } ?>
					<tr>
						<td colspan="5"><hr></td>
					</tr>
					<tr>
						<td class="numeroGrande">3</td>
						<td class="txtGrande">Pago</td>
						<td align="center">
							<?php if($pagoFactura == 'on'){ ?>
								<input name="pagoFactura" type="checkbox" checked>
							<?php }else{ ?>
								<input name="pagoFactura" type="checkbox">
							<?php } ?>
						</td>
						<td align="center">&nbsp;</td>
						<td>
							<input type="date" name="fechaPago"  style="font-size:18px;" value="<?php echo $fechaPago; ?>">
						</td>
					  </tr>
					  <tr>
						<td colspan="5" class="txtGrandeSub" align="right">
							<button name="Volver" style="padding:10px;" onclick="goBack()">
								<img src="../gastos/imagenes/room_48.png" width="48" height="48">
							</button>
							<button name="Guardar" style="padding:10px;">
								<img src="../gastos/imagenes/guardar.png" width="48" height="48">
							</button>
						</td>
					  </tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</form>