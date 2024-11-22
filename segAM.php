<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("conexionli.php"); 
	$Rev 	  = 0;
	$Cliente  = '';
	$cFree	  = '';
	$Docencia = '';
	$nFactura = 0;
	$cColor	  = ''; 
	
	if(isset($_GET['CAM'])) 	{ $CAM 		= $_GET['CAM'];		}
	if(isset($_GET['RAM'])) 	{ $RAM 		= $_GET['RAM'];		}
	if(isset($_GET['Rev'])) 	{ $Rev 		= $_GET['Rev'];		}
	if(isset($_GET['Cta'])) 	{ $Cta 		= $_GET['Cta'];		}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}
	//$cColor = $accion;

	$Estado = '';
	$fechaCotizacion = date('Y-m-d');
	$encNew = 'Si';

	if($CAM == 0){
		$accion = 'Guardar';
		$Atencion = 'Seleccionar';
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$RAM 					= $rowCot['RAM'];
			$Rev 					= $rowCot['Rev'];
			$Cta 					= $rowCot['Cta'];
			$fechaCotizacion 		= $rowCot['fechaCotizacion'];
			$usrCotizador 			= $rowCot['usrCotizador'];
			$usrResponzable			= $rowCot['usrResponzable'];
			$Cliente 				= $rowCot['RutCli'];
			$nContacto 				= $rowCot['nContacto'];
			$Atencion 				= $rowCot['Atencion'];
			$correoAtencion 		= $rowCot['correoAtencion'];
			$Descripcion			= $rowCot['Descripcion'];
			$EstadoCot				= $rowCot['Estado'];
			$Validez				= $rowCot['Validez'];
			$dHabiles				= $rowCot['dHabiles'];
			$oCompra				= $rowCot['oCompra'];
			$nOC					= $rowCot['nOC'];
			$HES					= $rowCot['HES'];
			$oMail					= $rowCot['oMail'];
			$oCtaCte				= $rowCot['oCtaCte'];
			$obsServicios			= $rowCot['obsServicios'];
			$Observacion			= $rowCot['Observacion'];
			$fechaAceptacion		= $rowCot['fechaAceptacion'];
			$proxRecordatorio		= $rowCot['proxRecordatorio'];
			$contactoRecordatorio	= $rowCot['contactoRecordatorio'];
			$informeUP				= $rowCot['informeUP'];
			$fechaInformeUP			= $rowCot['fechaInformeUP'];
			$Facturacion			= $rowCot['Facturacion'];
			$nFactura				= $rowCot['nFactura'];
			$fechaFacturacion		= $rowCot['fechaFacturacion'];
			$Archivo				= $rowCot['Archivo'];
			$fechaArchivo			= $rowCot['fechaArchivo'];
			if($usrResponzable == ''){
				$usrResponzable = $usrCotizador;
			}
		}
		$link->close();
		$fd = explode('-', $fechaAceptacion);
		if($fd[0] == 0 ){
			$fechaAceptacion = date('Y-m-d');
		}
		$encNew = 'No';
	}
?>
<!doctype html>
 
 <html lang="es">
 <head>
	<meta charset="utf-8">
   	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">


</head>

