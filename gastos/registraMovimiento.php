<?php
include_once("../conexionli.php");
$nGasto = 0;
if(isset($_GET['TpDoc'])) 		{ $TpDoc   	= $_GET['TpDoc']; 		}
if(isset($_GET['Proceso'])) 	{ $Proceso  = $_GET['Proceso']; 	}
if(isset($_GET['nGasto'])) 		{ $nGasto  	= $_GET['nGasto']; 		}

if($TpDoc == 'B'){ despliegaFormularioBoleta($nGasto); }
if($TpDoc == 'F'){ despliegaFormularioFactura($nGasto); }
if($TpDoc == 'P'){ despliegaFormularioFacturaSueldo($nGasto); }

function despliegaFormularioBoleta($nGasto){
	$Proveedor 		= '';
	$Proceso		= $_GET['Proceso'];
	$nDoc			= '';
	$FechaGasto		= date('Y-m-d');
	$Hora			= date('H:m');
	$Bien_Servicio	= '';
	$Bruto			= 0;
	$MsgUsr = "";

	if($nGasto){
		$link=Conectarse();
		$bdGas=$link->query("SELECT * FROM MovGastos WHERE nGasto = '".$nGasto."'");
		if ($row=mysqli_fetch_array($bdGas)){
   			$FechaGasto 	= $row['FechaGasto'];
			$Hora			= $row['Hora'];
   			$nDoc  			= $row['nDoc'];
   			$Proveedor  	= $row['Proveedor'];
			$Bien_Servicio	= $row['Bien_Servicio'];
			$exento			= $row['exento'];
			$Neto 			= $row['Neto'];
			$Iva 			= $row['Iva'];
			$Bruto			= $row['Bruto'];
			$TpDoc			= $row['TpDoc'];
			
			$nInforme = $row['nInforme'];
			
			if($nInforme) {
				$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."'");
				if ($rowForm=mysqli_fetch_array($bdForm)){
					$Concepto = $rowForm['Concepto'];
				}
			}
						
			$bdIt=$link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
			if ($rowIt=mysqli_fetch_array($bdIt)){
				$Items 			= $rowIt['Items'];
			}
			$bdTpGto=$link->query("SELECT * FROM TipoGasto Where IdGasto = '".$row['IdGasto']."'");
			if ($rowGto=mysqli_fetch_array($bdTpGto)){
				$TpGasto 		= $rowGto['TpGasto'];
			}
			$link=Conectarse();
			$bdRec=$link->query("SELECT * FROM Recursos Where IdRecurso = '".$row['IdRecurso']."'");
			if ($rowRec=mysqli_fetch_array($bdRec)){
				$Recurso 		= $rowRec['Recurso'];
				$IdRecurso 		= $rowRec['IdRecurso'];
			}
			$IdProyecto 	= $row['IdProyecto'];
			$IdAutoriza 	= $row['IdAutoriza'];
		}
		$link->close();
		if(isset($_GET['Proceso']) == 3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}
	
	
	?>
		<table width="99%"  border="0" cellspacing="0" cellpadding="0" id="RegistroDeGasto">
			<tr>
				<td colspan=4>Proveedor		</td>
			</tr>
			<tr>
				<td colspan=4 style="border-bottom: 1px solid #ccc;">
					<input name="Proveedor" list="prov" type="text" size="100" maxlength="100"  value="<?php echo $Proveedor; ?>" required />
					<datalist id="prov">
						<?php
							$link=Conectarse();
							$bdProv=$link->query("SELECT * FROM Proveedores");
							if($row=mysqli_fetch_array($bdProv)){
								do{?>
									<option value="<?php echo $row['Proveedor']; ?>">
									<?php
								}while ($row=mysqli_fetch_array($bdProv));
							}
						?>
					</datalist>
					<input name="Proceso"  			type="hidden" value="<?php echo $Proceso; ?>">
					<input name="nGasto"  			type="hidden" value="<?php echo $nGasto; ?>">
				</td>
			</tr>
			</tr>
				<td>N° Boleta		</td>
				<td>Fecha			</td>
				<td>Producto y/o servicio adquirido	</td>
				<td>Total			</td>
			</tr>
			<tr>
				<td>
					<input name="nDoc"	 	 		type="text" size="10" maxlength="10" 	value="<?php echo $nDoc; ?>" required />
				</td>
				<td>
					<input name="FechaGasto"		type="date"   size="10" maxlength="10" 	value="<?php echo $FechaGasto; ?>" required />
					<input name="Hora"				type="hidden" size="10" maxlength="10" 	value="<?php echo $Hora; ?>">
				</td>
				<td>
					<input name="Bien_Servicio" class="form-control"  	type="text" size="30" maxlength="100" 	value="<?php echo $Bien_Servicio; ?>" required />
				</td>
				<td>
					<input name="Bruto" 			type="text" size="10" maxlength="10" 	value="<?php echo $Bruto; ?>" required />
				</td>
			</tr>
		</table>
		<?php $MsgUsr = ""; ?>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">
			<tr>
				<td>Opciones
					<?php if($MsgUsr){ ?>
							<div id="Saldos"><?php echo $MsgUsr; ?></div>
					<?php }else{ ?>
							<div id="Saldos" style="display:none; "><?php echo $MsgUsr; ?></div>
					<?php } ?>
				</td>
			</tr>
		</table>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
			<tr>
				<td id="CajaOpc">
					Items de Gastos
				</td>
				<td id="CajaOpc">
					Tipo de Gastos
				</td>
				<td id="CajaOpc">
					Cuenta de Cargo
				</td>
				<td id="CajaOpc">
					Proyectos
				</td>
			</tr>
			<tr>
				<td id="CajaOpcDatos" valign="top">
					<?php
						$link=Conectarse();
						$bdIt=$link->query("SELECT * FROM ItemsGastos Order By nItem");
						if ($row=mysqli_fetch_array($bdIt)){
							do{
								if(isset($Items)){
									if($Items==$row['Items']){ ?>
										<input type="radio" name="Items" value="<?php echo $row['Items']; ?>" checked>	<?php echo $row['Items']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="Items" value="<?php echo $row['Items']; ?>">			<?php echo $row['Items']; ?><br>
									<?php }
								}else{ ?>
									<input type="radio" 	name="Items" value="<?php echo $row['Items']; ?>" required />			<?php echo $row['Items']; ?><br>
									<?php
								}
							}while ($row=mysqli_fetch_array($bdIt));
						}
						$link->close();
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php
						$link=Conectarse();
						$bdTpGto=$link->query("SELECT * FROM TipoGasto Where Estado = 'on' Order By IdGasto");
						if ($row=mysqli_fetch_array($bdTpGto)){
							do{
								if(isset($TpGasto)){
									if($TpGasto==$row['TpGasto']){?>
										<input type="radio" name="TpGasto" value="<?php echo $row['TpGasto']; ?>" checked>	<?php echo $row['TpGasto']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="TpGasto" value="<?php echo $row['TpGasto']; ?>">			<?php echo $row['TpGasto']; ?><br>
										<?php
									}
								}else{ ?>
									<input type="radio" 	name="TpGasto" value="<?php echo $row['TpGasto']; ?>" required />			<?php echo $row['TpGasto']; ?><br>
									<?php
								}
							}while($row=mysqli_fetch_array($bdTpGto));
						}
						$link->close();
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php 
						$link=Conectarse();
						$bdRec=$link->query("SELECT * FROM Recursos  Where Estado = 'on' Order By nPos");
						if ($row=mysqli_fetch_array($bdRec)){
							do{
								if(isset($Recurso)){
									if($Recurso==$row['Recurso']){ ?>
										<input type="radio" name="Recurso" value="<?php echo $row['Recurso']; ?>" checked>	<?php echo $row['Recurso']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="Recurso" value="<?php echo $row['Recurso']; ?>">			<?php echo $row['Recurso']; ?><br>
										<?php
									}
								}else{ ?>
									<input type="radio" 	name="Recurso" value="<?php echo $row['Recurso']; ?>" required />			<?php echo $row['Recurso']; ?><br>
									<?php
								}
							}while($row=mysqli_fetch_array($bdRec));
						}
						$link->close();
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php 
						$link=Conectarse();
						$bdPr=$link->query("SELECT * FROM Proyectos Order By IdProyecto");
						if ($row=mysqli_fetch_array($bdPr)){
							do{
								if(isset($IdProyecto)){
									if($IdProyecto==$row['IdProyecto']){ ?>
										<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>" checked><?php echo $row['IdProyecto']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>">		<?php echo $row['IdProyecto']; ?><br>
										<?php
									}
								}else{ ?>
									<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto'];?>" required />				<?php echo $row['IdProyecto']; ?><br>
									<?php 
								}
							}while($row=mysqli_fetch_array($bdPr));
						}
						$link->close();
					?>
				</td>
			</tr>
		</table>
		
	<?php
}

