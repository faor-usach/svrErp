<?php
		$nInforme = 0;
		$Reembolso = '';
		if(isset($_GET['nInforme']))  { $nInforme   = $_GET['nInforme']; 	}
		if(isset($_POST['nInforme'])) { $nInforme  = $_POST['nInforme']; }

		if(isset($_POST['Guardar'])){
			if(isset($_POST['nSolicitud'])) 	 { $nSolicitud   	= $_POST['nSolicitud']; 	}
			if(isset($_POST['RutCli'])) 	 	 { $RutCli   		= $_POST['RutCli']; 		}

			if(isset($_POST['Fotocopia'])) 	 { 
				$Fotocopia   	= $_POST['Fotocopia']; 		
				if(isset($_POST['fechaFotocopia'])) { $fechaFotocopia  = $_POST['fechaFotocopia']; }
			}else{
				$fechaFotocopia  = "0000-00-00";
			}

			if(isset($_POST['Reembolso'])) 	 { 
				$Reembolso   	= $_POST['Reembolso']; 		
				if(isset($_POST['fechaReembolso'])) { $fechaReembolso  = $_POST['fechaReembolso']; }
			}else{
				$fechaReembolso  	= "0000-00-00";
			}
			
			$link=Conectarse();
			$bdFac=$link->query("SELECT * FROM Formularios Where nInforme = '".$nInforme."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$actSQL="UPDATE Formularios SET ";
				$actSQL.="Fotocopia			='".$Fotocopia."',";
				$actSQL.="fechaFotocopia	='".$fechaFotocopia."',";
				$actSQL.="Reembolso			='".$Reembolso."',";
				$actSQL.="fechaReembolso	='".$fechaReembolso."'";
				$actSQL.="WHERE nInforme	= '".$nInforme."'";
				$bdFac=$link->query($actSQL);

				$actSQL="UPDATE MovGastos SET ";
				$actSQL.="Fotocopia			='".$Fotocopia."',";
				$actSQL.="fechaFotocopia	='".$fechaFotocopia."',";
				$actSQL.="Reembolso			='".$Reembolso."',";
				$actSQL.="fechaReembolso	='".$fechaReembolso."'";
				$actSQL.="WHERE nInforme	= '".$nInforme."'";
				$bdGtos=$link->query($actSQL);
			}
			$link->close();
		}
		$Formulario = '';		
		$link=Conectarse();
		$bdFm=$link->query("SELECT * FROM Formularios Where nInforme = '".$nInforme."'");
		if ($rowFm=mysqli_fetch_array($bdFm)){
			$Concepto 		= $rowFm['Concepto'];
			$Formulario		= $rowFm['Formulario'];

			$Fotocopia 		= $rowFm['Fotocopia'];
			$fechaFotocopia = $rowFm['fechaFotocopia'];

			$Reembolso 		= $rowFm['Reembolso'];
			$fechaReembolso	= $rowFm['fechaReembolso'];
		}
		$link->close();
?>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<form name="form" action="seguimientoGastos.php" method="post">
	<table width="60%"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<div id="CuerpoEncuesta">
					<div id="ImagenBarra">
						<a href="plataformaintranet.php" title="Cerrar">
							<img src="../gastos/imagenes/no_32.png" width="24" height="24">
						</a>
					</div>
					<div id="titulocaja">
						<img src="../gastos/imagenes/group_48.png" align="absmiddle">
						<strong style="font-size:20px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF;">
							Control de Seguimiento Gastos
						</strong>
					</div>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td colspan="5" align="center" class="txtGrandeSub">
								<?php 
									$tpPago = 'Solicitud de Reembolso';
									if(substr($Formulario,0,2) == 'F7'){
										$tpPago = 'Solicitud de Pago de Factura';
									}
									echo $tpPago.' '.$nInforme; 
								?>
								<br>
								<?php echo $Concepto; ?>
								<input type="hidden" name="nInforme" 	style="font-size:18px;" value="<?php echo $nInforme; ?>">
						</td>
					  </tr>
					  <tr>
						<td colspan="5"><hr></td>
					  </tr>
					  <tr>
						<td width="8%" align="center" class="numeroGrande">1</td>
						<td width="25%" class="txtGrande">
								Correo Enviado
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
						<td class="numeroGrande">3</td>
						<td class="txtGrande">Reembolso</td>
						<td align="center">
							<?php if($Reembolso == 'on'){ ?>
								<input name="Reembolso" type="checkbox" checked>
							<?php }else{ ?>
								<input name="Reembolso" type="checkbox">
							<?php } ?>
						</td>
						<td align="center">&nbsp;</td>
						<td>
							<input type="date" name="fechaReembolso"  style="font-size:18px;" value="<?php echo $fechaReembolso; ?>">
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