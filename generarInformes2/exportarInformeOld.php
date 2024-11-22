<?
include_once("conexion.php");
$CodInforme	= $_GET['CodInforme'];
$accion 	= $_GET['accion'];
$nomInforme = $CodInforme.'.doc';

//Exportar datos de php a Word
header("Content-Type: application/vnd.ms-word");
header("content-disposition: attachment;filename=$nomInforme");

header("Content-Transfer-Encoding: binary ");
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$link=Conectarse();
$bdInf=mysql_query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
if($rowInf=mysql_fetch_array($bdInf)){
	$nMuestras 		= $rowInf[nMuestras];
	$tipoMuestra	= $rowInf[tipoMuestra];
	$tpEnsayo		= $rowInf[tpEnsayo];
	$fechaRecepcion = $rowInf[fechaRecepcion];
	$fechaInforme 	= $rowInf[fechaInforme];
	$RutCli			= $rowInf[RutCli];
}

$bdCli=mysql_query("Select * From Clientes Where RutCli = '".$RutCli."'");
if($rowCli=mysql_fetch_array($bdCli)){
	$Cliente 	= $rowCli[Cliente];
	$Direccion 	= $rowCli[Direccion];
}
mysql_close($link);
?>
<HTML LANG="es">
<head>
<TITLE>::. Exportacion de Datos .::</TITLE>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<style>
		body {
			font-family:Arial;
			font-size:13px;
		}
		.cabezeraInforme {
			font-size:12px; 
			font-family:Arial;
			width:100%;
			/*border:1px solid #ccc;*/
		}
		.cuadroId {
			font-size:13px; 
			font-family:Arial;
			width:100%;
			border:4px solid #000;
		}
		.cuadroId td{
			height:10px;
		}

		.cajaIdMuestras {
			font-size:13px; 
			font-family:Arial;
			width:100%;
			border:4px double #000;
			background-color:#CCCCCC;
		}
		.cajaIdMuestras td{
			height:30px;
		}

		.ftoTablaResultado {
			font-size:13px; 
			font-family:Arial;
			width:100%;
			border:4px double #000;
			background-color:#CCCCCC;
		}
		.ftoTablaResultado td{
			height:30px;
		}
		.fondoTitMue {
			background-color:#CCCCCC;
		}

		.lineaBorde {
			border:1px solid #ccc;
		}
		.logoUsach {
			position:absolute;
			float:left;
			width:53px; 
			height:81px; 
		}
	</style>
