<?php
		$valorUF 		= 0;
		$Factura 		= 0;
		$pagoFactura 	= 0;
		$tAbonado		= 0;
		$Fotocopia		= '';
		$txtSeguimiento = '';
		$fechaHoy 		= date('Y-m-d');
		
		if(isset($_GET['nSolicitud'])) 	{ $nSolicitud   = $_GET['nSolicitud']; 	}
		if(isset($_GET['RutCli'])) 		{ $RutCli   	= $_GET['RutCli']; 		}

		if(isset($_POST['nSolicitud'])) { $nSolicitud  = $_POST['nSolicitud']; 	}
		if(isset($_POST['RutCli'])) 	{ $RutCli   	= $_POST['RutCli']; 	}


/*      Recalcular */
		$link=Conectarse();
		if(isset($_POST['Recalcular'])){
			if(isset($_POST['nSolicitud'])) 	{ $nSolicitud   	= $_POST['nSolicitud']; 	}
			if(isset($_POST['RutCli'])) 	 	{ $RutCli   		= $_POST['RutCli']; 		}
			if(isset($_POST['txtSeguimiento'])) { $txtSeguimiento  	= $_POST['txtSeguimiento']; }
			if(isset($_POST['valorUF'])) 	 	{ $valorUF   		= $_POST['valorUF']; 		}
			if(isset($_POST['Fotocopia'])) 	 	{ $Fotocopia   		= $_POST['Fotocopia']; 		}
			if(isset($_POST['Factura'])) 	 	{ $Factura   		= $_POST['Factura']; 		}
			if(isset($_POST['nFactura'])) 	 	{ $nFactura   		= $_POST['nFactura']; 		}
			if(isset($_POST['fechaFactura'])) 	{ $fechaFactura 	= $_POST['fechaFactura']; 	}

			if(isset($_POST['Fotocopia'])) 	 { 
				$Fotocopia   	= $_POST['Fotocopia']; 		
				if(isset($_POST['fechaFotocopia'])) { $fechaFotocopia  = $_POST['fechaFotocopia']; }
			}else{
				$fechaFotocopia  = "0000-00-00";
			}

			if(isset($_POST['pagoFactura'])) 	 { 
				$pagoFactura   	= $_POST['pagoFactura']; 		
				if(isset($_POST['fechaPago'])) { $fechaPago  = $_POST['fechaPago']; }
			}else{
				$fechaPago  	= "0000-00-00";
			}

			if(isset($_POST['Factura'])) 	 { 
				$Factura   	= $_POST['Factura']; 		
				if(isset($_POST['nFactura'])) 	 	{ $nFactura   	= $_POST['nFactura']; 		}
				if(isset($_POST['fechaFactura'])) 	{ $fechaFactura = $_POST['fechaFactura']; 	}
			}else{
				$nFactura  		= 0;
				$fechaFactura  	= "0000-00-00";
			}
			
			$bdFac=$link->query("SELECT * FROM SolFactura Where nSolicitud = '".$nSolicitud."'");
			if($rowFac=mysqli_fetch_array($bdFac)){
				//$nFactura 		= $rowFac['nFatura'];
				//$fechaFactura 	= $rowFac['fechaFatura'];
				$netoUF 		= $rowFac['netoUF'];
				$ivaUF 			= $rowFac['ivaUF'];
				$brutoUF 		= $rowFac['brutoUF'];
				//$Neto 			= $rowFac['Neto'];
				//$Iva 			= $rowFac['Iva'];
				//$Bruto 			= $rowFac['Bruto'];
			}
			
			if($rowFac['Exenta'] == 'on' ){
				$Neto 	= $netoUF 	* $valorUF;
				$Iva  	= 0;
				$Bruto  = $Neto;
			}else{
				$Neto 	= $netoUF 	* $valorUF;
				$Iva  	= $Neto 	* 0.19;
				$Bruto  = $Neto 	* 1.19;
			}			
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="txtSeguimiento	='".$txtSeguimiento."',";
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
			$bdFac=$link->query($actSQL);
			
		}
/*      Recalcular */

		$bdDet=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowDet=mysqli_fetch_array($bdDet)){
			$Cliente = $rowDet['Cliente'];
		}

