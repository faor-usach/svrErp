<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
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
	include_once("conexion.php"); 
	$Rev 	= 0;
	$CodInforme		= $_GET[CodInforme];
	$accion 		= $_GET[accion];
	$encNew = 'Si';
	$cEnsayo = 1;

	$link=Conectarse();
	$bdMue=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."'");
	if($rowMue=mysql_fetch_array($bdMue)){
		$idMuestra		= $rowMue[idMuestra];
	}
	mysql_close($link);
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
						<img src="../imagenes/viewtimetables_48.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Agregar Ensayo <?php echo $CodInforme;?>
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'edicionInformes.php?CodInforme='.$CodInforme;
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
							<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>" />
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" class="cuadroInformes">
							<tr>
								<td>Tipo Ensayo </td>
							  	<td colspan="3">Tipo Muestra</td>
							  	<td>c/s Referencia</td>
							  	<td colspan="3">Cantidad  Ensayos </td>
						  	</tr>
							<tr>
								<td width="20%">
							  		<select name="idEnsayo" id="idEnsayo" onChange="llenarTabMuestras($('#idEnsayo').val())">
                                		<option></option>
                                		<?php
											$link=Conectarse();
											$bdEns=mysql_query("SELECT * FROM amEnsayos Order By nEns Asc");
											if($rowEns=mysql_fetch_array($bdEns)){
												do{
													?>
                                						<option value="<?php echo $rowEns[idEnsayo];?>"><?php echo $rowEns[Ensayo]; ?></option>
                                					<?php
												}while($rowEns=mysql_fetch_array($bdEns));
											} 
											mysql_close($link);
										?>
                              		</select>
							  	</td>
							  	<td width="30%" colspan="3">
									<span id="resultadoTabMuestras"></span>
							  	</td>
							  	<td width="20%">
							  		<select name="Ref">
										<option value="SR">Sin Referencia</option>
										<option value="CR">Con Referencia</option>
									</select>
							  	</td>
							  	<td width="30%" colspan="3">
							  		<input name="cEnsayos" id="cEnsayos" size="3" maxlength="3" value="<?php echo $cEnsayo; ?>">
							  	</td>
						  </tr>
						</table>
					</td>
				</tr>
		  		<tr>
					<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						//if($accion == 'EditarMuestra' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardaEnsayo" style="float:right;" title="Guardar Ensayo">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						//}
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
