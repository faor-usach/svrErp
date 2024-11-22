<?php
include_once("../conexionli.php");
if(isset($_GET['CodInforme'])) 	{ $CodInforme	= $_GET['CodInforme']; 	}
if(isset($_GET['accion'])) 		{ $accion 		= $_GET['accion'];		}
header('Content-Type: text/html; charset=utf-8');


$nomInforme = $CodInforme.'.doc';

//chmod('../fxxx', 0755);

//Exportar datos de php a Word
header("Content-Type: application/vnd.ms-word");
header("content-disposition: attachment;filename=$nomInforme");
/*
header("Content-Transfer-Encoding: binary ");
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
*/

$link=Conectarse();
$bdInf=$link->query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
if($rowInf=mysqli_fetch_array($bdInf)){
	$nMuestras 			= $rowInf['nMuestras'];
	$tipoMuestra		= $rowInf['tipoMuestra'];
	$tpEnsayo			= $rowInf['tpEnsayo'];
	$fechaRecepcion 	= $rowInf['fechaRecepcion'];
	$fechaInforme 		= $rowInf['fechaInforme'];
	$RutCli				= $rowInf['RutCli'];
	$ingResponsable		= $rowInf['ingResponsable'];
	$cooResponsable		= $rowInf['cooResponsable'];
	$CodigoVerificacion = $rowInf['CodigoVerificacion'];
	$imgQR 				= $rowInf['imgQR'];
	$imgMuestra			= $rowInf['imgMuestra'];
}
$Cliente 	= '';
$Direccion 	= '';

$bdCli=$link->query("Select * From Clientes Where RutCli = '".$RutCli."'");
if($rowCli=mysqli_fetch_array($bdCli)){
	$Cliente 	= $rowCli['Cliente'];
	$Direccion 	= $rowCli['Direccion'];
}
$link->close();
?>
<HTML LANG="es">
<head>
<TITLE>::. Exportacion de Datos .::</TITLE>
<!-- <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\"> -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
	font-family:Arial;
	font-size:0.85em;
}

.blanco {
	display:block;
	margin:0% 0;
	line-height:150%;
}
.parrafoPie {
	display:block;
	margin:0% 0;
	line-height:100%;
}
.blancoSubTitulos{
	display:block;
	margin:0% 0;
	line-height:100%;
}
/* +++ */
.ftoTablaResultado {
	font-size		:0.8em; 
	width			:35.44em;
	border			:1px double #000;
	background-color:#E6E6E6;
}
.ftoTablaResultado td{
	height			:1.65em;
}
.tResQ1 {
	width			:6em;
}
.tResQ2-10 {
	width			:4.2em;
}
.tResT2-6 {
	font-size		:12px; 
	width			:4.2em;
	line-height		:150%;
}
/* +++ */

.tablaId {
	width			:35.44em;
	border			:1px double #000;
	background-color:#E6E6E6;
}
.tablaId td{
	height			:2.13em;
	/* height:30px; */
}
.tablaIdCol1{
/*	width			:5.15em; */
	font-size		:12px;
	width:10%;
}
.tablaIdCol2{
/*	width			:5.15em; */
	font-size		:12px;
	width:90%;
}

.tablaExternaNegra{
	font-family:Arial;
	border:2px solid #000; 
	background-color:#000000; 
	width:96%;
}
.tablaInternaNegra{
	font-family:Arial;
	width:100%;
	border:1px double #000; 
	background-color:#FFFFFF;
}

#tablaExternaNegra2{
	border:4px solid #000; 
	width:35.44em;
}
#tablaExternaNegra2 td{
	font-family:Arial;
	font-size:13,5px;
}
.c1{
	width		:10.5em;
	height		:0.97em;
}
.c2{
	width:1.48em;
}
.c3{
	width:13.55em;
}
.c4{
	width:14.95em;
}
.c5{
	width:1.48em;
}
.c6{
	width:5.8em;
}
.inter15{
	text-indent: 60px; 
	line-height:150%;
	text-align:justify;
	margin: 0 auto;	
}
</style>