</head>
<body>
	
	<table width="100%">
		<tr>
		  <td width="90%">
				<table cellpadding="0" cellspacing="0" class="cabezeraInforme">
					<tr>
						<td width="20%" rowspan="3" class="lineaBorde">
							<img src="http://erp.simet.cl/imagenes/logoSimetInforme.png">
						</td>
						<td width="59%" rowspan="3" valign="top" align="center" class="lineaBorde">
							INFORME DE RESULTADOS<br>
							<?php 
								echo $CodInforme.'<br>';
								echo $Cliente;
							 ?>
						</td>
						<td width="21%" class="lineaBorde">
							Fecha : 
							<?php
								$fd = explode('-',$fechaInforme);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>
						</td>
					</tr>
					<tr>
						<td class="lineaBorde">Revisi&oacute;n: 00 </td>
				  	</tr>
					<tr>
						<td class="lineaBorde">P&aacute;gina 1 de 1 </td>
				  	</tr>
				</table>
				
				
				<br>
				
				
			    <table cellpadding="0" cellspacing="0" class="cuadroId">
                	<tr>
                    	<td width="17%">Cliente</td>
	                    <td colspan="3">: <strong><?php echo $Cliente; ?></strong></td>
                   	</tr>
                  	<tr>
						<td>Direcci&oacute;n</td>
						<td colspan="3">: <?php echo $Direccion; ?></td>
					</tr>
                  	<tr>
						<td>Tipo de Muestra </td>
						<td colspan="3">: 
							<?php echo $tipoMuestra; ?>
						</td>
					</tr>
                  	<tr>
						<td>Cantidad</td>
						<td colspan="3">: 
							<?php 
								if($nMuestras < 10){
									$nMuestras = '0'.$nMuestras;
								}
								echo $nMuestras;
							?>
						</td>
					</tr>
                  	<tr>
						<td>Tipo de Ensayo </td>
						<td width="39%">: 
							<?php
							$link=Conectarse();
							$bdTpEns=mysql_query("Select * From amTpEnsayo Where tpEnsayo = '".$tpEnsayo."'");
							if($rowTpEns=mysql_fetch_array($bdTpEns)){
								echo $rowTpEns[Ensayo];
							}
							mysql_close($link);
							?>
						</td>
						<td width="28%">Fecha de Recepci&oacute;n </td>
						<td width="16%">:
							<?php
								$fd = explode('-',$fechaRecepcion);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>
						</td>
                  	</tr>
                  	<tr>
						<td>Solicitante</td>
						<td>: 
							<?php
								$Ra = explode('-',$CodInforme);
								$link=Conectarse();
								$bdCot=mysql_query("SELECT * FROM Cotizaciones Where RAM = '".$Ra[1]."'");
								if($rowCot=mysql_fetch_array($bdCot)){
									$bdCli=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCot[RutCli]."' and nContacto = '".$rowCot[nContacto]."'");
									if($rowCli=mysql_fetch_array($bdCli)){
										echo '<strong>'.$rowCli[Contacto].'</strong>';
									}
								}
								mysql_close($link);
							?>
						</td>
						<td>Fecha de Emisi&oacute;n Informe </td>
						<td>: 
							<?php
								$fd = explode('-',$fechaInforme);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>
						</td>
                  	</tr>
                </table>
				
				<?php $letraItem = 'A'; ?>
				
				<br>
				<b><?php echo $letraItem; ?>.- <span style="text-decoration:underline;">Identificación de la Muestra</span></b>
				<br>
				<br>
				
				<table class="cajaIdMuestras" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">
							ID<BR>
							ITEM
						</td>
						<td>
							Identificación del Cliente
						</td>
					</tr>
						<?php
						$link=Conectarse();
						$bdMue=mysql_query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
						if($rowMue=mysql_fetch_array($bdMue)){
							do{?>
								<tr bgcolor="#FFFFFF">
									<td align="center"><?php echo $rowMue[idItem]; ?></td>
									<td>
										Se ha recibido una muestra, identificada por el cliente como "
										<?php 
											if($rowMue[idMuestra]) { 
												echo $rowMue[idMuestra]; 
											}else{
												echo 'SIN IDENTIFICAR'; 
											} 
										?>
										"
									</td>
								</tr>
								<?php 
							}while($rowMue=mysql_fetch_array($bdMue));
						}
						mysql_close($link);
						?>
				</table>

				<center>
				<br>
				En la Figura <?php echo $letraItem; ?>.1 presenta una imagen de la muestra recibida.
				<br><br>
					<img src="http://erp.simet.cl/imagenes/muestraImg.jpg">
				<br><br>
				<strong>Figura <?php echo $letraItem; ?>.1</strong> Imagen de la muestra recibida.
				<br><br>
				</center>
				<br><br>
				<p align="right" style="color:#CCCCCC; font-size:9px;">
					UNIVERSIDAD DE SANTIAGO DE CHILE<br>
					Departamento de Ingeniería Metalúrgica<br>
					Laboratorio de Ensayos e Investigación de Materiales SIMET-USACH<br>
					Av. Ecuador 3769, Estación Central-Santiago-Chile<br>
					Fono-Fax: 56-2-23234780, Email: simet@usach.cl<br>
					<a href="http://www.simet.cl" target="_blank">www.simet.cl</a><br>
				</p>
				<br><br>
			</td>
			<td width="10%" valign="top">
				<img src="http://erp.simet.cl/imagenes/Logo-Color-Usach-Web-Ch.png" width="53" height="81">
			</td>
		</tr>
	</table>

	<table width="100%">
		<tr>
		  <td width="90%">
				<table cellpadding="0" cellspacing="0" class="cabezeraInforme">
					<tr>
						<td width="20%" rowspan="3" class="lineaBorde">
							<img src="http://erp.simet.cl/imagenes/logoSimetInforme.png">
						</td>
						<td width="59%" rowspan="3" valign="top" align="center" class="lineaBorde">
							INFORME DE RESULTADOS<br>
							<?php 
								echo $CodInforme.'<br>';
								echo $Cliente;
							 ?>
						</td>
						<td width="21%" class="lineaBorde">
							Fecha : 
							<?php
								$fd = explode('-',$fechaInforme);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>
						</td>
					</tr>
					<tr>
						<td class="lineaBorde">Revisi&oacute;n: 00 </td>
				  	</tr>
					<tr>
						<td class="lineaBorde">P&aacute;gina 1 de 1 </td>
				  	</tr>
				</table>
				
				<?php
				$link=Conectarse();
				$bdTabEns=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."'");
				if($rowTabEns=mysql_fetch_array($bdTabEns)){
					do{
						$letraItem++;
						echo $letraItem.'.- <span style="text-decoration:underline;">Resultados de Análisis Químico</span></b>';
						$i=1;
						?>
						<p style="font-size:13px;" align="justify">
							En la tabla <?php echo $letraItem.'.'.$i; ?> se muestran los valores resultantes del análisis químico, 
							obtenido mediante Espectrometría de Emisión Óptica.
						</p>
						<?php
						$cRef = 'No';
						for($i=1; $i<=$rowTabEns[cEnsayos]; $i++){
							?>
							<p>
								<?php

								// Químico - Acero
								if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Ac' and $rowTabEns[Ref]=='SR'){
									$ta = explode('-',$CodInforme);
									$tq = $ta[1].'-Q'.$i;
									if($i<10){
										$tq = $ta[1].'-Q0'.$i;
									}
									if($i==1){
										echo 'Tabla '.$letraItem.'.'.$i.' Resultados de análisis químico.';
									}
									tablaQuimicoSR($tq);
								}
								if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Ac' and $rowTabEns[Ref]=='CR'){
									$cRef = 'SiQuAc';
									$ta = explode('-',$CodInforme);
									$tq = $ta[1].'-Q'.$i;
									if($i<10){
										$tq = $ta[1].'-Q0'.$i;
									}
									if($i==1){
										echo 'Tabla '.$letraItem.'.'.$i.' Resultados de análisis químico.';
									}
									tablaQuimicoCR($tq);
								}


								// Químico - Cobre
								if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Co' and $rowTabEns[Ref]=='SR'){
									$ta = explode('-',$CodInforme);
									$tq = $ta[1].'-Q'.$i;
									if($i<10){
										$tq = $ta[1].'-Q0'.$i;
									}
									if($i==1){
										echo 'Tabla '.$letraItem.'.'.$i.' Resultados de análisis químico.';
									}
									tablaQuimicoCoSR($tq);
								}
								if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Co' and $rowTabEns[Ref]=='CR'){
									$cRef = 'SiQuCo';
									$ta = explode('-',$CodInforme);
									$tq = $ta[1].'-Q'.$i;
									if($i<10){
										$tq = $ta[1].'-Q0'.$i;
									}
									if($i==1){
										echo 'Tabla '.$letraItem.'.'.$i.' Resultados de análisis químico.';
									}
									tablaQuimicoCoSR($tq);
								}

								// Químico - Aluminio
								if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Al' and $rowTabEns[Ref]=='SR'){
									$ta = explode('-',$CodInforme);
									$tq = $ta[1].'-Q'.$i;
									if($i<10){
										$tq = $ta[1].'-Q0'.$i;
									}
									if($i==1){
										echo 'Tabla '.$letraItem.'.'.$i.' Resultados de análisis químico.';
									}
									tablaQuimicoAl($tq);
								}
								if($rowTabEns[idEnsayo]=='Qu' and $rowTabEns[tpMuestra]=='Al' and $rowTabEns[Ref]=='CR'){
									$cRef = 'SiQuAl';
									$ta = explode('-',$CodInforme);
									$tq = $ta[1].'-Q'.$i;
									if($i<10){
										$tq = $ta[1].'-Q0'.$i;
									}
									if($i==1){
										echo 'Tabla '.$letraItem.'.'.$i.' Resultados de análisis químico.';
									}
									tablaQuimicoAl($tq);
								}

								?>
							</p>
							<?php
						}
						if($cRef == 'SiQuAc'){
							ReftablaQuimicoCR();
						}
						if($cRef == 'SiQuCo'){
							ReftablaQuimicoCo();
						}
						if($cRef == 'SiQuAl'){
							ReftablaQuimicoAl();
						}
						if($i==1){?>
							<p>
								Tabla <?php echo $letraItem.'.'.$i; ?> Resultados de análisis químico.
							</p>
							<?php
						}
					}while($rowTabEns=mysql_fetch_array($bdTabEns));
				}
				mysql_close($link);
				?>
				<p align="right" style="color:#CCCCCC; font-size:9px;">
					UNIVERSIDAD DE SANTIAGO DE CHILE<br>
					Departamento de Ingeniería Metalúrgica<br>
					Laboratorio de Ensayos e Investigación de Materiales SIMET-USACH<br>
					Av. Ecuador 3769, Estación Central-Santiago-Chile<br>
					Fono-Fax: 56-2-23234780, Email: simet@usach.cl<br>
					<a href="http://www.simet.cl" target="_blank">www.simet.cl</a><br>
				</p>
				<br>
				
		  	</td>
			<td width="10%" valign="top">
				<img src="http://erp.simet.cl/imagenes/Logo-Color-Usach-Web-Ch.png" width="53" height="81">
			</td>
		</tr>
	</table>


	<table width="100%">
		<tr>
		  <td width="90%">
				<table cellpadding="0" cellspacing="0" class="cabezeraInforme">
					<tr>
						<td width="20%" rowspan="3" class="lineaBorde">
							<img src="http://erp.simet.cl/imagenes/logoSimetInforme.png">
						</td>
						<td width="59%" rowspan="3" valign="top" align="center" class="lineaBorde">
							INFORME DE RESULTADOS<br>
							<?php 
								echo $CodInforme.'<br>';
								echo $Cliente;
							 ?>
						</td>
						<td width="21%" class="lineaBorde">
							Fecha : 
							<?php
								$fd = explode('-',$fechaInforme);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>
						</td>
					</tr>
					<tr>
						<td class="lineaBorde">Revisi&oacute;n: 00 </td>
				  	</tr>
					<tr>
						<td class="lineaBorde">P&aacute;gina 1 de 1 </td>
				  	</tr>
				</table>

				<p>
				<?php
				$letraItem++;
				echo $letraItem.'.- <span style="text-decoration:underline;">Observaciones:</span></b>';
				?>
				</p>
				<p>
					<div style="margin-left:30px;">No presenta,</div>
				</p>
				<p>
					<span style="text-decoration:underline;"><strong>NOTAS:</strong></span>
				</p>
				<?php
				$link=Conectarse();
				$bdNot=mysql_query("SELECT * FROM amNotas Order By nNota Asc");
				if($rowNot=mysql_fetch_array($bdNot)){
					do{?>
						<li style="list-style-type:square;"><?php echo $rowNot[Nota]; ?> </li>
					<?php
					}while($rowNot=mysql_fetch_array($bdNot));
				}
				mysql_close($link);
				?>
				<p align="right" style="color:#CCCCCC; font-size:9px;">
					UNIVERSIDAD DE SANTIAGO DE CHILE<br>
					Departamento de Ingeniería Metalúrgica<br>
					Laboratorio de Ensayos e Investigación de Materiales SIMET-USACH<br>
					Av. Ecuador 3769, Estación Central-Santiago-Chile<br>
					Fono-Fax: 56-2-23234780, Email: simet@usach.cl<br>
					<a href="http://www.simet.cl" target="_blank">www.simet.cl</a><br>
				</p>
				<br>
				
		  	</td>
			<td width="10%" valign="top">
				<img src="http://erp.simet.cl/imagenes/Logo-Color-Usach-Web-Ch.png" width="53" height="81">
			</td>
		</tr>
	</table>
	
