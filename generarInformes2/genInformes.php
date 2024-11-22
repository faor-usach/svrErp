<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	?>
	
	<script>
		$( "#prgActividad" ).change(function() {
			var $input = $( this );
			var fPrg  = document.form.prgActividad.value;
			var tProx  = document.form.tpoProx.value;
			fVer = new Date(fPrg);
			
			tProx++;
			fVer.setDate(fVer.getDate()+parseInt(tProx));
			var anno	= fVer.getFullYear();
			var mes		= fVer.getMonth()+1;
			var dia		= fVer.getDate();
			var sep 	= '-';
			mes = (mes < 10) ? ("0" + mes) : mes;
			dia = (dia < 10) ? ("0" + dia) : dia;
			var fVer = anno+sep+mes+sep+dia;
			nVer = 'on';

			$("#fechaProxAct").val(fVer);
			
		  	//$("#Actividad").val(fVer);
		})

	</script>
	
	<?php
	include_once("../conexionli.php"); 
	$Rev 	= 0;
	$Contacto = '';

	if(isset($_GET['CodInforme'])) 	{ $CodInforme	= $_GET['CodInforme'];	}
	if(isset($_GET['RAM'])) 		{ $RAM 			= $_GET['RAM'];			}
	if(isset($_GET['accion'])) 		{ $accion 		= $_GET['accion'];		}

	$fechaApertura 	= date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();
	$bdCot=$link->query("SELECT * FROM Cotizaciones Where RAM = '".$RAM."'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$RutCli			= $rowCot['RutCli'];
		$nContacto		= $rowCot['nContacto'];
		$fechaRecepcion	= $rowCot['fechaInicio'];
		$usrResponzable	= $rowCot['usrResponzable'];
	}
	$bdCot=$link->query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$Cliente	= $rowCot['Cliente'];
	}
	$bdCot=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$Contacto	= $rowCot['Contacto'];
	}
	$link->close();
	$CodInforme = 'AM-'.$RAM;
?>

<style></style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="nominaInformes.php" method="get">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/poster_teachers.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Generacion de Informes <?php echo $CodInforme; ?>
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'plataformaGenInf.php';
									}
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
					  </span>
				  </td>
				</tr>
				<tr>
				  	<td colspan="4" class="lineaDerBot">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							<input name="CodInforme" 	id="CodInforme" type="hidden" value="<?php echo $CodInforme; 	?>" />
							<input name="RAM" 			id="RAM" 		type="hidden" value="<?php echo $RAM; 			?>" />
							<input name="RutCli" 		id="RutCli" 	type="hidden" value="<?php echo $RutCli;		?>" />
							<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td height="93">
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
								<td width="19%" height="28">Cliente </td>
								<td colspan="3" valign="top">: <?php echo $Cliente; ?></td>
							</tr>
							<tr>
								<td height="27">Solicitante</td>
								<td colspan="3">: <?php echo $Contacto; ?></td>
							</tr>
							<tr>
								<td height="31">Cantidad de Informes </td>
								<td width="29%">: 
									<select name="nroInformes">
										<?php for($i=1; $i<61; $i++){?>
											<option value="<?php echo $i;?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</td>
								<td width="19%">Fecha Recepci&oacute;n</td>
								<td width="33%">: 
									<input name="fechaRecepcion" id="fechaRecepcion" type="date" value="<?php echo $fechaRecepcion; ?>">
								</td>
							</tr>
							<tr>
								<td height="31">Responsable</td>
								<td width="29%">: 
									<select name="ingResponsable">
										<?php
											$link=Conectarse();
											$bdUsr=$link->query("SELECT * FROM Usuarios Where responsableInforme = 'on'");
											if($rowUsr=mysqli_fetch_array($bdUsr)){
												do{
													if($rowUsr['usr']==$usrResponzable){
														?>
														<option selected 	value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
														<?php 
													}else{
														?>
														<option 			value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
														<?php
													}
												}while($rowUsr=mysqli_fetch_array($bdUsr));
											} 
											$link->close();
										?>
									</select>
								</td>
								<td width="19%">Corresponsable</td>
							  	<td width="33%">: 
							    	<select name="cooResponsable">
										<option></option>
										<?php
											$link=Conectarse();
											$bdUsr=$link->query("SELECT * FROM Usuarios Where responsableInforme = 'on'");
											if($rowUsr=mysqli_fetch_array($bdUsr)){
												do{?>
													<option value="<?php echo $rowUsr['usr'];?>"><?php echo $rowUsr['usuario']; ?></option>
													<?php 
												}while($rowUsr=mysqli_fetch_array($bdUsr));
											} 
											$link->close();
										?>
                                	</select>
								</td>
							</tr>
							
						</table>
					</td>
				</tr>
		  		<tr>
					<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' or $accion == 'Agrega' or $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="generarInformes" style="float:right;" title="Generar Informe(s)">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Modificar'){?>
							<div id="botonImagen">
								<button name="generarInformes" style="float:right;" title="Generar Informe(s)">
									<img src="../imagenes/actualiza.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
					</td>
		  		</tr>
					<?php
						$link=Conectarse();
						$siMuestras = 'off';
						$bdMu=$link->query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%'");
						if($rowMu=mysqli_fetch_array($bdMu)){
							$siMuestras = 'on';
						}
						$link->close();
						if($siMuestras == 'on') {
							?>
								<tr>
									<td height="31" colspan="4" align="center" style="border-top:1px solid #ccc;">
										<table width="100%"  border="0">
                                        	<tr>
                                            	<td width="31%" valign="top">
													<span style="font-size:20px;">Existen Muestras Asociadas al Informe(s) </span>
												</td>
                                              	<td width="69%">
											  		<table width="100%"  cellpadding="0" cellspacing="0" id="claseMuestras">
                                                		<tr bgcolor="#999" style="color:#fff;">
                                                  			<td width="11%">Id.Items</td>
                                                  			<td width="89%">Id.Cliente</td>
                                                		</tr>
                                                		<?php
															$link=Conectarse();
															$siMuestras = 'off';
															$bdMu=$link->query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order By idItem");
															if($rowMu=mysqli_fetch_array($bdMu)){
																do{?>
																	<tr>
																	  <td><?php echo $rowMu['idItem']; ?></td>
																	  <td><?php echo $rowMu['idMuestra']; ?></td>
																	</tr>
																	<?php
																}while($rowMu=mysqli_fetch_array($bdMu));
															}
															$link->close();
														?>
                                              		</table>
											  	</td>
                                            </tr>
                                		</table>
									</td>
			  					</tr>
							<?php
						}
					?>
		</table>
		</form>
		</center>
	</div>
</div>

<script>
	$(document).ready(function(){
	  $("#CtaCte").click(function(){
		if($("#Cta").css("visibility") == "hidden" ){
			$("#Cta").css("visibility","visible");
		}else{
			$("#Cta").css("visibility","hidden");
		}
	  });
	});
</script>