</head>
<body>
	<?php $letraItem = 'A'; ?>
	<table cellpadding="0" cellspacing="0" id="tablaExternaNegra2" align="center">
		<tr>
			<td class="c1"><b>Cliente</b></td>
			<td class="c2"><b>:</b></td>
			<td colspan="4">
				<b>
				<?php 
					echo utf8_decode($Cliente);
				?>
				</b>
			</td>
		</tr>
		<tr>
			<td class="c1"><b>Direcci&oacute;n</b></td>
			<td class="c2"><b>:</b></td>
			<td colspan="4"><?php echo utf8_decode($Direccion); ?></td>
		</tr>
		<tr>
			<td class="c1"><b>Tipo de Muestra</b></td>
			<td class="c2"><b>:</b></td>
			<td colspan="4"><?php echo utf8_decode($tipoMuestra); ?></td>
		</tr>
		<tr>
			<td class="c1"><b>Cantidad</b></td>
			<td class="c2"><b>:</b></td>
			<td colspan="4">
				<?php 
					if($nMuestras < 10){
						$nMuestras = '0'.$nMuestras;
					}
					echo $nMuestras;
				?>
			</td>
		</tr>
		<tr>
			<td class="c1"><b>Tipo de Ensayo</b></td>
			<td class="c2"><b>:</b></td>
			<td class="c3">
				<?php
					$tipoEnsayo = utf8_decode('Caracterización');
					$link=Conectarse();
					$bdTpEns=$link->query("Select * From amTpEnsayo Where tpEnsayo = '".$tpEnsayo."'");
					if($rowTpEns=mysqli_fetch_array($bdTpEns)){
						$tipoEnsayo = utf8_decode($rowTpEns['Ensayo']);
					}
					$link->close();
					echo $tipoEnsayo;
				?>
			</td>
			<td class="c4"><b>Fecha de Recepci&oacute;n</b></td>
			<td class="c5"><b>:</b></td>
			<td class="c6">
				<?php
					$fd = explode('-',$fechaRecepcion);
					echo $fd[2].'-'.$fd[1].'-'.substr($fd[0],2,2);
				?>
			</td>
		</tr>
		<tr>
			<td class="c1"><b>Solicitante</b></td>
			<td class="c2"><b>:</b></td>
			<td class="c3">
				<?php
					$Ra = explode('-',$CodInforme);
					$link=Conectarse();
					$bdCot=$link->query("SELECT * FROM Cotizaciones Where RAM = '".$Ra[1]."'");
					if($rowCot=mysqli_fetch_array($bdCot)){
						$bdCli=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowCot['RutCli']."' and nContacto = '".$rowCot['nContacto']."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							echo '<strong>'.ucwords(strtolower(utf8_decode($rowCli['Contacto']))).'</strong>';
						}
					}
					$link->close();
				?>
			</td>
			<td class="c4"><b>Fecha de Emisi&oacute;n Informe</b></td>
			<td class="c5"><b>:</b></td>
			<td class="c6">
				<?php
					$fd = explode('-',$fechaInforme);
					echo $fd[2].'-'.$fd[1].'-'.substr($fd[0],2,2);
				?>
			</td>
		</tr>
	</table>
	
	<p class="blanco" >&nbsp;</p>
	<p class="blanco" >&nbsp;</p>
			
	<p class="blancoSubTitulos">
		<span style="text-decoration:underline; font-weight:700;"><?php echo $letraItem; ?>.- Identificaci&oacute;n de la Muestra:</span>
	</p>

	<p class="blanco" >&nbsp;</p>

	<!-- Ok -->
	<table cellpadding="0" cellspacing="0" class="tablaId" align="center">
		<tr class="tablaIdCol1">
			<td align="center">
				<b>
					ID<BR>
					ITEM
				</b>
			</td>
			<td class="tablaIdCol2">
				<b>
					 <div style="margin-left:10px;">Identificaci&oacute;n del Cliente</div>
				</b>
			</td>
		</tr>
			<?php
				$link=Conectarse();
				$bdMue=$link->query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
				if($rowMue=mysqli_fetch_array($bdMue)){
					do{
					?>
					
						<tr bgcolor="#FFFFFF" style="font-size:0.8em; padding-left:10px;">
							<td style="line-height:100%;" align="center"><b><?php echo $rowMue['idItem']; ?></b></td>
							<td style="line-height:100%;">
								Se ha recibido una muestra, identificada por el cliente como: '
								<?php 
									if($rowMue['idMuestra']) { 
										echo '<b><em>'.utf8_decode($rowMue['idMuestra']).'</em></b>'; 
									}else{
										echo 'SIN IDENTIFICAR'; 
									} 
								?>
								'
							</td>
						</tr>
						<?php 
					}while($rowMue=mysqli_fetch_array($bdMue));
				}
				$link->close();
			?>
	</table>

	<!-- Ok -->
	<p class="blanco" >&nbsp;</p>
	<p class="blanco" >&nbsp;</p>

	<p style="margin-left:60px;" class="blanco">
		En la figura <?php echo $letraItem; ?>.1 se presenta una imagen de la muestra recibida.
	</p>

	<p class="blanco" >&nbsp;</p>
	<p class="blanco" >&nbsp;</p>

	<p align="center">
		<?php
			if($imgMuestra){
				//$fotoMuestra = "http://erp.simet.cl/generarinformes/imgMuestras/".$CodInforme."/".$imgMuestra;
				$fotoMuestra = "http://servidorerp/erp/generarinformes/imgMuestras/".$CodInforme."/".$imgMuestra;

				$directorio="imgMuestras/".$CodInforme;
				$directorio="http://servidorerp/erp/generarinformes/imgMuestras/".$CodInforme;

				$foto 		= $directorio.'/'.$imgMuestra;
				$size 		= getimagesize("$foto");
				$anchura	= $size[0]; 
				$altura		= $size[1];
				echo '<img src="'.$fotoMuestra.'" width="'.$anchura.'" height="'.$altura.'">';
				//echo '<img src="'.$fotoMuestra.'">';
			}else{
				echo '<img src="http://servidorerp/erp/imagenes/muestraImg.jpg">';
			}
		?>
	</p>

	<p class="blanco" >&nbsp;</p>
	<p class="blanco" >&nbsp;</p>

	<p align="center" style="font-size:0.9em;" class="blanco">
		<b>Figura <?php echo $letraItem; ?>.1</b> Imagen de la muestra recibida.
	</p>

	<p class="blanco" >&nbsp;</p>
	<p class="blanco" >&nbsp;</p>

	<?php
		$link=Conectarse();
		$bdEns=$link->query("SELECT * FROM amEnsayos Order By nEns");
		if($rowEns=mysqli_fetch_array($bdEns)){
			do{
				$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."'");
				if($rowTabEns=mysqli_fetch_array($bdTabEns)){
					do{
						if($rowTabEns['cEnsayos'] > 0 ){
							if($rowTabEns['idEnsayo']=='Qu'){
								include_once('tabQuimicosNew.php');
							}
							if($rowTabEns['idEnsayo']=='Tr'){
								include_once('tabTraccionNew.php');
							}
							if($rowTabEns['idEnsayo']=='Do'){
								include_once('tabDobladoNew.php');
							}
							if($rowTabEns['idEnsayo']=='Du'){
								include_once('tabDurezaNew.php');
							}
							if($rowTabEns['idEnsayo']=='Ch'){
								include_once('tabCharpyNew.php');
							}
						}
					}while($rowTabEns=mysqli_fetch_array($bdTabEns));
				}
			}while($rowEns=mysqli_fetch_array($bdEns));
		}
		$link->close();
		?>
		
		<p class="blanco" >&nbsp;</p>

		<p class="blancoSubTitulos">
		<?php
			$letraItem++;
			echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Observaciones:</span></b>';
		?>
		</p>

		<p class="blanco" >&nbsp;</p>

		<p style="text-indent: 60px;" align="justify" class="blanco">
			No presenta.
		</p>

		<p class="blanco" >&nbsp;</p>

		<p class="blancoSubTitulos">
		<?php
			$letraItem++;
			echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Comentarios:</span></b>';
		?>
		</p>
		
		<p class="blanco" >&nbsp;</p>
		
		<p style="text-indent: 60px;" align="justify" class="blanco">
			No presenta.
		</p>

		<p class="blanco" >&nbsp;</p>

		<p class="blancoSubTitulos">
			<span style="text-decoration:underline; font-size:0.8em;"><b>NOTAS:</b></span>
		</p>
		<ul>
		<?php
			$impMediciones 	= 'No';
			$notaMe			= '';
			$link=Conectarse();
			$bdNot=$link->query("SELECT * FROM amNotas Order By nNota Asc");
			if($rowNot=mysqli_fetch_array($bdNot)){
				do{
					if($rowNot['idEnsayo']){
						$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowNot['idEnsayo']."'");
						if($rowTabEns=mysqli_fetch_array($bdTabEns)){
							?>
							<li style="list-style-type:square; text-align:justify; font-size:0.8em;" class="parrafoPie"><?php echo utf8_decode($rowNot['Nota']); ?> </li>
							<?php
							if($rowTabEns['idEnsayo'] == 'Tr' or $rowTabEns['idEnsayo'] == 'Ch'){
								$impMediciones 	= 'Si';
							}
						}
						if($rowNot['idEnsayo'] == 'Me'){
							$notaMe	= utf8_decode($rowNot['Nota']);
						}
					}else{
						?>
						<li style="list-style-type:square; text-align:justify; font-size:0.8em;" class="parrafoPie"><?php echo utf8_decode($rowNot['Nota']); ?> </li>
						<?php
					}
				}while($rowNot=mysqli_fetch_array($bdNot));
			}
			$link->close();
			if($impMediciones == 'Si'){
				?>
					<li style="list-style-type:square; text-align:justify; font-size:0.8em;" class="parrafoPie"><?php echo $notaMe; ?> </li>
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
						$bdUsuarios=$link->query("SELECT * FROM Usuarios Where usr = '".$ingResponsable."'");
						if($rowUsuarios=mysqli_fetch_array($bdUsuarios)){
							$fusr = $rowUsuarios['firmaUsr'];
							$firma = 'http://servidorerp/erp/fxxx/'.$fusr;
							echo '<img src="'.$firma.'" width="206" height="116"> ';
						}
						$link->close();
					?>
					</p>
				</td>
			  	<td rowspan="2" align="center" width="50%">
					<img src="http://servidorerp/erp/fxxx/timSim.png" width="185" height="185">
				</td>
			  	<td align="center" valign="bottom" width="25%">
			  		<p>
					<?php
						$link=Conectarse();
						$bdUsuarios=$link->query("SELECT * FROM Usuarios Where usr = '".$cooResponsable."'");
						if($rowUsuarios=mysqli_fetch_array($bdUsuarios)){
							$fusr = $rowUsuarios['firmaUsr'];
							//$firma = 'http://erp.simet.cl/fxxx/'.$fusr;
							$firma = 'http://servidorerp/erp/fxxx/'.$fusr;
							echo '<img src="'.$firma.'" width="206" height="116"> ';
						}
						$link->close();
					?>
					</p>
				</td>
		  	</tr>
			<tr>
				<td valign="top" align="center" style="font-size:0.8em;">
					<?php
						echo '___________________________'.'<br>';
						$link=Conectarse();
						$bdUsuarios=$link->query("SELECT * FROM Usuarios Where usr = '".$ingResponsable."'");
						if($rowUsuarios=mysqli_fetch_array($bdUsuarios)){
							echo utf8_decode($rowUsuarios['titPie'].' '.$rowUsuarios['usuario']).'<br>';
							echo '<b>'.utf8_decode($rowUsuarios['cargoUsr']).'</b><br>';
							echo '<b>Laboratorio SIMET-USACH</b><br>';
						}
						$link->close();
					?>
				</td>
			    <td valign="top" align="center" style="font-size:0.8em;">
					<?php
						echo '___________________________'.'<br>';
						$link=Conectarse();
						$bdUsuarios=$link->query("SELECT * FROM Usuarios Where usr = '".$cooResponsable."'");
						if($rowUsuarios=mysqli_fetch_array($bdUsuarios)){
							echo utf8_decode($rowUsuarios['titPie'].' '.$rowUsuarios['usuario']).'<br>';
							echo '<b>'.utf8_decode($rowUsuarios['cargoUsr']).'</b><br>';
							echo '<b>Laboratorio SIMET-USACH</b><br>';
						}
						$link->close();
					?>
				</td>
			</tr>
		</table>
		<p style="font-size:0.9em;" align="justify">
			<b>Es de responsabilidad del receptor verificar la veracidad de este informe y que corresponda a la &uacute;ltima revisi&oacute;n, mediante el c&oacute;digo QR o en nuestra p&aacute;gina Web.</b>
		</p>
		<p style="font-size:0.9em;" align="justify">
			<b>Verificaci&oacute;n de este documento en <a style="font-size:1em;" href="http://simet.cl/verificacioninforme.php">http://simet.cl/verificacioninforme.php</a>, ingresando el n&uacute;mero de informe y el c&oacute;digo verificador.</b>
		</p>
		<p style="font-size:0.9em;">
			<b>C&oacute;digo de Verificaci&oacute;n: <?php echo $CodigoVerificacion; ?></b>
		</p>
		<div align="right">
		<?php
			//$dirImg = "http://erp.simet.cl/codigoqr/phpqrcode/temp/$imgQR";
			$dirImg = "http://servidorerp/erp/codigoqr/phpqrcode/temp/".$imgQR;
		?>
			<img src="<?php echo $dirImg; ?>" width="133" height="133"><br>
		</div>
		<?php
			//chmod('../fxxx', 0400);
		?>
</body>
</html>

<?php
function tablaQuimicoSR($c, $t, $m){
	global $link;
			$cC  = '';
			$cSi = '';
			$cMn = '';
			$cP  = '';
			$cS  = '';
			$cCr = '';
			$cNi = '';
			$cMo = '';
			$cAl = '';
			$cCu = '';
			$cCo = '';
			$cTi = '';
			$cNb = '';
			$cV  = '';
			$cW  = '';
			$cSn = '';
			$cB  = '';
			$cFe = '';

		$bdRegQui=$link->query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysqli_fetch_array($bdRegQui)){
			$cC  = $rowRegQui['cC'];
			$cSi = $rowRegQui['cSi'];
			$cMn = $rowRegQui['cMn'];
			$cP  = $rowRegQui['cP'];
			$cS  = $rowRegQui['cS'];
			$cCr = $rowRegQui['cCr'];
			$cNi = $rowRegQui['cNi'];
			$cMo = $rowRegQui['cMo'];
			$cAl = $rowRegQui['cAl'];
			$cCu = $rowRegQui['cCu'];
			$cCo = $rowRegQui['cCo'];
			$cTi = $rowRegQui['cTi'];
			$cNb = $rowRegQui['cNb'];
			$cV  = $rowRegQui['cV'];
			$cW  = $rowRegQui['cW'];
			$cSn = $rowRegQui['cSn'];
			$cB  = $rowRegQui['cB'];
			$cFe = $rowRegQui['cFe'];
		}
	?>

	<!-- Ok +- -->
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6">
			<td align="center" class="tResQ1">ID<br>ITEM</td>
			<td align="center" class="tResQ2-10"><b>%C</b></td>
			<td align="center" class="tResQ2-10"><b>%Si</b></td>
			<td align="center" class="tResQ2-10"><b>%Mn</b></td>
			<td align="center" class="tResQ2-10"><b>%P</b></td>
			<td align="center" class="tResQ2-10"><b>%S</b></td>
			<td align="center" class="tResQ2-10"><b>%Cr</b></td>
			<td align="center" class="tResQ2-10"><b>%Ni</b></td>
			<td align="center" class="tResQ2-10"><b>%Mo</b></td>
			<td align="center" class="tResQ2-10"><b>%Al</b></td>
			<td align="center" class="tResQ2-10"><b>%Cu</b></td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td style="line-height:150%;" rowspan="3" align="center"><b><?php echo $t; ?></b></td>
			<td style="line-height:150%;" align="center"><?php echo $cC; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cSi; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cMn; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cP; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cS; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cCr; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cNi; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cMo; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cAl; ?></td>
			<td style="line-height:150%;" align="center"><?php echo $cCu; ?></td>
  		</tr>
		<tr style="font-weight:700;" align="center">
			<td height="28" align="center" bgcolor="#E6E6E6"><b>%Co</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Ti</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Nb</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%V</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%W</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Sn</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%B</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>-</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>-</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Fe</b></td>
  		</tr>
		<tr bgcolor="#FFFFFF" align="center">
			<td style="line-height:150%;"><?php echo $cCo; ?></td>
			<td style="line-height:150%;"><?php echo $cTi; ?></td>
			<td style="line-height:150%;"><?php echo $cNb; ?></td>
			<td style="line-height:150%;"><?php echo $cV; ?></td>
			<td style="line-height:150%;"><?php echo $cW; ?></td>
			<td style="line-height:150%;"><?php echo $cSn; ?></td>
			<td style="line-height:150%;"><?php echo $cB; ?></td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;"><b>Resto</b></td>
		</tr>
	</table>

	<!-- O +- -->

	<?php
}

