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
	$bdInf=$link->query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
	if($rowInf=mysqli_fetch_array($bdInf)){
		$nMuestras 			= $rowInf['nMuestras'];
		$tipoMuestra		= $rowInf['tipoMuestra'];
		$tpEnsayo			= $rowInf['tpEnsayo'];
		$amEnsayo			= $rowInf['amEnsayo'];
		$fechaRecepcion 	= $rowInf['fechaRecepcion'];
		$fechaInforme 		= $rowInf['fechaInforme'];
		$CodigoVerificacion = $rowInf['CodigoVerificacion'];
		$imgQR 				= $rowInf['imgQR'];
		
		if($CodigoVerificacion == ''){
			$CodigoVerificacion = '';
			
			$i=0; 
			$password=""; 
			$pw_largo = 12; 
			$desde_ascii = 50; // "2" 
			$hasta_ascii = 122; // "z" 
			$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
			while ($i < $pw_largo) { 
				mt_srand ((double)microtime() * 1000000); 
				$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
				if (!in_array ($numero_aleat, $no_usar)) { 
					$password = $password . chr($numero_aleat); 
					$i++; 
				} 
			}
			$CodigoVerificacion = $password;

			$actSQL="UPDATE amInformes SET ";
			$actSQL.="CodigoVerificacion = '".$CodigoVerificacion."'";
			$actSQL.="Where CodInforme = '".$CodInforme."'";
			$bdCot=$link->query($actSQL);

			$actSQL="UPDATE Informes SET ";
			$actSQL.="CodigoVerificacion = '".$CodigoVerificacion."'";
			$actSQL.="Where CodInforme = '".$CodInforme."'";
			$bdCot=$link->query($actSQL);
			
		}
	}
	$link->close();
?>

<form name="form" action="edicionInformes.php" method="post">
	<div class="row bg-secondary text-white">
				<div id="ImagenBarraLeft"  class="text-center">
					<?php
						$r = explode('-',$CodInforme);
						$cIn 	= $r[0].'-'.$r[1];
					?>
					<a href="../otamsajax/pOtams.php?RAM=<?php echo $RAM; ?>" title="Informes">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					Informes
				</div>

				<div ng-show="btnInformeOficial">
					<div id="ImagenBarraLeft" class="text-center">
						<a href="../generarinformes2/exportarInformeOficial.php?CodInforme=<?php echo $CodInforme; ?>&accion=<?php echo $accion; ?>&version=NewPortada" title="Generar Informe Word Portada">
							<img src="../imagenes/word.png"></a>
						<br>
						Info. Oficial
					</div>
				</div>
				<div id="ImagenBarraLeft" class="text-center" ng-show="btnOtrosEnsayos">
					<a href="../generarinformes2/exportarInformeWordAnalisis.php?CodInforme=<?php echo $CodInforme; ?>&accion=<?php echo $accion; ?>&version=NewPortada" title="Generar Informe Word Portada">
						<img src="../imagenes/word.png"></a>
					<br>
					Descargar Formato
				</div>
				
	</div>
<?php

