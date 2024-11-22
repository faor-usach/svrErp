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
	$nMuestras 			= $rowInf[nMuestras];
	$tipoMuestra		= $rowInf[tipoMuestra];
	$tpEnsayo			= $rowInf[tpEnsayo];
	$fechaRecepcion 	= $rowInf[fechaRecepcion];
	$fechaInforme 		= $rowInf[fechaInforme];
	$RutCli				= $rowInf[RutCli];
	$ingResponsable		= $rowInf[ingResponsable];
	$cooResponsable		= $rowInf[cooResponsable];
	$CodigoVerificacion = $rowInf[CodigoVerificacion];
	$imgQR 				= $rowInf[imgQR];
	$imgMuestra			= $rowInf[imgMuestra];
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
	font-size:0.85em;
}
.ftoTablaResultado {
	font-size:0.8em; 
	width:100%;
	border:4px double #000000;
	background-color:#CCCCCC;
}
.ftoTablaResultado td{
	height:30px;
}
.tablaId {
	width:100%;
	border:4px double #000;
	background-color:#CCCCCC;
}
.tablaId td{
	height:30px;
}
</style>

</head>
<body>
	<table cellpadding="0" cellspacing="0" style="font-family:Arial;width:100%;border:4px solid #000;">
    	<tr>
			<td width="20%"><b>Cliente</b></td>
			<td colspan="3">: <strong><?php echo $Cliente; ?></strong></td>
		</tr>
        <tr>
			<td><b>Direcci&oacute;n</b></td>
			<td colspan="3">: <?php echo $Direccion; ?></td>
		</tr>
        <tr>
			<td><b>Tipo de Muestra</b></td>
			<td colspan="3">: 
				<?php echo $tipoMuestra; ?>
			</td>
		</tr>
        <tr>
			<td><b>Cantidad</b></td>
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
			<td><b>Tipo de Ensayo</b></td>
			<td width="29%">: 
				<?php
					$link=Conectarse();
					$bdTpEns=mysql_query("Select * From amTpEnsayo Where tpEnsayo = '".$tpEnsayo."'");
					if($rowTpEns=mysql_fetch_array($bdTpEns)){
						echo $rowTpEns[Ensayo];
					}
					mysql_close($link);
				?>
			</td>
			<td width="35%"><b>Fecha de Recepci&oacute;n</b></td>
			<td width="16%">:
				<?php
					$fd = explode('-',$fechaRecepcion);
					echo $fd[2].'-'.$fd[1].'-'.$fd[0];
				?>
			</td>
    	</tr>
        <tr>
			<td><b>Solicitante</b></td>
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
			<td><b>Fecha de Emisi&oacute;n Informe</b></td>
			<td>: 
							<?php
								$fd = explode('-',$fechaInforme);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0];
							?>
			</td>
       	</tr>
 	</table>
				
	<?php $letraItem = 'A'; ?>
				
	<p>
		<span style="text-decoration:underline;"><b><?php echo $letraItem; ?>.- Identificación de las Muestras</b></span>
	</p>
	
	<table cellpadding="0" cellspacing="0" class="tablaId" >
		<tr>
			<td align="center">
				<b>
					ID<BR>
					ITEM
				</b>
			</td>
			<td style="padding-left:10px;">
				<b>
					Identificación del Cliente
				</b>
			</td>
		</tr>
			<?php
				$link=Conectarse();
				$bdMue=mysql_query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
				if($rowMue=mysql_fetch_array($bdMue)){
					do{?>
						<tr bgcolor="#FFFFFF" style="font-size:0.9em; padding-left:10px;">
							<td align="center"><b><?php echo $rowMue[idItem]; ?></b></td>
							<td>
								Se ha recibido una muestra, identificada por el cliente como "
								<?php 
									if($rowMue[idMuestra]) { 
										echo '<b><em>'.$rowMue[idMuestra].'</em></b>'; 
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
	
	<p style="margin-left:60px;">
		En la Figura <?php echo $letraItem; ?>.1 presenta una imagen de las muestras recibidas.
	</p>
	<p align="center">
		<?php
			if($imgMuestra){
				$fotoMuestra = "http://erp.simet.cl/generarinformes/imgMuestras/".$CodInforme."/".$imgMuestra;

				$directorio="imgMuestras/".$CodInforme;
				$foto 		= $directorio.'/'.$imgMuestra;
				$size 		= GetImageSize("$foto");
				$anchura	= $size[0]; 
				$altura		= $size[1];

				echo '<img src="'.$fotoMuestra.'" width="'.$anchura.'" height="'.$altura.'">';
			}else{
				echo '<img src="http://erp.simet.cl/imagenes/muestraImg.jpg">';
			}
		?>
	</p>
	<p align="center" style="font-size:0.9em;">
		<b>Figura <?php echo $letraItem; ?>.1</b> Imagen de las muestras recibidas.
	</p>

	<?php
		$link=Conectarse();
		$bdTabEns=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."'");
		if($rowTabEns=mysql_fetch_array($bdTabEns)){
			do{
				if($rowTabEns[idEnsayo]=='Qu'){
					include_once('tabQuimicos.php');
				}
				if($rowTabEns[idEnsayo]=='Tr'){
					include_once('tabTraccion.php');
				}
				if($rowTabEns[idEnsayo]=='Ch'){
					include_once('tabCharpy.php');
				}
				if($rowTabEns[idEnsayo]=='Du'){
					include_once('tabDureza.php');
				}
			}while($rowTabEns=mysql_fetch_array($bdTabEns));
		}
		mysql_close($link);
		?>
		
		<p>
		<?php
			$letraItem++;
			echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Observaciones:</span></b>';
		?>
		</p>
		<p style="text-indent: 60px;" align="justify">
			No presenta.
		</p>

		<p>
		<?php
			$letraItem++;
			echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Comentarios:</span></b>';
		?>
		</p>
		<p style="text-indent: 60px;" align="justify">
			No presenta.
		</p>

		<p>
			<span style="text-decoration:underline;"><strong>NOTAS:</strong></span>
		</p>
		<ul>
		<?php
			$impMediciones 	= 'No';
			$notaMe			= '';
			$link=Conectarse();
			$bdNot=mysql_query("SELECT * FROM amNotas Order By nNota Asc");
			if($rowNot=mysql_fetch_array($bdNot)){
				do{
					if($rowNot[idEnsayo]){
						$bdTabEns=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowNot[idEnsayo]."'");
						if($rowTabEns=mysql_fetch_array($bdTabEns)){
							?>
							<li style="list-style-type:square; text-align:justify; font-size:0.8em;"><?php echo $rowNot[Nota]; ?> </li>
							<?php
							if($rowTabEns[idEnsayo] == 'Tr' or $rowTabEns[idEnsayo] == 'Ch'){
								$impMediciones 	= 'Si';
							}
						}
						if($rowNot[idEnsayo] == 'Me'){
							$notaMe	= $rowNot[Nota];
						}
					}else{
						?>
						<li style="list-style-type:square; text-align:justify; font-size:0.8em;"><?php echo $rowNot[Nota]; ?> </li>
						<?php
					}
				}while($rowNot=mysql_fetch_array($bdNot));
			}
			mysql_close($link);
			if($impMediciones == 'Si'){
				?>
					<li style="list-style-type:square; text-align:justify; font-size:0.8em;"><?php echo $notaMe; ?> </li>
				<?php
			}
		?>
		</ul>
		<table width="80%" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td align="center" valign="bottom" width="25%">
			  		<p align="center">
					<?php
						$link=Conectarse();
						$bdUsuarios=mysql_query("SELECT * FROM Usuarios Where usr = '".$ingResponsable."'");
						if($rowUsuarios=mysql_fetch_array($bdUsuarios)){
							$firma = 'http://erp.simet.cl/ft/'.$rowUsuarios['firmaUsr'];
							echo '<img src="'.$firma.'" width="206" height="116">';
						}
						mysql_close($link);
					?>
					</p>
				</td>
			  	<td rowspan="2" align="center" width="50%">
					<img src="http://erp.simet.cl/ft/timSim.png" width="185" height="185">
				</td>
			  	<td align="center" valign="bottom" width="25%">
			  		<p>
					<?php
						$link=Conectarse();
						$bdUsuarios=mysql_query("SELECT * FROM Usuarios Where usr = '".$cooResponsable."'");
						if($rowUsuarios=mysql_fetch_array($bdUsuarios)){
							$firma = 'http://erp.simet.cl/ft/'.$rowUsuarios['firmaUsr'];
							echo '<img src="'.$firma.'" width="206" height="116">';
						}
						mysql_close($link);
					?>
					</p>
				</td>
		  	</tr>
			<tr>
				<td valign="top" align="center" style="font-size:0.8em;">
					<?php
						echo '___________________________'.'<br>';
						$link=Conectarse();
						$bdUsuarios=mysql_query("SELECT * FROM Usuarios Where usr = '".$ingResponsable."'");
						if($rowUsuarios=mysql_fetch_array($bdUsuarios)){
							echo $rowUsuarios['titPie'].' '.$rowUsuarios[usuario].'<br>';
							echo '<b><i>'.$rowUsuarios[cargoUsr].'</i></b><br>';
							echo '<b><i>Laboratorio SIMET-USACH</i></b><br>';
						}
						mysql_close($link);
					?>
				</td>
			    <td valign="top" align="center" style="font-size:0.8em;">
					<?php
						echo '___________________________'.'<br>';
						$link=Conectarse();
						$bdUsuarios=mysql_query("SELECT * FROM Usuarios Where usr = '".$cooResponsable."'");
						if($rowUsuarios=mysql_fetch_array($bdUsuarios)){
							echo $rowUsuarios['titPie'].' '.$rowUsuarios['usuario'].'<br>';
							echo '<b><i>'.$rowUsuarios[cargoUsr].'</i></b><br>';
							echo '<b></i>Laboratorio SIMET-USACH</i></b><br>';
						}
						mysql_close($link);
					?>
				</td>
			</tr>
		</table>
		<p style="font-size:0.8em;">
			Verificación de este documento en <a href="http://simet.cl/verificacioninforme.php">http://simet.cl/verificacioninforme.php</a>
		</p>
		<p style="font-size:0.8em;">
			Código de Verificación: <?php echo $CodigoVerificacion; ?>
		</p>
		<div align="right">
		<?php
			$dirImg = "http://erp.simet.cl/codigoqr/phpqrcode/temp/$imgQR";
			echo '<img src="'.$dirImg.'" width="133" height="133"><br>';
		?>
		</div>
			
</body>
</html>

<?php
function tablaQuimicoSR($c, $t, $m){
		$bdRegQui=mysql_query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysql_fetch_array($bdRegQui)){
			$cC  = $rowRegQui[cC];
			$cSi = $rowRegQui[cSi];
			$cMn = $rowRegQui[cMn];
			$cP  = $rowRegQui[cP];
			$cS  = $rowRegQui[cS];
			$cCr = $rowRegQui[cCr];
			$cNi = $rowRegQui[cNi];
			$cMo = $rowRegQui[cMo];
			$cAl = $rowRegQui[cAl];
			$cCu = $rowRegQui[cCu];
			$cCo = $rowRegQui[cCo];
			$cTi = $rowRegQui[cTi];
			$cNb = $rowRegQui[cNb];
			$cV  = $rowRegQui[cV];
			$cW  = $rowRegQui[cW];
			$cSn = $rowRegQui[cSn];
			$cB  = $rowRegQui[cB];
			$cFe = $rowRegQui[cFe];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Mo</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center">&nbsp;</td>
			<td align="center"><?php echo $cC; ?></td>
			<td align="center"><?php echo $cSi; ?></td>
			<td align="center"><?php echo $cMn; ?></td>
			<td align="center"><?php echo $cP; ?></td>
			<td align="center"><?php echo $cS; ?></td>
			<td align="center"><?php echo $cCr; ?></td>
			<td align="center"><?php echo $cNi; ?></td>
			<td align="center"><?php echo $cMo; ?></td>
			<td align="center"><?php echo $cAl; ?></td>
			<td align="center"><?php echo $cCu; ?></td>
  		</tr>
		<tr style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
			<td>&nbsp;</td>
			<td><?php echo $cCo; ?></td>
			<td><?php echo $cTi; ?></td>
			<td><?php echo $cNb; ?></td>
			<td><?php echo $cV; ?></td>
			<td><?php echo $cW; ?></td>
			<td><?php echo $cSn; ?></td>
			<td><?php echo $cB; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><b>Resto</b></td>
		</tr>
	</table>
	<?php
}

function tablaQuimicoCR($t){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Mo</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
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
		<tr style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
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
			<td><b>Resto</b></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoCR(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
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

function tablaQuimicoCoSR($c, $t, $m){
		$bdRegQui=mysql_query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysql_fetch_array($bdRegQui)){
			$cC  = $rowRegQui[cC];
			$cSi = $rowRegQui[cSi];
			$cMn = $rowRegQui[cMn];
			$cP  = $rowRegQui[cP];
			$cS  = $rowRegQui[cS];
			$cCr = $rowRegQui[cCr];
			$cNi = $rowRegQui[cNi];
			$cMo = $rowRegQui[cMo];
			$cAl = $rowRegQui[cAl];
			$cCu = $rowRegQui[cCu];
			$cCo = $rowRegQui[cCo];
			$cTi = $rowRegQui[cTi];
			$cNb = $rowRegQui[cNb];
			$cV  = $rowRegQui[cV];
			$cW  = $rowRegQui[cW];
			$cPb = $rowRegQui[cPb];
			$cB  = $rowRegQui[cB];
			$cSn = $rowRegQui[cSn];
			$cZn = $rowRegQui[cZn];
			$cAs = $rowRegQui[cAs];
			$cBi = $rowRegQui[cBi];
			$cTa = $rowRegQui[cTa];
			$cCa = $rowRegQui[cCa];
			$cCe = $rowRegQui[cCe];
			$cZr = $rowRegQui[cZr];
			$cLa = $rowRegQui[cLa];
			$cSe = $rowRegQui[cSe];
			$cN  = $rowRegQui[cN];
			$cFe = $rowRegQui[cFe];
			$cMg = $rowRegQui[cMg];
			$cTe = $rowRegQui[cTe];
			$cCd = $rowRegQui[cCd];
			$cAg = $rowRegQui[cAg];
			$cAu = $rowRegQui[cAu];
			$cAi = $rowRegQui[cAi];
			$cSb = $rowRegQui[cSb];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td><?php echo $cZn; ?></td>
			<td><?php echo $cPb; ?></td>
			<td><?php echo $cSn; ?></td>
			<td><?php echo $cP; ?></td>
			<td><?php echo $cMn; ?></td>
			<td><?php echo $cFe; ?></td>
			<td><?php echo $cNi; ?></td>
			<td><?php echo $cSi; ?></td>
			<td><?php echo $cMg; ?></td>
			<td><?php echo $cCr; ?></td>
  		</tr>
		<tr style="font-weight:700;" align="center">
			<td height="28" align="center" bgcolor="#FFFFFF">&nbsp;</strong></td>
			<td align="center" bgcolor="#E6E6E6">%Te</td>
			<td align="center" bgcolor="#E6E6E6">%As</td>
			<td align="center" bgcolor="#E6E6E6">%Sb</td>
			<td align="center" bgcolor="#E6E6E6">%Cd</td>
			<td align="center" bgcolor="#E6E6E6">%Bi</td>
			<td align="center" bgcolor="#E6E6E6">%Ag</td>
			<td align="center" bgcolor="#E6E6E6">%Co</td>
			<td align="center" bgcolor="#E6E6E6">%Ai</td>
			<td align="center" bgcolor="#E6E6E6">%S</td>
			<td align="center" bgcolor="#E6E6E6">%Zr</td>
  		</tr>
		<tr bgcolor="#FFFFFF" align="center">
			<td align="center"><strong><?php echo $t; ?></td>
			<td><?php echo $cTe; ?></td>
			<td><?php echo $cAs; ?></td>
			<td><?php echo $cSb; ?></td>
			<td><?php echo $cCd; ?></td>
			<td><?php echo $cBi; ?></td>
			<td><?php echo $cAg; ?></td>
			<td><?php echo $cCo; ?></td>
			<td><?php echo $cAi; ?></td>
			<td><?php echo $cS; ?></td>
			<td><?php echo $cZr; ?></td>
		</tr>
		<tr style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
			<td>&nbsp;</td>
			<td><?php echo $Au; ?></td>
			<td><?php echo $cB; ?></td>
			<td><?php echo $cTi; ?></td>
			<td><?php echo $cSe; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $cCu; ?></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoCo(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
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

function tablaQuimicoAl($c, $t, $m){
		$bdRegQui=mysql_query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysql_fetch_array($bdRegQui)){
			$cC  = $rowRegQui[cC];
			$cSi = $rowRegQui[cSi];
			$cMn = $rowRegQui[cMn];
			$cP  = $rowRegQui[cP];
			$cS  = $rowRegQui[cS];
			$cCr = $rowRegQui[cCr];
			$cNi = $rowRegQui[cNi];
			$cMo = $rowRegQui[cMo];
			$cAl = $rowRegQui[cAl];
			$cCu = $rowRegQui[cCu];
			$cCo = $rowRegQui[cCo];
			$cTi = $rowRegQui[cTi];
			$cNb = $rowRegQui[cNb];
			$cV  = $rowRegQui[cV];
			$cW  = $rowRegQui[cW];
			$cPb = $rowRegQui[cPb];
			$cB  = $rowRegQui[cB];
			$cSn = $rowRegQui[cSn];
			$cZn = $rowRegQui[cZn];
			$cAs = $rowRegQui[cAs];
			$cBi = $rowRegQui[cBi];
			$cTa = $rowRegQui[cTa];
			$cCa = $rowRegQui[cCa];
			$cCe = $rowRegQui[cCe];
			$cZr = $rowRegQui[cZr];
			$cLa = $rowRegQui[cLa];
			$cSe = $rowRegQui[cSe];
			$cN  = $rowRegQui[cN];
			$cFe = $rowRegQui[cFe];
			$cMg = $rowRegQui[cMg];
			$cTe = $rowRegQui[cTe];
			$cCd = $rowRegQui[cCd];
			$cAg = $rowRegQui[cAg];
			$cAu = $rowRegQui[cAu];
			$cAi = $rowRegQui[cAi];
			$cSb = $rowRegQui[cSb];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td><?php echo $cSi; ?></td>
			<td><?php echo $cFe; ?></td>
			<td><?php echo $cCu; ?></td>
			<td><?php echo $cMn; ?></td>
			<td><?php echo $cMg; ?></td>
			<td><?php echo $cCr; ?></td>
			<td><?php echo $cNi; ?></td>
			<td><?php echo $cZn; ?></td>
			<td><?php echo $cTi; ?></td>
			<td><?php echo $cPb; ?></td>
  		</tr>
		<tr style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
			<td>&nbsp;</td>
			<td><?php echo $cSn; ?></td>
			<td><?php echo $cBi; ?></td>
			<td><?php echo $cZr; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $cAl; ?></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoAl(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
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
		<tr bgcolor="#FFFFFF" align="center">
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

function tablaTraccionRe($c, $t, $m){
		$bdRegTra=mysql_query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysql_fetch_array($bdRegTra)){
			$aIni = $rowRegTra[aIni];
			$cFlu = $rowRegTra[cFlu];
			$cMax = $rowRegTra[cMax];
			$tFlu = $rowRegTra[tFlu];
			$tMax = $rowRegTra[tMax];
			$aSob = $rowRegTra[aSob];
			$rAre = $rowRegTra[rAre];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="8%">
				Área<br>Inicial<br> (mm<sup>2</sub>)
			</td>
			<td align="center" width="8%">
				Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
			</td>
			<td align="center" width="8%">
				Carga<br>Máxima<br>(Kgf)
			</td>
			<td align="center" width="8%">
				Tensión de<br>Fluencia<br>0,2% Def,<br> (MPa)
			</td>
			<td align="center" width="8%">
				Tensión<br>Máxima<br>(MPa)			
			</td>
			<td align="center" width="8%">
				Alarg,<br>Sobre 50<br>mm<br>(%)
			</td>
			<td align="center" width="8%">
				Red.<br>de Área<br> (%)
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<td><?php echo number_format($aIni, 1, ',', '.'); ?></td>
			<td><?php echo number_format($cFlu, 1, ',', '.'); ?></td>
			<td><?php echo number_format($cMax, 1, ',', '.'); ?></td>
			<td><?php echo number_format($tFlu, 1, ',', '.'); ?></td>
			<td><?php echo number_format($tMax, 1, ',', '.'); ?></td>
			<td><?php echo number_format($aSob, 1, ',', '.'); ?></td>
			<td><?php echo number_format($rAre, 1, ',', '.'); ?></td>
  		</tr>
	</table>
	<?php
}

function RefTablaTraccionRe($c, $t, $m){
		$bdRegTra=mysql_query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysql_fetch_array($bdRegTra)){
			$aIni = $rowRegTra[aIni];
			$cFlu = $rowRegTra[cFlu];
			$cMax = $rowRegTra[cMax];
			$tFlu = $rowRegTra[tFlu];
			$tMax = $rowRegTra[tMax];
			$aSob = $rowRegTra[aSob];
			$rAre = $rowRegTra[rAre];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td width="39%" colspan="4" align="center"><strong>Referencia</strong></td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaTraccionPl($c, $t, $m){
		$bdRegTra=mysql_query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysql_fetch_array($bdRegTra)){
			$aIni = $rowRegTra[aIni];
			$cFlu = $rowRegTra[cFlu];
			$cMax = $rowRegTra[cMax];
			$tFlu = $rowRegTra[tFlu];
			$tMax = $rowRegTra[tMax];
			$aSob = $rowRegTra[aSob];
			$rAre = $rowRegTra[rAre];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="8%">
				Área<br>Inicial<br> (mm<sup>2</sub>)
			</td>
			<td align="center" width="8%">
				Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
			</td>
			<td align="center" width="8%">
				Carga<br>Máxima<br>(Kgf)
			</td>
			<td align="center" width="8%">
				Tensión de<br>Fluencia<br>0,2% Def,<br> (MPa)
			</td>
			<td align="center" width="8%">
				Tensión<br>Máxima<br>(MPa)			
			</td>
			<td align="center" width="8%">
				Alarg,<br>Sobre 50<br>mm<br>(%)
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<td><?php echo number_format($aIni, 1, ',', '.'); ?></td>
			<td><?php echo number_format($cFlu, 1, ',', '.'); ?></td>
			<td><?php echo number_format($cMax, 1, ',', '.'); ?></td>
			<td><?php echo number_format($tFlu, 1, ',', '.'); ?></td>
			<td><?php echo number_format($tMax, 1, ',', '.'); ?></td>
			<td><?php echo number_format($aSob, 1, ',', '.'); ?></td>
		</tr>
	</table>
	<?php
}
function RefTablaTraccionPl(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td width="39%" colspan="4" align="center"><strong>Referencia</strong></td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaCharpy($c, $t, $m, $n, $tem){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
		  	<td width="15%" rowspan="2" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n+1; ?>" align="center">
		   		Energía de impacto a <?php echo $tem; ?><br>
				(Joule)
			</td>
  		</tr>
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<?php for($i=1; $i<=$n ; $i++){ ?>
				<td align="center" width="8%">
					Muestra N° <?php echo $i; ?>
				</td>
			<?php } ?>
			<td align="center" width="8%">
				Promedio
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<?php
				$sImpactos 	= 0;
				$Media 		= 0;
				for($i=1; $i<=$n; $i++){
					$bdRegCh=mysql_query("SELECT * FROM regCharpy Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."' and nImpacto = '".$i."'");
					if($rowRegCh=mysql_fetch_array($bdRegCh)){
						$vImpacto = $rowRegCh[vImpacto];
					}
					$sImpactos += $vImpacto;
					$Media = $sImpactos / $n;
					echo '<td width="8%">'.number_format($vImpacto, 1, ',', '.').'</td>';
				}
			?>
			<td width="8%"><?php echo number_format($Media, 1, ',', '.'); ?></td>
		</tr>
	</table>
	<?php
}
function RefTablaCharpy($c, $t, $m, $n, $tem){
	$por = $n * 8;
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
			<td align="center" width="15%">&nbsp;</td>
		  	<td align="center" width="<?php echo $por; ?>%" colspan="<?php echo $n; ?>"><strong>Referencia según especificación del cliente</strong></td>
			<td align="center" width="8%">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaDureza($c, $t, $m, $n){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
		  	<td width="15%" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n; ?>" align="center">
				Dureza <br>
				Rockwell <?php echo strtoupper(substr($m,2,1)); ?>
			</td>
  		    <td height="41" align="center">Promedio</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<?php
				$sDoblado 	= 0;
				$Media 		= 0;
				for($i=1; $i<=$n; $i++){
					$bdRegDob=mysql_query("SELECT * FROM regDoblado Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."' and nIndenta = '".$i."'");
					if($rowRegDob=mysql_fetch_array($bdRegDob)){
						$vIndenta = $rowRegDob[vIndenta];
					}
					$sDoblado += $vIndenta;
					$Media = $sDoblado / $n;
					echo '<td width="8%">'.number_format($vIndenta, 1, ',', '.').'</td>';
				}
			?>
			<td width="8%"><?php echo number_format($Media, 1, '.', ','); ?></td>
		</tr>
	</table>
	<?php
}
function RefTablaDureza($c, $t, $m, $n){
	$por = $n * 8;
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
			<td align="center" width="15%">&nbsp;</td>
		  	<td align="center" width="<?php echo $por; ?>%" colspan="<?php echo $n; ?>"><strong>Referencia según especificación del cliente</strong></td>
			<td align="center" width="8%">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

?>