function tablaQuimicoCR($t){
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
			<td align="center" class="tResQ1">ID<br>ITEM</td>
			<td align="center" class="tResQ2-10"><b>%C</b></td>
			<td align="center" class="tResQ2-10"><b>%Si</b></td>
			<td align="center" class="tResQ2-10"><b>%Mn</b></td>
			<td align="center" class="tResQ2-10"><b>%P</b></td>
			<td align="center" class="tResQ2-10"><b>%S</b></td>
			<td align="center" class="tResQ2-10"><b>%Cr</b></td>
			<td align="center" class="tResQ2-10"><b>%Ni</b></td>
			<td align="center" class="tResQ2-10"><b>%Mo</b></td>
			<td align="center" class="tResQ2-10"><b>%Al</b></td>
			<td align="center" class="tResQ2-10"><b>%Cu</b></td>
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
		<tr style="line-height:150%;" align="center">
			<td height="28" align="center" bgcolor="#FFFFFF"><b><?php echo $t; ?></b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Co</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Ti</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Nb</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%V</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%W</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Sn</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%B</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>-</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>-</b></td>
			<td align="center" bgcolor="#E6E6E6"><b>%Fe</b></td>
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
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
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
	global $link;
			$cC  = '';
			$cSi = '';
			$cMn = '';
			$cP  = '';
			$cS  = '';
			$cCr = '';
			$cNi = '';
			$cMo = '';
			$cAl = '';
			$cCu = '';
			$cCo = '';
			$cTi = '';
			$cNb = '';
			$cV  = '';
			$cW  = '';
			$cPb = '';
			$cB  = '';
			$cSn = '';
			$cZn = '';
			$cAs = '';
			$cBi = '';
			$cTa = '';
			$cCa = '';
			$cCe = '';
			$cZr = '';
			$cLa = '';
			$cSe = '';
			$cN  = '';
			$cFe = '';
			$cMg = '';
			$cTe = '';
			$cCd = '';
			$cAg = '';
			$cAu = '';
			$cAi = '';
			$cSb = '';
		$bdRegQui=$link->query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysqli_fetch_array($bdRegQui)){
			$cC  = $rowRegQui['cC'];
			$cSi = $rowRegQui['cSi'];
			$cMn = $rowRegQui['cMn'];
			$cP  = $rowRegQui['cP'];
			$cS  = $rowRegQui['cS'];
			$cCr = $rowRegQui['cCr'];
			$cNi = $rowRegQui['cNi'];
			$cMo = $rowRegQui['cMo'];
			$cAl = $rowRegQui['cAl'];
			$cCu = $rowRegQui['cCu'];
			$cCo = $rowRegQui['cCo'];
			$cTi = $rowRegQui['cTi'];
			$cNb = $rowRegQui['cNb'];
			$cV  = $rowRegQui['cV'];
			$cW  = $rowRegQui['cW'];
			$cPb = $rowRegQui['cPb'];
			$cB  = $rowRegQui['cB'];
			$cSn = $rowRegQui['cSn'];
			$cZn = $rowRegQui['cZn'];
			$cAs = $rowRegQui['cAs'];
			$cBi = $rowRegQui['cBi'];
			$cTa = $rowRegQui['cTa'];
			$cCa = $rowRegQui['cCa'];
			$cCe = $rowRegQui['cCe'];
			$cZr = $rowRegQui['cZr'];
			$cLa = $rowRegQui['cLa'];
			$cSe = $rowRegQui['cSe'];
			$cN  = $rowRegQui['cN'];
			$cFe = $rowRegQui['cFe'];
			$cMg = $rowRegQui['cMg'];
			$cTe = $rowRegQui['cTe'];
			$cCd = $rowRegQui['cCd'];
			$cAg = $rowRegQui['cAg'];
			$cAu = $rowRegQui['cAu'];
			$cAi = $rowRegQui['cAi'];
			$cSb = $rowRegQui['cSb'];
		}
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
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
		  	<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;"><?php echo $cZn; ?></td>
			<td style="line-height:150%;"><?php echo $cPb; ?></td>
			<td style="line-height:150%;"><?php echo $cSn; ?></td>
			<td style="line-height:150%;"><?php echo $cP; ?></td>
			<td style="line-height:150%;"><?php echo $cMn; ?></td>
			<td style="line-height:150%;"><?php echo $cFe; ?></td>
			<td style="line-height:150%;"><?php echo $cNi; ?></td>
			<td style="line-height:150%;"><?php echo $cSi; ?></td>
			<td style="line-height:150%;"><?php echo $cMg; ?></td>
			<td style="line-height:150%;"><?php echo $cCr; ?></td>
  		</tr>
		<tr align="center">
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
			<td style="line-height:150%;" align="center"><strong><?php echo $t; ?></td>
			<td style="line-height:150%;"><?php echo $cTe; ?></td>
			<td style="line-height:150%;"><?php echo $cAs; ?></td>
			<td style="line-height:150%;"><?php echo $cSb; ?></td>
			<td style="line-height:150%;"><?php echo $cCd; ?></td>
			<td style="line-height:150%;"><?php echo $cBi; ?></td>
			<td style="line-height:150%;"><?php echo $cAg; ?></td>
			<td style="line-height:150%;"><?php echo $cCo; ?></td>
			<td style="line-height:150%;"><?php echo $cAi; ?></td>
			<td style="line-height:150%;"><?php echo $cS; ?></td>
			<td style="line-height:150%;"><?php echo $cZr; ?></td>
		</tr>
		<tr align="center">
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
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;"><?php echo $cAu; ?></td>
			<td style="line-height:150%;"><?php echo $cB; ?></td>
			<td style="line-height:150%;"><?php echo $cTi; ?></td>
			<td style="line-height:150%;"><?php echo $cSe; ?></td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;"><?php echo $cCu; ?></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoCo(){
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
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
	global $link;
			$cC  = '';
			$cSi = '';
			$cMn = '';
			$cP  = '';
			$cS  = '';
			$cCr = '';
			$cNi = '';
			$cMo = '';
			$cAl = '';
			$cCu = '';
			$cCo = '';
			$cTi = '';
			$cNb = '';
			$cV  = '';
			$cW  = '';
			$cPb = '';
			$cB  = '';
			$cSn = '';
			$cZn = '';
			$cAs = '';
			$cBi = '';
			$cTa = '';
			$cCa = '';
			$cCe = '';
			$cZr = '';
			$cLa = '';
			$cSe = '';
			$cN  = '';
			$cFe = '';
			$cMg = '';
			$cTe = '';
			$cCd = '';
			$cAg = '';
			$cAu = '';
			$cAi = '';
			$cSb = '';
		$bdRegQui=$link->query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysqli_fetch_array($bdRegQui)){
			$cC  = $rowRegQui['cC'];
			$cSi = $rowRegQui['cSi'];
			$cMn = $rowRegQui['cMn'];
			$cP  = $rowRegQui['cP'];
			$cS  = $rowRegQui['cS'];
			$cCr = $rowRegQui['cCr'];
			$cNi = $rowRegQui['cNi'];
			$cMo = $rowRegQui['cMo'];
			$cAl = $rowRegQui['cAl'];
			$cCu = $rowRegQui['cCu'];
			$cCo = $rowRegQui['cCo'];
			$cTi = $rowRegQui['cTi'];
			$cNb = $rowRegQui['cNb'];
			$cV  = $rowRegQui['cV'];
			$cW  = $rowRegQui['cW'];
			$cPb = $rowRegQui['cPb'];
			$cB  = $rowRegQui['cB'];
			$cSn = $rowRegQui['cSn'];
			$cZn = $rowRegQui['cZn'];
			$cAs = $rowRegQui['cAs'];
			$cBi = $rowRegQui['cBi'];
			$cTa = $rowRegQui['cTa'];
			$cCa = $rowRegQui['cCa'];
			$cCe = $rowRegQui['cCe'];
			$cZr = $rowRegQui['cZr'];
			$cLa = $rowRegQui['cLa'];
			$cSe = $rowRegQui['cSe'];
			$cN  = $rowRegQui['cN'];
			$cFe = $rowRegQui['cFe'];
			$cMg = $rowRegQui['cMg'];
			$cTe = $rowRegQui['cTe'];
			$cCd = $rowRegQui['cCd'];
			$cAg = $rowRegQui['cAg'];
			$cAu = $rowRegQui['cAu'];
			$cAi = $rowRegQui['cAi'];
			$cSb = $rowRegQui['cSb'];
		}
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
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
		  	<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;"><?php echo $cSi; ?></td>
			<td style="line-height:150%;"><?php echo $cFe; ?></td>
			<td style="line-height:150%;"><?php echo $cCu; ?></td>
			<td style="line-height:150%;"><?php echo $cMn; ?></td>
			<td style="line-height:150%;"><?php echo $cMg; ?></td>
			<td style="line-height:150%;"><?php echo $cCr; ?></td>
			<td style="line-height:150%;"><?php echo $cNi; ?></td>
			<td style="line-height:150%;"><?php echo $cZn; ?></td>
			<td style="line-height:150%;"><?php echo $cTi; ?></td>
			<td style="line-height:150%;"><?php echo $cPb; ?></td>
  		</tr>
		<tr align="center">
			<td height="28" align="center" bgcolor="#FFFFFF"><b><?php echo $t; ?></b></td>
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
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;"><?php echo $cSn; ?></td>
			<td style="line-height:150%;"><?php echo $cBi; ?></td>
			<td style="line-height:150%;"><?php echo $cZr; ?></td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;">&nbsp;</td>
			<td style="line-height:150%;"><?php echo $cAl; ?></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoAl(){
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
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

/* Doblado */
function encabezadoDoblado( $tm ){?>
		<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
			<tr bgcolor="#E6E6E6" align="center">
				<td align="center" class="tResQ1">ID<br>ITEM</td>
				<td align="center">
					Tipo
				</td>
				<td align="center">
					Observaciones
				</td>
				<td align="center">
					Condici&oacute;n
				</td>
			</tr>
		</table>
	<?php
}

function datosDoblado( $c, $t, $tm){
	global $link;
	$bdRegDob=$link->query("SELECT * FROM regdobladosreal Where CodInforme = '".$c."' and idItem = '".$t."'");
	if($rowRegDob=mysqli_fetch_array($bdRegDob)){?>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td style="line-height:150%;" align="center"><b><?php echo $t; ?></b></td>
			<td class="tResT2-6">
				<?php
					if($rowRegDob['Tipo'] == 'C') { echo 'Cara'; }
					if($rowRegDob['Tipo'] == 'R') { echo 'Ra&iacute;z'; }
					if($rowRegDob['Tipo'] == 'L') { echo 'Lado'; }
				?>
			</td>
			<td class="tResT2-6"><?php echo $rowRegDob['Observaciones']; ?></td>
			<td class="tResT2-6">
				<?php 
					if($rowRegDob['Condicion'] == 'Si') { echo 'Cumple'; }
					if($rowRegDob['Condicion'] == 'No') { echo 'No Cumple'; }
				?>
			</td>
		</tr>
		<?php
	}
}

/* Traccion Nueva */
function encabezadoTraccion( $tm ){
	if($tm == 'Pl'){?>
		<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
			<tr bgcolor="#E6E6E6" align="center">
				<td align="center" class="tResQ1">ID<br>ITEM</td>
				<td align="center">
					&Aacute;rea<br>Inicial<br> (mm<sup>2</sup>)
				</td>
				<td align="center">
					Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
				</td>
				<td align="center">
					Carga<br>M&aacute;xima<br>(Kgf)
				</td>
				<td align="center">
					Tensi&oacute;n de<br>Fluencia<br>0,2% Def,<br> (MPa)
				</td>
				<td align="center">
					Tensi&oacute;n<br>M&aacute;xima<br>(MPa)			
				</td>
				<td align="center">
					Alarg,<br>Sobre 50<br>mm<br>(%)
				</td>
			</tr>
	<?php }else{ ?>
		<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
			<tr bgcolor="#E6E6E6" align="center">
				<td align="center" class="tResQ1">ID<br>ITEM</td>
				<td align="center">
					&Aacute;rea<br>Inicial<br> (mm<sup>2</sup>)
				</td>
				<td align="center">
					Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
				</td>
				<td align="center">
					Carga<br>M&aacute;xima<br>(Kgf)
				</td>
				<td align="center">
					Tensi&oacute;n de<br>Fluencia<br>0,2% Def,<br> (MPa)
				</td>
				<td align="center">
					Tensi&oacute;n<br>M&aacute;xima<br>(MPa)			
				</td>
				<td align="center">
					Alarg,<br>Sobre 50<br>mm<br>(%)
				</td>
				<td align="center">
					Red.<br>de &Aacute;rea<br> (%)
				</td>
			</tr>
	<?php
	}
}

function datosTraccion( $c, $t, $tm){
	global $link;
	if($tm == 'Pl'){
		$aIni = '';
		$cFlu = '';
		$cMax = '';
		$tFlu = '';
		$tMax = '';
		$aSob = '';
		$rAre = '';
		//$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		//$link=Conectarse();
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra['aIni'];
			$cFlu = $rowRegTra['cFlu'];
			$cMax = $rowRegTra['cMax'];
			$tFlu = $rowRegTra['tFlu'];
			$tMax = $rowRegTra['tMax'];
			$aSob = $rowRegTra['aSob'];
			$rAre = $rowRegTra['rAre'];
		}
		//$link->close();
		?>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td style="line-height:150%;" align="center"><b><?php echo $t; ?></b></td>
			<td class="tResT2-6"><?php echo $aIni; ?></td>
			<td class="tResT2-6"><?php echo $cFlu; ?></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($cMax), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($tFlu), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($tMax), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($aSob), 0, ',', '.'); 	?></b></td>
		</tr>
	<?php
	}else{
		$aIni = '';
		$cFlu = '';
		$cMax = '';
		$tFlu = '';
		$tMax = '';
		$aSob = '';
		$rAre = '';
		
		//$link=Conectarse();
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra['aIni'];
			$cFlu = $rowRegTra['cFlu'];
			$cMax = $rowRegTra['cMax'];
			$tFlu = $rowRegTra['tFlu'];
			$tMax = $rowRegTra['tMax'];
			$aSob = $rowRegTra['aSob'];
			$rAre = $rowRegTra['rAre'];
		}
		//$link->close();
		?>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td style="line-height:150%;" align="center"><b><?php echo $t; ?></b></td>
			<td class="tResT2-6"><?php echo $aIni; ?></td>
			<td class="tResT2-6"><?php echo $cFlu; ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($cMax), 0, ',', '.'); ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($tFlu), 0, ',', '.'); ?></td>
			<td class="tResT2-6"><?php echo $tMax; ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($aSob), 0, ',', '.'); ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($rAre), 0, ',', '.'); ?></td>
  		</tr>
		<?php
	}
}