?>

			<input name="CodInforme" 	id="CodInforme" ng-model="CodInforme"  ng-init="editarInforme('<?php echo $CodInforme; 	?>')" type="hidden" value="<?php echo $CodInforme; 	?>" />
			<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
			<div class="card m-2">
				<div class="card-header bg-info text-white"><h5>Identificación del Cliente</h5></div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">	
									Cliente:					
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<b>{{Cliente}}</b>		
								</div>
							</div>
							<div class="col-sm-1">
								<div class="form-group">	
									Solicitante:					
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<b>{{Contacto}}</b>		
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									Dirección:				
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<b>{{Direccion}}</b>		
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									Cantidad Muestras:		
								</div>
							</div>
							<div class="col-sm-1">
								<div class="form-group">
									<input class="form-control" ng-model="nMuestras" id="nMuestras" name="nMuestras" ng-change="guardarnMuestras()" type="type">
								</div>		
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									Tipo de Muestra: 
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<input class="form-control" ng-model="tipoMuestra" id="tipoMuestra" name="tipoMuestra" ng-change="guardarTipoMuestra()" type="type">
								</div>		
							</div>
							<div class="col-sm-1">
								<div class="form-group">
									Recepción: 
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<input class="form-control" ng-model="fechaRecepcion" id="fechaRecepcion" name="fechaRecepcion" ng-value="<?php echo $fechaRecepcion; ?>" ng-change="guardarfechaRecepcion()" type="date">
								</div>		
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									Tipo Informe:		
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group" > 
									<select class="form-control" ng-model="tpEnsayo" name="tpEnsayo" ng-change="verificaInforme()">
                              			<option value="" selected>Informe</option>
                                		<option ng-repeat="x in dataEnsayos" value="{{x.tpEnsayo}}">{{x.Ensayo}}</option>
                            		</select>
								</div>		
							</div>
							<div class="col-sm-4"></div>
							<div class="col-sm-1">
								<div class="form-group">
									Informe: 
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<input class="form-control" ng-model="fechaInforme" id="fechaInforme" name="fechaInforme" ng-change="guardarfechaInforme()" type="date">
								</div>		
							</div>

						</div>
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									Tipo Ensayo:		
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<input class="form-control" ng-model="amEnsayo" id="amEnsayo" name="amEnsayo" ng-change="guardaramEnsayo()" type="type">
								</div>		
							</div>
							<div class="col-sm-2" ng-show="certConformidad">
								<div class="form-group">
									Certificado Asociado:		
								</div>
							</div>
							<div class="col-sm-2" ng-show="certConformidad">
								<div class="form-group">
									<select class="form-control" ng-model="CodCertificado" name="CodCertificado" ng-change="mostrarQR(CodCertificado, CodInforme)">
										<option value="" selected>Informe Asociado</option>
										<option ng-repeat="x in dataCertificados" value="{{x.CodCertificado}}">{{x.CodCertificado}}</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2" ng-show="certConformidad"> 
								<div class="form-group">
									<?php
										$filename = '../codigoqr/phpqrcode/temp/{{CodCertificado}}.png';
										if (file_exists($filename)) {
											echo '<img src="'.$filename.'" width="50%">';
										}
									?>
								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
			

			<div class="card m-2">
				<div class="card-header bg-info text-white"><h5>Identificación de la Muestra</h5></div>
					<div class="card-body">
					<table class="table table-dark table-hover">
						<thead>
							<tr>
								<th>ID Items</th>
								<th>Identificación de las Muestras del Cliente</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="x in dataMuestras" class="table-secondary text-dark">
								<td> {{x.idItem}} </td>
								<td> {{x.idMuestra}} </td>
							</tr>
						</tbody>
					</table>

					</div>
				</div>
			</div>