/*      Guardar */
		$Saldo = 0;
		$Abono = 0;
		if(isset($_POST['Guardar'])){
			if(isset($_POST['nSolicitud'])) 	 { $nSolicitud   	= $_POST['nSolicitud']; 	}
			if(isset($_POST['RutCli'])) 	 	 { $RutCli   		= $_POST['RutCli']; 		}
			if(isset($_POST['txtSeguimiento'])) { $txtSeguimiento  	= $_POST['txtSeguimiento']; }
			if(isset($_POST['valorUF'])) 	 	 { $valorUF   		= $_POST['valorUF']; 		}
			if(isset($_POST['Factura'])) 	 	 { $Factura   		= $_POST['Factura']; 		}
			if(isset($_POST['nFactura'])) 	 	 { $nFactura   		= $_POST['nFactura']; 		}
			if(isset($_POST['fechaFactura'])) 	 { $fechaFactura 	= $_POST['fechaFactura']; 	}
			if(isset($_POST['Abono'])) 	 		 { $Abono 			= $_POST['Abono']; 			}
			if(isset($_POST['Saldo'])) 	 		 { $Saldo 			= $_POST['Saldo']; 			}

			if(isset($_POST['Fotocopia'])) 	 { 
				$Fotocopia   	= $_POST['Fotocopia']; 		
				if(isset($_POST['fechaFotocopia'])) { $fechaFotocopia  = $_POST['fechaFotocopia']; }
			}else{
				$fechaFotocopia  = "0000-00-00";
			}

			if(isset($_POST['Factura'])) 	 { 
				$Factura   	= $_POST['Factura']; 		
				if(isset($_POST['nFactura'])) 	 	{ $nFactura   	= $_POST['nFactura']; 		}
				if(isset($_POST['fechaFactura'])) 	{ $fechaFactura = $_POST['fechaFactura']; 	}
			}else{
				$nFactura  		= 0;
				$fechaFactura  	= "0000-00-00";
			}
			
			$fechaPago = "0000-00-00";
			$pagoFactura = '';
			if(isset($_POST['pagoFactura'])) 	 { 
				$pagoFactura   	= $_POST['pagoFactura'];
				if(isset($_POST['fechaPago'])) { $fechaPago  = $_POST['fechaPago']; }
			}

			$bdFac=$link->query("SELECT * FROM SolFactura Where nSolicitud = '".$nSolicitud."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){

/*				
				Bruto    Abono     Saldo
				300.000  		0   300.000
				300.000    100.000  200.000
				300.000     50.000  150.000
*/				
				if($Abono > 0){
					$Saldo = $Saldo - $Abono;
					if($Saldo == 0){
						$pagoFactura = 'on';
					}
				}

				if($pagoFactura == 'on'){
					$Saldo 		= 0;
					$Abono 		= $rowFac['Bruto'];
					if($fechaPago == '0000-00-00'){
						$fechaPago = date('Y-m-d');
					}
				}

				$actSQL="UPDATE SolFactura SET ";
				$actSQL.="txtSeguimiento	='".$txtSeguimiento."',";
				$actSQL.="valorUF			='".$valorUF."',";
				$actSQL.="Fotocopia			='".$Fotocopia."',";
				$actSQL.="fechaFotocopia	='".$fechaFotocopia."',";
				$actSQL.="Factura			='".$Factura."',";
				$actSQL.="nFactura			='".$nFactura."',";
				$actSQL.="fechaFactura		='".$fechaFactura."',";
				$actSQL.="pagoFactura		='".$pagoFactura."',";
				$actSQL.="Abono				='".$Abono."',";
				$actSQL.="Saldo				='".$Saldo."',";
				$actSQL.="fechaPago			='".$fechaPago."'";
				$actSQL.="WHERE nSolicitud	= '".$nSolicitud."' && RutCli = '".$RutCli."'";
				$bdFac=$link->query($actSQL);
				$Abono = 0;
			}
		}		
		$bdFac=$link->query("SELECT * FROM SolFactura Where nSolicitud = '".$nSolicitud."'");
		if ($rowFac=mysqli_fetch_array($bdFac)){
			$txtSeguimiento	= $rowFac['txtSeguimiento'];
			$tipoValor 		= $rowFac['tipoValor'];
			$valorUF 		= $rowFac['valorUF'];
			$fechaUF 		= $rowFac['fechaUF'];
			$netoUF 		= $rowFac['netoUF'];
			$ivaUF 			= $rowFac['ivaUF'];
			$brutoUF 		= $rowFac['brutoUF'];

			$Neto 			= $rowFac['Neto'];
			$Iva 			= $rowFac['Iva'];
			$Bruto 			= $rowFac['Bruto'];
			$tAbonado		= $rowFac['Abono'];

			if($rowFac['Abono'] == 0){
				//$Abono 			= $rowFac['Bruto'];
				$Saldo 			= $rowFac['Bruto'];
			}else{
				//$Abono 			= $rowFac['Saldo'];
				$Saldo 			= $rowFac['Saldo'];
			}
			
			$Fotocopia 		= $rowFac['Fotocopia'];
			$fechaFotocopia = $rowFac['fechaFotocopia'];

			$Factura 		= $rowFac['Factura'];
			$nFactura 		= $rowFac['nFactura'];
			$fechaFactura 	= $rowFac['fechaFactura'];

			$pagoFactura 	= $rowFac['pagoFactura'];
			$fechaPago 		= $rowFac['fechaPago'];
		}
		$link->close();