function imprimeTablaReferencia( $tm ){
	if($tm == 'Pl'){
		?>
			<tr bgcolor="#FFFFFF">
				<td style="line-height:150%; width:18em;" colspan="4" align="center"><b>Referencia</b></td>
				<td align="center" class="tResT2-6">0</td>
				<td align="center" class="tResT2-6">0</td>
				<td align="center" class="tResT2-6">0</td>
			</tr>
		<?php
	
	}else{
		?>
			<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
				<td style="line-height:150%;" width="39%" colspan="4" align="center"><strong>Referencia</strong></td>
				<td width="8%" align="center">&nbsp;</td>
				<td width="8%" align="center">&nbsp;</td>
				<td width="8%" align="center">&nbsp;</td>
				<td width="8%" align="center">&nbsp;</td>
			</tr>
		<?php
	}
}
/* Traccion Nueva */
function encabezadoDureza($tm, $n){
	global $link;
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
		  	<td width="15%" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n; ?>" align="center">
				Dureza <br>
				<?php
					$bdtMu=$link->query("SELECT * FROM amTpsMuestras Where idEnsayo = 'Du' and tpMuestra = '".$tm."'");
					if($rowtMu=mysqli_fetch_array($bdtMu)){
						echo $rowtMu['tipoEnsayo'];
					}
				?>
			</td>
  		    <td height="41" align="center"><b>Promedio</b></td>
		</tr>
	<?php
}
function datosDureza($c, $n, $t, $tm, $m){
	global $link;
	?>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td class="tResT2-6" align="center"><b><?php echo $t; ?></b></td>
			<?php
				$sDoblado 	= 0;
				$Media 		= 0;
				$cIndenta	= 0;
				$vIndenta	= 0;
				for($i=1; $i<=$m; $i++){
					$bdRegDob=$link->query("SELECT * FROM regDoblado Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$tm."' and nIndenta = '".$i."'");
					if($rowRegDob=mysqli_fetch_array($bdRegDob)){
						$vIndenta = $rowRegDob['vIndenta'];
						$cIndenta = $rowRegDob['cIndenta'];
						if($cIndenta > 0){
							$sDoblado += $cIndenta;
							$Media = $sDoblado / $n;
							echo '<td width="8%" class="tResT2-6" align="center">'.number_format($cIndenta, 1, ',', '.').'</td>';
						}else{
							$sDoblado += $vIndenta;
							$Media = $sDoblado / $n;
							echo '<td width="8%" class="tResT2-6" align="center">'.number_format($vIndenta, 1, ',', '.').'</td>';
						}
					}else{
						echo '<td width="8%" class="tResT2-6" align="center"> - </td>';
					}
				}
			?>
			<td width="8%" class="tResT2-6" ><b><?php echo number_format($Media, 1, '.', ','); ?></b></td>
		</tr>
	<?php
}
function imprimeTablaReferenciaDureza($c, $n){
	$n++;
	?>
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td align="center" colspan="<?php echo $n; ?>"><strong>Referencia seg&uacute;n especificaci&oacute;n del cliente</strong></td>
			<td align="center">&nbsp;</td>
  		</tr>
	<?php 
}
/* Fin Duereza Nueva */
function encabezadoCharpy($tm, $nImpactos, $Tem){?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
		  	<td width="15%" rowspan="2" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $nImpactos+1; ?>" align="center">
		   		Energ&iacute;a de impacto a T&deg; <?php echo $Tem; ?><br>
				(Joule)
			</td>
  		</tr>
		<tr bgcolor="#E6E6E6" align="center">
			<?php for($i=1; $i<=$nImpactos ; $i++){ ?>
				<td align="center" width="8%">
					Muestra<br> N&deg; <?php echo $i; ?>
				</td>
			<?php } ?>
			<td align="center" width="8%">
				<b>Promedio</b>
			</td>
		</tr>
		
		<?php
}

function datosCharpy($c, $n, $t, $m){
		global $link;
		?>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td style="line-height:150%;" align="center"><b><?php echo $t; ?></b></td>
			<?php
				$sImpactos 	= 0;
				$Media 		= 0;
				for($i=1; $i<=$n; $i++){
					$bdRegCh=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."' and nImpacto = '".$i."'");
					if($rowRegCh=mysqli_fetch_array($bdRegCh)){
						$vImpacto = $rowRegCh['vImpacto'];
					}
					$sImpactos += $vImpacto;
					$Media = $sImpactos / $n;
					echo '<td style="line-height:150%;">'.number_format($vImpacto, 1, ',', '.').'</td>';
				}
			?>
			<td><b><?php echo number_format($Media, 1, ',', '.'); ?></b></td>
		</tr>
		<?php
}
function imprimeTablaReferenciaCharpy($tm, $n){?>
	<?php $n++; ?>
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td style="line-height:150%;" align="center" colspan="<?php echo $n; ?>"><strong>Referencia seg&uacute;n especificaci&oacute;n del cliente</strong></td>
			<td style="line-height:150%;" align="center">0</td>
  		</tr>
		<?php
}