<!--
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
								<td width="19%">Cliente </td>
								<td colspan="3" valign="top">:
									<?php
									$link=Conectarse();
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
										$Direccion = $rowCli['Direccion'];
									}
									$link->close();

									//$dirImg = "../codigoqr/phpqrcode/temp/".$imgQR;
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
									<select name="nMuestras">
										<?php 
											for($i=1; $i<31; $i++){
												if($nMuestras == $i){?>
													<option selected value="<?php echo $i;?>"><?php echo $i; ?></option>
												<?php }else{ ?>
													<option value="<?php echo $i;?>"><?php echo $i; ?></option>
												<?php 
												}
											} ?>
									</select>
								</td>
								<td width="20%">&nbsp;</td>
								<td width="24%">&nbsp;</td>
							</tr>
							<tr>
							  <td>Tipo de Muestra </td>
							  <td colspan="3">: 
							  	<input name="tipoMuestra" id="tipoMuestra" type="text" size="50" maxlength="50" value="<?php echo $tipoMuestra; ?>">
							  </td>
						  </tr>
							<tr>
								<td>Tipo de Informe </td>
								<td>: 
									<select name="tpEnsayosssssssss">
										<?php
											$link=Conectarse();
											$bdEns=$link->query("SELECT * FROM amTpEnsayo");
											if($rowEns=mysqli_fetch_array($bdEns)){
												do{
													if($tpEnsayo == $rowEns['tpEnsayo']){
														?>
														<option selected value="<?php echo $rowEns['tpEnsayo'];?>"><?php echo $rowEns['Ensayo']; ?></option>
													<?php
													}else{
													?>
														<option value="<?php echo $rowEns['tpEnsayo'];?>"><?php echo $rowEns['Ensayo']; ?></option>
														<?php
													}
												}while($rowEns=mysqli_fetch_array($bdEns));
											} 
											$link->close();
										?>
									</select>
								</td>
								<td>Fecha de Recepci&oacute;n</td>
								<td>: 
									<?php
									$link=Conectarse();
									$bdCot=$link->query("SELECT * FROM Cotizaciones Where RAM = '".$Ra[1]."'");
									if($rowCot=mysqli_fetch_array($bdCot)){
										$fechaRecepcion = $rowCot['fechaAceptacion'];
									}
									$link->close();
									?>
									<input name="fechaRecepcion" id="fechaRecepcion" type="date" value="<?php echo $fechaRecepcion; ?>">
								</td>
							</tr>

							<tr>
								<td>Tipo de Ensayo </td>
								<td colspan="3">: 
							  		<input name="amEnsayo" id="amEnsayo" type="text" size="50" maxlength="50" value="<?php echo $amEnsayo; ?>">
								</td>
							</tr>
							<tr>
								<td>Solicitante</td>
								<td>: 
									<?php
									$link=Conectarse();
									$bdCot=$link->query("SELECT * FROM Cotizaciones Where RAM = '".$Ra[1]."'");
									if($rowCot=mysqli_fetch_array($bdCot)){
										$bdCli=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowCot['RutCli']."' and nContacto = '".$rowCot['nContacto']."'");
										if($rowCli=mysqli_fetch_array($bdCli)){
											echo $rowCli['Contacto'];
										}
									}
									$link->close();
									?>
								</td>
								<td>Fecha Emisi&oacute;n Informe</td>
								<td>: 
							    <input name="fechaInforme" id="fechaInforme" type="date" value="<?php echo $fechaInforme; ?>"></td>
							</tr>
						</table>
					</td>
				</tr>
		</table>
-->	
<!--
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
			<tr>
				<td>
					<?php
					$link=Conectarse();
					$bdMue=$link->query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem Desc");
					if($rowMue=mysqli_fetch_array($bdMue)){
						//echo 'Cod.'.$CodInforme;
						$idItem = $rowMue['idItem'];
						$Mu 	= explode('-',$idItem);
					}
					$link->close();
					$txtItemA = 'A.- Identificación de la Muestra';
					if($Mu[1]>1){
						$txtItemA = 'A.- Identificación de las Muestras';
					}
					echo '<strong>'.$txtItemA.'</strong>';
					?>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" id="tablaIdMuestras">
						<tr bgcolor="#CCCCCC">
							<td width="10%" align="center">
								ID<br>ITEM
							</td>
							<td width="70%">
								Identificación del Cliente
							</td>
							<td width="20%" colspan="2"></td>
						</tr>
						<?php
						$link=Conectarse();
						$bdMue=$link->query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
						if($rowMue=mysqli_fetch_array($bdMue)){
							do{?>
								<tr>
									<td align="center"><?php echo $rowMue['idItem']; ?></td>
									<td>
										Se ha recibido una muestra, identificada por el cliente como "
										<?php 
											if($rowMue['idMuestra']) { 
												echo $rowMue['idMuestra']; 
											}else{
												echo 'SIN IDENTIFICAR'; 
											} 
										?>
										"
									</td>
									<td>
										<?php
										echo '<a href="edicionInformes.php?accion=EditarMuestra&CodInforme='.$rowMue['CodInforme'].'&idItem='.$rowMue['idItem'].'"	><img src="../imagenes/actividades.png" width="30" title="Editar Muestra"	>	</a>';
										?>
									</td>
									<td>
										<?php
										//echo '<a href="edicionInformes.php?accion=EliminarMuestra&CodInforme='.$row[CodInforme].'&idItem='.$rowMue[idItem].'"	><img src="../imagenes/inspektion.png"  width="30" title="Eliminar Muestra"	>	</a>';
										?>
									</td>
								</tr>
								<?php 
							}while($rowMue=mysqli_fetch_array($bdMue));
						}
						$link->close();
						?>
					</table>
				</td>
			</tr>
		</table>
