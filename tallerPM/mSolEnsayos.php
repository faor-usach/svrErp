﻿<?php
	include_once("../conexionli.php");

	if(isset($_GET['CAM']))  		{ $CAM		= $_GET['CAM']; 	} 
	if(isset($_GET['RAM']))  		{ $RAM		= $_GET['RAM']; 	}
	if(isset($_GET['dBuscar']))  	{ $dBuscar  = $_GET['dBuscar']; }
	if(isset($_GET['accion']))  	{ $accion	= $_GET['accion']; 	}
?>
<div class="row bg-info text-white text-center" style="padding: 10px;">
	<?php
		$link=Conectarse();
		$SQLe = "SELECT * FROM amensayos Order By nEns Asc";
		$bde=$link->query($SQLe);
		while($rowe=mysqli_fetch_array($bde)){
			if($rowe['idEnsayo'] == 'Qu' or $rowe['idEnsayo'] == 'Tr' or $rowe['idEnsayo'] == 'Do' or $rowe['idEnsayo'] == 'Du' or $rowe['idEnsayo'] == 'Ch'){?>

				<div class="col">
					<h5><?php echo $rowe['Ensayo']; ?></h5>
				</div>

				<?php
			}
		}
		$link->close();
	?>
</div>

<div class="row bg-light text-dark text-center" style="padding: 10px;">
	<?php
		$link=Conectarse();
		$SQLe = "SELECT * FROM amensayos Order By nEns Asc";
		//echo $SQLe;
		$bde=$link->query($SQLe);
		while($rowe=mysqli_fetch_array($bde)){
			if($rowe['idEnsayo'] == 'Qu' or $rowe['idEnsayo'] == 'Tr' or $rowe['idEnsayo'] == 'Do' or $rowe['idEnsayo'] == 'Du' or $rowe['idEnsayo'] == 'Ch'){?>

				<div class="col">
					<table class="table table-hover">
						<tbody>
							<?php
								$SQLc = "SELECT * FROM cotizaciones Where Estado = 'P'";	
								$bdc=$link->query($SQLc);
								while($rowc=mysqli_fetch_array($bdc)){

									// $SQLo = "SELECT * FROM OTAMs Where Estado != 'R' and CodInforme = '' and idEnsayo = '".$rowe['idEnsayo']."' Order By fechaCreaRegistro Asc";
									$SQLo = "SELECT * FROM OTAMs Where RAM = '".$rowc['RAM']."' and idEnsayo = '".$rowe['idEnsayo']."' Order By fechaCreaRegistro Asc";
									$bdo=$link->query($SQLo);
									while($rowo=mysqli_fetch_array($bdo)){
									

										$SQLm = "SELECT * FROM ammuestras Where idItem = '".$rowo['idItem']."' and conEnsayo != 'off'";
										$bdm=$link->query($SQLm);
										while($rowm=mysqli_fetch_array($bdm)){
	
											$boton = "btn btn-danger";
											if($rowe['idEnsayo'] == 'Tr'){
												$enlace = 'iTraccion.php?Otam='.$rowo['Otam'];
	
												$sqlTe = "SELECT * FROM amtabensayos Where idItem = '".$rowo['idItem']."' and idEnsayo = 'Tr'";
												$bdTe=$link->query($sqlTe);
												if($rowTe=mysqli_fetch_array($bdTe)){
												}
	
												$sqlCe = "SELECT * FROM regtraccion Where idItem = '".$rowo['Otam']."' and fechaRegistro = '0000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-warning";
												}

												$sqlCe = "SELECT * FROM regtraccion Where idItem = '".$rowo['Otam']."' and fechaRegistro != '0000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-info";
												}
	
											}
											if($rowe['idEnsayo'] == 'Qu'){
												$enlace = 'iQuimico.php?Otam='.$rowo['Otam'];
												$sqlTe = "SELECT * FROM amtabensayos Where idItem = '".$rowo['idItem']."' and idEnsayo = 'Qu'";
												$bdTe=$link->query($sqlTe);
												if($rowTe=mysqli_fetch_array($bdTe)){
												}
	
												// $sqlCe = "SELECT * FROM regquimico Where idItem = '".$rowo['Otam']."' and Temperatura > 0 and Humedad > 0";
												$sqlCe = "SELECT * FROM regquimico Where idItem = '".$rowo['Otam']."' and fechaRegistro = '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-warning";
													//$boton = "btn btn-success";
												}
	
												$sqlCe = "SELECT * FROM regquimico Where idItem = '".$rowo['Otam']."' and fechaRegistro != '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-info";
												}
	
											}
											if($rowe['idEnsayo'] == 'Do'){
												$enlace = 'iDoblado.php?Otam='.$rowo['Otam'];
	
												$sqlTe = "SELECT * FROM amtabensayos Where idItem = '".$rowo['idItem']."' and idEnsayo = 'Do'";
												$bdTe=$link->query($sqlTe);
												if($rowTe=mysqli_fetch_array($bdTe)){
												}

												$sqlCe = "SELECT * FROM regdobladosreal Where idItem = '".$rowo['Otam']."' and fechaRegistro = '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-warning";
													//$boton = "btn btn-success";
												}

												$sqlCe = "SELECT * FROM regdobladosreal Where idItem = '".$rowo['Otam']."' and fechaRegistro != '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-info";
												}

	
											}
											if($rowe['idEnsayo'] == 'Du'){
												if($rowo['tpMedicion'] == 'Medi'){
													$enlace = 'iDureza.php?Otam='.$rowo['Otam'].'&tpMedicion='.$rowo['tpMedicion'];
												}
												if($rowo['tpMedicion'] == 'Perf'){
													$enlace = 'iDureza.php?Otam='.$rowo['Otam'].'&tpMedicion='.$rowo['tpMedicion'];
												}
												
	
												$sqlTe = "SELECT * FROM amtabensayos Where idItem = '".$rowo['idItem']."' and idEnsayo = 'Du'";
												$bdTe=$link->query($sqlTe);
												if($rowTe=mysqli_fetch_array($bdTe)){
												}

												$sqlCe = "SELECT * FROM regdoblado Where idItem = '".$rowo['Otam']."' and fechaRegistro = '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-warning";
													//$boton = "btn btn-success";
												}
	
												$sqlCe = "SELECT * FROM regdoblado Where idItem = '".$rowo['Otam']."' and fechaRegistro != '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-info";
													//$boton = "btn btn-success";
												}
	
											}
											if($rowe['idEnsayo'] == 'Ch'){
												$enlace = 'iCharpy.php?Otam='.$rowo['Otam'];
	
												$sqlTe = "SELECT * FROM amtabensayos Where idItem = '".$rowo['idItem']."' and idEnsayo = 'Ch'";
												$bdTe=$link->query($sqlTe);
												if($rowTe=mysqli_fetch_array($bdTe)){
												}

												$sqlCe = "SELECT * FROM regcharpy Where idItem = '".$rowo['Otam']."' and fechaRegistro = '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-warning";
													//$boton = "btn btn-success";
												}
	
												$sqlCe = "SELECT * FROM regcharpy Where idItem = '".$rowo['Otam']."' and fechaRegistro != '000-00-00'";
												$bdCe=$link->query($sqlCe);
												if($rowCe=mysqli_fetch_array($bdCe)){
													$boton = "btn btn-info";
													//$boton = "btn btn-success";
												}
	
											}
											if($rowm['fechaTerminoTaller'] == '0000-00-00'){
												$boton = "btn btn-warning";
											}
											?>
											<tr>
												<td>
														<a href="<?php echo $enlace; ?>" class="<?php echo $boton; ?>">
															<h5>
																<?php echo $rowo['Otam']; ?>
																<span class="badge badge-secondary">
																	<?php echo $rowo['tpMuestra']; ?>
																	<?php //echo $rowTe['cEnsayos']; ?>
																</span>
															</h5>
														</a>
												</td>
											</tr>
										<?php
										}
	







									}
								}
							?>
						</tbody>
					</table>
				</div>

				<?php
			}
		}
		$link->close();
	?>
</div>