function tablaCharpy($c, $t, $m, $n, $tem){
	global $link;
	if($tem == 0 or $tem == ''){
		$tem = 'ambiente';
	}
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
		  	<td width="15%" rowspan="2" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n+1; ?>" align="center">
		   		Energ&iacute;a de impacto a T&deg; <?php echo $tem; ?><br>
				(Joule)
			</td>
  		</tr>
		<tr bgcolor="#E6E6E6" align="center">
			<?php for($i=1; $i<=$n ; $i++){ ?>
				<td align="center" width="8%">
					Muestra<br> N&deg; <?php echo $i; ?>
				</td>
			<?php } ?>
			<td align="center" width="8%">
				<b>Promedio</b>
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td style="line-height:150%;" align="center"><b><?php echo $t; ?></b></td>
			<?php
				$sImpactos 	= 0;
				$Media 		= 0;
				for($i=1; $i<=$n; $i++){
					$bdRegCh=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."' and nImpacto = '".$i."'");
					if($rowRegCh=mysqli_fetch_array($bdRegCh)){
						$vImpacto = $rowRegCh['vImpacto'];
					}
					$sImpactos += $vImpacto;
					$Media = $sImpactos / $n;
					echo '<td>'.number_format($vImpacto, 1, ',', '.').'</td>';
				}
			?>
			<td style="line-height:150%;"><b><?php echo number_format($Media, 1, ',', '.'); ?></b></td>
		</tr>
	</table>
	<?php
}
function RefTablaCharpy($c, $t, $m, $n, $tem){
	$por = $n * 8;
	$por = $por + 15;
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td align="center" width="85%" colspan="<?php echo $n; ?>"><strong>Referencia seg&uacute;n especificaci&oacute;n del cliente</strong></td>
			<td align="center" width="15%">0</td>
  		</tr>
	</table>
	<?php 
}