-->

		<?php
			$filtroSQL = "CodInforme = '".$CodInforme."'";
		?>
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaDeTexto">
			<tr>
				<td>
					<?php
					$txtItemA = 'B.- Ensayos';
					echo '<strong>'.$txtItemA.'</strong>';
					?>
				</td>
			</tr>
				<table cellpadding="0" cellspacing="0" border="0" width="99%">
					<tr>
						<td width="20%" valign="top">
							<table cellpadding="0" cellspacing="0" id="titEnsayos">
								<tr>
									<td align="center" height="40">Tracciones</td>
								</tr>
							</table>
							
							<table border="0" cellspacing="0" cellpadding="0" id="lisEnsayos">
								<?php
									$link=Conectarse();
									$SQL = "SELECT * FROM OTAMs Where $filtroSQL Order By Otam";
								
									$bdEns=$link->query($SQL);
									if($rowEns=mysqli_fetch_array($bdEns)){
										do{
											$tEns = explode('-',$rowEns['Otam']);
											//if(substr($tEns[2],0,1) == 'T'){
											if($rowEns['idEnsayo'] == 'Tr'){
												$tr = '';
												if($rowEns['Estado'] == 'R') { $tr = 'bVerde'; }

												$tr = '';
												$SQLtr = "SELECT * FROM regtraccion Where idItem ='".$rowEns['Otam']."'";
												$bdtr=$link->query($SQLtr);
												if($rstr=mysqli_fetch_array($bdtr)){
													if($rstr['fechaRegistro'] != '0000-00-00') { 
														$tr = 'bVerde'; 
													}
												}

												?>
												<tr bgcolor="<?php echo $tr; ?>">
													<td height="40">
														<!-- <a href="pTallerPM.php?Otam=<?php echo $rowEns['Otam']; ?>&accion=Registrar"> -->
														<a href="../tallerPM/iTraccion.php?Otam=<?php echo $rowEns['Otam']; ?>&CodInforme=<?php echo $CodInforme; ?>">
															<?php echo $rowEns['Otam']; ?>
														</a>
													</td>
												</tr>
											<?php
											}
										}while($rowEns=mysqli_fetch_array($bdEns));
									}
									$link->close();
								?>
							</table>
						</td>
						<td width="20%" valign="top">
							<table cellpadding="0" cellspacing="0" id="titEnsayos">
								<tr>
									<td align="center" height="40">Químicos</td>
								</tr>
							</table>
			
							<table border="0" cellspacing="0" cellpadding="0" id="lisEnsayos">
								<?php
									$link=Conectarse();
									$SQL = "SELECT * FROM OTAMs Where $filtroSQL Order By Otam";
								
									$bdEns=$link->query($SQL);
									while($rowEns=mysqli_fetch_array($bdEns)){
											$tEns = explode('-',$rowEns['Otam']);
											if($rowEns['idEnsayo'] == 'Qu'){
												$tr = '';
												$SQLqu = "SELECT * FROM regquimico Where idItem ='".$rowEns['Otam']."' Order by fechaRegistro Desc ";
												$bdQu=$link->query($SQLqu);
												if($rowQu=mysqli_fetch_array($bdQu)){
													if($rowQu['Temperatura'] != '') { 
														$tr = 'bVerde'; 
													}
												}
												?>
												<tr bgcolor="<?php echo $tr; ?>">
													<td height="40">
														<a href="../tallerPM/iQuimico.php?Otam=<?php echo $rowEns['Otam']; ?>&CodInforme=<?php echo $CodInforme; ?>">
															<?php echo $rowEns['Otam']; ?>
														</a>
													</td>
												</tr>
											<?php
											}
									}
									$link->close();
								?>
							</table>
						<td width="20%" valign="top">
							<table cellpadding="0" cellspacing="0" id="titEnsayos">
								<tr>
									<td align="center" height="40">Charpy</td>
								</tr>
							</table>
			
							<table border="0" cellspacing="0" cellpadding="0" id="lisEnsayos">
								<?php
									$link=Conectarse();
									$SQL = "SELECT * FROM OTAMs Where $filtroSQL Order By Otam";
								
									$bdEns=$link->query($SQL);
									if($rowEns=mysqli_fetch_array($bdEns)){
										do{
											$tEns = explode('-',$rowEns['Otam']);
											if($rowEns['idEnsayo'] == 'Ch'){
												$tr = '';
												if($rowEns['Estado'] == 'R') { $tr = 'bVerde'; }
												?>
												<tr bgcolor="<?php echo $tr; ?>">
													<td height="40">
														<a href="../tallerPM/iCharpy.php?Otam=<?php echo $rowEns['Otam']; ?>&CodInforme=<?php echo $CodInforme; ?>">
															<?php echo $rowEns['Otam']; ?>
														</a>
													</td>
												</tr>
											<?php
											}
										}while($rowEns=mysqli_fetch_array($bdEns));
									}
									$link->close();
								?>
							</table>
						</td>
						<td width="20%" valign="top">
							<table cellpadding="0" cellspacing="0" id="titEnsayos">
								<tr>
									<td align="center" height="40">Dureza</td>
								</tr>
							</table>
			
							<table border="0" cellspacing="0" cellpadding="0" id="lisEnsayos">
								<?php
									$link=Conectarse();
									$SQL = "SELECT * FROM OTAMs Where $filtroSQL Order By Otam";
								
									$bdEns=$link->query($SQL);
									if($rowEns=mysqli_fetch_array($bdEns)){
										do{
											$tEns = explode('-',$rowEns['Otam']);
											//if(substr($tEns[1],0,1) == 'D'){
											if($rowEns['idEnsayo'] == 'Du'){
												$tr = '';
												if($rowEns['Estado'] == 'R') { $tr = 'bVerde'; }
												?>
												<tr bgcolor="<?php echo $tr; ?>">
													<td height="40">
														<?php
															if($rowEns['tpMedicion'] != 'Perf'){
																?>
																<a href="../tallerPM/iDureza.php?Otam=<?php echo $rowEns['Otam']; ?>&CodInforme=<?php echo $CodInforme; ?>">
																	<?php echo $rowEns['Otam']; ?>
																</a>
																<?php
															}else{
																?>
																<a href="../tallerPM/iDureza.php?Otam=<?php echo $rowEns['Otam']; ?>&CodInforme=<?php echo $CodInforme; ?>">
																	<?php echo $rowEns['Otam']; ?>
																</a>
																<?php
															}
														?>
													</td>
												</tr>
											<?php
											}
										}while($rowEns=mysqli_fetch_array($bdEns));
									}
									$link->close();
								?>
							</table>
							
						</td>





						<td width="20%" valign="top">
							<table cellpadding="0" cellspacing="0" id="titEnsayos">
								<tr>
									<td align="center" height="40">Doblado</td>
								</tr>
							</table>
			
							<table border="0" cellspacing="0" cellpadding="0" id="lisEnsayos">
								<?php
									$link=Conectarse(); 
									$SQL = "SELECT * FROM OTAMs Where $filtroSQL Order By Otam";
								
									$bdEns=$link->query($SQL);
									if($rowEns=mysqli_fetch_array($bdEns)){
										do{
											$tEns = explode('-',$rowEns['Otam']);
											//if(substr($tEns[1],0,1) == 'D'){
											if($rowEns['idEnsayo'] == 'Do'){
												$tr = '';
												if($rowEns['Estado'] == 'R') { $tr = 'bVerde'; }

												$SQLqu = "SELECT * FROM regdobladosreal Where idItem ='".$rowEns['Otam']."' Order by fechaRegistro Desc ";
												$bdQu=$link->query($SQLqu);
												if($rowQu=mysqli_fetch_array($bdQu)){
													if($rowQu['fechaRegistro'] != '0000-00-00') { 
														$tr = 'bVerde'; 
													}
												}




												?>
												<tr bgcolor="<?php echo $tr; ?>">
													<td height="40">
														<?php
															if($rowEns['tpMedicion'] != 'Perf'){
																?>
																<a href="../tallerPM/iDoblado.php?Otam=<?php echo $rowEns['Otam']; ?>&CodInforme=<?php echo $CodInforme; ?>">
																	<?php echo $rowEns['Otam']; ?>
																</a>
																<?php
															}else{
																?>
																<a href="../tallerPM/iDoblado.php?Otam=<?php echo $rowEns['Otam']; ?>&CodInforme=<?php echo $CodInforme; ?>">
																	<?php echo $rowEns['Otam']; ?>
																</a>
																<?php
															}
														?>
													</td>
												</tr>
											<?php
											}
										}while($rowEns=mysqli_fetch_array($bdEns));
									}
									$link->close();
								?>
							</table>
							
						</td>
						
					</tr>
				</table>
		</table>





		<div class="card m-2">
			<div class="card-header bg-info text-white"><h5>Códigos del Informe</h5></div>
				<div class="card-body">
				   <div class="row text-center">
					   	<div class="col-sm-2">
						   <div class="form-group">	
					   			Código de Verificación:
							</div>
					  	</div>
					   	<div class="col-sm-2">
					   		<div class="form-group">	
					   			<h6><?php echo $CodigoVerificacion; ?></h6>
							</div>
					   	</div>

				   </div>
				   <div class="row text-center">
				   		<div class="col-sm-2">
						   <div class="form-group">	
								Código QR:
							</div>
					   	</div>

					   <div class="col-sm-2">
					   		<div class="form-group">	
					   		<?php
							if($CodInforme) {
								if($CodigoVerificacion) {
									$dirinfo  = "http://www.simet.cl/mostrarPdf.php";
									$dirinfo .= '?CodInforme='.$CodInforme.'&amp;CodigoVerificacion='.$CodigoVerificacion;
									echo "<iframe scrolling='no' src='http://servidorerp/erp/codigoqr/phpqrcode/gQR.php?CodInforme=$CodInforme&data=$dirinfo' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";

									$imgQR = $CodInforme.'.png';

									$mapaQR = 'X:\codigoqr\phpqrcode\\temp\\'.$imgQR;
									$mapaQRDestino = '../codigoqr/phpqrcode/temp/'.$imgQR;
									if(file_exists($mapaQR)){
										copy($mapaQR, $mapaQRDestino);
									}

									$link=Conectarse();
									$actSQL="UPDATE amInformes SET ";
									$actSQL.="imgQR 			= '".$imgQR.		"'";
									$actSQL.="Where CodInforme 	= '".$CodInforme.	"'";
									$bdCot=$link->query($actSQL);
									$link->close();
								}
							}
							?>	
					   		</div>
					   </div>
				   </div>
				</div>
			</div>
		</div>