function despliegaFormularioFactura($nGasto){
	
	$Proveedor 		= '';
	$Proceso		= $_GET['Proceso'];
	$nDoc			= '';
	$FechaGasto		= date('Y-m-d');
	$Hora			= date('H:m');
	$Bien_Servicio	= '';
	$Bruto			= 0;
	$Concepto		= '';
	$nInforme		= '';
	$exento			= '';
	$efectivo		= '';
	$Neto			= 0;
	$Iva			= 0;
	$Bruto			= 0;
	$CalCosto		= 0;
	$CalCalidad		= 0;
	$CalPreVenta	= 0;
	$CalPostVenta	= 0;
	

	if($nGasto){
		$link=Conectarse();
		$bdGas=$link->query("SELECT * FROM MovGastos WHERE nGasto = '".$nGasto."'");
		if ($row=mysqli_fetch_array($bdGas)){
   			$CalCosto 		= $row['CalCosto'];
   			$CalCalidad 	= $row['CalCalidad'];
   			$CalPreVenta	= $row['CalPreVenta'];
   			$CalPostVenta	= $row['CalPostVenta'];
			
   			$FechaGasto 	= $row['FechaGasto'];
			$Hora			= $row['Hora'];
   			$nDoc  			= $row['nDoc'];
   			$Proveedor  	= $row['Proveedor'];
			$Bien_Servicio	= $row['Bien_Servicio'];
			$exento			= $row['exento'];
			$efectivo		= $row['efectivo'];
			$Neto 			= $row['Neto'];
			$Iva 			= $row['Iva'];
			$Bruto			= $row['Bruto'];
			$TpDoc			= $row['TpDoc'];
			
			$nInforme = $row['nInforme'];
			
			if($nInforme) {
				$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."'");
				if ($rowForm=mysqli_fetch_array($bdForm)){
					$Concepto = $rowForm['Concepto'];
				}
			}
						
			$bdIt=$link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
			if ($rowIt=mysqli_fetch_array($bdIt)){
				$Items 			= $rowIt['Items'];
			}
			$bdTpGto=$link->query("SELECT * FROM TipoGasto Where IdGasto = '".$row['IdGasto']."'");
			if ($rowGto=mysqli_fetch_array($bdTpGto)){
				$TpGasto 		= $rowGto['TpGasto'];
			}
			$link=Conectarse();
			$bdRec=$link->query("SELECT * FROM Recursos Where IdRecurso = '".$row['IdRecurso']."'");
			if ($rowRec=mysqli_fetch_array($bdRec)){
				$Recurso 		= $rowRec['Recurso'];
				$IdRecurso 		= $rowRec['IdRecurso'];
			}
			$IdProyecto 	= $row['IdProyecto'];
			$IdAutoriza 	= $row['IdAutoriza'];
		}
		$link->close();
		if(isset($_GET['Proceso']) == 3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}



	?>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="RegistroDeGasto">
			<tr>
				<td colspan=8>Proveedor</td>
			</tr>
			<tr>
				<td colspan=8 style="border-bottom: 1px solid #ccc;">
					<input name="Proveedor" 	 	type="text" size="100" maxlength="100" list="prov" value="<?php echo $Proveedor; ?>" required />
					<datalist id="prov">
						<?php
							$link=Conectarse();
							$bdProv=$link->query("SELECT * FROM Proveedores");
							if($row=mysqli_fetch_array($bdProv)){
								do{?>
									<option value="<?php echo $row['Proveedor']; ?>">
									<?php
								}while ($row=mysqli_fetch_array($bdProv));
							}
						?>
					</datalist>
					<input name="Proceso"  			type="hidden" value="<?php echo $Proceso; ?>">
					<input name="nGasto"  			type="hidden" value="<?php echo $nGasto; ?>">
				</td>
			</tr>
			</tr>
				<td>N° Factura					</td>
				<td>Fecha						</td>
				<td>Producto y/o servicio adquirido	</td>
				<td>Efectivo					</td>
				<td>Exento						</td>
				<td>Neto						</td>
				<td>IVA							</td>
				<td>Bruto						</td>
			</tr>
			<tr>
				<td>
					<input name="nDoc" 				type="text" 	size="10" maxlength="10" value="<?php echo $nDoc; ?>" required />
				</td>
				<td>
					<input name="FechaGasto"		type="date" 	size="8" maxlength="8" value="<?php echo $FechaGasto; ?>" required />
					<input name="Hora"				type="hidden" 	size="10" maxlength="10" value="<?php echo $Hora; ?>">
				</td>
				<td>
					<input name="Bien_Servicio" class="form-control" 		type="text" 	size="30" maxlength="100" value="<?php echo $Bien_Servicio; ?>" required />
					<?php if($Concepto){ ?>
							<br>Concepto <br>
							<input name="Concepto" 		type="text" size="30" maxlength="100" value="<?php echo $Concepto; ?>" required />
							<input name="nInforme" 		type="hidden"  value="<?php echo $nInforme; ?>">
					<?php } ?>
				</td>
				<td>
					<?php 
						echo $efectivo;
						if($efectivo == 'on'){ ?>
						<input type="checkbox" value='off' name="efectivo" checked>
					<?php }else{ ?>
						<input type="checkbox" value='on' name="efectivo">
					<?php } ?>
				</td>

				<td>
					<?php 
						echo $exento;
						if($exento == 'on'){ ?>
						<input type="checkbox" name="exento" checked>
					<?php }else{ ?>
						<input type="checkbox" name="exento">
					<?php } ?>
				</td>
				<td>
					<input name="Neto" id="Neto"	type="text" size="7" maxlength="10" value="<?php echo $Neto; ?>" required />
				</td>
				<td>
					<input name="Iva" 				type="text" size="7" maxlength="10" value="<?php echo $Iva; ?>">
				</td>
				<td>
					<input name="Bruto" 			type="text" size="7" maxlength="10" value="<?php echo $Bruto; ?>">
				</td>
			</tr>
		</table>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
			<tr>
				<td id="CajaOpc">
					Items de Gastos
				</td>
				<td id="CajaOpc">
					Tipo de Gastos
				</td>
				<td id="CajaOpc">
					Cuenta de Cargo
				</td>
				<td id="CajaOpc">
					Proyectos
				</td>
			</tr>
			<tr>
				<td id="CajaOpcDatos" valign="top">
					<?php
						$link=Conectarse();
						$bdIt=$link->query("SELECT * FROM ItemsGastos Order By nItem");
						if ($row=mysqli_fetch_array($bdIt)){
							do{
								if(isset($Items)){
									if($Items==$row['Items']){ ?>
										<input type="radio" name="Items" value="<?php echo $row['Items']; ?>" checked>	<?php echo $row['Items']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="Items" value="<?php echo $row['Items']; ?>">			<?php echo $row['Items']; ?><br>
									<?php }
								}else{ ?>
									<input type="radio" 	name="Items" value="<?php echo $row['Items']; ?>" required />			<?php echo $row['Items']; ?><br>
									<?php
								}
							}while ($row=mysqli_fetch_array($bdIt));
						}
						$link->close();
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php
						$link=Conectarse();
						$bdTpGto=$link->query("SELECT * FROM TipoGasto Where Estado = 'on' Order By IdGasto");
						if ($row=mysqli_fetch_array($bdTpGto)){
							do{
								if(isset($TpGasto)){
									if($TpGasto==$row['TpGasto']){?>
										<input type="radio" name="TpGasto" value="<?php echo $row['TpGasto']; ?>" checked>	<?php echo $row['TpGasto']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="TpGasto" value="<?php echo $row['TpGasto']; ?>">			<?php echo $row['TpGasto']; ?><br>
										<?php
									}
								}else{ ?>
									<input type="radio" 	name="TpGasto" value="<?php echo $row['TpGasto']; ?>" required />			<?php echo $row['TpGasto']; ?><br>
									<?php
								}
							}while($row=mysqli_fetch_array($bdTpGto));
						}
						$link->close();
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php 
						$link=Conectarse();
						$bdRec=$link->query("SELECT * FROM Recursos  Where Estado = 'on' Order By nPos");
						if ($row=mysqli_fetch_array($bdRec)){
							do{
								if(isset($Recurso)){
									if($Recurso==$row['Recurso']){ ?>
										<input type="radio" name="Recurso" value="<?php echo $row['Recurso']; ?>" checked>	<?php echo $row['Recurso']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="Recurso" value="<?php echo $row['Recurso']; ?>">			<?php echo $row['Recurso']; ?><br>
										<?php
									}
								}else{ ?>
									<input type="radio" 	name="Recurso" value="<?php echo $row['Recurso']; ?>" required />			<?php echo $row['Recurso']; ?><br>
									<?php
								}
							}while($row=mysqli_fetch_array($bdRec));
						}
						$link->close();
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php 
						$link=Conectarse();
						$bdPr=$link->query("SELECT * FROM Proyectos Order By IdProyecto");
						if ($row=mysqli_fetch_array($bdPr)){
							do{
								if(isset($IdProyecto)){
									if($IdProyecto==$row['IdProyecto']){ ?>
										<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>" checked><?php echo $row['IdProyecto']; ?><br>
									<?php }else{ ?>
										<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>">		<?php echo $row['IdProyecto']; ?><br>
										<?php
									}
								}else{ ?>
									<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto'];?>" required />				<?php echo $row['IdProyecto']; ?><br>
									<?php 
								}
							}while($row=mysqli_fetch_array($bdPr));
						}
						$link->close();
					?>
				</td>
			</tr>
		</table>
		<div style="border:1px solid #ccc; padding:5px; background-color:#ccc;">
			Calificación de Proveedores de 1 a 5
		</div>
		<table border=1 cellspacing="0" cellpadding="0" style="width: 100%;font-family: Arial;">
			<tr>
				<td style="padding: 5px;">
					Costo
				</td>
				<td style="padding: 5px;">
					Calidad
				</td>
				<td style="padding: 5px;">
					Preventa
				</td>
				<td style="padding: 5px;">
					Postventa
				</td>
			</tr>
			<tr>
				<td style="padding: 5px;">
					<select name="CalCosto">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalCosto == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
				<td style="padding: 5px;">
					<select name="CalCalidad">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalCalidad == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
				<td style="padding: 5px;">
					<select name="CalPreVenta">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalPreVenta == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
				<td style="padding: 5px;">
					<select name="CalPostVenta">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalPostVenta == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
			</tr>
		</table>
		
	<?php
}