/* Antigua Dureza */
function RefTablaDureza($c, $t, $m, $n){
	$por = $n * 8;
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td style="line-height:150%;" align="center" width="85%" colspan="<?php echo $n; ?>"><strong>Referencia seg&uacute;n especificaci&oacute;n del cliente</strong></td>
			<td style="line-height:150%;" align="center" width="15%">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaDureza($c, $t, $m, $n){
	global $link;
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
		  	<td width="15%" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n; ?>" align="center">
				Dureza <br>
				<?php
					$bdtMu=$link->query("SELECT * FROM amTpsMuestras Where idEnsayo = 'Du' and tpMuestra = '".$m."'");
					if($rowtMu=mysqli_fetch_array($bdtMu)){
						echo $rowtMu['tipoEnsayo'];
					}
				?>
				
				<?php 
/*				
					if( strtoupper(substr($m,2,1)) ){?>
						Rockwell <?php echo strtoupper(substr($m,2,1)); ?>
					<?php }else{ ?>
						Brinell
					<?php } 
*/
					?>
			</td>
  		    <td height="41" align="center"><b>Promedio</b></td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td class="tResT2-6" align="center"><b><?php echo $t; ?></b></td>
			<?php
				$sDoblado 	= 0;
				$Media 		= 0;
				for($i=1; $i<=$n; $i++){
					$bdRegDob=$link->query("SELECT * FROM regDoblado Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."' and nIndenta = '".$i."'");
					if($rowRegDob=mysqli_fetch_array($bdRegDob)){
						$vIndenta = $rowRegDob['vIndenta'];
					}
					$sDoblado += $vIndenta;
					$Media = $sDoblado / $n;
					echo '<td width="8%" class="tResT2-6">'.number_format($vIndenta, 1, ',', '.').'</td>';
				}
			?>
			<td width="8%" class="tResT2-6" ><b><?php echo number_format($Media, 1, '.', ','); ?></b></td>
		</tr>
	</table>
	<?php
}
/* Antigua Dureza */

function tablaOtra($c, $t, $m){
	?></b>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
		  	<td width="15%" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" align="center">
				Otra
			</td>
		</tr>
	</table>
	<?php
}


/* Antigua Traccion */
function tablaTraccionRe($c, $t, $m, $nro){
	global $link;

		$aIni = '';
		$cFlu = '';
		$cMax = '';
		$tFlu = '';
		$tMax = '';
		$aSob = '';
		$rAre = '';
		
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra['aIni'];
			$cFlu = $rowRegTra['cFlu'];
			$cMax = $rowRegTra['cMax'];
			$tFlu = $rowRegTra['tFlu'];
			$tMax = $rowRegTra['tMax'];
			$aSob = $rowRegTra['aSob'];
			$rAre = $rowRegTra['rAre'];
		}
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
			<td align="center" class="tResQ1">ID<br>ITEM</td>
			<td align="center">
				&Aacute;rea<br>Inicial<br> (mm<sup>2</sup>)
			</td>
			<td align="center">
				Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
			</td>
			<td align="center">
				Carga<br>M&Aacute;xima<br>(Kgf)
			</td>
			<td align="center">
				Tensi&oacute;n de<br>Fluencia<br>0,2% Def,<br> (MPa)
			</td>
			<td align="center">
				Tensi&oacute;n<br>M&Aacute;xima<br>(MPa)			
			</td>
			<td align="center">
				Alarg,<br>Sobre 50<br>mm<br>(%)
			</td>
			<td align="center">
				Red.<br>de &Aacute;rea<br> (%)
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><b><?php echo $t; ?></b></td>
			<td class="tResT2-6"><?php echo $aIni; ?></td>
			<td class="tResT2-6"><?php echo $cFlu; ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($cMax), 0, ',', '.'); ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($tFlu), 0, ',', '.'); ?></td>
			<td class="tResT2-6"><?php echo $tMax; ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($aSob), 0, ',', '.'); ?></td>
			<td class="tResT2-6"><?php echo number_format(intval($rAre), 0, ',', '.'); ?></td>
  		</tr>
	</table>
	<?php
}

