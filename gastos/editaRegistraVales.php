<?php
		if($_GET['nVale'])  	{ $nVale   = $_GET['nVale']; 	}
		if($_GET['Proceso']) 	{ $Proceso = $_GET['Proceso']; 	}
		
		if($Proceso == 1){
			$link=Conectarse();
			$result = $link->query('SELECT * FROM Vales');
			$nVale 		= $result->num_rows + 1;
			$fechaVale = date('Y-m-d');
			$link->close();
		}

		if(isset($_POST['Volver'])){
			header("Location: registraVales.php");
		}
		
		if(isset($_POST['Guardar'])){
			if($_POST['nVale'])  		{ $nVale   		= $_POST['nVale']; 		}
			if($_POST['Proceso']) 		{ $Proceso 		= $_POST['Proceso']; 	}
			
			if($_POST['fechaVale']) 	{ $fechaVale 	= $_POST['fechaVale']; 	}
			if($_POST['Descripcion']) 	{ $Descripcion 	= $_POST['Descripcion'];}
			if($_POST['Ingreso']) 		{ $Ingreso 		= $_POST['Ingreso'];	}
			if($_POST['Egreso']) 		{ $Egreso 		= $_POST['Egreso'];		}

			if($_POST['Reembolso']){ 
				$Reembolso   	= $_POST['Reembolso']; 
				if($_POST['fechaReembolso']) { $fechaReembolso  = $_POST['fechaReembolso']; }
			}else{
				$fechaReembolso  = "0000-00-00";
				$Reembolso 		 = '';
			}

			if($_POST['Deposito']){ 
				$Deposito   	= $_POST['Deposito']; 
				if($_POST['fechaDeposito']) { $fechaDeposito  = $_POST['fechaDeposito']; }
			}else{
				$fechaDeposito  = "0000-00-00";
				$Deposito 		 = '';
			}
			
			$link=Conectarse();
			$bdVa=$link->query("SELECT * FROM Vales Where nVale = '".$nVale."'");
			if ($rowVa=mysqli_fetch_array($bdVa)){
				$EgresoOld 		= $rowVa['Egreso'];
				$ReembolsoOld 	= $rowVa['Reembolso'];
				$actSQL="UPDATE Vales SET ";
				$actSQL.="fechaVale			='".$fechaVale."',";
				$actSQL.="Descripcion		='".$Descripcion."',";
				$actSQL.="Egreso			='".$Egreso."',";
				$actSQL.="Reembolso			='".$Reembolso."',";
				$actSQL.="fechaReembolso	='".$fechaReembolso."',";
				$actSQL.="Deposito			='".$Deposito."',";
				$actSQL.="fechaDeposito		='".$fechaDeposito."'";
				$actSQL.="WHERE nVale		= '".$nVale."'";
				$bdVa=$link->query($actSQL);

				if($Deposito <> 'on'){
					$bdRec=$link->query("SELECT * FROM Recursos Where IdRecurso = '1'");
					if($rowRec=mysqli_fetch_array($bdRec)){
						$IngresosRecursos 	= $rowRec['Ingreso'];
						$EgresosRecursos 	= $rowRec['Egreso'];
						$SaldoRecursos 		= $rowRec['Saldo'];
						
						if($ReembolsoOld=='on'){
							$EgresosRecursos 	+= $Egreso;
						}else{
							$EgresosRecursos 	-= $EgresoOld;
							$EgresosRecursos 	+= $Egreso;
		
							if($Reembolso=='on'){
								$EgresosRecursos 	-= $Egreso;
							}
						}
						
						$SaldoRecursos		= $IngresosRecursos - $EgresosRecursos;
						$actSQL="UPDATE Recursos SET ";
						$actSQL.="Egreso			='".$EgresosRecursos."',";
						$actSQL.="Saldo				='".$SaldoRecursos."'";
						$actSQL.="WHERE IdRecurso	= '1'";
						$bdVa=$link->query($actSQL);
						
					}
				}
			}else{
				$Proceso = 2;
				$link->query("insert into Vales	(	nVale,
													fechaVale,
													Descripcion,
													Egreso,
													Reembolso,
													fechaReembolso
												) 
										values 	(	'$nVale',
													'$fechaVale',
													'$Descripcion',
													'$Egreso',
													'$Reembolso',
													'$fechaReembolso'
				)");
				$bdRec=$link->query("SELECT * FROM Recursos Where IdRecurso = '1'");
				if($rowRec=mysqli_fetch_array($bdRec)){
					$IngresosRecursos 	= $rowRec['Ingreso'];
					$EgresosRecursos 	= $rowRec['Egreso'];
					$SaldoRecursos 		= $rowRec['Saldo'];
					$EgresosRecursos 	+= $Egreso;
					$SaldoRecursos		= $IngresosRecursos - $EgresosRecursos;
					$actSQL="UPDATE Recursos SET ";
					$actSQL.="Egreso			='".$EgresosRecursos."',";
					$actSQL.="Saldo				='".$SaldoRecursos."'";
					$actSQL.="WHERE IdRecurso	= '1'";
					$bdVa=$link->query($actSQL);
				}
			}
			$link->close();
		}
		
		$link=Conectarse();
		$bdVa=$link->query("SELECT * FROM Vales Where nVale = '".$nVale."'");
		if ($rowVa=mysqli_fetch_array($bdVa)){
			$fechaVale 		= $rowVa['fechaVale'];
			$Descripcion	= $rowVa['Descripcion'];
			$Egreso			= $rowVa['Egreso'];

			$Reembolso 		= $rowVa['Reembolso'];
			$fechaReembolso	= $rowVa['fechaReembolso'];

			$Deposito 		= $rowVa['Deposito'];
			$fechaDeposito	= $rowVa['fechaDeposito'];
		}
		$link->close();