</body>
</html>

<?php
function tablaQuimicoSR($t){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Mo</td>
			<td align="center" width="08%">%Ai</td>
			<td align="center" width="08%">%Cu</td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
		<tr>
			<td height="28" align="center" bgcolor="#FFFFFF"><strong><?php echo $t; ?></strong></td>
			<td align="center" bgcolor="#E6E6E6">%Co</td>
			<td align="center" bgcolor="#E6E6E6">%Ti</td>
			<td align="center" bgcolor="#E6E6E6">%Nb</td>
			<td align="center" bgcolor="#E6E6E6">%V</td>
			<td align="center" bgcolor="#E6E6E6">%W</td>
			<td align="center" bgcolor="#E6E6E6">%Sn</td>
			<td align="center" bgcolor="#E6E6E6">%B</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Fe</td>
  		</tr>
		<tr bgcolor="#FFFFFF">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php
}

function tablaQuimicoCR($t){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Mo</td>
			<td align="center" width="08%">%Ai</td>
			<td align="center" width="08%">%Cu</td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
		<tr>
			<td height="28" align="center" bgcolor="#FFFFFF"><strong><?php echo $t; ?></strong></td>
			<td align="center" bgcolor="#E6E6E6">%Co</td>
			<td align="center" bgcolor="#E6E6E6">%Ti</td>
			<td align="center" bgcolor="#E6E6E6">%Nb</td>
			<td align="center" bgcolor="#E6E6E6">%V</td>
			<td align="center" bgcolor="#E6E6E6">%W</td>
			<td align="center" bgcolor="#E6E6E6">%Sn</td>
			<td align="center" bgcolor="#E6E6E6">%B</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Fe</td>
  		</tr>
		<tr bgcolor="#FFFFFF">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoCR(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6">
			<td align="center" width="15%">Referencia</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Fe</td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaQuimicoCoSR($t){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">%Pb</td>
			<td align="center" width="08%">%Sn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mg</td>
			<td align="center" width="08%">%Cr</td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
		<tr>
			<td height="28" align="center" bgcolor="#FFFFFF">&nbsp;</strong></td>
			<td align="center" bgcolor="#E6E6E6">%Te</td>
			<td align="center" bgcolor="#E6E6E6">%As</td>
			<td align="center" bgcolor="#E6E6E6">%Sb</td>
			<td align="center" bgcolor="#E6E6E6">%Cd</td>
			<td align="center" bgcolor="#E6E6E6">%Bi</td>
			<td align="center" bgcolor="#E6E6E6">%Ag</td>
			<td align="center" bgcolor="#E6E6E6">%Co</td>
			<td align="center" bgcolor="#E6E6E6">%Al</td>
			<td align="center" bgcolor="#E6E6E6">%S</td>
			<td align="center" bgcolor="#E6E6E6">%Zr</td>
  		</tr>
		<tr bgcolor="#FFFFFF">
			<td align="center"><strong><?php echo $t; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="28" align="center" bgcolor="#FFFFFF">&nbsp;</td>
			<td align="center" bgcolor="#E6E6E6">%Au</td>
			<td align="center" bgcolor="#E6E6E6">%B</td>
			<td align="center" bgcolor="#E6E6E6">%Ti</td>
			<td align="center" bgcolor="#E6E6E6">%Se</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Cu</td>
  		</tr>
		<tr bgcolor="#FFFFFF">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoCo(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6">
			<td align="center" width="15%">Referencia</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Sn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Ni(**)</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu()***</td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaQuimicoAl($t){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Cu</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Mg</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">%Ti</td>
			<td align="center" width="08%">%Pb</td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
		<tr>
			<td height="28" align="center" bgcolor="#FFFFFF"><strong><?php echo $t; ?></strong></td>
			<td align="center" bgcolor="#E6E6E6">%Sn</td>
			<td align="center" bgcolor="#E6E6E6">%Bi</td>
			<td align="center" bgcolor="#E6E6E6">%Zr</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Al</td>
  		</tr>
		<tr bgcolor="#FFFFFF">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoAl(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6">
			<td align="center" width="15%">Referencia</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Sn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Ni(**)</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu()***</td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

?>