function RefTablaTraccionRe($c, $t, $m){
	global $link;
		$aIni = '';
		$cFlu = '';
		$cMax = '';
		$tFlu = '';
		$tMax = '';
		$aSob = '';
		$rAre = '';

		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra['aIni'];
			$cFlu = $rowRegTra['cFlu'];
			$cMax = $rowRegTra['cMax'];
			$tFlu = $rowRegTra['tFlu'];
			$tMax = $rowRegTra['tMax'];
			$aSob = $rowRegTra['aSob'];
			$rAre = $rowRegTra['rAre'];
		}
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
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

function tablaTraccionPlOLd($c, $t, $m){
	global $link;
		$aIni = '';
		$cFlu = '';
		$cMax = '';
		$tFlu = '';
		$tMax = '';
		$aSob = '';
		$rAre = '';
		//$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra['aIni'];
			$cFlu = $rowRegTra['cFlu'];
			$cMax = $rowRegTra['cMax'];
			$tFlu = $rowRegTra['tFlu'];
			$tMax = $rowRegTra['tMax'];
			$aSob = $rowRegTra['aSob'];
			$rAre = $rowRegTra['rAre'];
		}
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
			<td align="center" class="tResQ1">ID<br>ITEM</td>
			<td align="center">
				&Aacute;rea<br>Inicial<br> (mm<sup>2</sub>)
			</td>
			<td align="center">
				Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
			</td>
			<td align="center">
				Carga<br>M&Aacute;xima<br>(Kgf)
			</td>
			<td align="center">
				Tensi&oacute;n de<br>Fluencia<br>0,2% Def,<br> (MPa)
			</td>
			<td align="center">
				Tensi&oacute;n<br>M&Aacute;xima<br>(MPa)			
			</td>
			<td align="center">
				Alarg,<br>Sobre 50<br>mm<br>(%)
			</td>
		</tr>
		
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><b><?php echo $t; ?></b></td>
			<td class="tResT2-6"><?php echo $aIni; ?></td>
			<td class="tResT2-6"><?php echo $cFlu; ?></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($cMax), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($tFlu), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($tMax), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($aSob), 0, ',', '.'); 	?></b></td>
		</tr>
	</table>
	<?php
}

