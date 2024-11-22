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
					include_once('tabQuimicos2.php');
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
			echo '<b>'.$letraItem.'.- <span style="text-decoration:underline;">Observaciones:</span></b>';
		?>
		</p>
		<p style="text-indent: 60px;" align="justify">
			No presenta.
		</p>

		<p>
		<?php
			$letraItem++;
			echo '<b>'.$letraItem.'.- <span style="text-decoration:underline;">Comentarios:</span></b>';
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
							$firma = 'http://erp.simet.cl/ft/'.$rowUsuarios[firmaUsr];
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
							$firma = 'http://erp.simet.cl/ft/'.$rowUsuarios[firmaUsr];
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
							echo $rowUsuarios[titPie].$rowUsuarios[usuario].'<br>';
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
							echo $rowUsuarios[titPie].$rowUsuarios[usuario].'<br>';
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
function tablaQuimicoSR($t){
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

function tablaQuimicoCoSR($t){
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
		<tr bgcolor="#FFFFFF" align="center">
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

function tablaQuimicoAl($t){
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

function tablaTraccionRe($t){
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
function RefTablaTraccionRe(){
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

function tablaTraccionPl($t){
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

function tablaCharpy($t){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
		  	<td width="15%" rowspan="2" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="4" align="center">
		   		Energía de impacto a -20°C<br>
				(Joule)
			</td>
  		</tr>
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="8%">
				Muestra N° 1
			</td>
			<td align="center" width="8%">
				Muestra N° 2
			</td>
			<td align="center" width="8%">
				Muestra N° 3
			</td>
			<td align="center" width="8%">
				Promedio
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php
}
function RefTablaCharpy(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td align="center"><strong>Referencia según especificación del cliente</strong></td>
			<td width="8%" align="center">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaDureza($t, $n){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
		  	<td width="15%" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n; ?>" align="center">
				Dureza <br>
				Rockwell C
			</td>
  		    <td height="41" align="center">Promedio</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<?php
				for($i=1; $i<=$n; $i++){
					echo '<td width="8%">'.$i.'</td>';
				}
			?>
			<td width="8%">&nbsp;</td>
		</tr>
	</table>
	<?php
}
function RefTablaDureza(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td align="center"><strong>Referencia según especificación del cliente</strong></td>
			<td width="8%" align="center">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

?>
