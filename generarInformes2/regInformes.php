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
	if(isset($_GET['CodInforme']))	{ $CodInforme	= $_GET['CodInforme']; 	}
	if(isset($_GET['RAM']))			{ $RAM 			= $_GET['RAM'];			}
	if(isset($_GET['accion']))		{ $accion 		= $_GET['accion'];		}
	$encNew = 'Si';

	$Ra = explode('-',$CodInforme);
		
	$link=Conectarse();
	$bdIn=$link->query("SELECT * FROM amInformes Where CodInforme = '".$CodInforme."'");
	if($rowIn=mysqli_fetch_array($bdIn)){
		$tpEnsayo		= $rowIn['tpEnsayo'];
		$RutCli			= $rowIn['RutCli'];
		$fechaRecepcion = $rowIn['fechaRecepcion'];
		$fechaInforme	= $rowIn['fechaInforme'];
	}
	$link->close();
	$encNew = 'No';
	$fechaHoy = date('Y-m-d');
	if($fechaInforme == '0000-00-00'){
		$fechaInforme = $fechaHoy;
	}
?>

<style></style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="edicionInformes.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/poster_teachers.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Informe de Resultado <?php echo $CodInforme;?>
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'nominaInformes.php?RAM='.$Ra[1].'&CodInforme='.substr($CodInforme,0,7);
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
							<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
						</strong>										
					</td>
			  	</tr>
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
										<?php for($i=1; $i<31; $i++){?>
											<option value="<?php echo $i;?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</td>
								<td width="20%">&nbsp;</td>
								<td width="24%">&nbsp;</td>
							</tr>
							<tr>
							  <td>Tipo de Muestra </td>
							  <td colspan="3">: 
							  	<input name="tipoMuestra" id="tipoMuestra" type="text" size="50" maxlength="50">
							  </td>
						  </tr>
							<tr>
								<td>Tipo de Ensayo </td>
								<td>: 
									<select name="tpEnsayo">
										<?php
											$link=Conectarse();
											$bdEns=$link->query("SELECT * FROM amTpEnsayo");
											if($rowEns=mysqli_fetch_array($bdEns)){
												do{
													?>
													<option value="<?php echo $rowEns['tpEnsayo'];?>"><?php echo $rowEns['Ensayo']; ?></option>
													<?php
												}while($rowEns=mysqli_fetch_array($bdEns));
											} 
											$link->close();
										?>
									</select>
								</td>
								<td>Fecha de Recepci&oacute;n</td>
								<td>: 
									<input name="fechaRecepcion" id="fechaRecepcion" type="date" value="<?php echo $fechaRecepcion; ?>">
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
		  		<tr>
					<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Titular' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarInforme" style="float:right;" title="Guardar Informe">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
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