?>
<script>
function goBack()
  {
  window.history.back()
  }
</script>

<form name="form" action="seguimientoSolicitudes.php" method="post"> 
	<table width="60%"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<div id="CuerpoEncuesta">
					<div id="ImagenBarra">
						<a href="plataformaFacturas.php" title="Cerrar">
							<img src="../gastos/imagenes/no_32.png" width="24" height="24">
						</a>
					</div>
					<div id="titulocaja">
						<img src="../gastos/imagenes/klipper.png" width="50" height="50" align="absmiddle">
						<strong style="font-size:20px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF;">
							Control de Seguimiento Solicitud Factura
						</strong>
					</div>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td colspan="5" align="center" class="txtGrandeSub">
								<?php echo $Cliente; ?><br>
								Solicitud N° <?php echo $nSolicitud; ?>
								<input type="hidden" name="RutCli" 		style="font-size:18px;" value="<?php echo $RutCli; ?>">
								<input type="hidden" name="nSolicitud" 	style="font-size:18px;" value="<?php echo $nSolicitud; ?>">
						</td>
					  </tr>
					  <tr>
						<td colspan="5"><hr></td>
					  </tr>
					  <tr>
						<td width="8%" align="center" class="numeroGrande">1</td>
						<td width="25%" class="txtGrande">
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

					<tr bgcolor="#006699">
					  <td class="numeroGrande">&nbsp;</td>
					  <td class="txtGrande">Monto Facturado </td>
					  <td colspan="3" align="center" style="font-size:35px; color:#FFFFFF;"> 
					  		$ <?php echo number_format($Bruto, 0, ',', '.'); ?>
					  </td>
					</tr>

					<tr bgcolor="#006699">
					  <td class="numeroGrande">&nbsp;</td>
					  <td class="txtGrande">Último Abono </td>
					  <td colspan="3" align="center" style="font-size:30px; color:#FFFFFF;"> 
					  		<?php echo '$ '.number_format($tAbonado, 0, ',', '.'); ?>
					  </td>
					</tr>
					<tr bgcolor="#006699">
					  <td class="numeroGrande">&nbsp;</td>
					  <td class="txtGrande">Abono </td>
					  <td colspan="3" align="center"> 
					  		<input style="font-size:35px; color:#fff; background-color:#006600; text-align:right;" name="Abono" min="0" max="<?php echo $Saldo; ?>" type="number" value="<?php echo $Abono; ?>" maxlength="8" size="8">
					  </td>
					</tr>
					<tr bgcolor="#006699">
					  <td class="numeroGrande">&nbsp;</td>
					  <td class="txtGrande">Saldo </td>
					  <td colspan="3" align="center" style="font-size:35px; color:#FFFFFF;"> 
					  		<input name="Saldo" type="hidden" value="<?php echo $Saldo; ?>">
							$ <?php echo number_format($Saldo, 0, ',', '.'); ?>
					  </td>
					</tr>

					<tr>
						<td colspan="5"><hr></td>
					</tr>
<!-- 					
					<tr>
						<td class="numeroGrande">5</td>
						<td class="txtGrande" colspan="4">Seguimiento Solicitud Factura</td>
					</tr>
					<tr>
						<td class="numeroGrande"></td>
						<td colspan=4>
							<textarea name="txtSeguimiento" cols="80" rows="5"><?php echo $txtSeguimiento; ?></textarea>
						</td>
					</tr>
-->

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