function tablaTraccionPl($c, $t, $m){
	global $link;
		$aIni = '';
		$cFlu = '';
		$cMax = '';
		$tFlu = '';
		$tMax = '';
		$aSob = '';
		$rAre = '';
		//$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra['aIni'];
			$cFlu = $rowRegTra['cFlu'];
			$cMax = $rowRegTra['cMax'];
			$tFlu = $rowRegTra['tFlu'];
			$tMax = $rowRegTra['tMax'];
			$aSob = $rowRegTra['aSob'];
			$rAre = $rowRegTra['rAre'];
		}
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#E6E6E6" align="center">
			<td align="center" class="tResQ1">ID<br>ITEM</td>
			<td align="center">
				&Aacute;rea<br>Inicial<br> (mm<sup>2</sub>)
			</td>
			<td align="center">
				Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
			</td>
			<td align="center">
				Carga<br>M&iacute;xima<br>(Kgf)
			</td>
			<td align="center">
				Tensi&oacute;n de<br>Fluencia<br>0,2% Def,<br> (MPa)
			</td>
			<td align="center">
				Tensi&oacute;n<br>M&Aacute;xima<br>(MPa)			
			</td>
			<td align="center">
				Alarg,<br>Sobre 50<br>mm<br>(%)
			</td>
		</tr>
		
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><b><?php echo $t; ?></b></td>
			<td class="tResT2-6"><?php echo $aIni; ?></td>
			<td class="tResT2-6"><?php echo $cFlu; ?></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($cMax), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($tFlu), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($tMax), 0, ',', '.'); 	?></b></td>
			<td class="tResT2-6"><b><?php echo number_format(intval($aSob), 0, ',', '.'); 	?></b></td>
		</tr>
	</table>
	<?php
}


function RefTablaTraccionPl(){
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
		<tr bgcolor="#FFFFFF">
		  	<td colspan="4" align="center" style="width:18em;"><b>Referencia</b></td>
			<td align="center" class="tResT2-6">0</td>
			<td align="center" class="tResT2-6">0</td>
			<td align="center" class="tResT2-6">0</td>
  		</tr>
	</table>
	<?php 
}
/* Antigua Traccion */

?>