function despliegaFormularioFacturaSueldo($nGasto){
	$Proveedor 		= '';
	$RutProv		= '';
	$Proceso		= $_GET['Proceso'];
	$nFactura		= '';
	$FechaFactura	= date('Y-m-d');
	$Descripcion	= '';
	$Bruto			= 0;
	$Concepto		= '';
	$nInforme		= '';
	$exento			= '';
	$Bruto			= 0;
	$TpCosto		= 'M';
	$IdAutoriza		= '';
	$CalCosto		= 0;
	$CalCalidad		= 0;
	$CalPreVenta	= 0;
	$CalPostVenta	= 0;

	if($nGasto){
		$link=Conectarse();
		$bdGas=$link->query("SELECT * FROM Facturas WHERE nMov = '".$nGasto."'");
		if ($row=mysqli_fetch_array($bdGas)){
   			
			$CalCosto 		= $row['CalCosto'];
   			$CalCalidad 	= $row['CalCalidad'];
   			$CalPreVenta	= $row['CalPreVenta'];
   			$CalPostVenta	= $row['CalPostVenta'];
			
   			$FechaFactura 	= $row['FechaFactura'];
   			$nFactura  		= $row['nFactura'];
   			$RutProv  		= $row['RutProv'];
			$Descripcion	= $row['Descripcion'];
			$Bruto			= $row['Bruto'];
			$TpCosto		= $row['TpCosto'];
			
			$nInforme 		= $row['nInforme'];
			
			if($nInforme) {
				$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."'");
				if ($rowForm=mysqli_fetch_array($bdForm)){
					$Concepto = $rowForm['Concepto'];
				}
			}
			$bdPr=$link->query("SELECT * FROM Proveedores WHERE RutProv = '".$RutProv."'");
			if ($rowPr=mysqli_fetch_array($bdPr)){
				$Proveedor = $rowPr['Proveedor'];
			}
						
			$IdProyecto 	= $row['IdProyecto'];
			$IdAutoriza 	= $row['IdAutoriza'];
		}
		$link->close();
		if(isset($_GET['Proceso']) == 3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}
	
	?>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="RegistroDeGasto">
			<tr>
				<td colspan=8>Proveedor</td>
			</tr>
			<tr>
				<td colspan=8 style="border-bottom: 1px solid #ccc;">
					<input name="Proveedor" 	 	type="text" size="100" maxlength="100" list="prov" value="<?php echo $Proveedor; ?>" required />
					<datalist id="prov">
						<?php
							$link=Conectarse();
							$bdProv=$link->query("SELECT * FROM Proveedores");
							if($row=mysqli_fetch_array($bdProv)){
								do{?>
									<option value="<?php echo $row['Proveedor']; ?>">
									<?php
								}while ($row=mysqli_fetch_array($bdProv));
							}
						?>
					</datalist>
					<input name="Proceso"  			type="hidden" value="<?php echo $Proceso; ?>">
					<input name="nGasto"  			type="hidden" value="<?php echo $nGasto; ?>">
				</td>
			</tr>
			</tr>
				<td>N° Factura					</td>
				<td>Fecha						</td>
				<td>Producto y/o servicio adquirido</td>
				<td>Efectivo					</td>
				<td>Exento						</td>
				<td>Bruto						</td>
			</tr>
			<tr>
				<td>
					<input name="nFactura" 			type="text" 	size="10" maxlength="10" value="<?php echo $nFactura; ?>" required />
				</td>
				<td>
					<input name="FechaFactura"		type="date" 	size="8" maxlength="8" value="<?php echo $FechaFactura; ?>" required />
				</td>
				<td>
					<input name="Descripcion" class="form-control" 		type="text" 	size="30" maxlength="100" value="<?php echo $Descripcion; ?>" required />
					<?php if($Concepto){ ?>
							<br>Concepto <br>
							<input name="Concepto" class="form-control" 		type="text" size="30" maxlength="100" value="<?php echo $Concepto; ?>" required />
							<input name="nInforme" 		type="hidden"  value="<?php echo $nInforme; ?>">
					<?php } ?>
				</td>
				<td>
					<?php 
						$efectivo = '';
						if($efectivo == 'on'){ ?>
						<input type="checkbox" name="efectivo" checked>
					<?php }else{ ?>
						<input type="checkbox" name="efectivo">
					<?php } ?>
				</td>

				<td>
					<?php 
						$exento = 'on';
						if($exento == 'on'){ ?>
						<input type="checkbox" name="exento" checked>
					<?php }else{ ?>
						<input type="checkbox" name="exento">
					<?php } ?>
				</td>
				<td>
					<input name="Bruto" 			type="text" size="7" maxlength="10" value="<?php echo $Bruto; ?>" required />
				</td>
			</tr>
		</table>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
			<tr>
				<td id="CajaOpc">
					Costo
				</td>
				<td id="CajaOpc">
					Proyectos
				</td>
				<td id="CajaOpc">
					Autoriza
				</td>
			</tr>
			<tr>
				<td id="CajaOpcDatos" valign="top">
					<?php
						if($TpCosto=='M'){?>
							<input type="radio" name="TpCosto" value="M" checked required />Mensual<br>
							<input type="radio" name="TpCosto" value="E" 		 required />Esporadico<br>
							<input type="radio" name="TpCosto" value="I" 		 required />Inversión<br>
							<?php
						}
						if($TpCosto=='E'){?>
							<input type="radio" name="TpCosto" value="M" 		 required />Mensual<br>
							<input type="radio" name="TpCosto" value="E" checked required />Esporadico<br>
							<input type="radio" name="TpCosto" value="I" 		 required />Inversión<br>
							<?php
						}
						if($TpCosto=='I'){?>
							<input type="radio" name="TpCosto" value="M" 		 required />Mensual<br>
							<input type="radio" name="TpCosto" value="E" 		 required />Esporadico<br>
							<input type="radio" name="TpCosto" value="I" checked required />Inversión<br>
							<?php
						}
						if($TpCosto==''){?>
							<input type="radio" name="TpCosto" value="M" checked required />Mensual<br>
							<input type="radio" name="TpCosto" value="E" 		 required />Esporadico<br>
							<input type="radio" name="TpCosto" value="I" 		 required />Inversión<br>
							<?php
						}
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php
						$link=Conectarse();
						$bdPr=$link->query("SELECT * FROM Proyectos Order By IdProyecto");
						if($row=mysqli_fetch_array($bdPr)){
							do{
								if(isset($IdProyecto)){
									if($IdProyecto==$row['IdProyecto']){?>
										<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>" checked><?php echo $row['IdProyecto']; ?><br>
										<?php
									}else{?>
										<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>"><?php echo $row['IdProyecto']; ?><br>
										<?php
									}
								}else{?>
									<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>" required /><?php echo $row['IdProyecto']; ?><br>
									<?php
								}
							}while($row=mysqli_fetch_array($bdPr));
						}
						$link->close();
					?>
				</td>
				<td id="CajaOpcDatos" valign="top">
					<?php
						$link=Conectarse();
						$bdAu=$link->query("SELECT * FROM Autoriza");
						if($row=mysqli_fetch_array($bdAu)){
							do{
								if(isset($IdAutoriza)){
									if($IdAutoriza==$row['IdAutoriza']){?>
										<input type="radio" name="IdAutoriza" value="<?php echo $row['IdAutoriza']; ?>" checked><?php echo $row['IdAutoriza']; ?><br>
										<?php
									}else{?>
										<input type="radio" name="IdAutoriza" value="<?php echo $row['IdAutoriza']; ?>"><?php echo $row['IdAutoriza']; ?><br>
										<?php
									}
								}else{?>
									<input type="radio" name="IdAutoriza" value="<?php echo $row['IdAutoriza']; ?>" required /><?php echo $row['IdAutoriza']; ?><br>
									<?php
								}
							}while($row=mysqli_fetch_array($bdAu));
						}
						$link->close();
					?>
				</td>
			</tr>
		</table>
		<div style="border:1px solid #ccc; padding:5px; background-color:#ccc;">
			Calificación de Proveedores de 1 a 5
		</div>
		<table border=1 cellspacing="0" cellpadding="0" style="width: 100%;font-family: Arial;">
			<tr>
				<td style="padding: 5px;">
					Costo
				</td>
				<td style="padding: 5px;">
					Calidad
				</td>
				<td style="padding: 5px;">
					Preventa
				</td>
				<td style="padding: 5px;">
					Postventa
				</td>
			</tr>
			<tr>
				<td style="padding: 5px;">
					<select name="CalCosto">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalCosto == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
				<td style="padding: 5px;">
					<select name="CalCalidad">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalCalidad == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
				<td style="padding: 5px;">
					<select name="CalPreVenta">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalPreVenta == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
				<td style="padding: 5px;">
					<select name="CalPostVenta">
						<option></option>
						<?php
							for($i=1; $i<6; $i++){
								if($CalPostVenta == $i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
									<?php
								}else{?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
			</tr>
		</table>
	<?php
}
?>