<!-- <body ng-app="myApp" ng-controller="ctrlErp" ng-cloak> -->
<body ng-app="myApp" ng-controller="ctrlCAM" ng-init="loadCAM('<?php echo $_GET['CAM']; ?>', '<?php echo $_GET['RAM']; ?>', '<?php echo $_GET['accion']; ?>' )">
	<div class="container-fluid mb-2 mt-2">
		<div class="row">
			<div class="col-sm-8">
				<div class="card">
					<div class="card-header {{bColor}}">
						<h5>Seguimiento AM CAM {{CAM}} - RAM {{RAM}}     (Ing. {{usrResponzable}})</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-2">
								<b>Cliente:</b>
							</div>
							<div class="col-sm-10">
								<h5 class="card-title">	<input type="text" class="form-control" ng-model="Cliente" readonly ></h5>
							</div>

							<div class="col-sm-2">
								<b>Atención:</b>
							</div>
							<div class="col-sm-10">
								<h5 class="card-title">	{{Contacto}} </h5>
							</div>

							<div class="col-sm-2 mt-2">
								Orden de Compra:
							</div>
							<div class="col-sm-3 mt-2">
								<input type="text" class="form-control" ng-model="nOC" ng-change="activarSubidaOC()" >
							</div>
							<div class="col-sm-2 mt-2" ng-show="activaUp">
								Documento :
							</div>
							<div class="col-sm-5 mt-2"  ng-show="activaUp">
								<input id="archivosSeguimiento" ng-model="archivosSeguimiento" multiple type="file"> {{archivosSeguimiento}}
							</div> 
							
							
							
							<div ng-show="clienteHES">
								<div class="row">
									<div class="col-sm-2 mt-2">
										HES: 
									</div>
									<div class="col-sm-3 mt-2">
										<input type="text" class="form-control" ng-model="HES" ng-change="activarSubidaHES()" >
									</div>
									<div class="col-sm-2 mt-2" ng-show="activaHes">
										Documento :
									</div>
									<div class="col-sm-5 mt-2"  ng-show="activaHes"> 
										<input id="archivosSeguimientoHES" ng-model="archivosSeguimientoHES" multiple type="file"> {{archivosSeguimientoHES}}
									</div> 
								</div>
							</div>

							<hr class="mt-2">
							<div class="col-sm-2 mt-2">
								Estado Informe:
							</div>
							<div class="col-sm-5 mt-2">
								<div ng-show="informeUP == 'on'">
									<b>Informe Subido</b>
								</div>
							</div>
							<div class="col-sm-2 mt-2">
								Fecha :
							</div>
							<div class="col-sm-3 mt-2">
								<input type="date" class="form-control" ng-model="fechaInformeUP" >
							</div>

							<div class="col-sm-2 mt-2">
								Tipo CAM:
							</div>
							<div class="col-sm-5 mt-2">
								<div ng-show="Fan > 0">
									<b>CLON {{Fan}} de  RAM {{RAM}}</b>
								</div>
								<div ng-show="Fan == 0">
									<b>Cotización Base</b>
								</div>
							</div>

						</div>
					</div>
					<div class="card-footer">
						<a href="#" ng-click="guardarSeguimientoRosado()" class="btn btn-primary">Guardar Seguimiento</a>
						<a href="#" ng-if="cColor == 'Amarillo'" ng-click="retocederSeguimientoRosado()" class="btn btn-danger">Retroceder AM a paso Anterior</a>
						<a href="#" ng-if="cColor == 'Rosado'" ng-click="retocederATerminadosSinInforme()" class="btn btn-danger">Retroceder AM Informes No Subidos</a>
						<a href="plataformaErp.php" class="btn btn-primary">Volver</a>
					</div>
					</div>
				</div>
			<div class="col-sm-4">


				<div class="card">
					<div class="card-header {{bColor}}">
						<b>Ordenes de Compras Subidas</b>
					</div>

					<?php 

					$tr = "bVerde";
					$agnoActual = date('Y'); 
					$ruta = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp'; 
					$ruta = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp'; 
					$muestraCAM = 'SI';

					$gestorDir = opendir($ruta);
					while(false !== ($nombreDir = readdir($gestorDir))){
						if($nombreDir != '.' and $nombreDir != '..'){
							$fd = explode('-', $nombreDir);
							if(count($fd) > 1){
								$fd = explode('.', $fd[1]);
							}
							//echo $fd[1].'<br>';
							// echo $fd[0].' '.$_GET['CAM'].'<br>';
							if($fd[0] ==  $_GET['CAM']){
								// echo $ruta.'/'.$nombreDir.' ';
								// echo '/tmp/'.$nombreDir;
								if(file_exists($ruta)){
									copy($ruta.'/'.$nombreDir, 'tmp/'.$nombreDir);
								} 

								?>
								{{existeOC()}}
								<?php 
								if($muestraCAM == 'SI'){?>
									<div class="row">
										<div class="col-sm-4 m-1">
											<a style="margin-top: 5px;" class="btn btn-warning" role="button" href="procesosangular/formularios/iCAM.php?CAM={{CAM}}&Rev=0&Cta=0&accion=Reimprime" title="Imprimir Cotización"><i class="far fa-file-pdf"></i>CAM {{CAM}}</a>
										</div>
									</div>
									<?php 
									$muestraCAM = 'NO';
								}
								?>
								<div class="row">
									<div class="col-sm-4 m-1">
										<a href="<?php echo 'tmp/'.$nombreDir; ?>" class="btn btn-primary  btn-block" target="_blank" role="button">
											<b><?php echo $nombreDir; ?></b>
										</a>
									</div>
								</div>
							<?php
							}
							
						}
					}

					?>

				</div>



			</div>
		</div> 

	</div>



	<!-- <div id="bloqueoTrasperente">
		<div id="cajaRegistraPruebas">
			<center>
			<form name="form" action="plataformaErp.php" method="post">
			<table width="75%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="imagenes/tpv.png" width="50">
						<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
							SEGUIMIENTO {{5+5}}
							<?php 
								if($Rev<10){
									$Revision = '0'.$Rev;
								}else{
									$Revision = $Rev; 
								}
								echo 'AM-'.$CAM.'-'.$Revision.'-'.$Cta.' ('.$accion.')';
							?>
							<div id="botonImagen">
								<?php 
									$prgLink = 'plataformaErp.php';
									if($accion=="Actualiza") { $prgLink = 'modCotizacion.php?CAM='.$CAM.'&Rev='.$Rev.'&Cta='.$Cta; }; 
									if($accion=="Borrar") 	 { $prgLink = 'plataformaErp.php'; }; 
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="imagenes/no_32.png"></a>';
								?>
							</div>
						</span>
					</td>
				</tr>
				<tr>
				<td colspan="4" class="lineaDerBot">
					<strong style="font-size:20px; font-weight:700; margin-left:10px;">
						CAM-
						<input name="CAM" 	 			id="CAM" 	 			type="text"   value="<?php echo $CAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
						<input name="RAM" 	 			id="RAM" 	 			type="text"   value="<?php echo $RAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
						<input name="accion" 			id="accion" 			type="hidden" value="<?php echo $accion; ?>"			/>
						<input name="Cta"   			id="Cta" 	 			type="hidden" value="<?php echo $Cta; ?>"  				/>
						<input name="Rev"   			id="Rev" 	 			type="hidden" value="<?php echo $Rev; ?>" 				/>
						<?php
							echo 'Rev. <span class="vizualizacion">'.$Revision.'</span>';
						?>
					</strong>
				</td>
			</tr>
				<tr>
					<td height="27" colspan="2" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Empresa / Cliente </td>
					<td width="43%" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Atenci&oacute;n:</td>
					<td width="20%" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">ORDEN DE COMPRA</td>
				</tr>
				<tr>
					<td height="30" colspan="2" class="lineaDerBot">
						<span>					</span>
						<?php
							$cliFree = '';
							$HEScli = 'off';
							$link=Conectarse();
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$Cliente."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo '<span style="font-size:14px; font-weight:700;">'.$rowCli['Cliente'].'</span>';
								$cFree 		= $rowCli['cFree'];
								$Docencia 	= $rowCli['Docencia'];
								$HEScli 	= $rowCli['HES'];
								if($Docencia == 'on'){
									$cliFree = 'on';
								}
								if($cFree == 'on'){
									$cliFree = 'on';
								}
							}
							$link->close();
						?>
					</td>
					<td class="lineaDerBot"><?php echo '<span style="font-size:14px; font-weight:700;">'.$Atencion.'</span>'; ?></td>
					<td class="lineaDerBot">
						<div class="form-group">
							<label for="nOC">Orden de Compra:</label>
							<input type="text" name="nOC" class="form-control" id="nOC" value="<?php echo $nOC; ?>">
						</div>
						<?php
							if($HEScli == 'on'){?>
								<div class="form-group">
									<label for="HES">HES:</label>
									<input type="text" name="HES" class="form-control" id="HES" value="<?php echo $HES; ?>">
								</div>
								<?php
							}
						?>
					</td>
				</tr>
				<tr>
					<td height="32" colspan="4" bgcolor="#0099CC" class="lineaDerBot Estilo1">Situaci&oacute;n / Seguimiento </td>
				</tr>
				<?php 
					if($informeUP == 'on'){?>
					<tr>
					<td width="22%" height="29" valign="top" class="lineaDerBot"><strong>Informe Subido </strong></td>
					<td valign="top"  class="lineaDerBot">
							<?php if($informeUP == 'on'){?>
								<?php if($Facturacion == 'on'){?>
									<input name="informeUP"   		id="informeUP" 			type="hidden" value="<?php echo $informeUP; ?>">
									<img src="imagenes/printing.png" width="20">
								<?php }else{ ?>
									<input type="checkbox" name="informeUP" id="informeUP" checked />
								<?php } ?>
							<?php } ?>
					</td>
					<td valign="top"  class="lineaDerBot">
						<?php if($informeUP == 'on' and $Facturacion == 'on'){?>
							<input name="fechaInformeUP" 	id="fechaInformeUP" type="hidden"  value="<?php echo $fechaInformeUP; ?>" style="font-size:12px; font-weight:700;" />
							<?php 
								$fdUp = explode('-',$fechaInformeUP);
								echo $fdUp[2].'-'.$fdUp[1].'-'.$fdUp[0];
							?>
						<?php }else{ ?>
							<input name="fechaInformeUP" 	id="fechaInformeUP" type="date"  value="<?php echo $fechaInformeUP; ?>" style="font-size:12px; font-weight:700;" autofocus />
						<?php } ?>
					</td>
					</tr>
				<?php } ?>
				<?php if($informeUP == 'on' and $Facturacion == 'on'){?>
					<tr>
					<td height="25" valign="top" class="lineaDerBot"><strong>Facturación</strong></td>
					<td width="13%" valign="top" class="lineaDerBot">
							<?php 	
							//echo 'Informe Up '.$informeUP;
							//echo '<br>Facturacion '.$Facturacion.'<br>';
							?>
						<?php if($informeUP == 'on'){?>
							<?php if($Facturacion == 'on'){?>
									<input type="checkbox" name="Facturacion" id="Facturacion" checked>
							<?php }else{?>
									<input type="checkbox" name="Facturacion" id="Facturacion">
							<?php } ?>
						<?php } ?>
					</td>
					<td valign="top" class="lineaDerBot">
						<?php if($informeUP == 'on'){?>
							<input name="fechaFacturacion" 	id="fechaFacturacion" type="date"  value="<?php echo $fechaFacturacion; ?>" style="font-size:12px; font-weight:700;" autofocus />
									<?php
										$CodInforme 	= 'AM-'.$RAM;
										$nSolicitud		= 0;
										$link=Conectarse();
										$bdSol=$link->query("SELECT * FROM SolFactura Where cotizacionesCAM Like '%".$CAM."%'");
										if($rowSol=mysqli_fetch_array($bdSol)){
											$nFactura = $rowSol['nFactura'];
											echo ' Solicitud: '.$rowSol['nSolicitud'];
											$nSolicitud = $rowSol['nSolicitud'];
											if($rowSol['Factura'] == 'on'){
												echo ' Factura: '.$rowSol['nFactura'];
											}
										}else{
											$bdSol=$link->query("SELECT * FROM SolFactura Where informesAM Like '%".$RAM."%'");
											if($rowSol=mysqli_fetch_array($bdSol)){
												$nFactura = $rowSol['nFactura'];
												echo ' Solicitud: '.$rowSol['nSolicitud'];
												$nSolicitud = $rowSol['nSolicitud'];
												if($rowSol['Factura'] == 'on'){
													echo ' Factura: '.$rowSol['nFactura'];
												}
											}
										}
										$link->close();
									?>
						<?php }else{
							echo 'No hay ningún informe subido para esta RAM... ';
						} ?>
						<input name="nSolicitud" 	id="nSolicitud" type="hidden"  value="<?php echo $nSolicitud; ?>" />
					</td>
					</tr>
				<?php } ?>
				<?php
					if($nFactura > 0){
				?>
				<tr>
					<td height="25" valign="top" class="lineaDerBot"><strong>Archivar</strong></td>
					<td height="25" valign="top" class="lineaDerBot">
						
						<?php 
							if($informeUP == 'on' and $Facturacion == 'on'){
								if($Archivo=='on'){?>
									<input type="checkbox" name="Archivo" id="Archivo" checked>
								<?php }else{?>
									<input type="checkbox" name="Archivo" id="Archivo">
									<?php 
								}
							} 
						?>
					</td>
					<td height="25" valign="top" class="lineaDerBot">
						<?php 
							if($informeUP == 'on' and $Facturacion=='on'){ ?>
								<input name="fechaArchivo" 	id="fechaArchivo" type="date"  value="<?php echo $fechaArchivo; ?>" style="font-size:12px; font-weight:700;" autofocus />
								<?php 
							}else{
								echo 'Debe Facturar para poder Archivar trabajo...';
							}
						?>
					</td>
				</tr>
				<?php
					}
				?>
				<tr>
					<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
						<?php
							//echo $accion;
							if($accion == 'SeguimientoAM'){?>
								<div id="botonImagen">
									<button name="guardarSeguimientoAM" style="float:right;" title="Guardar Seguimiento">
										<img src="gastos/imagenes/guardar.png" width="55" height="55">
									</button>
								</div>
								<?php
							}
						?>
					</td> 
				</tr>
			</table>
			</form>
			</center>
		</div>
	</div> -->

	<script type="text/javascript" src="angular/angular.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="erp.js"></script>

</body>
</html>