?>
<form name="form" action="vales.php" method="post">
	<table width="60%"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<div id="CuerpoEncuesta">
					<div id="ImagenBarra">
						<a href="registraVales.php" title="Cerrar">
							<img src="../gastos/imagenes/no_32.png" width="24" height="24">
						</a>
					</div>
					<div id="titulocaja">
						<?php 
						if($Proceso==1){
							echo '<img src="../gastos/imagenes/AgregarVale.png" align="absmiddle" width="50" height="50">';
						}
						if($Proceso==2){
							echo '<img src="../gastos/imagenes/blank_128.png" align="absmiddle" width="50" height="50">';
						}
						?>
						<strong style="font-size:20px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF;">
							Control de Vales
						</strong>
					</div>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
						<tr>
							<td colspan="5" align="center" class="txtGrandeSub">
								Vale N° <?php echo $nVale; ?><br>
								<?php echo $Descripcion; ?>
								<input type="hidden" name="nVale" 	value="<?php echo $nVale; ?>">
								<input type="hidden" name="Proceso" value="<?php echo $Proceso; ?>">
							</td>
					  	</tr>
					  	<tr>
							<td colspan="5"><hr></td>
					  	</tr>
					  	<tr>
							<td width="8%" align="center" class="numeroGrande">&nbsp;</td>
							<td width="25%" class="txtGrande">
								Fecha Vale
							</td>
							<td width="15%" align="center">
								<input type="date" name="fechaVale" style="font-size:18px;" value="<?php echo $fechaVale; ?>">
							</td>
							<td width="15%" align="center">&nbsp;</td>
							<td width="37%">
							</td>
					  	</tr>
					  	<tr>
							<td colspan="5"><hr></td>
					  	</tr>
					  	<tr>
							<td width="8%" align="center" class="numeroGrande">&nbsp;</td>
							<td width="25%" class="txtGrande">
								Descripción
							</td>
							<td colspan="3">
                              	<textarea name="Descripcion" cols="50" rows="5"><?php echo $Descripcion; ?></textarea>
							</td>
						</tr>
					  	<tr>
							<td width="8%" align="center" class="numeroGrande">&nbsp;</td>
							<td width="25%" class="txtGrande">
								Monto Vale
							</td>
							<td colspan="3">
								<input type="text" name="Egreso" style="font-size:18px;" size="10" maxlength="10" value="<?php echo $Egreso; ?>">
							</td>
						</tr>
						<tr>
							<td colspan="5"><hr></td>
						</tr>
						<?php
						if($Proceso > 1){?>
							<tr>
								<td class="numeroGrande">&nbsp;</td>
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
								<td class="numeroGrande">&nbsp;</td>
								<td class="txtGrande">Deposito</td>
								<td align="center">
									<?php if($Deposito == 'on'){ ?>
										<input name="Deposito" type="checkbox" checked>
									<?php }else{ ?>
										<input name="Deposito" type="checkbox">
									<?php } ?>
								</td>
								<td align="center">&nbsp;</td>
								<td>
									<input type="date" name="fechaDeposito"  style="font-size:18px;" value="<?php echo $fechaDeposito; ?>">
								</td>
							</tr>
						<?php
						}
						?>
					  	<tr>
							<td colspan="5" class="txtGrandeSub" align="right">
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