<!--
		<p>
			<b>Códigos</b>
		</p>
		<table width="100%" cellpadding="0" cellspacing="0" id="tablaIdMuestras"> 
			<tr bgcolor="#CCCCCC">
				<td align="center">Código de Verificación</td>
				<td align="center">Código QR</td>
			</tr>
			<tr>
				<td align="center">
					<b style="font-size:18px;">
					<?php echo $CodigoVerificacion; ?>
					</b>
				</td>
				<td align="center">
					<?php
							if($CodInforme) {
								if($CodigoVerificacion) {
									$dirinfo  = "http://www.simet.cl/mostrarPdf.php";
									$dirinfo .= '?CodInforme='.$CodInforme.'&amp;CodigoVerificacion='.$CodigoVerificacion;
									echo "<iframe scrolling='no' src='http://servidorerp/erp/codigoqr/phpqrcode/gQR.php?CodInforme=$CodInforme&data=$dirinfo' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";

									$imgQR = $CodInforme.'.png';

									//$mapaQR = 'http://servidordata/erperp/codigoqr/phpqrcode/temp/'.$imgQR;
									$mapaQR = 'X:\codigoqr\phpqrcode\\temp\\'.$imgQR;
									$mapaQRDestino = '../codigoqr/phpqrcode/temp/'.$imgQR;
									// echo 'MAPA '.$mapaQR.'<BR>';
									//console.log($mapaQR);
									if(file_exists($mapaQR)){
										// echo 'MAPA ENCONTRADO '.$mapaQR.' - '.$mapaQRDestino;
										copy($mapaQR, $mapaQRDestino);
									}

									$link=Conectarse();
									$actSQL="UPDATE amInformes SET ";
									$actSQL.="imgQR 			= '".$imgQR.		"'";
									$actSQL.="Where CodInforme 	= '".$CodInforme.	"'";
									$bdCot=$link->query($actSQL);
									$link->close();
								}
							}
//						}

						?>
				</td>
			</tr>
		</table>
-->		
</form>
		
		<span id="resultadoEdicionMuestra"></span>
		<span id="resultado"></span>
		<span id="resultadoRegistro"></span>
		<span id="resultadoSubir"></span>
